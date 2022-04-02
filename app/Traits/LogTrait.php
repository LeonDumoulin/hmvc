<?php

namespace App\Traits;

trait LogTrait
{
    public function logs()
    {
        return $this->morphMany(Log::class, 'logable');
    }

    public static function createLog($log_model, $user, $title, $description = null, $type = 'admin')
    {
        $log_model->logs()->create([
            'user_id' => $user->id,
            'title' => $title,
            'description' => $description,
            'type' => $type,
        ]);
    }
}