<?php 
	function search_picker_class($class, $class_autoformat = ""){
		if(!empty($class)){
			$picker_class_autoformat=explode("|",$_SESSION["setting"][$class_autoformat]);
			foreach($picker_class_autoformat as $dca){
				if(strstr($class,$dca))
					return true;
			}
		}
		return false;
	} ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>