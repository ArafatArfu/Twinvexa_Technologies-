<?php

return [
    'emails' => array_values(array_filter(array_map(
        static fn ($email) => strtolower(trim($email)),
        explode(',', env('ADMIN_EMAILS', ''))
    ))),
];
