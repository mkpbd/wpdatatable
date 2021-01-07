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
   	$this->_items = $data;
   	    //$this->items = $data;
   }

// column set here
   function get_columns() {
	   return [
	   	    'cb' => '<input type="checkbox">',
		   'name'=> 'Person Name',
		   'sex'=> 'Gender',
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
	// for data filtering
	function extra_tablenav( $which ) {
   	    if('top' == $which):
		?>
		<div class="actions alignleft">
			<select name="filter_s" id="filter_s">
				<option value="All">All</option>
				<option value="m">Male</option>
				<option value="f">Female</option>
			</select>
			<?php submit_button('Filter','button','button',false); ?>
		</div>
	<?php

	endif;
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
			$data_chunks = array_chunk($this->_items,2);
			$this->items = $data_chunks[$paged-1];
		// set pagination
		$this->set_pagination_args([
			'total_items' => count($this->_items),
			'per_page' => 2,
			'total_pages' => ceil(count($this->_items)/2)
		]);

   }

   function  column_default( $item, $column_name ) {
	 return $item[$column_name];
   }


}