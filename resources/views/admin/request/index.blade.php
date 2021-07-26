@extends('admin.layouts.main')
@section('content')

<a href="{{route('tool.create')}}" class="nav-link">Create</a>
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">total Quanity</th>
            <th scope="col">status_id</th>
            <th scope="col">Action</th>
        </thead>
        <tbody>
          @foreach($data as $value)
          <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->totalQty}}</td>
            <td>{{$value->status_id}}</td>
            <td>
              <a href="{{route('request.edit', ['request'=>$value->id])}}" class="btn btn-primary">Edit</a>
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