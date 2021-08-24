<?php

namespace App\Imports;

use App\Modules\User\Cms\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{

    public function headingRow() : int
    {
        return 1;
    }

    public function model(array $row)
    {
        return new User([
            'name' => $row['name'] ?? $row['ten_tai_khoan'],
            'email' => $row['email'],
            'status' => $row['status'] ?? $row['trang_thai'],
            'phone'  => $row['phone'] ?? $row['so_dien_thoai'],
            'address' => $row['address'] ?? $row['dia_chi'],
            'password' => Hash::make(123),
            'is_delete' => $row['is_delete'] ?? $row['is_delete'],
            'admin_group' =>$row['admin_group'] ?? $row['admin_group'],
            'created_at' => $row['created_at'] ?? $row['ngay_tao'],
            'updated_at' => $row['updated_at'] ?? $row['ngay_cap_nhat']


        ]);
    }
}
