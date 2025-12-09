<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'product_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Get unread notifications count
     */
    public static function unreadCount(): int
    {
        return self::where('is_read', false)->count();
    }

    /**
     * Get unread notifications
     */
    public static function unread()
    {
        return self::where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

