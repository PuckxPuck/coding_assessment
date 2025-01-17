<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $table = 'recipients';
    public $timestamps = false;
    public function message(){
        return $this->belongsTo(Message::class);
    }
}
