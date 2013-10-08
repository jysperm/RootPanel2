<?php

defined("lpInLightPHP") or die(header("HTTP/1.1 403 Not Forbidden"));

f("lpLocale")->load(["admin"]);

$user = rpUserModel::find(["uname" => $this["uname"]]);

?>

<form class="website-form">
    <div class="form-horizontal">
        <div class="control-group">
            <label class="control-label" for="pptppasswd"><?= l("admin.settings.pptppasswd");?></label>

            <div class="controls">
                <label class="radio">
                    <textarea id="pptppasswd" name="pptppasswd" rows="6"><?= $user["settings"]["pptppasswd"];?></textarea>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="nginxextconfig"><?= l("admin.settings.nginxextconfig");?></label>

            <div class="controls">
                <label class="radio">
                    <textarea id="nginxextconfig" name="nginxextconfig" rows="6"><?= $user["settings"]["nginxextconfig"];?></textarea>
                </label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="apache2extconfig"><?= l("admin.settings.apache2extconfig");?></label>

            <div class="controls">
                <label class="radio">
                    <textarea id="apache2extconfig" name="apache2extconfig" rows="6"><?= $user["settings"]["apache2extconfig"];?></textarea>
                </label>
            </div>
        </div>
    </div>
</form>