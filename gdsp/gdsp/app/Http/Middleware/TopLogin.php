<?php
/**
 * Created by PhpStorm.
 * User: wmk
 * QQ: 2393209180
 * Date: 2018/3/2
 * Time: 13:29
 */
namespace App\Http\Middleware;

use Closure;

class TopLogin
{
    /**
     * 验证登陆的请求
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('gsp_top_user')){
            date_default_timezone_set('PRC');
            return redirect('/login');
//           echo " <script language=\"javascript\">alert(\"登陆已失效!\");top.location='http://pmoa.te.com/admin/login';</script>";
        }

        return $next($request);
    }

}