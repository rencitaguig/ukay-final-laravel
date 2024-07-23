<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\Brand as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Brand extends Model
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    protected $guarded = [];
    protected $table = 'brands';
    protected $fillable = ['name', 'company', 'website', 'description', 'logo', 'status'];


    protected $primaryKey = 'id';
}
