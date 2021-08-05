@extends('admin.layouts.main')
@section('content')

    <!-- /.content-header -->


    <!-- Main content -->
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
        </thead>
        <tbody>
          @foreach($role as $value)
          <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            @can('edit tools')
            <td>
              <a href="{{route('role.edit', ['role'=>$value->id])}}" class="btn btn-primary">Edit</a>
            </td>
            @endcan
          </tr>
          @endforeach
        </tbody>
      </table>
          <!-- /.content -->
        <!-- /.content-wrapper -->





@endsection