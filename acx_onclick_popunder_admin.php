<?php
	$acurax_popunder_array=get_option('acurax_popunder_array');
	$acurax_time_out=get_option('acurax_popunder_timeout');
	if($acurax_time_out == "" || !is_numeric($acurax_time_out))
	{
		$acurax_time_out = 60;
	}
	update_option('acurax_popunder_timeout',$acurax_time_out);
	$acx_popunder_message = "";
		
	if($acurax_popunder_array == "")
	{
		$acurax_popunder_array = array();
	}
	else
	{	 
		if(is_serialized($acurax_popunder_array))
		{
			$acurax_popunder_array = unserialize($acurax_popunder_array); 
		}	 
		if(!is_array($acurax_popunder_array))
		{
			$acurax_popunder_array = array();
		}
	}
		if(is_serialized($acurax_popunder_array ))
		{
			$acurax_popunder_array = unserialize($acurax_popunder_array); 
		}
		 
		if($_GET['action']=="delete" && $_GET['ID'] != "")
		{
			$to_del_id = $_GET['ID']-1;
			unset($acurax_popunder_array[$to_del_id]);
			$acurax_popunder_array = array_values($acurax_popunder_array);
			if(!is_serialized($acurax_popunder_array ))
			{
				$acurax_popunder_array = serialize($acurax_popunder_array); 
			}
			update_option('acurax_popunder_array', $acurax_popunder_array);
			if(is_serialized($acurax_popunder_array ))
			{
				$acurax_popunder_array = unserialize($acurax_popunder_array); 
			}
			$acx_popunder_message = "The URL Deleted Successfully!.";
		}
			
		if($_POST['acurax_popunder_hidden'] == 'Y') 
		{
			//Form data sent
			$acurax_popunder_url_formdata = $_POST['acurax_popunder_url'];
			if($acurax_popunder_url_formdata !="" )
			{
				$acurax_popunder_array[]=$acurax_popunder_url_formdata;
			}
			if(!is_serialized($acurax_popunder_array))
			{
				$acurax_popunder_array = serialize($acurax_popunder_array); 
			}
			update_option('acurax_popunder_array', $acurax_popunder_array);
			$acurax_time_out = $_POST['acurax_popunder_timeout'];
			
			update_option('acurax_popunder_timeout', $acurax_time_out);
			if(is_serialized($acurax_popunder_url ))
			{
				$acurax_popunder_url = unserialize($acurax_popunder_url); 
			}
			$acx_popunder_message = "Acurax Popunder Settings Saved!";
		}
		
		if($acx_popunder_message != "")
		{
			echo "<div class='updated'><p><strong>".$acx_popunder_message."</strong></p></div>";
		}
		
