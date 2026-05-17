<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationModel;

class NotificationController extends Controller
{
    public function markRead(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

     

        NotificationModel::where('n_id', $request->id)
            ->update(['status' => 1]);

        return response()->json([
            'success' => true
        ]);
    }
}
