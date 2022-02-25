.PHONY: setup

setup:
	docker-compose up -d php cli
	docker-compose exec php composer install
	docker-compose exec cli npm ci
	docker-compose exec cli npm run dev
	docker-compose up -d
