# Usage

PHP >= 7.0 is required

Create Facebook app, page and webhooks.
See:
* https://developers.facebook.com/docs/messenger-platform/getting-started/quick-start
* http://christoph-rumpel.com/2017/09/build-a-facebook-chatbot-with-laravel-and-botman-studio/

Copy or rename file `.env.dist` to `.env`

Change values in `.env` file

Run built-in php server.
```bash
php -S 127.0.0.1:8080
```

Run ngrok
``` bash
ngrok http 8080
```

