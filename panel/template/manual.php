<?php

$tmp = new lpTemplate;

$a["title"] = "用户手册";

lpBeginBlock();?>

<li class="active"><a href="#file-access"><i class="icon-chevron-right"></i> 文件权限</a></li>

<?php
$a["rpSidebar"]=lpEndBlock();

lpBeginBlock();?>

<script type="text/javascript">
  $("a[rel=popover]")
  .popover({trigger:"hover"})
  .click(function(e) {
    e.preventDefault()
  });
</script>

<?php
$a["endOfBody"]=lpEndBlock();

?>


<section id="file-access">
  <div class="page-header">
    <h1>文件权限</h1>
  </div>
  <p class="lead">
    Apache2会以你的用户权限来访问网页文件，Nginx会以你的同组用户的权限访问你的网页.<br />
    因此，为了让Apache2和Nginx可以正确访问你的文件，且阻止RP主机上其他用户读写你的文件，你应当将所有文件的权限设置为770,或更低.
    <div class="alert alert-error" style="margin-top:10px;">
      <h4 class="alert-heading">注意!</h4>
      <p>如果你将文件设置为比770更宽松的权限，将导致同主机的其他用户可以读写你的文件，这样非常危险！！</p>
    </div>
    你可以使用下面的命令，将自己的所有文件的权限设置为770：
    <code>
      <i class="icon-chevron-right"></i>chmod -R 770 ~
    </code>
  </p>
</section>

<?php

$tmp->parse("template/base.php",$a);

?>

