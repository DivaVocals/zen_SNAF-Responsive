<?php
/*
 * SNAF version 1.2
 * init_include 
*/

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

if($uninstall != 'uninstall')
{

/* Delete existing Specials configuration group */
$sql = "DELETE FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title = 'Specials Listing-SNAF';";
$db->Execute($sql);

/* Set sort order of specials listing to match sort order of featured listing */
/* We are putting specials in just above featured */
$sql = "SELECT sort_order FROM ".TABLE_ADMIN_PAGES." WHERE page_key ='configFeaturedListing' LIMIT 1";
$result = $db->Execute($sql);
	$specials_sort_order = $result->fields['sort_order'];

/*shuffle the other entries down one row*/
$sql = "UPDATE ".TABLE_ADMIN_PAGES." SET sort_order = sort_order + 1 WHERE menu_key = 'configuration' AND sort_order >= ".$specials_sort_order;
$db->Execute($sql);

/* Create New Specials configuration group */
$sql = "INSERT INTO ".TABLE_CONFIGURATION_GROUP." (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (NULL, 'Specials Listing-SNAF', 'Set Specials Listing Options', ".$specials_sort_order.", '1')";
$db->Execute($sql);

/* Find Config ID of Specials */
$sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='Specials Listing-SNAF' LIMIT 1";
$result = $db->Execute($sql);
	$specials_configuration_id = $result->fields['configuration_group_id'];

// Display Specials Page in Admin Menu
zen_deregister_admin_pages('configSpecialsListing');
zen_register_admin_page('configSpecialsListing',
	'BOX_CONFIGURATION_SPECIALS_LISTING', 'FILENAME_CONFIGURATION',
	'gID=' . $specials_configuration_id, 'configuration', 'Y',
	$specials_sort_order);




// create Specials Page Entry while keeping previous values
	$c_key = 'INCLUDE_SALEMAKER_IN_SPECIALS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Include Salemaker Items in Specials Listing', '".$c_key."', '".$config_value."', 'Include Salemaker Items in Specials Listing', ".$specials_configuration_id.", 900, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

// create Specials Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FOR_SPECIALS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Format for Specials Listing', '".$c_key."', '".$config_value."', 'Use Product Listing Format instead of the Default Specials Format', ".$specials_configuration_id.", 910, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry


// create Specials Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_SPECIALS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Filter for Specials in SNAF', '".$c_key."', '".$config_value."', 'Show the Product Listing Filter when using the Product Listing Format for Specials (SNAF) when the column display is used', ".$specials_configuration_id.", 920, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry


/* Find Config ID of All Products */
$sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='All listing' LIMIT 1";
$result = $db->Execute($sql);
	$all_configuration_id = $result->fields['configuration_group_id'];

// create All Products Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FOR_ALL_PRODUCTS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Format for All Products', '".$c_key."', '".$config_value."', 'Use Product Listing Format instead of the Default All Product Format <br/><br/>\r\nThis will make some of the settings on this page inactive as the product listing settings will be used.', ".$all_configuration_id.", 900, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

// create All Products Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_ALL_PRODUCTS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Filter for All Products in SNAF', '".$c_key."', '".$config_value."', 'Show the Product Listing Filter when using the Product Listing Format for All Products (SNAF) when the column display is used', ".$all_configuration_id.", 910, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

/* Find Config ID of New Products */
$sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='New listing' LIMIT 1";
$result = $db->Execute($sql);
	$new_configuration_id = $result->fields['configuration_group_id'];

// create New Products Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FOR_NEW_PRODUCTS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Format for New Products', '".$c_key."', '".$config_value."', 'Use Product Listing Format instead of the Default New Product Format <br/><br/>\r\nThis will make some of the settings on this page inactive as the product listing settings will be used.', ".$new_configuration_id.", 900, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

// create New Products Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_NEW_PRODUCTS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Filter for New Products in SNAF', '".$c_key."', '".$config_value."', 'Show the Product Listing Filter when using the Product Listing Format for New Products (SNAF) when the column display is used', ".$new_configuration_id.", 910, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

/* Find Config ID of Featured Products */
$sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='Featured listing' LIMIT 1";
$result = $db->Execute($sql);
	$featured_configuration_id = $result->fields['configuration_group_id'];

// create Featured Products Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FOR_FEATURED_PRODUCTS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Format for Featured Products', '".$c_key."', '".$config_value."', 'Use Product Listing Format instead of the Default Featured Product Format <br/><br/>\r\nThis will make some of the settings on this page inactive as the product listing settings will be used.', ".$featured_configuration_id.", 900, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

// create Featured Products Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_FEATURED_PRODUCTS';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Filter for Featured Products in SNAF', '".$c_key."', '".$config_value."', 'Show the Product Listing Filter when using the Product Listing Format for Featured Products (SNAF) when the column display is used', ".$featured_configuration_id.", 910, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

/* Find Config ID of Product listing */
$sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='Product Listing' LIMIT 1";
$result = $db->Execute($sql);
	$product_listing_configuration_id = $result->fields['configuration_group_id'];

// create Product Listing Page Entry while keeping previous values
	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_PRODUCT_LISTING';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Product Listing Filter for Column Display', '".$c_key."', '".$config_value."', 'Show the Product Listing Filter when the column display is used', ".$product_listing_configuration_id.", 930, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

// create Product Listing Page Entry while keeping previous values
	$c_key = 'PRODUCT_LISTING_LAYOUT_STYLE';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'rows';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Product Listing - Layout Style', '".$c_key."', '".$config_value."', 'Select the layout style:<br />Each product can be listed in its own row (rows option) or products can be listed in multiple columns per row (columns option)', ".$product_listing_configuration_id.", 900, now(), now(), NULL, 'zen_cfg_select_option(array(''rows'',''columns''),')";
	$db->Execute($sql);
// eof page entry

// create Product Listing Page Entry while keeping previous values
	$c_key = 'PRODUCT_LISTING_COLUMNS_PER_ROW';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'3';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Product Listing - Columns Per Row', '".$c_key."', '".$config_value."', 'Select the number of columns of products to show in each row in the product listing. The default setting is 3.', ".$product_listing_configuration_id.", 910, now(), now(), NULL, NULL)";
	$db->Execute($sql);
// eof page entry

// create Product Listing Page Entry while keeping previous values
	$c_key = 'USE_STYLE_CHANGER_FOR_PRODUCT_LISTING';
	
	$sql = "SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."' LIMIT 1";
	$results = $db->Execute($sql);
	
	$config_value = ($results->fields['configuration_value'] !='')?$results->fields['configuration_value']:'False';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);
	
	$sql = "INSERT INTO ".TABLE_CONFIGURATION." (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
	(NULL, 'Use Style Changer for Product Listing', '".$c_key."', '".$config_value."', 'Show the Style Changer for allowing the customer to change between Rows and Columns', ".$product_listing_configuration_id.", 940, now(), now(), NULL, 'zen_cfg_select_option(array(''True'',''False''),')";
	$db->Execute($sql);
// eof page entry

$messageStack->add('SNAF database changes have been installed', 'success');

}else{

// this is an uninstall :

	$sql = "DELETE FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title = 'Specials Listing-SNAF';";
	$db->Execute($sql);
	zen_deregister_admin_pages('configSpecialsListing');

	$c_key = 'INCLUDE_SALEMAKER_IN_SPECIALS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FOR_SPECIALS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_SPECIALS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FOR_ALL_PRODUCTS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_ALL_PRODUCTS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FOR_FEATURED_PRODUCTS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_FEATURED_PRODUCTS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FOR_NEW_PRODUCTS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_NEW_PRODUCTS';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_PRODUCT_LISTING_FILTER_FOR_PRODUCT_LISTING';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'PRODUCT_LISTING_LAYOUT_STYLE';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'PRODUCT_LISTING_COLUMNS_PER_ROW';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);

	$c_key = 'USE_STYLE_CHANGER_FOR_PRODUCT_LISTING';
	$sql ="DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key = '".$c_key."'";
	$db->Execute($sql);



$messageStack->add('SNAF database changes have been uninstalled', 'success');

}



@unlink(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.snaf.php');
