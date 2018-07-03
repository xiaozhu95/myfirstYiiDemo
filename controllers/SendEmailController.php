<?php
/**
 * @Time: [HJZD] (C)2018/06/07/18:02
 * This is not a free software, without any authorization is not allowed to use and spread.
 *
 * @Id  : SendEmailController.php by zhulang(zhulang@nxhjzddata.com)
 */
namespace app\controllers;
use Yii;


class SendEmailController extends \yii\web\Controller
{
    public function actionSendEmail ()
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setTo('langzhu_0325@163.com');    // 要发送到的那个人的邮箱，张三要给李四发送邮件，此处设置为李四邮箱地址
        $mail->setSubject("邮件测试");    // 邮箱标题
        $mail->setTextBody('zheshisha ');   // 邮件内容 发布纯文字文本
//        $mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
        if($mail->send())
            echo "success，发送成功!";
        else
            echo "false,发送失败！";
    }
}