// Our class extends the WP_List_Table class, so we need to make sure that it's there
if( ! class_exists( 'WP_List_Table' ) ) 
{
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class  Acx_Onclick_Popunder_My_List_Table extends WP_List_Table 
{
	function __construct()
	{
		
		global $status, $page;
		parent::__construct( array(
				'singular'  => 'url',     //singular name of the listed records
				'plural'    => 'urls',   //plural name of the listed records
				'ajax'      => false        //does this table support ajax?
								) );
	}
	function acx_onclick_popunder_data()
	{
		$acurax_popunder_array=get_option('acurax_popunder_array');

		if($acurax_popunder_array == "")
		{
			$acurax_popunder_array = array();
		} 
		else
		{	 
			if(is_serialized($acurax_popunder_array ))
			{
				$acurax_popunder_array = unserialize($acurax_popunder_array); 
			}	 
			if(!is_array($acurax_popunder_array))
			{
				$acurax_popunder_array = array($acurax_popunder_url);
			}
		}

		if(is_serialized($acurax_popunder_array ))
		{
			$acurax_popunder_array = unserialize($acurax_popunder_array); 
		}		 

		$acurax_popunder_url_new = array();

		foreach($acurax_popunder_array as $key => $value)
		{
			$acurax_popunder_url_new[]=array(
			'ID'=>$key+1,
			'URL'=>$value
			);
		}
		return $acurax_popunder_url_new;
	}

	function acx_onclick_popunder_get_columns()
	{
		$columns = array(
	  
		'ID' => 'Sl No',
		'URL'    => 'URL',
					);
		return $columns;
	}

	function acx_onclick_popunder_prepare_items()
	{
		$columns = $this->acx_onclick_popunder_get_columns();
		$hidden = array();
		//$sortable = array();
		$sortable = $this->acx_onclick_popunder_get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
	   
		$this->items = $this->acx_onclick_popunder_data();
	   
		usort( $this->items,array( &$this, 'acx_onclick_popunder_usort_reorder' ) );
		// $this->acx_onclick_popunder_del_url();
	}
	function column_URL($item)
	{
		$actions = array(
				'delete'    => sprintf('<a href="?page=%s&action=%s&ID=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
						);

		return sprintf('%1$s %2$s', $item['URL'], $this->row_actions($actions) );

	}
	function acx_onclick_popunder_get_sortable_columns()
	{
		$sortable_columns = array(
	  
		'ID'  => array('ID',false),
		'URL' => array('URL',false),
	  
								);
	  return $sortable_columns;
	}
	function acx_onclick_popunder_usort_reorder( $a, $b ) 
	{
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'ID';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : -$result;
	}
	function no_items() 
	{
		_e( 'No URLs found !!!!' );
	}
	function column_default( $item, $column_name ) 
	{
		switch( $column_name )
		{ 
			case 'ID':
			case 'URL':
			return $item[ $column_name ];
			default:
			return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
		}
	}
}
function acx_onclick_popunder_render_list_page()
{
   $myListTable = new Acx_Onclick_Popunder_My_List_Table();
   echo '<div class="wrap">'; 
   $myListTable->acx_onclick_popunder_prepare_items(); 
   $myListTable->display(); 
   echo '</div>'; 
}
?>
<style>
.top
{
display:none;
}
</style>
<div class="wrap">
<?php    echo "<h2>" . __( 'Acurax Popunder Options', 'acx_popunder_config' ) . "</h2>";
$acx_popunder_ru = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
if($acx_popunder_ru != "")
{
	$acx_popunder_ru = str_replace("action=delete&ID","acurax",$acx_popunder_ru);
}
?>
	<form name="acurax_popunder_form" method="post" action="<?php echo $acx_popunder_ru; ?>">
		<table>
		<tr><td>
			<input type="hidden" name="acurax_popunder_hidden" value="Y"></td></tr>
			<tr><td>
			<?php    echo "<h4>" . __( 'Add New Url', 'acx_popunder_config' ) . "</h4>"; ?></td></tr>
			<hr />
			<tr><td><p><?php _e("New Popunder URL: " );?></td><td> <input type="text" name="acurax_popunder_url" id="acurax_popunder_url" value="" size="20">
			</td>
			<td><?php _e(" ex: <a href='http://www.acurax.com' target='_blank'>http://www.acurax.com</a>" );?></td></tr>
			<tr>
			<td colspan="3">
			<input type="submit" name="Submit" value="<?php _e('Add', 'acx_popunder_config');?>" onclick="javascript:return acurax_popunder_validate();">
			</p></td></tr>
		</table>
		<table>
			<hr />
			<tr><td>
			<?php    echo "<h4>" . __( 'General Settings', 'acx_popunder_config' ) . "</h4>"; ?></td></tr>
			<tr><td><p><?php _e("Popunder Cookie Expire Timeout: " ); ?></td><td><input type="text" name="acurax_popunder_timeout" id="acurax_popunder_timeout"  value="<?php echo $acurax_time_out;?>" size="20" /></td><td><?php _e("<b>Minutes</b>. Needs to Define in Minutes, For Eg: '60' for 1 Hour" );?></p>
			</td></tr>
			<tr><td colspan="3">
			<p class="submit">
			<input type="submit" name="Submit" value="<?php _e('Update', 'acx_popunder_config');?>" onclick="javascript:return acurax_popunder_validate();" >
			</p></td></tr>
		</table>
			<hr />
			<p>
			<?php _e("<h4> Current URLs</h4>" );
			?> 
<?php acx_onclick_popunder_render_list_page(); ?>
			</p>
    </form>	
</div>
<script type="text/javascript">
function acurax_popunder_validate()
{
	var acurax_popunder_url=jQuery("#acurax_popunder_url").val();
	var acurax_popunder_timeout=jQuery("#acurax_popunder_timeout").val();
	var acuraxPopunderUrlValid = true;
	if ( acurax_popunder_timeout == "" || !(/^[0-9]+$/.test(acurax_popunder_timeout)) ) 
	{ 
		alert ( "Enter a valid Timeout" ); 
		acuraxPopunderUrlValid = false;
    } 
    if (acurax_popunder_url == "") 
	{ 
		alert ( "Enter Url" ); 
		acuraxPopunderUrlValid = false;
    } 
	else if(!/^(http)s?:\/\//.test(acurax_popunder_url))
	{
		alert( "Enter a valid Url " );
		acuraxPopunderUrlValid = false
	}
	else if( /^(http)s?:\/\//.test(acurax_popunder_url) ) 
	{ 
		var acx_csma_popunder_url_temp = acurax_popunder_url;
		var acx_csma_popunder_url_newstr = acx_csma_popunder_url_temp.replace(/[(http)s?:\/\/)]/g,"");
		if(acx_csma_popunder_url_newstr == "")
		{
			alert( "Enter a valid Url " );
			acuraxPopunderUrlValid = false;
		} 
	}
    return acuraxPopunderUrlValid;
}
</script>