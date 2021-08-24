
<table class="table_user table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Created_at</th>
        <th> Action </th>
        <th> <input type="checkbox" class="link_item" id="checkAll" />

    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->status}}</td>
            <td>{{$user->created_at}}</td>
            <td>
                <a href="" class="btn btn-warning edit_user_view" id="{{$user->id}}"><i class="fa fa-pencil" aria-hidden="true"></i> Cập nhật</a>

            </td>
            <td><input type="checkbox" name="user_id[]" class="delete_multiple"  value="{{$user->id}}" /></td>
        </tr>
    @endforeach

    </tbody>
</table>
{{$users->links("pagination::bootstrap-4")}}