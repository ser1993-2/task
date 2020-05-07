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

    public static function getAllTasksForManager()
    {
        $tasks =  Task::join('users', 'users.id', 'tasks.user_id')
            ->select('tasks.id', 'tasks.name', 'tasks.created_at', 'tasks.updated_at', 'tasks.status',
                'tasks.view', 'users.name as user_name' )
            ->orderBy('id', 'desc')
            ->get();

        foreach ($tasks as $task) {
            $task->answer = Message::getLastAnswer($task->id);
        }

        return $tasks;
    }

    public static function getTask($taskId)
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

    public static function openTask($taskId)
    {
        return Task::where('id', '=' , $taskId)
            ->update([
                'status' => 1
            ]);
    }

    public static function getLastTask($userId)
    {
        $task = Task::where('user_id', '=' , $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$task) {
            return response()->json(true);
        }

        $date = (int) Carbon::now()->hour - (int) $task->created_at->format('H');

        if ($date >=  0) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public static function editTask($taskId, $data)
    {
        return Task::where('id', '=', $taskId)
            ->update([
                'name' => $data['name'],
                'updated_at' => Carbon::now()
            ]);
    }

    public static function updateView($taskId)
    {
        return Task::where('id', '=', $taskId)
            ->update([
                'view' => 1
            ]);
    }
}
