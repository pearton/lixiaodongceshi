<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>科智科技</title>
    <script src="{{asset('/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <style>
        html,body{height: 100%; margin: 0; padding: 0; overflow-y: hidden; background-color: #f4f4f4; min-width: 1200px; }
        h2{background: url(); height: 50px; width: 100%; text-align: center; line-height: 50px; margin: 0; float: left; }
        ul{padding: 0; list-style-type: none; }
        a,a:hover{text-decoration: none; }
        nav{height: 100%; width: 260px; position: absolute; }
        nav>ul{position: absolute; top: 55px; box-shadow: 0 0 2px 2px #999; bottom: 5px; left: 10px; right: 20px; margin: 0; border-radius: 10px; overflow-y: auto; }
        nav>ul li{position: relative; }
        nav>ul>li{border-bottom: 1px solid #999; }
        nav ul li a{line-height: 60px; display: block; text-indent: 10px; color: #787d82; }
        nav ul li a:hover{color: #0078d7; }
        nav ul li ul{display: none; padding-left: 10px; }
        nav ul li ul:before{content: ''; display: block; position: absolute; top: 40px; bottom: 0px; width: 1px; border-left: 1px #787d82 dashed; left: 25px; z-index: 9; }
        nav ul li ul li a{line-height: 40px; text-indent: 30px; }
        nav ul li ul li a.foc{color: #0078d7; position: relative; }
        nav ul li ul li a.foc:before{content:''; display: block; position: absolute; top: 0; left: 0; height: 100%; width: 10px; border-bottom: solid 20px transparent; border-top: solid 20px transparent; border-left: solid 10px #0078d7; }
        nav ul li ul li a:before{content: ''; display: block; width: 10px; border-top: dotted 1px #787d82; position: absolute; top: 20px; left: 15px; }
        .affix{width: 200px; }
        .container{height: 100%; }
        .content{height: 100%; margin-left: 260px; padding-top: 50px; box-sizing: border-box; }
        .content figure{width: 100px; height: 100px; padding: 5px; position: relative; margin: 10px 10px 0 10px; float: left; }
        .content figure img{width: 90px; }
        .content figure figcaption a{background-color: rgba(0,0,0,0.4); position: absolute; top: 0; left: 0; bottom: 0; right: 0; text-align: center; line-height: 110px; color: #fff; }
    </style>
    </head>
<body>
<div class="container">
    <h2 id="title" class="title"></h2>
    <nav class="col-md-3 bs-docs-sidebar hidden-print hidden-xs hidden-sm">
        <ul>
            @foreach($data as $k=>$v)
                <li class="list">

                    <a href="javascript:;">{{$v[0]['name']}}</a>

                    <ul class="lis">
                        @foreach($v[1] as $m=>$n)
                            @if($n->type==1)
                                <li><a href="javascript:;" onclick="mp4click(this)" alt="{{$n->id}}">{{$n->title}}</a></li>
                            @elseif($n->type==2)
                                <li><a href="javascript:;" onclick="pptclick(this)" alt="{{$n->id}}">{{$n->title}}</a></li>
                            @else
                                <li><a href="javascript:;" onclick="wordclick(this)" alt="{{$n->id}}">{{$n->title}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </nav>
    <div class="col-md-9 content">

         <iframe src="{{url('/contentss')}}" width="100%" height="100%" frameborder="0"></iframe>
        <h4 style="height: 40px; line-height: 40px; text-align: center; font-weight: bold; ">这是一个短视频</h4>
        <video src="cat.mp4" width="100%" style="background-color: #333" controls autobuffer></video>
        <h4 style="height: 40px; line-height: 40px; color: #0078d7; ">
            下载相关课件
        </h4>
        <figure>
            <img src="{{url('images/pptlogo.png')}}" alt="ppt">
            <figcaption>
                <a href="{{url('ppt/cs.pps')}}">
                    点击下载
                </a>
            </figcaption>
        </figure>
        <figure>
            <img src="{{url('images/word.png')}}" alt="ppt">
            <figcaption>
                <a href="ppt/cs.pps">
                    点击下载
                </a>
            </figcaption>
        </figure>
    </div>
</div>
</body>
<script>
    function wordclick(obj){
        $(".content").find("iframe").attr("src",'{{url('/word')}}'+'/'+$(obj).attr("alt"));
    }
    function pptclick(obj){
        $(".content").find("iframe").attr("src",'{{url('/ppt')}}'+'/'+$(obj).attr("alt"));
    }
    function mp4click(obj){
        $('#title').text($(obj).text());
        $(".content").find("iframe").attr("src",'{{url('/play')}}'+'/'+$(obj).attr("alt"));
    }
    $("nav>ul>li").on("click","a",function(){
        $(this).siblings("ul").stop().slideToggle().parents(".list").siblings().find("ul").stop().slideUp();
    })
</script>
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