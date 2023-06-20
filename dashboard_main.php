<?php
if(!isset($page_dir))$page_dir="";?>
<div class="row">
	<!-- /*START edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/ -->
	<div id="sidebar-left" class="col-xs-2 col-sm-2">
		<div class="profile-menu">
			<img src="<?php echo $page_dir?>contents/image/user/avatar.jpg" class="img-circle" alt="avatar" /><br>
			<span class="welcome">Welcome,</span>
			<div style="position: relative;" class="account">
				<a href="?m=profil_aktif">
					<span><?php echo $_SESSION["login"]["nama"]?></span>
				</a>
				<?php echo $_SESSION["setting"]["company_name"]?>
			</div>
		</div>
		<?php echo $_SESSION["g.menu_html"]?>
	</div>
	<script language="javascript" type="text/javascript">
		$(function()
		{
			$('#menu_<?php echo $_SESSION["menu_".$_SESSION["g.menu_kode"]]["kode"]?>').attr('class','animated fadeInLeft active-parent active');
			<?php
		 		$header=explode("|",$_SESSION["menu_".$_SESSION["g.menu_kode"]]["daftar_header"]);
		 		foreach($header as $kode){?>
					$('#menu_<?php echo $kode?>').attr('class','animated fadeInLeft dropdown-toggle active-parent active ');
					$('#dropdown_<?php echo $kode?>').attr('style','display: block;');
				<?php
	 		}?>
	 	
		});
	</script>
	<div id="content" class="col-xs-12 col-sm-10">
	<!-- /*END edited_by:glennferio@inspiraworld.com;last_updated:2020-05-20;*/ -->
		<ul class="right-bar">
			<li>
				<a href="#" class="account" data-toggle="dropdown"><i class="nc-icon nc-single-01" aria-hidden="true"></i>
				</a>
				<ul class="dropdown-menu animated fadeInLeft" style="width: 110px;">
					<li>
						<a href="?m=profil_aktif">
							<span><i class="fa fa-user"></i> &nbsp;Profile</span>
						</a>
					</li>
					<li>
						<a href="dashboard_logout.php">
							<span><i class="fa fa-sign-out"></i> Sign Out</span>
						</a>
					</li>
				</ul>
			</li>
			<li class="open_notif">
				<a href="#" class="account" data-toggle="dropdown"><i class="nc-icon nc-bell-53" aria-hidden="true"></i><span class="label label-danger badges count-notif">0</span>
				</a>
				<ul class="dropdown-menu notifications animated fadeInRight">
					<li>
						<a href="#">
							<span>No Message</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<div id="ajax-content">
			<div class="row">
				<div id="breadcrumb" class="col-xs-12">
					<a href="#" class="show-sidebar active"><!-- <i class="fa fa-bars"></i> --><div class="hamburger"></div></a>
					<div style="margin-left: 55px;">
					<?php
 if(isset($_SESSION["setting"]["display_cabang_aktif"])&&$_SESSION["setting"]["display_cabang_aktif"]=="off"){echo "&nbsp";}else {$cabang_string="Cabang";if(isset($_SESSION["setting"]["display_cabang_alias"])&&!empty($_SESSION["setting"]["display_cabang_alias"])){$cabang_string=$_SESSION["setting"]["display_cabang_alias"];}?>
						<?php echo $cabang_string?> : <a href="?m=cabang_aktif" class="about"><b><?php echo $_SESSION["cabang"]["nama"]?></b></a>
						<?php
 }?>
					</div>
				</div>
			</div>
			<?php
 unset($_SESSION["menu_construction"]["judul"]);$content_html="";ob_start();if(!empty($_SESSION["menu_".$_SESSION["g.menu_kode"]]["judul"])){$infomenu="";if(isset($_SESSION["menu_".$_SESSION["g.menu_kode"]]["keterangan"])&&!empty($_SESSION["menu_".$_SESSION["g.menu_kode"]]["keterangan"]))$infomenu="<i class='infomenu fa fa-info-circle' title='' data-toggle='tooltip' title='' data-original-title='".$_SESSION["menu_".$_SESSION["g.menu_kode"]]["keterangan"]."'></i>";
 echo "
				<div class='parent-header'>
					<h3 class='page-header'>
						".$_SESSION["menu_".$_SESSION["g.menu_kode"]]["judul"].$infomenu."
					</h3>";?>
					<ol class="breadcrumb pull-left">
					<?php
 $header=explode("|",$_SESSION["menu_".$_SESSION["g.menu_kode"]]["daftar_header"]);foreach($header as $kode){if(!empty($kode)){$shmenu=mysqli_fetch_array(mysqli_query($con, "SELECT a.nama FROM shmenu a WHERE a.".$_SESSION["setting"]["field_kode"]." = '".$kode."'"));?>
						<li><a href="#"><?php echo $shmenu["nama"]?></a></li>
					<?php
 }}?>
						<li><a href="<?php echo $_SESSION["g.url"]?>"><?php echo $_SESSION["menu_".$_SESSION["g.menu_kode"]]["nama"]?></a></li>
					</ol>
			<?php
 echo "
				</div>";}if(!empty($_SESSION["menu_".$_SESSION["g.menu"]]["alert"]["message"])){if(empty($_SESSION["menu_".$_SESSION["g.menu"]]["alert"]["type"]))$_SESSION["menu_".$_SESSION["g.menu"]]["alert"]["type"]="warning";echo "<p class='well bg-".$_SESSION["menu_".$_SESSION["g.menu"]]["alert"]["type"]."'>".$_SESSION["menu_".$_SESSION["g.menu"]]["alert"]["message"]."</p>";unset($_SESSION["menu_".$_SESSION["g.menu"]]["alert"]);}if($_SESSION["setting"]["environment"]=="production")include $page_dir.$config["webspira"]."frameworks/frame-".$_SESSION["g.frame"].".php";else @include $page_dir.$config["webspira"]."frameworks/frame-".$_SESSION["g.frame"].".php";if(!empty($_SESSION["g.browse_html"])){foreach($_SESSION["g.browse_html"] as $browse_html)echo $browse_html;}if(!empty($_SESSION["g.debug0_html"])&&$_SESSION["setting"]["environment"]!="live"){echo "
				<!--
				-- BEGIN DEBUGGING SAVE #0 PROCESS :
				
				~~ ".$_SESSION["g.debug0_html"]." ~~
				
				-- END DEBUGGING SAVE #0 PROCESS
				-->";unset($_SESSION["g.debug0_html"]);}if(!empty($_SESSION["g.debug_html"])){echo "<br />
				<p class='well bg-default' id='debugging_save_1'>
					Debugging Save #1 :<br />
					".$_SESSION["g.debug_html"]."
				</p>";unset($_SESSION["g.debug_html"]);}if(!empty($_SESSION["g.debug2_html"])){echo "<br />
				<p class='well bg-default' id='debugging_save_2'>
					Debugging Save #2 :<br />
					".$_SESSION["g.debug2_html"]."
				</p>";}$debugging_otf_style="display:none;";if(isset($_GET["debug_otf"]))if($_GET["debug_otf"]==1)$debugging_otf_style="";echo "<br />
			<div id='debugging_otf_div' style='".$debugging_otf_style."'>
				Debugging otF :<br />
				<p class='well bg-default' id='debugging_otf'></p>
			</div>";$content_html=ob_get_contents();ob_end_clean();echo $content_html;?>
		</div>
	</div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
	var filter = '<?php if(isset($index["filter"])) echo $index["filter"]?>';
	if( filter === '1' && $('#form_filter').hasClass('popup')){
		$(".cst-btn-navbutton .col-sm-12 .bs-example div:nth-child(2)").prepend('<a data-toggle="tooltip" title="" class="btn btn-default filter" data-original-title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></a>');
		// CUSTOM POPUP
		$("#form_filter .box-icons").append('<i class="fa fa-times" aria-hidden="true"></i>');
		$(".filter").click(function(){
			$("#form_filter").fadeIn();
			$("table.dataTable").css("z-index", "9");
		});
		$("#form_filter .box-icons i.fa-times").click(function(){
			$("#form_filter").fadeOut(function(){
				$("table.dataTable").css("z-index", "99");
			});
		});
	}
	// $( "input.checkbox-input" ).wrap( "<div class='checkbox-box'></div>" );
	// $( ".checkbox-box" ).append('<span class="checkmark"></span>');
	$(".dataTables_filter").append("<span class='bt-search'><i class='fa fa-search' aria-hidden='true'></i></span>");
	$("div.dataTables_wrapper div.dataTables_filter input").on('input', function(){
		if($(this).val() != ''){
			$(this).css("width", "300px");
		}else{
			$(this).css("width", "35px");
		}
	});

	$(".ui-jqgrid").parents(".form-group").find("div").css("width", "100%");
	$(".cst-txt-browse").parent().css("overflow", "auto");
	$(".box").addClass("fadein");
	var togglesidebar = "<?php echo $_SESSION["setting"]["toogle-sidebar"]?>";
	if(togglesidebar == 'hidebar'){
		$(".dropdown-menu").hide();
	}
});
// PROGRESSBAR
var width = 100,
	perfData = window.performance.timing, // The PerformanceTiming interface represents timing-related performance information for the given page.
	EstimatedTime = -(perfData.loadEventEnd - perfData.navigationStart),
	time = parseInt((EstimatedTime/1000)%60)*50;

// LOADBAR ANIMATION
$(".loadbar").animate({
  width: width + "%"
}, time);

// FADING OUT LOADBAR AFTER FINISHED
setTimeout(function(){
  $('.loadbar').fadeOut(300);
}, time);
</script>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>