Example of embedding images in yii2-swiftmail
===

Installation
---
If you don't install before "fxp/composer-asset-plugin" composer's package, you must do it.
Otherwise composer will can't find bower's packages. Run this command

`php composer.phar global require "fxp/composer-asset-plugin:^1.2.0"`

Then run

`php composer.phar install`

Finally

`php ./embedding-test.php`

You should see new file in `./app/runtime/mail`. Open this file in your favourite email client.
You may need enable html view.

Resources
--
* I use HTML Email Layout from MailChimp - https://github.com/mailchimp/email-blueprints
* I use images from lorempixels - http://lorempixel.com/

