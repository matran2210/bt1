@extends('master')

@section('content')

<form action="{{route('add_user_realtime')}}" method="POST"  >
    {{ csrf_field() }}

    <div class="form-group">
        <label>Tên người dùng: </label><span class="text-danger">*</span>
        <input type="text"class="form-control" name="name" required>
        <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
    </div>
    <div class="form-group">
        <label>Email: </label><span class="text-danger">*</span>
        <input type="text"class="form-control" name="email" required>
        <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
    </div>
    <div class="form-group">
        <label>Mật khẩu: </label><span class="text-danger">*</span>
        <input type="text"class="form-control" name="password" required>
        <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
    </div>

    <div class="form-group">
        <label style="margin-right: 30px">Admin Group: </label>
        <label class="form-check-label font-weight-bold" style="margin-right: 50px">
            <input  type="radio" class="form-check-input" name="admin_group" value="1">Yes
        </label>
        <label class="form-check-label font-weight-bold">
            <input type="radio" class="form-check-input" name="admin_group" value="0" checked>No
        </label>
    </div>
    <div class="form-group">
        <label>Địa chỉ: </label><span class="text-danger">*</span>
        <input type="text"class="form-control" name="address" required>
        <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
    </div>
    <div class="form-group">
        <label>Số điện thoại: </label><span class="text-danger">*</span>
        <input type="text"class="form-control" name="phone" required>
        <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
    </div>

    <div  class="form-group">
        <input type="submit" class="button_add btn btn-info" value="Thêm người dùng">
    </div>
    <br>
</form>

@endsection