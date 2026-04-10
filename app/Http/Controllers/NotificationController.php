<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;

class NotificationController extends Controller
{
    //

    public function notificationuser()
    {
      
        $users2 = User::join('storeassignments', 'storeassignments.UserId', '=', 'users.id')
        ->where(['storeassignments.StoreId' => 3,'storeassignments.Type'=>3])
        ->get(['users.*']);
        return $users2;
    }
}
