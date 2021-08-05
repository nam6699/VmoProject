@extends('user.layouts.app')

@section('content')
<div class="container">
<div class="input-group">
</div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tools List') }}</div>
                <div class="d-flex flex-row">
               @foreach($data as $item)
                
               <div class="card mr-3" style="width: 15rem;">
                    <img class="card-img-top" src="{{asset('images/'.$item->image)}}" alt="Card image cap" width=100 height=200>
                    <div class="card-body bg-secondary">
                        <h5 class="card-title">{{$item->name}}</h5>
                        <p class="card-text">Quanity available: {{$item->quanity}}</p>
                        @if($item->quanity > 0 )
                        <a href="{{route('add.request', $item->id)}}" class="btn btn-primary">Add</a>
                        @endif
                    </div>
                </div>
                 
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection