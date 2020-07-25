<?php 
	function search_datetime_class($class, $class_autoformat = "datetime_class_autoformat"){
		if(!empty($class)){
			$datetime_class_autoformat=explode("|",$_SESSION["setting"][$class_autoformat]);
			foreach($datetime_class_autoformat as $dca){
				if(strstr($class,$dca))
					return true;
			}
		}
		return false;
	} ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-06-01;*/ ?>