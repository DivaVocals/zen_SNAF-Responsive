<?php
/*
 * SNAF version 1.2
*/
if($_POST['style_changer']=='columns') $_SESSION['PRODUCT_LISTING_LAYOUT_STYLE'] = 'columns';
if($_POST['style_changer']=='rows') $_SESSION['PRODUCT_LISTING_LAYOUT_STYLE'] = 'rows';