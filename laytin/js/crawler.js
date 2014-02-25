function strpos (haystack, needle, offset) {
  var i = (haystack+'').indexOf(needle, (offset || 0));
  return i === -1 ? false : i;
}
function select_all_checkbox(checked)
{
	if(checked==true){
		jQuery('input[type=checkbox]').attr('checked',true);
	}else{
		jQuery('input[type=checkbox]').attr('checked',false);
	}
}
function check_selected()
{	
	var status = false;
	var __class_checkbox = '';
	if(jQuery('.selected_ids').length > 0) __class_checkbox='.selected_ids';
	jQuery('form '+__class_checkbox+':checkbox').each(function(e){
		if(this.disabled == false && this.checked)
		{
			status = true;
		}
	});
	return status;
}
function get_form()
{
	if(document.forms.length>=1)
	{
		return document.forms[0];
	}
	return false;
}
function feed_data(){
	if(check_selected()){
		var form = get_form();
		jQuery('.template-data').hide();
		jQuery('.loading').show();
		jQuery('#cmd').val('feed');
		form.submit();
	}else{
		jQuery('.loading').hide();
		alert('Hãy chọn ít nhất một bản ghi');
		return false;
	}
}
function insert_data(){
	var form = get_form();
	jQuery('.template-data').hide();
	jQuery('.loading').show();
	jQuery('#cmd').val('insert_database');
	form.submit();
    console.log(form);
}
function delete_declaration_site(){
	if(check_selected()){
		if(confirm('Bạn muốn xóa không?')){
			var form = get_form();
			jQuery('#action').val('delete');
			form.submit();
		}
	}else{
		alert('Hãy chọn ít nhất một bản ghi');
		return false;
	}
}
function save_declaration_site(){
	var name=jQuery('#name').val();
	var host=jQuery('#host').val();
	var url=jQuery('#url').val();
	var table_name=jQuery('#table_name').val();
	var pattern_bound=jQuery('#pattern_bound').val();
	var extra=jQuery('#extra').val();
	if(name!="" && host!="" && url!="" && table_name!="" && pattern_bound!="" && extra!=""){
		var form = get_form();
		jQuery('#action').val('save');
		form.submit();
	}else{
		alert('Hãy điền đầy đủ các ô có dấu sao mầu đỏ');
		return false;
	}
}
function save_site_structure(){
	var form = get_form();
	jQuery('#action').val('save_structure');
	form.submit();
}
function hide_content(){
	jQuery('.get-page-content').hide();
}
function get_data_list(url,field){
	if(url==''){ alert('Hãy nhập Url'); jQuery('#url').focus();
	}else{
		if(field!='pattern_bound' && jQuery('#pattern_bound').val()==''){
			alert('Hãy nhập mẫu bao ngoài một tin!'); jQuery('#pattern_bound').focus();
		}else{
			jQuery.ajax({
				method: "POST",url: 'form.php?ajax=1',
				data : {
					'url':url
				},
				beforeSend: function(){
					jQuery('.loading-'+field).show();
				},
				success: function(content){
					if(content){
						jQuery('.loading-'+field).hide();
						jQuery('.get-page-content').show();
						jQuery('#page_content').attr('data',field).html(content);
						jQuery('#page_content a').attr('onclick','return false');
					}
				}
			});
		}
	}
}
function get_data_detail(url,field){
	if(url==''){ alert('Hãy nhập đường dẫn một trang chi tiết!'); jQuery('#url').focus();
	}else{
		jQuery.ajax({
			method: "POST",url: 'form.php?ajax=1',
			data : {
				'url':url
			},
			beforeSend: function(){
				jQuery('.loading-'+field).show();
			},
			success: function(content){
				if(content){
					jQuery('.loading-'+field).hide();
					jQuery('.get-page-content').show();
					jQuery('#page_detail_content').attr('data',field).html(content);
					jQuery('#page_detail_content a').attr('onclick','return false');
				}
			}
		});
	}
}
function get_data_detail_delete(url,field){
	if(url==''){ alert('Hãy nhập đường dẫn một trang chi tiết!'); jQuery('#url').focus();
	}else{
		jQuery.ajax({
			method: "POST",url: 'form.php?ajax=1',
			data : {
				'url':url
			},
			beforeSend: function(){
				jQuery('.loading-'+field).show();
			},
			success: function(content){
				if(content){
					jQuery('.loading-'+field).hide();
					jQuery('.get-page-content').show();
					jQuery('#page_detail_delete').attr('data',field).html(content);
					jQuery('#page_detail_delete a').attr('onclick','return false');
				}
			}
		});
	}
}
function get_img_detail(url,host){
	if(url==''){ alert('Hãy nhập đường dẫn một trang chi tiết!'); jQuery('#url').focus();
	}else{
		jQuery.ajax({
			method: "POST",url: 'form.php?ajax=1',
			data : {
				'url':url
			},
			beforeSend: function(){
				jQuery('.loading-img-detail').show();
			},
			success: function(content){
				if(content){
					jQuery('.loading-img-detail').hide();
					jQuery('.get-page-content').show();
					jQuery('#page_img_detail').attr('data',host).html(content);
					jQuery('#page_img_detail a').attr('onclick','return false');
				}
			}
		});
	}
}

