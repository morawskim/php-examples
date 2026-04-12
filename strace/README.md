### PHP File Access Tracer

This script is designed to track system calls related to file operations (like open) to monitor whether a script accesses or modifies files outside of a specified directory.

#### Basic Usage

To track all file-related system calls:

```bash
strace -e trace=file -f -y php ./write-file.php
```

#### Filtering strace Results

##### 1. Tracking access to `/tmp` directory excluding PHP files

If you want to track file access within the `/tmp` directory and exclude files with the `.php` extension, you can pipe the output to `grep`:

```bash
strace -e trace=file -f -y php ./write-file.php 2>&1 | grep '"/tmp/' | grep -v '\.php"'
```

##### 2. Tracking access to a custom directory excluding specific system paths and PHP files

To monitor a specific directory (e.g., `/var/www/`) while excluding common system paths like `/usr/` and `/etc/`, and ignoring files with the `.php` extension:

```bash
strace -e trace=file -f -y php ./write-file.php 2>&1 | grep -vE '"(/usr/|/etc/|/lib64/|/proc/|sys/)' | grep -v '\.php"'
```

Note: Replace the directory in the filter as needed. The above example excludes:
* `/usr/`
* `/etc/`
* `/lib64/`
* `/proc/`
* `/sys/`

and filters out `.php` files from the entire output.
