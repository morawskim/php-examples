
.PHONY: init

init:
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php php ./init_Schema.php
	docker-compose exec mongodb bash -c 'echo use benchmark > script.js && echo '\''db.createUser({user: "benchmark", pwd: "benchmark", roles: [ { role: "readWrite", db: "benchmark" } ]});'\'' >> script.js'
	docker-compose exec mongodb bash -c 'mongo --username admin --password adminpassword < script.js'
	docker-compose exec php php ./seed.php
