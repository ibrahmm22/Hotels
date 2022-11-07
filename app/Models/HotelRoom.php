<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    protected $fillable = ['hotel_id', 'facilities'];
    use HasFactory;
}
