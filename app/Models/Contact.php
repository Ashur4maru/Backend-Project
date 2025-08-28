<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Mogelijkheid om ongelezen berichten te krijgen
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Mogelijkheid om gelezen berichten te krijgen
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}