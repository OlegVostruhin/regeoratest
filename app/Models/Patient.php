<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $timestamps = false;
    public $fillable = ['first_name', 'last_name', 'birth_date', 'age', 'age_type'];
}
