<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addr extends Model
{
    use HasFactory;
    protected $table='listadd';
    protected $fillabe=['name'];

}
