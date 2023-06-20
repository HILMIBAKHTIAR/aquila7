		<?php
 if(!isset($page_dir))$page_dir="";if(strstr($config["webspira"],"webspira")){$_SESSION["login"]["framework"]="webspira";if(!isset($config["style"]))$config["style"]="style_v1.css";}else {$_SESSION["login"]["framework"]="pelangi";if(!isset($config["style"]))$config["style"]="creative_style_1.css";}?>
		<title><?php echo $_SESSION["setting"]["company_name"]?> - Dashboard</title>
		<!--
		config webspira: <?php echo $config["webspira"]?>
		mysql state: <?php echo $mysql["state"]?>
		mysql server: <?php echo $mysql["server"]?>
		mysql username: <?php echo $mysql["username"]?>
		mysql database: <?php echo $mysql["database"]?>
		-->
		<meta charset="utf-8" />
		<meta name="description" content="website developer" />
		<meta name="author" content="Krabsite" />
		<meta name="keyword" content="website developer" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<link href="<?php echo $page_dir?>contents/image/favicon.ico" rel="shortcut icon" id="dynamic-favicon" />
	<!--<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/img/favicon.ico" rel="shortcut icon" />-->
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
	<!--<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />-->
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-jqgrid/ui.jqgrid.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css" rel="stylesheet" />
		<!-- Animation -->
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/animate.css" rel="stylesheet">
		<!-- Animation -->
	<!--<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/font-awesome.min.css" rel="stylesheet" />-->
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/font-righteous.css" rel="stylesheet" />
	<!--<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/xcharts/xcharts.min.css" rel="stylesheet" />-->
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/select2/select2.css" rel="stylesheet" />
	<!--<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/justified-gallery/justifiedGallery.css" rel="stylesheet" />-->
