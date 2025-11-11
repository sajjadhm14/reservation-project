<?php

namespace App\Http\Controllers\Consulter\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consulter\Dashboard\ConsulterCalenderRequest;
use App\Models\Calender;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $calenders = Calender::getCalenderData();

        return view('consulter.dashboard.pages.calender' , compact('calenders'));

    }

    /**
     * @param ConsulterCalenderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function calenderPost(ConsulterCalenderRequest $request ): \Illuminate\Http\RedirectResponse
    {

        $id = Auth::guard('consulter')->id();
        $data = $request->validated();

        $conflict = Calender::checkCalenderConflict($id , $data);

        if($conflict){
            $notification = [
                'message' => 'Time is conflicted with existing time',
                'alert-type' => 'warning'
            ];

            return redirect()->route('consulter.calender')->with($notification);
        }

       $this->createCalender($id , $data);

        $notification = [
            'message' => 'Time Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('consulter.calender')->with($notification);



    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    private function createCalender($id , $data)
    {
        $calenderCreate=Calender::create([
            'consulter_id' => $id,
            'status'=> 'pending',
            'amount' => $data['amount'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
        return $calenderCreate;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $calender=Calender::find($id);

        if($calender->status === 'Approved')
            {
                $notification = [
                    'message' => 'fekkkkk nakonam ! ',
                    'alert-type' => 'error'
                ];
                return redirect()->route('consulter.calender')->with($notification);
            }



        $calender->delete();
        $notification = [
            'message' => 'Time Deleted Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('consulter.calender')->with($notification);
    }



}
