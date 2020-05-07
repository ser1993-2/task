<?php

namespace App\Http\Controllers;

use App\Model\Message;
use App\Model\Task;
use App\User;
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

    public function getAllTasksForManager()
    {
        if (Auth::user() && Auth::user()->role == 1) {
            return Task::getAllTasksForManager();
        }

        return false;
    }

    public function getTask(Request $request,$taskId)
    {
        return Task::getTask($taskId);
    }

    public function getTaskForManager(Request $request,$taskId)
    {
        $task = Task::getTask($taskId);

        if ($task) {
            Task::updateView($taskId);
        }

        return $task;
    }

    public function createNewTask(Request $request)
    {
        $data = $request->all();

        if ($data['name'] == '' || $data['text'] == '') {
            return false;
        }

        $taskId = Task::createTask($data);
        Message::createMessage($taskId,$data);
        User::sendNewTask($taskId);
        return true;
    }

    public function addMessage(Request $request,$taskId)
    {
        $data = $request->all();
        Message::createMessage($taskId,$data);

        if (Auth::user()->role == 1) {
            $userId = Task::find($taskId)->pluck('user_id');
            User::sendNewMessageForUser($taskId,$data['text'],$userId);
        } else {
            User::sendNewMessageForManager($taskId,$data['text']);
        }
    }

    public function closeTask(Request $request,$taskId)
    {
        return Task::closeTask($taskId);
    }

    public function openTask(Request $request,$taskId)
    {
        return Task::openTask($taskId);
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
