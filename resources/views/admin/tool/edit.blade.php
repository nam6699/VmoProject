@can('edit tools')
@extends('admin.layouts.main')
@section('content')
<div class="container">
<form method="post" action="{{route('tool.update',['tool'=>$data->id])}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" name="name" id="exampleInputEmail1" value="{{$data->name}}" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">quanity</label>
    <input type="number" class="form-control" name="quanity" id="exampleInputPassword1" value="{{$data->quanity}}" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">image</label>
    <input type="file" class="form-control" name="image" id="exampleInputPassword1" value="" placeholder="Password">
    @if ($data->image)
         <img src="{{asset('images/'.$data->image)}}" width="200">
     @endif
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


@endsection
@endcan