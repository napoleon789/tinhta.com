<?php
if(isset($_REQUEST['action']) and $_REQUEST['action']=='delete'){
	$ids=(isset($_REQUEST['selected_ids']) and $_REQUEST['selected_ids'])?$_REQUEST['selected_ids']:0;
	if($ids){
		foreach($ids as $id){
			Feed::delete_site($id);
		}
	}
}
?>
<!-- bắt đầu danh sách -->
<div class="clrfix">
    <h1 class="fl">Quản lý mẫu lấy tin tự động</h1>
    <div class="fr">
        <button onclick="window.location='declaration_site.php?cmd=add'">Thêm mới</button>
        <button onclick="delete_declaration_site();">Xóa</button>
    </div>
</div>
<div class="form-content">
<form name="DeclarationSite" method="post">
    <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse:collapse" bordercolor="#cccccc">
        <thead>
        <tr class="ht">
            <td width="1%" align="center"><input id="DeclarationSite_all_checkbox" onclick="select_all_checkbox(this.checked);" title="Tất cả" type="checkbox" value="1" /></th>
            <th align="left" nowrap>Tên mẫu</th>
            <th width="27%" align="left" nowrap>Đường dẫn</th>                    
            <th width="1%" align="left" nowrap>Bảng dữ liệu</th>                    
            <th width="1%" align="left" nowrap>Danh mục</th>                    
            <th width="10%" align="left">Mẫu ảnh đại diện</th>
            <th nowrap width="1%" align="center">Hành động</th>
        </tr>
        </thead>
            <tbody>
            <?php foreach($items as $key=>$value){ ?>
            <tr valign="middle">
                <td width="1%" align="center">
                    <input name="selected_ids[]" type="checkbox" value="<?php echo $key;?>" />
                </td>
                <td align="left" nowrap><?php echo $value['name'];?></td>
                <td align="left" nowrap style="width:250px;"><div style="word-wrap:break-word;"><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['url'];?></a></div></td>
                <td align="left" nowrap><?php echo $value['table_name'];?></td>
                <td align="left" nowrap><?php echo $value['category_title'];?></td>
                <td align="left" nowrap><?php echo $value['image_pattern'];?></td>
                <td align="center" nowrap width="1%">
                    <a href="declaration_site.php?cmd=edit&id=<?php echo $key;?>"><img src="images/edit.jpg" title="Sửa" /></a>
                    <a href="declaration_site.php?cmd=template&id=<?php echo $key;?>"><img src="images/txt.png" title="Cấu trúc" /></a>
                </td>
            </tr>
            <?php }?>
            </tbody>
    </table><br />
    <input type="hidden" name="action" value="" id="action" />
</form>
<!-- kết thúc danh sách -->
