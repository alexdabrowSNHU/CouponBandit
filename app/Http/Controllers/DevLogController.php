<?php

namespace App\Http\Controllers;

use App\Models\DevLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DevLogController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'message' => ['required', 'string', 'max:500'],
        ]);

        $user = User::where('name', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }

        $log = DevLog::create([
            'message' => $request->message,
            'log_date' => now()->toDateString(),
        ]);

        return response()->json([
            'message' => $log->message,
            'date' => $log->log_date->format('d-m-Y'),
        ]);
    }
}
