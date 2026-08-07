<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'campusconnect.corporate+admin@gmail.com')->first();
if ($user) {
    $user->password = Hash::make('password123');
    $user->save();
    echo "Success!";
} else {
    echo "User not found.";
}
