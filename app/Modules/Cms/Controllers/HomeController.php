<?php

namespace App\Modules\Cms\Controllers;
use App\Modules\Cms\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\SendEmail;
use DB;
use Session;
use Barryvdh\DomPDF\Facade as PDF;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('is_delete',0)->paginate(4);
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
            //filter bằng Trait tạo trong app\Traits\Filterable.php
            $users = User::where('is_delete',0)->filter($params)->orderBy('id', 'DESC')->paginate(4);
            Cache::put('result_filter', $users, 600);
            return view('user.data-home',compact('users'));
        }
        return view('user.home',compact('users'));
    }

    public function exportExcel(){
        $params = Session('params')?Session::get('params'):null;
        return Excel::download(new UsersExport($params), 'users.xlsx');
    }
    public function exportPDF(){
        $params = Session('params')?Session::get('params'):null;
        $users = User::where('is_delete',0)->filter($params[0])->get();
        $pdf = PDF::loadView('user.data-pdf',  compact('users'));
        return $pdf->download('users.pdf');

    }
    public function importExcel(Request $request){
        $import = Excel::import(new UsersImport, request()->file('file_excel'));
        return redirect()->back()->with('success', 'Success!!!');
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
