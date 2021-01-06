<?php
/*
 * Plugin Name:wp data table
 * Plugin URI:
 * Author: Mostofa kamal
 * Author URI:
 * Version:1.0
 * Description: datatables
 * Text Domain: wpdatatable
 * Domain Path:languages
 */



function wpdatatable_text_domain(){
	load_plugin_textdomain(
		'wpdatatable',
		false,
		plugin_dir_url(__FILE__)."/languages"
	);
}
// plugin loaded then callback function work
add_action('plugin_loaded','wpdatatable_text_domain');

function wpdatatable_admin_menu_page(){
	add_menu_page(
		'demo datatable', // page title
		'data table', // menu title
		'manage_options', // capability
		'datatable' , // menu slug or menu url
		'wpdatatable_display_data', // call back function
		'' // icon url
		// position
	);
}

add_action('admin_menu','wpdatatable_admin_menu_page');

// Search By Name
function wpdatatable_search_by_name($item){
		$name = strtolower($item['name']);
		$search_name = sanitize_text_field($_REQUEST['s']);
		if(strpos($name, $search_name) == !false){
			return true;
		}
		return false;
}

function wpdatatable_display_data() {
	require_once 'data.php';
//	print_r($data);
	require_once 'person.php';
	$per = new Person();
	// order by or order
    $orderby = $_REQUEST['orderby']?? "";
    $order = $_REQUEST['order']?? "";

    //Search Request
	if(isset($_REQUEST['s'])){
		$serch_name = $_REQUEST['s'];
		//print_r($serch_name);
		/*$data=array(
			array(
				'id' => 1,
				'name' => 'mostofa kamal',
				'email'=> 'mostofakamal1990@gmail.com',
				'age' => 22
			)
		);*/
		$data = array_filter($data, 'wpdatatable_search_by_name');

	}
	// compare for sorting Data
	if('a' == $orderby){
	    if('asc' == $order){
		    usort($data, function($item1, $item2){
			    return $item2['age'] <=> $item1['age'];
		    });
        }else{
		    usort($data, function($item1, $item2){
			    return $item1['age'] <=> $item2['age'];
		    });
        }
    } else if('n' == $orderby){
		if('asc' == $order){
			usort($data, function($item1, $item2){
				return $item2['age'] <=> $item1['age'];
			});
		}else{
			usort($data, function($item1, $item2){
				return $item1['age'] <=> $item2['age'];
			});
		}
	}
		$per->set_data($data);

	$per->prepare_items();
	?>
		<div class="wrap ">
			<h2><?php _e("Persons",'wpdatatable') ?></h2>
			<?php //print_r($_SERVER); ?>
			<form method="GET" action="<?php $_SERVER['PHP_SELF'] ?>">
				<?php 	$per->search_box('search','search_id'); ?>
				<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
			</form>
		</div>
	<?php

	$per->display();
}