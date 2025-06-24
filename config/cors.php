<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://tintuc-frontend.vercel.app'],
    'allowed_headers' => ['*'],
    'supports_credentials' => true, // ✅ Rất quan trọng nếu frontend gửi cookie/token
];
