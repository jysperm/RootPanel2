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
  echo "$k $v\n";
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
                  $r["msg"]="";
                  if(!isset($_POST["id"]))
                  {
                      $r["msg"]="参数不全";
                      break;
                  }
                  $rs=$conn->select("virtualhost",array("id"=>$_POST["id"]));
                  if($rs->read() && $rs->uname==lpAuth::getUName() && $rs->type!="no")
                  {
                      $userDir="/home/{$rs->uname}/";
                      $isOk=true;
                    
                      //domains-域名
                      // (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*
                      // ^ *DOMAIN( DOMAIN)* *$
                      if(!preg_match('/^ *(\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*( (\*\.)?[A-Za-z0-9]+(\-[A-Za-z0-9]+)*(\.[A-Za-z0-9]+(\-[A-Za-z0-9]+)*)*)* *$/',$_POST["domains"]) ||
                         strlen($_POST["domains"]) >128 )
                      {
                          $r["msg"]="域名格式不正确";
                          break;
                      }
                      else
                      {
                          $row["domains"]=strtolower(trim(str_replace("  "," ",$_POST["domains"])));
                          $rsD=$conn->exec("SELECT * FROM `virtualhost` WHERE `id` <> '%i'",$_POST["id"]);
                          while($rsD->read())
                          {
                              $tD=explode(" ",$rsD->domains);
                              if(count(array_intersect($tD,$row["domains"])))
                              {
                                  $r["msg"]="以下域名已被其他人绑定，请联系客服：" . join(" ",array_intersect($tD,$row["domains"]));
                                  $isOk=false;
                              }
                          }
                          if(!$isOk)
                            break;
                      }
                      
                      //template 模板类型
                      if(!in_array($_POST["optemplate"],array("web","proxy","python")))
                      {
                          $r["msg"]="参数错误";
                          break;
                      }
                      else
                      {
                          $row["template"]=$_POST["optemplate"];
                      }
                      
                      //Alias  别名
                      $aliasR=array();
                      $alias=explode("\n",$_POST["alias"]);
                      foreach($alias as $v)
                      {
                          $vv=explode(" ",trim(str_replace("  "," ",$v)));
                          
                          if(isset($vv[0]) && isset($vv[1]) && $vv[0] && $vv[1])
                          {
                          
                              if(!preg_match('/^\S+$/',$vv[0]) || strlen($vv[0]) > 128 )
                              {
                                  $r["msg"].="别名" . $vv[0] . "不正确";
                                  break;
                              }
                              
                              
                              
                              
                              if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$vv[1]) || substr($vv[1],0,strlen($userDir))!=$userDir || strlen($vv[1]) > 512  ||
                                 strpos($vv[1],"/../") || substr($vv[1],-3)=="/.." )
                              {
                                  $r["msg"].="别名" . $vv[1] . "不正确";
                                  break;
                              }
                              
                              //写入对象
                              
                              $aliasR[$vv[0]]=$vv[1];
                          }
                      }
                      
                      $row["alias"]=json_encode($aliasR);
                      
                      // 日志
                      if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["nginxaccess"]) || substr($_POST["nginxaccess"],0,strlen($userDir))!=$userDir || strlen($_POST["nginxaccess"]) > 512  ||
                                 strpos($_POST["nginxaccess"],"/../") || substr($_POST["nginxaccess"],-3)=="/.." )
                      {
                          $r["msg"].="nginxaccess不正确";
                          break;
                      }
                      
                      if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["nginxerror"]) || substr($_POST["nginxerror"],0,strlen($userDir))!=$userDir || strlen($_POST["nginxerror"]) > 512  ||
                                 strpos($_POST["nginxerror"],"/../") || substr($_POST["nginxerror"],-3)=="/.." )
                      {
                          $r["msg"].="nginxerror不正确";
                          break;
                      }
                      
                      if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["apacheaccess"]) || substr($_POST["apacheaccess"],0,strlen($userDir))!=$userDir || strlen($_POST["apacheaccess"]) > 512  ||
                                 strpos($_POST["apacheaccess"],"/../") || substr($_POST["apacheaccess"],-3)=="/.." )
                      {
                          $r["msg"].="apacheaccess不正确";
                          break;
                      }
                      
                      if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["apacheerror"]) || substr($_POST["apacheerror"],0,strlen($userDir))!=$userDir || strlen($_POST["apacheerror"]) > 512  ||
                                 strpos($_POST["apacheerror"],"/../") || substr($_POST["apacheerror"],-3)=="/.." )
                      {
                          $r["msg"].="apacheerror不正确";
                          break;
                      }
                      
                      $row["nginxaccess"]=$_POST["nginxaccess"];
                      $row["nginxerror"]=$_POST["nginxerror"];
                      $row["apacheaccess"]=$_POST["apacheaccess"];
                      $row["apacheerror"]=$_POST["apacheerror"];
                      
                      //SSL
                      if(isset($_POST["isssl"]) && $_POST["isssl"]=="on")
                      {
                          if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["sslcrt"]) || substr($_POST["sslcrt"],0,strlen($userDir))!=$userDir || strlen($_POST["sslcrt"]) > 512  ||
                                 strpos($_POST["sslcrt"],"/../") || substr($_POST["sslcrt"],-3)=="/.." )
                          {
                              $r["msg"].="sslcrt不正确";
                              break;
                          }
                          
                          if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["sslkey"]) || substr($_POST["sslkey"],0,strlen($userDir))!=$userDir || strlen($_POST["sslkey"]) > 512  ||
                                 strpos($_POST["sslkey"],"/../") || substr($_POST["sslkey"],-3)=="/.." )
                          {
                              $r["msg"].="sslkey不正确";
                              break;
                          }
                          
                          if(!file_exists($_POST["sslcrt"]))
                          {
                              $r["msg"].="sslcrt不存在";
                              break;
                          }
                          
                          if(!file_exists($_POST["sslkey"]))
                          {
                              $r["msg"].="sslkey不存在";
                              break;
                          }
                          
                          $row["isssl"]=1;
                          $row["sslcrt"]=$_POST["sslcrt"];
                          $row["sslkey"]=$_POST["sslkey"];
                      }
                      else
                      {
                          $row["isssl"]=0;
                      }
                      
                      
                      switch($_POST["optemplate"])
                      {
                          case "web":
                              switch($_POST["optype"])
                              {
                                  case "all":
                                  
                                  
                                  
                                  
                                  
                                  break;
                                  case "only":
                                  // [A-Za-z0-9_\-\.]+
                                  // ^ *DOMAIN( DOMAIN)* *$
                                  // ^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$
                                  
                                  
                                  if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["php"]) ||
                                     strlen($_POST["php"]) >256 )
                                  {
                                      $r["msg"]="php格式不正确";
                                      $isOk=false;
                                      break;
                                  }
                                  
                                  if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["cgi"]) ||
                                     strlen($_POST["cgi"]) >256 )
                                  {
                                      $r["msg"]="cgi格式不正确";
                                      $isOk=false;
                                      break;
                                  }
                                  
                                  if(isset($_POST["is404"]) && $_POST["is404"]=="on")
                                      $row["is404"]=1;
                                  else
                                      $row["is404"]=0;
                                  
                                  $row["php"]=$_POST["php"];
                                  $row["cgi"]=$_POST["cgi"];
                                  
                                  
                                  break;
                                  case "unless":
                                  
                                  if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["static"]) ||
                                     strlen($_POST["static"]) >256 )
                                  {
                                      $r["msg"]="static格式不正确";
                                      $isOk=false;
                                      break;
                                  }
                                  $row["static"]=$_POST["static"];
                                  
                                  
                                  break;
                                  default:
                                      $r["msg"]="参数错误";
                                      $isOk=false;
                              }
                              
                              $row["type"]=$_POST["optype"];
                              
                              if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["indexs"]) ||
                                     strlen($_POST["indexs"]) >256 )
                              {
                                  $r["msg"]="indexs格式不正确";
                                  $isOk=false;
                                  break;
                              }
                              
                              if(isset($_POST["autoindex"]) && $_POST["autoindex"]=="on")
                                    $row["autoindex"]=1;
                                else
                                    $row["autoindex"]=0;
                                    
                              if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["root"]) || substr($_POST["root"],0,strlen($userDir))!=$userDir || strlen($_POST["root"]) > 512  ||
                                 strpos($_POST["root"],"/../") || substr($_POST["root"],-3)=="/.." )
                              {
                                  $r["msg"].="root不正确";
                                  $isOk=false;
                                  break;
                              }
                              
                              
                              $row["indexs"]=$_POST["indexs"];
                              $row["root"]=$_POST["root"];
                          
                          break;
                          case "proxy":
                          
                          
                          if(!preg_match('%^http://[^\s]*$%',$_POST["root"]) ||
                                     strlen($_POST["indexs"]) >512 )
                              {
                                  $r["msg"]="url格式不正确";
                                  $isOk=false;
                                  break;
                              }
                              
                              $row["root"]=$_POST["root"];
                          
                          break;
                          case "python":
                          
                          
                          if(!preg_match('/^ *[A-Za-z0-9_\-\.]+( [A-Za-z0-9_\-\.]+)* *$/',$_POST["pyindexs"]) ||
                                     strlen($_POST["pyindexs"]) >256 )
                              {
                                  $r["msg"]="pyindexs格式不正确";
                                  $isOk=false;
                                  break;
                              }
                              
                              if(isset($_POST["pyautoindex"]) && $_POST["pyautoindex"]=="on")
                                    $row["autoindex"]=1;
                                else
                                    $row["autoindex"]=0;
                                    
                              if(!preg_match('%^[/A-Za-z0-9_\-\.]+/?$%',$_POST["root"]) || substr($_POST["root"],0,strlen($userDir))!=$userDir || strlen($_POST["root"]) > 512  ||
                                 strpos($_POST["root"],"/../") || substr($_POST["root"],-3)=="/.." )
                              {
                                  $r["msg"].="root不正确";
                                  $isOk=false;
                                  break;
                              }
                              
                              
                              $row["indexs"]=$_POST["pyindexs"];
                              $row["root"]=$_POST["root"];
                          
                          
                          break;
                          default:
                              $r["msg"]="参数错误";
                              $isOk=false;
                      }
                      
                      if(!$isOk)
                          break;
                      
                      
                      
                      
                      $row["lastchange"]=time()+$lpCfgTimeToChina;
                      
                      //写入数据库
                      $r["msg"].="正确".print_r($_POST,true);
                  }
                  else
                  {
                      $r["msg"]="id不存在,或未续费";
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
