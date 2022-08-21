<?php

namespace Database\Seeders;

use App\Models\Dropbox;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DropboxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dropbox::create([
            'app_key' => 'app_key',
            'app_secret' => 'app_secret',
            'refresh_token' => 'refresh_token',
            'access_token' => 'access_token',
            'redirect_url' => 'redirect_url',
            'notify_email' => 'notify_email',
        ]);
    }
}
