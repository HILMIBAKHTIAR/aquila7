<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<title><?php echo $_SESSION["cabang"]["nama"]?><?php if(!empty($_SESSION["menu_".$_SESSION["g.menu"]]["title"]))echo " - Print ".$_SESSION["menu_".$_SESSION["g.menu"]]["title"];?></title>
	<link href="../contents/image/favicon.ico" rel="shortcut icon" />
	<link href="../<?php echo $config["webspira"]?>assets_dashboard/css/style_print.css" media="all" rel="stylesheet" type="text/css" />
</head>
<body class="print"><div id="canvas"><div id="main">
<!--<body class="print" onload="window.print()"><div id="canvas"><div id="main">-->
	<p class="ver-middle">
		<?php
 $filename="../contents/image/logo_print.png";if(file_exists($filename))echo "<img align=\"center\" src=\"".$filename."\" height=\"50px\" style=\"margin-right:20px;\">";if(!empty($company))echo "<strong class=\"font-xlarge\">".$company."</strong>";?>
	</p>
	<center><h3><?php echo strtoupper($_SESSION["menu_".$_GET["m"]]["export_title"])?></h3></center>
	<table class="datalist" cellspacing="0" width="100%">
		<?php
 $column=$_SESSION["menu_".$_GET["m"]]["export_column"];$query=$_SESSION["menu_".$_GET["m"]]["export_query"];$html="<thead><tr class=\"th-height\">";foreach($column as $col){if(!empty($col["caption"])&&$col["caption"]!="Action"){$html.="<th>".strtoupper($col["caption"])."</th>";}}$html.="</tr></thead>";$html.="<tbody>";$total=array();include "../".$config["webspira"]."functions/number_formatting.php";include "../config/database.php";$mysqli=new mysqli($mysql["server"],$mysql["username"],$mysql["password"],$mysql["database"]);$result=$mysqli->query($query);while($data=$result->fetch_assoc()){$html.="<tr class=\"no-border\">";$count_column=0;foreach($column as $col){if(!empty($col["caption"])&&$col["caption"]!="Action"){$align="";if(!empty($col["align"]))$align=" align=\"".$col["align"]."\"";$width="";if(!empty($col["width"]))$width=" width=\"".$col["width"]."\"";$html.="<td ".$align." ".$width.">&nbsp;";if(isset($data[$col["name"]])){if($data[$col["name"]]!=""){if(isset($col["number"])){if($data[$col["name"]]<0)$html.="(".number_formatting($data[$col["name"]]*-1,$col["number"]).")";else $html.=number_formatting($data[$col["name"]],$col["number"]);}else $html.=$data[$col["name"]];}}$html.="</td>";if(isset($col["total"]))$total[$col["name"]]+=$data[$col["name"]];$count_column++;}}$html.="</tr><tr class=\"last-row\">";for($i=0;$i<$count_column;$i++)$html.="<td class=\"zero-font\">&nbsp;</td>";$html.="</tr>";}$html.="<tr class=\"no-border\">";$count_column=0;foreach($column as $col){if(!empty($col["caption"])&&$col["caption"]!="Action"){$align="";if(!empty($col["align"]))$align=" align=\"".$col["align"]."\"";$width="";if(!empty($col["width"]))$width=" width=\"".$col["width"]."\"";$html.="<td ".$align." ".$width.">&nbsp;";if(isset($total[$col["name"]])){if($total[$col["name"]]!=""){if(isset($col["number"])){if($total[$col["name"]]<0)$html.="<font color=\"blue\"><b>(".number_formatting($total[$col["name"]]*-1,$col["number"]).")</b></font>";else $html.="<font color=\"blue\"><b>".number_formatting($total[$col["name"]],$col["number"])."</b></font>";}else $html.="<font color=\"blue\"><b>".$total[$col["name"]]."</b></font>";}}$html.="</td>";$count_column++;}}$html.="</tr><tr class=\"last-row\">";for($i=0;$i<$count_column;$i++)$html.="<td class=\"zero-font\">&nbsp;</td>";$html.="</tr>";$html.="</tbody>";echo $html;?>
	</table>
	<table class="font-medium" width="100%">
	<!--<tr>
			<td width="15%"><strong>User</strong></td>
			<td>: <?php echo $_SESSION["login"]["nama"]?></td>
		</tr>
		<tr>
			<td><strong>Tanggal Cetak</strong></td>
			<td>: <?php echo date("Y-m-d")?></td>
		</tr>
		<tr>
			<td><strong>Waktu Cetak</strong></td>
			<td>: <?php echo date("H:i")?></td>
		</tr>-->
		<tr>
			<td><strong>User</strong> : <?php echo $_SESSION["login"]["nama"]?></td>
			<td><strong>Tanggal Cetak</strong> : <?php echo date("Y-m-d")?></td>
			<td><strong>Waktu Cetak</strong> : <?php echo date("H:i")?></td>
		</tr>
	</table>
</div></div></body>
</html>
<?php /*created_by:glennferio@inspiraworld.com;release_date:2020-05-09;*/ ?>