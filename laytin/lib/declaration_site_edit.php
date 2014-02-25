<?php
$category=DB::fetch_all('select * from category');
$id=(isset($_REQUEST['id']) and $_REQUEST['id'])?$_REQUEST['id']:0;
if($cmd=='edit'){
	$site=DB::fetch('select * from site where id='.$id);
}
if(isset($_REQUEST['action']) and $_REQUEST['action']=='save')
Feed::save_site($cmd,$id);
?>
<!-- thêm hoặc sửa mẫu lấy tin -->
<div class="clrfix">
    <h1 class="fl">Quản lý mẫu lấy tin tự động</h1>
    <div class="fr">
        <button onClick="save_declaration_site();">Ghi lại</button>
        <button onclick="window.location='declaration_site.php?cmd=template&id=<?php echo $id;?>'">Chi tiết</button>
        <button onclick="window.location='declaration_site.php'">Danh sách</button>
    </div>
</div>
<div class="form-content">
	<form name="EditDeclarationSite" id="EditDeclarationSite" method="post">
        <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse:collapse" bordercolor="#cccccc">
            <tr>
                <td><label>Tên mẫu (<span class="require">*</span>)</label></td>
                <td><input name="name" type="text" id="name" class="search-field" value="<?php echo isset($site['name'])?$site['name']:'';?>" /></td>
            </tr>
            <tr>
                <td><label>Host (<span class="require">*</span>)</label></td>
                <td><input name="host" type="text" id="host" class="search-field" value="<?php echo isset($site['host'])?$site['host']:'';?>" /></td>
            </tr>
            <tr>
                <td><label>Url (<span class="require">*</span>)</label></td>
                <td><input name="url" type="text" id="url" class="search-field" value="<?php echo isset($site['url'])?$site['url']:'';?>" /></td>
            </tr>
            <tr>
                <td><label>Chèn vào bảng (<span class="require">*</span>)</label></td>
                <td><input name="table_name" type="text" id="table_name" class="search-field" value="<?php echo isset($site['table_name'])?$site['table_name']:'';?>" /></td>
            </tr>
            <tr>
                <td><label>Mẫu bao ngoài một đối tượng (<span class="require">*</span>)</label></td>
                <td><input name="pattern_bound" type="text" id="pattern_bound" class="search-field" value='<?php echo isset($site['pattern_bound'])?$site['pattern_bound']:'';?>' /></td>
            </tr>
            <tr>
                <td><label>Mẫu liên kết một tin (<span class="require">*</span>)</label></td>
                <td><input name="extra" type="text" id="extra" class="search-field" value='<?php echo isset($site['extra'])?$site['extra']:'';?>'  /></td>
            </tr>
            <tr>
                <td><label>Chèn vào danh mục</label></td>
                <td><select name="category_id" id="category_id" style="width:20%;">
				<?php
				if($category)
				foreach($category as $key=>$value){
					echo '<option value="'.$key.'"'.((isset($site['category_id']) and $site['category_id']==$key)?' selected':'').'>'.$value['name'].'</option>';
				}
				?>
                </select></td>
            </tr>
            <tr>
                <td><label>Số trang cần lấy</label></td>
                <td><input name="page_num" type="text" id="page_num" style="width:20%;" value="<?php echo isset($site['page_num'])?$site['page_num']:'';?>"  /> (Ví dụ điền "1-9" sẽ thay ký tự "*" trên url lần lượt thành các trang từ 1 tới 9)</td>
            </tr>
            <tr>
                <td><label>Mẫu ảnh đại diện</label></td>
                <td><input name="image_pattern" type="text" id="image_pattern" style="width:60%;" value='<?php echo isset($site['image_pattern'])?$site['image_pattern']:'';?>'  /></td>
            </tr>
            <tr>
                <td><label>Thư mục chứa ảnh đại diện</label></td>
                <td><input name="image_dir" type="text" id="image_dir" style="width:60%;" value="<?php echo isset($site['image_dir'])?$site['image_dir']:'';?>"  /></td>
            </tr>
           <tr>
                <td><label>Bắt đầu và kết thúc vùng cần lấy</label></td>
                <td><input name="begin" type="text" id="begin" style="width:35%;" value='<?php echo isset($site['begin'])?str_replace('"','&quot;',$site['begin']):'';?>'  /> ==> 
                     <input name="end" type="text" id="end" style="width:35%;" value='<?php echo isset($site['end'])?str_replace('"','&quot;',$site['end']):'';?>'  />
                 </td>
           </tr>
        </table>
        <input type="hidden" name="action" value="" id="action" />
	</form>
</div>
<div class="get-page-content">
    <div id="page_content"></div>
    <span id="close_content" onclick="hide_content();">Close</span>
</div>