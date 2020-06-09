<?php

function dzsap_shortcode_init_listeners(){

  add_shortcode('dzsap_woo_grid', 'dzsap_shortcode_woo_grid');
  add_shortcode('player_button', 'dzsap_shortcode_player_button');

  add_shortcode(DZSAP_ZOOMSOUNDS_ACRONYM, 'dzsap_shortcode_playlist_main');
  add_shortcode('dzs_' . DZSAP_ZOOMSOUNDS_ACRONYM, 'dzsap_shortcode_playlist_main');

  add_shortcode(DZSAP_ZOOMSOUNDS_ACRONYM . '_in_lightbox', 'dzsap_shortcode_lightbox');
  add_shortcode(DZSAP_ZOOMSOUNDS_ACRONYM . '_showcase', 'dzsap_shortcode_showcase');
  add_shortcode('dzsap_wishlist', 'dzsap_shortcode_wishlist');
  add_shortcode('dzsap_search_con', 'dzsap_shortcode_search_con');
  add_shortcode('dzsap_search', 'dzsap_shortcode_search');
}

/**
 * [player_button]
 * @param $atts
 * @param null $content
 * @return string
 */
function dzsap_shortcode_player_button($atts, $content = null) {

  // --
  global $dzsap;

  //print_r($current_user->data);
  //echo 'ceva'.isset($current_user->data->user_nicename);


//        error_log('ratatata');
  $fout = '';


  $margs = array(
    'link' => '',
    'style' => '', // -- "btn-zoomsounds" or "player-but"
    'label' => '',
    'icon' => '',
    'color' => '',
    'target' => '',
    'background_color' => '',
    'extra_classes' => '',
    'wrap_object' => 'on', // -- this will allow a inside a html tag ( default on )
    'extraattr' => '',
    'post_id' => '',
  );

  if ($atts) {

    $margs = array_merge($margs, $atts);
  }


//        echo 'shortcode_player_button margs - '; print_rr($margs);

  $tag = 'div';
  if ($margs['link']) {
    $tag = 'a';

    if ($margs['wrap_object'] == 'on') {
      $tag = 'object';
    }
  }


  $fout .= '<' . $tag;


  if ($margs['link']) {

    $fout .= ' href="' . $margs['link'] . '"';
  }


  if ($margs['target']) {

    $fout .= ' target="' . $margs['target'] . '"';
  } else {

    $fout .= ' target="' . '' . '"';
  }

  $fout .= ' class="' . $margs['style'] . '';

  if ($margs['style'] == 'player-but') {
    $fout .= ' dzstooltip-con';
  }

  if ($content) {
    $margs['label'] = $content;
  }

//    print_rr($margs);
  $fout .= ' ' . $margs['extra_classes'];

  $fout .= '"';
  $fout .= ' style="';

  if ($margs['color']) {
    $fout .= 'color: ' . $margs['color'] . ';';
  }

  $fout .= '"';


//        print_rr($margs);

  if ($margs['post_id']) {

    $fout .= ' data-post_id="' . $margs['post_id'] . '"';


    if (strpos($margs['extra_classes'], 'dzsap-wishlist-but') !== false) {


      $arr_wishlist = $dzsap->get_wishlist();


//		        print_rr($arr_wishlist);
      if (in_array($margs['post_id'], $arr_wishlist)) {


        $margs['icon'] = str_replace('fa-star-o', 'fa-star', $margs['icon']);
      }

    }


    $margs['extraattr'] = str_replace('{{posturl}}', get_permalink($margs['post_id']), $margs['extraattr']);
  }

  $fout .= ' ' . $margs['extraattr'];

  $fout .= '>';


  if ($margs['wrap_object'] == 'on' && $margs['link']) {

    $fout .= ' <a rel="nofollow" href="' . $margs['link'] . '">';
  }

  if ($margs['style'] == 'player-but') {
    $fout .= '<span class="the-icon-bg';

//      print_rr($margs);
    if (strpos($margs['extra_classes'], 'dzsap-btn-info') !== false) {
      $fout .= ' tooltip-indicator';
    }

    $fout .= '"></span>';
  }
  if ($margs['style'] == 'btn-zoomsounds') {
    $fout .= '<span class="the-bg" style="';

    if ($margs['background_color']) {
      $fout .= 'background-color: ' . $margs['background_color'] . ';';
    }

    $fout .= '"></span>';
  }

  if (strpos($margs['icon'], 'fa-') !== false) {
    wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  }

  if ($margs['style'] == 'player-but') {
    $fout .= '<i class="svg-icon';


    if (strpos($margs['extra_classes'], 'dzsap-btn-info') !== false) {
      $fout .= ' tooltip-indicator';
    }

    $fout .= ' fa ' . $margs['icon'] . '"></i>';
  }
  if ($margs['style'] == 'btn-zoomsounds') {
    $fout .= '<span class="the-icon"><i class="fa ' . $margs['icon'] . '"></i></span>';
//            $fout.='<i class="svg-icon fa '. $margs['icon'].'"></i>';
  }


  if ($margs['style'] == 'btn-zoomsounds') {
    $fout .= '<span class="the-label ">' . $margs['label'] . '</span>';
  }


  if ($margs['style'] == 'player-but') {

    $tooltip_class = 'dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right talign-end style-rounded color-dark-light';
    $fout .= '<span class="' . $tooltip_class . '" style="width: auto; white-space: nowrap;"><span class="dzstooltip--inner" style="margin-right: -10px;">' . $margs['label'] . '</span></span>';
  }


  if ($margs['wrap_object'] == 'on' && $margs['link']) {

    $fout .= '</a>';
  }
  $fout .= '</' . $tag . '>';

  // <a rel="nofollow" href="#" class=" btn-zoomsounds  " style="color: #FFF;"><span class="the-bg" style="background-color: #00aced;"></span> <span class="the-label ">Twitter</span></a>


  return $fout;

}

