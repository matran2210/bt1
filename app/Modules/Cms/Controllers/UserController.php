<?php

namespace App\Modules\Cms\Controllers;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Modules\Cms\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Validator;
use Carbon\Carbon;
use Hash;
use Log;
use Illuminate\Support\Facades\Cache;
class UserController extends Controller
{

    public function addUser(Request $request){
        $rules = array(
            'email'    =>  'bail|required|email|unique:user,email',
            'password'     =>  'bail|required|min:3',
            'name' => 'bail|required|min:3',
            'phone' => 'required',
            'address' => 'required',

        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

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
        return redirect()->back()->with('success','Thêm người dùng thành công!');

    }
    public function getViewEditUser(Request $request){
        if($request->ajax()){
            $id = $request->idUser;
            $user = User::findOrFail($id);
            return response()->json(['user' => $user]);
            

        }

    }
    public function editUser(Request $request){
        $rules = array(
            'email'    =>  'bail|required|email|unique:user,email,'.$request->id,
            'name' => 'bail|required|min:3',
            'phone' => 'required',
            'address' => 'required',

        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'name'         =>  $request->get('name'),
            'email'        =>  $request->get('email'),
            'admin_group'        =>  $request->get('admin_group'),
            'phone'       => $request->get('phone'),
            'address'       => $request->get('address'),
            'updated_at'       => Carbon::now()
        );
        User::whereId($request->id)->update($form_data);
        return redirect()->back()->with('success','Sửa thông tin người dùng thành công!');
    }


    public function getListUser(Request $request){
        if($request->ajax()){
            $arr_id = $request->arr_idUser;
                $users = User::findMany($arr_id);
            return response()->json(['users' => $users]);
        }
    }


    public function deleteUser(Request $request){
        if($request->ajax()){
            $arr_id = $request->arr_idUser;
            foreach ($arr_id as $id) {
               $user = User::findOrFail($id);
               $user->is_delete = 1;
               $user->save();
            }
        }
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
        $extension ='';
        if($request->file('file_excel')!=null){
            $extension = strtolower($request->file('file_excel')->getClientOriginalExtension());
        }
        $req = array(
            'file'=>$request->file(),
            'extension' => $extension
        );
        $rules = array(
            'file'          => 'required',
            'extension'      => 'required|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp',
        );
        $error = Validator::make($req, $rules);
        if($error->fails())
        {
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
        }
        $import = Excel::import(new UsersImport, request()->file('file_excel'));
        return redirect()->back()->with('success', 'Success!!!');
    }

}
