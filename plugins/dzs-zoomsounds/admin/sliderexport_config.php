<?php
$post = $_GET;
require_once('get_wp.php');
//print_r();
//echo $post['slidernr'].$post['slidername'];
?>
Please note that this feature uses the last saved data. Unsaved changes will not be exported.
<form action="" method="POST">
    <input type="hidden" class="hidden" name="slidernr" value="<?php echo $post['slidernr']; ?>"/>
    <input type="hidden" class="hidden" name="slidername" value="<?php echo $post['slidername']; ?>"/>
    <input type="hidden" class="hidden" name="currdb" value="<?php echo $post['currdb']; ?>"/>
    <input class="button-secondary" type="submit" name="dzsap_exportslider_config" value="Export"/></form>
