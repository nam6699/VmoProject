@extends('admin.layouts.main')
@section('content')

          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">email</th>
            <th scope="col">total Quanity</th>
            <th scope="col">status</th>
            <th scope="col">Action</th>
        </thead>
        <tbody>
          @foreach($data as $value)
          <tr class="request-{{ $value->id }}">
            <td>{{$value->id}}</td>
            <td>{{$value->user_email}}</td>
            <td>{{$value->totalQty}}</td>
            <td>
            @if ($value->status_id === 1)
                    <span class="label label-info">New</span>
                @elseif ($value->status_id === 2)
                    <span class="label label-warning">accepted</span>
                @elseif ($value->status_id === 3)
                    <span class="label label-danger">Finished</span>
                @elseif ($value->status_id === 4)
                    <span class="label label-danger">Cancled</span>
                @else
                <span class="label label-danger">Returning</span>
            @endif
            </td>
            <td>
              <a href="{{route('request.edit', ['request'=>$value->id])}}" class="btn btn-primary">Detail</a>
              <a data-id="{{$value->id }}" href="javascript:void(0)" class="remove-to-cart btn btn-danger" class="text-dark">delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $data->links() }}
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
                      url: " admin/request/" + id,
                        success: function (response) {
                        console.log(response);
                        // success
                          if (response.status != 'undefined' && response.status == true) {
                          // xóa dòng vừa được click delete
                          $('.request-'+id).closest('tr').remove(); // class .item- ở trong class của thẻ td đã khai báo trong file index
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