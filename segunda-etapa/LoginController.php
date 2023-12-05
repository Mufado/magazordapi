<?php
class LoginController {

    public function doLogin($email, $password, $type, $shop = null, $social = false, $rememberUserLogin = false, $registerSession = true, $code2FA = null, $remoteAddr = null, $userAgent = null, $authToken = null, $newPassword = null)
    {
        # [GUSTAVO]: Realizando verificações de exceção primeiro.
        #            Isso pode evitar diversos usos de if e else desnecessário e
        #            , mais immportante, código rodando desnecessariamente.

        if (empty($email) or (empty($password) and !$social)) {
            throw new LoginException('Usuário e senha são obrigatórios!');
        }

        $user = null;
        $validPassword = false;

        $remoteAddr = $remoteAddr ? $remoteAddr : $this->getRequest()->getRemoteAddr();

        $userAgent = $userAgent ? $userAgent : $this->getRequest()->getUserAgent();
        

        if ($type == User::WEBSERVICE_TYPE) {
            // Login como cliente
            
            # [GUSTAVO]: Desacoplando código para facilitar legibilidade

            $httpAuth = new Http\BasicHttpAuthentication();
            
            $httpAuth->setFunctionValidateUser(function($token, $password) use (&$user, &$validPassword, &$email) {
                return $this->validateUser($token, $password, $user, $validPassword, $email);
            });
                
            $httpAuth->auth();
        } else {
            // Login como administrador.

            # [GUSTAVO]: Desacoplando código para facilitar legibilidade

            $this->loginAdministrator($user, $type, $email, $password, $remoteAddr, $authToken, $userAgent, $shop, $code2FA, $newPassword, $social);
        }

        return $this->handleResult($remoteAddr, $email, $type, $user, $validPassword, $registerSession, $userAgent, $rememberUserLogin);
    }

    private function loginAdministrator($user, $type, $email, $password, $remoteAddr, $authToken, $userAgent, $shop, $code2FA, $newPassword, $social) {
        // Verifica se o e-mail é controlado pela central e, se for, 
        // valida se o usuário existe na central pelo login
        if ($type == User::ADMINISTRATIVE_TYPE and CentralControlController::isEmailControledByCentral($email)) {

            # [GUSTAVO]: Não chamar outras controllers via instância.
            #            Isso fere boas práticas do MVX, pode levar à falta de performance,
            #            etc. Preferencialmente utilizar-se de requisições.
            #
            #   $centralControl = new CentralControlController();

            $user = $this->getUserFromCentralControl($email, $password, $remoteAddr);

            if ($user !== null) {
                $validPassword = true;
            }
            
            # [GUSTAVO]: Não é necessário lançar exceção se não houver um tratamento.
            #            Isso interfere na pilha de exceções, além de poluir o código.
            #
            # } catch (\Exception $exc) {
            #     throw $exc;
            # }
        }

        # [GUSTAVO]: Removendo validação, visto que não havia fluxos 
        #            em que a variável $user recebia valor antes de chegar aqui.
        #
        #   if ($user === null)
        
        // Se fornecido token, valida o mesmo e recebe o usuário
        if ($authToken) {
            $user = $this->validateAuthToken($authToken, $userAgent); 
        } else {
            $user = $this->getUserRepository()->getUserByLogin($email, $type, $shop);
        }

        if ($user !== null) {
            if ($social) {
                $validPassword = true;
            } else {
                //se estamos aqui e ainda é master esta errado deveria ter acessado pelo controler-central
                if ($user->getTipo() == User::MASTER_ADMINISTRATIVE_TYPE) {
                    $user->setTipo(User::ADMINISTRATIVE_TYPE);
                    $this->getEntityManager()->persist($user);
                    $this->getEntityManager()->flush($user);
                }
                $validPassword = $user->validatePassword($password);

                //acesso com senha gerada somente para o site
                if (!$validPassword && $type == User::ECOMMERCE_TYPE) {
                    //vamos validar a senha do administrador para acesso dos atendentes na conta do cliente
                    if ($user->getPerson()->generateAccessPasswordForAdmin() == $password) {
                        $validPassword = true;
                    }
                }
            }
        }

        # [GUSTAVO]: Refazendo essa condicional. Apesar de a variável $user estar sendo usada,
        #            ainda há abertura para ela chegar nula nesse local.
        #
        # if ($validPassword && $user->getAuth2FAType() !== User::OUTRANGE_2FA_TYPE && !$user->validateHost($remoteAddr))

        //se a senha é valida vamos verificar se existe restrição de hosts para este usuário
        if ($validPassword && $user->getAuth2FAType() !== User::OUTRANGE_2FA_TYPE && !$user->validateHost($remoteAddr)) {
            $authenticationErrorMsg = 'Você não possui privilégio para acessar o sistema deste local ' . $remoteAddr . '!';

            throw new LoginException($authenticationErrorMsg, LoginException::CODE_FORBIDDEN);
        }

        if ($validPassword && $user) {
            $this->handleValidAdminUser($user, $newPassword, $code2FA, $remoteAddr, $password);
        }
    }

