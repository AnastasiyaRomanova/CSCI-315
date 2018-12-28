<?php
require('../model/database.php');
require('../model/product_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'list_products';
    }
}



if ($action == 'list_products') {
    // Get product data
    $products = get_products();

    // Display the product list
    include('product_list.php');
} else if ($action == 'delete_product') {
    $product_code = filter_input(INPUT_POST, 'product_code');
    delete_product($product_code);
    header("Location: .");
} else if ($action == 'show_add_form') {
    include('product_add.php');
} else if ($action == 'add_product') {
  
    $code = filter_input(INPUT_POST, 'code');
    $name = filter_input(INPUT_POST, 'name');
    $version = filter_input(INPUT_POST, 'version', FILTER_VALIDATE_FLOAT);
    $release_date = filter_input(INPUT_POST, 'release_date');
    
    
    
    if ( $code === NULL || $name === FALSE || 
            $version === NULL || $version === FALSE || 
            $release_date === NULL) {
        $error = "Invalid product data. Check all fields and try again.";
        include('../errors/error.php');
    } else {
        $month;
        $day;
        $year;
        
        $format_date = array();
        $format_date[0] = explode("/", $release_date);
        $format_date[1] = explode("\\", $release_date);
        $format_date[2] = explode("-", $release_date);
        
        foreach($format_date as $dates) {
            for($i = 0; $i < count($dates); ++$i) {
                if(strlen($dates[0]) == 1) {
                    $month = '0' . $dates[0];
                }
                else {
                    $month = $dates[0];
                }
                
                if(strlen($dates[1]) == 1) {
                    $day = '0' . $dates[1];
                }
                else {
                    $day = $dates[1];
                }
                
                if(strlen($dates[2]) == 2) {
                    $year = '20' . $date[2];
                }
                else {
                    $year = $dates[2];
                }
            }
            if(count($dates) > 1) {
                $release_date = $dates[2] . "-" . $dates[0] . "-" . $dates[1];
            }
        }
        add_product($code, $name, $version, $release_date);
        header("Location: .");
    }
}
?>