<?php

namespace App\Exports;

use App\Modules\Cms\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $params;
    public function __construct($params)
    {
        $this->params = $params;
    }
    public function collection()
    {
       $users =   User::where('is_delete',0)->filter($this->params[0])->orderBy('id','DESC')->get();
        $output = [];
        //lọc ra các cột cần đưa vào excel
        foreach ($users as $user)
        {

            $output[] = [
                $user->name,
                $user->email,
                $user->phone,
                $user->address,
                (string)$user->admin_group,
                (string)$user->is_delete,
                $user->status,
                $user->created_at,
                $user->updated_at
            ];

        }
        return collect($output);
    }
    //Thêm hàng tiêu đề cho bảng
    public function headings(): array
    {
        return [
            'Tên tài khoản',
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Admin_Group',
            'Is_Delete',
            'Trạng thái',
            'Ngày tạo',
            'Ngày cập nhật'
        ];
    }

}
