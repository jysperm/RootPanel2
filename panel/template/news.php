<?php

$tmp = new lpTemplate;

$a["title"] = "公告";

lpBeginBlock();?>

<li class="active"><a href="#news"><i class="icon-chevron-right"></i> 公告</a></li>

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


<section id="news">
  <?= file_get_contents("https://raw.github.com/gist/4078878/borad.html");?>
</section>

<?php

$tmp->parse("template/base.php",$a);

?>

