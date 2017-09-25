# Usage

Copy file `.env.dist` to `.env`

You need developer account.

Create app, add platform `Facebook Web Games` (I can't add Facebook Canvas)

Go to `Settings -> Basic` your's app.

Copy your `App ID` and paste in your `.env` file (key `FACEBOOK_APP_ID`)

Copy your `App Secret` and paste to your `.env` file (key `FACEBOOK_APP_SECRET`)
 
Open `https://developers.facebook.com/tools/access_token/` and copy `App Token` for your application.
Then paste to `.env` file (key `FACEBOOK_APP_ACCESS_TOKEN`)

Run in console
`php index.php FACEBOOK_USER_ID`

You cant get your `FACEBOOK_USER_ID` from https://findmyfbid.com/

Notification should be sent to specific user.