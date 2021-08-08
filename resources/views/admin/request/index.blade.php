@extends('admin.layouts.main')
@section('content')
<div class="request_status" style="width:100px;">
  <select name="" id="statusId" class="form-control">
   
      <option {{( $filter == ''  ? 'selected' : '') }} value="0">all</option>
      <option {{( $filter == '1' ? 'selected' : '') }} value="1">New</option>
      <option {{( $filter == '2' ? 'selected' : '') }} value="2">Accepted</option>
      <option {{( $filter == '3' ? 'selected' : '') }} value="3">Finished</option>
      <option {{( $filter == '4' ? 'selected' : '') }} value="4">Cancel</option>
      <option {{( $filter == '5' ? 'selected' : '') }} value="5">Returning</option>
  </select>

</div>
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
          <tr id="my-table" class="request-{{ $value->id }}">
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
              <a data-id="{{$value->id }}" href="javascript:void(0)" class="remove-to-cart btn btn-danger">delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @if($filter == 0)
      {{ $data->links() }}
      @endif
          <!-- /.content -->
        <!-- /.content-wrapper -->


@endsection

@section('my_javascript')
<script type="text/javascript">
     
        $(function () {
          // xóa sản phẩm khỏi request
            $(document).on("click", '.remove-to-cart', function () {
                var result = confirm("Bạn có chắc chắn muốn xóa ?");
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
          var pathname = window.location.pathname; // 
          var urlParams = new URLSearchParams(window.location.search); // khoi tao
          $(document).on("change", '#statusId', function () {
                var status = $(this).val();
                if (status) {
                  if (status == '0') {
                    urlParams.delete('status');
                  } else {
                    urlParams.set('status', status);
                  }
                  window.location.href = pathname + "?"+decodeURIComponent(urlParams.toString());
                }
            });
    </script>
    @endsection