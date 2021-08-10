@extends('user.layouts.app')

@section('content')

<section>

        <div class="container-fluid mb-5 mt-5">
        <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    @if (session('msg'))
                        <div class="alert alert-success" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif
                </div>
        <div class="search ">
                <form action="{{url('search')}}" method='get'>
                <div class="input-group rounded">
                <input type="search" class="form-control rounded" name="searchInput" id="searchInput" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" /> 
                <button class="input-group-text border-0" type="submit" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>   
                </div>
                 </form>
            </div>
          <div class="row center-xs center-sm center-md center-lg">
            <div id="features" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h2>Tools List</h2>
              <div class="row">
              @foreach($data as $item)
                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                        <div class="card card-items" style="width:22rem;height:26rem;" >
                            <div class="card-image">
                            <img class="pt-2" src="{{asset('images/'.$item->image)}}" width=175 height=200>
                            </div>
                            <div class="pt-5 text">
                                <h5 class=" text-bold text-uppercase text-center text-dark">{{$item->name}}</h5>
                                <p class="text-uppercase">Quanity available: {{$item->quanity}}</p>
                                @if($item->quanity > 0 )
                                <div class="pt-3">
                                <a class="text-uppercase btn btn-danger btn-lg" href="{{route('add.request', $item->id)}}">Add To Request</a>
                                </div>
                                @endif
                            </div>
                        </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="navigation">
              {{ $data->links()}}
            </div>
      </section>
@endsection
@section('my_javascript')
    <script>
       
    </script>
@endsection