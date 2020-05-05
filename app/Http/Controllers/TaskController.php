<?php

namespace App\Http\Controllers;

use App\Model\Message;
use App\Model\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getAllTasksForUser(Request $request,$userId)
    {
        return Task::getAllTasksForUser($userId);
    }

    public function createNewTask(Request $request)
    {
        $data = $request->all();

        $taskId = Task::createTask($data);
        Message::createMessage($taskId,$data);
        return true;
    }
}
