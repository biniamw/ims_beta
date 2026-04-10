<?php

use App\Models\action_log;
use Illuminate\Support\Facades\Auth;

if (!function_exists('log_action')) {
    function log_action($action, $modelName, $modelId, $oldData = null, $newData = null)
    {
        action_log::create([
            'user_id'   => Auth::id(),
            'action'    => $action, // created, updated, deleted
            'model'     => $modelName,
            'model_id'  => $modelId,
            'old_data'  => $oldData ? json_encode($oldData) : null,
            'new_data'  => $newData ? json_encode($newData) : null,
        ]);
    }
}
