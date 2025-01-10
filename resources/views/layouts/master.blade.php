<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="ie=edge" http-equiv="X-UA-Compatible">

  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <title>Connect Friend</title>
</head>

<body>
  <div class="container-fluid">
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')
  </div>

  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
