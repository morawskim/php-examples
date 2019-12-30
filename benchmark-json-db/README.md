## Setup

Run command `make init`. You must have installed `make`.
This command will configure 3 database and generate 1 000 000 records.
This process may take about 30 minutes.

When data is ready, we can run `docker-compose exec php php benchmark.php`

Example output
```
[mysql] Take 2356.100000 and consume 2097152 memory
[postgres] Take 1394.400000 and consume 2097152 memory
[mongodb] Take 601.400000 and consume 4194304 memory
```
