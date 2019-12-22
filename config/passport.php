<?php

return [
    'grant_type'    => env('OAUTH_GRANT_TYPE', 'password'),
    'client_id'     => env('OAUTH_CLIENT_ID', 3),
    'client_secret' => env('OAUTH_CLIENT_SECRET', '1mnnEvqMIYV5OrQVhvJo55YNh9itZh3ccbceANQJ'),
    'scope'         => env('OAUTH_SCOPE', '*'),
];
