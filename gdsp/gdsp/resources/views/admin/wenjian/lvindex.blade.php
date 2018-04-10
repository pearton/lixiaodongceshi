@extends('admin.hearder.nav1')
@section('content')

    <script src="{{asset('/wdatepicker/WdatePicker.js')}}"></script>
    <div class="right-product my-index right-full" style="width: 90%;left: 10px;">
        <div class="row">
            <div class="span6">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{url('/admin/wenjian')}}">分类</a> <span class="divider">></span>
                    </li>
                    <li>
                        <a href="{{url('/admin/wenjian')}}">分类列表</a> <span class="divider">></span>
                    </li>
                    <li class="active">分级列表</li>
                </ul>
            </div>
        </div>
        <div class="main container-fluid" >
            <div class="form-inline mb10">
                <form method="get" action="{{ url('/admin/wenjian/lv/',[request()->route('item_type')])}}" style="float:left;margin-right: 10px;">
                    <input type="button" value="刷新一下" onclick="window.location.href='{{url('/admin/wenjian/lv',$id)}}'" class="btn btn-primary"/>

                    <input type="button" value="新增" onclick="window.location.href='{{url('/admin/wenjian/lv/add',$id)}}'" class="btn btn-success"/>
                    <input type="button" value="导出目录结构" onclick="window.location.href='{{url('/admin/putexcelerji',$id)}}'" class="btn btn-success"/>
                </form>

            </div>
            <table class="table table-striped">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <thead>
                <tr>
                    <th width="60px"><label><input type="checkbox" class="ckall"/> 选择</label></th>
                    <th width="30px">ID</th>
                    <th width="80px">分类名</th>
                    <th width="100px">分类文件夹</th>
                    <th width="80px">分级名</th>
                    <th width="80px">文件夹名</th>
                    <th width="100px">文件夹状态</th>
                    <th width="80px">修改时间</th>
                    <th width="80px">状态</th>
                    <th width="180px">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $test)

                    <tr>

                        <td><input type="checkbox" name="ckbox" value="{{$test->id}}" class="ckbox"/></td>
                        <td>{{$test->id}}</td>
                        <td>{{getNameByStyel($test->styel)}}</td>
                        <td>{{getDirByStyel($test->styel)}}</td>
                        <td>{{$test->name}}</td>
                        <td>{{$test->dir_name}}</td>
                        <td>
                            @if(getStyelByDirLv($test->styel,$test->dir_name)==1)
                                <span class="label label-success ">正常</span>
                                <i style="cursor: pointer; " class="glyphicon glyphicon-trash"><a href="{{url('/admin/lv/del',getDirByStyel($test->styel).','.$test->dir_name)}}">删除</a></i>
                            @elseif(getStyelByDir($test->dir_name)==2)
                                <span class="label label-danger">目录不存在</span>
                                <i style="cursor: pointer; " class="glyphicon glyphicon-plus"><a href="{{url('/admin/lv/create',$test->id)}}">创建</a></i>
                            @else
                                <span class="label label-danger">网络故障</span>
                                <input type="button" value="刷新" onclick="window.location.href='{{url('/admin/wenjian/lv',$id)}}'" class="btn btn-primary"/>
                            @endif
                        </td>
                        <td>{{$test->updatetime}}</td>
                        <td>
                            @if($test->show==1)
                                显示
                            @else
                                <span class="label label-danger">关闭</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-default btn-sm" href="javascript:;"
                               onclick="if(confirm('真的要 @if($test->show==2)开启@else关闭@endif该模块？')){clock({{$test->id}}); }">
                                <span class="icon-search"></span> @if($test->show==2)<span class="label label-success">开启</span>@else<span class="label label-danger">关闭</span>@endif</a>
                            <a class="btn btn-success btn-sm" href="{{url('/admin/wenjian/lv/edit',$test->id)}}">编辑</a>
                            <a class="btn btn-success btn-sm" href="{{url('/admin/item',$test->id)}}">查看资料列表</a>
                            <a class="btn btn-success btn-sm" href="javascript:;" onclick="if(confirm('真的要生成数据吗？')){created({{$test->id}}); }">自动</a>
                        </td>

                    </tr>

                @endforeach
                <tr style="background-color: #f9f9f9;">
                    <td><label><input type="checkbox" class="ckall"/> 选择</label></td>
                    <td colspan="3">
                        <input type="button" class="btn btn-danger btn-sm btn-del-all" value="批量删除"/>
                    </td>
                    <td colspan="8">
                        <div class="pageStr" style="font-size: inherit;margin: 0;text-align: left;">
                            {!! $data->render() !!}
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            function clock(id){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type : "GET",
                    url : "{{url('/admin/wenjian/lv/clock')}}/"+id,
                    dataType : "json",
                    success:function(datas){
                        if(datas==1){
                            alert("操作成功！");
                            window.location.href="";
                        }else if(datas==2){
                            window.location.href="";
                        }else if(datas==3){
                            window.location.href="";
                        }
                    }//ALAX调用成功
                    ,error:function () {
                        alert("ajax执行失败！");
                    }
                });

            }
            function created(id){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type : "POST",
                    url : "{{url('/admin/item/created')}}",
                    data: {id:id},
                    method:'put',
                    dataType : "json",
                    success:function(datas){
                        if(datas==1){
                            alert("成功！");
                            window.location.href="";
                        }if(datas==2){
                            alert("失败！");
                            window.location.href="";
                        }
                    }//ALAX调用成功
                    ,error:function () {
                        alert("网络错误！");
                    }
                });

            }
            $(".ckall").click(function(){
                $(".ckbox:checkbox").each(function(i,o){
                    $(o).prop("checked",!$(o).prop("checked"));
                });
            });
            $(".btn-del-all").click(function(){
                if(confirm("确定要删除选中的信息嘛？")){
                    var text= new Array();
                    $("input[name='ckbox']:checked").each(function() {
                        text.push($(this).val());

                    });
                    if(!text[0]){
                        alert("请选择要删除的信息！");
                    }
                    else{
                        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                        text = text.join(",");
                        $.ajax({
                            type : "POST",
                            url : "{{url('/admin/wenjian/lv/dels')}}",
                            data: {txt:text},
                            method:'delete',
                            dataType : "json",
                            success:function(datas){
                                if(datas==1){
                                    alert("删除成功！");
                                    window.location.href="";
                                }else if(datas==2){
                                    window.location.href="";
                                }else if(datas==3){
                                    alert("删除失败！");
                                    window.location.href="";
                                }
                            }//ALAX调用成功
                            ,error:function () {
                                alert("ajax执行失败！");
                            }
                        });
                    }
                }
            });
        </script>


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