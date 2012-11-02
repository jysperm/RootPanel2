<?php

$tmp = new lpTemplate;

if(lpAuth::login())
{
    $conn=new lpMySQL;
    $rs=$conn->select("user",array("uname"=>lpAuth::getUName()));
    $rs->read();
}

$a["title"] = "填写试用申请";

lpBeginBlock();?>

<li class="active"><a href="#request"><i class="icon-chevron-right"></i> 填写试用申请</a></li>
<li><a href="#limits"><i class="icon-chevron-right"></i> 试用帐号限制</a></li>

<?php
$a["rpSidebar"]=lpEndBlock();

lpBeginBlock();?>

<script type="text/javascript">
  $("a[rel=popover]")
  .popover({trigger:"hover"})
  .click(function(e) {
    e.preventDefault()
  });
  
  $($("#ok").click(function(){
    if(defaultValue==$("#content").val())
    {
        alert("你根本没填啊亲！");
        return;
    }
    $.post("/commit/virtualhost/",{"do":"request","content":$("#content").val()},function(data){
      if(data.status=="ok")
          alert("发送成功，请耐心等待回复");
      else
          alert(data.msg);
    },"json");
  }));
  
  $(function(){
    defaultValue=$("#content").val();
  });
</script>

<?php
$a["endOfBody"]=lpEndBlock();

?>


<section id="request">
  <div class="page-header">
    <h1>填写试用申请</h1>
  </div>
  <? if(!lpAuth::login()):?>
  <div class="alert alert-block alert-error fade in">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4 class="alert-heading">注意</h4>
    <p>如果你还没在本站注册过帐号，请先注册帐号再填写申请！.</p>
    <p>
      <a class="btn btn-info" href="/signup/">注册帐号</a>
    </p>
  </div>
  <? else:?>
      <? if($rs->type=="no"): ?>
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4 class="alert-heading">提示</h4>
        <p>你还没有开通RP主机，请填写申请以获得试用，或直接<a class="btn btn-success" href="/pay/">购买</a></p>
        <p>如果你已经发送了申请，请耐心等待回复(你注册时填写的邮箱)，一般会在24小时内回复，无论申请是否通过</p>
      </div>
      <? elseif($rs->type=="free"): ?>
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4 class="alert-heading">提示</h4>
        <p>你已经获得RP主机试用资格了，不过你还可以继续填写申请以获得延期</p>
      </div>
      <? else:?>
      <div class="alert alert-block alert-success fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4 class="alert-heading">提示</h4>
        <p>你在开玩笑吧？你都已经购买付费版了，还申请个毛啊</p>
      </div>
      <? endif;?>
  <? endif;?>
  <? if(lpAuth::login() && ($rs->type=="no" || $rs->type=="free" )): ?>
  <p class="lead">
<textarea id="content" name="content" rows="18">
请先填写下列问卷：
年龄、职业：
从何处得知RP主机：
是否会编程，如果会的话掌握哪些技术：
你将会用RP主机干什么:
-----------------------
简述为什么你需要这个免费试用(100-300字为宜)：
</textarea><br />
    <button id="ok" class="btn btn-success">提交申请</button>
  </p>
  <? endif;?>
</section>

<section id="limits">
  <div class="page-header">
    <h1>试用帐号限制</h1>
  </div>
  <p class="lead">
    CPU时间限制(按天)：500秒(相当于0.6%)<br />
    最小内存保证：10M<br />
    内存竞争系数：0.4(与付费用户竞争内存时的系数)<br />
    硬盘限制：300M<br />
    流量限制(按天)：300M<br />
    流量限制(按月)：3G<br /><br />
    
    不提供客服支持，不担保数据的安全，可能随时被删除(尽可能做到事先通知).
  </p>
</section>

<?php

$tmp->parse("template/base.php",$a);

?>

