@extends('admin.hearder.nav1')
@section('content')

    <script src="{{asset('/wdatepicker/WdatePicker.js')}}"></script>
    <div class="right-product my-index right-full" style="width: 90%;left: 10px;">
        <div class="row">
            <div class="span6">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{url('/admin/item')}}">项目</a> <span class="divider">></span>
                    </li>
                    <li class="active">测试</li>
                </ul>
            </div>
        </div>
        <input type="button" value="导出word" onclick="window.location.href='{{url('/admin/putword',$id=1)}}'" class="btn btn-primary"/>
        <script type="text/javascript">
            function clock(id){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type : "GET",
                    url : "{{url('/admin/item/clock')}}/"+id,
                    dataType : "json",
                    success:function(datas){
                        if(datas==1){
                            alert("操作成功！");
                            window.location.href="";
                        }else if(datas==2){
                            window.location.href="";
                        }else if(datas==3){
                            alert("操作失败！");
                            window.location.href="";
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
                        $.ajax({
                            type : "POST",
                            url : "{{url('/admin/item/dels')}}",
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