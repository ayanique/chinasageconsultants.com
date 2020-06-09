<?php if(allston_eltdf_core_plugin_installed()) { ?>
    <div class="eltdf-blog-like">
        <?php if( function_exists('allston_eltdf_get_like') ) allston_eltdf_get_like(); ?>
    </div>
<?php } ?>