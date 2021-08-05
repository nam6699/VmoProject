@extends('admin.layouts.main')
@section('content')


    <!-- /.content-header -->

    <!-- Main content -->
    <form action="{{url('admin/tool/search')}}" method='get'>
                <div class="input-group rounded">
                <input type="search" class="form-control rounded" name="search" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
                <button class="input-group-text border-0" type="submit" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
                </div>
    </form>
    @can('edit tools')
    <a href="{{route('tool.create')}}" class="nav-link">Create</a>
    @endcan
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Quanity</th>
            @can('edit tools')
            <th scope="col">Action</th>
            @endcan
        </thead>
        <tbody>
          @foreach($tool as $value)
          <tr class="tool-{{ $value->id }}">
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td><img src="{{asset('images/'.$value->image)}}" alt="" width=50 height=50></td>
            <td>{{$value->quanity}}</td>
            @can('edit tools')
            <td>
              <a href="{{route('tool.edit', ['tool'=>$value->id])}}" class="btn btn-primary">Edit</a>
                
            <a data-id="{{$value->id}}" href="javascript:void(0)" class="remove-to-cart btn btn-danger" class="text-dark ">Delete</a>
            </td>
            @endcan
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $tool->links() }}
      
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
                      url: " admin/tool/" + id,
                        success: function (response) {
                        console.log(response);
                        // success
                          if (response.status != 'undefined' && response.status == true) {
                          // xóa dòng vừa được click delete
                          $('.tool-'+id).closest('tr').remove(); // class .item- ở trong class của thẻ td đã khai báo trong file index
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
