<?php 
	function search_date_class($class, $class_autoformat = "date_class_autoformat"){
		if(!empty($class)){
			$date_class_autoformat=explode("|",$_SESSION["setting"][$class_autoformat]);
			foreach($date_class_autoformat as $dca){
				if(strstr($class,$dca))
					return true;
			}
		}
		return false;
	} ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>