First run `docker-compose up -d`
This will build docker image and start container.
Then you must install dependiencies.
Run command `docker-compose exec php composer --working-dir=/app install`.
You can resize image by run command `docker-compose exec php  php /app/resize.php /app/example.jpeg /app/resized.jpeg`

Image from https://picsum.photos/