<?php
/**
 * @Time: [HJZD] (C)2018/06/14/16:13
 * This is not a free software, without any authorization is not allowed to use and spread.
 *
 * @Id  : ExportController.php by zhulang(zhulang@nxhjzddata.com)
 */
namespace app\controllers;
use moonland\phpexcel\Excel;
use Yii;
use yii\web\Controller;

/**
 * 实现excel导出功能
 */
class ExportController extends Controller
{
    public function actionIndex ()
    {
        $query = "SELECT category_name FROM product_category";
        $result = Yii::$app->getDb()->createCommand($query)->queryAll();
        var_dump($result);exit();


        var_dump(11);
        var_dump(time());
        echo '<br/>';
        var_dump(date('Y-m-d H-i-s'));
        echo '<br/>';
        var_dump(microtime());
        echo '<br/>';
        var_dump(getdate());
        echo '<br/>';
        var_dump(ceil(5.4));
        echo '<br/>';
        $r = fmod(5.7, 1.3);
        var_dump($r);




        exit();
        return $this->render('index');
    }

    /**
     * 到表内获取相应的数据，然后对数据进行整理，
     */
    public function actionExport ()
    {
        // 获取数据模型
        $query = "SELECT contact,job_name,address,department,created_at,updated_at FROM hj_job";
        $result = Yii::$app->getDb()->createCommand($query)->queryAll();
        if(!empty($result)) {
            foreach ($result as $key => $value) {
                $result[$key]['job_name'] = !empty($value['job_name']) ? $value['job_name'] : '';
            }
        }
        $fileName = '测试表格';
        $mergeTitle = '测试合并表头';
        /* 填充表头 */
        $excelTitle = ['联系方式', '岗位名称', '工作地址', '所属部门', '创建时间', '更新时间'];
        $this->excelExport($fileName,$excelTitle,$mergeTitle,$result);
    }

    /**
     * 将导出方法封装出来
     * $fileName 文件名称 string
     * $excelTitle 表列的名称 array
     * $mergeTitle 合并行的表头 string
     * $result 从数据库中查出的数据 array
     */
    public function excelExport ($fileName = '', $excelTitle = [], $mergeTitle = '', $result = [])
    {
        $excelObject = new \PHPExcel();

        /**
         * 对表格进行整理
         */
        // 设置列
        $colSpanCell = ['A', 'B', 'C', 'D', 'E', 'F'];

        /* 设置每列宽度 */
        $excelObject->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $excelObject->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excelObject->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $excelObject->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excelObject->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $excelObject->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        /* 设置行 */
        $excelObject->getActiveSheet()->getRowDimension('1')->setRowHeight(40);    // 设置单行第一行高度
        // 字体和样式
        $excelObject->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);   //字体大小
        $excelObject->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(true); //第二行是否加
        $excelObject->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);    //第一行是否加粗
        $excelObject->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);         //第一行字体大小
        //设置水平居中
        $excelObject->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置垂直居中
        $excelObject->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $excelObject->getActiveSheet()->mergeCells('A1:F1');
        $excelObject->setActiveSheetIndex()->setCellValue('A1', $mergeTitle);

        $j = 2;
        if (!empty($excelTitle)) {
            foreach ($excelTitle as $excelTitleKey => $excelTitleValue) {
                $excelObject->setActiveSheetIndex()->setCellValue($colSpanCell[$excelTitleKey].$j, $excelTitleValue);
                $excelObject->getActiveSheet()->getRowDimension($j)->setRowHeight(20);
            }
        }

        $style = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        $borderNum = 'A1:F' . (count($result) + 2);
        $excelObject->getActiveSheet()->getStyle($borderNum)->applyFromArray($style);

        /* 合并及加粗后的行需要特殊定义居中 */
        $excelObject->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excelObject->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $excelObject->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excelObject->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

        /* 对内容进行填充到每个单元格内 */
        if (!empty($result)) {
            foreach ($result as $resultValue) {
                $i = 0;
                $j++;
                if (is_array($resultValue)) {
                    foreach ($resultValue as $value) {
                        $excelObject->setActiveSheetIndex()->setCellValue($colSpanCell[$i].$j, $value);
                        $i++;
                    }
                }
                $excelObject->getActiveSheet()->getRowDimension($j)->setRowHeight(20);
            }
        }

        $objWrite = \PHPExcel_IOFactory::createWriter($excelObject, 'Excel2007');
        header('pragma:public');
        //设置输出文件名及格式
        header("Content-Disposition:attachment;filename=$fileName.xls");
        $objWrite->save('php://output');

    }

}