<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Admin;

use App\Model\Item;
use App\Model\Lv;
use App\Model\Styels;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Request;
use Validator;

class WenjianController extends Controller
{
    public function __construct()
    {
//        echo "初始化！";
        date_default_timezone_set('PRC');

    }
    /**
     * 文件类型列表
     *
     */
    public function index($item_type = null)
    {
        $where=new Styels;  

        $searchType = trim(request('searchType'));
        $searchTxt = trim(request('searchTxt'));
        $date1=trim(request('date1'));
        $date2=trim(request('date2'));
        $status=trim(request('status'));
        $item_type = $item_type ? $item_type : request('item_type');
        if(!empty($item_type) and empty($status) ){
            if($status!=9999)
                $where=$where->where('id',$item_type);
        }

        //时间
        if(!empty($date1) and !empty($date2)){
            $sdate1=trim(request('date1'));
            $sdate2=trim(request('date2'));
            $where=$where->where('updatetime','>=',$sdate1)->where('updatetime','<=',$sdate2);
        }
        //类型1  id ,名称,文件夹名
        if(!empty($searchType) and !empty($searchTxt)){
            if($searchType==1){
                $where=$where->where('id',$searchTxt);
            }elseif($searchType==2){
                $where=$where->where('name','like','%'.$searchTxt.'%');
            }elseif($searchType==3){
                $where=$where->where('dir_name','like','%'.$searchTxt.'%');
            }else{

            }
        }
        //类型2 开启状态否
        if(!empty($status)){
            if($status==1){
                $where=$where->where('show',1);
            }elseif($status==2){
                $where=$where->where('show',2);
            }else{

            }
        }

        //查询
        $data=$where->where('type',1)->orderBy('createtime', 'desc')->paginate(7);
        //分页
        if($data){
            $appendData = $data->appends(array(
                'searchType'=>$searchType,
                'searchTxt'=>$searchTxt,
                'date1'=>$date1,
                'date2'=>$date2,
                'status'=>$status,
                'item_type' => $item_type,
            ));

            return view('admin.wenjian.index',compact('data'));
        }
    }

    /**
     * @param $id
     * 创建分类文件夹
     */
    public function create($id){
        $re=createDir($id);
        if($re==1){
            return back()->with('errors', "<script> alert(\"创建成功!\");</script>");
        }else{
            return back()->with('errors', "<script> alert(\"创建失败!\");</script>");
        }
    }
    /**
     * 删除文件夹
     *
     */
    public function del($id){
            // $id = "resdata/"."李小东";
            // if(!file_exists($id)){
            //     echo "没有该文件";
            // }else{
            // deldir($id);
            // echo "成功";
            // }
            // die();
            $id="resdata/" .$id;
            deldir($id);
        return back()->with('errors', "<script> alert(\"删除成功!\");</script>");
    }
    /**
     * @param $id
     * 创建分级文件夹
     */
    public function createlv($id){
        $data=Lv::where('id',$id)->select('styel','dir_name')->first();
        if($data){
            $dir=getDirByStyel($data->styel).'/'.$data->dir_name;
            $re=createDir($dir);
            if($re==1){
                return back()->with('errors', "<script> alert(\"创建成功!\");</script>");
            }else{
                return back()->with('errors', "<script> alert(\"创建失败!\");</script>");
            }
        }else{
            return back()->with('errors', "<script> alert(\"创建失败!\");</script>");
        }
    }
    /**
     * @param $id
     * 删除分级文件夹
     */
    public function dellv($id){

        $id = explode(",",$id);
        if($id[1]==null)
            return 2;
        $ids="resdata/".$id[0].'/'.$id[1];
        deldir($ids);
        return back()->with('errors', "<script> alert(\"删除成功!\");</script>");
    }
    /**
     * 添加页面
     *
     */
    public function add(){
        // $new_file = "resdata/".'李小东';
        // if(!file_exists($new_file)){
        //     if(mkdir(iconv('utf-8','gbk',$new_file),0777)){
        //         echo "创建成功";
        //     }else{
        //         echo "创建失败";
        //     }
        // }else{
        //     echo "文件夹已存在";
        // }
        // die();
        return view('admin.wenjian.add');
    }
    /**
     * 添加执行
     *
     */
    public function added(){
        $list = Input::except('_token','_method','img');
        $file = Request::file('img');
        $allowed_extensions = ["png", "jpg", "gif"];
        if($file){
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                 return back()->with('errors', "<script> alert(\"You may only upload png, jpg or gif.\");</script>");
            }
            
            $destinationPath = 'uploads/styel/'; //public 文件夹下面建 storage/uploads 文件夹
            $extension = $file->getClientOriginalExtension();
            $fileName = str_random(10).'.'.$extension;
            $file->move($destinationPath, $fileName);
            $filePath = $destinationPath.$fileName;
            $list['url']=$filePath;
        }
        $rules = [
            'name' => 'required',
            'dir_name' => 'required',
            'show' => 'required',
        ];
        $message = [
            'dir_name.required' => '<script> alert("文件名名称不能为空！");</script>',
            'name.between' => '<script> alert("标题不能为空");</script>',
            'show.required' => '<script> alert("显示状态不能为空！!");</script>',
        ];

