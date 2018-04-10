<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>科智科技</title>
    <link href="{{asset('/css/bootstrap.min.css')}}" title="" rel="stylesheet" />
    <link href="{{asset('/css/wch1.css')}}" title="" rel="stylesheet" />
    </head>
<body>
<div class="container" style="position: relative; ">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 100%;">

        @foreach($data as $k=>$v)

        <figure class="col-md-4">
            <a href="http://{{$v['1']}}">
                <img src="{{asset($v[3])}}" alt="{{$v[0]}}">
                <figcaption>
                    {{$v[2]}}
                </figcaption>
            </a>
        </figure>
      @endforeach
    </div>
</div>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: wmk
 * QQ: 2393209180
 * Date: 2018/3/2
 * Time: 13:29
 */
?>