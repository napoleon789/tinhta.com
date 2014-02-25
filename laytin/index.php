<?php
$cmd=(isset($_REQUEST['cmd']) and $_REQUEST['cmd'])?$_REQUEST['cmd']:'';
require 'lib/database.php';
require 'lib/crawler.php';
$temps=Feed::get_template();
$items=Feed::get_items();
Feed::feed_data($cmd);
?>
<?php


function delete_data() {

    $sql = "delete from news";
    $sql1 = "select * from news";
    $result = mysql_query($sql1);
    $num = mysql_num_rows($result);
    if ($num > 200) {
    mysql_query($sql);
    $images = glob("upload/*.*");
    foreach($images as $image){
        @unlink($image);
    }

    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lấy tin tự động từ website khác</title>
<meta name="generator" content="minhtc.net" />
<link href="css/style.css" rel="stylesheet" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/crawler.js" type="text/javascript"></script>
</head>
<body>
<div>
	<div class="clrfix">

    	<h1 class="fl title">Lấy tin tự động</h1>
        <div class="fr">
            <button click="<?php delete_data();?>">Xóa table news</button>
        	<button onclick="feed_data();">Lấy tin</button>
            <button onclick="insert_data();" <?php if(!isset($items) or !$items){?> disabled<?php }?>>Chèn vào Database</button>
        </div>
    </div>
    <form name="feedForm" method="post">
	<div class="fl" style="width:40%;">
        <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse:collapse" bordercolor="#cccccc">
        	<tr class="ht">
            	<th><input type="checkbox" value="1" id="feedForm_all_checkbox" onclick="select_all_checkbox(this.checked);" title="Tất cả" /></th>
            	<th>Mẫu lấy tin</th>
            	<th>Chèn vào danh mục</th>
                <th>Sửa</th>
            </tr>

    		<?php foreach($temps as $key=>$value){ ?>

            <tr>
	            <td width="1%" align="center"><input name="temps[<?php echo $key;?>]" value="<?php echo $key;?>" type="checkbox" id="temps[<?php echo $key;?>]" /></td>
                <td><label for="temps[<?php echo $key;?>]"><?php echo $value['site_name'];?></label>[ <a href="<?php echo $value['url'];?>" target="_blank" title="<?php echo $value['url'];?>">link</a> ]</td>
                <td><?php echo $value['category_title'];?></td>
                <td width="1%" align="center"><a href="declaration_site.php?cmd=edit&id=<?php echo $key;?>"><img src="images/edit.jpg" title="Sửa" alt="Sửa" /></a></td>
            </tr>
	    	<?php }?>
        </table><br />
        <a href="declaration_site.php">Quản lý mẫu lấy tin</a> | <a href="news.php">Danh sách tin đã lấy</a>
	</div>
    <?php if(isset($items) and $items){ ?>
    <div class="template-data fr" style="width:50%;">
    	<h2 style="margin-top:0;">Dữ liệu đã lấy</h2>

    	<ol id="data_result"><?php echo $items;?></ol>
    </div>
    <?php }?>
    <input type="hidden" name="cmd" value="" id="cmd" />
    </form>
    <div align="center"><img src="images/animated_loading.gif" class="hide loading" /></div>

</div>
</body>
</html>