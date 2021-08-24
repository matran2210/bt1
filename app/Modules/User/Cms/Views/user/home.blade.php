@extends('master')

@section('content')
    <h2 style="text-align: center" class="text-danger font-weight-bold">Danh sách người dùng</h2> <br>
    <div class="alert" style="width: 500px;margin-left: 500px">
    @if(Session::has('errors'))
        <div class="alert alert-danger" >
            @foreach (Session::get('errors') as $error)
                {{$error}} <br>
            @endforeach

        </div>
    @elseif(Session::has('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif

    </div>
    <div class="d-flex justify-content-end">
        <a href="{{route('index')}}"  class="btn btn-danger mb-3 ml-1"> <i class="fa fa-refresh" aria-hidden="true"></i> Tải lại trang</a>
        <button class=" mb-3 ml-1 btn btn-primary"  data-toggle="modal" data-target="#add_user"><i class="fa fa-plus-square" aria-hidden="true"></i> Thêm</button>
        <button class="mb-3 ml-1 btn btn-success"  data-toggle="modal" data-target="#import_excel"><i class="fa fa-upload" aria-hidden="true"></i> Nhập</button>


        <form method="get" action="{{ route('export_excel') }}">
            <button class="mb-3 ml-1 btn btn-info"  type="submit" name="export_excel"> <i class="fa fa-download" aria-hidden="true"></i> Xuất Excel</button>

        </form>
        <form method="get" action="{{ route('export_pdf') }}">
            <button class="mb-3 ml-1 btn btn-info"  type="submit" name="export_pdf"> <i class="fa fa-download" aria-hidden="true"></i> Xuất PDF</button>

        </form>
        <button class="mb-3 ml-1 btn btn-danger" id="btn_send_email"><i class="fa fa-envelope" aria-hidden="true"></i> Gửi Email</button>

        <button class="mb-3 ml-1 btn btn-secondary"  id="btn_delete_multiple"> <i class="fa fa-trash" aria-hidden="true"></i> Xóa</button>

        <a href="{{route('get_view_add_user_realtime')}}" class="mb-3 ml-1 btn btn-secondary"  id="add_realtime"> <i class="fa fa-info" aria-hidden="true"></i> Add</a>




    </div>




{{--   content--}}
    <div class="user_dashboard d-flex justify-content-start">
    <div class="filter_user" style="margin-right: 50px">


{{--        <form action="" method="">--}}

        <div class="form-group">
            <span class="text-danger font-weight-bold">Lọc theo tên:</span>
            <input class="form-control" type="text" name="name" placeholder="input name...">
        </div>
        <div class="form-group">
            <span class="text-danger font-weight-bold">Lọc theo email:</span>
            <input class="form-control" type="text" name="email" placeholder="input email...">
        </div>
        <span class="text-danger font-weight-bold">Lọc theo status:</span>
        <div class="form-check">

            <label class="form-check-label font-weight-bold" style="margin-right: 20px">
                <input  type="radio" class="form-check-input" name="status" value="online">Online
            </label>
            <label class="form-check-label font-weight-bold">
                <input type="radio" class="form-check-input" name="status" value="offline">Offline
            </label>
        </div>
        <div class="form-group">
            <span class="text-danger font-weight-bold">Lọc theo thời gian tạo:</span>
            <input class="form-control" type="date" name="created_at">
        </div>
            <input class="form-control btn btn-danger btn_filter" type="submit" value="Lọc">

{{--        </form>--}}
    </div>


    <div id="result" style="width: 1000px">

    </div>

        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
        <input type="hidden" name="hidden_name" id="hidden_name" value="" />
        <input type="hidden" name="hidden_email" id="hidden_email" value="" />
        <input type="hidden" name="hidden_status" id="hidden_status" value="" />
        <input type="hidden" name="hidden_created_at" id="hidden_created_at" value="" />

    </div>


{{--    //import excel modal--}}
    <div class="modal fade" id="import_excel">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-info">Nhập danh sách user </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{route('import_excel')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input accept=".xlsx, .xls, .csv, .ods" type="file" name="file_excel"/>


                        <br>
                        <br>
                        <button style="margin-left: 130px" type="submit" class="import_excel btn btn-info"> Nhập danh sách </button>




                    </form>
                </div>


            </div>
        </div>
    </div>
{{--    //add_user modal--}}
    <div class="modal fade" id="add_user">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-info">Thêm người dùng vào danh sách </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('add_user')}}" method="POST"  >
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
                </div>


            </div>
        </div>
    </div>
    {{--    //edit_user modal--}}
    <div class="modal fade" id="edit_user">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-info">Sửa thông tin người dùng </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('edit_user')}}" method="POST"  >
                        {{ csrf_field() }}
                        <input type="hidden" class="id_user"  name="id" value="">
                        <div class="form-group">
                            <label>Tên người dùng: </label><span class="text-danger">*</span>
                            <input type="text"class="form-control name_user" name="name" required>
                            <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
                        </div>
                        <div class="form-group">
                            <label>Email: </label><span class="text-danger">*</span>
                            <input type="text"class="form-control email_user" name="email" required>
                            <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
                        </div>
                        <div class="form-group">
                            <label style="margin-right: 30px">Admin Group: </label>
                            <label class="form-check-label font-weight-bold" style="margin-right: 50px">
                                <input  type="radio" class="form-check-input" name="admin_group" value="1">Yes
                            </label>
                            <label class="form-check-label font-weight-bold">
                                <input type="radio" class="form-check-input" name="admin_group" value="0">No
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ: </label><span class="text-danger">*</span>
                            <input type="text"class="form-control address_user" name="address" required>
                            <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại: </label><span class="text-danger">*</span>
                            <input type="text"class="form-control phone_user" name="phone" required>
                            <div class="invalid-feedback">Không được bỏ trống thông tin này</div>
                        </div>

                        <div  class="form-group">
                            <input type="submit" class="button_add btn btn-info" value="Cập nhật thông tin">
                        </div>
                        <br>
                    </form>
                </div>


            </div>
        </div>
    </div>
{{--    //send email modal--}}
    <div class="modal fade" id="send_email">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-info">Nhập thông tin cần gửi </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{route('send_email')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <span class="text-danger font-weight-bold">Gửi đến:</span>
                            <div style="position: relative;font-weight: bold" id="list_user_to"><br>
                            </div>
                            <input type="hidden" name="list_email_hidden" id="list_email_hidden" value="">
                        </div>
                        <div class="form-group">
                            <span class="text-danger font-weight-bold">Tiêu đề:</span>
                            <input class="form-control" type="text" name="subject" placeholder="Nhập tiêu đề">
                        </div>
                        <div class="form-group">
                            <span class="text-danger font-weight-bold">Nội dung:</span>
                            <textarea class="form-control" type="text"
                                      name="message" rows="3"> </textarea>
                        </div>


                        <button style="margin-left: 180px" type="submit" class="brn_send_email btn btn-info"> Gửi thư </button>




                    </form>
                </div>


            </div>
        </div>
    </div>


{{--    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>--}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        $(document).ready(function(){
            fetch_data();
            // Enable pusher logging - don't include this in production
            // Pusher.logToConsole = true;
            // var pusher = new Pusher('f9f82a600cf77c2c77e0', {
            //     cluster: 'ap1'
            // });
            // var channel = pusher.subscribe('my-channel');
            // channel.bind('my-event', function(data) {
            //     if(data.message = 'New User was created!'){
            //         alert(data.message);
            //         fetch_data(); //ajax load lại dữ liệu bảng user
            //     }
            // });






            function fetch_data(page=1,name='',email='',status='',created_at='') {
                $.ajax({
                    url: "/",
                    method: 'GET',
                    data:{
                        'page':page,
                        'name': name,
                        'email': email,
                        'status': status,
                        'created_at': created_at,
                    },
                    dataType: 'html',
                    success: function (data) {
                        $('div#result').html('');
                        $('div#result').html(data);
                    }
                })
            }

            $('#btn_send_email').click(function(e){
                e.preventDefault();
                    var arr_idUser = [];
                    $(':checkbox:checked').each(function(i){
                        arr_idUser[i] = $(this).val(); //lấy value của tất cả nút check bao gồm cả checkAll
                    });
                    if(arr_idUser[0]=='on'){ //nếu phần tử đầu tiên là value của nút checkAll
                        arr_idUser.shift(); //bỏ phần tử đầu tiên đi
                    }
                    if(arr_idUser.length === 0)
                    {
                        alert("Chưa chọn người nào để gửi");
                    }
                    else {

                        $.ajax({
                            url:"/get-list-user",
                            method: "GET",
                            data: {
                                arr_idUser:arr_idUser,
                            },
                            success: function (data) {
                                var str='',list_email='';
                                $.each(data.users, function(index, value) {
                                    str+=value.name+', ';
                                    list_email+=value.email+'-';

                                });
                                $('#list_user_to').html(str);
                                $('#list_email_hidden').val(list_email);

                                $('#send_email').modal('show');

                            }

                        })
                    }



            });

            $(document).on('click', '.edit_user_view', function(e){
                e.preventDefault();
                var idUser = $(this).attr('id');
                $.ajax({
                    url:"/get-view-edit-user",
                    method:"get",
                    data:{
                        idUser:idUser,
                    },
                    dataType:"json",
                    success:function(data)
                    {
                        $('.id_user').val(data.user.id);
                        $('.email_user').val(data.user.email);
                        $('.phone_user').val(data.user.phone);
                        $('.address_user').val(data.user.address);
                        $('.name_user').val(data.user.name);
                        $("input[name=admin_group" + "][value=" + data.user.admin_group + "]")
                            .prop('checked', true); //đặt checked cho nút radio

                        $('#edit_user').modal('show');

                    }
                });

            });




            // tất cả thành phần được ajax load thì phải đợi ajax load_data xong mới được
            $( document ).ajaxComplete(function() {

                $("#checkAll").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
                 });


            });


            $('#btn_delete_multiple').click(function(e){
                 e.preventDefault();
                var arr_idUser = [];
                $(':checkbox:checked').each(function(i){
                    arr_idUser[i] = $(this).val(); //lấy value của tất cả nút check bao gồm cả checkAll
                });
                if(arr_idUser[0]=='on'){ //nếu phần tử đầu tiên là value của nút checkAll
                    arr_idUser.shift(); //bỏ phần tử đầu tiên đi
                }
                if(arr_idUser.length === 0)
                {
                    alert("Chưa tích chọn user nào");
                }
                else {
                if(confirm("Bạn muốn xóa thật không?"))
                {
                        $.ajax({
                            url:"/delete-user",
                            method: "POST",
                            data: {
                                arr_idUser:arr_idUser,
                            },
                            success: function (data) {
                                //get
                                var page=$('#hidden_page').val();
                                var name = $('#hidden_name').val();
                                var email =  $('#hidden_email').val();
                                var status = $('#hidden_status').val();
                                var created_at =$('#hidden_created_at').val();
                                fetch_data(page,name,email, status,created_at);
                            }
                        })
                    }
                else
                {
                    return false;
                }
                }
            });
            $(document).on('click', '.btn_filter',function(event)
            {
                event.preventDefault();
                //get
                var status=$('input[name="status"]:checked').val();
                var name = $("[name='name']").val();
                var email = $("[name='email']").val();
                var created_at = $("[name='created_at']").val();
               // var page = $('#hidden_page').val();
                var page = 1; //đặt lại page =1 chứ  k nên lấy ra page hiện tại

                //set
                $('#hidden_page').val(page); //đặt lại page =1 mỗi khi filter
                $('#hidden_name').val(name);
                $('#hidden_email').val(email);
                $('#hidden_status').val(status);
                $('#hidden_created_at').val(created_at);


                fetch_data(page,name,email, status,created_at);
            });
            $(document).on('click', '.pagination a',function(event)
            {
                event.preventDefault();
                //get
                var page=$(this).attr('href').split('page=')[1];
                var name = $('#hidden_name').val();
                var email =  $('#hidden_email').val();
                var status = $('#hidden_status').val();
                var created_at =$('#hidden_created_at').val();
                //set
                $('#hidden_page').val(page);

                fetch_data(page,name,email, status,created_at);
            });


        });
    </script>
 
@endsection