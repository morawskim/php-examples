.PHONY: init send-event

init:
	docker-compose up -d
	docker-compose exec cli composer install --ignore-platform-reqs
	docker-compose exec cli npm ci
	docker-compose exec cli npm run dev

send-event:
	docker-compose up -d
	docker-compose exec php php send-event.php
