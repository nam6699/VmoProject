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
            <i class="fa fa-file-text-o" aria-hidden="true"></i> Request Detail
        </h1>
        <ol class="breadcrumb">
            <li style="margin-right:10px;"><a href="/" class="btn btn-primary">Home</a></li>
            <li><a href="{{route('request.index')}}" class="btn btn-info">Request List</a></li>
        </ol>
    </section>
    @if (session('msg'))
        <div class="pad margin no-print">
            <div class="alert alert-success alert-dismissible" style="" id="thongbao">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Notice !</h4>
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
                            @if($data->status_id == 1)
                            <button id="button-disable" name="status_id" value="2" type="submit" class="btn btn-success btn-flat">
                                <i class="fa fa-edit"></i>
                                Approve
                            </button>
                            <button id="button-disable" type="submit" name="status_id" value="4" class="btn btn-danger btn-flat">
                                <i class="fa fa-edit"></i>
                                Cancel
                            </button>
                            @elseif($data->status_id == 5)
                            <button id="button-disable" name="status_id" value="3" type="submit" class="btn btn-success btn-flat">
                                <i class="fa fa-edit"></i>
                                Done
                            </button>
                            @endif
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td><label for="">Username :</label></td>
                                    <td>{{$data->user->name}}</td>
                                    <td><label>Status</label></td>
                                    @foreach($status as $item)
                                            @if($data->status_id == $item->id)
                                            @if($item->id == 2)
                                                <td><label class="badge badge-primary"><h6>{{ $item->name }}</h6></label></td>
                                                @elseif($item->id == 3)
                                                <td><label class="badge badge-success"> <h6>{{ $item->name }}</h6></label></td>
                                                @elseif($item->id == 4)
                                                <td><label class="badge badge-danger"> <h6>{{ $item->name }}</h6></label></td>
                                                @elseif($item->id == 5)
                                                <td><label class="badge badge-warning"> <h6>{{ $item->name }}</h6></label></td>
                                                @else
                                                <td><label class="badge badge-info"> <h6>{{ $item->name }}</h6></label></td>
                                                @endif
                                            @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <td><label>Email :</label></td>
                                    <td>{{$data->user->email}}</td>
                                    <td><label>Total Quanity</label></td>
                                    <td>{{$data->totalQty}}</td>
                                </tr>
                                <tr>
                                    <td><label>Note :</label> </td>
                                    <td colspan="3">
                                        <div class="form-group">
                                            <textarea name="note" class="form-control" rows="3"  placeholder="" value="{{$data->note}}">
                                                @if(isset($data->note))
                                                {{$data->note}}
                                                @endif
                                            </textarea>
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
                                <th>ID no.</th>
                                <th style="max-with:200px">Tool name</th>
                                <th>Image</th>
                                <th>Quanity</th>
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

