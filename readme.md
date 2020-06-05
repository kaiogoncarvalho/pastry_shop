# Pastry Shop

This API is responsible for management of a pastry shop.

## Install

This System uses Docker, so it is necessary Docker 
and Docker Compose installed to run this project, but you can configure nginx (or apache), php and mysql.

For install is necessary follow this steps:

**Install using Docker**

* Acess the directory of project
* give permissions for logs:
    * **MacOS:** `sudo chmod -R 777 storage`
    * **Linux:** `sudo chmod 777 -R storage`
* run this commands for install and start docker
    * `docker-compose build`
    * `docker-compose up -d`
* run this command to generate .env
    * `cp .env.example .env `
    * Configure e-mail informations in .env  
* run this command to install libraries
    * `docker-compose exec php composer install`
* run this command for create tables
    * `docker-compose exec php php artisan migrate`
* run this command for create initial data
    * `docker-compose exec php php artisan db:seed`


**Install without Docker**
* Configure nginx (or apache), php and mysql;
* Acess the directory of project
* give permissions for logs:
    * `sudo chmod 777 -R storage`
* run this command to generate .env
    * `cp .env.example .env `   
    * Configure e-mail informations in .env  
* run this command to install libraries
    *  `composer install`
* run this command to create tables
    * `php artisan migrate`
* run this command for create initial data
    * `php artisan db:seed`


## Tests
For run tests follow this steps in directory of project:
* run this command to run acceptance tests:    
    * `docker-compose exec php composer tests`

If you don't user Docker to Install use this commands in directory of project:
* run this command to run acceptance tests:    
    * `php composer tests`


## Usage
**IMPORTANT! All request with method POST need Content-Type: application/json in header**

**In directory root exists a collection of Postman with all endpoints**

Access this URL for API of endpoints ((this URL is only if you use Docker to install project):
  
  * **URL:** http://localhost:8080

_if you don't use Docker to install system you need configure the URL;_  
   



