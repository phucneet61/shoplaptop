@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê users
    </div>
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
          
            <th>Tên user</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>Author</th>
            <th>Admin</th>
            <th>User</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($admin as $key => $user)
            <form action="{{url('/assign-roles')}}" method="POST">
              @csrf
              <tr>
               
                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                <td>{{ $user->admin_name }}</td>
                <td>
                  {{ $user->admin_email }} 
                  <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
                  <input type="hidden" name="admin_id" value="{{ $user->admin_id }}">
                </td>
                <td>{{ $user->admin_phone }}</td>
                <td>{{ $user->admin_password }}</td>
                <td><input type="checkbox" name="author_role" {{$user->hasRole('author') ? 'checked' : ''}}></td>
                <td><input type="checkbox" name="admin_role"  {{$user->hasRole('admin') ? 'checked' : ''}}></td>
                <td><input type="checkbox" name="user_role"  {{$user->hasRole('user') ? 'checked' : ''}}></td>

              <td>
                  
                    
                <input type="submit" value="Phân quyền" class="btn btn-sm btn-default">
                <a style="margin: 5px 0" class="btn btn-sm btn-danger" onclick="return confirm('Bạn muốn xóa người dùng này không?');" href="{{'delete-user-roles/'.$user->admin_id}}">Xóa user</a>
                <a style="margin: 5px 0" class="btn btn-sm btn-success" href="{{'impersonate/'.$user->admin_id}}">Chuyển quyền</a>
              </td> 

              </tr>
            </form>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection