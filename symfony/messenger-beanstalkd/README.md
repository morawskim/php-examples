## Usage

Call `make init` to install dependencies.

Call `docker-compose exec php php ./producer.php` to produce message.

Open `127.0.0.1:8000` in your favourite webbrowser. You should see value 1 in tube `foo` in column `current-jobs-ready`.  

Call `docker-compose exec php php ./consumer.php` to consume message from queue.

## Important classes

`\App\MessageBusFactory` - factory to create MessageBus and Transport
