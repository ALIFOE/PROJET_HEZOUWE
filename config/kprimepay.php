<?php

return [

    'secret_key' => env('KPRIMEPAY_SECRET_KEY'),

    'base_url' => env('KPRIMEPAY_BASE_URL', 'https://api.kprimepay.com/v2'),

    // Requis par /checkout uniquement : 1 = test, 2 = live.
    'mode' => (int) env('KPRIMEPAY_MODE', 2),

];
