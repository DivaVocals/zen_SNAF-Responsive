<?php
/**
 * SNAF version 1.4
 * Common Template - tpl_tabular_display.php
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_tabular_display.php 3957 2006-07-13 07:27:06Z drbyte $
 */

//print_r($list_box_contents);
  $cell_scope = (!isset($cell_scope) || empty($cell_scope)) ? 'col' : $cell_scope;
  $cell_title = (!isset($cell_title) || empty($cell_title)) ? 'list' : $cell_title;

?>
<div id="<?php echo 'cat' . $cPath . 'Table'; ?>" class="tabTable">
<?php
  for($row=0; $row<sizeof($list_box_contents); $row++) {
    $r_params = "";
    $c_params = "";
    if (isset($list_box_contents[$row]['params'])) $r_params .= ' ' . $list_box_contents[$row]['params'];
?>
  <div class="listingRow" <?php echo $r_params; ?>>
<?php
    for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
      $c_params = "";
      $cell_type = ($row==0) ? 'div' : 'div';

if ($current_listing_style == 'columns') $cell_type = 'div';
      if (isset($list_box_contents[$row][$col]['params'])) $c_params .= ' ' . $list_box_contents[$row][$col]['params'];
      if (isset($list_box_contents[$row][$col]['align']) && $list_box_contents[$row][$col]['align'] != '') $c_params .= ' align="' . $list_box_contents[$row][$col]['align'] . '"';
      if ($cell_type=='div') $c_params .= ' scope="' . $cell_scope . '" id="' . $cell_title . 'Cell' . $col . '"';
      if (isset($list_box_contents[$row][$col]['text'])) {
?>
   <?php echo '<' . $cell_type . $c_params . '>'; ?><?php echo $list_box_contents[$row][$col]['text'] ?><?php echo '</' . $cell_type . '>'  . "\n"; ?>
<?php
      }
    }
?>
  </div>
<?php
  }
?> 
</div>