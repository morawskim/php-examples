<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Google two factor auth example</title>
</head>
<body>

<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

$google2fa = new PragmaRX\Google2FA\Google2FA();
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    $pin = !empty($_POST['secret']) ? $_POST['secret'] : '';
    $valid = $google2fa->verifyKey(GOOGLE_AUTH_SECRET, $pin);
    if($valid) {
        printf('PIN "%s" is VALID', $pin);
    } else {
        printf('PIN "%s" is NOT VALID', $pin);
    }
}

?>
<form id="form-login" action="index.php" method="post">
    <div>
        <label for="input-secret">PIN:</label>
        <input id="input-secret" type="text" name="secret" required />
    </div>
    <div>
        <button type="submit">Check</button>
    </div>
</form>
<div>
<?php
    $qrCodeUrl = $google2fa->getQRCodeGoogleUrl(
        'Google two factor auth php example',
        'test@example.com',
        GOOGLE_AUTH_SECRET
    );
?>
<img src="<?php echo $qrCodeUrl; ?>" alt="qrCode" />
</div>

</body>
</html>