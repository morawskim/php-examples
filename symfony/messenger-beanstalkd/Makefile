.PHONY: init

init:
	docker-compose up -d
	# at the moment cli container use 8.0.1, but Symfony 6 requires at least 8.0.2
	docker-compose exec cli composer install --ignore-platform-reqs
