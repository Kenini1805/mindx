<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllCountry extends Model
{
    protected $table = 'all_countries';
    use HasFactory;

    protected $guarded = [];
}

