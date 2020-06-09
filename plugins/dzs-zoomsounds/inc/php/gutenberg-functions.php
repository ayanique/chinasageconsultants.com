<?php


function dzsap_gutenberg_init() {

  add_action('init', 'dzsap_gutenberg_add_support_block', 500);

  add_action('admin_footer', 'dzsap_gutenberg_add_support', 500);
  add_action('admin_footer', 'dzsap_gutenberg_add_support', 500);
  add_action('enqueue_block_editor_assets', 'dzsap_gutenberg_admin_enqueue_block_editor_assets', 100);
}


function dzsap_gutenberg_admin_enqueue_block_editor_assets() {
//      echo 'ceva';

  // -- enqueue for gutenberg

  global $dzsap;
  if (is_admin()) {
    wp_enqueue_script('dzsap-gutenberg-admin', DZSAP_BASE_URL . 'admin/gutenberg-admin.js');
    $dzsap->enqueue_main_scripts();
  }
}

function dzsap_gutenberg_player_render($attributes) {
  // -- player render

  $fout = '';

  // -- add block support on init
  global $dzsap;

  if (is_admin()) {
  }


//		echo ' attributes - '.print_rr($attributes,true);

  $attributes['call_from'] = 'dzsap_gutenberg_player_render';
  $fout .= '<div class="gutenberg-dzsap-player-con">' . $dzsap->shortcode_player($attributes);
  $fout .= '</div>';

  return $fout;
}


function dzsap_gutenberg_add_support_block() {
  // -- in init


  // -- add block support on init
  global $dzsap;

  // -- default atrributes gallery
  $atts_gallery = array(
    'dzsap_select_id' => array(
      'type' => 'string',
      'default' => 'default',
    ),
    'examples_con_opened' => array(
      'type' => 'string',
      'default' => '',
    ),
  );


  if (function_exists('register_block_type')) {

//      register_block_type('dzsap/gutenberg-block', array(
//        'attributes' => $atts_gallery,
//        'editor_script' => 'dzsap-gutenberg-block', // The script name we gave in the wp_register_script() call.
//        'render_callback' => array($dzsap, 'gutenberg_block_render'),
//      ));


    $atts_player = array();

//      print_rr($dzsap->options_item_meta);

    foreach ($dzsap->options_item_meta_sanitized as $opt) {
      $aux = array();

      $aux['type'] = 'string';
      if (isset($opt['type'])) {
        $aux['type'] = $opt['type'];
      }
      if ($aux['type'] == 'select') {
        $aux['type'] = 'string';
      }
      if (isset($opt['default'])) {

        $aux['default'] = $opt['default'];
      }

      // -- sanitizing
      if ($aux['type'] == 'text') {
        $aux['type'] = 'string';
      }


      if ($aux['type'] == 'string' || $aux['type'] == 'attach') {
        $atts_player[$opt['name']] = $aux;
      }

//          array_push($atts_player,$aux);
    }

//			error_log('$dzsap->options_item_meta_sanitized - '.print_r($dzsap->options_item_meta_sanitized,true));
//			error_log('$atts_player - '.print_r($atts_player,true));


    // -- register gutenberg
    register_block_type('dzsap/gutenberg-player', array(
      'attributes' => $atts_player,
      'render_callback' => 'dzsap_gutenberg_player_render',
    ));
    register_block_type('dzsap/gutenberg-playlist', array(
      'attributes' => $atts_gallery,
      'render_callback' => 'dzsap_gutenberg_playlist_render',
    ));
  }

}


function dzsap_gutenberg_add_support() {
  // -- this is loaded in admin_footer

//		echo 'ceva'.function_exists('register_block_type');


  global $post;
  global $dzsap;
  global $current_screen;

//    error_log(print_rr($post,true));
//     -- we need to remove gutenberg support if this is avada or wpbakery

//    error_log('is_gutenberg_editor_active() - '.get_current_screen()->is_block_editor());

  $load_script = true;
//  echo $current_screen;

  if ($post && $post->post_content && strpos($post->post_content, 'vc_row') !== false) {
    $load_script = false;
  }
  if ((defined('AVADA_VERSION'))) {

    $load_script = false;
  }

  // -- disable if it's not gutenberg
  if (function_exists('get_current_screen')) {
    if (method_exists('get_current_screen', 'is_block_editor') && get_current_screen()->is_block_editor() == false) {
      $load_script = false;
    }
  }

  if (isset($_GET['post_type']) && $_GET['post_type'] == 'sp_easy_accordion') {
    $load_script = false;
  }

//    error_log('is_gutenberg_editor_active() - '.print_r(get_current_screen(),true));

  if ((isset($current_screen) && $current_screen->base && $current_screen->base == 'post') && !(function_exists('has_blocks') && has_blocks($post->ID))) {
    $load_script = false;
  }
  if ($load_script) {
    wp_enqueue_script('wp-blocks');
    wp_enqueue_script('wp-element');
    wp_enqueue_script('dzsap-gutenberg-player');
    wp_enqueue_script('dzsap-gutenberg-playlist');
  }

}

function dzsap_gutenberg_register_scripts() {
  global $dzsap;

  // -- on init
  if (is_admin() && function_exists('register_block_type')) {

    // -- register our block editor script.

    // -- gallery
//      wp_register_script(
//        'dzsap-gutenberg-block',
//        plugins_url('gutenberg/block.js', __FILE__),
//        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor')
//      );


    wp_register_script(
      'dzsap-gutenberg-playlist',
      DZSAP_BASE_URL . ('dist/block_playlist.js'),
      array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor')
    );

    // -- we store this for loading in the footer once all dependencies are loaded
    wp_register_script(
      'dzsap-gutenberg-player',
      DZSAP_BASE_URL . ('dist/block_player.js'),
      array(
        'wp-blocks',
        'wp-element',
        'wp-components',
        'wp-editor',
      )
    );
  }


  add_shortcode('dzsap_gutenberg_block', 'dzsap_gutenberg_playlist_render');
  add_shortcode('dzsap_gutenberg_player', 'dzsap_gutenberg_player_render');
}

function dzsap_gutenberg_playlist_render($attributes) {
  // -- gallery render

  $fout = '';
  $attributes['id'] = $attributes['dzsap_select_id'];


  //  || $attributes['called_from']=='from_gutenberg'
  if (is_admin()) {
    $attributes['overwrite_only_its'] = array(
      array(
        'source' => 'fake',
        'thumb' => 'https://i.imgur.com/kW6ucoW.jpg',
        'title' => esc_html__('Placeholder', 'dzsap') . ' 1',
        'type' => 'audio',
        'playfrom' => '0',
      ),
      array(
        'source' => 'fake',
        'thumbnail' => 'https://i.imgur.com/kW6ucoW.jpg',
        'thumb' => 'https://i.imgur.com/kW6ucoW.jpg',
        'title' => esc_html__('Placeholder', 'dzsap') . ' 2',
        'type' => 'audio',
        'playfrom' => '0',
      ),
      array(
        'source' => 'fake',
        'thumb' => 'https://i.imgur.com/kW6ucoW.jpg',
        'title' => esc_html__('Placeholder', 'dzsap') . ' 3',
        'type' => 'audio',
        'playfrom' => '0',
      ),
    );

//      print_rr($attributes);
  }
  $fout .= '<div class="gutenberg-dzsap-con">' . dzsap_shortcode_playlist_main($attributes);


  $fout .= '</div>';
  return $fout;
}

