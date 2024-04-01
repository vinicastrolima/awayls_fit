Clonar o repositório:


Para configurar e rodar o backend:


cd backend
composer install
php artisan key:generate
Certifique-se de configurar as variáveis no arquivo .env conforme necessário, incluindo a conexão com o banco de dados e outras configurações específicas do seu ambiente.

php artisan jwt:secret
php artisan serve


Para configurar e rodar o frontend:

cd ../frontend
yarn install
Certifique-se de validar o arquivo .env para garantir que a rota da API esteja correta.

yarn build
serve -s dist
