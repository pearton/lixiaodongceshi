<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Item;
use App\Model\Lv;
use App\Model\Styels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;

class ItemController extends Controller
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
        $where=new Item ;

        $searchType = trim(request('searchType'));
        $searchTxt = trim(request('searchTxt'));
        $date1=trim(request('date1'));
        $date2=trim(request('date2'));
        $status=trim(request('status'));
        $lvs=null;
        $item_type = $item_type ? $item_type : request('item_type');
        if(!empty($item_type)){
               $where=$where->where('lv',$item_type);
               $lvs=$item_type;
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
                $styel=Styels::where('name','like','%'.$searchTxt.'%')->select('id')->get();

                if($styel){
                    $where=$where->whereIn('styel',$styel);
                }
            }elseif($searchType==3){
                $lv=Lv::where('name','like','%'.$searchTxt.'%')->select('id')->get();
                if($lv){
                    $where=$where->whereIn('lv',$lv);
                }
            }elseif($searchType==4){
                $where=$where->where('name','like','%'.$searchTxt.'%');
            }elseif($searchType==5){
                $where=$where->where('title','like','%'.$searchTxt.'%');
            }else{

            }
        }
        //类型2 开启状态否
        if(!empty($status)){
            if($status==1){
                $where=$where->where('status',1);
            }elseif($status==2){
                $where=$where->where('status',2);
            }else{

            }
        }


        //查询
        $data=$where->orderBy('createtime', 'desc')->paginate(7);
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

            return view('admin.item.index',compact('data','lvs'));
        }else{
        }
    }
    /**
     *
     * 创建文件夹
     */
    public function createitem($id){
        $data=Item::where('id',$id)->select('styel','lv')->first();
        if($data){
            $styel=getDirByStyel($data->styel);
            $dir=getDirByStyel($data->styel).'/'.getDirByLv($data->lv);
            if(getStyelByDir($styel)!=1){
                createDir($styel);
            }
            if(getStyelByDir($dir)!=1){
                createDir($dir);
            }
                return back()->with('errors', "<script> alert(\"创建成功!\");</script>");
        }else{
            return back()->with('errors', "<script> alert(\"创建失败!\");</script>");
        }
    }
//    /**
//     * 添加
//     *
//     */
//    public function add(){
//        $list=Styels::get();
//        if($list){
//            return view('admin.item.add',compact('list'));
//        }else{
//            echo "数据错误，或网络问题！联系运维。。。。";
//        }
//    }
//    /**
//     * 添加执行
//     *
//     */
//    public function added(){
//        $list =Input::except('_token','_method');
//
//        $rules = [
//            'wenjian' => 'required',
//            'name' => 'required',
//            'title' => 'required',
//            'status' => 'required',
//        ];
//        $message = [
//            'wenjian.required' => '<script> alert("文件不能为空！");</script>',
//            'name.required' => '<script> alert("文件名名称不能为空！");</script>',
//            'title.between' => '<script> alert("标题不能为空");</script>',
//            'status.required' => '<script> alert("状态不能为空！!");</script>',
//        ];
//
//        $validator =Validator::make($list, $rules, $message);
//        if ($validator->passes()){
//            $list['createtime']=time();
//            $re = Item::create($list);
//            if ($re){
//                $re1=createDir($list['name']);
//                echo "<script language=\"javascript\">alert(\"添加成功!\");</script>";
//                header("refresh:1;url=/admin/item");
//            }else{
//                return back()->with('errors', "<script> alert(\"添加失败!\");</script>");
//            }
//        }else{
//            return back()->withErrors($validator);
//        }
//    }
    /**
     * 修改
     *
     */
    public function edit($id){
        // $res = new styels ;
        // $re = styels::orderBy('updatetime','desc')->paginate(6);
        // echo $re;
        // die();
        $re=Item::where('id',$id)->first();
        if($re){
            $data=$re;
            return view('admin.item.edit',compact('data'));
        }else{
            echo '<script> alert("不存在！");</script>';
        }
    }
    /**
     * 修改执行
     *
     */
    public function edited(){
        $list =Input::except('_token','_method');

        $rules = [
            'title' => 'required',
        ];
        $message = [
            'title.between' => '<script> alert("标题不能为空");</script>',
        ];

        $validator =Validator::make($list, $rules, $message);
        if ($validator->passes()){
            $re = Item::where('id',$list['id'])->update($list);
            if ($re){
                echo "<script language=\"javascript\">alert(\"修改成功!\");</script>";
                header("refresh:1;url=/admin/item");
            }else{
                return back()->with('errors', "<script> alert(\"修改失败!\");</script>");
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    /**
     * 批量删除
     *
     */
    public function dels(){
        $input=Input::all();
        $txt=$input['txt'];
        $id = explode(",",$txt);
        if($id[0]==null)
            return 2;
        foreach($id as $i){
            $re=Item::where('id',$i)->delete();
        }
        if($re){
            return 1;
        }else{
            return 3;
        }

    }
    /**
     * @param $id
     * 开启或关闭
     */

    public function clock($id){
        try{
            $data=Item::where('id',$id)->first();
            if($data){
                if($data->status==1){
                    $re=Item::where('id',$id)->update(['status'=>2]);
                }else{
                    $re=Item::where('id',$id)->update(['status'=>1]);
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
     * 获取指定文件夹下XXX
     *
     */
    public function select(){
        //创建文件夹
//        $name="数学";
//        $data=createDir($name);
        //读取S文件夹下的所有文件或者子目录下文件
        $name="resdata/数学";
        $data=scanfiles($name);
        dd($data);
    }
    /**
     * 批量自动生成
     *
     */
    public function createditem(){
        $input=Input::all();
        $id=$input['id'];
        $lv=Lv::where('id',$id)->first();
        if($lv){
            $styel=getDirByStyel($lv->styel);
            if($styel){
                $name="resdata/".$styel."/".$lv->dir_name;
                $data=scanfiles($name);

                 if($data){
                     foreach($data as $k=>$v){
                         //判断是否存在该文件的记录  存在，不添加
                        if(Item::where('styel',$lv->styel)->where('lv',$lv->id)->where('name',$v)->count()<1){
                            $list['styel']=$lv->styel;
                            $list['lv']=$lv->id;
                            $list['name']=$v;
                            $list['title']=$v;
                            $list['status']=1;
                            $list['url']="空";
                            $list['discr']=$v;
                            $atype=explode('.',$v);
                            $n=count($atype)-1;

                                  $list['type']=1;
//                                  print_r($atype);
//                                  echo $n;
//                                  die();
                                  switch ($atype[$n])
                                  {
                                      case "ppt":
                                          $list['type']=2;break;
                                      case "pptx":
                                          $list['type']=2;break;
                                      case "doc":
                                          $list['type']=3;break;
                                      case "docx":
                                          $list['type']=3;break;
                                      default:
                                          $list['type']=1;
                                  }

                            $list['createtime']=time();
                            $re=Item::create($list);
                        }
                     }
                 }
            }
        }
       if(isset($re) and $re)
           return 1;
        else
            return 2;
    }

    public function ceshi(){
        return view('admin.item.ceshi');
    }


}