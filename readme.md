# Pastelaria

## Como Instalar
* Na pasta principal
    * Rodar os comandos:
        * docker-compose build
        * docker-compose up -d
        * docker exec php composer install
        * docker-compose exec php php artisan migrate
            * Pode ser que de erro nesse passo, mas é devido estar subindo o banco de dados, aguardar e tentar novamente 
        * docker-compose exec php composer dump-autoload
        * sudo chmod 777 -R storage
        * docker-compose exec php php artisan db:seed
    * Configurar o arquivo .env
        * Copiar o arquivo .env.example para .env
        * Configurar informações de e-mail válidas
 
## Como rodar os testes     
* Na pasta principal
    * Rodar o comando:   
        * docker-compose exec php ./vendor/bin/phpunit -d memory_limit=-1 --testdox
            * Os testes irão limpar o banco de dados, então será necessário fazer o seed de dados novamente
        



