<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

$rpL["admin.title"] = "管理员面板";

$rpL["admin.index"] = "概述";
$rpL["admin.users"] = "用户管理";
$rpL["admin.log"] = "日志";
$rpL["admin.ticket"] = "工单";

$rpL["admin.users.no"] = "未开通";
$rpL["admin.users.free"] = "即将到期/免费试用";
$rpL["admin.users.waitDel"] = "等待删除";
$rpL["admin.users.common"] = "正常用户";

$rpL["admin.users.user"] = "用户(UA)";
$rpL["admin.users.ticket"] = "工单";
$rpL["admin.users.email"] = "Email(QQ)";
$rpL["admin.users.last"] = "最后登录";
$rpL["admin.users.expired"] = "到期";
$rpL["admin.users.type"] = "类型";

$rpL["admin.operator"] = "操作";
$rpL["admin.op.addTime"] = "延时";
$rpL["admin.op.createTK"] = "创建工单";
$rpL["admin.op.log"] = "日志";
$rpL["admin.op.loginas"] = "登录为";
$rpL["admin.op.getPasswd"] = "找回密码";
$rpL["admin.op.toStd"] = "开通为标准付费版";
$rpL["admin.op.toExt"] = "开通为额外技术支持版";
$rpL["admin.op.toFree"] = "开通为免费试用版";
$rpL["admin.op.delete"] = "删除用户";
$rpL["admin.op.alert"] = "续费提醒";
$rpL["admin.op.switch"] = "变更付费方式";
$rpL["admin.op.disable"] = "取消帐号";

return $rpL;