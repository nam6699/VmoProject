@if(session('UserRequest'))
    @php
        $UserRequest = session('UserRequest');
        $item = $UserRequest->items;
        $totalQty = $UserRequest->totalQty;
    @endphp
          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table table-request">
            @if (session('msg'))
                    <div class="alert alert-success" role="alert">
                        {{ session('msg') }}
                    </div>
            @endif
            @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
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
            <div class="d-flex justify-content-end">
            <div><span>Total Quanity: {{$totalQty}}</span></div>
            </div>
          </div>
          <!-- End -->
         
@section('my_javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript">
        $(function () {
            // Delete items from form request
            $(document).on("click", '.remove-to-cart', function () {
                var result = confirm("Are you sure you want to delete this item?");
                if (result) {
                    var item_id = $(this).attr('data-id');
                    $.ajax({
                        url: 'request/remove-request/' + item_id,
                        type: 'get',
                        data: {
                            id : item_id
                        }, // send data
                        dataType: "json", // return back data
                        success: function (response) {
                        console.log(response);
                        // success
                            if (response.status == true) {
                                $('#my-request').html(response.data);
                            }
                        },
                        error: function (e) { // error
                            console.log(e.message);
                        }
                    });
                }
            });
            // update item quanity
            //$('.item-qty').change(function () {
            $(document).on("change", '.item-qty', function () {
                const item_id = $(this).attr('data-id');
                const before_qty = Number($(this).attr('data-num')); // quanity before update
                const itemQty = Number($(this).attr('data-itemQty'));
                const qty = Number($(this).val());
                if (qty <= 0) {
                    alert('The quanity cannot be smaller than 0');
                    $(this).val(before_qty); // set back quanity
                    return false;
                }else if (qty > itemQty) {
                    alert('not enough quanity available');
                    $(this).val(before_qty); // set back quanity
                    return false;
                  }
                $.ajax({
                    url: 'request/update-request',
                    type: 'get',
                    data: {
                        id : item_id,
                        qty : qty
                        
                    }, 
                    dataType: "json", 
                    success: function (response) {
                        console.log(response);
                        // success
                        if (response.status == true) {
                            $('#my-request').html(response.data);
                        }
                    },
                    error: function (e) { //error
                        console.log(e.message);
                    }
                });
            });
        })
    </script>
    @endsection
    @endif