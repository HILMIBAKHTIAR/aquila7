<?php 
	function search_period_class($class, $class_autoformat = "period_class_autoformat"){
		if(!empty($class)){
			$period_class_autoformat=explode("|",$_SESSION["setting"][$class_autoformat]);
			foreach($period_class_autoformat as $dca){
				if(strstr($class,$dca))
					return true;
			}
		}
		return false;
	} ?>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-06-01;*/ ?>