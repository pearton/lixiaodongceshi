<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>科智科技</title>
    <link href="{{asset('/css/wch1.css')}}" title="" rel="stylesheet" />
    </head>
<body style="background-image:url('uploads/rNInNnVAnE.jpg');background-position:center; background-repeat:repeat-y">
<div class="container">

        <figure class="col-md-4">
            <a href="{{url('/content/1')}}">
                <img src="{{asset('/uploads/styel/ntzWDW4ZQi.jpg')}}" alt="平台">
                <figcaption>
                    <h4 style="font-family: 楷体 ;font-size: 50px;">平台开发</h4>
                    <p>平台开发：视频定制开发，从剧本-拍摄-后期一站式服务。从事多年有丰富的经验，曾多次获得重庆市大赛奖项</p>
                </figcaption>
            </a>
        </figure>

        @foreach($data as $k=>$v)

        <figure class="col-md-4">
            <a href="{{url('/contents',$v->id)}}">
                <img src="{{asset($v->url)}}" alt="{{$v->name}}">
                <figcaption>
                    <h4 style="font-family: 楷体 ;font-size: 50px;">{{$v->name}}</h4>
                    {!! $v->discr !!}
                </figcaption>
            </a>
        </figure>
      @endforeach

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