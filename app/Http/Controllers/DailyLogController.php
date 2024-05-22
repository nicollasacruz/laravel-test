<?php

namespace App\Http\Controllers;

use App\Rules\NoShit;
use App\Models\DailyLog;
use Illuminate\Http\Request;
use App\Events\DailyLogCreated;
use App\Http\Requests\StoreDailyLogRequest;

class DailyLogController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'log' => ['required', 'string', new NoShit],
            'day' => 'required|date',
        ]);

        $dailyLog = DailyLog::create([
            'user_id' => auth()->id(),
            'log'     => $request->log,
            'day'     => $request->day,
        ]);

        DailyLogCreated::dispatch($dailyLog);

        return response()->json([
            'status' => true,
            'message' => 'Daily log created successfully',
            'data' => $dailyLog
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DailyLog $dailyLog, Request $request)
    {
        $request->validate([
            'log' => 'string',
            'day' => 'date',
        ]);

        $dailyLog->fill($request->all());

        if ($dailyLog->isDirty()) {

            $dailyLog->save();

            return response()->json([
                'status' => true,
                'message' => 'Daily log updated successfully',
                'data' => $dailyLog
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No changes were made',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyLog $dailyLog)
    {
        $this->authorize('delete', $dailyLog);
        
        $dailyLog->delete();

        return response()->json([
            'status' => true,
            'message' => 'Daily log deleted successfully',
        ]);
    }
}
