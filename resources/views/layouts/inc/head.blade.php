<meta charset="utf-8" />
<title>@yield('PageTitle') | {{ env('APP_NAME') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<base href="{{ url('/') }}">
<link href="{{ url('/assets/images/favicon.ico') }}" rel="shortcut icon">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css" integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<link href="{{ url('/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ url('/assets/css/w3.css') }}">
<link href="{{ url('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ url('/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />


@stack('styles')
<script>
    var _URL = "{{ url('/') }}";
</script>

