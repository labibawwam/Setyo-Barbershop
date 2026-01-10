<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
  public function boot()
{
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

    // Ensure public/storage exists without calling disabled functions (exec/symlink)
    $publicStorage = public_path('storage');
    if (!is_dir($publicStorage)) {
        $source = storage_path('app/public');
        if (is_dir($source)) {
            // only attempt to create a symlink if system functions are available
            if (function_exists('symlink') || function_exists('exec')) {
                try {
                    Storage::link('public', $publicStorage);
                } catch (\Throwable $e) {
                    // ignore and fallback to copy below
                }
            }

            // if symlink wasn't created, fallback to copying files
            if (!is_dir($publicStorage)) {
                @mkdir($publicStorage, 0755, true);
                $it = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );
                foreach ($it as $item) {
                    $dest = $publicStorage . DIRECTORY_SEPARATOR . $it->getSubPathName();
                    if ($item->isDir()) {
                        @mkdir($dest, 0755, true);
                    } else {
                        @copy($item->getPathname(), $dest);
                    }
                }
            }
        }
    }
}
}
