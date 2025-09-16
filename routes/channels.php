<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('draft.{id}', function () {
    return true;
});

Broadcast::channel('node.socket', function () {
    logger('Authorizing node.socket channel');

    return true;
});
