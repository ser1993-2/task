<?php

namespace App\Model;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public static function getAllTasksForUser($userId)
    {
        return Task::where('user_id', '=', $userId)
            ->join('messages' , 'messages.task_id', 'tasks.id')
            ->select('tasks.id', 'tasks.name','messages.text')
            ->get();
    }

    public static function createTask($data)
    {
        return Task::insertGetId([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'created_at' => Carbon::now(),
        ]);
    }
}
