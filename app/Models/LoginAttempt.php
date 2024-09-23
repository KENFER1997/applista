<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;

    protected $table = 'login_attempts';

    protected $fillable = [
        'user_id',
        'ip_address',
        'successful',
    ];

    /**
     * Relación con el modelo User.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
