@extends('admin.layouts.main')
@section('content')

    <!-- /.content-header -->
    <form action="{{url('admin/user/search')}}" method='get'>
                <div class="input-group rounded">
                <input type="search" class="form-control rounded" name="search" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
                <button class="input-group-text border-0" type="submit" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
                </div>
    </form>
    <!-- Main content -->
    <a href="{{route('user.create')}}" class="nav-link">Create</a>
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">email</th>
            <th scope="col">action</th>
        </thead>
        <tbody>
          @foreach($user as $value)
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
      {{ $user->links() }}
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
          })
    </script>



@endsection
