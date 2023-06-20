<?php /*START created_by:glennferio@inspiraworld.com;release_date:2020-05-20;*/ ?>
<?php if ($_SESSION["login"]["framework"] == "pelangi") { ?>
	<script src="<?= $page_dir . $config["webspira"] ?>assets_dashboard/js/creative_js.js" type="text/javascript"></script>
<?php } ?>
<?php include $page_dir . "assets_custom/php/custom_js.php"; ?>
<script src="<?= $page_dir ?>assets_custom/js/custom.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
	function auto_ctrl_a(element) {
		$(element).on('focus', function(e) {
			$(this).select();
		});
	}
	<?php
	$start_date = $_SESSION["setting"]["start_date"];

	// OLD FASHIONED DATEPICKER, DATETIMEPICKER, MONTHPICKER & TIMEPICKER
	isset($_SESSION["setting"]["date_1"]) ? $date_1 = $_SESSION["setting"]["date_1"] : $date_1 = 'yy-mm-dd';
	isset($_SESSION["setting"]["datetime_1"]) ? $datetime_1 = $_SESSION["setting"]["datetime_1"] : $datetime_1 = 'YYYY-MM-DD HH:mm:ss';
	isset($_SESSION["setting"]["month_1"]) ? $month_1 = $_SESSION["setting"]["month_1"] : $month_1 = 'yy-mm-01';
	isset($_SESSION["setting"]["coltemplate_date_1"]) ? $coltemplate_date_1 = $_SESSION["setting"]["coltemplate_date_1"] : $coltemplate_date_1 = 'yy-mm-dd';
	isset($_SESSION["setting"]["coltemplate_datetime_1"]) ? $coltemplate_datetime_1 = $_SESSION["setting"]["coltemplate_datetime_1"] : $coltemplate_datetime_1 = 'yy-mm-dd|HH:mm:ss';
	$coltemplate_datetime_date = explode("|", $coltemplate_datetime_1)[0];
	$coltemplate_datetime_time = explode("|", $coltemplate_datetime_1)[1];
	isset($_SESSION["setting"]["coltemplate_month_1"]) ? $coltemplate_month_1 = $_SESSION["setting"]["coltemplate_month_1"] : $coltemplate_month_1 = 'yy-mm-01';

	// NEW JQUERY DATEPICKER, DATETIMEPICKER, MONTHPICKER, YEARPICKER, TIMEPICKER	
	isset($_SESSION["setting"]["jqtime_1"]) ? $jqtime_1 = $_SESSION["setting"]["jqtime_1"] : $jqtime_1 = 'HH:mm';
	isset($_SESSION["setting"]["jqdate_1"]) ? $jqdate_1 = $_SESSION["setting"]["jqdate_1"] : $jqdate_1 = 'YYYY-MM-DD';
	isset($_SESSION["setting"]["jqdatetime_1"]) ? $jqdatetime_1 = $_SESSION["setting"]["jqdatetime_1"] : $jqdatetime_1 = 'YYYY-MM-DD HH:mm:ss';
	isset($_SESSION["setting"]["jqmonth_1"]) ? $jqmonth_1 = $_SESSION["setting"]["jqmonth_1"] : $jqmonth_1 = 'YYYY-MM-01';
	isset($_SESSION["setting"]["jqyear_1"]) ? $jqyear_1 = $_SESSION["setting"]["jqyear_1"] : $jqyear_1 = 'YYYY-01-01';
	isset($_SESSION["setting"]["coltemplate_jqtime_1"]) ? $coltemplate_jqtime_1 = $_SESSION["setting"]["coltemplate_jqtime_1"] : $coltemplate_jqtime_1 = 'HH:mm';
	isset($_SESSION["setting"]["coltemplate_jqdate_1"]) ? $coltemplate_jqdate_1 = $_SESSION["setting"]["coltemplate_jqdate_1"] : $coltemplate_jqdate_1 = 'YYYY-MM-DD';
	isset($_SESSION["setting"]["coltemplate_jqdatetime_1"]) ? $coltemplate_jqdatetime_1 = $_SESSION["setting"]["coltemplate_jqdatetime_1"] : $coltemplate_jqdatetime_1 = 'YYYY-MM-DD HH:mm:ss';
	isset($_SESSION["setting"]["coltemplate_jqmonth_1"]) ? $coltemplate_jqmonth_1 = $_SESSION["setting"]["coltemplate_jqmonth_1"] : $coltemplate_jqmonth_1 = 'YYYY-MM-01';
	isset($_SESSION["setting"]["coltemplate_jqyear_1"]) ? $coltemplate_jqyear_1 = $_SESSION["setting"]["coltemplate_jqyear_1"] : $coltemplate_jqyear_1 = 'YYYY-01-01';

	$picker_range =
		array(
			"min_date" 					=> DateTime::createFromFormat('Y-m-d', $_SESSION["setting"]["start_date"])->format($_SESSION["setting"]["date"]),
			"min_datetime"				=> DateTime::createFromFormat('Y-m-d', $_SESSION["setting"]["start_date"])->format($_SESSION["setting"]["datetime"]),
			"max_date" 					=> DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('+10 years')))->format($_SESSION["setting"]["date"]),
			"max_datetime"				=> DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('+10 years')))->format($_SESSION["setting"]["datetime"]),
			"min_coltemplate_date" 		=> DateTime::createFromFormat('Y-m-d', $_SESSION["setting"]["start_date"])->format($_SESSION["setting"]["coltemplate_date"]),
			"min_coltemplate_datetime" 	=> DateTime::createFromFormat('Y-m-d', $_SESSION["setting"]["start_date"])->format($_SESSION["setting"]["coltemplate_datetime"]),
			"max_coltemplate_date" 		=> DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('+10 years')))->format($_SESSION["setting"]["coltemplate_date"]),
			"max_coltemplate_datetime"	=> DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('+10 years')))->format($_SESSION["setting"]["coltemplate_datetime"]),
		);

	$declares = array("decimal_number|", "decimal_percent|", "decimal_money|", "separator_decimal|'", "separator_thousands|'");
	foreach ($declares as $declare) {
		$dec = explode("|", $declare);
		if (!empty($_SESSION["setting"][$dec[0]])) $val = $_SESSION["setting"][$dec[0]];
		else $val = 0;
		echo " var " . $dec[0] . " = " . $dec[1] . $val . $dec[1] . "; ";
	}
	$temp_width = "width:100";
	$temp_right = "align:'left'";
	$temp_sortable = "sortable:false";
	$temp_decimalSeparator = "decimalSeparator:separator_decimal";
	$temp_thousandsSeparator = "thousandsSeparator:separator_thousands";
	$temp_defaultValue = "defaultValue:''";
	$temp_editable = "editable:true";
	$temp_required = "required:true";
	$temp_number = "number:true";
	$temp_editrules = "editrules:{ " . $temp_required . " }";
	$coltemplate["general"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . " }";
	$coltemplate["integer"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:0, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["number"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:decimal_number, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["number1"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:1, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["number2"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:2, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["number3"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:3, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["number4"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:4, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["number5"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:5, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["number6"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:6, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["percent"] = "{ width:50, " . $temp_right . ", " . $temp_sortable . ", formatter:'number', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:decimal_percent }, " . $temp_editable . ", editrules:{ " . $temp_number . " } }";
	$coltemplate["currency"] = "{ " . $temp_width . ", " . $temp_right . ", " . $temp_sortable . ", formatter:'currency', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:decimal_money, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules: { " . $temp_number . " } }";
	$coltemplate["currency2"] = "{ " . $temp_width . ", " . $temp_right . ", " . $temp_sortable . ", formatter:'currency', formatoptions:{ " . $temp_decimalSeparator . ", " . $temp_thousandsSeparator . ", decimalPlaces:decimal_number, " . $temp_defaultValue . " }, " . $temp_editable . ", editrules: { " . $temp_number . " } }";
	$coltemplate["date_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).datepicker({
				dateFormat:'" . $coltemplate_date_1 . "',
				minDate: '" . $picker_range["min_coltemplate_date"] . "',
				// maxDate: '" . $picker_range["max_coltemplate_date"] . "',
				// maxDate: '+1M +30D',
				changeMonth: true,
				changeYear: true,
				onClose: function () { this.focus(); }
			});
		}
	},formatoptions:{ newformat: 'Y-m-d' } }";
	$coltemplate["datetime_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
        size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).jquerydatetimepicker({
			    dateFormat:'" . $coltemplate_datetime_date . "',
			    timeFormat: '" . $coltemplate_datetime_time . "',
			    timeInput: true,
			    minDate: '" . $picker_range["min_coltemplate_datetime"] . "',
				// maxDate: '" . $picker_range["max_coltemplate_datetime"] . "',
			    showMillisec: false,
			    changeMonth: true,
			    changeYear: true,
			    yearRange: '-99:+99',
			    onClose: function () { this.focus(); }

			});
        }
    }, formatoptions:{ newformat: 'Y-m-d' } }";
	$coltemplate["month_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
        size: 18, maxlengh: 10, dataInit: function(element) {
              $(element).datepicker({
                    dateFormat:'" . $coltemplate_month_1 . "',
                    minDate: '" . $picker_range["min_coltemplate_date"] . "',
                    // maxDate: '" . $picker_range["max_coltemplate_date"] . "',
                    // maxDate: '+1M +30D',
                    changeMonth: true,
                    changeYear: true,
                    onClose: function () { this.focus(); }
              });
        }
    }, formatoptions:{ newformat: 'Y-m-d' } }";
	// $coltemplate["time_1"]="{ ".$temp_width.", ".$temp_sortable.", ".$temp_editable.", editoptions:{
	// 	size: 18, maxlengh: 8, dataInit: function(element) {
	// 		$(element).clockpicker({ 
	// 			autoclose: true,
	// 			align: 'left',
	// 			placement:'top',
	// 		});
	// 	}
	// }, formatoptions:{ newformat: 'H:i:s' } }";
	$coltemplate["jqtime_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).timepickeralone({
				hours: true,
				minutes: true,
				" . (strstr($coltemplate_jqdatetime_1, "ss") ? "seconds:true," : "seconds:false,") . "
				ampm: false,
				inputFormat: '" . $coltemplate_jqtime_1 . "',
				twelveHoursFormat: false
			});
		},
		dataEvents: [{ 
			type: 'keydown', fn: function(e) { 
				var key = e.charCode || e.keyCode; 
				if (key == 9 || key == 13) // Tab / Enter
					$(this).timepickeralone('destroy');  
			} 
		}]
	},formatoptions:{ newformat: 'H:i:s' } }";
	$coltemplate["jqdate_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).periodpicker({
				likeXDSoftDateTimePicker: true,
			    norange: true, // use only one value
				// cells: [1, 1], // show only one month
				clearButton: true,
				clearButtonInButton: true,
				hideAfterSelect: true,
				hideOnBlur: true,
				minDate: '" . $picker_range["min_coltemplate_date"] . "',
				maxDate: '" . $picker_range["max_coltemplate_date"] . "',
				formatDecoreDateWithYear: '" . $coltemplate_jqdate_1 . "',
				formatDate: '" . $coltemplate_jqdate_1 . "',
		        timepicker: false, // use timepicker
			});
		},
		dataEvents: [{ 
			type: 'keydown', fn: function(e) { 
				var key = e.charCode || e.keyCode; 
				if (key == 9 || key == 13) // Tab / Enter
					$(this).periodpicker('hide');  
			} 
		}]
	},formatoptions:{ newformat: 'Y-m-d' } }";
	$coltemplate["jqdatetime_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).periodpicker({
				likeXDSoftDateTimePicker: true,
			    norange: true, // use only one value
				// cells: [1, 1], // show only one month
				clearButton: true,
				clearButtonInButton: true,
				hideAfterSelect: true,
				minDate: '" . $picker_range["min_coltemplate_datetime"] . "',
				maxDate: '" . $picker_range["max_coltemplate_datetime"] . "',
				formatDecoreDateWithYear: '" . $coltemplate_jqdatetime_1 . "',
				formatDate: '" . $coltemplate_jqdatetime_1 . "',
		        timepicker: true, // use timepicker
		        timepickerOptions: {
					hours: true,
					minutes: true,
					" . (strstr($coltemplate_jqdatetime_1, "ss") ? "seconds:true," : "seconds:false,") . "
					ampm: false,
					twelveHoursFormat: false
				}
			});
		},
		dataEvents: [{ 
			type: 'keydown', fn: function(e) { 
				var key = e.charCode || e.keyCode; 
				if (key == 9 || key == 13) // Tab / Enter
					$(this).periodpicker('hide');  
			} 
		}]
	},formatoptions:{ newformat: 'Y-m-d H:i:s' } }";
	$coltemplate["jqmonth_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			if(element.value != '')
				var startDate = moment(element.value, '" . $coltemplate_jqmonth_1 . "').format('YYYY-MM-DD');
			else 
				var startDate = moment().format('YYYY-MM-DD');
			
			$(element).daterangepicker({	
			      startDate:moment(),
				  endDate:moment(),
				  forceUpdate: true,
				  opened: true,
				  expanded: true, 
				  periods: ['month'],
				  single: true,
				  minDate: '" . $_SESSION["setting"]["start_date"] . "',
				  maxDate:'" . date('Y-m-d', strtotime('+10 years')) . "',
				  startDate: startDate,
				  callback: function(startDate, endDate, period){
				    var title = startDate.format('" . $coltemplate_jqmonth_1 . "');
		    		$(this).val(title);
				  }
			});
		},
		dataEvents: [{ 
			type: 'keydown', fn: function(e) { 
				var key = e.charCode || e.keyCode; 
				if (key == 9 || key == 13) // Tab / Enter
					$(this).daterangepicker('close');
			} 
		}]
	},formatoptions:{ newformat: 'Y-m-d' } }";
	$coltemplate["jqyear_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			if(element.value != '')
				var startDate = moment(element.value, '" . $coltemplate_jqyear_1 . "').format('YYYY-MM-DD');
			else 
				var startDate = moment().format('YYYY-MM-DD');

			$(element).daterangepicker({	
			      startDate:moment(),
				  endDate:moment(),
				  forceUpdate: true,
				  opened: true,
				  expanded: true, 
				  periods: ['year'],
				  single: true,
				  minDate: '" . $_SESSION["setting"]["start_date"] . "',
				  maxDate:'" . date('Y-m-d', strtotime('+10 years')) . "',
				  startDate: startDate,
				  callback: function(startDate, endDate, period){
				    var title = startDate.format('" . $coltemplate_jqyear_1 . "');
		    		$(this).val(title);
				  }
			});
		},
		dataEvents: [{ 
			type: 'keydown', fn: function(e) { 
				var key = e.charCode || e.keyCode; 
				if (key == 9 || key == 13) // Tab / Enter
					$(this).daterangepicker('close');
			} 
		}]
	},formatoptions:{ newformat: 'Y-m-d' } }";
	$coltemplate["jqcolor_1"] = "{ " . $temp_width . ", " . $temp_sortable . ", " . $temp_editable . ", editoptions:{
		size: 18, maxlengh: 10, dataInit: function(element) {
			$(element).spectrum({
				preferredFormat: 'hex',
		  		type: 'text',
		  		showPalette: false,
		  		showPaletteOnly: true,
		  		togglePaletteOnly: true,
		  		hideAfterPaletteSelect: true,
		  		allowEmpty:true,
		  		showInput: true,
		  		showInitial: true
			});
		}
	} }";
	$coltemplate["browsedefault"] = "{ searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']} }";
	foreach ($coltemplate as $key => $val)
		echo " var coltemplate_" . $key . " = " . $val . "; ";
	?>

	// FUNCTION IN ALL MENU
	$(function() {
		$('input').on('focus', function() {
			idInputOnchange = ($(this).attr("id"));
		});

		$('[data-toggle="tooltip"]').tooltip();

		$('.date_1').datepicker({
			dateFormat: '<?= $date_1 ?>',
			minDate: '<?= $picker_range["min_date"] ?>',
			// maxDate: '<?= $picker_range["max_date"] ?>',
			changeMonth: true,
			changeYear: true
		});
		$('.datetime_1').datetimepicker({
			// inline: true,
			// sideBySide: true,
			toolbarPlacement: 'top',
			showClose: true,
			showTodayButton: true,
			keepOpen: false,
			minDate: '<?= $picker_range["min_datetime"] ?>',
			// maxDate: '<?= $picker_range["max_datetime"] ?>',
			format: '<?= $datetime_1 ?>'
			// 24 HOURS TIME
			// format : "DD-MM-YYYY HH:mm:ss"
		});
		$('.month_1').datepicker({
			dateFormat: '<?= $month_1 ?>',
			minDate: '<?= $picker_range["min_date"] ?>',
			// maxDate: '+1M',
			changeMonth: true,
			changeYear: true
		});
		// $('.time_1').clockpicker({
		// 	autoclose: true,
		// 	align: 'left',
		// 	placement:'bottom',
		// });
		$('.jqtime_1').timepickeralone({
			hours: true,
			minutes: true,
			<?php if (strstr($jqdatetime_1, "ss")) { ?>
				seconds: true,
			<?php } else { ?>
				seconds: false,
			<?php } ?>
			ampm: false,
			twelveHoursFormat: false
		});
		$('.jqdate_1').periodpicker({
			norange: true, // use only one value
			// cells: [1, 1], // show only one month
			clearButton: true,
			clearButtonInButton: true,
			hideAfterSelect: true,
			minDate: '<?= $picker_range["min_date"] ?>',
			// maxDate: '<?= $picker_range["max_date"] ?>',
			formatDecoreDateWithYear: '<?= $jqdate_1 ?>',
			formatDate: '<?= $jqdate_1 ?>',
			timepicker: false, // use timepicker
		});
		$('.jqdatetime_1').periodpicker({
			norange: true, // use only one value
			// cells: [1, 1], // show only one month
			clearButton: true,
			clearButtonInButton: true,
			hideAfterSelect: true,
			minDate: '<?= $picker_range["min_datetime"] ?>',
			// maxDate: '<?= $picker_range["max_datetime"] ?>',
			formatDecoreDateWithYear: '<?= $jqdatetime_1 ?>',
			formatDate: '<?= $jqdatetime_1 ?>',
			timepicker: true, // use timepicker
			timepickerOptions: {
				hours: true,
				minutes: true,
				<?php if (strstr($jqdatetime_1, "ss")) { ?>
					seconds: true,
				<?php } else { ?>
					seconds: false,
				<?php } ?>
				ampm: false,
				twelveHoursFormat: false
			}
		});

		$('.iptinteger').number(true, 0, separator_decimal, separator_thousands);
		$('.iptnumber').number(true, decimal_number, separator_decimal, separator_thousands);
		$('.iptnumber1').number(true, 1, separator_decimal, separator_thousands);
		$('.iptnumber2').number(true, 2, separator_decimal, separator_thousands);
		$('.iptnumber3').number(true, 3, separator_decimal, separator_thousands);
		$('.iptnumber4').number(true, 4, separator_decimal, separator_thousands);
		$('.iptnumber5').number(true, 5, separator_decimal, separator_thousands);
		$('.iptnumber6').number(true, 6, separator_decimal, separator_thousands);
		$('.iptpercent').number(true, decimal_percent, separator_decimal, separator_thousands);
		$('.iptmoney').number(true, decimal_money, separator_decimal, separator_thousands);
		$('.iptmoney1').number(true, 1, separator_decimal, separator_thousands);
		$('.iptmoney3').number(true, 3, separator_decimal, separator_thousands);

		$('.iptmoney2').number(true, 2, separator_decimal, separator_thousands);

		jQuery.validator.addMethod("notEqualTo", function(v, e, p) {
			return this.optional(e) || v != p;
		}, "Please specify a different value");
		// LoadSelect2Script(DemoSelect2);
	});

	// function DemoSelect2() {
	// 	$('.select2').select2();
	// }

	function browse_open(id) {
		$(function() {
			$('#browse_' + id + '_area').attr('class', '');
			$.blockUI({
				message: $('#browse_' + id + '_area'),
				css: {
					top: '15%',
					left: '17%',
					width: '<?= $_SESSION["setting"]["browse_area_width"] ?>',
					cursor: 'default'
				}
			});
			$('#browse_' + id + '_close').click(function() {
				browse_closing(id);
			});
		});
	}

	function browse_closing(id) {
		$(function() {
			$.unblockUI({});
			$('#browse_' + id + '_area').attr('class', 'hiding');
		});
	}

	function browse_clear(id, element) {
		$(function() {
			$('.browse_' + id + '_clear').val('');
			$('.browse_' + id + '_clear').html('');
			$('#browse_' + id + '_keyword').val('');

			if (typeof $(element).getGridParam('lastpage') !== 'undefined') {
				var totalPage = $(element).getGridParam('lastpage').toString();
				var saveSelectedRows = '0';
				for (var i = 1; i <= parseInt(totalPage); i++) {
					$(element).data(i.toString(), saveSelectedRows);
				}
			}
		});
	}

	function browse_selected_open(id) {
		$(function() {
			var value_hidden = $('#browse_' + id + '_hidden').val();
			var selected_url = $('#browse_' + id + '_selected_url').val();
			if (value_hidden != '' && selected_url != '')
				window.open(selected_url + value_hidden, '_newtab');
		});
	}

	function take_number(number) {
		if (!number)
			number = 0;
		number = parseFloat(number);
		number = isNaN(number) ? 0 : number;
		return number;
	}

	function round_number(number, decimal) {
		return Math.round(number * Math.pow(10, decimal)) / Math.pow(10, decimal);
		// return Math.round(number*Math.pow(10,decimal))/Math.pow(10,decimal);
	}

	function calculate_summary(id, mode) {
		console.log('calculate_summary(' + id + ')');
		<?php
		$declares = array(
			"decimal_number|",
			"decimal_percent|",
			"decimal_money|",
			"separator_decimal|'",
			"separator_thousands|'"
		);
		foreach ($declares as $declare) {
			$dec = explode("|", $declare);
			if (!empty($_SESSION["setting"][$dec[0]]))
				$val = $_SESSION["setting"][$dec[0]];
			else $val = 0;
			echo " var " . $dec[0] . " = " . $dec[1] . $val . $dec[1] . "; ";
		}
		?>
		var total = 0;
		var total_diskon = 0;
		var total_um = 0;

		if ($('#sum_subtotal_' + id)) {
			var subtotal = $('#sum_subtotal_' + id).val();
			total = take_number(subtotal);
		}

		if ($('#sum_diskon1_' + id)) {
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
			var diskon1 = take_number($('#sum_diskon1_' + id).val());
			var diskon1nominal = take_number($('#sum_diskon1nominal_' + id).val());

			var isChangeDiskon1Prosentase = 0;
			if ($('#sum_diskon1tipe_' + id) && mode == "diskon1prosentase")
				isChangeDiskon1Prosentase = 1;
			if (isChangeDiskon1Prosentase == 1) {
				var diskon1nominal = diskon1 / 100 * total;
				diskon1nominal = round_number(diskon1nominal, decimal_money);
				$('#sum_diskon1nominal_' + id).val(diskon1nominal);
			} else {
				var diskon1 = (diskon1nominal * 100) / total;
				diskon1 = round_number(diskon1, decimal_percent);
				$('#sum_diskon1_' + id).val(diskon1);
			}

			total -= diskon1nominal;
			total_diskon += diskon1nominal;

			// diskon1 = round_number(diskon1,decimal_percent);
			// diskon1nominal = round_number(diskon1nominal,decimal_money);
			// $('#sum_diskon1_'+id).val(diskon1);
			// $('#sum_diskon1nominal_'+id).val(diskon1nominal);
		}

		if ($('#sum_diskon2_' + id)) {
			var diskon2 = take_number($('#sum_diskon2_' + id).val());
			var diskon2nominal = take_number($('#sum_diskon2nominal_' + id).val());

			var isChangeDiskon2Prosentase = 0;
			if ($('#sum_diskon2tipe_' + id) && mode == "diskon2prosentase")
				isChangeDiskon2Prosentase = 1;
			if (isChangeDiskon2Prosentase == 1) {
				var diskon2nominal = diskon2 / 100 * total;
				diskon2nominal = round_number(diskon2nominal, decimal_money);
				$('#sum_diskon2nominal_' + id).val(diskon2nominal);
			} else {
				var diskon2 = (diskon2nominal * 100) / total;
				diskon2 = round_number(diskon2, decimal_percent);
				$('#sum_diskon2_' + id).val(diskon2);
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

		if ($('#sum_diskon3_' + id)) {
			var diskon3 = take_number($('#sum_diskon3_' + id).val());
			var diskon3nominal = take_number($('#sum_diskon3nominal_' + id).val());

			var isChangeDiskon3Prosentase = 0;
			if ($('#sum_diskon3tipe_' + id) && mode == "diskon3prosentase")
				isChangeDiskon3Prosentase = 1;
			if (isChangeDiskon3Prosentase == 1) {
				var diskon3nominal = diskon3 / 100 * total;
				diskon3nominal = round_number(diskon3nominal, decimal_money);
				$('#sum_diskon3nominal_' + id).val(diskon3nominal);
			} else {
				var diskon3 = (diskon3nominal * 100) / total;
				diskon3 = round_number(diskon3, decimal_percent);
				$('#sum_diskon3_' + id).val(diskon3);
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

		if ($('#sum_diskontotal_' + id)) {
			total_diskon = round_number(total_diskon, decimal_money);
			$('#sum_diskontotal_' + id).val(total_diskon);
		}

		if ($('#sum_subtotalakhir_' + id)) {
			total = round_number(total, decimal_money);
			$('#sum_subtotalakhir_' + id).val(total);
		}

		if ($('#sum_um1_' + id)) {
			var um1 = $('#sum_um1_' + id).val();
			um1 = take_number(um1);
			total -= um1;
			// total_um += um1;
		}

		if ($('#sum_um2_' + id)) {
			var um2 = $('#sum_um2_' + id).val();
			um2 = take_number(um2);
			total -= um2;
			// total_um += um2;
		}

		if ($('#sum_um3_' + id)) {
			var um3 = $('#sum_um3_' + id).val();
			um3 = take_number(um3);
			total -= um3;
			// total_um += um3;
		}

		if ($('#sum_umtotal_' + id)) {
			total_um = round_number(total_um, decimal_money);
			$('#sum_umtotal_' + id).val(total_um);
		}

		if ($('#sum_dpp_' + id)) {
			$('#sum_dpp_' + id).val(total);
		}

		if ($('#sum_ppn_' + id)) {
			var isChangePPNNominal = 0;
			if ($('#sum_ppntipe_' + id) && $('#sum_ppntipe_' + id).val() == '1')
				isChangePPNNominal = 1;
			if (isChangePPNNominal == 0) {
				var dpp = $('#sum_dpp_' + id).val();
				var ppn = $('#sum_ppn_' + id).val();
				ppn = take_number(ppn);
				var ppnnominal = ppn * dpp / 100;
			} else {
				var dpp = $('#sum_dpp_' + id).val();
				var ppnnominal = $('#sum_ppnnominal_' + id).val();
				ppnnominal = take_number(ppnnominal);
				var ppn = (ppnnominal * 100) / dpp;
				ppnnominal = $('#sum_ppnnominal_' + id).val();
			}
			ppn = round_number(ppn, decimal_percent);
			ppnnominal = round_number(ppnnominal, decimal_money);
			total += ppnnominal;
			$('#sum_ppn_' + id).val(ppn);
			$('#sum_ppnnominal_' + id).val(ppnnominal);
		}

		if ($('#sum_pembulatan_' + id)) {
			var pembulatan = $('#sum_pembulatan_' + id).val();
			pembulatan = take_number(pembulatan);
			total += pembulatan;
		}

		if ($('#sum_total_' + id)) {
			total = round_number(total, decimal_money);
			$('#sum_total_' + id).val(total);
		}

		if ($('#sum_totalbayar_' + id)) {
			total = round_number(total, decimal_money);
			$('#sum_totalbayar_' + id).val(total);
		}
	}

	function calculate_summary_include_ppn(id, mode) {
		console.log('calculate_summary_include_ppn(' + id + ')');
		<?php
		$declares = array(
			"decimal_number|",
			"decimal_percent|",
			"decimal_money|",
			"separator_decimal|'",
			"separator_thousands|'"
		);
		foreach ($declares as $declare) {
			$dec = explode("|", $declare);
			if (!empty($_SESSION["setting"][$dec[0]]))
				$val = $_SESSION["setting"][$dec[0]];
			else $val = 0;
			echo " var " . $dec[0] . " = " . $dec[1] . $val . $dec[1] . "; ";
		}
		?>
		var total = 0;
		var total_diskon = 0;
		var total_um = 0;

		if ($('#sum_subtotal_' + id)) {
			var subtotal = $('#sum_subtotal_' + id).val();
			total = take_number(subtotal);
		}

		if ($('#sum_diskon1_' + id)) {
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
			var diskon1 = take_number($('#sum_diskon1_' + id).val());
			var diskon1nominal = take_number($('#sum_diskon1nominal_' + id).val());

			var isChangeDiskon1Prosentase = 0;
			if ($('#sum_diskon1tipe_' + id) && mode == "diskon1prosentase")
				isChangeDiskon1Prosentase = 1;
			if (isChangeDiskon1Prosentase == 1) {
				var diskon1nominal = diskon1 / 100 * total;
				diskon1nominal = round_number(diskon1nominal, decimal_money);
				$('#sum_diskon1nominal_' + id).val(diskon1nominal);
			} else {
				var diskon1 = (diskon1nominal * 100) / total;
				diskon1 = round_number(diskon1, decimal_percent);
				$('#sum_diskon1_' + id).val(diskon1);
			}

			total -= diskon1nominal;
			total_diskon += diskon1nominal;

			// diskon1 = round_number(diskon1,decimal_percent);
			// diskon1nominal = round_number(diskon1nominal,decimal_money);
			// $('#sum_diskon1_'+id).val(diskon1);
			// $('#sum_diskon1nominal_'+id).val(diskon1nominal);
		}

		if ($('#sum_diskon2_' + id)) {
			var diskon2 = take_number($('#sum_diskon2_' + id).val());
			var diskon2nominal = take_number($('#sum_diskon2nominal_' + id).val());

			var isChangeDiskon2Prosentase = 0;
			if ($('#sum_diskon2tipe_' + id) && mode == "diskon2prosentase")
				isChangeDiskon2Prosentase = 1;
			if (isChangeDiskon2Prosentase == 1) {
				var diskon2nominal = diskon2 / 100 * total;
				diskon2nominal = round_number(diskon2nominal, decimal_money);
				$('#sum_diskon2nominal_' + id).val(diskon2nominal);
			} else {
				var diskon2 = (diskon2nominal * 100) / total;
				diskon2 = round_number(diskon2, decimal_percent);
				$('#sum_diskon2_' + id).val(diskon2);
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

		if ($('#sum_diskon3_' + id)) {
			var diskon3 = take_number($('#sum_diskon3_' + id).val());
			var diskon3nominal = take_number($('#sum_diskon3nominal_' + id).val());

			var isChangeDiskon3Prosentase = 0;
			if ($('#sum_diskon3tipe_' + id) && mode == "diskon3prosentase")
				isChangeDiskon3Prosentase = 1;
			if (isChangeDiskon3Prosentase == 1) {
				var diskon3nominal = diskon3 / 100 * total;
				diskon3nominal = round_number(diskon3nominal, decimal_money);
				$('#sum_diskon3nominal_' + id).val(diskon3nominal);
			} else {
				var diskon3 = (diskon3nominal * 100) / total;
				diskon3 = round_number(diskon3, decimal_percent);
				$('#sum_diskon3_' + id).val(diskon3);
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

		if ($('#sum_diskontotal_' + id)) {
			total_diskon = round_number(total_diskon, decimal_money);
			$('#sum_diskontotal_' + id).val(total_diskon);
		}

		if ($('#sum_subtotalakhir_' + id)) {
			total = round_number(total, decimal_money);
			$('#sum_subtotalakhir_' + id).val(total);
		}

		if ($('#sum_pembulatan_' + id)) {
			var pembulatan = $('#sum_pembulatan_' + id).val();
			pembulatan = take_number(pembulatan);
			total += pembulatan;
		}

		if ($('#sum_total_' + id)) {
			total = round_number(total, decimal_money);
			$('#sum_total_' + id).val(total);
		}

		if ($('#sum_um1_' + id)) {
			var um1 = $('#sum_um1_' + id).val();
			um1 = take_number(um1);
			total -= um1;
			// total_um += um1;
		}

		if ($('#sum_um2_' + id)) {
			var um2 = $('#sum_um2_' + id).val();
			um2 = take_number(um2);
			total -= um2;
			// total_um += um2;
		}

		if ($('#sum_um3_' + id)) {
			var um3 = $('#sum_um3_' + id).val();
			um3 = take_number(um3);
			total -= um3;
			// total_um += um3;
		}

		if ($('#sum_umtotal_' + id)) {
			total_um = round_number(total_um, decimal_money);
			$('#sum_umtotal_' + id).val(total_um);
		}

		if ($('#sum_totalbayar_' + id)) {
			total = round_number(total, decimal_money);
			$('#sum_totalbayar_' + id).val(total);
		}

		if ($('#sum_dpp_' + id)) {
			var ppn = $('#sum_ppn_' + id).val();
			ppn = take_number(ppn);
			// if(ppn > 0) 
			// {
			var dpp = total / (1 + ppn / 100),
				decimal_money;
			dpp = round_number(dpp, decimal_money);
			// }
			// else 
			// var dpp = 0;
			$('#sum_dpp_' + id).val(dpp);
		}

		if ($('#sum_ppn_' + id)) {
			var isChangePPNNominal = 0;
			if ($('#sum_ppntipe_' + id) && $('#sum_ppntipe_' + id).val() == '1')
				isChangePPNNominal = 1;
			if (isChangePPNNominal == 0) {
				var dpp = $('#sum_dpp_' + id).val();
				var ppn = $('#sum_ppn_' + id).val();
				ppn = take_number(ppn);
				var ppnnominal = ppn * dpp / 100;
			} else {
				var dpp = $('#sum_dpp_' + id).val();
				var ppnnominal = $('#sum_ppnnominal_' + id).val();
				ppnnominal = take_number(ppnnominal);
				var ppn = (ppnnominal * 100) / dpp;
				ppnnominal = $('#sum_ppnnominal_' + id).val();
			}
			ppn = round_number(ppn, decimal_percent);
			ppnnominal = round_number(ppnnominal, decimal_money);
			$('#sum_ppn_' + id).val(ppn);
			$('#sum_ppnnominal_' + id).val(ppnnominal);
		}
	}

	function check_value_elements(fields) {
		var failed = '',
			length_fields = fields.length;
		for (var i = 0; i < length_fields; i++) {
			var field = fields[i].split('|');
			var val_field = $('#' + field[0]).val();
			if (val_field == '') {
				if (failed != '')
					failed += ", ";
				failed += field[1];
			}
		}
		return failed;
	}

	function get_icon_type(icon_color) {
		if (icon_color == 'btn-warning')
			type = "orange";
		if (icon_color == 'btn-danger')
			type = "red";
		if (icon_color == 'btn-success')
			type = "green";
		if (icon_color == 'btn-warning')
			type = "orange";
		if (icon_color == 'btn-dark')
			type = "dark";
		if (icon_color == 'btn-default')
			type = "default";
		if (icon_color == 'btn-primary' || icon_color == 'btn-info')
			type = "blue";
		return type;
	}

	function link_confirmation(message = '', href = '', newtab = '', mode = '', navicon = '') {
		if (!navicon.split("|")[0])
			var icon = 'fa fa-warning';
		else
			var icon = navicon.split("|")[0];

		if (!navicon.split("|")[1])
			var type = 'default';
		else
			var type = get_icon_type(navicon.split("|")[1]);

		if (mode.toLowerCase() == 'delete') {
			icon = 'fa fa-trash';
			type = 'red';
			<?php if (!empty($_SESSION["setting"]["navbutton_delete"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_delete"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_delete"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'approve') {
			icon = 'fa fa-check-square-o';
			type = 'green';
			<?php if (!empty($_SESSION["setting"]["navbutton_approve"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_approve"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_approve"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'disapprove') {
			icon = 'fa fa-times';
			type = 'red';
			<?php if (!empty($_SESSION["setting"]["navbutton_disapprove"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_disapprove"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_disapprove"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'reject') {
			icon = 'fa fa-ban';
			type = 'red';
			<?php if (!empty($_SESSION["setting"]["navbutton_reject"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_reject"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_reject"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'print') {
			icon = 'fa fa-print';
			type = 'blue';
			<?php if (!empty($_SESSION["setting"]["navbutton_print"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_print"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_print"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'finish') {
			icon = 'fa fa-flag-checkered';
			type = 'default';
			<?php if (!empty($_SESSION["setting"]["navbutton_close"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_close"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_close"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
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
				Ya: function() {
					if (newtab == '_newtab')
						window.open(href, newtab);
					else
						document.location.href = href;
				},
				Tidak: function() {},
			}
		});
	}

	function import_confirmation(message = '', href = '', newtab = '', mode = '', navicon = '') {
		if (!navicon.split("|")[0])
			var icon = 'fa fa-warning';
		else
			var icon = navicon.split("|")[0];

		if (!navicon.split("|")[1])
			var type = 'default';
		else
			var type = get_icon_type(navicon.split("|")[1]);

		if (mode.toLowerCase() == 'delete') {
			icon = 'fa fa-trash';
			type = 'red';
			<?php if (!empty($_SESSION["setting"]["navbutton_delete"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_delete"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_delete"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'approve') {
			icon = 'fa fa-check-square-o';
			type = 'green';
			<?php if (!empty($_SESSION["setting"]["navbutton_approve"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_approve"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_approve"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'disapprove') {
			icon = 'fa fa-times';
			type = 'red';
			<?php if (!empty($_SESSION["setting"]["navbutton_disapprove"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_disapprove"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_disapprove"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'reject') {
			icon = 'fa fa-ban';
			type = 'red';
			<?php if (!empty($_SESSION["setting"]["navbutton_reject"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_reject"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_reject"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'print') {
			icon = 'fa fa-print';
			type = 'blue';
			<?php if (!empty($_SESSION["setting"]["navbutton_print"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_print"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_print"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		if (mode.toLowerCase() == 'finish') {
			icon = 'fa fa-flag-checkered';
			type = 'default';
			<?php if (!empty($_SESSION["setting"]["navbutton_close"])) { ?>
				icon_class = '<?= explode("|", $_SESSION["setting"]["navbutton_close"])[0] ?>';
				icon_color = '<?= explode("|", $_SESSION["setting"]["navbutton_close"])[1] ?>';
				if (icon_class)
					icon = icon_class;
				if (icon_color)
					type = get_icon_type(icon_color);
			<?php } ?>
		}
		$.confirm({
			title: 'Import Excel!',
			content: '' +
				'<form id="myForm" action="' + href + '" class="formName" method="post" enctype="multipart/form-data">' +
				'<div class="form-group">' +
				'<input type="text" style="display: none;" name="nomormhusaha" value="' + <?php echo $_SESSION['usaha']['nomor'] == '%' ? 1 : $_SESSION['usaha']['nomor']; ?> + '">' +
				'<input type="text" style="display: none;" name="nomormhcabang" value="' + <?php echo $_SESSION['cabang']['nomor']; ?> + '">' +
				'<input type="text" style="display: none;" name="nomormhadmin" value="' + <?php echo $_SESSION['login']['nomor']; ?> + '">' +
				'<label>Import File Excel</label>' +
				'<input type="file" id="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required> ' +
				'</div>' +
				'</form>',
			buttons: {
				formSubmit: {
					text: 'Submit',
					btnClass: 'btn-blue',
					action: function() {
						// TODO add php script to import data from excel
						let form = document.getElementById("myForm");
						let formData = new FormData(form);

						$.ajax({
							url: href,
							type: 'POST',
							data: formData,
							success: function(data) {
								console.log(data);

								alert("Data Succesfully Inserted");

								//location.reload();
							},
							error: function(data) {
								console.log(data.responseJSON);

								let errorStr = '';
								data.responseJSON.error.forEach(function(value) {
									value.errors.forEach(function(err) {
										errorStr += `${err} on row ${value.row}\n`;
									})
								});

								$.alert({
									title: 'Error!',
									content: errorStr,
								});

							},
							complete: function() {
								// location.reload();
							},
							cache: false,
							contentType: false,
							processData: false
						});
					}
				},
				cancel: function() {
					//close
				},
			},
			onContentReady: function() {
				// bind to events
				var jc = this;
				this.$content.find('form').on('submit', function(e) {
					// if the user submits the form by pressing enter in the field.
					e.preventDefault();
					jc.$$formSubmit.trigger('click'); // reference the button and click it
				});
			}
		});
	}

	function file_delete(x) {
		var pages = 'dashboard.php?m=master_archieve&f=header_grid&sm=custom&c=delete&no=' + x;

		$.ajax({
			url: pages,
			type: 'GET',
			async: true,
			success: function(data) {
				var search_success = data.indexOf("data_success_didelete_custom");
				// console.log(search_success);
				if (search_success >= 0) {
					$("#uploaded_file_" + x).hide();
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				// refreshResultListError( "error", thrownError );
			}
		});
	}
	//==============================================NOTIFICATION==================================================//
	var intervalNotif = null;
	notification_load();
	notification_interval(true);

	$(".open_notif").click(function() {
		if (!$(".open_notif").hasClass("open"))
			notification_load();
	});
	$(document).on('click', '.notifications > .click_notifications', function(event) {
		if (!$(event.target).is('.delete')) {
			notification_click($(this).attr('nomor'));
			window.location.href = $(this).attr('link');
		}
	});
	$(document).on('click', '.notifications > li > a > strong > .delete', function(e) {
		notification_interval(false);
		setTimeout(function() {
			$(".open_notif").addClass("open");
		}, 100);
		$(this).parents(".read_notif").remove();
		if (!$(".notifications").children("li").hasClass("read_notif")) {
			$(".notifications").css('overflow', 'hidden');
			$(".notifications").html("<li><a href='#'><span>No Message</span></a></li>");
		}
		notification_delete($(this).attr('nomor'));
	});
	$('body').on('click', function() {
		if ($(".open_notif").hasClass("open")) {
			notification_update();
			notification_load();
		}
	});

	function notification_interval(flag) {
		clearInterval(intervalNotif);
		if (flag == true) {
			intervalNotif = setInterval(function() {
				notification_load();
			}, 60000);
		}
	}

	function notification_load() {
		$.ajax({
			async: true,
			type: "POST",
			url: "pages/notifications.php",
			data: {
				id: 'get_notif'
			},
			success: function(data) {
				var result = JSON.parse(data);
				var datas = "";
				console.log("Load Notification Success!!");
				console.log(result);
				$.each(result.child, function(i, item) {
					var read = "";
					var new_label = "";
					if (result.child[i].read_status == 1) {
						read = "read_notif";
					}
					if (result.child[i].new_status == 0) {
						new_label = "<span class='label label-info new'>NEW</span>";
					}

					datas = datas.concat("<li class='" + read + " click_notifications' nomor='" + result.child[i].nomor + "' link='" + result.child[i].link + "'><a><strong style='display:block;'><span><i class='notif-icon fa fa-bell'></i>" + result.child[i].users + "<span class='notification_time'>" + result.child[i].date_time + "</span></span><i class='delete fa fa-trash' nomor='" + result.child[i].nomor + "'></i>" + new_label + "</strong>" + result.child[i].message + "</a></li>");

				});

				if (datas == '') {
					$(".notifications").css('overflow', 'hidden');
					$(".notifications").html("<li><a href='#'><span>No Message</span></a></li>");
				} else {
					$(".notifications").removeAttr("style");
					$(".notifications").css('overflow', 'auto');
					$("ul.notifications").html(datas);
				}
				$(".count-notif").html(result.parent.count);
				if (result.parent.count < 1) {
					$(".count-notif").hide();
				} else {
					$(".count-notif").show();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
			}
		});
	}

	function notification_update() {
		$.ajax({
			async: true,
			type: "POST",
			url: "pages/notifications.php",
			data: {
				id: 'update_notif'
			},
			success: function(data) {},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
			}
		});
	}

	function notification_click(nomor) {
		$.ajax({
			async: true,
			type: "POST",
			url: "pages/notifications.php",
			data: {
				id: 'update_click_notif',
				nomor: nomor
			},
			success: function(data) {},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
			}
		});
	}

	function notification_delete(nomor) {
		$.ajax({
			async: true,
			type: "POST",
			url: "pages/notifications.php",
			data: {
				id: 'update_click_notif',
				nomor: nomor
			},
			success: function(data) {
				// notification_load()
				notification_interval(true);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log("error notifications");
			}
		});
	}
	//==============================================NOTIFICATION==================================================//

	//===========================================LOADER & DATATABLE===============================================//
	function showLoader() {
		$(".lds-ellipsis").removeClass('hide');
	}

	function hideLoader() {
		$(".lds-ellipsis").addClass('hide');
		if (!$('.dataTables_wrapper').hasClass('animated fadeIn')) {
			$('.dataTables_wrapper').addClass('animated fadeIn');
		}
	}

	function loadDataTable() {
		showLoader();
		$('.dataTables_wrapper').addClass('hide');
		// RESIZE AFTER COLLAPSE SIDE BAR
		setTimeout(function() {
			hideLoader();
			$('.dataTables_wrapper').removeClass('hide');
			reDrawDataTable();
			$(".dataTables_filter").append("<span class='bt-search'><i class='fa fa-search' aria-hidden='true'></i></span>");
		}, 300);
	}
	//===========================================LOADER & DATATABLE===============================================//

	//==============================================PRINT REPORT==================================================//
	function price_to_number(v) {
		if (!v) {
			return 0;
		}
		v = v.split('.').join('');
		v = v.split(',').join('.');
		v = v.replace('(', '-');
		return Number(v.replace(/[^0-9.|-]/g, ""));
	}

	function number_to_price(v) {
		if (v == 0) {
			return '0,00';
		}
		v = parseFloat(v);
		v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		if (v.indexOf('-') > -1) {
			v = v.replace('-', '(') + ')';
		}
		v = v.split('.').join('*').split(',').join('.').split('*').join(',');
		return v;
	}

	function defaultPrint() {
		Print();
		/* DOCUMENTATION PARAM 
		0: title -> Custom Title
		1: header / HTML Yang Akan Ditampilkan Pada Bagian Caption/ Header dari Print
		2: periode -> Custom periode
		3: company_mode -> 1 Utk Tampil Data Company, 0 Utk Tidak Tampil
		4: company_logo
		5: company_name
		6: company_address
		7: company_contact
		*/
	}

	function Print(title = '', header = '', periode = '', groupReportPrint = '', company_mode = '', company_logo = '', company_name = '', company_address = '', company_contact = '') {
		var aa = company_mode;
		var company_logo = company_logo;
		var company_name = company_name;
		var company_address = company_address;
		var company_contact = company_contact;
		var title = title;
		var periode = periode;
		var header = header;
		var table_header = "",
			table_body = "",
			table_footer = "";

		if ($('.dataTables_scrollHead .table-datatable').children("thead").length > 0) {
			table_header = $('.dataTables_scrollHead .table-datatable').children("thead").html().toString();
		}
		if ($('.dataTables_scrollBody .table-datatable').children("tbody").length > 0) {
			table_body = $('.dataTables_scrollBody .table-datatable').children("tbody").html().toString();
		}
		if ($(' .dataTables_scrollFoot .table-datatable').children("tfoot").length > 0) {
			table_footer = $('.dataTables_scrollFoot .table-datatable').children("tfoot").html().toString();
		}
		var total_column = 99;
		var link = '<?= $_SESSION["g.menu"] ?>';

		if (periode == '') {
			var start_date_id = "#" + '<?= $_SESSION["setting"]["filter_start_date"] ?>';
			var end_date_id = "#" + '<?= $_SESSION["setting"]["filter_end_date"] ?>';
			if (typeof $(start_date_id).val() !== 'undefined') {
				periode += $(start_date_id).val();
			}
			if (typeof $(end_date_id).val() !== 'undefined') {
				periode += " <b>s/d</b> " + $(end_date_id).val();
			}
		}
		var obj = $.alert({
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

		var framework = '<?= $config["webspira"] ?>';
		$.ajax({
			async: true,
			type: "POST",
			url: framework + "codes/print.php",
			data: {
				company_name: company_name,
				company_address: company_address,
				company_contact: company_contact,
				title: title,
				periode: periode,
				header: header,
				table_header: table_header,
				table_body: table_body,
				table_footer: table_footer,
				total_column: total_column,
			},
			success: function(data) {
				obj.close();
				window.open('pages/export_print.php?m=' + link + '&f=report&&sm=edit&a=view&no=', '_newtab');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				obj.close();
				$.alert({
					title: 'NOTIFICATION',
					content: errorThrown,
					icon: 'fa fa-warning',
					type: 'red',
					theme: 'modern',
					onClose: function() {
						// before the modal is hidden. 
					}
				});
			}
		});
	}
	//==============================================PRINT REPORT==================================================//

	//===============================================START PAGE===================================================//
	function start() {
		var framework = '<?= $config["webspira"] ?>';
		$.ajax({
			async: true,
			type: "POST",
			url: framework + "codes/start.php"
		});
	}
	//===============================================START PAGE===================================================//

	//==================================COLLAPSE SIDEBAR & RELOAD DATATABLE======================================//
	function hidebar() {
		if ($("#main").hasClass("sidebar-show")) {
			$(".sidebar-show .nav.main-menu > li > a").removeClass("scaleUp15");
			$(".sidebar-show .nav.main-menu > li > a").removeClass("scaleUp13");
			$(".dropdown-menu").css("display", "none");
			setTimeout(function() {
				$("#sidebar-left").addClass("hidesidebar");
			}, 4000);

		} else {
			$("#sidebar-left").addClass("hidesidebar");
			setTimeout(function() {
				$("#sidebar-left").removeClass("hidesidebar");
			}, 300);
			setTimeout(function() {
				$("#sidebar-left").addClass("hidesidebar");
			}, 4000);
		}
	}
	$(document).ready(function() {
		start();
		hidebar();
		$('input').blur();
		$(".show-sidebar").click(function() {
			hidebar();
			if ($.fn.DataTable.isDataTable('.table-datatable')) {
				loadDataTable();
			}
		})
		$('[data-toggle="tooltip"]').tooltip();

		var scaleUp15 = '';
		var scaleUp13 = '';

		<?php if ($_SESSION["menu_position"] == 'left') { ?>
			scaleUp15 = 'scaleUp15-left';
			scaleUp13 = 'scaleUp13-left';
		<?php } else { ?>
			scaleUp15 = 'scaleUp15-bottom';
			scaleUp13 = 'scaleUp13-bottom';
		<?php } ?>
		$(".main-menu > li > a").mouseenter(function() {
			if ($("#main").hasClass("sidebar-show")) {
				$(".sidebar-show .nav.main-menu > li > a").removeClass(scaleUp15);
				$(".sidebar-show .nav.main-menu > li > a").removeClass(scaleUp13);

				$(this).addClass(scaleUp15);
				$(this).removeClass("fadeInRight");
				$(this).parents("li").prev().children("a").addClass(scaleUp13);
				$(this).parents("li").next().children("a").addClass(scaleUp13);
			}
		});
		$(".main-menu").mouseleave(function() {
			$(".sidebar-show .nav.main-menu > li > a").removeClass(scaleUp15);
			$(".sidebar-show .nav.main-menu > li > a").removeClass(scaleUp13);
		});
		$(".bt-preference").click(function() {
			if ($(".setting").hasClass("hidepref")) {
				$(".setting").removeClass("hidepref");
			} else {
				$(".setting").addClass("hidepref");
			}
		});

		<?php if(isset($index["filter_column"])){ if($index["filter_column"] == 1){ ?>
		var $input = $("#selected_columns");

		var index_table = <?php echo json_encode($index_table["column"]); ?>;

		var str_option = "";
		for (let i = 1; i < index_table.length; i++) {
			if(index_table[i]['name'] == "action"){
				continue;
			}
			if(index_table[i]["visible"] == "true"){
				str_option += "<option selected value='"+index_table[i]['name']+"'>"+index_table[i]['caption']+"</option>";
			}else{
				str_option += "<option value='"+index_table[i]['name']+"'>"+index_table[i]['caption']+"</option>";
			}
		}
		$input.html(str_option);

		$input.select2({
			tags: true
		});
		$("#selected_columns").on("select2:select", function (evt) {
			var element = evt.params.data.element;
			var $element = $(element);
			
			$element.detach();
			$(this).append($element);
			$(this).trigger("change");
		});

		$(".filter_column").click(function(){
			$('#modal_filter_column').modal('show');
		});

		$.ajax({
			dataType: "json",
			url: "pages/ajax.php",
			data: {
				tipe: 'user_filter_column', 
				menu: '<?= $_SESSION["g.menu_kode"] ?>'
			},
			type: "post",
			success: function(json){
				var strHtml = "";
				for(var i = 0; i < json.length; i++) {
					var obj = json[i];
					strHtml = strHtml + "<option value='" + obj.nomormhadmin + "'>" + obj.nama_admin + "</option>";
				}
				$("#user_filter_column").html(strHtml);
			},
			error: function(data) {
				console.log('Data Error'); 
			}
		});
		<?php } } ?>
	});

	function reload_selected_column(){
		var obj=$.alert({
			icon: 'fa fa-spinner fa-spin',
			title: 'Please Wait..',
			animation: 'scale',
			content: '<font style="font-size:14px">Getting Data..</font>',
			buttons: {
				ok: {
					isHidden: true,
				}
			}
	    });

		$.ajax({
			dataType: "json",
			url: "pages/ajax.php",
			data: {
				tipe: 'menu_filter_column', 
				nomormhadmin: $('#user_filter_column').val(),
				menu: $('#menu_filter_column').val()
			},
			type: "post",
			success: function(json){
				obj.close();
				$('#modal_filter_column').modal('hide');

				var result = json[0];

				var $input = $("#selected_columns");

				var index_table = <?php echo json_encode($index_table["column"]); ?>;

				var str_option = "";
				for (let i = 1; i < index_table.length; i++) {
					if(index_table[i]['name'] == "action"){
						continue;
					}
					if($.inArray(index_table[i]["name"], result.columns) != -1){
						str_option += "<option selected value='"+index_table[i]['name']+"'>"+index_table[i]['caption']+"</option>";
					}else{
						str_option += "<option value='"+index_table[i]['name']+"'>"+index_table[i]['caption']+"</option>";
					}
				}
				$input.html(str_option);

				$input.select2({
					tags: true
				});
				$("#selected_columns").on("select2:select", function (evt) {
					var element = evt.params.data.element;
					var $element = $(element);
					
					$element.detach();
					$(this).append($element);
					$(this).trigger("change");
				});
			},
			error: function(data) {
				console.log('Data Error'); 
			}
		});
	}

	var counter = 0;
	var leave;
	$("#sidebar-left").before().on("mouseover", function() {
		clearInterval(leave);
		$("#sidebar-left").removeClass("hidesidebar");
		counter = 0;
	})
	$("#sidebar-left").on("mouseleave", function() {
		if ($("#main").hasClass("sidebar-show")) {
			leave = setInterval(function() {
				// console.log(counter);
				if (counter == 3) {
					$("#sidebar-left").addClass("hidesidebar");
					$(".dropdown-menu").css("display", "none");
					$("#sidebar-left").removeClass("hidetips");
					$("ul.dropdown-menu").removeClass("open");
					clearInterval(leave);
				}
				++counter;
			}, 1000);
		}
	})
	//==================================COLLAPSE SIDEBAR & RELOAD DATATABLE======================================//

	//=======================================OVERRIDE RELOAD WITH AJAX===========================================//
	// RELOAD WITH AJAX
	$(document).on('click', '.reload', function(event) {
		event.preventDefault();
		$(".table-datatable").DataTable().state.clear();
		var reload_link = $(this).attr("link");
		var obj = $.dialog({
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
			onOpen: function() {
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
	//=======================================OVERRIDE RELOAD WITH AJAX===========================================//
</script>
<?php /*END created_by:glennferio@inspiraworld.com;release_date:2020-05-20;*/ ?>