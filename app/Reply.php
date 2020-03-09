<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [ 
        'SmsMessageSid', 
        'NumMedia', 
        'SmsSid', 
        'SmsStatus',
        'Body',
        'To',
        'NumSegments',
        'MessageSid',
        'AccountSid',
        'From',
        'ApiVersion',
        'content_id'
    ];

    public function Content() {
        return $this->belongsTo('App\Content');
    }
    
}
