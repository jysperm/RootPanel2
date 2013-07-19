<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

/** @var lpLocale $rpL */
$rpL = f("lpLocale");

$rpL->load(["panel", "edit-website"]);

$types = rpVHostType::loadTypes();

$rpDomain = c("NodeList")[c("NodeID")]["domain"];
$vhost = $this["vhost"];

if($this["new"])
{
    $vhost = [
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
        <h4><?= l("edit-website.general"); ?></h4>
        <div class="control-group">
            <label class="control-label" for="ison"><i class="icon-check"></i></label>
            <div class="controls">
                <button id="ison" name="ison" type="button" class="btn <?= ($vhost["ison"]) ? "active" : ""; ?>"
                        data-toggle="button">
                    <?= l("edit-website.enabledSite"); ?>
                </button>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><a href="#" rel="tooltip" title="<?= l("panel.tooltip.id"); ?>"><?= l("panel.website.id"); ?></a></label>
            <div class="controls">
                <span class="label"><?= $vhost["id"]; ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="domains"><a href="#" rel="tooltip" title="<?= l("panel.tooltip.dialog.domain"); ?>"><?= l("edit-website.domain"); ?></a></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="domains" name="domains" value="<?= $vhost["domains"]; ?>"
                       required="required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="source"><a href="#" rel="tooltip" title="<?= l("panel.tooltip.source"); ?>"><?= l("panel.website.source"); ?></a></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="source" name="source" value="<?= $vhost["source"]; ?>"
                       required="required"/>
            </div>
        </div>
    </div>
    <hr/>

    <div class="form-horizontal">
        <h4><?= l("edit-website.siteType"); ?></h4>
        <div class="control-group">
            <label class="control-label">&raquo;</label>
            <div class="controls">
                <? foreach($types as $k => $v): ?>
                    <label class="radio">
                        <input type="radio" name="type" id="op<?= $k; ?>"
                               value="<?= $k; ?>" <?= ($vhost["type"] == $k) ? "checked='checked'" : ""; ?> />
                        <?= $v->meta()["description"]; ?>
                    </label>
                <? endforeach; ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="form-horizontal">
        <h4 id="title-type"><?= $types[$vhost["type"]]->meta()["name"]; ?></h4>
        <? foreach($types as $k => $v): ?>
            <div class="setting-<?= $k; ?>">
                <?= $v->settingsHTML(($vhost["type"] == $k) ? $vhost : ["settings" => $v->defaultSettings()]); ?>
            </div>
        <? endforeach; ?>
    </div>
    <hr/>
    <div class="form-horizontal">
        <h4><?= l("edit-website.common"); ?></h4>
        <div class="control-group">
            <label class="control-label" for="alias"><a href="#" rel="tooltip" title="<?= l("panel.tooltip.alias"); ?>">Alias别名</a></label>
            <div class="controls">
                <label class="radio">
                    <textarea id="alias" name="alias" rows="4"><?php
                        foreach($vhost["general"]["alias"] as $k => $v)
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
                            class="btn <?= ($vhost["general"]["autoindex"]) ? "active" : ""; ?>" data-toggle="button">
                        <?= l("edit-website.autoindex"); ?>
                    </button>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="indexs"><a href="#" rel="tooltip" title="<?= l("panel.tooltip.index");?>"><?= l("edit-website.indexs");?></a></label>
            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="indexs" name="indexs"
                           value="<?= $vhost["general"]["indexs"];?>"/>
                </label>
            </div>
        </div>
    </div>
    <hr/>

    <div class="form-horizontal">
        <h4><?= l("edit-website.ssl");?></h4>
        <div class="control-group">
            <label class="control-label" for="isssl"><i class="icon-check"></i></label>
            <div class="controls">
                <label class="radio">
                    <button id="isssl" name="isssl" type="button"
                            class="btn <?= ($vhost["general"]["isssl"]) ? "active" : ""; ?>"
                            data-toggle="button"><?= l("edit-website.enabledSsl");?>
                    </button>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sslcrt"><?= l("edit-website.sslcrt");?></label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="sslcrt" name="sslcrt"
                           value="<?= $vhost["general"]["sslcrt"]; ?>"/>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="sslkey"><?= l("edit-website.sslkey");?></label>

            <div class="controls">
                <label class="radio">
                    <input type="text" class="input-xxlarge" id="sslkey" name="sslkey"
                           value="<?= $vhost["general"]["sslkey"]; ?>"/>
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
    $("#op<?= $vhost["type"];?>").click();
</script>