<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; // ← importa el trait

class Room extends Model
{
    use HasFactory, SoftDeletes; // ← activa Soft Deletes

    protected $fillable = ['name','location','capacity','status'];
}
