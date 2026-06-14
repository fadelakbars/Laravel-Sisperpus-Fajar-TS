<?php

test('check database connection', function () {
    \Illuminate\Support\Facades\Log::error("DEBUG_CONN: " . config('database.default'));
    \Illuminate\Support\Facades\Log::error("DEBUG_SQLITE: " . config('database.connections.sqlite.database'));
    \Illuminate\Support\Facades\Log::error("DEBUG_MYSQL: " . config('database.connections.mysql.database'));
});
