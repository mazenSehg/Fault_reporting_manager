$(document).ready(function() {
	
	var cnt = 10;
	
	TabbedNotification = function(options) {
		var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
		"</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

		if (!document.getElementById('custom_notifications')) {
			alert('doesnt exists');
		} else {
			$('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
			$('#custom_notifications #notif-group').append(message);
			cnt++;
			CustomTabs(options);
		}
	};

	CustomTabs = function(options) {
		$('.tabbed_notifications > div').hide();
		$('.tabbed_notifications > div:first-of-type').show();
		$('#custom_notifications').removeClass('dsp_none');
		$('.notifications a').click(function(e) {
			e.preventDefault();
			var $this = $(this),
			tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
			others = $this.closest('li').siblings().children('a'),
			target = $this.attr('href');
			others.removeClass('active');
			$this.addClass('active');
			$(tabbed_notifications).children('div').hide();
			$(target).show();
		});
	};

	CustomTabs();

	var tabid = idname = '';
	
	$(document).on('click', '.notification_close', function(e) {
		idname = $(this).parent().parent().attr("id");
		tabid = idname.substr(-2);
		$('#ntf' + tabid).remove();
		$('#ntlink' + tabid).parent().remove();
		$('.notifications a').first().addClass('active');
		$('#notif-group div').first().css('display', 'block');
	});

	$('[data-toggle="tooltip"]').tooltip(); 
	
	
		console.log($(".datatable-buttons").length);
	var handleDataTableButtons = function() {
		if ($(".datatable-buttons").length) {
			$(".datatable-buttons").DataTable({
				order: [[ 1, "desc" ]],
				dom: "Bfrtip",
				buttons: [
					{extend: "copy",className: "btn-sm"},
					{extend: "csv",className: "btn-sm"},
					{extend: "excel",className: "btn-sm"},
					{extend: "pdfHtml5",className: "btn-sm"},
					{extend: "print",className: "btn-sm"},
				],
				responsive: true,
			});
		}
	};
	
var ajaxhandleDataTableButtons = function() {
	
		if ($(".ajax-datatable-buttons").length) {
			$(".ajax-datatable-buttons").DataTable({
				
				order: [[ $(".ajax-datatable-buttons").data('order-column'), "desc" ]],
				dom: "Bflrtip",
				lengthMenu: [[10, 25, 50, 100,150,200,250,300,400,450,500], [10, 25, 50, 100,150,200,250,300,400,450,500]],
				buttons: [
					{extend: "copy",className: "btn-sm"},
					{extend: "csv",className: "btn-sm"},
					{extend: "excel",className: "btn-sm"},
					{extend: "pdfHtml5",className: "btn-sm"},
					{extend: "print",className: "btn-sm"},
				],
				responsive: true,
				processing: true,
				serverSide: true,
				ajax: {
					url: table_ajax_url,
					type: 'POST',
					data: function ( d ) {
						d.action = $('.ajax-datatable-buttons').data('table');
						d.centre = $('.custom-filters select[name="centre"]').val();
						d.equipment_type = $('.custom-filters select[name="equipment_type"]').val();
						d.equipment = $('.custom-filters select[name="equipment"]').val();
						d.fault_type = $('.custom-filters select[name="fault_type"]').val();
						d.manufacturer = $('.custom-filters select[name="manufacturer"]').val();
						d.model = $('.custom-filters select[name="model"]').val();
						d.approved = $('.custom-filters select[name="approved"]').val();
						d.date_of_fault = $('.custom-filters select[name="date_of_fault"]').val();
					},
					complete:function(r){
						if ($("table .js-switch")[0]) {
							var elems = Array.prototype.slice.call(document.querySelectorAll('table .js-switch'));
							elems.forEach(function (html) {
								var switchery = new Switchery(html, {
									color: '#26B99A'
								});
							});
						}
					}
				},
			});
		}
	};


	TableManageButtons = function() {
		"use 	strict";
		return {
			init: function() {
				handleDataTableButtons();
				ajaxhandleDataTableButtons();
			}
		};
	}();
			
	TableManageButtons.init();
	
	function initToolbarBootstrapBindings() {
		var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier','Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times','Times New Roman', 'Verdana'],
		fontTarget = $('[title=Font]').siblings('.dropdown-menu');
		$.each(fonts, function(idx, fontName) {
			fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
		});
		$('a[title]').tooltip({
			container: 'body'
		});
		$('.dropdown-menu input').click(function() {
			return false;
		})
		.change(function() {
			$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
		})
		.keydown('esc', function() {
			this.value = '';
			$(this).change();
		});

		$('[data-role=magic-overlay]').each(function() {
			var overlay = $(this),
			target = $(overlay.data('target'));
			overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
		});

		if ("onwebkitspeechchange" in document.createElement("input")) {
			var editorOffset = $('.editor-box').offset();

			$('.voiceBtn').css('position', 'absolute').offset({
				top: editorOffset.top,
				left: editorOffset.left + $('#editor').innerWidth() - 35
			});
		} else {
			$('.voiceBtn').hide();
		}
	}

	function showErrorAlert(reason, detail) {
		var msg = '';
		if (reason === 'unsupported-file-type') {
			msg = "Unsupported format " + detail;
		} else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+'<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
	}

	initToolbarBootstrapBindings();

	$('.editor-box').wysiwyg({
		fileUploadError: showErrorAlert
	});
	
	$('.editor-box').blur(function(){
		var data_id = $(this).data('id');
		var data_text = $(this).html();
		var parent_form = $(this).parents('form');
		parent_form.find('textarea#'+data_id).val(data_text);
	});

	window.prettyPrint;
	prettyPrint();
	
	$select_single = $('.select_single').select2({ allowClear: true });
	
	$select_multiple = $('.select_multiple').select2({ allowClear: true });
	
	$('.input-datepicker').daterangepicker({
		format: 'MMMM DD,YYYY',
		singleDatePicker: true,
		showDropdowns: true,
		calender_style: "picker_1"
	});
	
	
	var radiobox_names = ['fault_corrected_by_user' ,'to_fix_at_next_service_visit','engineer_called_out'];
	var radiobox_check = false;
	$.each( radiobox_names, function( key, value ) {
		var _value = $('input[name="'+value+'"]:checked').val();
		if(radiobox_check == false){
			$.each( radiobox_names, function( key1, value1 ) {
				if( value != value1){
					if(_value == '1'){
						$('input[name="'+value1+'"][value="2"]').iCheck('check');
						$('input[name="'+value1+'"]').iCheck('disable');
						radiobox_check = true;
					}else{
						$('input[name="'+value1+'"]').iCheck('enable');
					}
				}
			});
		}
	});
	
	$('.custom_radiobox').on('ifClicked',function(){
		var _this = $(this);
		var value = _this.attr('name');
		var radiobox_names = ['fault_corrected_by_user' ,'to_fix_at_next_service_visit','engineer_called_out'];
		var _value = _this.val();
		$.each( radiobox_names, function( key1, value1 ) {
			if( value != value1){
				if(_value == '1' ){
					$('input[name="'+value1+'"][value="2"]').iCheck('check');
					$('input[name="'+value1+'"]').iCheck('disable');
				}else{
					$('input[name="'+value1+'"]').iCheck('enable');
				}
			}
		});
	});

	
	
	var url_filter = /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
	var email_filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	var phone_filter = /^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/;
	var postcode_filter = /^[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}$/i;
	var spinner = '&nbsp;<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>';
	
	$('.page-scroll').bind('click', function(event) {
		var $anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top
		}, 1500, 'easeInOutExpo');
		event.preventDefault();
	});
	
	$('form .form-control').focus(function(){
		var box = $(this).parents('.form-group');
	 	box.removeClass('has-error');
	 	return false;
	});
	
	$('form.login-form').submit(function(e){
		e.preventDefault();
		
		var form = $(this);
		var formData = new FormData(this);
		$('.form-group').removeClass('has-error'); // remove class from form control which show error (red) color 
		form.find('div.alert').slideUp();
		
		var user_name = form.find('input[name="user_name"]');
		var user_pass = form.find('input[name="user_pass"]');
		
		//  USER NAME VALIDATION
		if(user_name.val() == ''){
			user_name.parents('.form-group').addClass('has-error');
			form.find('div.alert-danger').html('<i class="fa fa-times-circle"></i>  &nbsp;<span>Please enter user name or email address</span>');
			form.find('div.alert-danger').slideDown();
			return false;
		}
		
		// USER PASSWORD VALIDATION 
		if(user_pass.val() == ''){
			user_pass.parents('.form-group').addClass('has-error');
			form.find('div.alert-danger').html('<i class="fa fa-times-circle"></i>  &nbsp;<span>Please enter your password</span>');
			form.find('div.alert-danger').slideDown();
			return false;
		}
		
		var btn = $(this).find('button[type="submit"]');
		var btn_text = btn.html();
		btn.html(btn_text+spinner);
		btn.attr('disabled',true);
				
		// MAKE AJAX PROCESS 
		$.ajax({ 
			type : 'POST',
			data: formData,
			contentType: false,
			cache: false,
			processData:false,
			url  : ajax_url,
			success : function(res){
				console.log(res);
				btn.attr('disabled',false);
				btn.html(btn_text);
				if(res == 0 ){ // if failed then go inside 
					user_pass.parents('.form-group').addClass('has-error');
					form.find('div.alert-danger').html('<i class="fa fa-times-circle"></i>  &nbsp;<span>Invalid Username or Password</span>');
					form.find('div.alert-danger').slideDown();
					return false;
				}else if(res == 2 ){
					form.find('div.alert-danger').html('<i class="fa fa-times-circle"></i>  &nbsp;<span>Your account has been disabled , please contact your company to get it re-enabled.</span>');
					form.find('div.alert-danger').slideDown();
					return false;
				}else if (res == 1 ){ // if success then go inside
					form.trigger('reset');
					form.find('button[type="submit"]').hide();
					form.find('div.alert-success').slideDown();
					setTimeout(function(){ window.location.reload(); }, 500);
					return false;
				}else{
					form.find('div.alert-danger').html('<i class="fa fa-times-circle"></i>  &nbsp;<span>Could not login, please try again</span>');
					form.find('div.alert-danger').slideDown();
					return false;
				}
			}
		});
	});
	
	$('.link-logout').click(function(e){
	 	e.preventDefault();
	 	$.ajax({
	 		type : 'POST',
	 		url : ajax_url,
	 		data : { 'action' : 'logout_request' },
	 		success : function (res){
				window.location.reload();
			}
	 	});
	 });
	 
	$('form.change-password').submit(function(e){
		e.preventDefault();
		
		var form = $(this);
		$('.form-group').removeClass('has-error'); // remove class from form control which show error (red) color 		
		var current_pass = form.find('input[name="current_password"]');
		var new_pass = form.find('input[name="new_password"]');
		var repeat_pass = form.find('input[name="confirm_password"]');
		
		
		//  CURRENT PASSWORD VALIDATION
		if(current_pass.val() == ''){
			current_pass.parents('.form-group').addClass('has-error');
			alert_notification('Empty Password','Current password can\'t be empty, please enter current password !','error');
			return false;
		}
		
		//  REPEAT PASSWORD VALIDATION
		if(new_pass.val() == ''){
			new_pass.parents('.form-group').addClass('has-error');
			alert_notification('Empty Password','New password can\'t be empty, please enter new password !','error');
			return false;
		}
		
		
		//  REPEAT PASSWORD VALIDATION
		if(repeat_pass.val() == ''){
			repeat_pass.parents('.form-group').addClass('has-error');
			alert_notification('Empty Password','Repeat password can\'t be empty, please enter repeat password !','error');
			return false;
		}
		
		//  PASSWORD MATCH VALIDATION
		if(new_pass.val() != repeat_pass.val()){
			repeat_pass.parents('.form-group').addClass('has-error');
			alert_notification('Passwords don\'t match','Your password doesn\'t match with repeat password, please enter correct password !','error');
			return false;
		}
		
		var btn = form.find('button[type="submit"]');
		var btn_text = btn.html();
		btn.html(btn_text+spinner);
		btn.attr('disabled',true);
		
		// MAKE AJAX PROCESS 
		$.ajax({ 
			type : 'POST',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			url  : ajax_url,
			success : function(res){
				btn.attr('disabled',false);
				btn.html(btn_text);
				console.log(res);
				
				if(res == 0 ){ // if failed then go inside 
					current_pass.parents('.form-group').addClass('has-error');
					alert_notification('Invalid Password','Entered current password is invalid, please try again !','info');
				}else if (res == 1 ){ // if success then go inside
					form.trigger('reset');
					alert_notification('Success !','Your account password has been successfully updated.!','success');
					window.scrollTo(0,0);
					setTimeout(function(){window.location.reload();},1000);
				}else{
					alert_notification('Failed','Could not update password, Please try again !','info');
				}
				return false;
			}
		});
	});

	$('form.upload-profile-image input[type="file"]').change(function(){
	 	if($(this).val() != ''){
			var file = $(this).val();
			var exten = file.split('.').pop();
			var file_match = ["JPG","jpg","jpeg","JPEG","PNG","png"];
			var form = $(this).parents('form');
			if($.inArray(exten, file_match ) == -1){
				 form.trigger('reset');
				 alert_notification('Invalid Image Format','Selected image format is not valid, please check again !','error');
				return false;
			}else{
				var filesize =$(this)[0].files[0].size;
				if(filesize > 1045505){
					form.trigger('reset');
					alert_notification('File Size Is Big','You can only upload max 1 MB image file !','error');
					return false;
				}
			}
			form.trigger('submit');
			return false;
		}
	 });
	 
	$('form.upload-profile-image').submit(function(e){
		e.preventDefault();
		var form = $(this);
		form.find('div.alert').fadeIn();
		$.ajax({ 
			type : 'POST',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			url  : ajax_url,
			success : function(res){
				//window.location.reload();
				form.find('div.alert').fadeOut();
				if(res == 0){
					form.trigger('reset');
					alert_notification('Failed','There is some problem occured in uploading image, please try again !','error');
				}else{
					$('input[name="profile_img"]').val(res);
					$('div.profile-image-preview-box img').attr('src',site_url + res);
					form.find('button[type="button"]').trigger('click');
				}
				return false;
			}
		});
	});

	$('form.user-form').submit(function(e){
		e.preventDefault();
		
		var form = $(this);
		var validation_check = 0;
		$('.form-group').removeClass('has-error'); // remove class from form control which show error (red) color 		
		var user_email = form.find('input[name="user_email"]');
		
		form.find('.require').each(function(){
			if($(this).val() == '' || $(this).val() == null){
				$(this).parents('.form-group').addClass('has-error');
				validation_check = 1;
			}
		});
		
		if(validation_check == 0){
				
			// USER EMAIL PATTERN VALIDATION 
			if(!email_filter.test(user_email.val()) && user_email.val() != '') {
				user_email.parents('.form-group').addClass('has-error');
				alert_notification('Invalid Email','Entered email is not valid, Please enter a valid email address !','error');
				return false;
			}
		}
		
		if(validation_check == 1){
			alert_notification('Form Validation Errors','Highlighted fields are required or have some validation errors. Please check and try again !','error');
			window.scrollTo(0,0);
			return false;
		}
		
		var btn = form.find('button[type="submit"]');
		var btn_text = btn.html();
		btn.html(btn_text+spinner);
		btn.attr('disabled',true);
		
		// MAKE AJAX PROCESS 
		$.ajax({ 
			type : 'POST',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			url  : ajax_url,
			dataType: 'json',
			success : function(res){
				btn.attr('disabled',false);
				btn.html(btn_text);
				console.log(res);
				if(res['status'] == 0 ){ // if failed then go inside
					alert_notification(res['message_heading'],res['message'],'info');
				}else if(res['status'] == 2 ){ // if failed then go inside
					$.each(res['fields'], function( key, value ) {
						var class_name = form.find('input[name="'+value+'"]');
						class_name.parents('.form-group').addClass('has-error');
					});
					alert_notification(res['message_heading'],res['message'],'info');
				}else if(res['status'] == 1 ){ // if success then go inside
					if(res['reset_form'] == 1){
						form.trigger('reset');
					}
					alert_notification(res['message_heading'],res['message'],'success');
					window.scrollTo(0,0);
				}
				return false;
			}
		});
	});

	$('.generate-password').click(function(){
		var btn = $(this);
		var btn_text = btn.html();
		btn.html(btn_text+spinner);
		btn.attr('disabled',true);
		
		// MAKE AJAX PROCESS 
		$.ajax({ 
			type : 'POST',
			data: {
				'action' : 'generate_password',
			},
			url  : ajax_url,
			success : function(res){
				btn.attr('disabled',false);
				btn.html(btn_text);
				$('form.edit-user input[name="user_pass"]').val(res);
			}
		});
	});

	$('form.submit-form').submit(function(e){
		e.preventDefault();
		
		var form = $(this);
		var validation_check = 0;
		$('.form-group').removeClass('has-error'); // remove class from form control which show error (red) color 
		form.find('.require').each(function(){
			if($(this).val() == '' || $(this).val() == null){
				$(this).parents('.form-group').addClass('has-error');
				validation_check = 1;
			}
		});

		if(validation_check == 1){
			alert_notification('Form Validation Errors','Highlighted fields are required or have some validation errors. Please check and try again !','error');
			window.scrollTo(0,0);
			return false;
		}
		
		var btn = form.find('button[type="submit"]');
		var btn_text = btn.html();
		btn.html(btn_text+spinner);
		btn.attr('disabled',true);
		
		// MAKE AJAX PROCESS 
		$.ajax({ 
			type : 'POST',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			url: ajax_url,
			dataType: 'json',
			success : function(res){
				console.log(res);
				btn.attr('disabled',false);
				btn.html(btn_text);
				if(res['status'] == 0 ){ // if failed then go inside
					alert_notification(res['message_heading'],res['message'],'info');
				}else if(res['status'] == 2 ){ // if failed then go inside
					$.each(res['fields'], function( key, value ) {
						var class_name = form.find('input[name="'+value+'"]');
						class_name.parents('.form-group').addClass('has-error');
					});
					alert_notification(res['message_heading'],res['message'],'info');
				}else if(res['status'] == 1 ){ // if success then go inside
					if(res['reset_form'] == 1){
						form.trigger('reset');
					}
					alert_notification(res['message_heading'],res['message'],'success');
					window.scrollTo(0,0);
					if(res['reload'] == 1){
						window.location.reload();
					}
				}
				return false;
			}
		});
	});
	
	$('.read-notification').click(function(){
		var btn = $(this);
		var id = btn.data('id');
		var type = btn.data('type');
		var btn_text = btn.html();
		btn.html(btn_text+spinner);
		btn.attr('disabled',true);
		
		// MAKE AJAX PROCESS 
		$.ajax({ 
			type : 'POST',
			data: {
				'action' : 'read_notification',
				'id' : id,
				'type' : type
			},
			url  : ajax_url,
			success : function(res){
				btn.attr('disabled',false);
				btn.html(btn_text);
				console.log(res);
				if (res == 1 ){ // if success then go inside
					if(type == 'all'){
						setTimeout(function(){ window.location.reload();},1000);
						return false;
					}
					btn.parents('li').removeClass('unread');
				}
			}
		});
	});

	$('.hide-notification').click(function(e){
		e.preventDefault();
		var btn = $(this);
		var id = btn.data('id');
		var btn_text = btn.html();
		var hide_type = btn.data('type');
		btn.html(btn_text+spinner);
		btn.attr('disabled',true);
		
		// MAKE AJAX PROCESS 
		$.ajax({ 
			type: 'POST',
			data: {
				'action' : 'hide_notification',
				'id' : id,
				'type' : hide_type
			},
			url: ajax_url,
			success : function(res){
				console.log(res);
				btn.attr('disabled',false);
				btn.html(btn_text);
				if (res == 1 ){ // if success then go inside
					if(hide_type == 'all'){
						setTimeout(function(){ window.location.reload();},1000);
						return false;
					}
					btn.parents('li').remove();
				}
			}
		});
	});
	
	$('.fetch-equipment-type-data').change(function(e){
		var _this = $(this);
		$.ajax({ 
			type: 'POST',
			data: {
				action: 'fetch_equipment_type_data',
				id: _this.val()
			},
			url: ajax_url,
			dataType: 'json',
			success: function(res){
				console.log(res);
				$select_multiple.select2("destroy");
				$select_single.select2("destroy");
				$('.select-service-agent').html(res['service_agent_html']);
				$('.select_manufacturer').html(res['manufacturer_html']);
				$('.select_supplier').html(res['supplier_html']);
				$select_single.select2({ allowClear: true });
				$select_multiple.select2({ allowClear: true });
			}
		});
	});
	
	$('.fetch-manufacturer-data').change(function(e){
		var _this = $(this);
		$.ajax({ 
			type : 'POST',
			data: {
				action: 'fetch_manufacturer_data',
				id: _this.val()
			},
			url  : ajax_url,
			dataType: 'json',
			success: function(res){
				$select_multiple.select2("destroy");
				$select_single.select2("destroy");
				$('.select_model').html(res['model_html']);
				$select_single.select2({ allowClear: true });
				$select_multiple.select2({ allowClear: true });
			}
		});
	});
	
	$('.fetch-equipment-data').change(function(e){
		var _this = $(this);
		var value  = 0;
		if($('.show-decommed').is(':checked')){
			var value = 1;
		}
		$.ajax({ 
			type : 'POST',
			data: {
				action: 'fetch_equipment_data',
				id: _this.val(),
				decommed: value,
				centre: jQuery('.fetch-centre-equipment-data').val()	
			},
			url  : ajax_url,
			dataType: 'json',
			success: function(res){
				console.log(res);
				$select_multiple.select2("destroy");
				$select_single.select2("destroy");
				$('.select-fault-type').html(res['fault_type_html']);
				$('.select-equipment').html(res['equipment_html']);
				$select_single.select2({ allowClear: true });
				$select_multiple.select2({ allowClear: true });
			}
		});
	});

	$('.fetch-service-agent-data').change(function(e){
		var _this = $(this);
		$.ajax({ 
			type : 'POST',
			data: {
				action: 'fetch_service_agent_data',
				id: _this.val(),
			},
			url  : ajax_url,
			dataType: 'json',
			success: function(res){
				console.log(res);
				$select_multiple.select2("destroy");
				$select_single.select2("destroy");
				$('.select-servicing-agency').html(res['servicing_agency_html']);
				$select_single.select2({ allowClear: true });
				$select_multiple.select2({ allowClear: true });
			}
		});
	});
	
	
	
		$('.fetch-service-agent-data2').change(function(e){
		var _this = $(this);
		$.ajax({ 
			type : 'POST',
			data: {
				action: 'fetch_service_agent_data2',
				id: _this.val(),
			},
			url  : ajax_url,
			dataType: 'json',
			success: function(res){
				console.log(res);
				$select_multiple.select2("destroy");
				$select_single.select2("destroy");
				$('.select-servicing-agency2').html(res['servicing_agency_html2']);
				$select_single.select2({ allowClear: true });
				$select_multiple.select2({ allowClear: true });
			}
		});
	});
	
	$('.show-decommed').change(function(e){
		var value  = 0;
		var _this = $(this);
		if(_this.is(':checked')){
			var value = 1;
		}
		$.ajax({ 
			type : 'POST',
			data: {
				action: 'fetch_equipment_data',
				id: $('.select-equipment-type').val(),
				decommed: value,
				centre: $('.fetch-centre-equipment-data').val(),
			},
			url  : ajax_url,
			dataType: 'json',
			success: function(res){
				console.log(res);
				$select_multiple.select2("destroy");
				$select_single.select2("destroy");
				$('.select-equipment').html(res['equipment_html']);
				$select_single.select2({ allowClear: true });
				$select_multiple.select2({ allowClear: true });
			}
		});
	});
	
	$('.fetch-centre-equipment-data').change(function(e){
		var _this = $(this);
		var value  = 0;
		if($('.show-decommed').is(':checked')){
			var value = 1;
		}
		$.ajax({ 
			type : 'POST',
			data: {
				action: 'fetch_centre_equipment_data',
				id: _this.val(),
				decommed: value,
				equipment_type: $('.select-equipment-type').val()
			},
			url  : ajax_url,
			dataType: 'json',
			success: function(res){
				console.log(res);
				$select_multiple.select2("destroy");
				$select_single.select2("destroy");
				$('.select-equipment').html(res['equipment_html']);
				$select_single.select2({ allowClear: true });
				$select_multiple.select2({ allowClear: true });
			}
		});
	});
	
	$('.doh-action').on('click',function(e){
		var _this = $(this);
		if( _this.is(':checked')){
			$('.doh-action-group').slideDown();
		}else{
			$('.doh-action-group').slideUp();
		}
	});
	

	$('.custom-filters select').on('change',function(){
		var attr_name = $(this).attr('name');
		if(attr_name == 'centre' || attr_name == 'equipment_type'){
			$.ajax({ 
				type : 'POST',
				data: {
					action: 'fetch_equipment_data',
					id: $('select[name="equipment_type"]').val(),
					decommed: 0,
					equipment_type: $('select[name="centre"]').val(),
				},
				url  : ajax_url,
				dataType: 'json',
				success: function(res){
					console.log(res);
					$select_multiple.select2("destroy");
					$select_single.select2("destroy");
					$('select[name="equipment"]').html(res['equipment_html']);
					$('select[name="fault_type"]').html(res['fault_type_html']);
					$select_single.select2({ allowClear: true });
					$select_multiple.select2({ allowClear: true });
					$('.ajax-datatable-buttons > thead > tr th:nth-child(1)').trigger('click');
				}
			});
		}else{
			$('.ajax-datatable-buttons > thead > tr th:nth-child(1)').trigger('click');
		}
		
	});
});

