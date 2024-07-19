Introdução
Este projeto implementa uma API simples para buscar produtos e autenticação de usuários usando Laravel com autenticação JWT.

Funcionalidades Principais
Autenticação JWT: Implementação de registro, login, refresh token, logout e obtenção de dados do usuário autenticado.
Produtos: Listagem básica de produtos, incluindo listagem de todos os produtos e detalhes de um produto específico.
Tecnologias Utilizadas
Laravel: Framework PHP utilizado para desenvolvimento do backend da API.
JWT (JSON Web Tokens): Utilizado para autenticação stateless na API.
PHPUnit: Utilizado para testes automatizados.
Como Usar
Configuração do Ambiente

Clone este repositório.
Instale as dependências usando composer install.
Configure o arquivo .env com suas credenciais de banco de dados e outras configurações necessárias.
Migrações e Seeders

Execute as migrações para criar as tabelas no banco de dados: php artisan migrate.
Opcional: Se necessário, execute seeders para popular o banco de dados com dados iniciais.
Execução dos Testes

Execute os testes para garantir que tudo está funcionando corretamente: php artisan test.
Endpoints Disponíveis

Consulte a documentação da API (Swagger) para obter detalhes sobre os endpoints disponíveis e como interagir com eles.
Documentação da API
A documentação da API está disponível através do Swagger, acessível em /api/documentation após iniciar o servidor local.

Conclusão
Este projeto demonstra habilidades em desenvolvimento de APIs RESTful utilizando Laravel, integração de autenticação JWT, e testes automatizados com PHPUnit. Sinta-se à vontade para explorar o código-fonte.
