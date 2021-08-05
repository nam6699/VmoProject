@extends('admin.layouts.main')
@section('content')
<div class="container">
<form method="post" action="{{route('user.store')}}" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">email</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group">
      @foreach ($role as $role )
        <div class="form-check">
            <input class="form-check-input" name="role" type="radio" value="{{ $role->id }}" id = "{{ $role->name }}">
            <lable class="form-check-lable" for="{{ $role->name }}">
                {{ $role->name }}
            </lable>
        </div>
      @endforeach
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


@endsection