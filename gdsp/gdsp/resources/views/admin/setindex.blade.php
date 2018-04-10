<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>管理主页</title>
</head>
<body>
<div style="z-index: 99;border: 1px;" align="center">
    <div class="content">
        <div class="layui-fluid" >
            <br>
            <br>
            <h2>文件夹</h2><a href="http://test.lara.com/moban/wenjian.xls" download="文件分类" >模板下载</a>
            <hr>
            <br>
            <br>
            <br>
            <form method="post" action="{{url('/admin/wenjian/onexcel')}}" class="form-signin" enctype="multipart/form-data" >
                {{csrf_field()}}

                <input type="hidden" name="_method" value="PUT" >
                <input name="excel" type="file" class="form-control">
                <input type="submit" value="导入文件夹表数据">
            </form>
            <hr>
            <br>
            <br>
            <br>
            <h2>列表</h2>
            <hr>

            <form method="post" action="{{url('/admin/item/onexcel')}}" class="form-signin" enctype="multipart/form-data" >
                {{csrf_field()}}

                <input type="hidden" name="_method" value="PUT" >
                <input name="excel" type="file" class="form-control">
                <input type="submit" value="导入详细列表">
            </form>
        </div>
        <br>
        <br>
        <br>
        <hr>
        <div>
            <a href="{{url('/admin/quit')}}"><input id="login" style="cursor:pointer;width: 150px;" type="button" value="退出登陆"></a>
        </div>
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