    public function handleValidAdminUser($user, $newPassword, $code2FA, $remoteAddr, $password) {
        if (
            !$this->getEngine()->isDev() &&
            $user->getSecret2FA() &&
            (
                $user->getAuth2FAType() == User::ALWAYS_2FA_TYPE ||
                $user->getAuth2FAType() == User::OUTRANGE_2FA_TYPE
            )
        ) {
            // Se o usuário informou uma nova senha não solicita o token novamente, se ele chegou nesta parte significa que já validou o token
            $check2FA = is_null($newPassword);

            // Somente exige o 2FA se autenticado fora do range de hosts do usuário
            if ($check2FA && !$code2FA && $user->getAuth2FAType() == User::OUTRANGE_2FA_TYPE) {
                $check2FA = !$user->validateHost($remoteAddr);
            }

            if ($check2FA && !$code2FA) {
                Model\Usuario2FAException::throw2FARequired();
            } else if ($check2FA) {
                $googleAuth = new \Google\Authenticator\GoogleAuthenticator();
                if (!$googleAuth->checkCode($user->getSecret2FA(), $code2FA)) {
                    Model\Usuario2FAException::throw2FAInvalidCode();
                }
            }
        }

        // Se os dados do usuário estão corretos mas a senha está expirada
        if ($user->getTipo() == User::ADMINISTRATIVE_TYPE && $user->getPasswordOptions()->getExpiredPassword()) {
            $this->manageExpiredPassword($user, $password, $newPassword);
        }
    }

    private function handleResult($remoteAddr, $email, $type, $user, $validPassword, $registerSession, $userAgent, $rememberUserLogin) {
        $log = new Model\Log\LogLogin();
        $log->setSuccess(false);
        $log->setIp($remoteAddr);
        $log->setLogin($email);
        $log->setTipo($type);

        if ($user === null || !$validPassword) {
            $log->setMenssage('Usuário ou senha informados inválidos!');
        } else if ($user->getSituacao() !== User::ACTIVE_SITUATION) {
            $log->setMessage($this->getLogMessage());
        } else {
            $this->handleSuccess($registerSession, $user, $log, $userAgent, $type, $rememberUserLogin);
        }

        if (!$log->getSuccess()) {
            throw new LoginException($log->getMessage());
        }
        
        // Insere o log no banco de dados 
        $this->getEntityManager()->getRepository(Model\Log\LogLogin::class)->insertSql($log);

        $this->getEntityManager()->flush();
        
        return $user;
    }

    private function handleSuccess($registerSession, $user, $log, $userAgent, $type, $rememberUserLogin) {
        if ($registerSession) {
            $this->getSession()->init();
            $this->getSession()->set('user', $user);
        } else {
            $this->getSession()->setRequest('user', $user);
        }

        $log->setUser($user);
        $log->setSuccess(true);

        if ($type == User::ECOMMERCE_TYPE) {
            $tokenRepository = $this->getEntityManager()->getRepository('Model\UserToken');
            $token = $tokenRepository->findOneBy(array('user' => $user, 'userAgent' => $userAgent));
            if (!$token) {
                $token = new Model\UserToken($user);
                $token->setUserAgent($userAgent);
            }
            if ($rememberUserLogin) {
                $token->setChangeDate(new \DateTime());
                $this->getSession()->setCookie('utoklog', $token->getHash(), strtotime('+30 days'), '/', null, null, true);
            } else {
                $this->getSession()->removeCookie('utoklog');
            }
            $this->getEntityManager()->persist($token);
            $this->getSession()->setCookie('utokcar', $token->getHash(), strtotime('+180 days'), '/', null, null, true);
            $user->setUserToken($token);
        }
    }

    private function getUserFromCentralControl($email, $password, $remoteAddr) {
        # [GUSTAVO]: Lógica da requisição aqui...
    }

    private function manageExpiredPassword(&$user, $password, $newPassword) {
        if (!is_null($newPassword)) {
            if ($newPassword == $password) {
                throw new LoginException('Nova senha não pode ser igual a senha antiga.', LoginException::CODE_PASSWORD_EXPIRED);
            } else {
                $user->setPasswordRegister($newPassword);
                $user->setPasswordChangeDate(new \DateTime());
                $user->getPasswordOptions()->setExpiredPassword(false);
                $this->getEntityManager()->persist($user);
            }
        } else {
            throw new LoginException('Senha expirada! É necessário gerar uma nova para poder utilizar o sistema.', LoginException::CODE_PASSWORD_EXPIRED);
        }
    }

    private function validateAuthToken($authToken, $userAgent) {
        $tokenRepository = $this->getEntityManager()->getRepository('Model\UsuarioToken');
        $authUserToken = $tokenRepository->findValidTokenByHash($authToken);
        
        // Caso o token não seja encontrado no repositório, ou seu usuário ou agente esteja inválido, lança exceção
        if (
            !$authUserToken ||
            !$authUserToken->getUsuario() ||
            $authUserToken->getUserAgent() !== $userAgent
        ) {
            throw new LoginException('Token de usuário inválido para acesso!');
        }

        return $authUserToken->getUsuario();
    }

    private function validateUser($token, $password, &$user, &$validPassword, &$email) {
        if (strlen($token) == 64) {
            $user = $this->getUserRepository()->getUserByToken($token, User::WEBSERVICE_TYPE);
            
            if ($user) {
                $email = $token;
                $validPassword = $user->validatePassword($password);

                return $validPassword;
            }
        }
        
        return false;
    }

    private function getLogMessage($user) {
        switch ($user->getSituacao()) {
            case User::PENDENT_SITUATION:
                return 'Seu cadastro está pendente de aprovação. Para maiores informações entre em contato com nossos atendentes.';
            case User::REJECTED_SITUATION:
                return 'Seu cadastro não foi aprovado. Para maiores informações entre em contato com nossos atendentes.';
            default:
                return 'Seu login e senha não conferem. Entre em contato com nossos atendentes.';
        }
    }
}