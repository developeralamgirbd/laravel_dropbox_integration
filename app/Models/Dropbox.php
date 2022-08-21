<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropbox extends Model
{
    use HasFactory;
    protected $fillable = ['app_key','app_secret','refresh_token','access_token','redirect_url','notify_email'];
    protected $hidden = ['app_key', 'app_secret','refresh_token','access_token'];
}
