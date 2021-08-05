@extends('user.layouts.app')

@section('content')
<div class="container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Your Request : {{Auth::user()->name}}</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID No.</th>
                                        <th>note</th>
                                        <th>Detail</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->requests as $key => $value)
                                    <tr>
                                        <td>{{$data->name}}</td>
                                        <td>{{$key}}</td>
                                        <td>{{$value->note}}</td> 
                                        <td><a class="btn btn-primary" href="{{route('detail.request', ['id'=>$value->id])}}">detail</a></td>
                                        @foreach($status as $item)
                                            @if($value->status_id == $item->id)
                                            <td><label class="{{($item->id == 2 ? 'badge badge-success' : 'badge badge-danger')}}"> {{ $item->name }}</label></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 