<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * @var mixed|string
     */

    public function entity(){
        return $this->morphTo();
    }

    public function initiator(){
        return $this->hasOne(User::class);
    }
}
