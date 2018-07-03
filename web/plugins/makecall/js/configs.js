/**
 * @link         http://www.hejunzongda.com/
 * @author       yaoliang <yaoliang@hfhjzddata.com>
 * @copyright    Copyright &copy; hjzddata.com, 2015 - 2018
 * @description    呼叫系统配置模块
 */

layui.define(['layer'], function(exports) {
    exports('configs', {
        'ipaddress':ipaddress, // 呼叫系统地址
        'port':5060, // 端口
        'engine':'CJI', // 选择呼叫版本 CE 汉天 CJI astercc
        'model_id':model_id, // 项目ID
    });
});