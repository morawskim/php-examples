# Example encryption by PHP

Run `docker-compose up -d`

Next create encrypted message `docker-compose exec php php ./encrypt.php > message`

You can decrypt message by export `GNUPGHOME` env variable and import secret key to temorary keyring - `export GNUPGHOME=$PWD`. Next `gpg --import ./privkey.asc`. Check private key was imported by execute command `gpg --list-secret-keys`. You should see in output key `0A2EF9AE9D9904816116C4063EB6BE9650D8871F` for `Test PHP GPG <test@example.com>`. You can decrypt message by execute command `gpg --decrypt message`.
