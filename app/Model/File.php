<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public static function storeFile($path,$messageId)
    {
        $path = str_replace('public', 'storage', $path);

        return File::insert([
            'message_id' => $messageId,
            'path' => $path,
            'created_at' => Carbon::now()
        ]);
    }
}