/** [zoomsounds id="theid"]
 * @param array $atts
 * @param null $content
 * @return string|void
 */
function dzsap_shortcode_playlist_main($atts = array(), $content = null) {

  global $current_user, $dzsap;
  $fout = '';
  $iout = ''; //items parse

  $margs = array(
    'id' => 'default'
  , 'db' => ''
  , 'category' => ''
  , 'extra_classes' => ''
  , 'fullscreen' => 'off'
  , 'settings_separation_mode' => 'normal'  // === normal ( no pagination ) or pages or scroll or button
  , 'settings_separation_pages_number' => '5'//=== the number of items per 'page'
  , 'settings_separation_paged' => '0'//=== the page number
  , 'return_onlyitems' => 'off' // ==return only the items ( used by pagination )
  , 'playerid' => ''
  , 'embedded' => 'off'
  , 'divinsteadofscript' => 'off'
  , 'width' => '-1'
  , 'height' => '-1'
  , 'embedded_in_zoombox' => 'off'
  , 'for_embed_ids' => ''
  , 'single' => 'off'
  , 'overwrite_only_its' => ''
  , 'called_from' => 'default'
  , 'play_target' => 'default'
  );

  if ($atts == '') {
    $atts = array();
  }

  $margs = array_merge($margs, $atts);


  // -- the id will get replaced so we can store the original id / slug
  $margs['original_id'] = $margs['id'];


  // -- setting up the db
  $currDb = '';
  if (isset($margs['db']) && $margs['db'] != '') {
    $dzsap->currDb = $margs['db'];
    $currDb = $dzsap->currDb;
  }
  $dzsap->dbs = get_option($dzsap->dbname_dbs);


  $dzsap->db_read_mainitems();


//    print_rr($margs);


  //echo 'ceva'; print_r($dzsap->dbs);
  if ($dzsap->mainoptions['playlists_mode'] == 'normal') {

  } else {
    if ($currDb != 'main' && $currDb != '') {
      $dzsap->dbname_mainitems .= '-' . $currDb;
      $dzsap->mainitems = get_option($dzsap->dbname_mainitems);
    }

    if ($dzsap->mainitems == '') {
      return;
    }
  }

  // -- setting up the db END


  $dzsap->front_scripts();


  $dzsap->sliders_index++;


  $its = array(
    'settings' => array(),
  );
  $selected_term_id = '';

  $term_meta = array();


  $dzsap->get_its_items($its, $margs);

  if ($dzsap->mainoptions['playlists_mode'] == 'normal') {
    $tax = $dzsap->taxname_sliders;


    $reference_term = get_term_by('slug', $margs['id'], $tax);

    if ($reference_term) {

    } else {
      // -- reference term does not exist..

      $directores = get_terms('dzsap_sliders');
//        print_rr($directores);

      $args = $margs;
      $args['id'] = $directores[0]->slug;
      if ($margs['called_from'] != 'redo') {
        $args['called_from'] = 'redo';
        return dzsap_shortcode_playlist_main($args);
      }
      return '';
    }


//      $reference_term_name = $reference_term->name;
//      $reference_term_slug = $reference_term->slug;

    $selected_term_id = $reference_term->term_id;

    $term_meta = get_option("taxonomy_$selected_term_id");
  }


//		error_log('BEFORE its -5 '.print_r($its,true).' - MARGS - '.print_r($margs,true));

  if ($margs['overwrite_only_its'] && is_array($margs['overwrite_only_its'])) {

//        print_rr($margs);

    $new_its = array_merge(array(), $its);
    foreach ($its as $lab => $val) {
      if ($lab !== 'settings') {
        unset($new_its[$lab]);
      }
    }
    $new_its = array_merge($new_its, $margs['overwrite_only_its']);

    $its = $new_its;
  }

//    error_log('AFTER its - '.print_r($its,true).' - MARGS - '.print_r($margs,true));


  $dzsap->get_its_settings($its, $margs, $term_meta, $selected_term_id);


  //print_r($dzsap->mainitems);
  // -- audio player configuration setup
  $vpsettingsdefault = array(
    'id' => 'default',
    'skin_ap' => 'skin-wave',
    'settings_backup_type' => 'full',
    'skinwave_dynamicwaves' => 'off',
    'skinwave_enablespectrum' => 'off',
    'skinwave_enablereflect' => 'on',
    'skinwave_comments_enable' => 'off',
    'skinwave_mode' => 'normal',
    'playfrom' => 'default',
    'enable_embed_button' => 'off',
    'loop' => 'off',
    'preload_method' => 'metadata',
    'cue_method' => 'on',
  );

  $vpsettings = array();


  $i = 0;

  $vpsettings = DZSZoomSoundsHelper::getVpSettings($its['settings']['vpconfig']);

  $tempVpConfigId=  $vpsettings['settings']['id'];
  unset($vpsettings['settings']['id']);
  $its['settings'] = array_merge($its['settings'], $vpsettings['settings']);
  $its['playerConfigSettings'] = ($vpsettings['settings']);
  $its['playerConfigSettings']['id'] = $tempVpConfigId;

  if (isset($its['playerConfigSettings']['config_extra_css'])) {

    if (in_array(DZSZoomSoundsHelper::sanitize_for_css_class($its['settings']['vpconfig']), $dzsap->footer_style_configs) == false) {

      $its['playerConfigSettings']['config_extra_css'] = str_replace('$classmain', '.apconfig-' . DZSZoomSoundsHelper::sanitize_for_css_class($its['settings']['vpconfig']), $its['playerConfigSettings']['config_extra_css']);
      $dzsap->footer_style .= $its['playerConfigSettings']['config_extra_css'];

      array_push($dzsap->footer_style_configs, DZSZoomSoundsHelper::sanitize_for_css_class($its['settings']['vpconfig']));
    }
  }


  //this works only for the zoomsounds_player shortcode ==== not anymore hahaha
//        $its['settings']['skinwave_comments_enable'] = 'off';
  //print_r($its);
  // -- some sanitizing
  $tw = $its['settings']['width'];
  $th = $its['settings']['height'];

  if ($margs['width'] != '-1') {
    $tw = $margs['width'];
  }
  if ($margs['height'] != '-1') {
    $th = $margs['height'];
  }
  $str_tw = '';
  $str_th = '';

  if ($tw != '') {
    $str_tw .= 'width: ';
    if (strpos($tw, "%") === false && strpos($tw, "auto") === false) {
      $str_tw .= $tw . 'px';
    }
    $str_tw .= ';';
  }

  if ($th != '') {
    $str_th .= 'height: ';
    if (strpos($th, "%") === false && $th != 'auto' && $th != '') {
      $str_th .= $th . 'px';
    }
    $str_th .= ';';
  }


  $galleryskin = 'skin-wave';

  if (isset($its['settings']['galleryskin'])) {
    $galleryskin = $its['settings']['galleryskin'];
  }


//        print_rr($its);


  // -- playlist
  if (isset($its['playerConfigSettings']['colorhighlight']) && $its['playerConfigSettings']['colorhighlight']) {
    $fout .= '<style class="audiogallery-style">';

    $fout .= $dzsap->generate_extra_css_player(array(
      'skin_ap' => $its['playerConfigSettings']['skin_ap'],
      'selector' => '.audiogallery#ag' . $dzsap->sliders_index . ' .audioplayer',
      'colorhighlight' => $its['playerConfigSettings']['colorhighlight'],
    ));

    $fout .= '</style>';

  }


  if (isset($its['settings']['enable_bg_wrapper']) && $its['settings']['enable_bg_wrapper'] == 'on') {
    $fout .= '<div class="ap-wrapper">
<div class="the-bg"></div>';
  }

//		print_rr($its);
  $fout .= '<noscript><style>.audiogallery{ opacity: 1!important; } .audiogallery .audioplayer-tobe{ display:block!important; opacity: 1!important; }  .audioplayer-tobe>div[class^=feed-]{ display: block!important; }</style></noscript>';
  // -- main gallery div
  $fout .= '<div style="opacity:0;" id="ag' . $dzsap->sliders_index . '" class="audiogallery ag_slug_' . $margs['original_id'] . ' ' . $galleryskin . ' id_' . $its['settings']['id'] . ' ';

//    error_log('$its after ag.. '.print_r($its,true));

  if ($margs['extra_classes']) {
    $fout .= ' ' . $margs['extra_classes'];
  }


  $fout .= '" style="background-color:' . $its['settings']['bgcolor'] . ';' . $str_tw . '' . $str_th . '">';


  //$fout.=$dzsap->parse_items($its, $margs);

//        print_r($its); print_r($margs);
  if ($content) {


//            echo 'do_shortcode(content); '; $content. ' '.do_shortcode($content);

    $iout .= do_shortcode($content);
  } else {

    $args = array(
      'called_from' => 'gallery',
      'gallery_skin' => $galleryskin,
    );
    $args = array_merge($vpsettings['settings'], $args);
    $args = array_merge($args, $margs);

//            print_rr($its);


//      error_log('we are getting ready to parse_items for gallery'.print_r($its,true));

    $args['called_from'] = 'gallery';

//      echo 'its -6 '. print_r($its,true);
//      echo '$args -6 '. print_r($args,true);

    $iout .= $dzsap->parse_items($its, $args);
//      error_log('parse_items result - '.$dzsap->parse_items($its, $args));
  }

  $fout .= '<div class="items">';
  $fout .= $iout;


  $fout .= '</div>';
  $fout .= '</div>'; // -- end .audiogallery


  if (isset($its['settings']['enable_bg_wrapper']) && $its['settings']['enable_bg_wrapper'] == 'on') {
    $fout .= '</div>';
  }

  if ($margs['divinsteadofscript'] != 'on') {
    $fout .= '<script>';
  } else {
    $fout .= '<div class="toexecute">';
  }


  $fout .= 'jQuery(document).ready(function ($) { var settings_ap = ';


  $fout .= '{ "design_skin": "' . $its['settings']['skin_ap'] . '"';



//  print_rr('$its[\'playerConfigSettings\'] - '.print_r($its['playerConfigSettings'],true));
  $fout.=dzsap_generate_javascript_setting_for_player($its['playerConfigSettings']);

  if ($dzsap->mainoptions['soundcloud_api_key']) {
    $fout .= ',"soundcloud_apikey":"' . $dzsap->mainoptions['soundcloud_api_key'] . '","php_retriever":"' . $dzsap->base_url . 'soundcloudretriever.php"     ';
  }



  if (isset($dzsap->mainoptions['skinwave_wave_mode_canvas_normalize']) && $dzsap->mainoptions['skinwave_wave_mode_canvas_normalize'] == 'off') {
    $fout .= ',"skinwave_wave_mode_canvas_normalize":"' . $dzsap->mainoptions['skinwave_wave_mode_canvas_normalize'] . '"';
  }



  if (isset($its['playerConfigSettings']['enable_embed_button']) && ($its['playerConfigSettings']['enable_embed_button'] != 'off')) {

    $str_db = '';
    if ($dzsap->currDb != '') {
      $str_db = '&db=' . $dzsap->currDb . '';
    }
    if ($margs['id'] == 'playlist_gallery') {
      $str = '<iframe src="' . site_url() . '?action=zoomsounds-embedtype=playlist&ids=' . $margs['for_embed_ids'] . '' . $str_db . '" width="100%" height="' . $its['settings']['height'] . '" style="overflow:hidden; transition: height 0.5s ease-out;" scrolling="no" frameborder="0"></iframe>';
    } else {
      $str = '<iframe src="' . site_url() . '?action=zoomsounds-embed&type=gallery&id=' . $its['settings']['id'] . '' . $str_db . '" width="100%" height="' . $its['settings']['height'] . '" style="overflow:hidden; transition: height 0.5s ease-out;" scrolling="no" frameborder="0"></iframe>';
    }


    $str = str_replace('"', "'", $str);
    $fout .= ',"embed_code":"' . htmlentities($str, ENT_QUOTES) . '"';
  }

  if (isset($its['settings']['enable_embed_button']) && ($its['settings']['enable_embed_button'] == 'on' || $vpsettings['settings']['enable_embed_button'] == 'in_player_controls')) {
    $fout .= ',"enable_embed_button":"' . 'on' . '"';
  }

  $fout .= ',"settings_php_handler":window.ajaxurl';
  if ($its['settings']['skinwave_comments_enable'] == 'on') {
    if (isset($current_user->data->user_nicename)) {
      $fout .= ',"skinwave_comments_account":"' . $current_user->data->user_nicename . '"';
      $fout .= ',"skinwave_comments_avatar":"' . $dzsap->get_avatar_url(get_avatar($current_user->data->ID, 20)) . '"';
      $fout .= ',"skinwave_comments_playerid":"' . $margs['playerid'] . '"';
    }
  }


  $dzsap->mainoptions['color_waveformbg'] = str_replace('#', '', $dzsap->mainoptions['color_waveformbg']);
  if ($dzsap->mainoptions['skinwave_wave_mode'] == 'canvas') {
    $fout .= ',"pcm_data_try_to_generate": "' . $dzsap->mainoptions['pcm_data_try_to_generate'] . '"';
    $fout .= ',"pcm_notice": "' . $dzsap->mainoptions['pcm_notice'] . '"';
    $fout .= ',"notice_no_media": "' . $dzsap->mainoptions['notice_no_media'] . '"';

  }


  $design_animateplaypause = 'off';


  if ($dzsap->mainoptions['failsafe_repair_media_element'] == 'on') {
    $fout .= ',"failsafe_repair_media_element":1000';
  }

  if ($dzsap->mainoptions['settings_trigger_resize'] == 'on') {
    $fout .= ',"settings_trigger_resize":"1000"';
  };

  if ($dzsap->mainoptions['wavesurfer_pcm_length'] != '200') {
    $fout .= ',"wavesurfer_pcm_length":"' . $dzsap->mainoptions['wavesurfer_pcm_length'] . '"';
  };


//        print_rr($its);
  $fout .= '};';
  // -- end settings ap


  $fout .= ' dzsag_init("#ag' . $dzsap->sliders_index . '",';


  // -- start settings
  $fout .= '{ "playlistTransition":"fade"  ,"autoplay" : "' . $its['settings']['autoplay'] . '"  ,"embedded" : "' . $margs['embedded'] . '" ,"autoplayNext" : "' . $its['settings']['autoplaynext'] . '","design_menu_position" :"' . $its['settings']['menuposition'] . '"';


  $fout .= ',"settings_ap": settings_ap';
//        print_rr($its);


  $lab = 'mode_normal_video_mode';
  if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
    $fout .= ',"' . $lab . '":"' . $its['settings'][$lab] . '"';
  }


  if (isset($dzsap->mainoptions['loop_playlist']) && $dzsap->mainoptions['loop_playlist']) {
    $fout .= ',"loop_playlist":"' . $dzsap->mainoptions['loop_playlist'] . '"';
  }
  $lab = 'player_navigation';
  if (isset($its['settings'][$lab])) {
    $fout .= ',"' . $lab . '":"' . $its['settings'][$lab] . '"';
  }
  if (isset($its['settings']['cuefirstmedia'])) {
    $fout .= ',"cueFirstMedia":"' . $its['settings']['cuefirstmedia'] . '"';
  }
  if (isset($its['settings']['mode'])) {
    $fout .= ',"settings_mode":"' . $its['settings']['mode'] . '"';
  }
  if (isset($its['settings']['settings_navigation_method'])) {
    $fout .= ',"navigation_method":"' . $its['settings']['settings_navigation_method'] . '"';
  }
  if (isset($its['settings']['settings_mode_showall_show_number'])) {
    $fout .= ',"settings_mode_showall_show_number":"' . $its['settings']['settings_mode_showall_show_number'] . '"';

    if ($its['settings']['settings_mode_showall_show_number'] && $its['settings']['settings_mode_showall_show_number'] == 'on') {

      wp_enqueue_script('isotope', $dzsap->base_url . 'libs/isotope/isotope.js');
    }
  }


  $lab = 'mode_showall_layout';
  if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
    $fout .= ',"' . $lab . '":"' . $its['settings'][$lab] . '"';
  }


  if (isset($_GET['fromsharer']) && $_GET['fromsharer'] == 'on') {
    if (isset($_GET['audiogallery_startitem_ag1']) && $_GET['audiogallery_startitem_ag1'] !== '') {


      $its['settings']['design_menu_state'] = 'closed';
    }
  }

  if (isset($its['settings']['design_menu_state'])) {
    $fout .= ',"design_menu_state":"' . $its['settings']['design_menu_state'] . '"';
  }
  if (isset($its['settings']['design_menu_height']) && $its['settings']['design_menu_height'] != '') {
    $fout .= ',"design_menu_height":"' . $its['settings']['design_menu_height'] . '"';
  }


  if (isset($its['settings']['design_menu_show_player_state_button'])) {
    $fout .= ',"design_menu_show_player_state_button":"' . $its['settings']['design_menu_show_player_state_button'] . '"';
  }

  if (isset($its['settings']['settings_enable_linking'])) {
    $fout .= ',"settings_enable_linking":"' . $its['settings']['settings_enable_linking'] . '"';
  }
  if (isset($its['settings']['enable_linking'])) {
    $fout .= ',"settings_enable_linking":"' . $its['settings']['enable_linking'] . '"';
  }

  if ($dzsap->mainoptions['force_autoplay_when_coming_from_share_link'] == 'on') {
    $fout .= ',"force_autoplay_when_coming_from_share_link": "on"';
  }


  $fout .= '}';

  // -- end settings


  $fout .= ');';

  $fout .= '});';

  if ($margs['divinsteadofscript'] != 'on') {
    $fout .= '</script>';
  } else {
    $fout .= '</div>';
  }


