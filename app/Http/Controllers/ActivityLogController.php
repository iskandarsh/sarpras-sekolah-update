<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $logs = ActivityLog::with('user')->latest()->get();

        return view('activity-log.index', compact('logs'));
    }
}
