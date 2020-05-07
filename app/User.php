<?php

namespace App;

use App\Notifications\NewTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\NewMessage;
use Illuminate\Support\Facades\Notification;

class User extends Authenticatable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name', 'email', 'password',
];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
];

    public static function getUserById($id)
    {
        return User::where('id', '=' , $id)
            ->first();
    }

    public static function sendNewMessageForManager($taskId,$text)
    {
        $toUser = User::getManager();

        Notification::send($toUser, new NewMessage($taskId,$text));
    }

    public static function sendNewMessageForUser($taskId,$text,$userId)
    {
        $toUser = User::getUser($userId);

        Notification::send($toUser, new NewMessage($taskId,$text));
    }

    public static function sendNewTask($taskId)
    {
        $toUser = User::getManager();

        Notification::send($toUser, new NewTask($taskId));
    }

    public static function getManager()
    {
        return User::where('role', '=' , 1)
            ->first();
    }

    public static function getUser($id)
    {
        return User::where('id', '=' , $id)
            ->first();
    }
}
