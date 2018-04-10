<?php
/**
 * Created by PhpStorm.
 * User: wmk
 * QQ:2393209180
 * Date: 2018/3/2
 * Time: 11:15
 */
use App\Model\Styels;
use App\Model\Lv;
date_default_timezone_set('PRC');
function test(){
    return "测试全局函数";
}

/**
 * @param $object
 * @return mixed
 * 对象数组化
 */
function objToArray(&$object) {
    $object =  json_decode( json_encode( $object),true);
    return  $object;
}

/**
 * @param $name
 * 创建文件夹
 */

function createDir($name)
{
    try{
        $new_file = "resdata/" . $name;
        if (!file_exists($new_file)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            //utf-8 转gbk
            //mkdir($new_file,0700) linux
            //mkdir(iconv('utf-8', 'gbk', $new_file),0700)  window
            if (mkdir(iconv('utf-8', 'gbk', $new_file), 0700))
                return 1;
            else
                return 2;
            //创建失败

        } else {
            //文件夹存在
            return 3;
        }
    }catch (\Exception $e){
        return false;
    }

}

/**
 * @param $name
 * 删除文件夹
 */

function deldir($dir) {
    try{
        $dir=iconv('utf-8', 'gbk', $dir);
        //先删除目录下的文件：
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if($file != "." && $file!="..") {
                $fullpath = $dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $fullpath=iconv('gbk', 'utf-8', $fullpath);
                    deldir($fullpath);
                }
            }
        }
        closedir($dh);

        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }catch (\Exception $e){
        return false;
    }
}


/**
 * @param $dir
 * @return array
 * 读取文件夹下的文件名
 */
function scanfiles($dir) {
    //判断是否文件夹
    try{
    $dir=iconv('utf-8', 'gbk', $dir);

    if (!is_dir( $dir ))
        return false;

    // 兼容各操作系统
    $dir = rtrim ( str_replace ( '\\', '/', $dir ), '/' ) . '/';

    // 栈，默认值为传入的目录
    $dirs = array ( $dir );

    // 放置所有文件的容器
    $rt = array ();

    do {
        // 弹栈
        $dir = array_pop ( $dirs );

        // 扫描该目录
        $tmp = scandir ( $dir );

        foreach ( $tmp as $f ) {
            // 过滤. ..
            if ($f == '.' || $f == '..')
                continue;

            // 组合当前绝对路径
            $path = $dir . $f;
            // 文件名
            $paths =  $f;

            // 如果是目录，压栈。
            if (is_dir ( $path )) {
                array_push ( $dirs, $path . '/' );
            } else if (is_file ( $path )) { // 如果是文件，放入容器中
                $rt [] = iconv('gbk', 'utf-8', $paths);
            }
        }

    } while ( $dirs ); // 直到栈中没有目录

    return $rt;
    }catch (\Exception $e){
        return false;
    }
}

/**
 * @param $name
 * 判断文件夹是否存在
 */
function getStyelByDir($name){
    try{
        $new_file = "resdata/" . $name;
        $new_file=iconv('utf-8', 'gbk', $new_file);
        if (!file_exists($new_file)) {
            return 2;
        }
        return 1;
     }catch (\Exception $e){
        return false;
    }
}

/**
 * @param $id
 * @return bool
 * 获取分类名
 */
function getNameByStyel($id){
    try{
        $re=Styels::where('id',$id)->first();
        if($re){
            return $re->name;
        }else{
            return false;
        }
    }catch (\Exception $e){
        return false;
    }
}
/**
 * @param $id
 * @return bool
 * 获取分级名
 */
function getNameByLv($id){
    try{
        $re=Lv::where('id',$id)->first();
        if($re){
            return $re->name;
        }else{
            return false;
        }
    }catch (\Exception $e){
        return false;
    }
}
/**
 * @param $id
 * @return bool
 * 获取分级文件夹名
 */
function getDirByStyel($id){
    try{
        $re=Styels::where('id',$id)->first();
        if($re){
            return $re->dir_name;
        }else{
            return false;
        }
    }catch (\Exception $e){
        return false;
    }
}
/**
 * @param $id
 * @return bool
 * 获取分级文件夹名
 */
function getDirByLv($id){
    try{
        $re=Lv::where('id',$id)->first();
        if($re){
            return $re->dir_name;
        }else{
            return false;
        }
    }catch (\Exception $e){
        return false;
    }
}

/**
 *
 * @return bool
 * 获取分类ID和名字
 */
function getIdNameByStyel(){
    try{
        $re=Styels::select('id','name')->get();
        if($re){
            return $re;
        }else{
            return false;
        }
    }catch (\Exception $e){
        return false;
    }
}
/**
 * @param $id
 * @param $name
 * @return bool|int
 * 判断分级资源根目录resdata/分类/文件夹名
 */
function getStyelByDirLv($id,$name){
    try{
        $Dir=getDirByStyel($id);
        if(!$Dir)
            return false;

        $new_file = "resdata/" .$Dir.'/'. $name;
        $new_file=iconv('utf-8', 'gbk', $new_file);
        if (!file_exists($new_file)) {
            return 2;
        }
        return 1;
    }catch (\Exception $e){
        return false;
    }
}

/**
 * @param $styel
 * @param $dir
 * @return bool|int
 * 判断项目目录
 */
function getStyelByItem($styel,$dir)
{
    try {
        $styel = "resdata/" . $styel;
        $dir = $styel . '/' . $dir;
        $styel = iconv('utf-8', 'gbk', $styel);
        $dir = iconv('utf-8', 'gbk', $dir);
        if (!file_exists($styel) or !file_exists($dir)) {
            return 2;
        }
        return 1;
    } catch (\Exception $e) {
        return false;
    }
}
    /**
     * @param $styel
     * @param $dir
     * @return bool|int
     * 判断项目文件
     */
    function getItemByItem($styel)
{
        try {
            $styel = "resdata/" . $styel;
            $styel = iconv('utf-8', 'gbk', $styel);
            if (!file_exists($styel)) {
                return 2;
            }
            return 1;
        } catch (\Exception $e) {
            return false;
        }
}
