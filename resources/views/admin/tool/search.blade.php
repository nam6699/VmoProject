@extends('admin.layouts.main')
@section('content')
    <!-- /.content-header -->

    <!-- Main content -->
    @can('edit tools')
    <a href="{{route('tool.create')}}" class="nav-link">Create</a>
    @endcan
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Quanity</th>
            @can('edit tools')
            <th scope="col">Action</th>
            @endcan
        </thead>
        <tbody>
          @foreach($data as $value)
          <tr class="tool-{{ $value->id }}">
            <td>{{$value->id}}</td>
            <td>{{$value->name}}</td>
            <td><img src="{{asset('images/'.$value->image)}}" alt="" width=50 height=50></td>
            <td>{{$value->quanity}}</td>
            @can('edit tools')
            <td>
              <a href="{{route('tool.edit', ['tool'=>$value->id])}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                  <!-- <form method="post" action="{{route('tool.destroy',['tool'=>$value->id])}}">
                    @csrf
                    @method('DELETE')
                  
                  <button type="submit" class="btn btn-primary" onclick="return confirm('ban co chac chan muon xoa')">delete</button>
                  </form> -->
            <a data-id="{{$value->id }}" href="javascript:void(0)" class="remove-to-cart" class="text-dark"><i class="fa fa-trash"></i></a>
            </td>
            @endcan
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $data->links() }}
      
          <!-- /.content -->
        <!-- /.content-wrapper -->
@endsection