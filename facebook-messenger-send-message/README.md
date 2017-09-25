# Usage

Copy file `.env.dist` to `.env`

You need developer account.

Create app. Add `Messenger` product's. More info https://developers.facebook.com/docs/messenger-platform/getting-started/quick-start

Go to `Settings -> Basic` your's app.

Copy your `App ID` and paste in your `.env` file (key `FACEBOOK_APP_ID`)

Copy your `App Secret` and paste to your `.env` file (key `FACEBOOK_APP_SECRET`)
 
Create a page token.
See point 3 of https://developers.facebook.com/docs/messenger-platform/getting-started/quick-start
Then paste token to `.env` file (key `FACEBOOK_PAGE_ACCESS_TOKEN`)

Run in console
`php index.php PAGE_SCOPED_USER_ID`

Message should be sent to specific user.

**WARNING!**
`PAGE_SCOPED_USER_ID` is not user id.
From documentation (https://developers.facebook.com/docs/messenger-platform/reference/send-api/):
>The id must be an ID that was retrieved through the Messenger entry points or through the Messenger webhooks (e.g., a person may discover your business in Messenger and start a conversation from there.
 These IDs are page-scoped IDs (PSID). This means that the IDs are unique for a given page.
 If you have an existing Facebook Login integration, user IDs are app-scoped and will not work with the Messenger platform.

