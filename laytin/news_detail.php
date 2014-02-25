<?php
require 'lib/database.php';
$id=(isset($_REQUEST['id']) and $_REQUEST['id'])?$_REQUEST['id']:0;
$item=DB::fetch('select * from news where id="'.$id.'"');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $item['name'];?></title>
<meta name="generator" content="minhtc.net" />
<link href="css/style.css" rel="stylesheet" />
</head>
<body>
<a href="javascript:void(0)" onclick="history.go(-1)">Quay lại</a>
<h1><?php echo $item['name'];?></h1>
<p><strong><?php echo $item['brief'];?></strong></p>
<div><?php echo $item['description'];?></div>
</body>
</html>