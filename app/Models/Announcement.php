<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\Announcement as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Announcement extends Model
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

   


    protected $guarded = [];
    protected $table = 'announcements';
    protected $fillable = ['title', 'date_of_arrival', 'description', 'logo'];


    protected $primaryKey = 'id';
   
}
