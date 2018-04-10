<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('bootstrap-3.3.7/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/commen.css')}}">
    <script src="{{asset('/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
</head>
<body>
<div class="center">
    <div  class="left">

        <ul class="nav">
            <li alt="{{url('/admin/content')}}">
                <a>
                    <p class="logo">
                        <img src="{{asset('images/logo.png')}}" alt="logo">
                    </p>
                </a>
            </li>
            <li alt="{{url('/admin/wenjian')}}" >
                <a>
                    <i class="glyphicon glyphicon-film"></i>
                    <p>分类</p>
                </a>
            </li>
            <li alt="{{url('/admin/item')}}">
                <a>
                    <i class="glyphicon glyphicon-th-large"></i>
                    <p>项目</p>
                </a>
            </li>
            <li alt="{{url('/admin/ceshi')}}">
                <a>
                    <i class="glyphicon glyphicon-th-large"></i>
                    <p>测试</p>
                </a>
            </li>
        </ul>
    </div>
    <div class="right">
        <header>
            <form class="search">
                <input type="text">
                <i class="glyphicon glyphicon-search"></i>
                <input type="submit">
            </form>
            <div style="background-color: #fff; height: 100%; border-radius: 10px; flex:6; padding: 0 10px; margin: 0 20px; ">
                <img class="img-circle" src="{{asset('images/123.jpg')}}" style="width: 50px; height: 50px; margin-top: 5px; float: left;" alt="头像">
                <p style="margin-left: 60px; height: 60px; line-height: 60px; font-size:18px; overflow: hidden; text-overflow: ellipsis; ">欢迎！<span>admin</span>，使用123456系统</p>
            </div>
            <a href="{{url('/admin/quit')}}"><button>LOGOUT</button></a>
        </header>
        <div class="content">

            <iframe id="iftame" style="border: 0;border-radius: 9px;"  src="{{url('/admin/content')}}"></iframe>
            <script type="text/javascript">
                var old = $(".active");
                $(".left ul li").click(function(){
                    old.removeClass("active");
                    old=$(this).find("a").addClass("active");
                    $('#iftame').attr('src',$(this).attr('alt'));
//                    $(this).siblings().removeClass('active');
//                    $(this).parent().parent().siblings().children().children().removeClass('active');
//                    $(this).addClass('active');
                } )</script>

        </div>
    </div>
</div>
<footer>
    重庆市科智科技有限公司
</footer>
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