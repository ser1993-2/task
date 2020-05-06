<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public static function getAllTasksForUser($userId)
    {
        return Task::where('tasks.user_id', '=', $userId)
            ->get();
    }

    public static function getTaskForUser($taskId)
    {
        $task = Task::where('id', '=', $taskId)
            ->first();

        $message = Message::getMessageForTask($taskId);

        return compact('task', 'message');
    }

    public static function createTask($data)
    {
        return Task::insertGetId([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'created_at' => Carbon::now(),
        ]);
    }

    public static function updateTask($taskId)
    {
        return Task::where('id', '=' , $taskId)
            ->update([
                'updated_at' => Carbon::now()
            ]);
    }

    public static function closeTask($taskId)
    {
        return Task::where('id', '=' , $taskId)
            ->update([
                'status' => 0
            ]);
    }

    public static function getLastTask($userId)
    {
        $task = Task::where('user_id', '=' , $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        $date = (int) Carbon::now()->hour - (int) $task->created_at->format('H');

        if ($date >=  0) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }

    }
}
