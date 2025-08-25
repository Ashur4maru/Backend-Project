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

    // Scope pour obtenir les messages non lus
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope pour obtenir les messages lus
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}