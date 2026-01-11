# PHP and Go Shared Memory Example

This project demonstrates how to use shared memory (IPC) to communicate between a PHP application and a Go application on a Linux-based system.

## Overview

- **PHP (Writer):** Creates a shared memory segment, writes a message to it, and waits for user input to exit. The `shmop` and `pcntl` extensions are required.
- **Go (Reader):** Attaches to the existing shared memory segment, reads the message, prints it, and exits.

## How to Run

### 1. Start the PHP Writer

The PHP script acts as the creator and writer of the shared memory block.

```bash
docker compose up --build
```

Once it starts, you will see a message: `type "exit" to finish this script`. Keep this process running.

### 2. Build the Go Reader

In a separate terminal, navigate to the `go` directory and build the reader application using the provided Makefile (which uses a Docker container for the build process):

```bash
cd go
make build
```

This will create an executable named `shared-memory-read` in the `go` directory.

### 3. Run the Go Reader

To run the reader, you can execute it within the running PHP container. 

Since `docker-compose.yml` starts the `php` service, you can run the Go binary inside that container:

```bash
docker compose exec php ./go/shared-memory-read
```

You should see the output:
```
Read from shared memory:
my shared memory block
```

### 4. Cleanup

Type `exit` in the PHP terminal or press `Ctrl+C` to stop the PHP script and then run:

```bash
docker compose down
```
