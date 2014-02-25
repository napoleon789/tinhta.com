<?php
$item=$_REQUEST;
if(isset($item['ajax']) and $item['ajax']==1 and $url=$item['url']){
	require_once 'lib/simple_html_dom.php';
	require_once 'lib/crawler.php';
	if($html=Feed::html_no_comment($url)){
		$html=str_get_html($html);
		$script=$html->find("script");
		foreach($script as $sc)
		{
			$sc->outertext='';
		}
		$a=$html->find("body",0)->childNodes();
		$noidung="";
		foreach($a as $child)
		{
			$noidung.=$child->outertext();
		}
		$html->clear(); 
		unset($html);
		echo $noidung; exit();
	}
}
?>
