<?php
if (!isset ($_GET['page']) ) {  
    $page = 1;  
} else {  
    $page = validate($_GET['page']);  
}

$page_first_result = ($page-1) * RES_LIMIT;

function time_diff_mesage($diff){
    switch($diff){
        case 0:
            echo " today."; break;
        case 1:
            echo " yesterday."; break;
        default:
            echo $diff." days ago.";
    }
}


function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;

}

function pagination($page, $page_total){
    if($page_total > 1){
        for ($i = 1; $i <= $page_total; $i++) {
            $_GET['page'] = $i;
            $current = "";
            if($i == $page){
                $current = "current";
            }
    ?>
            <a class='page-numbers <?php echo $current ?>'
            href="<?php echo urldecode($_SERVER["PHP_SELF"]."?".http_build_query($_GET));?>">
            <?php echo $i; ?></a>
    <?php
        }
    }
}

function remove_page_param_from_url(){
    $parsed = parse_url($_SERVER['REQUEST_URI']);
    $query = $parsed['query'];
    parse_str($query, $params);
    unset($params['page']);
    $url = http_build_query($params);
    return $url;
}