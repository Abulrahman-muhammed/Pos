<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Storage;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useBootstrapFive();
        // Paginator::useBootstrapFour();

// Dynamically set morph map for all models instead it stored by it is full namespace like 'App\Models\User' in database it is just model name like 'User', 'Post' etc.
// in file system config we have added a new [disk=>[ 'driver' => 'local', 'root' => app_path().DIRECTORY_SEPARATOR, 'visibility' => 'public']] called 'app' to point to app/ directory [C:\xampp\htdocs\laravel\albadr-pos\config\filesystems.php]
        // 'app'=>[
        // 'driver' => 'local',
        // 'root' => app_path().DIRECTORY_SEPARATOR,
        // 'visibility' => 'public',
        // ],
        $modelFiles = Storage::disk('app')->files('Models');
        foreach ($modelFiles as $modelFile) {
            $model = str_replace(['.php', 'Models/'], '', $modelFile);
            $modelClass = 'App\\Models\\'.str_replace('/', '\\', $model);
            Relation::enforceMorphMap([
                (string) $model => $modelClass,
            ]);
        }

    }


}
