<?php

namespace App\Http\Controllers;

use App\Model\Message;
use App\Model\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getAllTasksForUser()
    {
        if (Auth::user()) {
            return Task::getAllTasksForUser(Auth::user()->id);
        }

        return false;
    }

    public function getTaskForUser(Request $request,$taskId)
    {
        return Task::getTaskForUser($taskId);
    }

    public function createNewTask(Request $request)
    {
        $data = $request->all();

        if ($data['name'] == '' || $data['text'] == '') {
            return false;
        }

        $taskId = Task::createTask($data);
        Message::createMessage($taskId,$data);
        return true;
    }

    public function addMessage(Request $request,$taskId)
    {
        $data = $request->all();

        return Message::createMessage($taskId,$data);
    }

    public function closeTask(Request $request,$taskId)
    {
        return Task::closeTask($taskId);
    }

    public function getDateOfLastTaskForUser(Request $request,$userId)
    {
        return Task::getLastTask($userId);
    }

    public function editTask(Request $request)
    {
        $data = $request->all();

        return Task::editTask($request['taskId'], $data);
    }
}
