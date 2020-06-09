<?php

allston_eltdf_get_single_post_format_html($blog_single_type);

do_action('allston_eltdf_after_article_content');

allston_eltdf_get_module_template_part('templates/parts/single/author-info', 'blog');

allston_eltdf_get_module_template_part('templates/parts/single/single-navigation', 'blog');

allston_eltdf_get_module_template_part('templates/parts/single/related-posts', 'blog', '', $single_info_params);

allston_eltdf_get_module_template_part('templates/parts/single/comments', 'blog');