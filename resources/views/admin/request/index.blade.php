@extends('admin.layouts.main')
@section('content')

<a href="{{route('tool.create')}}" class="nav-link">Create</a>
          <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">total Quanity</th>
            <th scope="col">status</th>
            <th scope="col">Action</th>
        </thead>
        <tbody>
          @foreach($data as $value)
          <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->totalQty}}</td>
            <td>
            @if ($value->status_id === 1)
                    <span class="label label-info">New</span>
                @elseif ($value->status_id === 2)
                    <span class="label label-warning">accepted</span>
                @else
                    <span class="label label-danger">Hủy</span>
                @endif
            </td>
            <td>
              <a href="{{route('request.edit', ['request'=>$value->id])}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                  <form method="post" action="{{route('request.destroy',['request'=>$value->id])}}">
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