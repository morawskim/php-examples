<?php
$ffi = FFI::load(__DIR__ . '/ffi-libnotify.h');

if (!$ffi->notify_init("ffitest")) {
    throw new RuntimeException('Unable to initialize libnotify');
}

if (!$ffi->notify_is_initted()) {
    throw new RuntimeException('Libnotify has not been initialized');
}

$appName = $ffi->notify_get_app_name();

$notification = $ffi->notify_notification_new("summary", "long body", "terminal");
$ffi->notify_notification_show($notification, null);
$ffi->notify_uninit();
