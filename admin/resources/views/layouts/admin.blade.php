<html lang="en">
@include('includes.admin-head')
<body>
<div class="wrapper">
@include('includes.admin-header')
@include('includes.admin-sidebar')
@yield('content')
@include('includes.admin-footer')
</body>

</html>