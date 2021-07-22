<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Mail Send in Laravel Example</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Courgette|Pacifico:400,700">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>    
body {
    color: #000;
    background-image: url("background.jpg");
    font-family: "Roboto", sans-serif;
}
.contact-form {
    padding: 50px;
    margin: 30px auto;
}	
.contact-form h1 {
    font-size: 42px;
    font-family: 'Pacifico', sans-serif;
    margin: 0 0 50px;
    text-align: center;
}
.contact-form .form-group {
    margin-bottom: 20px;
}
.contact-form .form-control, .contact-form .btn {
    min-height: 40px;
    border-radius: 2px;
}
.contact-form .form-control {
    border-color: #e2c705;
}
.contact-form .form-control:focus {
    border-color: #d8b012;
    box-shadow: 0 0 8px #dcae10;
}
.contact-form .btn-primary, .contact-form .btn-primary:active {
    min-width: 250px;
    color: #fcda2e;
    background: #000 !important;
    margin-top: 20px;
    border: none;
}
.contact-form .btn-primary:hover {
    color: #fff; 
}
.contact-form .btn-primary i {
    margin-right: 5px;
}
.contact-form label {
    opacity: 0.9;
}
.contact-form textarea {
    resize: vertical;
}
.bs-example {
    margin: 20px;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                 style="border: 1px solid #cccccc; border-radius: 5px; width: 39px; height: auto;float:left; margin-right: 7px;">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
<div class="container-lg">

	<div class="row">
		<div class="col-md-8 mx-auto">
			<div class="contact-form">
				<h1>Get in Touch</h1>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <form action="{{ route('send.email') }}" method="post">
                @csrf
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="inputName">Name</label>
								<input type="text" name="name" class="form-control" placeholder="Enter Name">
                                @error('name')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="inputEmail">Email</label>
								<input type="email" name="email" class="form-control" placeholder="Enter Email">
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
					<div class="form-group">
						<label for="inputMessage">Message</label>
                        <textarea name="content" rows="5" class="form-control" placeholder="Enter Your Message"></textarea>
                        @error('content')
                        <span class="text-danger"> {{ $message }} </span>
                        @enderror
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Send</button>
					</div>            
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
