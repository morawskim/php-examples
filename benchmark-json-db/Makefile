
.PHONY: init

init:
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php php ./init_Schema.php
	docker-compose exec php php ./seed.php
