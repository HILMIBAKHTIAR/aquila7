<script language="javascript" type="text/javascript">	
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
</script>