function delete_function(btn){
	var isDelete = confirm('Are you sure want to delete this record?');
	if(isDelete == false){
		return false;
	}
	var spinner = '&nbsp;<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>';
	var btn = $(btn);
	var id = btn.data('id');
	var action = btn.data('action');
	var hide = btn.data('hide');
	var  process= btn.data('process');
	
	btn_text = btn.html();
	btn.html(btn_text+spinner);
	btn.attr('disabled',true);
	
	$.ajax({ 
		type : 'POST',
		data: {
			'action' : action,
			'id' : id
		},
		url  : ajax_url,
		success : function(res){
			console.log(res);
			if(res == 1){
				if(hide == '1'){
					if(process == 'booking'){
						alert_notification('Success !','Booking has been successfully cancelled !','success');
						setTimeout(function(){ window.location.reload();},1000);
					}
				}else{
					alert_notification('Success !','Record has been deleted successfully !','success');
					btn.parents('tr').remove();
				}
					
			}else{
				btn.attr('disabled',false);
				btn.html(btn_text);
			}
		}
	});
	
}

function filter_user_name(value){
	var check = 0;
	var username_filter = [","," ","/","@","#","$","%","^","&","*","(",")","+","=","\\","|","{","}","[","]",";",":"];
	for(var i = 0; i< username_filter.length; i++){
		if(value.indexOf(username_filter[i]) >= 0){
			check = 1;
		}
	}	
	return check;
}

