<?php

namespace App\Modules\Cms\Controllers;
use App\Modules\Cms\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
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

}
