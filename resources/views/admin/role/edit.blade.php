@extends('admin.layouts.main')
@section('content')
<div class="container">
<form method="post" action="{{route('role.update',$role->id)}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name" 
    value="@isset($role){{ $role->name }}@endisset">
  </div>
  <div class="form-group">
      @foreach ($permission as $permission )
        <div class="form-check">
            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission->id }}" id = "{{ $permission->name }}"
            @isset($role) @if(in_array($permission->id,$role->permissions->pluck('id')->toArray())) checked @endif @endisset>
            <lable class="form-check-lable" for="{{ $permission->name }}">
                {{ $permission->name }}
            </lable>
        </div>
      @endforeach
    
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>


@endsection