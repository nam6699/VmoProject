<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="{{asset('css/app.css')}}">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
<div id="my-request">
    @include('user.components.requests')
</div>




@yield('my_javascript')
</body>
</html>
