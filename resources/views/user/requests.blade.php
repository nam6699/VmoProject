@extends('user.layouts.app')

@section('content')
<form method="post" action="{{ route('request.checkout') }}">
 @csrf
    <div class="pb-5">
        <div class="container">
        <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
            <div id="my-request">
                @include('user.components.requests')
            </div>
            <div class="container-lg">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="contact-form">
                                @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row py-5 p-4 bg-white rounded shadow-sm">
                <div class="col-lg-12">
                    <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold text-center">Send Email</div>
                    <div class="p-4">
                        <div class="row">
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inputName">Your name</label>
                                    <input type="name" name="name" class="form-control" placeholder="Enter Your Email..">
                                    @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inputEmail">Send To</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email" value="namnpp@vmodev.com">
                                    @error('email')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSubject">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Enter subject">
                            @error('subject')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMessage">Message</label>
                            <textarea name="content" rows="5" class="form-control" placeholder="Enter Your Message"></textarea>
                            @error('content')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>         
                    </div>
                        <button type="submit" class="btn btn-dark rounded-pill py-2 btn-block">Send Request</button> 
                        <a class="btn btn-danger rounded-pill py-2 btn-block" href="{{ route('destroy.request') }}">Cancel</a>
                </div>
            </div>
        </div>
        </div>
    </div>
</form>




@endsection
