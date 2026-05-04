<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Correction du chemin pour le mode maintenance
if (file_exists($maintenance = __DIR__.'/../ondigoci_core/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. CORRECTION ICI : Ajoute l'espace entre require et __DIR__
require __DIR__.'/../ondigoci_core/vendor/autoload.php';

// 3. Liaison avec le bootstrap
/** @var Application $app */
$app = require_once __DIR__.'/../ondigoci_core/bootstrap/app.php';

$app->handleRequest(Request::capture());