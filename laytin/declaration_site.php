<?php
$cmd=(isset($_REQUEST['cmd']) and $_REQUEST['cmd'])?$_REQUEST['cmd']:'';
require 'lib/database.php';
require 'lib/crawler.php';
$items=Feed::get_template();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Quản lý mẫu lấy tin tự động</title>
<meta name="generator" content="minhtc.net" />
<link href="css/style.css" rel="stylesheet" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/crawler.js" type="text/javascript"></script>
</head>
<body>
<?php
if($cmd=='add' or $cmd=='edit'){
	require_once 'lib/declaration_site_edit.php';
}elseif($cmd=='template'){
	require_once 'lib/declaration_site_template.php';
}else{
	require_once 'lib/declaration_site_list.php';
}
?>
    <br /><a href="javascript:void(0)" onclick="history.go(-1)">Quay lại</a> | <a href="news.php">Danh sách tin đã lấy</a>
</body>
</html>