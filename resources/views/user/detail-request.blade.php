@extends('user.layouts.app')

@section('content')

<form action="{{ route('update-status.request', ['id' => $data->id]) }}" method="post">
@csrf
<div class="container" id="page-content">
                   
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-8 grid-margin stretch-card">
                    @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Your Request : {{Auth::user()->name}}</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>quanity</th>
                                 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data->details as $key => $value)
                                    <tr><td>{{$key}}</td>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->quanity}}</td>
                                    </tr>
                                    @endforeach
                                    <div class="return">
                                    @foreach($status as $item)
                                            @if($data->status_id == $item->id)
                                            @if($item->id == 2)
                                                <label class="badge badge-success"> {{ $item->name }}</label>
                                                @elseif($item->id == 3)
                                                <label class="badge badge-success"> {{ $item->name }}</label>
                                                @elseif($item->id == 4)
                                                <label class="badge badge-danger"> {{ $item->name }}</label>
                                                @elseif($item->id == 5)
                                                <label class="badge badge-warning"> {{ $item->name }}</label>
                                                @else
                                                <label class="badge badge-info"> {{ $item->name }}</label>
                                                @endif
                                            @endif
                                    @endforeach
                                    @if($data->status_id == 2)
                                    <button id="button-disable" onclick="return confirm('Are you sure?')" type="submit" name="status_id" value="5" class="btn btn-outline-danger">
                                        <i class="fa fa-edit"></i>
                                        Returning
                                    </button>
                                    </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@endsection 