function alert_notification(Title,Text, Type, Class){
	$('.ui-pnotify-closer').trigger('click');
	new PNotify({
		title: Title,
		text: Text,
		type: Type,
		styling: 'bootstrap3',
		addclass : Class
	});
}

function approve_switch(btn){
	var e = window.event;
	
	var status = 0;
	var id = $(btn).data('id');
	var action = $(btn).data('action');
	
	if($(btn).is(':checked')){
		var status = 1;
	}
	if( action.trim() == 'fault_approve_change' && status == 1 ){
		if(e) {
			e.preventDefault();
		}
		var form = $('.fault-modal-form');
		form.find('input[name="id"]').val(id);
		form.find('input[name="status"]').val(status);
		$.ajax({ 
			type: 'POST',
			data: {
				'action' : 'fetch_fault_data_for_modal',
				'id' : id,
			},
			url: ajax_url,
			dataType: 'json',
			success: function(res){
				console.log(res);
				if(res['doh'] != ''){
					if(res['doh'].trim() == '1' && !form.find('.doh-action').is(':checked')){
						form.find('.doh-action').trigger('click');
					}
					form.find('input[name="supplier_enquiry"]').val(res['supplier_enquiry'].trim());
					form.find('input[name="supplier_action"]').val(res['supplier_action'].trim());
					form.find('textarea[name="supplier_comments"]').val(res['supplier_comments'].trim());
					$('.launch-fault-modal').trigger('click');
					return false;
				}
			}
		});
		return false;
	}
	$.ajax({ 
		type: 'POST',
		data: {
			'action' : action,
			'id' : id,
			'status' : status,
		},
		url: ajax_url,
		dataType: 'json',
		success: function(res){
			console.log(res);
			if(res['status'] == 0 ){ // if failed then go inside
				alert_notification(res['message_heading'],res['message'],'info');
				//setTimeout(function(){ window.location.reload();},1000);
			}else if(res['status'] == 1 ){ // if success then go inside
				alert_notification(res['message_heading'],res['message'],'success');
			}
			return false;
		}
	});
}
