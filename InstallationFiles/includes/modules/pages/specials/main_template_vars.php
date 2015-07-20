<?php
/**
 * SNAF version 1.4
 * Specials
 *
 * @package page
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 18802 2011-05-25 20:23:34Z drbyte $
 */


//===========  bof SNAF (filter by category)
if($_GET['sale_category'])
{
// find subcategories
    $subcategories_array = array();
    zen_get_subcategories($subcategories_array, $_GET['sale_category']);
	$subcategories_array[] = $_GET['sale_category'];
	foreach($subcategories_array as $s)
	{
		$string .= "'".$s."',";
	}
	$string = substr($string, 0, -1);


  $extra = "AND p.master_categories_id IN (".$string.") ";
}else{
  $extra = '';
}
//===========  eof SNAF (filter by category)


if (MAX_DISPLAY_SPECIAL_PRODUCTS > 0 ) {


// INCLUDE SALE ITEMS IN SPECIALS LISTING
	// add sort order
	$disp_order_default = PRODUCT_ALL_LIST_SORT_DEFAULT;
	require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_LISTING_DISPLAY_ORDER));
	$order_by = isset($order_by) ? $order_by : 'ORDER BY s.specials_date_added DESC';
	$sale_categories = $db->Execute("SELECT sale_categories_all FROM " . TABLE_SALEMAKER_SALES . " WHERE sale_status = 1");

if ($sale_categories->RecordCount() > 0 and zen_get_configuration_key_value('INCLUDE_SALEMAKER_IN_SPECIALS')=='True') 
{
	$sale_categories_all = '';
	while(!$sale_categories->EOF) {
	  	$sale_categories_all .= substr($sale_categories->fields['sale_categories_all'], 0, -1); // remove trailing comma
		  $sale_categories->MoveNext();
	}
	$sale_categories_all = substr($sale_categories_all, 1); // remove preceeding comma

        $specials_query_raw = "SELECT p.products_type, p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id,
                                    p.products_date_added,  p.products_model, p.products_quantity, p.products_weight, p.product_is_call,
                                    p.product_is_always_free_shipping, p.products_qty_box_status,
                                    p.master_categories_id
                         FROM " . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_SPECIALS . " s ON (s.products_id = p.products_id)
                         LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (pd.products_id = p.products_id)
                         WHERE p.products_status = '1'
                           AND ( (s.status = 1 AND p.products_id = s.products_id) OR (p.master_categories_id IN ($sale_categories_all)) )
                           AND p.products_id = pd.products_id
                           AND pd.language_id = :languagesID
                         ".$extra.' '.$order_by;

} else {
  // DEFAULT ZEN CART SPECIALS LISTING
        $specials_query_raw = "SELECT p.products_type, p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id,
                                    p.products_date_added,  p.products_model, p.products_quantity, p.products_weight, p.product_is_call,
                                    p.product_is_always_free_shipping, p.products_qty_box_status,
                                    p.master_categories_id
                         FROM (" . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                         LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         WHERE p.products_id = s.products_id and p.products_id = pd.products_id and p.products_status = '1'
                           AND s.status = 1
                           AND pd.language_id = :languagesID
                         ".$extra.' '.$order_by;
}

  $specials_query_raw = $db->bindVars($specials_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $specials_split = new splitPageResults($specials_query_raw, MAX_DISPLAY_SPECIAL_PRODUCTS);
  $specials = $db->Execute($specials_split->sql_query);
  $row = 0;
  $col = 0;
  $list_box_contents = array();
  $title = '';

  $num_products_count = $specials->RecordCount();
  if ($num_products_count) {
    if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS==0 ) {
      $col_width = floor(100/$num_products_count);
    } else {
      $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS);
    }

    $list_box_contents = array();
    while (!$specials->EOF) {

      $products_price = zen_get_products_display_price($specials->fields['products_id']);
      $specials->fields['products_name'] = zen_get_products_name($specials->fields['products_id']);
      $list_box_contents[$row][$col] = array('params' => 'class="specialsListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
                                             'text' => '<a href="' . zen_href_link(zen_get_info_page($specials->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($specials->fields['master_categories_id']) . '&products_id=' . $specials->fields['products_id']) . '">' . (($specials->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : zen_image(DIR_WS_IMAGES . $specials->fields['products_image'], $specials->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>') . '<br /><a href="' . zen_href_link(zen_get_info_page($specials->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($specials->fields['master_categories_id']) . '&products_id=' . $specials->fields['products_id']) . '">' . $specials->fields['products_name'] . '</a><br />' . $products_price);
      $col ++;
      if ($col > (SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS - 1)) {
        $col = 0;
        $row ++;
      }
      $specials->MoveNext();
    }

//===========  bof SNAF (set up for product listing)

$use_product_listing = false;

if(zen_get_configuration_key_value('USE_PRODUCT_LISTING_FOR_SPECIALS')=='True')
{
$use_product_listing = true;
$snaf_listing_split = $specials_split;

if(zen_get_configuration_key_value('USE_PRODUCT_LISTING_FILTER_FOR_SPECIALS')=='True')
{
$show_product_listing_filter = true;
}else{
$show_product_listing_filter = false;
}

if (PRODUCT_LISTING_LAYOUT_STYLE == 'rows'){
// include the language file for the headings
	$category_depth = 'products';
	if(file_exists(DIR_WS_LANGUAGES.$_SESSION['language'].'/index.php'))
	{
	require(DIR_WS_LANGUAGES.$_SESSION['language'].'/index.php');
	}else{
	require(DIR_WS_LANGUAGES.'english/index.php');
	}
}

  // create column list
  $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
  'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
  'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
  'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
  'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
  'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
  'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE);

  /*                         ,
  'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);
  */
  asort($define_list);
  reset($define_list);
  $column_list = array();
  foreach ($define_list as $key => $value)
  {
    if ($value > 0) $column_list[] = $key;
  }
}
//===========  eof SNAF (set up for product listing)

    require($template->get_template_dir('tpl_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_specials_default.php');
  }
}
