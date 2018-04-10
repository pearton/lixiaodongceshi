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
                    <li class="active">分类列表</li>
                </ul>
            </div>
        </div>
        <div class="main container-fluid" >
            <div class="form-inline mb10">
                <form method="get" action="{{ url('/admin/wenjian',[request()->route('item_type')])}}" style="float:left;margin-right: 10px;">
                    <div class="input-group">
                        <div class="select input-group-btn">
                            <select name="searchType" class="btn btn-default dropdown-toggle">
                                <option value="1" @if(!empty($_GET['searchType']) and $_GET['searchType']==1) selected="selected" @endif >ID</option>
                                <option value="2" @if(!empty($_GET['searchType']) and $_GET['searchType']==2) selected="selected" @endif >分类名</option>
                                <option value="3" @if(!empty($_GET['searchType']) and $_GET['searchType']==3) selected="selected" @endif >文件夹名</option>
                            </select>
                        </div><!-- /btn-group -->
                        <input name="searchTxt" style="width:120px;padding:0;" @if(!empty($_GET['searchTxt'])) value="{{$_GET['searchTxt']}}"  @endif  class="form-control" type="text">
                    </div><!-- /input-group -->
                    <div class="input-group">
                        <input class="form-control " name="date1" onfocus="WdatePicker()" @if(!empty($_GET['date1'])) value="{{$_GET['date1']}}"  @endif style="width:150px;padding:0;text-indent: 10px;" placeholder="起始日期" type="text">
                        <span class="input-group-addon">-</span>
                        <input class="form-control" name="date2" onfocus="WdatePicker()" @if(!empty($_GET['date2'])) value="{{$_GET['date2']}}"  @endif style="width:150px;padding:0;text-indent: 10px;" placeholder="结束日期" type="text">
                    </div>
                    <div class="input-group">
                        <div class="select input-group-btn">
                            <select class="btn btn-default dropdown-toggle" name="status">
                                <option value="0" @if(!empty($_GET['status']) and $_GET['status']==0) selected="selected" @endif >全部</option>
                                <option value="1" @if(!empty($_GET['status']) and $_GET['status']==1) selected="selected" @endif >开启</option>
                                <option value="2" @if(!empty($_GET['status']) and $_GET['status']==2) selected="selected" @endif >关闭</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" value="搜索" class="btn btn-primary"/>
                    <input type="button" value="重置" onclick="window.location.href='{{url('/admin/wenjian')}}'" class="btn btn-primary"/>
                    <input type="button" value="新增" onclick="window.location.href='{{url('/admin/wenjian/add')}}'" class="btn btn-success"/>
                    <input type="button" value="导出文件目录" onclick="window.location.href='{{url('admin/putexcel')}}'" class="btn btn-success"/>
                    <input type="button" value="打开项目根目录" onclick="window.location.href='{{url('admin/wenjianmulu')}}'" class="btn btn-success"/>
                </form>
                <!-- <form method="post" action="{{url('/admin/wenjian/onexcel')}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="file" name="excel" id="excel" class="btn btn-success"/>
                    <input type="submit" value="导入excel文件" class="btn btn-success">                    
                </form> -->


            </div>
            <table class="table table-striped">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <thead>
                <tr>
                    <th width="60px"><label><input type="checkbox" class="ckall"/> 选择</label></th>
                    <th width="60px">ID</th>
                    <th width="80px">分类名</th>
                    <th width="80px">文件夹名</th>
                    <th width="80px">文件夹状态</th>
                    <th width="80px">修改时间</th>
                    <th width="50px" align="center">状态</th>
                    <th width="140px">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $test)

                    <tr>

                        <td><input type="checkbox" name="ckbox" value="{{$test->id}}" class="ckbox"/></td>
                        <td>{{$test->id}}</td>
                        <td>{{$test->name}}</td>
                        <td>{{$test->dir_name}}</td>
                        <td>
                            @if(getStyelByDir($test->dir_name)==1)
                                <span class="label label-success ">正常</span>
                                <i style="cursor: pointer; " class="glyphicon glyphicon-trash"><a href="{{url('/admin/wenjian/del',$test->dir_name)}}">删除</a></i>
                            @elseif(getStyelByDir($test->dir_name)==2)
                                <span class="label label-danger">目录不存在</span>
                                <i style="cursor: pointer; " class="glyphicon glyphicon-plus"><a href="{{url('/admin/wenjian/create',$test->dir_name)}}">创建</a></i>
                            @else
                                <span class="label label-danger">网络故障</span>
                                <input type="button" value="刷新" onclick="window.location.href='{{url('/admin/wenjian')}}'" class="btn btn-primary"/>
                            @endif
                        </td>
                        <td>{{$test->updatetime}}</td>
                        <td style="font-size: 18px;">
                            @if($test->show==1)
                                显示
                            @else
                                <span class="label label-danger">关闭</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-default btn-sm" href="javascript:;"
                               onclick="if(confirm('真的要@if($test->show==2)开启@else关闭@endif该模块？')){clock({{$test->id}}); }">
                                <span class="icon-search"></span> 
                                @if($test->show==2)<span class="label label-success">开启</span>
                                @else<span class="label label-danger">关闭</span>@endif</a>
                            <a class="btn btn-success btn-sm" href="{{url('/admin/wenjian/edit',$test->id)}}">编辑</a>
                            <a class="btn btn-success btn-sm" href="{{url('/admin/wenjian/lv',$test->id)}}">查看分级</a>
                            <a class="btn btn-danger btn-sm" href="{{url('/admin/wenjian/dels',$test->id)}}">删除</a>
                        </td>

                    </tr>

                @endforeach
                <tr style="background-color: #f9f9f9;">
                    <td><label><input type="checkbox" class="ckall"/> 选择</label></td>
                    <td colspan="3">
                        <input type="button" class="btn btn-danger btn-sm btn-del-all" value="批量删除"/>
                    </td>
                    <td colspan="5">
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
                    url : "{{url('/admin/wenjian/clock')}}/"+id,
                    dataType : "json",
                    success:function(datas){
                        if(datas==1){
                            alert("操作成功！");
                            window.location.href="";
                        }else{
                            alert("操作失败！");
                        }
                    }//ALAX调用成功
                    ,error:function () {
                        alert("ajax执行失败！");
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
                        console.log(text);
                        $.ajax({
                            type : "POST",
                            url : "{{url('/admin/wenjian/dels')}}",
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