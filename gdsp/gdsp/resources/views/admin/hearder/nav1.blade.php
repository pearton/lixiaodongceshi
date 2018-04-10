<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
    <title>用户中心</title>
    <link href="{{asset('/css/bootstrap.min.css')}}" title="" rel="stylesheet" />
    <link href="{{asset('/css/style.css')}}" rel="stylesheet" type="text/css"  />
    <link href="{{asset('css/templatecss.css')}}" rel="stylesheet" title="" type="text/css" />

    <script src="{{asset('/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/wdatepicker/WdatePicker.js')}}"></script>
</head>
<style>
    .fred1{
        color: #d43f3a;
    }
    body{
        background-color: #eceff3;
    }
</style>
<body>

@yield('content')
</body>
</html>