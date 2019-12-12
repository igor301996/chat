<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function saveMessage(int $roomId, int $userId, string $text)
    {
        return self::create([
            'room_id' => $roomId,
            'user_id' => $userId,
            'text' => $text
        ]);
    }
}
