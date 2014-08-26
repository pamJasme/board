 <?php

const MAX_ROWS = 10;

/**
* Function for pagination
* @param $num_rows
* @param $pagenum
* @param $set_url
**/
function pagination($num_rows, $pagenum, array $set_url = NULL)
{
    $pagination = array();

    if (!(isset($pagenum))){ 
        $pagenum = 1; 
    }

    if(isset($_GET['pn'])){
        $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);   
    }

    $last_page = ceil($num_rows/MAX_ROWS);
    
    if($last_page < 1){
        $last_page = 1;
    }

    if($pagenum < 1){
        $pagenum = 1;
    }elseif($pagenum > $last_page){
        $pagenum = $last_page;
    }
    
    $max = 'limit ' .($pagenum - 1) * MAX_ROWS.',' .MAX_ROWS;
    $page_link =& $set_url['pn'];
    $control = "";
    if($last_page != 1){
        if($pagenum > 1){
            $page_link = $pagenum - 1;
            $control .= "<a href='" . url('', $set_url) . "'> 
                Previous </a> &nbsp; &nbsp;";
            
            for ($i = $pagenum - ; $i < $pagenum; $i++) { 
                if($i > 0){
                    $control .= "<a href'". url('', $set_url). "'>$i</a> &nbsp; ";
                }
            }
        }

        $control .= ''.$pagenum.' &nbsp; ';
        for($i = $pagenum + 1; $i <= $last_page; $i++){
            $page_link = $i;
            $control .= "<a href='".url('', $set_url)."'>$i</a> &nbsp; ";
            if($i >= $pagenum + 4){
                break;
            }
        }

        if($pagenum != $last_page){
            $page_link = $pagenum + 1;
            $control .= " &nbsp; &nbsp; <a href='".url('', $set_url)."'>Next</a>";
        }
    }
    $pagination['max'] = $max;
    $pagination['last_page'] = $last_page;
    $pagination['pagenum'] = $pagenum;
    $pagination['control'] = $control;
    return $pagination;
}