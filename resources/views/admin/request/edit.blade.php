@extends('admin.layouts.main')
@section('content')
<style>
        #thongbao {
            position: absolute;
            margin-bottom: 0px;
            width: 350px;
            z-index: 1000;
            float: right;
            right: 22px;
        }
    </style>
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o" aria-hidden="true"></i> Chi Tiết Đơn Hàng
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
            <li><a href="{{route('request.index')}}">DS Request</a></li>
        </ol>
    </section>
    @if (session('msg'))
        <div class="pad margin no-print">
            <div class="alert alert-success alert-dismissible" style="" id="thongbao">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Thông báo !</h4>
                {{ session('msg') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="pad margin no-print">
            <div class="alert alert-danger alert-dismissible" style="" id="thongbao">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fas fa-file-excel"></i> Warning !</h4>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <form action="{{ route('request.update', ['request' => $data->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="box-header with-border">
                            <button id="button-disable" type="submit" class="btn btn-info btn-flat">
                                <i class="fa fa-edit"></i>
                                Cập nhật
                            </button>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td><label for="">Mã ĐH :</label></td>
                                    <td></td>
                                    <td><label>Ngày Đặt Hàng:</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><label for="">Họ tên :</label></td>
                                    <td></td>
                                    <td><label>Mã giảm giá</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><label>SĐT :</label> </td>
                                    <td></td>
                                    <td><label>Tạm tính</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><label>Email :</label></td>
                                    <td></td>
                                    <td><label>Khuyến mại</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><label>Địa chỉ :</label> </td>
                                    <td colspan=""></td>
                                    <td><label>Thành tiền</label></td>
                                    <td style="color: red"></td>

                                </tr>
                                <tr>
                                    <td><label>Địa chỉ nhận hàng :</label> </td>
                                    <td colspan="">
                                        <div class="form-group">
                                            <input class="form-control" name="address2" value="">
                                        </div>
                                    </td>
                                    <td><label>Trạng thái ĐH</label></td>
                                    <td style="color: red">
                                        <select class="form-control" id="select-disable" name="status_id" style="max-width: 150px;display: inline-block;">
                                            <option value="0">-- chọn --</option>
                                            @foreach($status as $status)
                                                <option {{ ($data->status_id == $status->id ? 'selected':'') }} value="{{ $status->id }}">{{ $status->name }}</option>   
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Ghi chú :</label> </td>
                                    <td colspan="3">
                                        <div class="form-group">
                                            <textarea name="note" class="form-control" rows="3" placeholder=""></textarea>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
                <div class="box">

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>TT</th>
                                <th style="max-with:200px">Tool nam</th>
                                <th>Hình ảnh</th>
                                <th>Số lượng</th>
                                <th class="text-center"></th>
                            </tr>
                            </tbody>
                            <!-- Lặp một mảng dữ liệu pass sang view để hiển thị -->
                            @foreach($data->details as $key => $item)
                            
                                <tr class=""> <!-- Thêm Class Cho Dòng -->
                                    <td>{{$key}}</td>
                                    <td>
                                        <a href="">
                                        {{ $item->name }}
                                        </a>
                                    </td>
                                    <td>
                                         @if ($item->image) <!-- Kiểm tra hình ảnh tồn tại -->
                                            <img src="{{asset('images/'.$item->image)}}" width="50" height="50">
                                        @endif
                                      
                                    </td>
                                    <td>{{ $item->quanity }}</td>
                                    <td></td>

                                    <td style="color:red;"></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.box-body -->

                </div>

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>

@endsection

@section('my_javascript')
<script type="text/javascript">
        $(document).ready(function() {
             var conceptName =$('#select-disable').find(":selected").text();
            if(conceptName=='accepted'){
            document.getElementById("select-disable").disabled = true ;
            document.getElementById("button-disable").disabled = true
            }
        });
    </script>
@endsection