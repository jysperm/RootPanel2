<?php

class VirtualHost extends lpPage
{
    public function post()
    {
        global $lpCfgTimeToChina;
        
        if(!lpAuth::login())
        {
            echo "未登录";
            return true;
        }
        
        if(!isset($_POST["do"]))
        {
            echo "参数不全";
            return true;
        }
        
        $conn=new lpMySQL;
        
        $uiHander=array("web"=>"Web根目录",
                "proxy"=>"反向代理URL",
                "python"=>"Web根目录");
        
        switch($_POST["do"])
        {
            case "get":
                if(!isset($_POST["id"]))
                {
                    echo "参数不全";
                    return true;
                }
                else
                {
                    $rs=$conn->select("virtualhost",array("id"=>$_POST["id"]));
                    if($rs->read() && $rs->uname==lpAuth::getUName())
                    {
                          ?>
                          <form class="rp-form" method="post">
                            
                          <div>站点ID：<span class="label"><?= $rs->id;?></span></div>
                          <div>
                            绑定的域名：<input type="text" class="input-xxlarge" id="domains" name="domains" value="<?= trim(str_replace("  "," ",$rs->domains));?>" required="required" />
                          </div>
                          <hr />
                          <div class="box">
                              <header>站点模板：</header>
                              <label class="radio">
                                <input type="radio" name="optemplate" id="opweb" value="web" <?= ($rs->template=="web")?"checked='checked'":"";?> />
                                常规Web(PHP等CGI)
                              </label>
                              <label class="radio">
                                <input type="radio" name="optemplate" id="opproxy" value="proxy" <?= ($rs->template=="proxy")?"checked='checked'":"";?> />
                                反向代理
                              </label>
                              <label class="radio">
                                <input type="radio" name="optemplate" id="oppython" value="python" <?= ($rs->template=="python")?"checked='checked'":"";?> />
                                Python(WSGI模式)
                              </label>
                              <hr />
                              <div class="div-web<?= ($rs->template!="web")?" hide":"";?>">
                                  <div class="box">
                                      <header>脚本处理策略：</header>
                                      <label class="radio">
                                        <input type="radio" name="optype" id="opall" value="all" <?= ($rs->type=="all")?"checked='checked'":"";?> />
                                        全部转到Apache
                                      </label>
                                      <label class="radio">
                                        <input type="radio" name="optype" id="oponly" value="only" <?= ($rs->type=="only")?"checked='checked'":"";?> />
                                        仅转发指定的URL(一般是脚本文件)
                                      </label>
                                      <label class="radio">
                                        <input type="radio" name="optype" id="opunless" value="unless" <?= ($rs->type=="unless")?"checked='checked'":"";?> />
                                        不转发指定的URL(一般是静态文件)
                                      </label>
                                  </div>
                                  <div class="div-only<?= ($rs->type!="only")?" hide":"";?>">
                                      作为PHP脚本处理的后缀：<input type="text" class="input-xxlarge" id="php" name="php" value="<?= trim(str_replace("  "," ",$rs->php));?>" /><br />
                                      作为CGI脚本处理的后缀：<input type="text" class="input-xxlarge" id="cgi" name="cgi" value="<?= trim(str_replace("  "," ",$rs->cgi));?>" />
                                      <label class="checkbox">
                                        <input type="checkbox" id="is404" name="is404" <?= ($rs->is404)?"checked='checked'":"";?> />
                                        将404的请求转发到Apache(多用于URL重写)
                                      </label>
                                  </div>
                                  <div class="div-unless<?= ($rs->type!="unless")?" hide":"";?>">
                                      静态文件后缀:<input type="text" class="input-xxlarge" id="static" name="static" value="<?= trim(str_replace("  "," ",$rs->static));?>" />
                                  </div>
                                  默认首页：<input type="text" class="input-xxlarge" id="indexs" name="indexs" value="<?= trim(str_replace("  "," ",$rs->indexs));?>" />
                                  <label class="checkbox">
                                    <input type="checkbox" id="autoindex" name="autoindex" <?= ($rs->autoindex)?"checked='checked'":"";?> />
                                    开启自动索引
                                  </label>
                              </div>
                              <div class="div-python<?= ($rs->template!="python")?" hide":"";?>">
                                默认首页：<input type="text" class="input-xxlarge" id="pyindexs" name="pyindexs" value="<?= trim(str_replace("  "," ",$rs->indexs));?>" />
                                <label class="checkbox">
                                    <input type="checkbox" id="pyautoindex" name="pyautoindex" <?= ($rs->autoindex)?"checked='checked'":"";?> />
                                    开启自动索引
                                  </label>
                              </div>
                              <?= $uiHander[$rs->template];?>：<input type="text" class="input-xxlarge" id="root" name="root" value="<?= trim(str_replace("  "," ",$rs->root));?>" />
                          </div>
                          Alias别名（一行一对）：<br />
                          <textarea id="alias" name="alias" rows="4">
                            <?php
                              $alias=json_decode($rs->alias,true);
                              foreach($alias as $k => $v)
                              {
                                  echo "$k $v";
                              }
                            ?>
                          </textarea>
                          <hr />
                          <div>
                            nginx access日志：<input type="text" class="input-xxlarge" id="nginxaccess" name="nginxaccess" value="<?= $rs->nginxaccess;?>" /><br />
                            nginx error日志：<input type="text" class="input-xxlarge" id="nginxerror" name="nginxerror" value="<?= $rs->nginxerror;?>" /><br />
                            apache access日志：<input type="text" class="input-xxlarge" id="apacheaccess" name="apacheaccess" value="<?= $rs->apacheaccess;?>" /><br />
                            apache error日志：<input type="text" class="input-xxlarge" id="apacheerror" name="apacheerror" value="<?= $rs->apacheerror;?>" />
                          </div>
                          <hr />
                          <div>
                            <label class="checkbox">
                              <input type="checkbox" id="isssl" name="isssl" <?= ($rs->isssl)?"checked='checked'":"";?> />
                              开启SSL
                            </label>
                            ssl key：<input type="text" class="input-xxlarge" id="sslkey" name="sslkey" value="<?= $rs->sslkey;?>" /><br />
                            ssl crt：<input type="text" class="input-xxlarge" id="sslcrt" name="sslcrt" value="<?= $rs->sslcrt;?>" />
                          </div>
                          </form>
                          <?php
                          return true;
                    }
                    else
                    {
                        echo "id不存在";
                        return true;
                    }
                }
            case "edit":
                while(true)
                {
                  if(!isset($_POST["id"]))
                  {
                      $r["msg"]="参数不全";
                      break;
                  }
                  $rs=$conn->select("virtualhost",array("id"=>$_POST["id"]));
                  if($rs->read() && $rs->uname==lpAuth::getUName())
                  {
                      //domains-域名
                      // (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*
                      // ^ *DOMAIN( DOMAIN)* *$
                      if(!preg_match('/^ *(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*( (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*)* *$/',$_POST["domains"]))
                      {
                          $r["msg"]="域名格式不正确";
                          break;
                      }
                      else
                      {
                          $_POST["domains"]=trim(str_replace("  "," ",$_POST["domains"]));
                      }
                      
                      //参数正确性校验
                      //写入数据库
                      $r["msg"]="正确";
                  }
                  else
                  {
                      $r["msg"]="id不存在";
                      break;
                  }
                  break;
                }
                
                if(isset($r["msg"]))
                    $r["status"]="error";
                else
                    $r["status"]="ok";
                echo json_encode($r);
                return true;
            default:
                echo "参数错误";
                return true;
        }
    }
}

?>