//end document ready an script

  $url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
  if ($dzsap->mainoptions['fontawesome_load_local'] == 'on') {
    $url = $dzsap->base_url . 'libs/fontawesome/font-awesome.min.css';
  }


  wp_enqueue_style('fontawesome', $url);

//    error_log('fout - '.print_r($fout,true));

  if ($margs['return_onlyitems'] != 'on') {
    return $fout;
  } else {
    return $iout;
  }


  //echo $k;
}

function dzsap_shortcode_lightbox($atts, $content = null) {

  global $dzsap;
  $fout = '';
  //$dzsap->sliders_index++;

  $dzsap->front_scripts();

  wp_enqueue_style('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.css');
  wp_enqueue_script('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.js');

  $args = array(
    'id' => 'default'
  , 'db' => ''
  , 'category' => ''
  , 'width' => ''
  , 'height' => ''
  , 'gallerywidth' => '800'
  , 'galleryheight' => '370'
  );
  $args = array_merge($args, $atts);
  $fout .= '<div class="ultibox"';

  if ($args['width'] != '') {
    $fout .= ' data-width="' . $args['width'] . '"';
  }
  if ($args['height'] != '') {
    $fout .= ' data-height="' . $args['height'] . '"';
  }
  if ($args['gallerywidth'] != '') {
    $fout .= ' data-bigwidth="' . $args['gallerywidth'] . '"';
  }
  if ($args['galleryheight'] != '') {
    $fout .= ' data-bigheight="' . $args['galleryheight'] . '"';
  }

  $fout .= 'data-src="' . $dzsap->base_url . 'retriever.php?id=' . $args['id'] . '" data-type="ajax">' . $content . '</div>';
  $fout .= '<script>
jQuery(document).ready(function($){
$(".zoombox").zoomBox();
});
</script>';

  return $fout;
}


