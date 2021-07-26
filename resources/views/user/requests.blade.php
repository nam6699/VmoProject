<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{asset('css/app.css')}}">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
<form method="post" action="{{ route('request.checkout') }}">
 @csrf
<h2>HTML Table</h2>
<div >
<table>
  <tr>
    <th>name</th>
    <th>quanity</th>
  </tr>
  @foreach($item as $value)
  <tr id="item-delete">
    <td>{{$value['item']->name}}</td>
    <td class="cart_quantity text-center">
        <div class="">
            <input id="item-update" min="1" class="cart-plus-minus item-qty" data-id="{{ $value['item']->id }}" data-num="{{$value['qty']}}" type="number" name="qty" value="{{$value['qty']}}">
        </div>
    </td>
    <td class="cart-delete text-center">
          <a data-id="{{$value['item']->id }}" href="javascript:void(0)"class="cart_quantity_delete remove-to-cart" title="Xóa sản phẩm">Delete</a>
    </td>
</tr>
  @endforeach
</table>
<div class="returne-continue-shop">
    <a href="{{ route('destroy.request') }}" class="continueshoping"><i class="fa fa-chevron-left"></i>Cancel</a>
     <button type="submit" class="procedtocheckout">Send Request</button> 
</div>
</div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
        $(function () {
            // xóa sản phẩm khỏi giỏ hàng
            $(document).on("click", '.remove-to-cart', function () {
                var result = confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng ?");
                if (result) {
                    var item_id = $(this).attr('data-id');
                    $.ajax({
                        url: 'request/remove-request/' + item_id,
                        type: 'get',
                        data: {
                            id : item_id
                        }, // dữ liệu truyền sang nếu có
                        dataType: "json", // kiểu dữ liệu trả về
                        success: function (response) {
                            console.log(response);
                        // success
                        if (response.status == true) {
                            $('#item-delete').html(response.data);
                        }
                        },
                        error: function (e) { // lỗi nếu có
                            console.log(e.message);
                        }
                    });
                }
            });
            // cập nhật số lượng giỏ hàng
            //$('.item-qty').change(function () {
            $(document).on("change", '.item-qty', function () {
                var item_id = $(this).attr('data-id');
                var before_qty = $(this).attr('data-num'); // số lượng trước khi thay đổi
                var qty = $(this).val();
                if (qty <= 0) {
                    alert('Nhập số lượng phải lớn hơn 0');
                    $(this).val(before_qty); // set lại giá trị
                    return false;
                }
                $.ajax({
                    url: 'request/update-request',
                    type: 'get',
                    data: {
                        id : item_id,
                        qty : qty
                    }, // dữ liệu truyền sang nếu có
                    dataType: "json", // kiểu dữ liệu trả về
                    success: function (response) {
                        console.log(response);
                        // success
                        if (response.status == true) {
                            $('#item-update').html(response.data);
                        }
                    },
                    error: function (e) { // lỗi nếu có
                        console.log(e.message);
                    }
                });
            });
        })
    </script>

</body>
</html>
