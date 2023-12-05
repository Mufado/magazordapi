# CRUD MVC MagazordAPI

## Instalação do projeto:

1. Cerrificar-se de ter instalado em sua máquina os seguintes componentes:

   - [Git](https://git-scm.com/download/win)
   - [Docker](https://www.docker.com/get-started/)
   - [Docker Compose](https://docs.docker.com/compose/install/)
     - Vale ressaltar que o Docker Compose já vem com o Docker Desktop, mas vale ressaltar a necessidade para o caso de você tentar rodar a aplicação usando Docker Engine.

2. Clonar o repositório no local que você preferir

3. Executar o arquivo init.sh

4. Ser feliz! (E abrir a página localhost no seu browser...)

# Refatoração Login.php:

### As principais alterações foram os desacoplamentos no método doLogin. Tirando isso, as alterações notáveis foram:

- Visto que o arquivo representa uma controller chamada Login, o nome do mesmo foi alterado para LoginController para deixar mais claro a funcionalidade do arquivo diretamente pelo nome, além de seguir o padrão MVC.
- Nomes de variáveis e de outros objetos alterados para seguirem em inglês, pois essa é a linguagem padrão utilizada na maioria dos códigos no mundo inteiro, e seguir seu uso é ideal por vários motivos, como facilitar a inclusão de desenvolvedores de qualquer local do mundo para a empresa.
  - Essas alterações também incluem o significado do nome de cada variável, a fim de tornar mais óbvio para qualquer um que ler o código para que serve cada variável.
- Comentários ajustados, visando melhor explicação do código.

> Há diversos comentários escritos com meu nome pelo código que podem ser importantes para o entendimento das alterações.
