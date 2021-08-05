@extends('user.layouts.app')

@section('content')
<form method="post" action="{{ route('request.checkout') }}">
 @csrf
    <div class="pb-5">
        <div class="container">
        <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
            <div id="my-request">
                @include('user.components.requests')
            </div>
        </div>
        </div>
    </div>
</form>




@endsection
