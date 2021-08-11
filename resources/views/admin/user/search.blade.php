@extends('admin.layouts.main')
@section('content')
<form action="{{url('admin/user/search')}}" method='get'>
    <div class="search-form">
                <div class="search-input-group rounded">
                <input type="search" class="form-control rounded" name="search" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
                <button class="input-group-text border-0" type="submit" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
                </div>
    </div>
    <div class="p-2" style="text-align:center;">
    <h5> Search keyword: "{{$search}}" ({{$totalResult}})</h5>
    </div>
    <!-- /.content-header -->
    <div class="d-flex flex-start">
      <a href="{{route('user.create')}}" class="nav-link btn btn-success" style="width:120px;" ><span class="mr-2">CREATE</span><i class="fas fa-plus"></i></a>
      <div class="request_status" style="width:150px;">
      <select name="" id="role" class="form-control">
        <option {{( $role == ''  ? 'selected' : '') }} value="0">all</option>
        <option {{( $role == 'user' ? 'selected' : '') }} value="user">user</option>
        <option {{( $role == 'admin' ? 'selected' : '') }} value="admin">admin</option>
        <option {{( $role == 'superadmin' ? 'selected' : '') }} value="superadmin">super admin</option>
      </select>
      </div>
  </div>
    
    <!-- Main content -->
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">email</th>
            <th scope="col">action</th>
        </thead>
        <tbody>
          @foreach($data as $value)
          <tr class="user-{{ $value->id }}">
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->email}}</td>
            <td>
              <a href="{{route('user.edit', ['user'=>$value->id])}}" class="btn btn-primary">Edit</a>
              <a data-id="{{$value->id }}" href="javascript:void(0)" class="remove-to-cart btn btn-danger" class="text-dark">Delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @if($role == 0)
      {{ $data->appends(['role'=>$role])->links() }}
      @else
      {{ $data->appends(['search'=>$search,'role'=>$role])->links() }}
      @endif
          <!-- /.content -->
        <!-- /.content-wrapper -->




@endsection
@section('my_javascript')
<script type="text/javascript">

        $(function () {
    
          // xóa sản phẩm khỏi giỏ hàng
            $(document).on("click", '.remove-to-cart', function () {
                var result = confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng ?");
                if (result) {
                    var id = $(this).attr('data-id');
                    $.ajax({
                      type: 'delete',
                      dataType: 'json',
                      data: {
                        "_token": "{{ csrf_token() }}",
                        id : id,
                        },
                      url: " admin/user/" + id,
                        success: function (response) {
                        console.log(response);
                          if (response.status != 'undefined' && response.status == true) {
                          // xóa dòng vừa được click delete
                          $('.user-'+id).closest('tr').remove(); // class .item- ở trong class của thẻ td đã khai báo trong file index
                          }
                        },
                        error: function (e) { // lỗi nếu có
                            console.log(e.message);
                        }
                    });
                }
            });
            var pathname = window.location.pathname; // 
          var urlParams = new URLSearchParams(window.location.search); // khoi tao
          $(document).on("change", '#role', function () {
                var status = $(this).val();
                if (status) {
                  if (status == '0') {
                    urlParams.delete('role');
                  } else {
                    urlParams.set('role', status);
                  }
                  window.location.href = pathname + "?"+decodeURIComponent(urlParams.toString());
                }
            });
          })
    </script>



@endsection