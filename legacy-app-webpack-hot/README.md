# Run

Install required npm packages `docker-compose run nodejs npm ci`

Start containers `docker-compose up -d`

Open browser and go to url `http://localhost:3456`

Run `docker-compose exec nodejs npm run watch`

Edit css file. The `h1` font color should change.

But there is also side effect, if you change event listener. After update we have two event listeners for button :/