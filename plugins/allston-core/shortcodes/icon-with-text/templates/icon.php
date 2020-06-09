<?php 
if ($icon_parameters['icon_source'] == 'icon-font') {
	echo allston_eltdf_execute_shortcode('eltdf_icon', $icon_parameters);
} else {
	$icon_parameters['svg_path'] = urldecode(base64_decode($icon_parameters['svg_path']));

	echo '<span class="eltdf-svg-icon-holder" '.  allston_eltdf_get_inline_attrs($svg_holder_data) .'>';
	echo allston_eltdf_get_module_part($icon_parameters['svg_path']);
	echo '</span>';
}
