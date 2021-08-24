<?php

namespace App\Modules\User\Cms\Controllers;
use App\Modules\User\Cms\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use DB;
use Hash;
use Log;
use Session;
use Validator;
use Google\Cloud\BigQuery\BigQueryClient;
use SchulzeFelix\BigQuery\BigQueryFacade;
use App\Events\DemoPusherEvent;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    public function index(Request $request)
    {
//        $bigquery = new BigQueryClient();
//        $bigquery->dataset('bt1')->table('user')->exists();
//        $rawQuery = ' SELECT *   FROM `bt1.user` WHERE id = 2';
//        // $rawQuery= "INSERT INTO `bt1.user` (`id`,`name`, `address`) VALUES(3,'Toan','QN')";
//        $queryJobConfig = $bigquery->query($rawQuery);
//        $result = $bigquery->runQuery($queryJobConfig);
//        foreach ($result as $row) {
//            echo ($row['name']);
//            echo '<br>';
//            echo ($row['address']);
//        }


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

    public function getViewAddUserRealtime(){

        return view('user.add_realtime');

    }
    public function addUserRealtime(Request  $request){

        $form_data = array(
            'name'         =>  $request->get('name'),
            'email'        =>  $request->get('email'),
            'password'         => Hash::make($request->get('password')),
            'phone'       => $request->get('phone'),
            'address'       => $request->get('address'),
            'admin_group'       => $request->get('admin_group'),
            'is_delete'       => 0,
            'status'       => 'offline',
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        );
        User::create($form_data);
        Log::info('User: '.$request->get('name').' was created!', $form_data);

        //event
        $message = 'New User was created!';
        event(new DemoPusherEvent($message));


        return redirect()->back()->with('success','Thêm người dùng thành công!');
    }


}
