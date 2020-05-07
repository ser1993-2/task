<?php

namespace App\Model;

use App\Http\Controllers\AccountController;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    public static function createMessage($taskId,$data)
    {
         $messageId = Message::insertGetId([
            'task_id' => $taskId,
            'text' => $data['text'],
            'user_id' => $data['user_id'] ?? 0,
            'manager_id' => $data['manager_id'] ?? 0,
            'created_at' => Carbon::now(),
        ]);

         Task::updateTask($taskId);

        return $messageId;
    }

    public static function getMessageForTask($taskId)
    {
        return Message::where('task_id', '=', $taskId)
            ->leftJoin('files', 'files.message_id', 'messages.id')
            ->select('messages.id','messages.text', 'messages.created_at','messages.user_id',
                'messages.manager_id', 'files.path')
            ->orderBy('messages.id')
            ->get();
    }

    public static function getLastAnswer($taskId)
    {
        return Message::where('task_id', '=', $taskId)
            ->orderBy('messages.id', 'desc')
            ->pluck('manager_id')
            ->first();
    }
}
