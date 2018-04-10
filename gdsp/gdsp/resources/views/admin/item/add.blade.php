@extends('admin.hearder.nav1')
@section('content')

    <div class="right-product my-index right-full" style="left: 10px;">
        <div class="row">
            <div class="span6">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{url('/admin/item')}}">项目</a> <span class="divider">></span>
                    </li>
                    <li class="active">项目添加</li>
                </ul>
            </div>
        </div>
        <div class="framework" style="margin-bottom:0;">
            <!-- main body -->
            <script type="text/javascript">
                function addFinancing(){
                    var name = $("#name").val();
                    var dir_name = $("#dir_name").val();
                    var myEditor = $("#myEditor").html();

                    if(name.trim() == ""){
                        alert("请填写分类名！");
                        $("#title").focus();
                        return false;
                    }
                    if(dir_name.trim() == ""){
                        alert("请填写文件夹名！");
                        $("#guarantee").focus();
                        return false;
                    }
                    if(myEditor.trim() == ""){
                        alert("请填写描述！");
                        $("#guaranteeURL").focus();
                        return false;
                    }
                }
            </script>
            @if(count($errors)>0)
                @if(is_object($errors))
                    @foreach($errors->all() as $error)

                        {!! $error !!}
                        @break
                    @endforeach
                @else
                    {!!$errors!!}
                @endif
            @endif
            <script src="{{asset('/wdatepicker/WdatePicker.js')}}"></script>
            <div class="">
                <input type="button" value="刷新一下" onclick="window.location.href='{{url('/admin/item/add')}}'" class="btn btn-primary"/>
                <form id="fm" action="{{url('/admin/item/added')}}" method="post" onsubmit="return addFinancing()">
                    <!-- a form -->
                    <input type="hidden" name="_method" value="PUT" >
                    {{csrf_field()}}
                    <ul class="form" style="width:800px;margin-left:50px;">
                        <li>
                            <div class="left">
                                <b>分类名</b>
                            </div>
                            <div class="right form-group">
                                <input validate="" style="width:300px" maxlength="35" class="pledge " id="name" name="name" type="text">
                                <b class="however"></b>
                                <i class="tip" style="display:inline"> 在前台显示的分类标题！</i><label></label>
                            </div>
                        </li>
                        <li>
                            <div class="left">
                                <b>文件夹名</b>
                            </div>
                            <div class="right form-group">
                                <input validate="" style="width:300px" maxlength="35" class="pledge " id="dir_name" name="dir_name" type="text">
                                <b class="however"></b>
                                <i class="tip" style="display:inline"> 在根目录下的文件夹名！推荐使用英文命名</i><label></label>
                            </div>
                        </li>

                        <li>
                            <div class="left"  style="display:inline">
                                <b>显示控制</b>
                            </div>
                            <div class="right form-group" style="display:inline">
                                <select name="show"  style="width: 107px;height:32px;font-weight: bold; border: solid 1px #ddd;">
                                    <option value="1" style="color: green;">显示</option>
                                    <option value="2" style="color: red;">关闭</option>
                                </select>
                                <label></label>
                            </div>
                        </li>
                        <br>
                        <li>
                            <div class="left"  style="display:inline">
                                <b>分类类型</b>
                            </div>
                            <div class="right form-group" style="display:inline">
                                <select name="type"  style="width: 107px;height:32px;font-weight: bold; border: solid 1px #ddd;">
                                    <option value="1" style="color: green;">分类</option>
                                </select>
                                <label></label>
                            </div>

                        </li>
                        <br>
                        <li>
                            <div class="left">
                                <b>描述</b>
                            </div>
                            <div class="right form-group">
                                <textarea class="edui-default" id="myEditor" name="discr" style="height:300px"></textarea>
                                <label></label>
                            </div>
                        </li>
                        <li>
                            <input class="btn btn-primary" id="btn_apply" style="width:300px;height:45px;border-radius:0;display:inline-block;float:none;" value="确认提交" type="submit">
                        </li>
                    </ul>
                </form>


                <script type="text/javascript" src="{{asset('/ueditor/ueditor.config.js')}}"></script>
                <script type="text/javascript" src="{{asset('/ueditor/ueditor.all.js')}}"></script>
                <script>
                    var editor = new UE.ui.Editor({ initialFrameWidth: 900 });
                    var _ispic = "2";
                    editor.render("myEditor");
                </script>
            </div>
        </div>
        <!-- sidebar -->
    </div>
@endsection
<?php
/**
 * Created by PhpStorm.
 * User: wmk
 * QQ: 2393209180
 * Date: 2018/3/2
 * Time: 13:29
 */
?>