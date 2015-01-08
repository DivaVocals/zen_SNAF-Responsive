<?php
//  * SNAF version 1.2
// this version is used when a style changer
// -- product listing
// -- snaf listings
// it includes the get parameters as needed

$this_page =  zen_href_link($_GET['main_page'], zen_get_all_get_params());
?>

<div id="style_changer">

<?php 
if($current_listing_style == 'rows')
{
?>
    <form class="snafStyleChangerCol" action="<?php echo $this_page;?>" method="POST">
        <input type="hidden" name="style_changer" value="columns"/>
        <?php echo zen_image_submit(BUTTON_IMAGE_SNAF_COLUMN,BUTTON_SNAF_COLUMN_ALT, 'id="snafColumn" name="snafColumnSubmit"');?>
    </form>
    	<br />
<?php
}else
{
?>
    <form class="snafStyleChangerRow" action="<?php echo $this_page;?>" method="POST">
        <input type="hidden" name="style_changer" value="rows"/>
        <?php echo zen_image_submit(BUTTON_IMAGE_SNAF_ROW,BUTTON_SNAF_ROW_ALT, 'id="snafRow" name="snafRowSubmit"');?>
    </form>
<?php
}
?>
</div>