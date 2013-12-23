<?php

if (isset($_POST["pubkey"])) {
    $textPubKey = file_get_contents($_POST["pubkey"]);
    $pubKey = openssl_pkey_get_public($textPubKey);

    if (isset($_POST["siteurl"]))
        $info = json_decode(file_get_contents($_POST["siteurl"] . "install/license/"), true);
    else if (isset($_POST["siteid"]))
        $info = ["name" => $_POST["siteid"], "expired" => $_POST["expired"], "certificate" => $_POST["license"]];
    else
        $info = json_decode($_POST["licensejson"], true);

    $strToEncode = "{$info["name"]} {$info["expired"]}";

    $result = openssl_public_decrypt(base64_decode($info["certificate"]), $strDecode, $pubKey);

    if ($result) {
        $strToEncode = "{$info["name"]} {$info["expired"]}";
        if ($strDecode == $strToEncode)
            echo "授权有效，有效期至：{$info["expired"]}";
        else
            echo "站点ID或有效期有误： {$strDecode}";
    } else {
        echo "授权验证失败";
    }

    exit();
}

?>
<html>
<head>
    <meta charset="utf-8">
    <title>RootPanel 授权验证工具</title>
</head>
<body>
<form method="post">
    公钥来源 <input type="text" id="pubkey" name="pubkey"
                value="https://raw.github.com/jybox/RootPanel/master/RootPanel.php.pubkey"/><br/>
    站点URL(含斜线) <input type="text" id="siteurl" name="siteurl"/><br/>
    <input type="submit" value="验证站点">
</form>
<hr/>
<form method="post">
    公钥来源 <input type="text" id="pubkey" name="pubkey"
                value="https://raw.github.com/jybox/RootPanel/master/RootPanel.php.pubkey"/><br/>
    站点ID(域名) <input type="text" id="siteid" name="siteid"/><br/>
    有效期 <input type="text" id="expired" name="expired"/><br/>
    授权信息 <textarea id="license" name="license"></textarea><br/>
    <input type="submit" value="验证授权">
</form>
<hr/>
<form method="post">
    公钥来源 <input type="text" id="pubkey" name="pubkey"
                value="https://raw.github.com/jybox/RootPanel/master/RootPanel.php.pubkey"/><br/>
    授权信息(JSON格式) <textarea id="licensejson" name="licensejson"></textarea><br/>
    <input type="submit" value="验证JSON序列">
</form>
</body>
</html>