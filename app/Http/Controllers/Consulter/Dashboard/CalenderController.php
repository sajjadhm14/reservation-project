<?php

namespace App\Http\Controllers\Consulter\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consulter\Dashboard\CalenderRequest;
use App\Models\Calender;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $calenders = Calender::where('consulter_id' , Auth::guard('consulter')->id())->get();

        return view('consulter.dashboard.pages.calender' , compact('calenders'));

    }

    public function calenderPost(CalenderRequest $request ): \Illuminate\Http\RedirectResponse
    {

        $id = Auth::guard('consulter')->id();
        $data = $request->validated();

        $conflict = Calender::where('date', $data['date'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                    ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('start_time', '<=', $data['start_time'])
                            ->where('end_time', '>=', $data['end_time']);
                    });
            })
            ->exists();

        if($conflict){
            $notification = [
                'message' => 'Time is already exist',
                'alert-type' => 'info'
            ];

            return redirect()->route('consulter.calender')->with($notification);
        }
        if(!$conflict ){
            Calender::create([
                'consulter_id' => $id,
                'status'=> 'pending',
                'amount' => $data['amount'],
                'date' => $data['date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
            ]);
        }


        $notification = [
            'message' => 'Time Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('consulter.calender')->with($notification);
    }
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $calender = Calender::find($id)->delete();
        $notification = [
            'message' => 'Time Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('consulter.calender')->with($notification);
    }
}
