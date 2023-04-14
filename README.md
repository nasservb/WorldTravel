we could run environment with 
	
```sh
docker-compose up
``` 

build data base tables and default data : 

```sh
docker-cmpose exec app sh 
composer i
php cli.php
 
```
and select "7. Init DB(essential at first time running )" from menu


build front end application  : 

```sh
docker-cmpose exec front sh 
npm i
npm run prod
 
```

now you can open the "http://127.0.0.1:4000/" url in your browser and test app


run tests: 

```sh
php vendor/bin/phpunit  --testdox  tests/ 
```

run rabbitmq consumer for email : 
```sh
docker-cmpose exec app sh 
php src/Consumers/Mail.php
 
```
