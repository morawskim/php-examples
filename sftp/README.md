# Description

Example usage of `league/flysystem` which is a filesystem abstraction library for PHP.
In this demo, We use adapter `SFTP` to connecto to sftp server to put, read and list files.
We use both password and private key authorization in this demo.

In one of the project we had the task to send files to sftp server and this example is researching on how this can be done.

When you connect by private key in `docker-compose logs` you will see:
`Accepted publickey for userPHP from 192.168.16.3 port 34392 ssh2: RSA SHA256:DUq5LEQb7jTIRCs2NIPtt3exrioDH8Q3bAYX9KFWAyI`

## Usage

`docker-compose up -d`

`docker-compose exec php composer install`

`docker-compose exec php php ./index.php`
