<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Reply;

class Content extends Model
{
    // note that sid is: sms id
    //protected $table= "contents";
    protected $fillable = [
        'from_number','to_number','content','u_id','c_id','status', 'sid'
    ];


    public function replies() {
        return $this->hasMany(Reply::class);
    }

}
