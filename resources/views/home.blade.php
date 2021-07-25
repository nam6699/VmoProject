@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div>
               <ul>
                   @foreach($data as $item)
                   <li>{{$item->name}}</li>
                   <li><img src="{{asset('images/'.$item->image)}}" alt="" width=50 height=50></li>
                   <li>{{$item->quanity}}</li>
                   <li><a href="{{route('send.request',$item->id)}}">add</a></li>
                   @endforeach
               </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
