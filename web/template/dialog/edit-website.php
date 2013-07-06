<?php

$types = rpVHostType::loadTypes();

$rpDomain = $rpCfg["NodeList"][$rpCfg["NodeID"]]["domain"];

$rs = $this["rs"];

if($this["new"])
{
    $rs = [
        "id" => "XXOO",
        "domains" => substr(md5(time()), 0, 8) . ".{$rpDomain}",
        "type" => "phpfpm",
        "general" => [
            "isssl" => 0,
            "sslcrt" => "",
            "sslkey" => "",
            "indexs" => "index.php index.html index.htm",
            "autoindex" => 1,
            "alias" => []
        ],
        "source" => "/home/" . rpAuth::uname() . "/web/",
        "ison" => 1,
        "settings" => $types["phpfpm"]->defaultSettings()
    ];
}
?>

<form class="website-form">
    <div class="form-horizontal">
        <h4>常规</h4>

        <div class="control-group">
            <label class="control-label" for="ison"><i class="icon-check"></i></label>

            <div class="controls">
                <button id="ison" name="ison" type="button" class="btn <?= ($rs["ison"]) ? "active" : ""; ?>"
                        data-toggle="button">
                    启用站点
                </button>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.id"]; ?>">站点ID</a></label>

            <div class="controls">
                <span class="label"><?= $rs["id"]; ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="domains"><a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.dialog.domain"]; ?>">绑定的域名</a></label>

            <div class="controls">
                <input type="text" class="input-xxlarge" id="domains" name="domains" value="<?= $rs["domains"]; ?>"
                       required="required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="source"><a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.source"]; ?>">数据源</a></label>

            <div class="controls">
                <input type="text" class="input-xxlarge" id="source" name="source" value="<?= $rs["source"]; ?>"
                       required="required"/>
            </div>
        </div>
    </div>
    <hr/>

    <div class="form-horizontal">
        <h4>站点类型</h4>

        <div class="control-group">
            <label class="control-label">&raquo;</label>

            <div class="controls">
                <? foreach($types as $k => $v): ?>
                    <label class="radio">
                        <input type="radio" name="type" id="op<?= $k; ?>"
                               value="<?= $k; ?>" <?= ($rs["type"] == $k) ? "checked='checked'" : ""; ?> />
                        <?= $v->meta()["description"]; ?>
                    </label>
                <? endforeach; ?>
            </div>
        </div>
    </div>
    <hr/>

    <div class="form-horizontal">
        <h4 id="title-type"><?= $types[$rs["type"]]->meta()["name"]; ?></h4>
        <? foreach($types as $k => $v): ?>
            <div class="setting-<?= $k; ?>">
                <?= $v->settingsHTML(($rs["type"] == $k) ? $rs : ["settings" => $v->defaultSettings()]); ?>
            </div>
        <? endforeach; ?>
    </div>
    <hr/>

    <div class="form-horizontal">
        <h4>通用</h4>

        <div class="control-group">
            <label class="control-label" for="alias"><a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.alias"]; ?>">Alias别名</a></label>

            <div class="controls">
                <label class="radio">
                    <textarea id="alias" name="alias" rows="4"><?php
                        foreach($rs["general"]["alias"] as $k => $v)
                            echo "$k $v\n";
                        ?></textarea>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="autoindex"><i class="icon-check"></i></label>

            <div class="controls">
                <label class="radio">
                    <button id="autoindex" name="autoindex" type="button"
                            class="btn <?= ($rs["general"]["autoindex"]) ? "active" : ""; ?>" data-toggle="button">
                        对目录显示文件列表
                    </button>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="indexs"><a href="#" rel="tooltip" title="<?= $rpL["panel.tooltip.index"]; ?>">默认首页</a></label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="indexs" name="indexs"
                           value="<?= $rs["general"]["indexs"]; ?>"/>
                </label>
            </div>
        </div>
    </div>
    <hr/>

    <div class="form-horizontal">
        <h4>SSL</h4>

        <div class="control-group">
            <label class="control-label" for="isssl"><i class="icon-check"></i></label>

            <div class="controls">
                <label class="radio">
                    <button id="isssl" name="isssl" type="button"
                            class="btn <?= ($rs["general"]["isssl"]) ? "active" : ""; ?>"
                            data-toggle="button">启用SSL
                    </button>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sslcrt">SSL证书</label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="sslcrt" name="sslcrt"
                           value="<?= $rs["general"]["sslcrt"]; ?>"/>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sslkey">SSL私钥</label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="sslkey" name="sslkey"
                           value="<?= $rs["general"]["sslkey"]; ?>"/>
                </label>
            </div>
        </div>
    </div>
</form>
<?php
$jsSiteType = "";
foreach($types as $k => $v) {
    $jsSiteType [] = "'{$k}'";
}
?>
<script type='text/javascript'>
    <? foreach($types as $k => $v): ?>
    $("#op<?= $k;?>").click(function () {
        $("#title-type").html('<?= $v->meta()["name"];?>');
        <? foreach($types as $k2 => $v2): ?>
        $(".setting-<?= $k2;?>").hide();
        <? endforeach; ?>
        $(".setting-<?= $k;?>").show();
    });
    <? endforeach; ?>
    $("#op<?= $rs["type"];?>").click();
</script>