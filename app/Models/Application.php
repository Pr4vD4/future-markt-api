<?php

namespace App\Models;

use App\Helpers\Telegram;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'body',
        'web_site_id',
    ];

    public function web_site()
    {
        return $this->belongsTo(WebSite::class);
    }

}
