## Info

Guzzle has support for SOCKS5 proxy server.
There is an issue on the guzzle library that there are problems with socks5 proxy servers - https://github.com/guzzle/guzzle/issues/1484. I had similar problems when I used public SOCKS5 servers from http://spys.one/en/socks-proxy-list/.
When I use the private SOCKS5 server I didn't have any problems. Testing with `php7.2` and `guzzle 6.5`.

## Run
First you must install dependiences. In project root run `docker run --rm -v $PWD:/app composer composer install`
`php` container bind to the host network, so you don't need to copy your ssh keys/config to the container.
You can check guzzle can use SOCKS5 proxy by run `docker-compose run --rm php php index.php <SOCKS5_PROXY>`
In the output you will see the message `Using socks5 server: <SOCKS5_PROXY>` and below public IP address of your socks5 server.
