<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public static function createMessage($taskId,$data)
    {
         Message::insert([
            'task_id' => $taskId,
            'text' => $data['text'],
            'user_id' => $data['user_id'] ?? 0,
            'manager_id' => $data['manager_id'] ?? 0,
            'created_at' => Carbon::now(),
        ]);

         Task::updateTask($taskId);

        return true;
    }

    public static function getMessageForTask($taskId)
    {
        return Message::where('task_id', '=', $taskId)
            ->get();
    }
}
