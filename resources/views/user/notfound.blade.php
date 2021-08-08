@extends('user.layouts.app')

@section('content')


<div class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block">404</span>
                <div class="mb-4 lead">Your Request is empty</div>
                <a href="{{url('home')}}" class="btn btn-link">Back to Home</a>
            </div>
        </div>
    </div>
</div>


@endsection