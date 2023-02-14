# api-rest
api rest

para roda o projeto precisa do composer instalado , rodar o comando composer install.
Foi criado crud simples usando o SQLite3, JWT para geração de token, sistema bem simples só para ter uma ideia de como funcionar uma api.

endpoint

POST - http://localhost:8000/api/user/register
POST - http://localhost:8000/api/user/login

GET - http://localhost:8000/api/product/all => pagination assim vai trazer os 10 primeiros registros passado 1 vai para a proxima página
http://localhost:8000/api/product/all/1

GET - http://localhost:8000/api/product/edit/1

POST - http://localhost:8000/api/product/register
PUT - http://localhost:8000/api/product/update
DELETE - http://localhost:8000/api/product/delete

Quando pegar logar precisa pegar o token e passa nas requisições com autorization:Bearer "token"
