<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Styels;
use App\Model\Lv;
use App\Model\Item;
use Request;
use PHPExcel;
use PHPWord;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SetController extends Controller
{
    public function __construct()
    {
//        echo "初始化！";
        date_default_timezone_set('PRC');

    }
    public function index(){
        return view('admin.setindex');
    }
    /**
     * Excel一级文件目录导出
     *
     */
    public function putExcel(){
        //查询到文件目录
        $where = new styels;
        $data=$where->orderBy('createtime', 'desc')->get();

        $objPHPExcel= new PHPExcel();

        //    include_once("../app/libs/phpexcel/PHPexcel/IOFactory.php");
        // $data=array(
        //     0=>array('id'=>2013,'name'=>'张某某','age'=>21),
        //     1=>array('id'=>201,'name'=>'EVA','age'=>21)
        // );
        //设置excel列名
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','文件ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','分类名');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','文件夹名');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','操作时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','是否显示与前台');
        //把数据循环写入excel中
        foreach($data as $key => $value){
            $key+=2;
            if($value['show'] == 1){
                $value['show'] = '显示';
            }else{
                $value['show'] = '已隐藏';
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['id']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['dir_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['updatetime']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['show']);
        }
        //excel保存在根目录下  如要导出文件，以下改为注释代码
        $objPHPExcel->getActiveSheet() -> setTitle("表单1");
        $objPHPExcel-> setActiveSheetIndex(0);

        $objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="Brand_' .date('Y-m-d') . '.xls"');//设置导出文件名
        header('Cache-Control:max-age=0');
        $objWriter-> save('php://output');
    }
    /**
     * Excel二级文件目录导出
     *
     */
    public function putExcelerji($id){
        //查询到文件目录
        $where = new Lv;
        $data=$where->orderBy('createtime', 'desc')->where('styel',$id)->get();
        $datas = DB::table('gdsp_styel')->where('id',$id)->first();
        if(is_object($datas)){
            $datas = (array)$datas;
        }
        $objPHPExcel= new PHPExcel();

        //    include_once("../app/libs/phpexcel/PHPexcel/IOFactory.php");
        // $data=array(
        //     0=>array('id'=>2013,'name'=>'张某某','age'=>21),
        //     1=>array('id'=>201,'name'=>'EVA','age'=>21)
        // );
        //设置excel列名
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','文件ID');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','分类名');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','分类文件夹');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','分级名');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','文件夹名');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','修改时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','是否显示');
        //把数据循环写入excel中
        foreach($data as $key => $value){
            $key+=2;
            if($value['show'] == 1){
                $value['show'] = '显示';
            }else{
                $value['show'] = '已隐藏';
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['id']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$datas['name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$datas['dir_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['dir_name']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['updatetime']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['show']);
        }
        //excel保存在根目录下  如要导出文件，以下改为注释代码
        $objPHPExcel->getActiveSheet() -> setTitle("表单1");
        $objPHPExcel-> setActiveSheetIndex(0);

        $objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="Brand_' .date('Y-m-d') . '.xls"');//设置导出文件名
        header('Cache-Control:max-age=0');
        $objWriter-> save('php://output');
    }
    /**
     * Excel资源文件目录导出
     *
     */
    public function putExcelsanji($id = null){
        $where = new Item;
        if($id == null){
            $data=$where->orderBy('createtime', 'desc')->get();
            

            
            $objPHPExcel= new PHPExcel();

            //    include_once("../app/libs/phpexcel/PHPexcel/IOFactory.php");
            // $data=array(
            //     0=>array('id'=>2013,'name'=>'张某某','age'=>21),
            //     1=>array('id'=>201,'name'=>'EVA','age'=>21)
            // );
            //设置excel列名
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','文件ID');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','标题');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','文件名');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','分类名');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','分级名');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','路径');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','修改时间');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','是否显示');
            //把数据循环写入excel中
            foreach($data as $key => $value){
                $key+=2;
                if($value['status'] == 1){
                    $value['status'] = '显示';
                }else{
                    $value['status'] = '已隐藏';
                }
                $datas = DB::table('gdsp_lv')->where('id',$value['lv'])->first();
                if(is_object($datas)){
                $datas = (array)$datas;
                }
                $datass = DB::table('gdsp_styel')->where('id',$datas['styel'])->first();
                if(is_object($datass)){
                $datass = (array)$datass;
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['id']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['title']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$datass['name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$datas['name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$datass['dir_name']."/".$datas['dir_name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['updatetime']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['status']);
            }    
        }else{
        //查询到文件目录
        
            $data=$where->orderBy('createtime', 'desc')->where('lv',$id)->get();
            $datas = DB::table('gdsp_lv')->where('id',$id)->first();        
            if(is_object($datas)){
                $datas = (array)$datas;
            }
            $datass = DB::table('gdsp_styel')->where('id',$datas['styel'])->first();
            if(is_object($datass)){
                $datass = (array)$datass;
            }
            $objPHPExcel= new PHPExcel();

            //    include_once("../app/libs/phpexcel/PHPexcel/IOFactory.php");
            // $data=array(
            //     0=>array('id'=>2013,'name'=>'张某某','age'=>21),
            //     1=>array('id'=>201,'name'=>'EVA','age'=>21)
            // );
            //设置excel列名
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','文件ID');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','标题');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','文件名');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','分类名');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','分级名');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','路径');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','修改时间');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','是否显示');
            //把数据循环写入excel中
            foreach($data as $key => $value){
                $key+=2;
                if($value['status'] == 1){
                    $value['status'] = '显示';
                }else{
                    $value['status'] = '已隐藏';
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value['id']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['title']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$datass['name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$datas['name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$datass['dir_name']."/".$datas['dir_name']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['updatetime']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['status']);
            }
        }
        //excel保存在根目录下  如要导出文件，以下改为注释代码
        $objPHPExcel->getActiveSheet() -> setTitle("表单1");
        $objPHPExcel-> setActiveSheetIndex(0);

        $objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="Brand_' .date('Y-m-d') . '.xls"');//设置导出文件名
        header('Cache-Control:max-age=0');
        $objWriter-> save('php://output');
    }
    /**
     * 文件分类Excel导入
     *
     */

    public function wenjianOnExcel(){
        $file = Request::file('excel');
        if($file){
            $file_type =$file->getClientOriginalExtension();
            if(strtolower($file_type)!="xlsx" and strtolower($file_type)!="xls" ){
                echo "<script language='javascript'>alert('请确认传入excel文件');</script>";
            }else{

                $savePath ="excel/";

                /*以时间来命名上传的文件*/

                $str =date('Ymdhis');

                $fileName =$str . "." . $file_type;
                $file->move($savePath, $fileName);
                $filePath ="./excel/".$fileName; //asset($savePath.$fileName);
                echo $filePath;
                $re =$this->read($filePath,$file_type,'utf-8');
                $time=time();
                if($re){
                      foreach($re as $k=>$v){
                          if($k==1){
                              continue;
                          }
                          $data[$k-2]['id']=trim($v['0']);
                          $data[$k-2]['name']=trim($v['1']);
                          $data[$k-2]['dir_name']=trim($v['2']);
                          $data[$k-2]['discr']=trim($v['3']);
                          $data[$k-2]['show']=trim($v['4']);
                          $data[$k-2]['createtime']=$time;
                          createDir($v['2']);
                      }
                    $styels=new Styels;
                    $styels->saved($data);
                    dd($data);
                }
            }
        }else{
            echo "<script language='javascript'>alert('请先选择excel文件');</script>";
        }

    }

    /**
     * 详细项目Excel导入
     *
     */

    public function itemOnExcel(){
        $file = Request::file('excel');
        $file_type =$file->getClientOriginalExtension();
        if(strtolower($file_type)!="xlsx" and strtolower($file_type)!="xls" ){
            $data['t']=1;
            $data['error']='不是Excel文件，重新上传';
            die();
        }

        $savePath ="excel/";

        /*以时间来命名上传的文件*/

        $str =date('Ymdhis');

        $fileName =$str . "." . $file_type;
        $file->move($savePath, $fileName);
        $filePath ="./excel/".$fileName; //asset($savePath.$fileName);
        echo $filePath;
        $re =$this->read($filePath,$file_type,'utf-8');
        dd($re);

    }

    /**
     * word学生个人综合奖学金报表导出
     *
     */
    public function putword(){
        $PHPWord = new PHPWord();
        $section = $PHPWord->createSection();                           //创建新页面
        //-------------设置文档属性---------------------//
        // $properties = $PHPWord->getProperties();
        // $properties->setCreator('LXD');                                 //创建者
        // $properties->setCompany('科智科技');                            //公司
        // $properties->setTitle('这是word标题');                          //word标题
        // $properties->setDescription('不可描述');                        //word描述
        // $properties->setCategory('word分类？');                         //分类
        // $properties->setLastModifiedBy('一般没有');                     //最后修改人
        // $properties->setSubject('这是word主题');                        //主题
        //-------------设置文档属性end------------------//
        

        //-------------设置文档标题及内容---------------//
        $c = "李小东 同学综合奖学金报表";                                                //文档标题
        $content="*本文档为学生个人综合奖学金申请详情";        //文档内容
        $fontStyle = array('bold'=>true, 'align'=>'center','size'=>25); //标题样式
        $section->addText($c, $fontStyle, 'pStyle');                    //添加标题
        $section->addText($content);                                    //添加内容
        //-------------设置文档标题及内容end------------//
        

        //-------------设置文字样式及表格样式-----------//
        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
        $styleCell = array('valign'=>'center','align'=>'center');
        $fontStyle = array('bold'=>true, 'align'=>'center','size'=>12); //表格字体样式
        $fontStyle0 = array('bold'=>true, 'align'=>'center','size'=>10,'color'=>'0090D7'); //表格字体样式
        $fontStyle1 = array('bold'=>true, 'align'=>'center','size'=>15); //表格字体样式
        $fontStyle2 = array('bold'=>false, 'align'=>'center','size'=>10); //表格字体样式
        $PHPWord->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>1));
        $PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));
        //-------------设置文字样式及表格样式end--------//


        //--------------word表格------------------------// Add row设置行高
        $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
        $table = $section->addTable('myOwnTableStyle');
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText('评测类别', $fontStyle,$styleCell);
        $table->addCell(6300, $styleCell)->addText('详情', $fontStyle,$styleCell);
        $table->addCell(800, $styleCell)->addText('状态', $fontStyle,$styleCell);
        $table->addCell(700, $styleCell)->addText('学分', $fontStyle,$styleCell);

        $term1 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第一学期")->get();  //第一学期成绩
        if(!$term1->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第一学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term1 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term2 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第二学期")->get();  //第二学期成绩
        if(!$term2->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第二学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term2 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term3 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第三学期")->get();  //第三学期成绩
        if(!$term3->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第三学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term3 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term4 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第四学期")->get();  //第四学期成绩
        if(!$term4->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第四学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term4 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term5 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第五学期")->get();  //第五学期成绩
        if(!$term5->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第五学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term5 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term6 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第六学期")->get();  //第六学期成绩
        if(!$term6->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第六学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term6 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term7 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第七学期")->get();  //第七学期成绩
        if(!$term7->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第七学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term7 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term8 = DB::table('stuscholarship')->where('uid',2129)->where('term',"第八学期")->get();  //第八学期成绩
        if(!$term8->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第八学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term8 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        
        //--------------word表格end---------------------//

        $objWriter = \PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        header ( "Content-Description: File Transfer" );
        header('Content-Disposition:attachment;filename="李晓东综合奖学金' .date('Y-m-d') . '.doc"');//设置导出文件名
        $objWriter->save('php://output');           //页面下载
        //$objWriter->save("word/$name.doc");        //保存在本地public下word文件夹

        
    }

    /**
     * word学生多人综合奖学金报表生成
     *
     */
    public function putwordduoren(){
        $data = DB::table('stuinfo')->where('classRoom',"2016级小学教育（全科教师）专业3班")->get();
        foreach($data as $k=>$v){
        $uId = $v->uId;
        $PHPWord = new PHPWord();
        $section = $PHPWord->createSection();                           //创建新页面
        //-------------设置文档属性---------------------//
        // $properties = $PHPWord->getProperties();
        // $properties->setCreator('LXD');                                 //创建者
        // $properties->setCompany('科智科技');                            //公司
        // $properties->setTitle('这是word标题');                          //word标题
        // $properties->setDescription('不可描述');                        //word描述
        // $properties->setCategory('word分类？');                         //分类
        // $properties->setLastModifiedBy('一般没有');                     //最后修改人
        // $properties->setSubject('这是word主题');                        //主题
        //-------------设置文档属性end------------------//
        

        //-------------设置文档标题及内容---------------//
        $c = "$v->realName 同学综合奖学金报表";                                                //文档标题
        $content="*本文档为学生个人综合奖学金申请详情";        //文档内容
        $fontStyle = array('bold'=>true, 'align'=>'center','size'=>25); //标题样式
        $section->addText($c, $fontStyle, 'pStyle');                    //添加标题
        $section->addText($content);                                    //添加内容
        //-------------设置文档标题及内容end------------//
        

        //-------------设置文字样式及表格样式-----------//
        $styleTable = array('borderSize'=>6, 'borderColor'=>'006699', 'cellMargin'=>80);
        $styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'66BBFF');
        $styleCell = array('valign'=>'center','align'=>'center');
        $fontStyle = array('bold'=>true, 'align'=>'center','size'=>12); //表格字体样式
        $fontStyle0 = array('bold'=>true, 'align'=>'center','size'=>10,'color'=>'0090D7'); //表格字体样式
        $fontStyle1 = array('bold'=>true, 'align'=>'center','size'=>15); //表格字体样式
        $fontStyle2 = array('bold'=>false, 'align'=>'center','size'=>10); //表格字体样式
        $PHPWord->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>1));
        $PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));
        //-------------设置文字样式及表格样式end--------//


        //--------------word表格------------------------// Add row设置行高
        $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
        $table = $section->addTable('myOwnTableStyle');
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText('评测类别', $fontStyle,$styleCell);
        $table->addCell(6300, $styleCell)->addText('详情', $fontStyle,$styleCell);
        $table->addCell(800, $styleCell)->addText('状态', $fontStyle,$styleCell);
        $table->addCell(700, $styleCell)->addText('学分', $fontStyle,$styleCell);

        $term1 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第一学期")->get();  //第一学期成绩
        if(!$term1->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第一学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term1 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term2 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第二学期")->get();  //第二学期成绩
        if(!$term2->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第二学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term2 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term3 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第三学期")->get();  //第三学期成绩
        if(!$term3->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第三学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term3 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term4 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第四学期")->get();  //第四学期成绩
        if(!$term4->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第四学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term4 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term5 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第五学期")->get();  //第五学期成绩
        if(!$term5->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第五学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term5 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term6 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第六学期")->get();  //第六学期成绩
        if(!$term6->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第六学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term6 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term7 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第七学期")->get();  //第七学期成绩
        if(!$term7->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第七学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term7 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        $term8 = DB::table('stuscholarship')->where('uid',$uId)->where('term',"第八学期")->get();  //第八学期成绩
        if(!$term8->isEmpty()){
        $table->addRow(350);
        $table->addCell(9200, $styleCell)->addText('第八学期', $fontStyle1,$styleCell);   //$styleCell=表格内文本对齐
        foreach($term8 as $key=>$value){
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition ==2)
            {
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
        $table->addRow(300);
        $table->addCell(1400, $styleCell)->addText($value->module, $fontStyle0,$styleCell);
        $table->addCell(6300, $styleCell)->addText($value->detail, $fontStyle2,$styleCell);
        $table->addCell(800, $styleCell)->addText($shenhe, $fontStyle2,$styleCell);
        $table->addCell(700, $styleCell)->addText($value->credit, $fontStyle2,$styleCell);
        }
        }

        
        //--------------word表格end---------------------//

        $objWriter = \PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        //header ( "Content-Description: File Transfer" );
        //header('Content-Disposition:attachment;filename="李晓东综合奖学金' .date('Y-m-d') . '.doc"');//设置导出文件名
        //$objWriter->save('php://output');           //页面下载
        $objWriter->save("word/$v->realName.doc");        //保存在本地public下word文件夹
        }
        
    }


    /**
     * word学生个人GSP活动报表
     *
     */
    public function putexcelgsp(){
        //查询学生gsp活动
        $res = DB::table('stugspitem')->where('uid',2129)->get();        
        $objPHPExcel= new PHPExcel();
        //设置excel列名
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','项目名称');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','能力平台');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','能力模块');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','项目级别');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','参加时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','等级水平');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','详情');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','状态');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','学分');
        //把数据循环写入excel中
        foreach($res as $key => $value){
            $key+=2;
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition == 2){
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value->plateform);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value->module);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value->level);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value->attendtime);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value->prize);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value->detail);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value->addtime);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$shenhe);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value->credit);
        }
        //excel保存在根目录下  如要导出文件，以下改为注释代码
        $objPHPExcel->getActiveSheet() -> setTitle("表单1");
        $objPHPExcel-> setActiveSheetIndex(0);

        $objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="李晓东GSP' .date('Y-m-d') . '.xls"');//设置导出文件名
        header('Cache-Control:max-age=0');
        $objWriter-> save('php://output');
    }


    /**
     * word学生多人GSP活动报表
     *
     */
    public function putexcelgspduoren(){
        $data = DB::table('stuinfo')->where('classRoom',"2016级小学教育（全科教师）专业3班")->get();  //查询到班级所有学生
        foreach($data as $k=>$v){
            //查询学生gsp活动
            $res = DB::table('stugspitem')->where('uid',$v->uId)->get();        
            $objPHPExcel= new PHPExcel();
            //设置excel列名
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','项目名称');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','能力平台');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','能力模块');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','项目级别');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','参加时间');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','等级水平');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','详情');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','时间');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','状态');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','学分');
            //把数据循环写入excel中
            foreach($res as $key => $value){
                $key+=2;
                if($value->condition == 1){
                    $shenhe = "未审核";
                }elseif($value->condition == 2){
                    $shenhe = "未通过";
                }else{
                    $shenhe = "已通过";
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value->plateform);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value->module);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value->level);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value->attendtime);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value->prize);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value->detail);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value->addtime);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$shenhe);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value->credit);
            }
            //excel保存在根目录下  如要导出文件，以下改为注释代码
            $objPHPExcel->getActiveSheet() -> setTitle("表单1");
            $objPHPExcel-> setActiveSheetIndex(0);

            $objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $filename = $v->realName;
            $filename = iconv("utf-8","gbk",$filename);
            $objWriter->save("excel/$filename.xls");
        }
    }



    /**
     * word学生个人综合素质报表
     *
     */
    public function putexcelsuzhi(){
        //查询学生综合素质
        $res = DB::table('stuinteitem')->where('uid',2129)->get();        
        $objPHPExcel= new PHPExcel();
        //设置excel列名
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','项目名称');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','模块');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','主要内容');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','参加时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','详情');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','添加时间');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','状态');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','学分');
        //把数据循环写入excel中
        foreach($res as $key => $value){
            $key+=2;
            if($value->condition == 1){
                $shenhe = "未审核";
            }elseif($value->condition == 2){
                $shenhe = "未通过";
            }else{
                $shenhe = "已通过";
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$value->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value->module);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value->content);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value->term);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value->detail);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value->addtime);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$shenhe);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value->credit);
        }
        //excel保存在根目录下  如要导出文件，以下改为注释代码
        $objPHPExcel->getActiveSheet() -> setTitle("表单1");
        $objPHPExcel-> setActiveSheetIndex(0);

        $objWriter =\PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="李晓东综合素质' .date('Y-m-d') . '.xls"');//设置导出文件名
        header('Cache-Control:max-age=0');
        $objWriter-> save('php://output');
    }

    /**
     * 压缩文件夹
     *
     */
    function addFileToZip($zipopenname,$zip){

    $handler=opendir($zipopenname); 
    while(($filename=readdir($handler))!==false){

        if($filename != "." && $filename != ".."){

            if(is_dir($zipopenname."/".$filename)){

                addFileToZip($zipopenname."/".$filename, $zip);
                $zip->renameName($zipopenname.$filename,$filename);

            }else { //将文件加入zip对象
                //$con = file_get_contents(iconv('gbk','utf-8',$filename));
                //$zip->addFromString(iconv('gbk','utf-8',$filename),$con);
                $filename = iconv("gbk","utf-8",$filename);
                $zip->addFile($zipopenname."/".$filename);
                $zip->renameName($zipopenname.$filename,$filename);

            }

        }

    }

    @closedir($zipopenname);

    }

    /**
     * word学生多人综合报表导出
     *
     */
    function yasuoword(){
        $zip=new ZipArchive();
        $zipname = 'D:\xiangmu\gdsp\gdsp\public\word/学生报表.zip';    //要生成的压缩文件的地址
        $zipopenname = 'word';    //要压缩的文件夹
        if($zip->open($zipname,ZipArchive::CREATE)=== TRUE){

            $this->addFileToZip($zipopenname, $zip);

            $zip->close(); 
            // header("Content-Type: application/zip");
            // header("Content-Transfer-Encoding: Binary");
            // header ( "Content-Description: File Transfer" );
            // //header("Content-Length: " . filesize('D:\xiangmu\gdsp\gdsp\public\word/学生报表.zip'));
            // header('Content-Disposition:attachment;filename="学生报表.zip"');//设置导出文件名
            // @readfile ('D:\xiangmu\gdsp\gdsp\public\word/学生报表.zip');
        }else{
            echo "压缩失败，检查压缩文件生成的路径是否正确";
        }
    }


    public function read($filename,$extend,$encode='utf-8')
    {

        //include_once('../app/libs/phpexcel/phpexcel/IOFactory.php');

        if($extend=="xlsx"){
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');//use excel2007 for 2007 format
        }else{
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
        }
        $objReader->setReadDataOnly(true);

        $objPHPExcel= $objReader->load($filename);

        $objWorksheet= $objPHPExcel->getActiveSheet();

        $highestRow =$objWorksheet->getHighestRow();

//        echo$highestRow;die;

        $highestColumn = $objWorksheet->getHighestColumn();

        //echo$highestColumn;die;

        $highestColumnIndex =\PHPExcel_Cell::columnIndexFromString($highestColumn);

        $excelData =array();

        for($row = 1;$row <= $highestRow; $row++) {

            for ($col= 0; $col < $highestColumnIndex; $col++) {

                $excelData[$row][]=(string)$objWorksheet->getCellByColumnAndRow($col,$row)->getValue();

            }

        }

        return$excelData;

    }
}