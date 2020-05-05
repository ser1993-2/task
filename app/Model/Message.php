<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public static function createMessage($taskId,$data)
    {
        return Message::insert([
            'task_id' => $taskId,
            'text' => $data['text'],
            'created_at' => Carbon::now(),
        ]);
    }
}
