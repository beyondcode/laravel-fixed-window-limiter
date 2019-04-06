<?php

return [
    /*
     * The redis connection to use.
     */
    'connection' => 'default',

    /*
     * The prefix to use when storing limits in the Redis cache.
     */
    'prefix' => 'fixed-window-limiter-',

];