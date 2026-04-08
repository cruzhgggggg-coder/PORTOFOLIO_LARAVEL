<?php

use App\Models\ProfileSetting;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Updating ProfileSettings...\n";
foreach (ProfileSetting::all() as $s) {
    if (str_contains($s->value, 'portofolio-main.test')) {
        $newValue = str_replace('http://portofolio-main.test', 'http://localhost:8000', $s->value);
        $s->value = $newValue;
        $s->save();
        echo "Updated ProfileSetting: {$s->key} to {$newValue}\n";
    }
}

echo "Updating Projects...\n";
foreach (Project::all() as $p) {
    if (str_contains($p->image_url, 'portofolio-main.test')) {
        $newValue = str_replace('http://portofolio-main.test', 'http://localhost:8000', $p->image_url);
        $p->image_url = $newValue;
        $p->save();
        echo "Updated Project: {$p->title} image to {$newValue}\n";
    }
}

echo "Done!\n";
