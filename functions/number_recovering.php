<?php function number_recovering($number=""){$recovered="0";if(!empty($number)){$recovered=str_replace(".","",$number);$recovered=str_replace(",",".",$recovered);}return $recovered;} ?>
<?php /*created_by:patricklipesik@gmail.com;release_date:2020-05-09;*/ ?>