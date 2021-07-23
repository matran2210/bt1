
<table style="font-size: 13px">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Created_at</th>
        <th>Updated_at</th>
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
            <td>{{$user->updated_at}}</td>
             </tr>
    @endforeach

    </tbody>
</table>