<?php if($_SESSION["login"]["framework"]=="pelangi"){?>
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/style.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/icon_style.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/datatables.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/fixedHeader.dataTables.css" rel="stylesheet" />
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/inspinia_style.css" rel="stylesheet" />
<?php }else {?>
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/<?php echo $config["style"]?>" rel="stylesheet" />
<?php }?>
		<link href="<?php echo $page_dir?>assets_custom/css/style_custom.css?<?php echo date("H:i:s");?>" rel="stylesheet" />
	<!--<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/chartist/chartist.min.css" rel="stylesheet" />-->
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery.min.js"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/knockout.js"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui/jquery-ui.js"></script>
<!------start all compiled plugins--------------------------------------------------------------------------------------------------------------------------------------------------->
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/bootstrap/bootstrap.min.js"></script>
	<!--<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/justified-gallery/jquery.justifiedGallery.min.js"></script>-->
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/tinymce/tinymce.min.js"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/tinymce/jquery.tinymce.min.js"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<!------finish all compiled plugins-------------------------------------------------------------------------------------------------------------------------------------------------->
<!------start individual files as needed--------------------------------------------------------------------------------------------------------------------------------------------->
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jconfirmation.jquery.js" type="text/javascript"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery.validate.js" type="text/javascript"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/additional-methods.js" type="text/javascript"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery.blockUI.js" type="text/javascript"></script>
	<!--<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery-ui-1.8.12.js" type="text/javascript"></script>-->
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-jqgrid/jquery.jqGrid.src.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-jqgrid/jQuery.jqGrid.setColWidth.js"></script>
    	<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-jqgrid/jQuery.jqGrid.autoWidthColumns.js"></script>

		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/locale-en.js" type="text/javascript"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery.number.js" type="text/javascript"></script>
		<!-- /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/ -->
		<script src="<?php echo $config['webspira']?>assets_dashboard/plugins/moment/moment.min.js?<?php echo date("H:i:s");?>"></script>
		<!-- BOOTSTRAP DATE TIME PICKER -->
		<link rel="stylesheet"
	          type="text/css"
	          href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/bootstrap-datetimepicker.min.css"/>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/bootstrap-datetimepicker.min.js"></script>
		<!-- BOOTSTRAP DATE TIME PICKER -->
		<!-- JQUERY CONFIRM -->
	    <script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/popper.js"></script>
	    <link rel="stylesheet"
	          type="text/css"
	          href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/jquery-confirm.css"/>
	   	<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery-confirm.js"></script>
	   	<!-- JQUERY CONFIRM -->
	   	<!-- JQUERY CLOCK PICKER -->
		<!-- <link rel="stylesheet" type="text/css" href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/jquery-clockpicker.css">
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery-clockpicker.js"></script> -->
		<!-- JQUERY CLOCK PICKER -->
		<!-- JQUERY PERIOD PICKER -->
		<link rel="stylesheet" type="text/css" href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-periodpicker/jquery.periodpicker.css">
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-periodpicker/jquery.periodpicker.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-periodpicker/jquery.timepicker.css">
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-periodpicker/jquery.timepicker.js"></script>
		<!-- JQUERY PERIOD PICKER -->
		<!-- JQUERY RANGE PICKER -->
		<link rel="stylesheet" type="text/css" href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-rangepicker/daterangepicker.css">
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-rangepicker/daterangepicker.js"></script>
		<!-- JQUERY RANGE PICKER -->
		<!-- JQUERY COLOR PICKER -->
		<link rel="stylesheet" type="text/css" href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-colorpicker/spectrum.css">
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/plugins/jquery-ui-colorpicker/spectrum.js"></script>
		<!-- JQUERY COLOR PICKER -->
		<!-- /*END added_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/ -->
<?php if($_SESSION["login"]["framework"]=="pelangi"){?>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery.inputmask.js" type="text/javascript"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/datatables.js" type="text/javascript"></script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/dataTables.fixedHeader.js" type="text/javascript"></script>
		<!-- DATATABLE EXPORT BUTTONS -->
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/dataTables.buttons.min.js"></script> 
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/buttons.colVis.min.js"></script> 
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jszip.min.js"></script>
		<script type="text/javascript" src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/buttons.html5.min.js"></script>
		<!-- DATATABLE EXPORT BUTTONS -->
<?php }?>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/sweetalert.min.js" type="text/javascript"></script>
	<!--<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/jquery.form.js" type="text/javascript"></script>-->
<!------finish individual files as needed-------------------------------------------------------------------------------------------------------------------------------------------->
<!------start functions for this theme + document.ready processing------------------------------------------------------------------------------------------------------------------->
		<?php $ws=explode("/",$page_dir.$config["webspira"]);?>
		<script>var page_dir_config_webspira = '<?php echo $ws[1]?>';</script>
		<script src="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/js/devoops.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<!	[endif]-->
<!------finish functions for this theme + document.ready processing------------------------------------------------------------------------------------------------------------------>
<!------
	-----       -----  -----  -----        -    -   -  ----   -----  ----   -----  -----  -----  -----   -----  -----  -- --
-           -   -  -   -    -         -     -  -   -   -  -   -  -   -  -        -      -    -       -      -   -  -- --
	----   ---  -----  -----    -        -      ---    ----   -----  ----   -----    -      -    ----    -      -   -  - - -
-           -      -   -    -       -       -  -   -  -   -   -  -   -      -    -      -    -       -      -   -  -   -
	-----       -      -   -    -      -        -   -  -   -  -   -  ----   -----  -----    -    ----- - -----  -----  -   -
--->
<?php if($_SESSION["login"]["framework"]=="pelangi"){?>
		<link href="<?php echo $page_dir.$config["webspira"]?>assets_dashboard/css/<?php echo $config["style"]?>" rel="stylesheet" />
		<?php include $page_dir.$config["webspira"]."dashboard_java.php";?>
<?php }?>
<?php /*created_by:glennferio@inspiraworld.com,release_date:2019-12-16*/ ?>