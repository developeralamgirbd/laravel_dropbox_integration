<?php

namespace App\Providers;

use App\Models\Dropbox;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Spatie\Dropbox\Client as DropboxClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('dropbox', function ($app, $config) {
            $adapter = new DropboxAdapter(new DropboxClient(
                $config['authorization_token']
            ));
            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });

        if (Schema::hasTable('dropboxes')){
            $dropbox = Dropbox::first();
            if ($dropbox){
                $data = [
                    'driver' => 'dropbox',
                    'key' => $dropbox->app_key,
                    'secret' => $dropbox->app_secret,
                    'authorization_token'   => $dropbox->access_token
                ];
                Config::set('filesystems.disks.dropbox', $data);
                Config::set('backup.notifications.mail.to', $dropbox->notify_email);
            }
        }
    }
}
