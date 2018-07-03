<?php
/**
 * @Time: [HJZD] (C)2018/06/14/17:06
 * This is not a free software, without any authorization is not allowed to use and spread.
 *
 * @Id  : index.php by zhulang(zhulang@nxhjzddata.com)
 */
use yii\helpers\Html;
?>

<div>
    <a href="<?= yii\helpers\Url::toRoute('export/export')?>" ><button>导出</button></a>
</div>
<?=Html::jsFile('@web/plugins/layui/layui.js')?>
<script>
    layui.use(['laydate', 'laypage', 'layer', 'table', 'form'], function () {
//        $('#export').click(function ()
//        {
//            window.local.href = "<?//= yii\helpers\Url::toRoute('export/export')?>//";
////            $.ajax({
////                url: "<?////= yii\helpers\Url::toRoute('export/export')?>////",
////                method : 'get',
////            })
//        });
    })


</script>
