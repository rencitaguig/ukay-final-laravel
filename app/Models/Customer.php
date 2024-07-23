<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'first_name', 
        'last_name', 
        'phone_number', 
        'address', 
        'image_path'
    ];

    protected $table = 'customers';
    public $timestamps = false;

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function fullName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected $primaryKey = 'user_id';
}
