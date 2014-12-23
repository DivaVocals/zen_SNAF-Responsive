<?php
/**
 * SNAF version 1.2
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_specials_default.php 2958 2006-02-03 08:55:25Z birdbrain $
 */
?>
<div class="centerColumn" id="specialsListing">

<?php
//=========== SNAF add category name to title if appropriate (filtered by category)
if(isset($_GET['sale_category']))
{
	$title_extra = ' : '.zen_get_category_name($_GET['sale_category'],$_SESSION['languages_id']);
}else{
	$title_extra = '';
}

?>
<h1 id="specialsListingHeading"><?php echo $breadcrumb->last().$title_extra; ?></h1>

<?php
//===========  eof SNAF add category name to title if appropriate
?>

<?php
//===========  bof SNAF conditional (uses default listing)
if(!$use_product_listing){
?>

<?php
  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

<div id="specialsListingTopNumber" class="navSplitPagesResult back"><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></div>
<div id="specialsListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
<br class="clearBoth" />
<?php
  } // split page
?>
<!-- bof: specials -->
<?php
/**
 * require the list_box_content template to display the products
 */
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
?>
<!-- eof: specials -->
<?php
  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

<div id="specialsListingBottomNumber" class="navSplitPagesResult back"><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></div>
<div id="specialsListingBottomLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . ' ' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?></div>
<br class="clearBoth" />
<?php
  } // split page
?>
<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

<?php
}else{ 	//===========  eof SNAF conditional (uses default listing)
	//===========  bof SNAF conditional else (uses product listing)
?>

<?php

require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');

?>

<?php
}   	//===========  eof SNAF conditional else (uses product listing)
?>
</div>
