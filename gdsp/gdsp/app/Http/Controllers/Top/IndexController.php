<?php

namespace App\Http\Controllers\Top;


use App\Http\Controllers\Controller;
use App\Model\Item;
use App\Model\Lv;
use App\Model\Student;
use App\Model\Styels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Request;

class IndexController extends Controller
{
    public function __construct()
    {
//        echo "初始化！";
        date_default_timezone_set('PRC');

    }

    /**
     * 展示给定用户的信息。
     *
     * 前台首页
     *
     */
    public function index()
    {

        return view("top.index");

    }

    /**
     * 展示给定用户的信息。
     *
     * 分类模块
     *
     */
    public function content()
    {
           $data=Styels::where('type',1)->where('show',1)->get();
           $webdata=Styels::where('type',2)->where('show',1)->get();
        if(!$data)
            $data=[];
        if(!$webdata)
            $webdata['id']="1";
//        dd($webdata);
//        dd($data);

        return view("top.content",compact('data','webdata'));

    }
    /**
     * 展示给定用户的信息。
     *
     * 分类模块->详细
     *
     */
    public function contents($id)
    {
        $styel=Styels::where('id',$id)->where('show',1)->first();
        $data=[];
        if($styel){
            $lv=Lv::where('styel',$styel->id)->where('show',1)->get();
//            dd($lv);
            $styels=$styel->dir_name;
            if($lv){
                foreach($lv as $k=>$v){
                    $data[$k][0]=$v;
                    $item=Item::where('styel',$styel->id)->where('status',1)->where('lv',$v->id)->get();
                    if($item)
                        $data[$k][1]=$item;
//                        dd($item);
                }
            }
        }
//        dd($data);

        return view("top.contents",compact('data','styels'));

    }

    /**
     * 展示给定用户的信息。
     *
     * 分类模块->平台
     *
     */
    public function contented($id){
        $data=array
        (
            array("三字一话",'baoming.xenoeye.org','三字一话','images/ppt.jpg'),
            array("竞赛报名",'baoming.xenoeye.org','13','images/ppt.jpg'),
        );
        //0 标题 1 链接 3 描述 4 图片地址
          return view('top.contented',compact('data'));
    }

    /**
     * 默认界面
     */
    public function contentss(){
        echo "欢迎界面";
    }
    public function play($id){
        $item=Item::where('id',$id)->first();
        if($item){
            $data='resdata/'.getDirByStyel($item->styel).'/'.getDirByLv($item->lv).'/'.$item->name;
            $title=$item->title;
            return view('top.play',compact('data','title'));
        }

    }
    public function word($id){
        return view('top.word');
    }
    public function ppt($id){
        return view('top.ppt');
    }




    /**
     * 前台登陆
     *
     */

    public function login()
    {
        return view("top.login");
    }

    /**
     * 前台登陆执行
     *
     */
    public function loging()
    {
        $code = "1234";

        if ($input = Input::all()) {
            $code1 = trim($input['code']);
            $tel = trim($input["id"]);
            $pass = trim($input["pass"]);
            if ($code == $code1 and $code1 != "") {

                $re = Student::where('username', $tel)->first();
                if ($re) {
                    $pass1 = Crypt::decryptString($re->password);
                    if ($pass == $pass1) {
                        $data = array(
                            'id' => $re->uId,
                            'no'=> $re->username,
                            'name' => $re->realName,
                        );

                        session(['gsp_top_user' => $data]);
                        $str = array('t' => '1', 'eror' => '初始化成功！');
                        echo json_encode($str);
                        return;
                    } else {
//                        Session::reflash('captcha');
                        $str = array('t' => '2', 'eror' => '密码或用户名错误！');
                        echo json_encode($str);
                        return;
                    }
                } else {
//                    Session::reflash('captcha');
                    $str = array('t' => '2', 'eror' => '密码或用户名错误！');
                    echo json_encode($str);
                    return;
                }
            } else {
//                Session::reflash('captcha');
                $str = array('t' => '3', 'eror' => '验证码错误！');
                echo json_encode($str);
                return;
            }
        }
    }

    /**
     * 设置密码
     *
     */
    public function quit()
    {
        session(['gdsp_top_user' => null]);
        return view('top.login');
    }

    /**
     * 设置密码
     *
     */
    public function set()
    {
//        $id = '1410805101';
//
//        $pass = Crypt::encryptString('top1410805101');
//        // echo $pass;
////        $re=Admin::first();
//        // echo $re->pass;
//        $re = Student::where('studentid', $id)->first();
//
//        if ($re) {
////            echo $re->pass."<br>";
////            echo Crypt::decryptString($re->pass);
//            Student::where('studentid', $id)->update(['pass' => $pass]);//修改密码
//        } else {
//
//            echo 1;
//        }

    }
}