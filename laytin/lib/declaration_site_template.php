<?php
$id=(isset($_REQUEST['id']) and $_REQUEST['id'])?$_REQUEST['id']:0;
$site=DB::fetch('select * from site where id='.$id);
$site_structure=DB::fetch_all('select *,field_name as id from site_structure where site_id='.$id);
if(isset($_REQUEST['action']) and $_REQUEST['action']=='save_structure')
Feed::save_site_structure($cmd,$id,$site);
?>
<div class="content-header clrfix">
    <h1 class="fl title">Chi tiết các trường thông tin của mẫu:<br><span class="require"><?php echo $site['name'];?></span></h1>
    <div class="fr">
    <button onClick="save_site_structure();">Ghi lại</button>
    <button onclick="window.location='declaration_site.php?cmd=edit&id=<?php echo $id;?>'">Sửa site</button>
    <button onclick="window.location='declaration_site.php'">Danh sách</button>
    </div>
</div>
<div class="form-content">
    <form name="EditDeclarationSite" id="EditDeclarationSite" method="post">
    	<div style="margin-bottom:10px;">
    	<label>Thay thế đường dẫn ảnh trong nội dung:</label>
        <input name="image_content_left" type="text" id="image_content_left" style="width:35%;" value='<?php echo isset($site['image_content_left'])?$site['image_content_left']:'';?>'  /> ==> 
        <input name="image_content_right" type="text" id="image_content_right" style="width:35%;" value='<?php echo isset($site['image_content_right'])?$site['image_content_right']:'';?>'  />
        </div>
    	<table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse:collapse" bordercolor="#cccccc">
            <tr bgcolor="#efefef">
                <th>Trường dữ liệu</th>
                <th>Mẫu cần lấy</th>
                <th>Mẫu đối tượng cần xóa</th>
            </tr>
            <tr>
                <td>name</td>
                <td><input name="field[name][extra]" type="text" id="name_extra" style="width:90%;" value="<?php echo isset($site_structure['name']['extra'])?$site_structure['name']['extra']:'';?>" /></td>
                <td><input name="field[name][element_delete]" type="text" id="name_element_delete" style="width:90%;" value="<?php echo isset($site_structure['name']['element_delete'])?$site_structure['name']['element_delete']:'';?>" /></td>
            </tr>
            <tr>
                <td>brief</td>
                <td><input name="field[brief][extra]" type="text" id="brief_extra" style="width:90%;" value="<?php echo isset($site_structure['brief']['extra'])?$site_structure['brief']['extra']:'';?>" /></td>
                <td><input name="field[brief][element_delete]" type="text" id="brief_element_delete" style="width:90%;" value="<?php echo isset($site_structure['brief']['element_delete'])?$site_structure['brief']['element_delete']:'';?>" /></td>
            </tr>
            <tr>
                <td>description</td>
                <td><input name="field[description][extra]" type="text" id="description_extra" style="width:90%;" value="<?php echo isset($site_structure['description']['extra'])?$site_structure['description']['extra']:'';?>" /></td>
                <td><input name="field[description][element_delete]" type="text" id="description_element_delete" style="width:90%;" value="<?php echo isset($site_structure['description']['element_delete'])?$site_structure['description']['element_delete']:'';?>" /></td>
            </tr>
        </table>
        <input type="hidden" name="action" id="action" value="" />
    </form>
</div>
<div class="get-page-content">
    <div id="page_detail_content"></div>
    <div id="page_detail_delete"></div>
    <div id="page_img_detail"></div>
    <span id="close_content" onclick="hide_content();">Close</span>
</div>