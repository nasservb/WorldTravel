we could run environment with 
	
```sh
docker-compose up
``` 

and

```sh
docker-cmpose exec app sh 
php src/nasservb/AgencyAssistant/Main.php
```

run tests: 

```sh
php vendor/bin/phpunit  --testdox  tests/ 
```
i wana to add event on rabbitmq when entity created and store index on Elasticsearch and get result from elasticseach when we serching but time is late.

