@extends('user.layouts.app')

@section('content')
<section>

        <div class="container">
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
        <div class="search">
                <form action="{{url('search')}}" method='get' >
                <div class="input-group rounded">
                <input type="search" class="form-control rounded" name="searchInput" placeholder="Search" aria-label="Search"
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="d-flex flex-wrap" >
                        @foreach($data as $item)
                        <div class="card card-items" style="width: 15rem;" >
                            <div class="card-image">
                                <img class="pt-2" src="{{asset('images/'.$item->image)}}" alt="Card image cap" width=150 height=175>
                            </div>
                            <div class="card-body">
                                <h5 class=" text-bold text-uppercase text-center text-dark">{{$item->name}}</h5>
                                <p class="text-uppercase">Quanity available: {{$item->quanity}}</p>
                                @if($item->quanity > 0 )
                                <div class="p-3">
                                <a class="text-uppercase btn btn-danger" href="{{route('add.request', $item->id)}}">Add To Request</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ $data->links()}}
              </div>
            </div>
          </div>
        </div>
      </section>

@endsection