 <?php
/**
* Function for pagination
* @param $num_rows
* @param $pagenum
**/

//IN PROGRESS
function pagination($num_rows, $pagenum, array $set_url = NULL)
{
    define('rows_per_page', 10);
    $pagination = array();
    if (!(isset($pagenum))){ 
        $pagenum = 1; 
    }
    if(isset($_GET['pn'])){
        $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);   
    }

    $last_page = ceil($num_rows/rows_per_page);
    
    if($last_page < 1){
        $last_page = 1;
    }

    if(isset($_GET['pn'])){
        $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']); 
    }

    if($pagenum < 1){
        $pagenum = 1;
    }elseif($pagenum > $last_page){
        $pagenum = $last_page;
    }
    
    $max = 'limit ' .($pagenum - 1) * rows_per_page.',' .rows_per_page;
    $page_link =& $url_query['pn'];
    $control = "";
    if($last_page != 1){
        if($pagenum > 1){
            $page_link = $pagenum - 1;
            $control .= "<a href='" . url('', $url_query) . "'> 
                Previous </a> &nbsp; &nbsp;";
            for ($i = $pagenum-4; $i < $pagenum; $i++) { 
                if($i > 0){
                    $control .= "<a href'". url('', $url_query). "'>$i</a> &nbsp; ";
                }
            }
        }

        $control .= ''.$pagenum.' &nbsp; ';
        for($i = $pagenum + 1; $i <= $last_page; $i++){
            $page_link = $i;
            $control .= "<a href='".url('', $url_query)."'>$i</a> &nbsp; ";
            if($i >= $pagenum + 4){
                break;
            }
        }

        if($pagenum != $last_page){
            $page_link = $pagenum + 1;
            $control .= " &nbsp; &nbsp; <a href='".url('', $url_query)."'>Next</a>";
        }
    }//14:25 Video 



    $pagination['max'] = $max;
    $pagination['last_page'] = $last_page;
    $pagination['pagenum'] = $pagenum;
    $pagination['control'] = $control;

    //$pagination['']
    return $pagination;
}