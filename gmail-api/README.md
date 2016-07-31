# Gmail Api - Get email's signatures example

## Configure Google Apps - http://stackoverflow.com/a/29328258
1. Using a google apps user open the developer console

2. Create a new project (ie MyProject)

3. Go to [Apis & auth] > [Credentials] and create a new [Service Account] client ID

4. Save json credentials file in project root dir under name `service-account-credentials.json`

5. Copy the [service account]'s [Client ID] (the one like xxx.apps.googleusercontent.com) for later use

6. Now you have to Delegate domain-wide authority to the service account in order to authorize your appl to access user data on behalf of users in the Google Apps domain ... so go to your google apps domain admin console

7. Go to the [Security] section and find the [Advanced Settings] (it might be hidden so you'd have to click [Show more..])

8. Click con [Manage API Client Access]

9. Paste the [Client ID] you previously copied at [4] into the [Client Name] text box.

10. To grant your app access to gmail settings, at the [API Scopes] text box enter:  (it's very important that you enter ALL the scopes)
* https://mail.google.com
* https://www.googleapis.com/auth/gmail.modify
* https://www.googleapis.com/auth/gmail.readonly
* https://www.googleapis.com/auth/gmail.settings.basic

## Usage

`php signatures.php user@example.com`