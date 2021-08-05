@extends('admin.layouts.main')
@section('content')

    <!-- /.content-header -->
    
    <!-- Main content -->
    <a href="{{route('user.create')}}" class="nav-link">Create</a>
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">email</th>
            <th scope="col">action</th>
        </thead>
        <tbody>
          @foreach($data as $value)
          <tr class="user-{{ $value->id }}">
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td>{{$value->email}}</td>
            <td>
              <a href="{{route('user.edit', ['user'=>$value->id])}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
            <a data-id="{{$value->id }}" href="javascript:void(0)" class="remove-to-cart" class="text-dark"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $data->links() }}
          <!-- /.content -->
        <!-- /.content-wrapper -->




@endsection