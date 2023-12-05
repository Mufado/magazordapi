# MagazordAPI - CRUD MVC utilizando PHP e Docker

## Instalação do projeto:

1. Cerrificar-se de ter instalado em sua máquina os seguintes componentes:

   - [Git](https://git-scm.com/download/win)
   - [Docker](https://www.docker.com/get-started/)
   - [Docker Compose](https://docs.docker.com/compose/install/)
     - Vale ressaltar que o Docker Compose já vem com o Docker Desktop, mas vale ressaltar a necessidade para o caso de você tentar rodar a aplicação usando Docker Engine.

2. Clonar o repositório no local que você preferir

3. Executar o arquivo init.sh

4. Ser feliz! (E abrir a página localhost no seu browser...)

## Padrões utilizados:

- Singleton foi utilizado para instanciar a base de dados. Na classe contexto do sistema, eu utilizei não uma instância de si mesma, mas de uma conexão com o banco de dados. A classe Singleton em si nunca foi instanciada. Dessa forma, fiz com que o código utilize essa consulta para qualquer operação com o banco de dados. Apesar de não ser ativamente útil nesse projeto, pois mesmo sem ele o projeto funcionaria, decidi utilizar o Singleton por boa prática. Já que não preciso de várias conexões, me privei a somente uma.

- Usei o Front Controller para rotear todas as conexões entre os métodos das controllers. Toda vez que uma requisição chega no arquivo `index.php`, ela é tratada por uma instância da classe roteadora. A classe de roteamento em si encontra a controller e o método a serem executados, que são executados de forma dinâmica. Esse padrão foi extremamente útil, pois foi exatamente ele que fez tudo se ligar no projeto.

- Esse último é mais um adicional. Na classe `Renderer.php`, criei um sistema de renderização dinâmica de views. Ele possui uma função estática que é chamada pelas controllers, e, por meio de parâmetro, essa função encontra todos os arquivos front-end, relacionados a esse nome. Por exemplo, quando o método é chamado com o parâmetro `index`, ele encontra os arquivos `index.html`, `index.css` e `index.js` relacionados a tela, renderizando todos logo depois.

# Refatoração Login.php:

### As principais alterações foram os desacoplamentos no método doLogin. Tirando isso, as alterações notáveis foram:

- Visto que o arquivo representa uma controller chamada Login, o nome do mesmo foi alterado para LoginController para deixar mais claro a funcionalidade do arquivo diretamente pelo nome, além de seguir o padrão MVC.
- Nomes de variáveis e de outros objetos alterados para seguirem em inglês, pois essa é a linguagem padrão utilizada na maioria dos códigos no mundo inteiro, e seguir seu uso é ideal por vários motivos, como facilitar a inclusão de desenvolvedores de qualquer local do mundo para a empresa.
  - Essas alterações também incluem o significado do nome de cada variável, a fim de tornar mais óbvio para qualquer um que ler o código para que serve cada variável.
- Comentários ajustados, visando melhor explicação do código.

> Há diversos comentários escritos com meu nome pelo código que podem ser importantes para o entendimento das alterações.