jQuery(function(){
	// Danh sách
	jQuery("#page_content").bind('mouseout mouseover',function(event){
		var $tgt = $(event.target);
		var $z=event.target.nodeName;
		if ($tgt.closest('div').length) {
		  $tgt.toggleClass('outline-element');
		}
    }).click(function(event){
		jQuery(event.target).removeClass('outline-element');
		// Mẫu bao ngoài một đối tượng
		var pattern_bound=jQuery('#pattern_bound').val();
		// Mẫu đang lấy
		var data=jQuery('#page_content').attr('data');
		// Đối tượng cha ban đầu
		var parent=jQuery(event.target);
		// Tên thẻ của đối tượng cha ban đầu
		var mau=parent.prop('tagName').toLowerCase();
		// Class của đối tượng cha ban đầu
		var obj_class=parent.attr('class');
		// Nếu đối tượng cha ban đầu có class
		if(typeof(obj_class) != 'undefined' && obj_class != null && obj_class!=''){
			if(strpos(obj_class,' ',0)){
				obj_class='"'+obj_class+'"';
			}
			mau=parent.prop('tagName').toLowerCase()+'[class='+obj_class+']';
		}else{
			var check=1;
			while (check>0){
				parent=parent.parent();
				obj_class=parent.attr('class');
				if(typeof(obj_class) != 'undefined' && obj_class != null && obj_class != ''){
					if(strpos(obj_class,' ',0)){
						obj_class='"'+obj_class+'"';
					}
					mau=parent.prop('tagName').toLowerCase()+'[class='+obj_class+'] '+mau;
					if(strpos(mau,pattern_bound,0)!='false'){
						if(data!='pattern_bound'){
							mau=jQuery.trim(mau.replace(pattern_bound,''));
						}
						check=0;
					}
				}else{
					mau=parent.prop('tagName').toLowerCase()+' '+mau;
				}
			}
		}
		jQuery('#'+data).val(mau);
		jQuery(".get-page-content").hide();
	});
	// Chi tiết
	jQuery("#page_detail_content").bind('mouseout mouseover',function(event){
		var $tgt = $(event.target);
		var $z=event.target.nodeName;
		if ($tgt.closest('div').length) {
		  $tgt.toggleClass('outline-element');
		}
    }).click(function(event){
		jQuery(event.target).removeClass('outline-element');
		// Mẫu đang lấy
		var data=jQuery('#page_detail_content').attr('data');
		// Số lượng cha muốn lấy
		var parent_number=3;
		// Đối tượng cha ban đầu
		var parent=jQuery(event.target);
		// Class của đối tượng cha ban đầu
		var obj_class=parent.attr('class');
		// Mẫu đầu tiên
		if(typeof(obj_class) != 'undefined' && obj_class != null && obj_class != ''){
			if(strpos(obj_class,' ',0)){
				obj_class='"'+obj_class+'"';
			}
			var mau=parent.prop('tagName').toLowerCase()+'[class='+obj_class+']';
		}else{
			var mau=parent.prop('tagName').toLowerCase();
		}
		for(i=1;i<parent_number;i++){
			parent=parent.parent();
			obj_class=parent.attr('class');
			if(typeof(obj_class) != 'undefined' && obj_class != null && obj_class != ''){
				if(strpos(obj_class,' ',0)){
					obj_class='"'+obj_class+'"';
				}
				mau=parent.prop('tagName').toLowerCase()+'[class='+obj_class+'] '+mau;
			}else{
				mau=parent.prop('tagName').toLowerCase()+' '+mau;
			}
		}
		jQuery('#'+data).val(mau);
		jQuery('#page_detail_delete').html('');
		jQuery('#page_detail_content').html('');
		jQuery('#page_img_detail').html('');
		jQuery(".get-page-content").hide();
	});
	// Xóa đối tượng
	jQuery("#page_detail_delete").bind('mouseout mouseover',function(event){
		var $tgt = $(event.target);
		var $z=event.target.nodeName;
		if ($tgt.closest('div').length) {
		  $tgt.toggleClass('outline-element');
		}
    }).click(function(event){
		jQuery(event.target).removeClass('outline-element');
		// Mẫu đang lấy
		var data=jQuery('#page_detail_delete').attr('data');
		// Số lượng cha muốn lấy
		var parent_number=1;
		// Đối tượng cha ban đầu
		var parent=jQuery(event.target);
		// Class của đối tượng cha ban đầu
		var obj_class=parent.attr('class');
		// Mẫu đầu tiên
		if(typeof(obj_class) != 'undefined' && obj_class != null && obj_class != ''){
			if(strpos(obj_class,' ',0)){
				obj_class='"'+obj_class+'"';
			}
			var mau=parent.prop('tagName').toLowerCase()+'[class='+obj_class+']';
		}else{
			var mau=parent.prop('tagName').toLowerCase();
		}
		for(i=1;i<parent_number;i++){
			parent=parent.parent();
			obj_class=parent.attr('class');
			if(typeof(obj_class) != 'undefined' && obj_class != null && obj_class != ''){
				if(strpos(obj_class,' ',0)){
					obj_class='"'+obj_class+'"';
				}
				mau=parent.prop('tagName').toLowerCase()+'[class='+obj_class+'] '+mau;
			}else{
				mau=parent.prop('tagName').toLowerCase()+' '+mau;
			}
		}
		if(jQuery('#'+data).val()==''){
			jQuery('#'+data).val(mau);
		}else{
			jQuery('#'+data).val(jQuery('#'+data).val()+','+mau);
		}
	});
	// Đường dẫn ảnh trong nội dung
	jQuery("#page_img_detail").bind('mouseout mouseover',function(event){
		var $tgt = $(event.target);
		var $z=event.target.nodeName;
		if ($tgt.closest('div').length) {
		  $tgt.toggleClass('outline-element');
		}
    }).click(function(event){
		jQuery(event.target).removeClass('outline-element');
		var host=jQuery('#page_img_detail').attr('data');
		var src_old=jQuery(event.target).attr('src');
		var src_new=src_old;
		if(strpos(src_old,'http://')===false){
			src_old=src_old.replace(/\.\.\//g,'');
			if(strpos(src_old,'/',0)==0){
				src_old.substring(1);
			}
			var pos=strpos(src_old,'/',0);
			var str1=src_old.substring(0,pos+1);
			var str2=host+''+str1;
			jQuery('#image_content_left').val(str1);
			jQuery('#image_content_right').val(str2);
		}else{
			jQuery('#image_content_left').val('');
			jQuery('#image_content_right').val('');
			alert('Đường dẫn ảnh ở dạng tuyệt đối, không cần xử lý!');
		}
		jQuery('#page_detail_delete').html('');
		jQuery('#page_detail_content').html('');
		jQuery('#page_img_detail').html('');
		jQuery(".get-page-content").hide();
	});
});