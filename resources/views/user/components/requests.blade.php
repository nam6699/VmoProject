@if(session('UserRequest'))
    @php
        $UserRequest = session('UserRequest');
        $item = $UserRequest->items;
        $totalQty = $UserRequest->totalQty;
    @endphp
<div class="container-lg">
<table class="contact-form">
  <tr>
    <th>name</th>
    <th>quanity</th>
    <th>quanity available</th>
  </tr>
  @foreach($item as $value)
  <trs>
    <td>{{$value['item']->name}}</td>
    <td class="cart_quantity text-center">
        <div class="">
            <input  min="1" class="cart-plus-minus item-qty" data-id="{{ $value['item']->id }}" data-num="{{$value['qty']}}" data-itemQty="{{$value['item']->quanity}}" type="number" name="qty" value="{{$value['qty']}}">
        </div>
    </td>
    <td class="cart_quantity text-center">
        <span>{{$value['item']['quanity']}}</span>
    </td>
    <td class="cart-delete text-center">
          <a data-id="{{$value['item']->id }}" href="javascript:void(0)"class="cart_quantity_delete remove-to-cart" title="Xóa sản phẩm">Delete</a>
    </td>
</tr>
  @endforeach
</table>
</div>
@section('my_javascript')
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
                                $('#my-request').html(response.data);
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
                const item_id = $(this).attr('data-id');
                const before_qty = Number($(this).attr('data-num')); // số lượng trước khi thay đổi
                const itemQty = Number($(this).attr('data-itemQty'));
                const qty = Number($(this).val());
                if (qty <= 0) {
                    alert('Nhập số lượng phải lớn hơn 0');
                    $(this).val(before_qty); // set lại giá trị
                    return false;
                }else if (qty > itemQty) {
                    alert('not enough quanity available');
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
                            $('#my-request').html(response.data);
                        }
                    },
                    error: function (e) { // lỗi nếu có
                        console.log(e.message);
                    }
                });
            });
        })
    </script>
    @endsection
    @endif