<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }
}