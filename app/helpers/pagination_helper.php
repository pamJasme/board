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

    $rows_per_page = 10;
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
            for ($i = $pagenum-4; $i < $pagenum; $i++) { 
                if($i > 0){
                    $control .= '<a href"'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
                }
            }
        }

        $control .= ''.$pagenum.' &nbsp; ';
        for($i = $pagenum + 1; $i <= $last_page; $i++){
            $control .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'</a> &nbsp; ';
            if($i >= $pagenum + 4){
                break;
            }
        }

        if($pagenum != $last_page){
            $next = $pagenum + 1;
            $control .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> ';
        }
    }//14:25 Video 



    $pagination['max'] = $max;
    $pagination['last_page'] = $last_page;
    $pagination['pagenum'] = $pagenum;
    $pagination['control'] = $control;

    //$pagination['']
    return $pagination;
}