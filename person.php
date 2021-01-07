<?php
if(!class_exists('WP_List_Table')){
	require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
}

class Person extends WP_List_Table{
	private  $_items;
   function __construct( $args = array() ) {
	   parent::__construct( $args );
   }

// data set here
   function set_data($data){
   	$this->items = $data;
   	    //$this->items = $data;
   }

// column set here
   function get_columns() {
	   return [
	   	    'cb' => '<input type="checkbox">',
		   'name'=> 'Person Name',
		   'email'=> 'Person Email',
		   'age'=> 'Age'
	   ];
   }
   // sortable column
	function  get_sortable_columns() {
		return [
			'age'=>['a',true],
			'name'=>['n',true]
		];
	}

	function column_cb( $item ) {
	   return '<input type="checkbox" value="'.$item['id'].'">';
   }

   // name column style or format
   function column_name($item){

   	return "<strong>{$item['name']} </strong>";
   }

	function  prepare_items() {
		$this->_column_headers = array($this->get_columns(),array(),$this->get_sortable_columns());
			$paged = $_REQUEST['paged']?? 1;
		// set pagination
		$this->set_pagination_args([
			'total_items' => count($this->items),
			'per_page' => 2,
			'total_page' => ceil(count($this->items))
		]);

   }

   function  column_default( $item, $column_name ) {
	 return $item[$column_name];
   }


}