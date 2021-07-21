@extends('admin.layouts.main')
@section('content')

    <!-- /.content-header -->

    <!-- Main content -->
    <a href="{{route('tool.create')}}" class="nav-link">Create</a>
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Quanity</th>
            <th scope="col">Action</th>
        </thead>
        <tbody>
          @foreach($data as $value)
          <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td><img src="{{asset('images/'.$value->image)}}" alt="" width=50 height=50></td>
            <td>{{$value->quanity}}</td>
            <td>
              <a href="{{route('tool.edit', ['tool'=>$value->id])}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                  <form method="post" action="{{route('tool.destroy',['tool'=>$value->id])}}">
                    @csrf
                    @method('DELETE')
                  
                  <button type="submit" class="btn btn-primary">delete</button>
            </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
          <!-- /.content -->
        <!-- /.content-wrapper -->





@endsection
