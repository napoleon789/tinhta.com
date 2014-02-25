<?php
$cmd=(isset($_REQUEST['cmd']) and $_REQUEST['cmd'])?$_REQUEST['cmd']:'';
if($cmd=='crawler'){
	require_once "simple_html_dom.php"; // Chèn thư viện simple_html_dom
	$link = "http://ngoisao.net/tin-tuc/showbiz-viet/2013/07/mr-dam-mang-thi-sinh-giong-hat-viet-2013-ra-san-khau-lon-246330/"; // link cần lấy tin
	$html = file_get_html($link); // Create DOM from URL or file
	$title_pattern = "h1.Title"; // Mẫu lấy phần tiêu đề
	$brief_pattern = "h2.Lead"; // Mẫu lấy phần tóm tắt
	$description_pattern = "div.detailCT"; // Mẫu lấy phần miêu tả
	$description_pattern_delete = "div.topDetail,h1.Title,h2.Lead,p.RelatedLeadSubject,div.detailNS,div.relateNewsDetail"; // Các mẫu cần xóa trong phần miêu tả
	$item=array();
	// Lấy tiêu đề
	foreach($html->find($title_pattern) as $element)
	{
		$item['title'] = trim($element->plaintext); // Chỉ lấy phần text
	}
	// Lấy tóm tắt
	foreach($html->find($brief_pattern) as $element)
	{
		$item['brief'] = trim($element->plaintext); // Chỉ lấy phần text
	}
	// Lấy miêu tả
	foreach($html->find($description_pattern) as $element)
	{
		// Xóa các mẫu trong miêu tả
		if($description_pattern_delete){
			$arr = explode(',',$description_pattern_delete);
			for($i=0;$i<count($arr);$i++){
				foreach($element->find($arr[$i]) as $e){
					$e->outertext='';
				}
			}
		}
		$item['description'] = $element->innertext; // Lấy toàn bộ phần html
		// Bổ sung đường dẫn ảnh
		if(isset($item['description']) and $item['description']){
			$item['description']=str_replace("/Files/","http://ngoisao.net/Files/",$item['description']);
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lấy tin tự động từ website khác - minhtc.net</title>
<meta name="generator" content="minhtc.net" />
</head>
<body>
<form method="post">
<div>Lấy tin từ: <a href="http://ngoisao.net/tin-tuc/showbiz-viet/2013/07/mr-dam-mang-thi-sinh-giong-hat-viet-2013-ra-san-khau-lon-246330/" target="_blank">http://ngoisao.net/tin-tuc/showbiz-viet/2013/07/mr-dam-mang-thi-sinh-giong-hat-viet-2013-ra-san-khau-lon-246330/</a></div>
<button type="submit">Lấy tin</button><input type="hidden" name="cmd" value="crawler" />
</form>
<?php
if(isset($item) and $item) echo '<h1>'.$item['title'].'</h1><h2>'.$item['brief'].'</h2><div>'.$item['description'].'</div>';
?>
</body>
</html>