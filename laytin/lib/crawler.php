<?php
ob_start ();
class Feed
{
	static $items = array();
	function save_site_structure($cmd,$id,$site){
		if($cmd=='template' and $id and $site){
			// Cập nhật đường dẫn ảnh trong nội dung
			$image_content_left=(isset($_REQUEST['image_content_left']) and $_REQUEST['image_content_left'])?$_REQUEST['image_content_left']:'';
			$image_content_right=(isset($_REQUEST['image_content_right']) and $_REQUEST['image_content_right'])?$_REQUEST['image_content_right']:'';
			DB::update('site',array('image_content_left'=>$image_content_left,'image_content_right'=>$image_content_right),'id='.$id);
			// Lưu dữ liệu cấu trúc trang chi tiết
			DB::delete('site_structure','site_id='.$id);
			$field=(isset($_REQUEST['field']) and $_REQUEST['field'])?$_REQUEST['field']:false;
			if($field){
				foreach($field as $key=>$value){
					$arr=array(
						'field_name'=>$key,
						'extra'=>$value['extra'],
						'element_delete'=>$value['element_delete'],
						'site_id'=>$id
					);
					DB::insert('site_structure',$arr);
				}
			}
			header('Location:declaration_site.php?cmd=template&id='.$id);
		}
	}
	function save_site($cmd,$id){
		if($cmd=='edit' and $id and $site=DB::fetch('select * from site where id='.$id)){
			$site_edit=array();
			$site_edit['name']=(isset($_REQUEST['name']) and $_REQUEST['name'])?$_REQUEST['name']:'';
			$site_edit['host']=(isset($_REQUEST['host']) and $_REQUEST['host'])?$_REQUEST['host']:'';
			$site_edit['url']=(isset($_REQUEST['url']) and $_REQUEST['url'])?$_REQUEST['url']:'';
			$site_edit['table_name']=(isset($_REQUEST['table_name']) and $_REQUEST['table_name'])?$_REQUEST['table_name']:'';
			$site_edit['pattern_bound']=(isset($_REQUEST['pattern_bound']) and $_REQUEST['pattern_bound'])?$_REQUEST['pattern_bound']:'';
			$site_edit['extra']=(isset($_REQUEST['extra']) and $_REQUEST['extra'])?$_REQUEST['extra']:'';
			$site_edit['category_id']=(isset($_REQUEST['category_id']) and $_REQUEST['category_id'])?$_REQUEST['category_id']:'';
			$site_edit['page_num']=(isset($_REQUEST['page_num']) and $_REQUEST['page_num'])?$_REQUEST['page_num']:'';
			$site_edit['image_pattern']=(isset($_REQUEST['image_pattern']) and $_REQUEST['image_pattern'])?$_REQUEST['image_pattern']:'';
			$site_edit['image_dir']=(isset($_REQUEST['image_dir']) and $_REQUEST['image_dir'])?$_REQUEST['image_dir']:'';
			$site_edit['image_content_left']=(isset($_REQUEST['image_content_left']) and $_REQUEST['image_content_left'])?$_REQUEST['image_content_left']:'';
			$site_edit['image_content_right']=(isset($_REQUEST['image_content_right']) and $_REQUEST['image_content_right'])?$_REQUEST['image_content_right']:'';
			$site_edit['begin']=(isset($_REQUEST['begin']) and $_REQUEST['begin'])?$_REQUEST['begin']:'';
			$site_edit['end']=(isset($_REQUEST['end']) and $_REQUEST['end'])?$_REQUEST['end']:'';
			DB::update('site',$site_edit,'id='.$id);
			header('Location:declaration_site.php?cmd=edit&id='.$id);
		}else{
			$site_edit=array();
			$site_edit['name']=(isset($_REQUEST['name']) and $_REQUEST['name'])?$_REQUEST['name']:'';
			$site_edit['host']=(isset($_REQUEST['host']) and $_REQUEST['host'])?$_REQUEST['host']:'';
			$site_edit['url']=(isset($_REQUEST['url']) and $_REQUEST['url'])?$_REQUEST['url']:'';
			$site_edit['table_name']=(isset($_REQUEST['table_name']) and $_REQUEST['table_name'])?$_REQUEST['table_name']:'';
			$site_edit['pattern_bound']=(isset($_REQUEST['pattern_bound']) and $_REQUEST['pattern_bound'])?$_REQUEST['pattern_bound']:'';
			$site_edit['extra']=(isset($_REQUEST['extra']) and $_REQUEST['extra'])?$_REQUEST['extra']:'';
			$site_edit['category_id']=(isset($_REQUEST['category_id']) and $_REQUEST['category_id'])?$_REQUEST['category_id']:'';
			$site_edit['page_num']=(isset($_REQUEST['page_num']) and $_REQUEST['page_num'])?$_REQUEST['page_num']:'';
			$site_edit['image_pattern']=(isset($_REQUEST['image_pattern']) and $_REQUEST['image_pattern'])?$_REQUEST['image_pattern']:'';
			$site_edit['image_dir']=(isset($_REQUEST['image_dir']) and $_REQUEST['image_dir'])?$_REQUEST['image_dir']:'';
			$site_edit['image_content_left']=(isset($_REQUEST['image_content_left']) and $_REQUEST['image_content_left'])?$_REQUEST['image_content_left']:'';
			$site_edit['image_content_right']=(isset($_REQUEST['image_content_right']) and $_REQUEST['image_content_right'])?$_REQUEST['image_content_right']:'';
			$site_edit['begin']=(isset($_REQUEST['begin']) and $_REQUEST['begin'])?$_REQUEST['begin']:'';
			$site_edit['end']=(isset($_REQUEST['end']) and $_REQUEST['end'])?$_REQUEST['end']:'';
			$id=DB::insert('site',$site_edit);
			header('Location:declaration_site.php?cmd=edit&id='.$id);
		}
	}
	function delete_site($id){
		if($id and $site=DB::fetch('select * from site where id='.$id)){
			DB::delete('site_structure','site_id='.$id);
			DB::delete('site','id='.$id);
		}
		header('Location:declaration_site.php');
	}
	static function feed_data($cmd){
		if($cmd=='insert_database'){
			$dir = 'cache/temp_data.cache.php';
			if(file_exists($dir)){
				require $dir;
				if(isset($items) and $items){
					foreach($items as $key=>$value){
						//Feed::debug($value);
						$table=$value['table'];
						if(!DB::fetch('select id from '.$table.' where name="'.str_replace('"','\"',$value['name']).'"')){
                          mysql_query("SET NAMES utf8");
							unset($value['table']);

							DB::insert($table,$value);
						}
					}
					@unlink($dir);
				}
			}

			header('Location:'.$_SERVER['REQUEST_URI']);
		}else
		if($cmd=='feed' and $temps=$_REQUEST['temps']){
			// Lấy tin
			$temps = implode(',',$temps);
			require_once 'lib/simple_html_dom.php';
			require_once 'lib/crawler.php';
			if($sites = Feed::get_site('site.id in ('.$temps.')'))
			{
				//Feed::debug($sites);
				foreach($sites as $key=>$value)
				{
					$check_page = strpos($value['url'],'*');
					if($check_page===false){
						Feed::get_data($value,Feed::get_pattern($key));
					}else{
						if($page_num = $value['page_num']){
							$check_page_num = strpos($page_num,'-');
							if($check_page_num===false){
								$value['url'] = str_replace('*',$page_num,$value['url']);
								Feed::get_data($value,Feed::get_pattern($key));
							}else{
								$arr_page = explode('-',$page_num);
								for($i=$arr_page[1];$i>=$arr_page[0];$i--){
									$site = $value;
									$site['url'] = str_replace('*',$i,$value['url']);
									Feed::get_data($site,Feed::get_pattern($key));
								}
							}
						}else{
							$value['url'] = str_replace('*','1',$value['url']);
							Feed::get_data($value,Feed::get_pattern($key));
						}
					}
				}
				// Lưu tin đã lấy vào file cache
				$path = 'cache/temp_data.cache.php';
				$content = '<?php $items = '.var_export(Feed::$items,true).';?>';
				$handler = fopen($path,'w+');
				fwrite($handler,$content);
				fclose($handler);
			}
			header('Location:'.$_SERVER['REQUEST_URI']);
		}
	}
	function get_template()
	{
		return DB::fetch_all('
			SELECT
				site.*,
				site.name as site_name,
				category.name as category_title
			FROM
				site
				LEFT OUTER JOIN category ON site.category_id=category.id
			ORDER BY
				site.name
		');
	}
	function get_items(){
		$data='';
		$dir = 'cache/temp_data.cache.php';
		if(file_exists($dir)){
			require $dir;
			if(isset($items) and $items){
				foreach($items as $key=>$value){
					$data .= '<li>'.$value['name'].'</li>';
				}
			}
		}
		return $data;
	}	
	function get_site($cond = 1)
	{
		return DB::fetch_all('
			SELECT
				site.*
			FROM
				site 
			WHERE
				'.$cond.'
			ORDER BY	
				site.id DESC
		');
	}
	function get_pattern($site_id)
	{
		return DB::fetch_all('
			SELECT
				*
			FROM
				site_structure
			WHERE
				site_id='.$site_id.'		
			ORDER BY
				id desc	
		');
	}
	function format_link($source,$format=false)
	{
		if($format)
		{
			$source = str_replace(' ','%20',$source);	
		}
		else
		{
			if(strrpos($source,'?')===true)
			{
				$source = substr($source,0,strrpos($source,'?'));
			}
			$source = str_replace(' ','',$source);	
		}
		return $source;
	}
	function save($sour,$dest)
	{
		$sour = Feed::format_link($sour,true);
		if(!file_put_contents($dest, file_get_contents($sour))){
			$dest = '';
		}
	}
	function parse_row($link,$pattern,$site)
	{
		$html=Feed::html_no_comment($link);
		if($html){
			$html = str_get_html($html);
			$item = array();
			$check = false;
			if(isset($site['image_url']) and $site['image_url'])
			{
				$item['image_url'] = $site['image_url'];
			}
			if($pattern)
			{
				foreach($pattern as $key=>$value)
				{
					$element_delete = $value['element_delete'];
					if($detail_pattern = $value['extra']){
						foreach($html->find($detail_pattern) as $element)
						{
							if($element_delete){
								$arr = explode(',',$element_delete);
								for($i=0;$i<count($arr);$i++){
									foreach($element->find($arr[$i]) as $e){
										$e->outertext='';
									}
								}
							}
							if($value['field_name']=='name' or $value['field_name']=='brief'){
								$item[$value['field_name']] = trim($element->plaintext);
							}else{
								$item[$value['field_name']] = $element->innertext;
							}
							break;
						}
					}
				}
				if(isset($item['name']))
				{
					foreach(Feed::$items as $key=>$value){
						if($value['name']==$item['name']) $check=true;
					}
					if(!$check){
						// Viết lại đường dẫn ảnh trong nội dung
						if(isset($item['description']) and $item['description']){
							$item['description']=str_replace($site['image_content_left'],$site['image_content_right'],$item['description']);
						}
						$item+= array(
							'category_id'=>$site['category_id'],
							'table'=>$site['table_name']
						);
						Feed::$items[] = $item;
					}
				}
			}
			$html->clear();
			unset($html);
		}
	}
	function get_data($site,$pattern)
	{
		$html=Feed::html_no_comment($site['url']);
		if($html){
			//Feed::debug($html);
			$hd = $site['begin'];
			$ft = $site['end'];
			
			if(!$hd or !($bg = strpos($html,$hd))) $bg = 0;
			if(!$ft or !($end = strpos($html,$ft))) $end = strlen($html);
			
			$html = substr($html,$bg+strlen($hd),$end-$bg-strlen($hd));
			
			$html = str_get_html($html);
			
			$host = $site['host'];
			$pattern_bound = $site['pattern_bound'];
			$pattern_link = $site['extra'];
			$pattern_img = $site['image_pattern'];
			
			$folder=$site['image_dir']; // Thư mục chứa ảnh
			if(!is_dir($folder)) @mkdir($folder,0755,true);
			$num=0;
			$maxitem=1000;
			foreach($html->find($pattern_bound) as $item)
			{
				if($num>=$maxitem) break;
				$num++;
				foreach($item->find($pattern_link) as $link){
					$link = Feed::check_link($link->getAttribute('href'),$host);
				}
				if(Feed::check_url($link)){
					$items = $item->find($pattern_img);
					if($items and count($items)){
						foreach($items as $img){
							$image_url=$img->src;
						}
						$source = Feed::check_link($image_url,$site['host']);
						$basename = basename($source);
						// Thư mục chứa ảnh
						if(file_exists($folder.'/'.$basename)){
							$dest = $folder.'/'.time().'_'.$basename;
						}else{
							$dest = $folder.'/'.$basename;
						}
						Feed::save($source,$dest);
						$site['image_url'] = $dest;
					}else{
						$site['image_url'] = '';
					}
					//Feed::debug($site);
					Feed::parse_row($link,$pattern,$site);
				}
			}
		}
		$html->clear();
		unset($html);
	}
	function check_link($url,$host='')
	{
		if((strpos($url,'http://')===false) and (preg_match_all('/http:\/\/(.*)\.([a-z]+)\//',$host,$matches,PREG_SET_ORDER)))
		{
			while ($url{0}=='/'){
				$url=substr($url,1);
			}
			if($matches[0][0]{strlen($matches[0][0])-1}!='/'){
				$matches[0][0]=$matches[0][0].'/';
			}
			$url = $matches[0][0].$url;
		}
		return $url;
	}
	function check_url($url=NULL){
		if($url == NULL) return false;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);//lay code tra ve cua http
		curl_close($ch);
		return ($httpcode>=200 && $httpcode<300);
	}
	function _isCurl(){
		return function_exists('curl_version');
	}
	function _urlencode($url){
		$output="";
		for($i = 0; $i < strlen($url); $i++) 
		$output .= strpos("/:@&%=?.#", $url[$i]) === false ? urlencode($url[$i]) : $url[$i]; 
		return $output;
	}
	function file_get_contents_curl($url) {
		//$url=urlencode($url);
		//debug($url);
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	
		$data = curl_exec($ch);
		curl_close($ch);
	
		return $data;
	}
	function html_no_comment($url) {
		// create HTML DOM
		$check_curl=Feed::_isCurl();
		if(!$html=file_get_html($url)){
			if(!$html=str_get_html(Feed::file_get_contents_curl($url)) or !$check_curl){
				return false;
			}
		}
		// remove all comment elements
		foreach($html->find('comment') as $e)
		
			$e->outertext = '';
	
		$ret = $html->save();
		
		// clean up memory
		$html->clear();
		unset($html);
		return $ret;
	}
	static function debug($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
		exit();
	}
}
?>