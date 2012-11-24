<?php if(!isset($lpInTemplate)) die();

global $rpNewsUrl,$rpROOT;

$tmp = new lpTemplate("{$rpROOT}/template/base.php");

$tmp->title = "公告";

lpTemplate::beginBlock();?>

<li class="active"><a href="#news"><i class="icon-chevron-right"></i> 公告</a></li>

<?php
$tmp->rpSidebar=lpTemplate::endBlock();

lpTemplate::beginBlock();?>

<script type="text/javascript">
  $("a[rel=popover]")
  .popover({trigger:"hover"})
  .click(function(e) {
    e.preventDefault()
  });
</script>

<?php
$tmp->endOfBody=lpTemplate::endBlock();

?>


<section id="news">
  <?= file_get_contents($rpNewsUrl);?>
</section>

<?php

$tmp->output();

?>