        $validator =Validator::make($list, $rules, $message);    //验证$list中的name、dir_name、show字段是否为空，如果为空，返回弹窗
        if ($validator->passes()){
            $list['createtime']=time();
                // $li = DB::table('gdsp_styel')->where('dir_name',$list['dir_name'])->first();
                $li = Styels::where('dir_name',$list['dir_name'])->first();   //验证文件夹是否存在
                    if($li){
                        return back()->with('errors', "<script> alert(\"文件夹已存在!\");</script>");
                    }else{
                        $re = Styels::create($list);
                        if ($re){
                            createDir($list['dir_name']);
                            echo "   <script language=\"javascript\">alert(\"添加成功!\");</script>";
                            header("refresh:1;url=/admin/wenjian");
                        }else{
                            return back()->with('errors', "<script> alert(\"添加失败!\");</script>");
                        }
                    }
        }else{
            return back()->withErrors($validator);
        }

    }
    /**
     * 修改
     *
     */
    public function edit($id){
        $re=Styels::where('id',$id)->first();
        if($re){
            $data=$re;
            return view('admin.wenjian.edit',compact('data'));
        }else{
            echo '<script> alert("不存在！");</script>';
        }
    }
    /**
     * 修改执行
     *
     */
    public function edited(){
        $list =Input::except('_token','_method','img');
        $file = Request::file('img');
        if(!empty($file)){    //如果有图片更新，则上传图片到项目并更改数据库图片路径，反正，不更新数据库图片信息
            $allowed_extensions = ["png", "jpg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                 return back()->with('errors', "<script> alert(\"You may only upload png, jpg or gif.\");</script>");
            }
            
            $destinationPath = 'uploads/styel/'; //public 文件夹下面建 storage/uploads 文件夹
            $extension = $file->getClientOriginalExtension();
            $fileName = str_random(10).'.'.$extension;
            $file->move($destinationPath, $fileName);
            $filePath = $destinationPath.$fileName;
            $list['url']=$filePath;
        }
            $rules = [
                'name' => 'required',
                'dir_name' => 'required',
                'show' => 'required',
            ];
            $message = [
                'dir_name.required' => '<script> alert("文件名名称不能为空！");</script>',
                'name.between' => '<script> alert("标题不能为空");</script>',
                'show.required' => '<script> alert("状态不能为空！!");</script>',
            ];
            $validator =Validator::make($list, $rules, $message);
            if ($validator->passes()){
                $re = Styels::where('id',$list['id'])->update($list);
                if ($re){
                    echo "   <script language=\"javascript\">alert(\"修改成功!\");</script>";
                    header("refresh:1;url=/admin/wenjian");
                }else{
                    return back()->with('errors', "<script> alert(\"修改失败!\");</script>");
                }
            }else{
                return back()->withErrors($validator);
            }
        
    }

    /**
     * @param $id
     * 开启或关闭
     */

    public function clock($id){
        try{
           $data=Styels::where('id',$id)->where('type',1)->first();
            if($data){
                if($data->show==1){
                   $re=Styels::where('id',$id)->update(['show'=>2]);
                }else{
                    $re=Styels::where('id',$id)->update(['show'=>1]);
                }
                if($re)
                    return 1;
                else
                    return false;
            }
        }catch (\Exception $e){
            return false;
        }
    }
    /**
     * 删除记录
     *
     */
    public function dels($id){
       $re=Styels::where('id',$id)->delete();
        if($re){
            echo "   <script language=\"javascript\">alert(\"删除成功!\");</script>";
            header("refresh:1;url=/admin/wenjian");
        }else{
            return back()->with('errors', "<script> alert(\"删除失败!\");</script>");
        }
    }
    /**
     * 批量删除
     *
     */
    public function delss(){
        $input=Input::all();

        $txt=$input['txt'];
        $id = explode(",",$txt);
        if($id[0]==null)
            return 2;
        foreach($id as $i){
            $re=Styels::where('id',$i)->delete();
        }
        if($re){
            return 1;
        }else{
            return 3;
        }
    }
    /**
     * 分级
     *
     */
    public function lv($id){

        $re=Lv::where('styel',$id)->paginate(6);
        if($re){
            $data=$re;
            return view('admin.wenjian.lvindex',compact('data','id'));
        }else{
            echo '<script> alert("不存在！");</script>';
        }

    }

    /**
     * 分级
     *
     */
    public function lvAdd($id){
        $list=getIdNameByStyel();
            if(!$list){
                echo '<script> alert("网络故障！");</script>';
                die();
            }

        return view("admin.wenjian.lvadd",compact('list','id'));

    }
    /**
     * 分级添加执行
     *
     */
    public function lvAdded(){
        $list =Input::except('_token','_method');

        $rules = [
            'name' => 'required',
            'dir_name' => 'required',
            'styel' => 'required',
        ];
        $message = [
            'dir_name.required' => '<script> alert("文件名名称不能为空！");</script>',
            'name.between' => '<script> alert("标题不能为空");</script>',
            'styel.required' => '<script> alert("分类不能为空！!");</script>',
        ];

        $validator =Validator::make($list, $rules, $message);
        if ($validator->passes()){
            $list['createtime']=time();
                $li = DB::table('gdsp_lv')->where('dir_name',$list['dir_name'])->first();
                    if($li){
                        return back()->with('errors', "<script> alert(\"文件夹已存在!\");</script>");
                    }else{
                        $re = Lv::create($list);
                        if ($re){
                            try{
                                createDir(getDirByStyel($list['styel']));
                                createDir(getDirByStyel($list['styel']).'/'.$list['dir_name']);
                                echo "   <script language=\"javascript\">alert(\"添加成功!\");</script>";
                            }catch (\Exception $e){
                                echo "   <script language=\"javascript\">alert(\"添加成功,生成文件夹失败!\");</script>";
                            }

                            header("refresh:1;url=/admin/wenjian");
                        }else{
                            return back()->with('errors', "<script> alert(\"添加失败!\");</script>");
                        }
                    }
        }else{
            return back()->withErrors($validator);
        }

    }
    /**
     * 修改
     *
     */
    public function lvEdit($id){
        $re=Lv::where('id',$id)->first();
        $list=getIdNameByStyel();
        if(!$list){
            echo '<script> alert("网络故障！");</script>';
            die();
        }
        if($re){
            $data=$re;
            return view('admin.wenjian.lvedit',compact('data','list'));
        }else{
            echo '<script> alert("不存在！");</script>';
        }
    }
    /**
     * 修改执行
     *
     */
    public function lvEdited(){
        $list =Input::except('_token','_method');

        $rules = [
            'name' => 'required',
            'dir_name' => 'required',
            'styel' => 'required',
        ];
        $message = [
            'dir_name.required' => '<script> alert("文件名名称不能为空！");</script>',
            'name.between' => '<script> alert("标题不能为空");</script>',
            'styel.required' => '<script> alert("状态不能为空！!");</script>',
        ];

        $validator =Validator::make($list, $rules, $message);
        if ($validator->passes()){
            $re = Lv::where('id',$list['id'])->update($list);
            if ($re){
                echo "   <script language=\"javascript\">alert(\"修改成功!\");</script>";
                header("refresh:1;url=/admin/wenjian");
            }else{
                return back()->with('errors', "<script> alert(\"修改失败!\");</script>");
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * @param $id
     * 开启或关闭
     */

    public function lvclock($id){
        try{
            $data=Lv::where('id',$id)->first();
            if($data){
                if($data->show==1){
                    $re=Lv::where('id',$id)->update(['show'=>2]);
                }else{
                    $re=Lv::where('id',$id)->update(['show'=>1]);
                }
                if($re)
                    return 1;
                else
                    return false;
            }
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * 批量删除
     *
     */
    public function lvdels(){
        $input=Input::all();
        $txt=$input['txt'];
        $id = explode(",",$txt);
        if($id[0]==null)
            return 2;
        foreach($id as $i){
            $re=Lv::where('id',$i)->delete();
        }
        if($re){
            return 1;
        }else{
            return 3;
        }
    }
    /**
     * 打开系统根目录
     *
     */
    public function mulu(){
        $path = "d:\\xiangmu\\gdsp\\gdsp\\public\\resdata";
        system("cmd.exe /c explorer $path");
        //die();
        //echo "   <script language=\"javascript\">alert(\"添加成功!\");</script>";
        //header("refresh:1;url=/admin/wenjian");
        return redirect('admin/wenjian');
    }


}