<?php

global $rpCfg, $lpApp, $rpROOT, $rpVHostType;

require_once("{$rpROOT}/handler/vhost-types.php");

$rpDomain = $rpCfg["NodeList"][$rpCfg["NodeID"]]["domain"];

if(isset($new) && $new) {
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
        "source" => "/home/" . $lpApp->auth()->getUName() . "/web/",
        "ison" => 1,
        "settings" => ["server" => ""],
    ];
}
?>

<form class="website-form">
  <div class="form-horizontal">
    <h4>常规</h4>
    <div class="control-group">
      <label class="control-label" for="ison"><i class="icon-check"></i></label>
      <div class="controls">
        <button id="ison" name="ison" type="button" class="btn <?= ($rs["ison"]) ? "active" : "";?>" data-toggle="button">
          启用站点
        </button>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">站点ID</label>
      <div class="controls">
        <span class="label"><?= $rs["id"];?></span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="domains">绑定的域名</label>
      <div class="controls">
        <input type="text" class="input-xxlarge" id="domains" name="domains" value="<?= $rs["domains"];?>"
               required="required"/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="source">数据源</label>
      <div class="controls">
        <input type="text" class="input-xxlarge" id="source" name="source" value="<?= $rs["source"];?>"
               required="required"/>
      </div>
    </div>
  </div>
  <hr />

  <div class="form-horizontal">
    <h4>站点类型</h4>
    <div class="control-group">
      <label class="control-label">&raquo;</label>
      <div class="controls">
          <? foreach($rpVHostType as $k => $v): ?>
            <label class="radio">
              <input type="radio" name="type" id="op<?= $k;?>"
                     value="<?= $k;?>" <?= ($rs["type"] == $k) ? "checked='checked'" : "";?> />
                <?= $v["description"];?>
            </label>
          <? endforeach; ?>
      </div>
    </div>
  </div>
  <hr />

  <div class="form-horizontal">
    <h4><?= $rpVHostType[$rs["type"]]["name"];?></h4>
    <? foreach($rpVHostType as $k => $v): ?>
    <div class="website-<?= $k;?>">
        <?= $v["html-setting"](($rs["type"] == $k) ? $rs : ["settings" => $v["default-settings"]()]);?>
    </div>
    <? endforeach; ?>
  </div>
  <hr />

  <div class="form-horizontal">
    <h4>通用</h4>
    <div class="control-group">
      <label class="control-label" for="alias">Alias别名</label>
      <div class="controls">
        <label class="radio">
<textarea id="alias" name="alias" rows="4">
<?php
foreach($rs["general"]["alias"] as $k => $v)
    echo "$k $v\n";
?>
</textarea>
        </label>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="autoindex"><i class="icon-check"></i></label>
      <div class="controls">
        <label class="radio">
          <button id="autoindex" name="autoindex" type="button"
                  class="btn <?= ($rs["general"]["autoindex"]) ? "active" : "";?>" data-toggle="button">对目录显示文件列表
          </button>
        </label>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="indexs">默认首页</label>
      <div class="controls">
        <label class="radio">
          <input type="text" class="input-xxlarge" id="indexs" name="indexs" value="<?= $rs["general"]["indexs"];?>"/>
        </label>
      </div>
    </div>
  </div>
  <hr />

  <div class="form-horizontal">
    <h4>SSL</h4>
    <div class="control-group">
      <label class="control-label" for="isssl"><i class="icon-check"></i></label>
      <div class="controls">
        <label class="radio">
          <button id="isssl" name="isssl" type="button" class="btn <?= ($rs["general"]["isssl"]) ? "active" : "";?>"
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
                 value="<?= $rs["general"]["sslcrt"];?>"/>
        </label>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="sslkey">SSL私钥</label>
      <div class="controls">
        <label class="radio">
          <input type="text" class="input-xxlarge" id="sslkey" name="sslkey"
                 value="<?= $rs["general"]["sslkey"];?>"/>
        </label>
      </div>
    </div>
  </div>
</form>