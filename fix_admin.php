<?php
use App\Models\User;
use App\Models\Boutique;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::statement('SET FOREIGN_KEY_CHECKS=0;');
Boutique::truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

$admin = User::where('email', 'admin@ondigoci.test')->first();

if ($admin) {
    Boutique::create([
        'user_id' => $admin->id,
        'nom_boutique' => 'Ondigoci Direct',
        'description' => 'Boutique officielle de l\'administration.',
        'statut' => 'approuve',
        'adresse_siege' => 'Abidjan'
    ]);
    echo "Boutique created successfully.\n";
} else {
    echo "Admin user not found.\n";
}
