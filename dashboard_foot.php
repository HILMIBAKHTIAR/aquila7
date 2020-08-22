<?php /*START created_by:glennferio@inspiraworld.com;release_date:2020-05-20;*/ ?>
<script type="text/javascript">
	//==============================================NOTIFICATION==================================================//
	var intervalNotif = null;
	loadNotifications();
	intervalNotifications(true);

	$(".open_notif").click(function(){
		if(!$(".open_notif").hasClass("open")){
			loadNotifications();
		}
	});
	$(document).on('click','.notifications > .click_notifications',function(event){
		if(!$(event.target).is('.delete')){
	     updateClickNotifications($(this).attr('nomor'));
	     window.location.href = $(this).attr('link');
	   }
	});
	$(document).on('click','.notifications > li > a > strong > .delete',function(e){
		intervalNotifications(false);
		setTimeout(function() {
		    $(".open_notif").addClass("open");
		}, 100);
		$(this).parents(".read_notif").remove();
		if(!$(".notifications").children("li").hasClass("read_notif")){
			$(".notifications").css('overflow', 'hidden');
			$(".notifications").html("<li><a href='#'><span>No Message</span></a></li>");
		}
	    deleteNotifications($(this).attr('nomor'));
	});
	$('body').on('click',function(){
	   if($(".open_notif").hasClass("open")){
	   		updateNotifications();
	   		loadNotifications();
	   }
	});
	
	function intervalNotifications(flag){
		clearInterval(intervalNotif);
		if(flag == true){
			intervalNotif = setInterval(function() {
			    loadNotifications();
			}, 60000);
		}	
	}
	function loadNotifications(){
		$.ajax({
			async: true, 
			type: "POST",
			url: "pages/notifications.php",
			data: {id : 'get_notif'},
			success: function (data) {
				var result = JSON.parse(data);
				var datas = "";
				console.log("Load Notification Success!!");
				console.log(result);
				$.each(result.child, function(i, item) {
					var read = "";
					var new_label = "";
					if(result.child[i].read_status == 1) {
						read = "read_notif";
					}
					if(result.child[i].new_status == 0) {
						new_label = "<span class='label label-info new'>NEW</span>";
					}

				    datas = datas.concat("<li class='"+read+" click_notifications' nomor='"+result.child[i].nomor+"' link='"+result.child[i].link+"'><a><strong style='display:block;'><span><i class='notif-icon fa fa-bell'></i>"+result.child[i].users+"<span class='notification_time'>"+result.child[i].date_time+"</span></span><i class='delete fa fa-trash' nomor='"+result.child[i].nomor+"'></i>"+new_label+"</strong>"+result.child[i].message+"</a></li>");
				 
				});
				
				if(datas==''){
					$(".notifications").css('overflow', 'hidden');
					$(".notifications").html("<li><a href='#'><span>No Message</span></a></li>");
				}
				else{
					$(".notifications").removeAttr("style");
					$(".notifications").css('overflow', 'auto');
					$("ul.notifications").html(datas);
				}
				$(".count-notif").html(result.parent.count);
				if(result.parent.count < 1) {
					$(".count-notif").hide();
				}else {
					$(".count-notif").show();
				}
		    },
		    error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
		    }
		});
	}
	function updateNotifications(){
		$.ajax({
			async: true, 
			type: "POST",
			url: "pages/notifications.php",
			data: {id : 'update_notif'},
			success: function (data) {
			},
		    error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
		    }
		});
	}
	function updateClickNotifications(nomor){
		$.ajax({
			async: true, 
			type: "POST",
			url: "pages/notifications.php",
			data: {id : 'update_click_notif', nomor:nomor},
			success: function (data) {
			},
		    error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
		    }
		});
	}
	function deleteNotifications(nomor){
		$.ajax({
			async: true, 
			type: "POST",
			url: "pages/notifications.php",
			data: {id : 'update_click_notif', nomor:nomor},
			success: function (data) {
				// loadNotifications()
				intervalNotifications(true);
			},
		    error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
		    }
		});
	}
	//==============================================NOTIFICATION==================================================//

	//===========================================LOADER & DATATABLE===============================================//
	function showLoader(){
		$( ".lds-ellipsis" ).removeClass( 'hide' );
	}
	function hideLoader(){
		$( ".lds-ellipsis" ).addClass( 'hide' );
		if(!$( '.dataTables_wrapper' ).hasClass('animated fadeInDown')){
			$( '.dataTables_wrapper' ).addClass( 'animated fadeInDown' );
		}
	}
	function loadDataTable(){
 		showLoader();
		$( '.dataTables_wrapper' ).addClass( 'hide' );
		// RESIZE AFTER COLLAPSE SIDE BAR
		setTimeout(function(){
			hideLoader();
			$( '.dataTables_wrapper' ).removeClass( 'hide' );
			reDrawDataTable();
			$(".dataTables_filter").append("<span class='bt-search'><i class='fa fa-search' aria-hidden='true'></i></span>");
		},300);
 	}
 	//===========================================LOADER & DATATABLE===============================================//

 	//==============================================PRINT REPORT==================================================//
 	function price_to_number(v){
	    if(!v){return 0;}
	    v=v.split('.').join('');
	    v=v.split(',').join('.');
	    v=v.replace('(','-');
	    return Number(v.replace(/[^0-9.|-]/g, ""));
	}
	function number_to_price(v){
	    if(v==0){return '0,00';}
	    v=parseFloat(v);
	    v=v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	    if(v.indexOf('-') > -1){v=v.replace('-','(') + ')';}
	    v=v.split('.').join('*').split(',').join('.').split('*').join(',');
	    return v;
	}
	function defaultPrint(){
		Print();
		/* DOCUMENTATION PARAM 
		1: title -> Custom Title
		2: header / HTML Yang Akan Ditampilkan Pada Bagian Caption/ Header dari Print
		3: periode -> Custom Periode
		4: company_mode -> 1 Utk Tampil Data Company, 0 Utk Tidak Tampil
		4: company_logo
		5: company_name
		6: company_address
		7: company_contact
		*/
	}
 	function Print(title='',  header='', periode='', company_mode='', company_logo='', company_name='', company_address='', company_contact=''){
 		var company_mode = company_mode;
 		var company_logo = company_logo;
 		var company_name = company_name;
	    var company_address = company_address;
	    var company_contact = company_contact;
	    var title = title;
	    var periode = periode;
	    var header= header;
	    var table_header = "", table_body = "", table_footer ="";
	    if($('.dataTables_scrollHead .table-datatable').children("thead").length > 0){
	    	table_header = $('.dataTables_scrollHead .table-datatable').children("thead").html().toString();
	    }
	    if($('.dataTables_scrollBody .table-datatable').children("tbody").length > 0){
	    	table_body = $('.dataTables_scrollBody .table-datatable').children("tbody").html().toString();
	    }
	    if($(' .dataTables_scrollFoot .table-datatable').children("tfoot").length > 0){
	    	table_footer = $('.dataTables_scrollFoot .table-datatable').children("tfoot").html().toString();
	    }
	    var total_column = 99;
	    var link = '<?php echo $_SESSION["g.menu"]?>';

	    if(periode == ''){
	    	var start_date_id ="#" + '<?php echo $_SESSION["setting"]["filter_start_date"] ?>';
	    	var end_date_id = "#" + '<?php echo $_SESSION["setting"]["filter_end_date"] ?>';
	    	if (typeof $(start_date_id).val() !== 'undefined') {
	    		periode += $(start_date_id).val();
	    	}
	    	if (typeof $(end_date_id).val() !== 'undefined') {
	    		periode += " <b>s/d</b> " + $(end_date_id).val();
	    	}
	    }
	    var obj=$.alert({
	      icon: 'fa fa-spinner fa-spin',
	      title: 'Please Wait..',
	      animation: 'scale',
	      content: '<font style="font-size:14px">Loading Print Preview..</font>',
	      buttons: {
	        ok: {
	            isHidden: true,
	          }
	      }
	    });

	    var framework = '<?php echo $config["webspira"]?>';
	    $.ajax({
	      async: true, 
	      type: "POST",
	      url:  framework + "codes/print.php",
	      data: { 
	      	  company_mode:company_mode,
	      	  company_logo:company_logo,
	          company_name:company_name,
	          company_address:company_address,
	          company_contact:company_contact,
	          title:title,
	          periode:periode,
	          header:header,
	          table_header:table_header, 
	          table_body:table_body,
	          table_footer:table_footer,
	          total_column:total_column,
	      },
	      success: function (data) {
	          obj.close();
	          window.open('pages/export_print.php?m=' + link + '&f=report&&sm=edit&a=view&no=','_newtab');  
	      },
	      error: function(jqXHR, textStatus, errorThrown) {
	      	  obj.close();
	          $.alert({
			    title: 'NOTIFICATION',
			    content: errorThrown,
			    icon: 'fa fa-warning',
			    type: 'red',
			    theme: 'modern',
			    onClose: function () {
			        // before the modal is hidden. 
			    }
			  });
	      }
	    });
 	}
 	//==============================================PRINT REPORT==================================================//

 	//==================================COLLAPSE SIDEBAR & RELOAD DATATABLE======================================//
 	function hidebar(){
		if($("#main").hasClass("sidebar-show")){
			$( ".sidebar-show .nav.main-menu > li > a" ).removeClass( "scaleUp15" );
			$( ".sidebar-show .nav.main-menu > li > a" ).removeClass( "scaleUp13" );
			setTimeout(function(){ $("#sidebar-left").addClass("hidesidebar"); }, 4000);

		}else{
			$("#sidebar-left").addClass("hidesidebar");
			setTimeout(function(){
				$("#sidebar-left").removeClass("hidesidebar");
			}, 300);
			setTimeout(function(){
				$("#sidebar-left").addClass("hidesidebar");
			}, 4000);
		}
	}
	$( document ).ready(function() {
		hidebar();
		$('input').blur();
		$(".show-sidebar").click(function(){
			hidebar();
			if($.fn.DataTable.isDataTable( '.table-datatable' )){
				loadDataTable();
			}
		})
		$('[data-toggle="tooltip"]').tooltip();

		var scaleUp15 ='';
		var scaleUp13 ='';

		<?php if($_SESSION["menu_position"] == 'left') {?>
			scaleUp15 = 'scaleUp15-left';
			scaleUp13 = 'scaleUp13-left';
		<?php }else{?>
			scaleUp15 = 'scaleUp15-bottom';
			scaleUp13 = 'scaleUp13-bottom';
		<?php }?>
		$(".main-menu > li > a").mouseenter(function(){
			if($("#main").hasClass("sidebar-show")){
				$( ".sidebar-show .nav.main-menu > li > a" ).removeClass( scaleUp15 );
				$( ".sidebar-show .nav.main-menu > li > a" ).removeClass( scaleUp13 );

				$( this ).addClass( scaleUp15 );
				$( this ).removeClass( "fadeInRight" );
				$( this ).parents( "li" ).prev().children( "a" ).addClass( scaleUp13 );
				$( this ).parents( "li" ).next().children( "a" ).addClass( scaleUp13 );
			}
		});
		$(".main-menu").mouseleave(function(){
			$( ".sidebar-show .nav.main-menu > li > a" ).removeClass( scaleUp15 );
			$( ".sidebar-show .nav.main-menu > li > a" ).removeClass( scaleUp13 );
		});
		$(".bt-preference").click(function(){
			if($(".setting").hasClass("hidepref")){
				$(".setting").removeClass("hidepref");
			}else{
				$(".setting").addClass("hidepref");
			}
		});
	});
	var counter = 0;
	var leave;
	$("#sidebar-left").before().on("mouseover", function() {
		clearInterval(leave);
		$("#sidebar-left").removeClass("hidesidebar");
		counter = 0;
	})
	$("#sidebar-left").on("mouseleave", function() {
		if($("#main").hasClass("sidebar-show")){
	        leave = setInterval(function () {
	        	// console.log(counter);
	        	if(counter == 3){
	        		$("#sidebar-left").addClass("hidesidebar");
					$(".dropdown-menu").css("display","none");
					$("#sidebar-left").removeClass("hidetips");
					$("ul.dropdown-menu").removeClass("open");
					clearInterval(leave);
	        	}
	            ++counter;
	        }, 1000);
	    }
	})
	//==================================COLLAPSE SIDEBAR & RELOAD DATATABLE======================================//

	//=======================================OVERRIDE FILTER WITH AJAX===========================================//
	/*START added_by:glennferio@inspiraworld.com;last_updated:2020-05-19;*/
	// FILTER WITH AJAX
	$(document).on('click', '#search', function(event) {
		event.preventDefault();
		var filter_link = $("#form_filter").attr("action");
		var obj=$.dialog({
	      icon: 'fa fa-spinner fa-spin',
	      title: 'Please Wait..',
	      draggable: false,
	      animation: 'scale',
	      content: '<font style="font-size:14px">Requesting Data..</font>',
	      buttons: {
	        ok: {
	            isHidden: true,
	          }
	      },
	      onOpen: function () {
	            $.ajax({
			        url: filter_link,
			        type: 'POST',
			        data: $("#form_filter").serialize(),
			        success: function(msg) {
			        	obj.close();
			            location.reload();
			        }               
			    });
	        }
	    });
	});
	/*END added_by:glennferio@inspiraworld.com;last_updated:2020-05-19;*/
	//=======================================OVERRIDE FILTER WITH AJAX===========================================//
	
	//=======================================OVERRIDE RELOAD WITH AJAX===========================================//
	/*START added_by:glennferio@inspiraworld.com;last_updated:2020-05-27;*/
	// RELOAD WITH AJAX
	$(document).on('click', '.reload', function(event) {
		event.preventDefault();
		var reload_link = $(this).attr("link");
		var obj=$.dialog({
	      icon: 'fa fa-spinner fa-spin',
	      title: 'Please Wait..',
	      draggable: false,
	      animation: 'scale',
	      content: '<font style="font-size:14px">Requesting Data..</font>',
	      buttons: {
	        ok: {
	            isHidden: true,
	          }
	      },
	      onOpen: function () {
	            $.ajax({
			        url: reload_link,
			        type: 'POST',
			        data: '',
			        success: function(msg) {
			        	obj.close();
			            location.reload();
			        }               
			    });
	        }
	    });
	});
	/*END added_by:glennferio@inspiraworld.com;last_updated:2020-05-27;*/
	//=======================================OVERRIDE RELOAD WITH AJAX===========================================//
</script>
<?php /*END created_by:glennferio@inspiraworld.com;release_date:2020-05-20;*/ ?>