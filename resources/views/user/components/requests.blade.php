@if(session('UserRequest'))
    @php
        $UserRequest = session('UserRequest');
        $item = $UserRequest->items;
        $totalQty = $UserRequest->totalQty;
    @endphp
          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
            @if (session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
            @endif
              <thead>
                <tr>
                  <th scope="col" class="border-0 bg-light">
                    <div class="p-2 px-3 text-uppercase">Tools</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">quanity</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Quantity available</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Remove</div>
                  </th>
                </tr>
              </thead>
              <tbody>
              @foreach($item as $value)
                <tr>
                  <th scope="row" class="border-0">
                    <div class="p-2">
                      <img src="{{asset('images/'.$value['item']->image)}}" alt="" width="70" class="img-fluid rounded shadow-sm">
                      <div class="ml-3 d-inline-block align-middle">
                        <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">{{$value['item']->name}}</a></span>
                      </div>
                    </div>
                  </th>
                  <td class="border-0 align-middle"><strong> <input  min="1" class="cart-plus-minus item-qty" data-id="{{ $value['item']->id }}" data-num="{{$value['qty']}}" data-itemQty="{{$value['item']->quanity}}" type="number" name="qty" value="{{$value['qty']}}"></strong></td>
                  <td class="border-0 align-middle"><strong>{{$value['item']['quanity']}}</strong></td>
                  <td class="border-0 align-middle"><a data-id="{{$value['item']->id }}" href="javascript:void(0)" class="cart_quantity_delete remove-to-cart"  class="text-dark"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- End -->
          <div class="container-lg">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="contact-form">
                                @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row py-5 p-4 bg-white rounded shadow-sm">
                <div class="col-lg-6">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Send Email</div>
                    <div class="p-4">
                        <div class="row">
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inputName">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                    @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inputEmail">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email" value="namnpp@vmodev.com">
                                    @error('email')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSubject">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Enter subject">
                            @error('subject')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMessage">Message</label>
                            <textarea name="content" rows="5" class="form-control" placeholder="Enter Your Message"></textarea>
                            @error('content')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>         
                    </div>
                    <div class="col-lg-6">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Request summary </div>
                    <div class="p-4">
                        <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
                        <ul class="list-unstyled mb-4">
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong>$390.00</strong></li>
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Shipping and handling</strong><strong>$10.00</strong></li>
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>$0.00</strong></li>
                        <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total Quanity</strong>
                            <h6 class="font-weight-bold">{{$totalQty}}</h6>
                        </li>
                        </ul>
                        <button type="submit" class="btn btn-dark rounded-pill py-2 btn-block">Send Request</button> 
                        <a class="btn btn-danger rounded-pill py-2 btn-block" href="{{ route('destroy.request') }}" class="continueshoping">Cancel</a>
                    </div>
                    </div>
                </div>
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