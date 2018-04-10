<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>登录页面</title>
</head>
<body>
<div style="z-index: 99;border: 1px;" align="center">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content">
        <div class="title m-b-md">
          学生登陆
        </div>
        <br>
        <div id="error" style="color: red;">

        </div>
        <br>
        <div>
            <input type="text" id="id" placeholder="请输入账号" value="" >
        </div>
        <br>
        <div>
            <input type="password" id="pass" placeholder="请输入密码" value="" >
        </div>
        <br>
        <div>
            <input id="login" style="cursor:pointer;width: 150px;" type="button" value="登陆">
        </div>
    </div>
</div>
<script src="{{asset('/js/jquery-3.2.1.min.js')}}"></script>
<script>
    $('#login').on("click",function() {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        var tel= $.trim($("#id").val());
        var pass= $.trim($("#pass").val());
        var code= "1234";

        $.ajax({
            url:"{{url('/loging')}}",
            type:'POST',
            method:'put',
            data:{'id':tel,'pass':pass,'code':code}, //传用户ID
            dataType:"JSON",
            traditional:true,
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            success:function(datas){
                if(datas['t']==1){
                    window.top.location.href="{{url('/')}}";
                }else{
                    $("#error").html(datas['eror']);
                }
            }//ALAX调用成功
            ,error:function (datas) {
                $("#code-mark").html(datas['eror']);

            }
        })
    })
</script>
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