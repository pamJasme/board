<?php
/**
* Function for pagination
* @param $num_rows
* @param $pagenum
**/
function pagination($num_rows, $pagenum)
{
    echo $pagenum;
    $pagination = array();
    if (!(isset($pagenum))){ 
 		$pagenum = 1; 
 	}
 	if(isset($_GET['pn'])){
 		$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);	
 	}

    $rows_per_page = 5;
    $last_page = ceil($num_rows/$rows_per_page);
    
    if($last_page < 1){
    	$last_page = 1;
    }

    if(isset($_GET['pn'])){
    	$pagenum = preg_replace('#[^0-9]', '', $_GET['pn']); 
    }

    if($pagenum < 1){
    	$pagenum = 1;
    }elseif($pagenum > $last_page){
    	$pagenum = $last_page;
    }
   	
    $max = 'limit ' .($pagenum - 1) * $rows_per_page.',' .$rows_per_page;

    $control = "";
    if($last_page != 1){
    	if($pagenum > 1){
    		$previous = $pagenum - 1;
    		$control .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'
    		">Previous</a> &nbsp; &nbsp;';
    	}
    }//14:25 Video

    $pagination['max'] = $max;
    $pagination['rows_disp'] = $rows_disp;
    $pagination['pagenum'] = $pagenum;

    //$pagination['']
   	return $pagination;
}