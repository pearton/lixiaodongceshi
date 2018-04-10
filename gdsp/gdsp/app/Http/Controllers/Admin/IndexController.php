<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Admin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

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
     * 后台首页
     *
     * 框
     */
    public function index()
    {
        return view("admin.index");
    }
    /**
     * 展示给定用户的信息。
     *
     * 后台首页
     *
     */
    public function content(){
        echo "欢迎使用本系统";
        // $pass = 123456;
        // $pass1 = Crypt::encryptString($pass);
        // echo $pass1;
    }

    /**
     * 后台登陆
     *
     */

    public function login()
    {
       return view("admin.login");
    }

    /**
     * 后台登陆执行
     *
     */
    public function loging(){
        $code="1234";
                try{
                    if($input=Input::all()){
                        $code1 = trim($input['code']);
                        $tel=trim($input["id"]);
                        $pass=trim($input["pass"]);
                        if($code==$code1 and $code1!=""){

                            $re=Admin::where('tel',$tel)->first();
                            if($re){
                                $pass1=Crypt::decryptString($re->pass);
                                if($pass==$pass1){
                                    $data=array(
                                        'id'=>$re->id,
                                        'name'=>$re->name,
                                    );

                                    session(['gdsp_admin_user'=>$data]);
                                    $str= array('t'=>'1', 'eror'=>'<script language="javascript">alert("登陆成功！");</script>');
                                    echo json_encode($str); return;
                                }else{
//                        Session::reflash('captcha');
                                    $str= array('t'=>'2', 'eror'=>'<script language="javascript">alert("密码错误,请重新输入");</script>');
                                    echo json_encode($str); return;
                                }
                            }else{
//                    Session::reflash('captcha');
                                $str= array('t'=>'2', 'eror'=>'<script language="javascript">alert("用户名错误，请重新输入！");</script>');
                                echo json_encode($str); return;
                            }
                        }else{
//                Session::reflash('captcha');
                            $str= array('t'=>'3', 'eror'=>'验证码错误！');
                            echo json_encode($str); return;
                        }
                    }
                }catch (\Exception $e){
                    $str= array('t'=>'2', 'eror'=>'网络或者系统正在维护！');
                    echo json_encode($str); return;

            }

    }



    /**
     * 设置密码
     *
     */
    public function quit(){
        session(['gdsp_admin_user'=>null]);
        return view('admin.login');
    }
    /**
     * 设置密码
     *
     */
    public function set(){
        $id='15730711336';

        $pass= Crypt::encryptString('admin1336');
       // echo $pass;
//        $re=Admin::first();
       // echo $re->pass;
        $re=Admin::where('tel',$id)->first();

        if($re){
//            echo $re->pass."<br>";
//
//            echo Crypt::decryptString($re->pass);
            Admin::where('tel',$id)->update(['pass' => $pass]);//修改密码
        }else{

            echo 1;
        }
    }

 
}