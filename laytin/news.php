<?php
require 'lib/database.php';
$item_per_page=10;
$page_no=(isset($_REQUEST['page_no']) and $_REQUEST['page_no'])?$_REQUEST['page_no']:1;
$total=DB::fetch('select count(*) as total from news','total');
$items=DB::fetch_all('select * from news limit '.(($page_no-1)*$item_per_page).','.$item_per_page);
mysql_query("SET NAME 'utf-8'");
$total_page=ceil($total/$item_per_page);
//Feed::debug($items);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Danh sách tức đã lấy</title>
<meta name="generator" content="minhtc.net" />
<link href="css/style.css" rel="stylesheet" />
</head>
<body>
<a href="javascript:void(0)" onclick="history.go(-1)">Quay lại</a>
<h1>Danh sách tin tức</h1>
<ul class="news-list">
<?php foreach($items as $key=>$value){ ?>
<li class="clrfix">
	<?php if($value['image_url'] and file_exists($value['image_url'])){ ?>
	<a href="news_detail.php?id=<?php echo $key;?>"><img src="<?php echo $value['image_url'];?>" /></a>
    <?php } ?>
	<h3><a href="news_detail.php?id=<?php echo $key;?>"><?php echo $value['name'];?></a></h3>
    <div><?php echo $value['brief'];?></div>
</li>
<?php }?>
</ul>
<div class="paging"><span>Trang</span>
<?php
for($i=1;$i<=$total_page;$i++){
	echo '<a href="news.php?page_no='.$i.'"'.($page_no==$i?' class="active"':'').'>'.$i.'</a>';
}
?>
</div>
</body>
</html>