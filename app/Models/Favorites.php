<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $table = 'favourite_guide';

    protected $fillable = ['guide_id', 'traveler_id'];
}
