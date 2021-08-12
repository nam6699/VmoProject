@extends('user.layouts.app')

@section('content')
<div class="container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="top-filter">
                        <h4 class="card-title">Your Request : {{Auth::user()->name}}</h4>
                        <div class="request_status">
                            <select name="" id="statusId" class="form-control">
                                <option {{( $filter == ''  ? 'selected' : '') }} value="0">all</option>
                                <option {{( $filter == '1' ? 'selected' : '') }} value="1">New</option>
                                <option {{( $filter == '2' ? 'selected' : '') }} value="2">Accepted</option>
                                <option {{( $filter == '3' ? 'selected' : '') }} value="3">Finished</option>
                                <option {{( $filter == '4' ? 'selected' : '') }} value="4">Cancel</option>
                                <option {{( $filter == '5' ? 'selected' : '') }} value="5">Returning</option>
                            </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID No.</th>
                                        <th>note</th>
                                        <th>Detail</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{$value->user->name}}</td>
                                        <td>{{$key}}</td>
                                        <td>{{$value->note}}</td> 
                                        <td><a class="btn btn-outline-secondary" href="{{route('detail.request', ['id'=>$value->id])}}">Detail</a></td>
                                        @foreach($status as $item)
                                            @if($value->status_id == $item->id)
                                                @if($item->id == 2)
                                                <td><label class="badge badge-success"> {{ $item->name }}</label></td>
                                                @elseif($item->id == 3)
                                                <td><label class="badge badge-success"> {{ $item->name }}</label></td>
                                                @elseif($item->id == 4)
                                                <td><label class="badge badge-danger"> {{ $item->name }}</label></td>
                                                @elseif($item->id == 5)
                                                <td><label class="badge badge-warning"> {{ $item->name }}</label></td>
                                                @else
                                                <td><label class="badge badge-info"> {{ $item->name }}</label></td>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($filter == 0)
                            {{$data->links()}}
                            @else
                            {{ $data->appends(['status'=>$filter])->links()  }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
@section('my_javascript')
<script>
          var pathname = window.location.pathname; // 
          var urlParams = new URLSearchParams(window.location.search); // khoi tao
          $(document).on("change", '#statusId', function () {
                var status = $(this).val();
                if (status) {
                  if (status == '0') {
                    urlParams.delete('status');
                  } else {
                    urlParams.set('status', status);
                  }
                  window.location.href = pathname + "?" +decodeURIComponent(urlParams.toString());
                }
            });
</script>
@endsection