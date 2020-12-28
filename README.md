<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
## API Rest para Teste na Helpay

### Descricao
Este projeto foi desenvolvido utilizando o framework Laravel, faz parte do teste de admissão na empresa Helpay.

### Tecnologias
- php >= 7.3
- composer
- docker e docker-compose

## Configurando projeto
Primeiramente certifique-se de ter as dependências instaladas. clone o projeto na sua máquina.

```
$ https://github.com/hitallow/helpay-api-test.git
```

Após clonar, instale as dependências do projeto laravel

```
$ composer install
```

### Configurações do .env
Após as duas etapas, sete as variaveis ambiente tomando como base o arquivo no root chamado de `.env.example`, neste arquivo altere as informacoes de email e suas credenciais para conectar a API do google drive.

```
  # configuracoes de conexao
  GOOGLE_API_KEY=CHAVE DA API
  GOOGLE_APP_ID=IDENTIFICADOR DO APP
  GOOGLE_CLIENT_ID=IDENTIFICADOR DA API
  GOOGLE_CLIENT_SECRET=CHAVE SECRETA DE ACESSO
  GOOGLE_DRIVE_FOLDER_ID= DIRETÓRIO ONDE OS XMLS DEVEM SER SALVOS
  GOOGLE_DRIVE_REFRESH_TOKEN=TOKEN INICIAL DE ACESSO

  # configuracoes do email

  MAIL_MAILER=smtp
  MAIL_HOST=smtp.gmail.com
  MAIL_PORT=587
  MAIL_ENCRYPTION=tls
  MAIL_TO=ENDERECO QUE RECEBERA OS EMAIL
  MAIL_USERNAME=EMAIL DO REMETENTE
  MAIL_FROM_ADDRESS=EMAIL DO REMETENTE
  MAIL_PASSWORD=SUA SENHA DE ACESSO
```

Por padrão, o projeto vem pronto para trabalhar com  o **Gmail**.
Crie a API do google drive seguinto o  passo a passo descrito na página da [Google Drive API](https://developers.google.com/drive), caso seja nescessário contate-me via email para utilizar as credenciais usadas por mim.
Há um passo a passo listado [aqui](https://developers.google.com/identity/protocols/oauth2)

### Executando o  projeto
É possível executar o projeto facilmente utilizando o *Docker*, dentro da pasta raiz do projeto execute:
```
$ docker-compose build && docker-compose up -d
```
Os containers iram iniciar no modo daemon, execute:
```
$ docker container ps --format ‘{{.Names}}’ 
```
A saída deve ser algo parecido como

```
  ... outros containers
  ‘app’
  ‘db’
  ‘webserver’
```

**Obs.** É possível que o projeto demore um pouco para iniciar.

### Iniciando tabelas do banco de dados

Após o container com nome `db` ser iniciado com sucesso (pode ser que demore um pouco) rode no seu terminal
```
$ docker exec -it app bash -c "php artisan key:generate && php artisan migrate"
```
Este comando irá deixar o projeto pronto para salvar as informações.

## Rotas

É possível encontrar a documentação das rotas e os devidos endpoints acessando [aqui](https://documenter.getpostman.com/view/7451308/TVsydQRg)

| Metodo | URL                                        | Descrição                                                           |
| ------ | ------------------------------------------ | ------------------------------------------------------------------- |
| POST   | localhost:8000/api/products                | Insere um novo produto                                              |
| GET    | localhost:8000/api/products                | Lista todos os produtos                                             |
| GET    | localhost:8000/api/products/{{id_produto}} | Lista produto com id repassado                                      |
| DELETE | localhost:8000/api/products/{{id_produto}} | Exclui(soft delete) produto com id repassado                        |
| POST   | localhost:8000/api/purchase                | Realiza uma compra, envia o email e salva o arquivo no google drive |
### Testes

É possivel rodar restes utilizando
```
  $ php artisan test
```

## O que não consegui fazer
Como utilizei a api do google drive como um filesystem, não consegui recuperar a url do arquivo salvo, logo não foi possível incluir essa informação no email.

## Vulnerabilidades de Segurança

Se você descobrir uma vulnerabilidade de segurança no Laravel, envie um e-mail para Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). Todas as vulnerabilidades de segurança serão resolvidas imediatamente.

## Licensa

O framework Laravel é um software de código aberto licenciado sob a [MIT license](https://opensource.org/licenses/MIT).