/**
 *   [zoomsounds_showcase feed_from="audio_items" ids="1,2,3"]
, example2 : [zoomsounds_showcase feed_from="audio_items" ids="" style="widget_player" orderby="likes"  order="DESC" count="5" style_widget_player_show_likes="on"]
 * @param array $pargs
 * @return string
 */
function dzsap_shortcode_showcase($pargs = array()) {

  global $dzsapp, $dzsap;

  $fout = '';


  include(DZSAP_BASE_PATH."class_parts/front_shortcode_showcase.php");



  if ($dzsapp) {

    wp_enqueue_style('dzsapp_showcase', $dzsapp->base_url . 'libs/dzsapp/front-dzsapp.css');
    wp_enqueue_script('dzsapp_showcase', $dzsapp->base_url . 'libs/dzsapp/front-dzsapp.js');
  }

  return $fout;

}

function dzsap_shortcode_wishlist($pargs = array()) {

  global $dzsap;

  $margs = array();


  if (!is_array($pargs)) {
    $pargs = array();
  }


  $arr_wishlist = $dzsap->get_wishlist();


//		print_rr($arr_wishlist);


  $fout = '';
  $fout .= '<div class="dzsap-wishlist">';


  if (get_current_user_id()) {

    foreach ($arr_wishlist as $pl) {


      $fout .= $dzsap->shortcode_player(array(
        'source' => $pl,
        'called_from' => 'shortcode_wishlist',
        'config' => 'wishlist-player',
      ));
    }
  } else {
    $fout .= '<div class="dzsap-warning warning">' . esc_html__("You need to be logged in to have a wishlist.") . '</div>';
  }

  $fout .= '</div>';

  return $fout;
}

/** [dzsap_search_con]
 * @param array $pargs
 * @return string
 */
function dzsap_shortcode_dzsap_search_con($pargs = array()) {

  // --

  $margs = array(
    'extra_classes' => 'search-align-right',
  );

  if (!is_array($pargs)) {
    $pargs = array();
  }

  $margs = array_merge($margs, $pargs);


  $fout = '';

  $fout .= '<div class="zoomsounds-search-con ' . $margs['extra_classes'] . '">';
  $fout .= dzsap_shortcode_dzsap_search($margs);
  $fout .= '</div>';

  return $fout;
}

function dzsap_shortcode_dzsap_search($pargs = array()) {

  // -- [dszap_search]
  // -- @search tracks

  $margs = array(
    'extra_classes' => '',
    'target' => '',
  );

  if (!is_array($pargs)) {
    $pargs = array();
  }


  $margs = array_merge($margs, $pargs);


  $fout = '';

  $fout .= '<input class="zoomsounds-search-field ' . $margs['extra_classes'] . '" placeholder="' . esc_html__('Search tracks...', 'dzsap') . '"/>';

  return $fout;
}

