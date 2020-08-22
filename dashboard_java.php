<script language="javascript" type="text/javascript">
	function auto_ctrl_a(element)
	{
		$(element).on('focus',function(e)
		{
			$(this).select();
		});
	}
	<?php
 isset($_SESSION["setting"]["date_1"]) ? $date_1 = $_SESSION["setting"]["date_1"] : $date_1 = 'yy/mm/dd';
 isset($_SESSION["setting"]["datetime_1"]) ? $datetime_1 = $_SESSION["setting"]["datetime_1"] : $datetime_1 = 'YYYY/MM/DD HH:mm:ss';
 isset($_SESSION["setting"]["period_1"]) ? $period_1 = $_SESSION["setting"]["period_1"] : $period_1 = 'yy/mm/01';
 isset($_SESSION["setting"]["coltemplate_date_1"]) ? $coltemplate_date_1 = $_SESSION["setting"]["coltemplate_date_1"] : $coltemplate_date_1 = 'yy/mm/dd';
 isset($_SESSION["setting"]["coltemplate_datetime_1"]) ? $coltemplate_datetime_1 = $_SESSION["setting"]["coltemplate_datetime_1"] : $coltemplate_datetime_1 = 'yy/mm/dd|HH:mm:ss';
 $coltemplate_datetime_date = explode("|",$coltemplate_datetime_1)[0];
 $coltemplate_datetime_time = explode("|",$coltemplate_datetime_1)[1];
 isset($_SESSION["setting"]["coltemplate_period_1"]) ? $coltemplate_period_1 = $_SESSION["setting"]["coltemplate_period_1"] : $coltemplate_period_1 = 'yy/mm/01';
 $start_date=$_SESSION["setting"]["start_date"];
 $min_date=mysqli_fetch_array(mysqli_query($con, "SELECT DATE_FORMAT('".$_SESSION["setting"]["start_date"]."','".$_SESSION["setting"]["date_sql"]."') AS min_date, TIMESTAMPDIFF(MONTH,'".$_SESSION["setting"]["start_date"]."',NOW()) AS min_period"));$this_month=date("Y-m")."-01";$next_month=date("Y-m-d",strtotime("+1 month",strtotime($this_month)));
 $max_date=date("Y-m-t",strtotime($next_month));

 $declares=array("decimal_number|","decimal_percent|","decimal_money|","separator_decimal|'","separator_thousands|'");foreach($declares as $declare){$dec=explode("|",$declare);if(!empty($_SESSION["setting"][$dec[0]]))$val=$_SESSION["setting"][$dec[0]];else $val=0;echo " var ".$dec[0]." = ".$dec[1].$val.$dec[1]."; ";}$temp_width="width:100";$temp_right="align:'right'";$temp_sortable="sortable:false";$temp_decimalSeparator="decimalSeparator:separator_decimal";$temp_thousandsSeparator="thousandsSeparator:separator_thousands";$temp_defaultValue="defaultValue:''";$temp_editable="editable:true";$temp_required="required:true";$temp_number="number:true";$temp_editrules="editrules:{ ".$temp_required." }";$coltemplate["general"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable." }";$coltemplate["integer"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:0, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["number"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:decimal_number, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["number1"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:1, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["number2"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:2, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["number3"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:3, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["number4"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:4, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["number5"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:5, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["number6"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:6, ".$temp_defaultValue." }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["percent"]="{ width:50, ".$temp_right.", ".$temp_sortable.", formatter:'number', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:decimal_percent }, ".$temp_editable.", editrules:{ ".$temp_number." } }";$coltemplate["currency"]="{ ".$temp_width.", ".$temp_right.", ".$temp_sortable.", formatter:'currency', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:decimal_money, ".$temp_defaultValue." }, ".$temp_editable.", editrules: { ".$temp_number." } }";$coltemplate["currency2"]="{ ".$temp_width.", ".$temp_right.", ".$temp_sortable.", formatter:'currency', formatoptions:{ ".$temp_decimalSeparator.", ".$temp_thousandsSeparator.", decimalPlaces:decimal_number, ".$temp_defaultValue." }, ".$temp_editable.", editrules: { ".$temp_number." } }";$coltemplate["date_1"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).datepicker({
				dateFormat:'".$coltemplate_date_1."',
				minDate: '".$min_date["min_date"]."',
				maxDate: '".$max_date."',
				// maxDate: '+1M +30D',
				changeMonth: true,
				changeYear: true,
				onClose: function () { this.focus(); }
			});
		}
	},formatoptions:{ newformat: 'Y-m-d' } }";$coltemplate["datetime_1"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
            size: 18, maxlengh: 10, dataInit: function(element) {
                  $(element).jquerydatetimepicker({
                        dateFormat:'".$coltemplate_datetime_date."',
                        timeFormat: '".$coltemplate_datetime_time."',
                        timeInput: true,
                        minDate: '".$min_date["min_date"]."',
                        maxDate: '".$max_date."',
                        showMillisec: false,
                        changeMonth: true,
                        changeYear: true,
                        yearRange: '-99:+99',
                        onClose: function () { this.focus(); }

                  });
                  // $(element).datetimepicker(
                  // {
                  //       toolbarPlacement: 'top',
                  //       showClose: true,
                  //       showTodayButton:true,
                  //       keepOpen:false,
                  //       // widgetParent: '.ui-jqgrid-view',
                  //       minDate: '".$_SESSION["setting"]["start_datetime"]."',
                  //       maxDate: '".$max_date."',
                  //       format : '".$_SESSION["setting"]["datetime_1"]."'
                  // });
            }
      }, formatoptions:{ newformat: 'Y-m-d' } }";$coltemplate["period_1"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
            size: 18, maxlengh: 10, dataInit: function(element) {
                  $(element).datepicker({
                        dateFormat:'".$coltemplate_period_1."',
                        minDate: '-".$min_date["min_period"]."M',
                        maxDate: '".$max_date."',
                        // maxDate: '+1M +30D',
                        changeMonth: true,
                        changeYear: true,
                        onClose: function () { this.focus(); }
                  });
            }
      }, formatoptions:{ newformat: 'Y-m-d' } }";$coltemplate["date_1_custom"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				yearRange: '-99:+99',
				onClose: function () { this.focus(); }
			});
		}
	}, formatoptions:{ newformat: 'Y-m-d' }, editrules:{ date:true } }";$coltemplate["period_1_custom"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).datepicker({
				dateFormat: 'yy-mm',
				changeMonth: true,
				changeYear: true,
				yearRange: '-99:+99',
				onClose: function () { this.focus(); }
			});
		}
	}, formatoptions:{ newformat: 'Y-m' } }";$coltemplate["datetime_1_custom"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).jquerydatetimepicker({
				dateFormat: 'yy-mm-dd',
				timeFormat: 'HH:mm:ss',
				changeMonth: true,
				changeYear: true,
				yearRange: '-99:+99',
				onClose: function () { this.focus(); }
			});
		}
	}, formatoptions:{ newformat: 'Y-m-d H:i:s' } }";$coltemplate["date_2"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).datepicker({
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
				changeYear: true,
				onClose: function () { this.focus(); }
			});
		}
	}, formatoptions:{ newformat: 'Y-m-d' }, editrules:{ date:true } }";$coltemplate["time_1"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
		size: 18, maxlengh: 8, dataInit: function(element) {
			$(element).clockpicker({ 
				autoclose: true,
				align: 'left',
				placement:'top',
				onClose: function () { this.focus(); }
			});
		}
	}, formatoptions:{ newformat: 'H:i:s' } }";$coltemplate["browsedefault"]="{ searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']} }";
		foreach($coltemplate as $key => $val)
			echo " var coltemplate_".$key." = ".$val."; ";
	?>
	// new sync
	var vgrid_comp = [];
	var vgrid_load = [];
	var vgrid_last = [];
	var vgrid_real = [];
	
	var idInputOnchange = "";
	var isChangeDiskon1Nominal = 0;
	var isChangeDiskon2Nominal = 0;
	var isChangeDiskon3Nominal = 0;
	var isChangePPNNominal = 0;
	var defaultDiskon1Nominal = 0;
	var defaultDiskon2Nominal = 0;
	var defaultDiskon3Nominal = 0;
	var defaultPPNNominal = 0;

	var viewmode = "";
	var editmode = "";
	var addmode  = "";
	<?php if(isset($_GET["a"])){?>
		viewmode = "<?php echo $_GET["a"]?>";
	<?php }?>
	<?php if(isset($_GET["sm"])){?>
		editmode = "<?php echo $_GET["sm"]?>";
	<?php }?>
	<?php if(isset($_GET["no"])){?>
		addmode  = "<?php echo $_GET["no"]?>";
	<?php }?>
	var finalmode = "";
	var firstload = 0;

	if( viewmode == "edit" && editmode != "" && addmode != "" )
	{
		finalmode == "view";
	}
	if( viewmode == "edit" && editmode != "" && addmode == "" )
	{
		finalmode == "edit";
	}
	if( viewmode == "edit" && editmode == "" && addmode == "" )
	{
		finalmode == "add";
	}

	setInterval(function(){
		var penghitungan_kurs    = $("input[name='kurs'].form-control").val();
		var penghitungan_total   = $("input[name='total'].form-control").val();
		var penghitungan_totalrp = $("input[name='totalrp'].form-control").val();
		if(penghitungan_kurs != undefined && penghitungan_total != undefined && penghitungan_total != undefined){
			$("input[name='totalrp'].form-control").val( parseFloat(penghitungan_kurs) * parseFloat(penghitungan_total) );
		}
	},100);

	// fungsi-fungsi yang dipakai hampir di semua menu
	$(function()
	{
	    $('input').on('focus', function() {
	        idInputOnchange = ($(this).attr("id"));
	    });
	    /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
	    $('.ask').on('click', function(e) {
	        e.preventDefault();
			thisHref	= $(this).attr('href');
			mode 		= $(this).children('i').attr('title');
			var icon    = 'fa-fa-warning', type = 'default';
			if(mode.toLowerCase() == 'delete'){
				icon = 'fa fa-trash';
				type = 'red'; 
				<?php if(!empty($_SESSION["setting"]["navbutton_delete"])) { ?>
              		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_delete"])[0] ?>';
              		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_delete"])[1] ?>';
              		if(icon_class!= ''){
              			icon = icon_class;
              		}
              		if(icon_color!= ''){
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-danger'){
              				type = "red";
              			}
              			if(icon_color == 'btn-success'){
              				type = "green";
              			}
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-dark'){
              				type = "dark";
              			}
              			if(icon_color == 'btn-default'){
              				type = "default";
              			}
              			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
              				type = "blue";
              			}
              		}
              	<?php }?>
			}
			if(mode.toLowerCase() == 'approve'){
					icon = 'fa fa-check-square-o';
					type = 'green';
				<?php if(!empty($_SESSION["setting"]["navbutton_approve"])) { ?>
              		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_approve"])[0] ?>';
              		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_approve"])[1] ?>';
              		if(icon_class!= ''){
              			icon = icon_class;
              		}
              		if(icon_color!= ''){
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-danger'){
              				type = "red";
              			}
              			if(icon_color == 'btn-success'){
              				type = "green";
              			}
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-dark'){
              				type = "dark";
              			}
              			if(icon_color == 'btn-default'){
              				type = "default";
              			}
              			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
              				type = "blue";
              			}
              		}
                <?php }?>
			}
			if(mode.toLowerCase() == 'disapprove'){
				icon = 'fa fa-times';
				type = 'red';
				<?php if(!empty($_SESSION["setting"]["navbutton_disapprove"])) { ?>
              		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_disapprove"])[0] ?>';
              		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_disapprove"])[1] ?>';
              		if(icon_class!= ''){
              			icon = icon_class;
              		}
              		if(icon_color!= ''){
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-danger'){
              				type = "red";
              			}
              			if(icon_color == 'btn-success'){
              				type = "green";
              			}
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-dark'){
              				type = "dark";
              			}
              			if(icon_color == 'btn-default'){
              				type = "default";
              			}
              			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
              				type = "blue";
              			}
              		}
                <?php }?>
			}
			if(mode.toLowerCase() == 'reject'){
				icon = 'fa fa-ban';
				type = 'red';
				<?php if(!empty($_SESSION["setting"]["navbutton_reject"])) { ?>
              		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_reject"])[0] ?>';
              		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_reject"])[1] ?>';
              		if(icon_class!= ''){
              			icon = icon_class;
              		}
              		if(icon_color!= ''){
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-danger'){
              				type = "red";
              			}
              			if(icon_color == 'btn-success'){
              				type = "green";
              			}
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-dark'){
              				type = "dark";
              			}
              			if(icon_color == 'btn-default'){
              				type = "default";
              			}
              			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
              				type = "blue";
              			}
              		}
                <?php }?>
			}
			if(mode.toLowerCase() == 'print'){
				icon = 'fa fa-print';
				type = 'blue';
				<?php if(!empty($_SESSION["setting"]["navbutton_print"])) { ?>
              		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_print"])[0] ?>';
              		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_print"])[1] ?>';
              		if(icon_class!= ''){
              			icon = icon_class;
              		}
              		if(icon_color!= ''){
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-danger'){
              				type = "red";
              			}
              			if(icon_color == 'btn-success'){
              				type = "green";
              			}
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-dark'){
              				type = "dark";
              			}
              			if(icon_color == 'btn-default'){
              				type = "default";
              			}
              			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
              				type = "blue";
              			}
              		}
                <?php }?>
			}
			if(mode.toLowerCase() == 'finish'){
				icon = 'fa fa-flag-checkered';
				type = 'default';
				<?php if(!empty($_SESSION["setting"]["navbutton_close"])) { ?>
              		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_close"])[0] ?>';
              		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_close"])[1] ?>';
              		if(icon_class!= ''){
              			icon = icon_class;
              		}
              		if(icon_color!= ''){
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-danger'){
              				type = "red";
              			}
              			if(icon_color == 'btn-success'){
              				type = "green";
              			}
              			if(icon_color == 'btn-warning'){
              				type = "orange";
              			}
              			if(icon_color == 'btn-dark'){
              				type = "dark";
              			}
              			if(icon_color == 'btn-default'){
              				type = "default";
              			}
              			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
              				type = "blue";
              			}
              		}
                <?php }?>
			}
			$.confirm({
		          icon: icon,
		          theme: 'modern',
		          closeIcon: true,
		          animation: 'scale',
		          type: type,
		          title: 'NOTIFICATION',
		          content: 'Apakah Anda Yakin Ingin ' + mode + '?',
		          buttons: {
		               Ya:function(){
		                    window.location = thisHref;                        
		                },
		                Tidak:function(){
		                },
		          }
		     });
	    });
	    // $('.ask').jConfirmAction();
	    /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
		$('[data-toggle="tooltip"]').tooltip();
	/*	$('#form_search').submit(function()
		{
			var keyword = $('#keyword').val();
			if(!keyword)
				alert('<?php echo get_message(715)?>');	
			else
				return true;
			return false;
		});
	*/	
		$('.date_1').datepicker(
		{
		//	untuk field tanggal yang akan disimpan ke database dengan format date '2000-01-01'
		//	bersifat transaksional (dibatasi mulai dari tanggal saldo awal program hingga sebulan ke depan)
			dateFormat:'<?php echo $date_1?>',
			minDate: '<?php echo $min_date["min_date"]?>',
			maxDate: '<?php echo $max_date?>',
			changeMonth: true,
			changeYear: true
		});
		$('.datetime_1').datetimepicker(
		{
		//	untuk field tanggal yang akan disimpan ke database dengan format date '2000-01-01'
		//	bersifat transaksional (dibatasi mulai dari tanggal saldo awal program hingga sebulan ke depan)
			// inline: true,
			// sideBySide: true,
			toolbarPlacement: 'top',
			showClose: true,
			showTodayButton:true,
			keepOpen:false,
			minDate: '<?php echo $min_date["min_date"]?>',
			maxDate: '<?php echo $max_date?>',
			format : '<?php echo $datetime_1?>'
			// 24 HOURS TIME
			// format : "DD-MM-YYYY HH:mm:ss"
		});
		$('.date_1_custom').datepicker(
		{
		//	untuk field tanggal yang akan disimpan ke database dengan format date '2000-01-01'
		//	bersifat non-transaksional (misal: tanggal lahir / tanggal bergabung)
			dateFormat:'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: '-99:+99'
		});
		$('.date_2,.date_2_custom').datepicker(
		{
		//	untuk field tanggal yang tidak akan disimpan ke database (misal: untuk filter)
		//	class date_2 akan otomatis terisi tanggal default (diatur oleh codes/form.php)
		//	class date_2_custom tidak akan otomatis terisi tanggal default
			dateFormat:'dd-mm-yy',
			changeMonth: true,
			changeYear: true
		});
		$('.period_1').datepicker(
		{
		//	untuk field periode yang akan disimpan ke database dengan format date '2000-01-01'
		//	bersifat transaksional (dibatasi mulai dari tanggal saldo awal program hingga sebulan ke depan)
			dateFormat:'<?php echo $period_1?>',
			minDate: '-<?php echo $min_date["min_period"]?>M',
			// maxDate: '+1M',
			changeMonth: true,
			changeYear: true
		});
		$('.period_1_custom').datepicker(
		{
		//	untuk field periode yang akan disimpan ke database dengan format char '2000-01'
		//	bersifat non-transaksional
			dateFormat:'yy-mm',
			changeMonth: true,
			changeYear: true
		});
		$('.period_2').datepicker(
		{
		//	untuk field periode yang tidak akan disimpan ke database (misal: untuk filter)
			dateFormat:'mm-yy',
			changeMonth: true,
			changeYear: true
		});
		//$('.time_1').timepicker({ timeFormat: 'HH:mm:ss' });
		$('.time_1').clockpicker({
			autoclose: true,
			align: 'left',
			placement:'bottom',
		});
		$('.iptinteger').number(true,0,separator_decimal,separator_thousands);
		$('.iptnumber').number(true,decimal_number,separator_decimal,separator_thousands);
		$('.iptnumber1').number(true,1,separator_decimal,separator_thousands);
		$('.iptnumber2').number(true,2,separator_decimal,separator_thousands);
		$('.iptnumber3').number(true,3,separator_decimal,separator_thousands);
		$('.iptnumber4').number(true,4,separator_decimal,separator_thousands);
		$('.iptnumber5').number(true,5,separator_decimal,separator_thousands);
		$('.iptnumber6').number(true,6,separator_decimal,separator_thousands);
		$('.iptpercent').number(true,decimal_percent,separator_decimal,separator_thousands);
		$('.iptmoney').number(true,decimal_money);
		$('.iptmoney3').number(true,3,separator_decimal,separator_thousands);
		/*
		$('.summary').blur(function()
		{
			calculate_summary();
		});
		*/
		jQuery.validator.addMethod("notEqualTo", function(v, e, p)
		{
			return this.optional(e) || v != p;
		}, "Please specify a different value");
		LoadSelect2Script(DemoSelect2);
	});
	function DemoSelect2()
	{
		$('.select2').select2();
	}
	function browse_open(id)
	{
		$(function()
		{
			$('#browse_'+id+'_area').attr('class','');
			$.blockUI(
			{
				message: $('#browse_'+id+'_area'),
				css:
				{
					top:'15%',
					left:'17%',
					width:'<?php echo $_SESSION["setting"]["browse_area_width"]?>',
					cursor:'default'
				}
			});
			$('#browse_'+id+'_close').click(function()
			{
				browse_closing(id);
			});
		});
	}
	function browse_closing(id)
	{
		$(function()
		{
			$.unblockUI({});
			$('#browse_'+id+'_area').attr('class','hiding');
		});
	}
	function browse_clear(id, element)
	{
		$(function()
		{
			$('.browse_'+id+'_clear').val('');
			$('.browse_'+id+'_clear').html('');
			$('#browse_'+id+'_keyword').val('');

			var totalPage = $(element).getGridParam('lastpage').toString();
    		var saveSelectedRows = '0';
    		for(var i = 1; i <= parseInt(totalPage); i++){
	            $(element).data(i.toString(), saveSelectedRows);
	        }
		});
	}
	function browse_selected_open(id)
	{
		$(function()
		{
			var value_hidden = $('#browse_'+id+'_hidden').val();
			var selected_url = $('#browse_'+id+'_selected_url').val();
			if(value_hidden != '' && selected_url != '')
				window.open(selected_url+value_hidden,'_newtab');
		});
	}
	function take_number(number)
	{
		if(!number)
			number = 0;
		number = parseFloat(number);
		number = isNaN(number) ? 0 : number;
		return number;
	}
	function round_number(number,decimal)
	{
		return Math.round(number*Math.pow(10,decimal))/Math.pow(10,decimal);
	}
	function calculate_summary(id,mode)
	{
		console.log('calculate_summary('+id+')');
		$(function()
		{
			var total = 0;
			var total_diskon = 0;
			var total_um = 0;
			
			if($('#sum_subtotal_'+id))
			{
				var subtotal = $('#sum_subtotal_'+id).val();
				total = take_number(subtotal);
			}
			
			if($('#sum_diskon1_'+id))
			{
				// if($('#sum_diskon1tipe_'+id) && $('#sum_diskon1tipe_'+id).val() == '1')
				// 	isChangeDiskon1Nominal = 1;
				// if(isChangeDiskon1Nominal == 0)
				// {
				// 	var diskon1 = $('#sum_diskon1_'+id).val();
				// 	diskon1 = take_number(diskon1);
				// 	var diskon1nominal = diskon1/100 * total;
				// }
				// else
				// {
				// 	var diskon1nominal = $('#sum_diskon1nominal_'+id).val();
				// 	diskon1nominal = take_number(diskon1nominal);
				// 	var diskon1 = (diskon1nominal * 100) / total;
				// 	diskon1nominal = $('#sum_diskon1nominal_'+id).val();
				// }
				var diskon1 		= take_number($('#sum_diskon1_'+id).val());
				var diskon1nominal 	= take_number($('#sum_diskon1nominal_'+id).val());
	
				var isChangeDiskon1Prosentase = 0;
				if($('#sum_diskon1tipe_'+id) && mode == "diskon1prosentase")
					isChangeDiskon1Prosentase = 1;
				if(isChangeDiskon1Prosentase == 1)
				{
					var diskon1nominal = diskon1/100 * total;
					diskon1nominal = round_number(diskon1nominal,decimal_money);
					$('#sum_diskon1nominal_'+id).val(diskon1nominal);
				}
				else
				{
					var diskon1 = (diskon1nominal * 100) / total;
					diskon1 = round_number(diskon1,decimal_percent);
					$('#sum_diskon1_'+id).val(diskon1);
				}
				
				total -= diskon1nominal;
				total_diskon += diskon1nominal;
				
				// diskon1 = round_number(diskon1,decimal_percent);
				// diskon1nominal = round_number(diskon1nominal,decimal_money);
				// $('#sum_diskon1_'+id).val(diskon1);
				// $('#sum_diskon1nominal_'+id).val(diskon1nominal);
			}
			
			if($('#sum_diskon2_'+id))
			{
				var diskon2 		= take_number($('#sum_diskon2_'+id).val());
				var diskon2nominal 	= take_number($('#sum_diskon2nominal_'+id).val());
	
				var isChangeDiskon2Prosentase = 0;
				if($('#sum_diskon2tipe_'+id) && mode == "diskon2prosentase")
					isChangeDiskon2Prosentase = 1;
				if(isChangeDiskon2Prosentase == 1)
				{
					var diskon2nominal = diskon2/100 * total;
					diskon2nominal = round_number(diskon2nominal,decimal_money);
					$('#sum_diskon2nominal_'+id).val(diskon2nominal);
				}
				else
				{
					var diskon2 = (diskon2nominal * 100) / total;
					diskon2 = round_number(diskon2,decimal_percent);
					$('#sum_diskon2_'+id).val(diskon2);
				}

				// if($('#sum_diskon2tipe_'+id) && $('#sum_diskon2tipe_'+id).val() == '1')
				// 	isChangeDiskon2Nominal = 1;
				// if(isChangeDiskon2Nominal == 0)
				// {
				// 	var diskon2 = $('#sum_diskon2_'+id).val();
				// 	diskon2 = take_number(diskon2);
				// 	var diskon2nominal = diskon2/100 * total;
				// }
				// else
				// {
				// 	var diskon2nominal = $('#sum_diskon2nominal_'+id).val();
				// 	diskon2nominal = take_number(diskon2nominal);
				// 	var diskon2 = (diskon2nominal * 100) / total;
				// 	diskon2nominal = $('#sum_diskon2nominal_'+id).val();
				// }
				
				total -= diskon2nominal;
				total_diskon += diskon2nominal;
				
				// diskon2 = round_number(diskon2,decimal_percent);
				// diskon2nominal = round_number(diskon2nominal,decimal_money);
				// $('#sum_diskon2_'+id).val(diskon2);
				// $('#sum_diskon2nominal_'+id).val(diskon2nominal);
			}
			
			if($('#sum_diskon3_'+id))
			{
				var diskon3 		= take_number($('#sum_diskon3_'+id).val());
				var diskon3nominal 	= take_number($('#sum_diskon3nominal_'+id).val());
	
				var isChangeDiskon3Prosentase = 0;
				if($('#sum_diskon3tipe_'+id) && mode == "diskon3prosentase")
					isChangeDiskon3Prosentase = 1;
				if(isChangeDiskon3Prosentase == 1)
				{
					var diskon3nominal = diskon3/100 * total;
					diskon3nominal = round_number(diskon3nominal,decimal_money);
					$('#sum_diskon3nominal_'+id).val(diskon3nominal);
				}
				else
				{
					var diskon3 = (diskon3nominal * 100) / total;
					diskon3 = round_number(diskon3,decimal_percent);
					$('#sum_diskon3_'+id).val(diskon3);
				}

				// if($('#sum_diskon3tipe_'+id) && $('#sum_diskon3tipe_'+id).val() == '1')
				// 	isChangeDiskon3Nominal = 1;
				// if(isChangeDiskon3Nominal == 0)
				// {
				// 	var diskon3 = $('#sum_diskon3_'+id).val();
				// 	diskon3 = take_number(diskon3);
				// 	var diskon3nominal = diskon3/100 * total;
				// }
				// else
				// {
				// 	var diskon3nominal = $('#sum_diskon3nominal_'+id).val();
				// 	diskon3nominal = take_number(diskon3nominal);
				// 	var diskon3 = (diskon3nominal * 100) / total;
				// 	diskon3nominal = $('#sum_diskon3nominal_'+id).val();
				// }
				
				total -= diskon3nominal;
				total_diskon += diskon3nominal;
				
				// diskon3 = round_number(diskon3,decimal_percent);
				// diskon3nominal = round_number(diskon3nominal,decimal_money);
				// $('#sum_diskon3_'+id).val(diskon3);
				// $('#sum_diskon3nominal_'+id).val(diskon3nominal);
			}
			
			if($('#sum_diskontotal_'+id))
			{
				total_diskon = round_number(total_diskon,decimal_money);
				$('#sum_diskontotal_'+id).val(total_diskon);
			}
			
			if($('#sum_um1_'+id))
			{
				var um1 = $('#sum_um1_'+id).val();
				um1 = take_number(um1);
				total -= um1;
				total_um += um1;
			}
			
			if($('#sum_um2_'+id))
			{
				var um2 = $('#sum_um2_'+id).val();
				um2 = take_number(um2);
				total -= um2;
				total_um += um2;
			}
			
			if($('#sum_um3_'+id))
			{
				var um3 = $('#sum_um3_'+id).val();
				um3 = take_number(um3);
				total -= um3;
				total_um += um3;
			}
			
			if($('#sum_umtotal_'+id))
			{
				total_um = round_number(total_um,decimal_money);
				$('#sum_umtotal_'+id).val(total_um);
			}
			
			if($('#sum_dpp_'+id))
			{
				$('#sum_dpp_'+id).val(total);
			}
			
			if($('#sum_ppn_'+id))
			{
				if($('#sum_ppntipe_'+id) && $('#sum_ppntipe_'+id).val() == '1')
					isChangePPNNominal = 1;
				if(isChangePPNNominal == 0)
				{
					var ppn = $('#sum_ppn_'+id).val();
					ppn = take_number(ppn);
					var ppnnominal = ppn/100 * total;
				}
				else
				{
					var ppnnominal = $('#sum_ppnnominal_'+id).val();
					ppnnominal = take_number(ppnnominal);
					var ppn = (ppnnominal * 100) / total;
					ppnnominal = $('#sum_ppnnominal_'+id).val();
				}
				
				total += ppnnominal;
				
				ppn = round_number(ppn,decimal_percent);
				ppnnominal = round_number(ppnnominal,decimal_money);
				$('#sum_ppn_'+id).val(ppn);
				$('#sum_ppnnominal_'+id).val(ppnnominal);
			}
			
			if($('#sum_total_'+id))
			{
				total = round_number(total,decimal_money);
				$('#sum_total_'+id).val(total);
			}
		});
	}
	function calculate_summaries(id,mode)
	{
		console.log('calculate_summaries id='+id+' mode='+mode);
		$(function()
		{
			console.log('finalmode='+finalmode+'; firstload='+firstload);
			if(finalmode != "add" && firstload == 0)
			{
				var first_subtotal = $('#sum_subtotal_'+id).val();
				var first_diskon1nominal = $('#sum_diskon1nominal_'+id).val();
				var first_diskon2nominal = $('#sum_diskon2nominal_'+id).val();
				var first_dpp = $('#sum_dpp_'+id).val();
				firstload = 1;
				
				// DISKON 1
				var diskon1 = $('#sum_diskon1_'+id).val();
					diskon1 = take_number(diskon1);
				var diskon1nominal = $('#sum_diskon1nominal_'+id).val();
				var diskon1nominal_calculate = diskon1/100 * first_subtotal;
					diskon1nominal_calculate = round_number(diskon1nominal_calculate,decimal_money);
				console.log('diskon1nominal='+diskon1nominal+'; diskon1nominal_calculate='+diskon1nominal_calculate);
				if(diskon1nominal != diskon1nominal_calculate) 
					isChangeDiskon1Nominal = 1;
				console.log('isChangeDiskon1Nominal='+isChangeDiskon1Nominal);
				
				// DISKON 2
				var diskon2 = $('#sum_diskon2_'+id).val();
					diskon2 = take_number(diskon2);
				var diskon2nominal = $('#sum_diskon2nominal_'+id).val();
				var diskon2nominal_calculate = diskon2/100 * (first_subtotal-first_diskon1nominal);
					diskon2nominal_calculate = round_number(diskon2nominal_calculate,decimal_money);
				console.log('diskon2nominal='+diskon2nominal+'; diskon2nominal_calculate='+diskon2nominal_calculate);
				if(diskon2nominal != diskon2nominal_calculate) 
					isChangeDiskon2Nominal = 1;
				console.log('isChangeDiskon2Nominal='+isChangeDiskon2Nominal);
				
				// DISKON 3
				var diskon3 = $('#sum_diskon3_'+id).val();
					diskon3 = take_number(diskon3);
				var diskon3nominal = $('#sum_diskon3nominal_'+id).val();
				var diskon3nominal_calculate = diskon3/100 * (first_subtotal-first_diskon1nominal-first_diskon2nominal);
					diskon3nominal_calculate = round_number(diskon3nominal_calculate,decimal_money);
				console.log('diskon3nominal='+diskon3nominal+'; diskon3nominal_calculate='+diskon3nominal_calculate);
				if(diskon3nominal != diskon3nominal_calculate) 
					isChangeDiskon3Nominal = 1;
				console.log('isChangeDiskon3Nominal='+isChangeDiskon3Nominal);
				
				// PPN
				var ppn = $('#sum_ppn_'+id).val();
					ppn = take_number(ppn);
				var ppnnominal = $('#sum_ppnnominal_'+id).val();
				var ppnnominal_calculate = ppn/100 * first_dpp;
					ppnnominal_calculate = round_number(ppnnominal_calculate,decimal_money);
				console.log('ppnnominal='+ppnnominal+'; ppnnominal_calculate='+ppnnominal_calculate);
				if(ppnnominal != ppnnominal_calculate) 
					isChangePPNNominal = 1;
				console.log('isChangePPNNominal='+isChangePPNNominal);
			}
			
			var total = 0;
			var total_diskon = 0;
			var total_um = 0;
			
			if($('#sum_subtotal_'+id))
			{
				var subtotal = $('#sum_subtotal_'+id).val();
				total = take_number(subtotal);
			}
			
			if($('#sum_diskon1_'+id))
			{
				defaultDiskon1Nominal = $('#sum_diskon1nominal_'+id).val();
				
				if(idInputOnchange == 'sum_diskon1_'+id)
					isChangeDiskon1Nominal = 0;
				
				if(idInputOnchange == 'sum_diskon1nominal_'+id)
					isChangeDiskon1Nominal = 1;
				
				if(isChangeDiskon1Nominal == 0)
				{
					var diskon1 = $('#sum_diskon1_'+id).val();
					diskon1 = take_number(diskon1);
					var diskon1nominal = diskon1/100 * total;
				}
				else
				{
					var diskon1nominal = $('#sum_diskon1nominal_'+id).val();
					diskon1nominal = take_number(diskon1nominal);
					var diskon1 = (diskon1nominal * 100) / total;
				}
				
				if(isChangeDiskon1Nominal == 1)
					diskon1nominal = take_number(defaultDiskon1Nominal);
				
				total -= diskon1nominal;
				total_diskon += diskon1nominal;
				
				diskon1 = round_number(diskon1,decimal_percent);
				diskon1nominal = round_number(diskon1nominal,decimal_money);
				$('#sum_diskon1_'+id).val(diskon1);
				$('#sum_diskon1nominal_'+id).val(diskon1nominal);
			}
			
			if($('#sum_diskon2_'+id))
			{
				defaultDiskon2Nominal = $('#sum_diskon2nominal_'+id).val();
				
				if(idInputOnchange == 'sum_diskon2_'+id)
					isChangeDiskon2Nominal = 0;
				
				if(idInputOnchange == 'sum_diskon2nominal_'+id)
					isChangeDiskon2Nominal = 1;
				
				if(isChangeDiskon2Nominal == 0)
				{
					var diskon2 = $('#sum_diskon2_'+id).val();
					diskon2 = take_number(diskon2);
					var diskon2nominal = diskon2/100 * total;
				}
				else
				{
					var diskon2nominal = $('#sum_diskon2nominal_'+id).val();
					diskon2nominal = take_number(diskon2nominal);
					var diskon2 = (diskon2nominal * 100) / total;
				}
				
				if(isChangeDiskon2Nominal == 1)
					diskon2nominal = take_number(defaultDiskon2Nominal);
				
				total -= diskon2nominal;
				total_diskon += diskon2nominal;
				
				diskon2 = round_number(diskon2,decimal_percent);
				diskon2nominal = round_number(diskon2nominal,decimal_money);
				$('#sum_diskon2_'+id).val(diskon2);
				$('#sum_diskon2nominal_'+id).val(diskon2nominal);
			}
			
			if($('#sum_diskon3_'+id))
			{
				defaultDiskon3Nominal = $('#sum_diskon3nominal_'+id).val();
				
				if(idInputOnchange == 'sum_diskon3_'+id)
					isChangeDiskon3Nominal = 0;
				
				if(idInputOnchange == 'sum_diskon3nominal_'+id)
					isChangeDiskon3Nominal = 1;
				
				if(isChangeDiskon3Nominal == 0)
				{
					var diskon3 = $('#sum_diskon3_'+id).val();
					diskon3 = take_number(diskon3);
					var diskon3nominal = diskon3/100 * total;
				}
				else
				{
					var diskon3nominal = $('#sum_diskon3nominal_'+id).val();
					diskon3nominal = take_number(diskon3nominal);
					var diskon3 = (diskon3nominal * 100) / total;
				}
				
				if(isChangeDiskon3Nominal == 1)
					diskon3nominal = take_number(defaultDiskon3Nominal);
				
				total -= diskon3nominal;
				total_diskon += diskon3nominal;
				
				diskon3 = round_number(diskon3,decimal_percent);
				diskon3nominal = round_number(diskon3nominal,decimal_money);
				$('#sum_diskon3_'+id).val(diskon3);
				$('#sum_diskon3nominal_'+id).val(diskon3nominal);
			}
			
			if($('#sum_diskontotal_'+id))
			{
				total_diskon = round_number(total_diskon,decimal_money);
				$('#sum_diskontotal_'+id).val(total_diskon);
			}
			
			if($('#sum_um1_'+id))
			{
				var um1 = $('#sum_um1_'+id).val();
				um1 = take_number(um1);
				total -= um1;
				total_um += um1;
			}
			
			if($('#sum_um2_'+id))
			{
				var um2 = $('#sum_um2_'+id).val();
				um2 = take_number(um2);
				total -= um2;
				total_um += um2;
			}
			
			if($('#sum_um3_'+id))
			{
				var um3 = $('#sum_um3_'+id).val();
				um3 = take_number(um3);
				total -= um3;
				total_um += um3;
			}
			
			if($('#sum_umtotal_'+id))
			{
				total_um = round_number(total_um,decimal_money);
				$('#sum_umtotal_'+id).val(total_um);
			}
			
			if($('#sum_dpp_'+id))
			{
				$('#sum_dpp_'+id).val(total);
			}
			
			if($('#sum_ppn_'+id))
			{
				defaultPPNNominal = $('#sum_ppnnominal_'+id).val();
				
				if(idInputOnchange == 'sum_ppn_'+id)
					isChangePPNNominal = 0;
				
				if(idInputOnchange == 'sum_ppnnominal_'+id)
					isChangePPNNominal = 1;
				
				if(isChangePPNNominal == 0)
				{
					var ppn = $('#sum_ppn_'+id).val();
					ppn = take_number(ppn);
					var ppnnominal = ppn/100 * total;
				}
				else
				{
					var ppnnominal = $('#sum_ppnnominal_'+id).val();
					ppnnominal = take_number(ppnnominal);
					var ppn = (ppnnominal * 100) / total;
				}
				
				if(isChangePPNNominal == 1)
					ppnnominal = take_number(defaultPPNNominal);
				
				total += ppnnominal;
				
				ppn = round_number(ppn,decimal_percent);
				ppnnominal = round_number(ppnnominal,decimal_money);
				$('#sum_ppn_'+id).val(ppn);
				$('#sum_ppnnominal_'+id).val(ppnnominal);
			}
			
			if($('#sum_total_'+id))
			{
				total = round_number(total,decimal_money);
				$('#sum_total_'+id).val(total);
			}
		});
	}
	function check_value_elements(fields)
	{
		var failed = '';
		var length_fields = fields.length;
		for(var i = 0; i < length_fields; i++)
		{
			var field = fields[i].split('|');
			var val_field = $('#'+field[0]).val();
			if(val_field == '')
			{
				if(failed != '')
					failed += ", ";
				failed += field[1];
			}
		}
		return failed;
	}
	function link_confirmation(message,href,newtab, mode)
	{
		/*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
		// if(confirm(message))
		// {
		// 	if(newtab == '_newtab')
		// 		window.open(href,newtab);
		// 	else
		// 		document.location.href = href;
		// }
		var icon = 'fa-fa-warning', type = 'default';
		if(mode.toLowerCase() == 'delete'){
			icon = 'fa fa-trash';
			type = 'red';
			<?php if(!empty($_SESSION["setting"]["navbutton_delete"])) { ?>
          		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_delete"])[0] ?>';
          		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_delete"])[1] ?>';
          		if(icon_class != ''){
          			icon = icon_class;
          		}
          		if(icon_color!= ''){
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-danger'){
          				type = "red";
          			}
          			if(icon_color == 'btn-success'){
          				type = "green";
          			}
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-dark'){
          				type = "dark";
          			}
          			if(icon_color == 'btn-default'){
          				type = "default";
          			}
          			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
          				type = "blue";
          			}
          		}
            <?php } ?>
		}
		if(mode.toLowerCase() == 'approve'){
			icon = 'fa fa-check-square-o';
			type = 'green';
			<?php if(!empty($_SESSION["setting"]["navbutton_approve"])) { ?>
          		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_approve"])[0] ?>';
          		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_approve"])[1] ?>';
          		if(icon_class!= ''){
          			icon = icon_class;
          		}
          		if(icon_color!= ''){
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-danger'){
          				type = "red";
          			}
          			if(icon_color == 'btn-success'){
          				type = "green";
          			}
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-dark'){
          				type = "dark";
          			}
          			if(icon_color == 'btn-default'){
          				type = "default";
          			}
          			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
          				type = "blue";
          			}
          		}
            <?php } ?>
		}
		if(mode.toLowerCase() == 'disapprove'){
			icon = 'fa fa-times';
			type = 'red';
			<?php if(!empty($_SESSION["setting"]["navbutton_disapprove"])) { ?>
          		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_disapprove"])[0] ?>';
          		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_disapprove"])[1] ?>';
          		if(icon_class!= ''){
          			icon = icon_class;
          		}
          		if(icon_color!= ''){
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-danger'){
          				type = "red";
          			}
          			if(icon_color == 'btn-success'){
          				type = "green";
          			}
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-dark'){
          				type = "dark";
          			}
          			if(icon_color == 'btn-default'){
          				type = "default";
          			}
          			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
          				type = "blue";
          			}
          		}
            <?php } ?>
		}
		if(mode.toLowerCase() == 'reject'){
			icon = 'fa fa-ban';
			type = 'red';
			<?php if(!empty($_SESSION["setting"]["navbutton_reject"])) { ?>
          		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_reject"])[0] ?>';
          		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_reject"])[1] ?>';
          		if(icon_class!= ''){
          			icon = icon_class;
          		}
          		if(icon_color!= ''){
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-danger'){
          				type = "red";
          			}
          			if(icon_color == 'btn-success'){
          				type = "green";
          			}
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-dark'){
          				type = "dark";
          			}
          			if(icon_color == 'btn-default'){
          				type = "default";
          			}
          			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
          				type = "blue";
          			}
          		}
            <?php } ?>
		}
		if(mode.toLowerCase() == 'print'){
			icon = 'fa fa-print';
			type = 'blue';
			<?php if(!empty($_SESSION["setting"]["navbutton_print"])) { ?>
          		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_print"])[0] ?>';
          		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_print"])[1] ?>';
          		if(icon_class!= ''){
          			icon = icon_class;
          		}
          		if(icon_color!= ''){
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-danger'){
          				type = "red";
          			}
          			if(icon_color == 'btn-success'){
          				type = "green";
          			}
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-dark'){
          				type = "dark";
          			}
          			if(icon_color == 'btn-default'){
          				type = "default";
          			}
          			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
          				type = "blue";
          			}
          		}
            <?php } ?>
		}
		if(mode.toLowerCase() == 'finish'){
			icon = 'fa fa-flag-checkered';
			type = 'default';
			<?php if(!empty($_SESSION["setting"]["navbutton_close"])) { ?>
          		icon_class = '<?php echo explode("|", $_SESSION["setting"]["navbutton_close"])[0] ?>';
          		icon_color = '<?php echo explode("|", $_SESSION["setting"]["navbutton_close"])[1] ?>';
          		if(icon_class != ''){
          			icon = icon_class;
          		}
          		if(icon_color!= ''){
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-danger'){
          				type = "red";
          			}
          			if(icon_color == 'btn-success'){
          				type = "green";
          			}
          			if(icon_color == 'btn-warning'){
          				type = "orange";
          			}
          			if(icon_color == 'btn-dark'){
          				type = "dark";
          			}
          			if(icon_color == 'btn-default'){
          				type = "default";
          			}
          			if(icon_color == 'btn-primary' || icon_color == 'btn-info'){
          				type = "blue";
          			}
          		}
            <?php } ?>
		}
		$.confirm({
	          icon: icon,
	          theme: 'modern',
	          closeIcon: true,
	          animation: 'scale',
	          type: type,
	          title: 'NOTIFICATION',
	          content: 'Apakah Anda Yakin Ingin ' + mode + '?',
	          buttons: {
	               Ya:function(){
	                  if(newtab == '_newtab')
					window.open(href,newtab);
			 	else
			 		document.location.href = href;                     
	                },
	                Tidak:function(){
	                },
	          }
	    });
		/*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-13;*/
	}
</script>
<?php /*created_by:patricklipesik@gmail.com,release_date:2019-12-16*/ ?>