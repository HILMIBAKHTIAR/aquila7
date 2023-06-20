<?php 
	function search_month_class($class, $class_autoformat = "month_class_autoformat"){
		if(!empty($class)){
			$month_class_autoformat=explode("|",$_SESSION["setting"][$class_autoformat]);
			foreach($month_class_autoformat as $dca){
				if(strstr($class,$dca))
					return true;
			}
		}
		return false;
	} ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-06-01;*/ ?>