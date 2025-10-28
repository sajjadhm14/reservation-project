<?php

namespace App\Http\Controllers\Consulter\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consulter\Dashboard\CalenderRequest;
use App\Models\Calender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $calenders = Calender::where('consulter_id' , Auth::guard('consulter')->id())->get();
        return view('consulter.dashboard.pages.calender' , compact('calenders'));
    }

    public function calenderPost(CalenderRequest $request): \Illuminate\Http\JsonResponse
    {
        $id = Auth::guard('consulter')->id();
        $data = $request->validated();

        $calender = Calender::create([
            'consulter_id' => $id,
            'status'=> 'pending',
            'amount' => $data['amount'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
        return response()->json([
            'message' => 'Time Added To Calender successfully',
            'data' => $calender,
        ]);
    }
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $calender = Calender::find($id)->delete();
        return response()->json([
            'message' => 'Time Deleted Successfully',
            'data' => $calender,
        ]);
    }
}
