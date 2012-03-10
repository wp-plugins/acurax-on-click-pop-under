<?php
/* 
Plugin Name: Acurax On Click Pop Under
Plugin URI: http://www.acurax.com/Products/acurax-click-pop-plugin-wordpress/
Description: An Easy to use plugin to enable pop under page on visitors browser on visitor click. Admin can configure the url to open as popunder on visitor 	
click. Plugin will set cookie on visitors browser on popunder appear and so it will show only once. You can also configure the cookie timeout in plugin settings.
Author: Acurax 
Version: 1.0.2
Author URI: http://www.acurax.com 
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/ 
?>
<?php
//*************** Include JS in Header ********
function enqueue_acx_popunder_script()
{
?>
<br/>
<script type="text/javascript" src="<?php echo plugins_url('js.php', __FILE__);?>"></script>
<?php
}
add_action( 'get_footer', 'enqueue_acx_popunder_script' );
//*************** Include JS in Header Ends Here ********
//*************** Admin function ***************
function acx_onclick_popunder_admin() {
	include('acx_onclick_popunder_admin.php');
}
function acx_onclick_popunder_admin_actions()
{
	add_menu_page(  'PopUnder', 'PopUnder', 8, 'Acurax-onclick_popunder-Settings','acx_onclick_popunder_admin',plugin_dir_url( __FILE__ ).'/images/admin.png', 12 ); // 8 for admin
}
if ( is_admin() )
{
add_action('admin_menu', 'acx_onclick_popunder_admin_actions');
}
?>