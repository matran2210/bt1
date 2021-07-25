<?php

namespace App\Modules\Cms\Controllers;
use App\Modules\Cms\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use DB;
use Session;
use Validator;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    public function index(Request $request)
    {
       // $users = User::where('is_delete',0)->orderBy('id', 'DESC')->paginate(4);

        if($request->ajax()){
            $params = [
                'name--like' => $request->name,
                'email--like' => $request->email,
                'status' => $request->status,
                'created_at--date' => $request->created_at,
            ];
            if(Session::has('params')){
                Session::forget('params');
            }
            Session::push('params', $params);


            //cache
            if($request->name==''){
                $users = User::where('is_delete',0)->filter($params)->orderBy('id', 'DESC')->paginate(4);

            }else {
                $page = request()->get('page', 1);
                $users = Cache::remember($request->name . $page, 600, function () use ($params) {
                    return User::where('is_delete', 0)->filter($params)->orderBy('id', 'DESC')->paginate(4);
                });

            }
            return view('user.data-home',compact('users'));
        }
        return view('user.home');
    }

    public function sendEmail(Request $request){
        $str = $request->list_email_hidden;
        $listEmail = explode("-",$str);
        $subject  =  $request->subject;
        $message = $request->message;

        SendEmail::dispatch($listEmail, $subject,$message)->delay(now()->addMinute(1));
        return redirect()->back();

    }



}
