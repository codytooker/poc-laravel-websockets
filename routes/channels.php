<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('draft.{id}', function () {
    return true;
});
