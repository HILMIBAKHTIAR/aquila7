<?php $where="";foreach($acomplete["param_input"]as $parameter){$param=explode("|",$parameter);$param_0=str_replace(".","",$param[0]);if($_GET[$param_0]!="skip"){$operator="=";if(isset($param[2])&&!empty($param[2]))$operator=$param[2];if(isset($param[3])&&!empty($param[3]))$acomplete["query"]=str_replace($param[3],$_GET[$param_0],$acomplete["query"]);else $where.=" AND ".$param[0]." ".$operator." '".$_GET[$param_0]."'";if(isset($acomplete["query_sp"])){if(isset($param[3])&&!empty($param[3])){$acomplete["query_sp"]=str_replace($param[3],$_GET[$param[1]],$acomplete["query_sp"]);}}}}$post_term=str_replace(" - "," ",$_POST["term"]);$terms=explode(" ",$post_term);$where.=" AND ( ( ";$i=0;foreach($terms as $keyword){if($i>0)$where.=" AND ( ";$j=0;foreach($acomplete["query_search"]as $column){if($j>0)$where.=" OR ";$where.=" ".$column." LIKE '%".addslashes($keyword)."%' ";$j++;}$where.=" ) ";$i++;}$where.=" ) ";$acomplete["query"]=str_replace("?",$where,$acomplete["query"]);$acomplete["query"].=" ORDER BY ".$acomplete["query_order"];if(!empty($acomplete["query_limit"]))$acomplete["query"].=" LIMIT 0, ".$acomplete["query_limit"];else $acomplete["query"].=" LIMIT 0, ".$_SESSION["setting"]["autocomplete_limit"];if(isset($acomplete["query_sp"]))$acomplete["query"]=str_replace("?",$where,$acomplete["query_sp"]);$response=new stdClass();$query=mysqli_query($con, $acomplete["query"]);$response->items[0]["num"]=0;$response->items[0]["visible"]=get_message(713);if($_SESSION["setting"]["environment"]!="live"){$response->items[0]["debug"]=str_replace(array("\n","\r","\t")," ",$acomplete["query"]);if(!$query)$response->items[0]["debug_error"]=str_replace(array("\n","\r","\t")," ",mysqli_error($con));}if(!empty($query)){$i=0;while($data=mysqli_fetch_array($query)){$response->items[$i]["num"]=$i;foreach($acomplete["items"]as $items){$item=explode("|",$items);$response->items[$i][$_GET["id"]][$item[0]]=$data[$item[0]];}$j=0;$visible="";if(empty($acomplete["items_visible"]))$acomplete["items_visible"]=$acomplete["items"];foreach($acomplete["items_visible"]as $items){$item=explode("|",$items);if(!isset($item[2])){if($j!=0&&!empty($visible))$visible.=$_SESSION["setting"]["autocomplete_separator"];$visible.=$data[$item[0]];$j++;}}$response->items[$i]["visible"]=$visible;$k=0;$result="";if(empty($acomplete["items_selected"]))$result=$visible;else{foreach($acomplete["items_selected"]as $items){if($k!=0&&!empty($result))$result.=$_SESSION["setting"]["autocomplete_separator"];$result.=$data[$items];$k++;}}$response->items[$i]["result"]=$result;$i++;}}echo json_encode($response); ?>
<?php /*created_by:patricklipesik@gmail.com;release_date:2020-05-09;*/ ?>