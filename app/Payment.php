<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function clients(){
        return $this->belongsTo(Client::class);
    }
}
