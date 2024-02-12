# PHP & FFI demo

In this demo we use PHP FFI to display the notification from PHP script via calling libnotify functions.

PHP need to be compiled with support for FFI.
In some Linux distributions you need to install package `php8-ffi`.

We can use ldd to display all dynamic libraries used by notify-send - `ldd /usr/bin/notify-send`
In my exmaple I got:

```
linux-vdso.so.1 (0x00007fff39164000)
libnotify.so.4 => /lib64/libnotify.so.4 (0x00007f141460f000)
libgobject-2.0.so.0 => /lib64/libgobject-2.0.so.0 (0x00007f14145ad000)
libglib-2.0.so.0 => /lib64/libglib-2.0.so.0 (0x00007f1414465000)
libc.so.6 => /lib64/libc.so.6 (0x00007f1414200000)
libgdk_pixbuf-2.0.so.0 => /lib64/libgdk_pixbuf-2.0.so.0 (0x00007f1414436000)
libgio-2.0.so.0 => /lib64/libgio-2.0.so.0 (0x00007f1414011000)
libffi.so.8 => /lib64/libffi.so.8 (0x00007f141442b000)
libpcre2-8.so.0 => /lib64/libpcre2-8.so.0 (0x00007f1413f6a000)
/lib64/ld-linux-x86-64.so.2 (0x00007f1414642000)
libm.so.6 => /lib64/libm.so.6 (0x00007f1413e83000)
libgmodule-2.0.so.0 => /lib64/libgmodule-2.0.so.0 (0x00007f1414422000)
libpng16.so.16 => /lib64/glibc-hwcaps/x86-64-v3/libpng16.so.16.40.0 (0x00007f1413e36000)
libjpeg.so.8 => /lib64/glibc-hwcaps/x86-64-v3/libjpeg.so.8.3.2 (0x00007f1413d2d000)
libz.so.1 => /lib64/glibc-hwcaps/x86-64-v3/libz.so.1.3 (0x00007f1414408000)
libmount.so.1 => /lib64/libmount.so.1 (0x00007f1413ce1000)
libselinux.so.1 => /lib64/libselinux.so.1 (0x00007f1413cb3000)
libblkid.so.1 => /lib64/libblkid.so.1 (0x00007f1413c78000)
```

We can see the path to "libnotify.so.4" - "/lib64/libnotify.so.4".
We can use nm command to display exported symbols = `nm -D /lib64/libnotify.so.4`

Our simple script need to call a few C function - notify_init, notify_notification_new, notify_notification_show and notify_uninit.
We can extract [declaration of these functions from header file](Based on https://github.com/GNOME/libnotify/blob/150af91dc3cf4b35b2e11202cbb616cd56fb6106/libnotify/notification.h). Additional types from glib we can extract from [php-gtk-ffi project](https://github.com/scorninpc/php-gtk-ffi/blob/2260c0d65b821f8fdb77534b340aecd053d946f1/gtk.h)

The main problem is with GObject declaration, because we need also add declaration for some other types.

![notification](./notification.png)
