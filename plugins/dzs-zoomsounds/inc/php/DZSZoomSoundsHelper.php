<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04/05/2019
 * Time: 16:11
 */


if (!defined('ABSPATH')) // Or some other WordPress constant
  exit;


class DZSZoomSoundsHelper {
  public static function autoupdaterUpdate($zipUrl = '', $zipTargetPath = '') {


    global $dzsap;
    if (!$zipUrl) {
      $zipUrl = 'https://zoomthe.me/updater_dzsap/servezip.php?purchase_code=' . $dzsap->mainoptions['dzsap_purchase_code'] . '&site_url=' . site_url();
    }
    if (!$zipTargetPath || $zipTargetPath == '') {
      $zipTargetPath = DZSAP_BASE_PATH . 'update.zip';
    }

//    error_log(DZSAP_PHP_LOG_AJAX_LABEL . ' autoupdater - '.$zipUrl.'|'.$zipTargetPath);

    $res = DZSHelpers::get_contents($zipUrl);

    //            echo 'hmm'; echo strpos($res,'<div class="error">'); echo 'dada'; echo $res;
    if ($res === false) {
      echo 'server offline';
    } else {
      if (strpos($res, '<div class="error') === 0) {
        echo $res;


        if (strpos($res, '<div class="error">error: in progress') === 0) {

          $dzsap->mainoptions['dzsap_purchase_code_binded'] = 'on';
          update_option($dzsap->dbname_options, $dzsap->mainoptions);
        }
      } else {

        file_put_contents($zipTargetPath, $res);
        if (class_exists('ZipArchive')) {
          $zip = new ZipArchive;
          $zipOpenResp = $zip->open($zipTargetPath);
          //test
          if ($zipOpenResp === TRUE) {
            //                echo 'ok';
            $zip->extractTo(DZSAP_BASE_PATH);
            $zip->close();


            $dzsap->mainoptions['dzsap_purchase_code_binded'] = 'on';
            update_option($dzsap->dbname_options, $dzsap->mainoptions);


            echo esc_html__('Update succesful.', DZSAP_PREFIX_LOWERCASE);
          } else {
            echo 'failed, code:' . $res;
          }
        } else {

          echo __('ZipArchive class not found.');
        }

      }
    }
  }

  public static function enqueueScriptsForAdminGeneral() {
    global $dzsap;

    wp_enqueue_script('media-upload');
    wp_enqueue_script('tiny_mce');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_enqueue_script('dzs.farbtastic', DZSAP_BASE_URL . "libs/farbtastic/farbtastic.js");
    wp_enqueue_style('dzs.farbtastic', DZSAP_BASE_URL . 'libs/farbtastic/farbtastic.css');

    wp_enqueue_style('dzs.scroller', DZSAP_BASE_URL . 'libs/dzsscroller/scroller.css');
    wp_enqueue_script('dzs.scroller', DZSAP_BASE_URL . 'libs/dzsscroller/scroller.js');
    wp_enqueue_style('dzs.dzstoggle', DZSAP_BASE_URL . 'libs/dzstoggle/dzstoggle.css');
    wp_enqueue_script('dzs.dzstoggle', DZSAP_BASE_URL . 'libs/dzstoggle/dzstoggle.js');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-sortable');


    if (isset($_GET['from']) && $_GET['from'] == 'shortcodegenerator') {
      wp_enqueue_style('dzs.remove_wp_bar', DZSAP_BASE_URL . 'tinymce/remove_wp_bar.css');
    }


    if (isset($_GET['page'])) {
      if ($_GET['page'] == DZSAP_ADMIN_PAGENAME_DESIGNER_CENTER) {
        wp_enqueue_style('dzsap-dc.style', DZSAP_BASE_URL . 'deploy/designer/style/style.css');
        wp_enqueue_script('dzs.farbtastic', DZSAP_BASE_URL . "libs/farbtastic/farbtastic.js");
        wp_enqueue_style('dzs.farbtastic', DZSAP_BASE_URL . 'libs/farbtastic/farbtastic.css');
        wp_enqueue_script('dzsap-dc.admin', DZSAP_BASE_URL . 'deploy/designer/js/admin.js');
      }
      if ($_GET['page'] == DZSAP_ADMIN_PAGENAME_LEGACY_SLIDERS_ADMIN_SLIDERS || $_GET['page'] == DZSAP_ADMIN_PAGENAME_LEGACY_SLIDERS_ADMIN_VPCONFIGS) {

        wp_enqueue_script('dzsap_legacy_sliders_admin', DZSAP_BASE_URL . "admin/legacy-sliders-admin.js", array('jquery'), DZSAP_VERSION);
        wp_enqueue_style('dzsap_legacy_sliders_admin', DZSAP_BASE_URL . 'admin/legacy-sliders-admin.css');


        wp_enqueue_style('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.css');
        wp_enqueue_script('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.js');


        $url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

        if ($dzsap->mainoptions['fontawesome_load_local'] == 'on') {
          $url = DZSAP_BASE_URL . 'libs/fontawesome/font-awesome.min.css';
        }


        wp_enqueue_style('fontawesome', $url);
        wp_enqueue_style('dzstabsandaccordions', DZSAP_BASE_URL . 'libs/dzstabsandaccordions/dzstabsandaccordions.css');
        wp_enqueue_script('dzstabsandaccordions', DZSAP_BASE_URL . "libs/dzstabsandaccordions/dzstabsandaccordions.js");
      }
    }


  }

  public static function parseItemDetermineExtraHtml($initialValue, $playerConfigSettings) {


    if (isset($playerConfigSettings['js_settings_extrahtml_in_bottom_controls_from_config']) && $playerConfigSettings['js_settings_extrahtml_in_bottom_controls_from_config']) {
      $playerConfigSettings['js_settings_extrahtml_in_bottom_controls_from_config'] = str_replace(array("\r", "\r\n", "\n"), '', $playerConfigSettings['js_settings_extrahtml_in_bottom_controls_from_config']);

      $initialValue .= (($playerConfigSettings['js_settings_extrahtml_in_bottom_controls_from_config']));
    }

    return $initialValue;
  }

  public static function enqueueScriptsForAdminMainOptions() {

    wp_enqueue_style('dzscheckbox', DZSAP_BASE_URL . 'libs/dzscheckbox/dzscheckbox.css');


    wp_enqueue_style('dzs.dzstoggle', DZSAP_BASE_URL . 'libs/dzstoggle/dzstoggle.css');
    wp_enqueue_script('dzs.dzstoggle', DZSAP_BASE_URL . 'libs/dzstoggle/dzstoggle.js');

    dzsap_enqueue_fontawesome();
    wp_enqueue_style('dzstabsandaccordions', DZSAP_BASE_URL . 'libs/dzstabsandaccordions/dzstabsandaccordions.css');
    wp_enqueue_script('dzstabsandaccordions', DZSAP_BASE_URL . "libs/dzstabsandaccordions/dzstabsandaccordions.js");


    if (isset($_GET['dzsap_shortcode_builder']) && $_GET['dzsap_shortcode_builder'] == 'on') {

      wp_enqueue_style('dzsap_shortcode_builder_style', DZSAP_BASE_URL . 'tinymce/popup.css');
      wp_enqueue_script('dzsap_shortcode_builder', DZSAP_BASE_URL . 'tinymce/popup.js');
      wp_enqueue_style('dzs.tabsandaccordions', DZSAP_BASE_URL . 'libs/dzstabsandaccordions/dzstabsandaccordions.css');
      wp_enqueue_script('dzs.tabsandaccordions', DZSAP_BASE_URL . 'libs/dzstabsandaccordions/dzstabsandaccordions.js');
      wp_enqueue_media();


      wp_enqueue_style('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.css');
      wp_enqueue_script('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.js');
    } else {


      if (isset($_GET['dzsap_shortcode_player_builder']) && $_GET['dzsap_shortcode_player_builder'] == 'on') {


        wp_enqueue_style('dzsap_shortcode_builder_style', DZSAP_BASE_URL . 'tinymce/popup.css');
        wp_enqueue_style('dzsap_shortcode_player_builder_style', DZSAP_BASE_URL . 'shortcodegenerator/generator_player.css');
        wp_enqueue_script('dzsap_shortcode_player_builder', DZSAP_BASE_URL . 'shortcodegenerator/generator_player.js');

        wp_enqueue_style('dzs.tabsandaccordions', DZSAP_BASE_URL . 'libs/dzstabsandaccordions/dzstabsandaccordions.css');
        wp_enqueue_script('dzs.tabsandaccordions', DZSAP_BASE_URL . 'libs/dzstabsandaccordions/dzstabsandaccordions.js');
        wp_enqueue_media();


        wp_enqueue_style('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.css');
        wp_enqueue_script('ultibox', DZSAP_BASE_URL . 'libs/ultibox/ultibox.js');


        wp_enqueue_style('dzs.tooltip', DZSAP_BASE_URL . 'libs/dzstooltip/dzstooltip.css');
      } else {

        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-slider');
        $url = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css";
        wp_enqueue_style('jquery-ui-smoothness', $url, false, null);
        wp_enqueue_script('dzs.farbtastic', DZSAP_BASE_URL . "libs/farbtastic/farbtastic.js");
        wp_enqueue_style('dzs.farbtastic', DZSAP_BASE_URL . 'libs/farbtastic/farbtastic.css');
      }

    }

  }

  public static function registerDzsapPages() {


    global $dzsap;
    if ($dzsap->pluginmode == 'theme') {
      $dzsap_page = add_theme_page(__('DZS ZoomSounds', 'dzsap'), __('DZS ZoomSounds', 'dzsap'), $dzsap->admin_capability, $dzsap->adminpagename, array($dzsap, 'admin_page'));
    } else {
      $capability = 'dzsap_manage_options';

      if (current_user_can('manage_options')) {
        $capability = 'manage_options';
      }


      $dzsap_page = add_menu_page(esc_html__('Playlists', 'dzsap'), esc_html__('ZoomSounds', 'dzsap'), $capability, $dzsap->adminpagename, array($dzsap, 'admin_page'), 'div');


      $capability = 'dzsap_manage_vpconfigs';

      if (current_user_can('manage_options')) {
        $capability = 'manage_options';
      }


      $dzsap_subpage = add_submenu_page($dzsap->adminpagename, esc_html__('Playlists', 'dzsap'), esc_html__('Playlists', 'dzsap'), $capability, $dzsap->adminpagename, array($dzsap, 'admin_page'));


      $capability = 'dzsap_manage_vpconfigs';

      if (current_user_can('manage_options')) {
        $capability = 'manage_options';
      }


      $dzsap_subpage = add_submenu_page($dzsap->adminpagename, 'ZoomSounds ' . __('Player Configs', 'dzsap'), __('Player Configs', 'dzsap'), $capability, $dzsap->pageName_legacy_sliders_admin_vpconfigs, array($dzsap, 'admin_page_vpc'));


      $capability = 'dzsap_manage_options';

      if (current_user_can('manage_options')) {
        $capability = 'manage_options';
      }

      $dzsap_subpage = add_submenu_page($dzsap->adminpagename, __('ZoomSounds Settings', 'dzsap'), __('Settings', 'dzsap'), $capability, $dzsap->page_mainoptions_link, array($dzsap, 'admin_page_mainoptions'));


      $capability = 'manage_options';


      $dzsap_subpage = add_submenu_page($dzsap->adminpagename, __('Autoupdater', 'dzsap'), __('Autoupdater', 'dzsap'), $dzsap->admin_capability, $dzsap->adminpagename_autoupdater, array($dzsap, 'admin_page_autoupdater'));


      $capability = 'delete_posts';
      if (current_user_can('manage_options')) {
        $capability = 'manage_options';
      }
      $dzsap_subpage = add_submenu_page($dzsap->adminpagename, __('About ZoomSounds', 'dzsap'), __('About', 'dzsap'), $capability, $dzsap->adminpagename_about, array($dzsap, 'admin_page_about'));
    }


    //echo $dzsap_page;


    if ($dzsap->mainoptions['dzsap_items_hide'] == 'on') {
      remove_menu_page('edit.php?post_type=' . DZSAP_REGISTER_POST_TYPE_NAME);
    }

  }

  public static function get_assets() {
    $default_options = include_once DZSAP_BASE_PATH . 'class_parts/options-main-php.php';
    return array(
      'default_options' => $default_options,
      'hearts_svg' => '<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" version="1.0" width="15" height="15"  viewBox="0 0 645 700" id="svg2"> <defs id="defs4" /> <g id="layer1"> <path d="M 297.29747,550.86823 C 283.52243,535.43191 249.1268,505.33855 220.86277,483.99412 C 137.11867,420.75228 125.72108,411.5999 91.719238,380.29088 C 29.03471,322.57071 2.413622,264.58086 2.5048478,185.95124 C 2.5493594,147.56739 5.1656152,132.77929 15.914734,110.15398 C 34.151433,71.768267 61.014996,43.244667 95.360052,25.799457 C 119.68545,13.443675 131.6827,7.9542046 172.30448,7.7296236 C 214.79777,7.4947896 223.74311,12.449347 248.73919,26.181459 C 279.1637,42.895777 310.47909,78.617167 316.95242,103.99205 L 320.95052,119.66445 L 330.81015,98.079942 C 386.52632,-23.892986 564.40851,-22.06811 626.31244,101.11153 C 645.95011,140.18758 648.10608,223.6247 630.69256,270.6244 C 607.97729,331.93377 565.31255,378.67493 466.68622,450.30098 C 402.0054,497.27462 328.80148,568.34684 323.70555,578.32901 C 317.79007,589.91654 323.42339,580.14491 297.29747,550.86823 z" id="path2417" style="" /> <g transform="translate(129.28571,-64.285714)" id="g2221" /> </g> </svg>',
      'svg_star' => '<svg enable-background="new -1.23 -8.789 141.732 141.732" height="141.732px" id="Livello_1" version="1.1" viewBox="-1.23 -8.789 141.732 141.732" width="141.732px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Livello_100"><path d="M139.273,49.088c0-3.284-2.75-5.949-6.146-5.949c-0.219,0-0.434,0.012-0.646,0.031l-42.445-1.001l-14.5-37.854   C74.805,1.824,72.443,0,69.637,0c-2.809,0-5.168,1.824-5.902,4.315L49.232,42.169L6.789,43.17c-0.213-0.021-0.43-0.031-0.646-0.031   C2.75,43.136,0,45.802,0,49.088c0,2.1,1.121,3.938,2.812,4.997l33.807,23.9l-12.063,37.494c-0.438,0.813-0.688,1.741-0.688,2.723   c0,3.287,2.75,5.952,6.146,5.952c1.438,0,2.766-0.484,3.812-1.29l35.814-22.737l35.812,22.737c1.049,0.806,2.371,1.29,3.812,1.29   c3.393,0,6.143-2.665,6.143-5.952c0-0.979-0.25-1.906-0.688-2.723l-12.062-37.494l33.806-23.9   C138.15,53.024,139.273,51.185,139.273,49.088"/></g><g id="Livello_1_1_"/></svg>',
      'svg_stick_to_bottom_close_hide' => '<svg version="1.1" class="svg-icon icon-hide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="144.883px" height="145.055px" viewBox="0 0 144.883 145.055" enable-background="new 0 0 144.883 145.055" xml:space="preserve"> <g> <g> <g> <g> <g> <path fill="#5A5B5D" d="M72.527,145.055C32.535,145.055,0,112.52,0,72.527S32.535,0,72.527,0c37.921,0,69.7,29.6,72.35,67.387 c0.097,1.377-0.942,2.572-2.319,2.669c-1.384,0.087-2.571-0.941-2.669-2.319C137.423,32.557,107.834,5,72.527,5 C35.293,5,5,35.293,5,72.527s30.293,67.527,67.527,67.527c35.271,0,64.858-27.525,67.355-62.665 c0.098-1.377,1.302-2.396,2.672-2.316c1.377,0.099,2.414,1.294,2.316,2.672C142.188,115.488,110.41,145.055,72.527,145.055z"/> </g> </g> <g> <g> <g> <path fill="#5A5B5D" d="M45.658,101.897c-0.64,0-1.279-0.244-1.768-0.732c-0.977-0.976-0.977-2.559,0-3.535l25.102-25.103 L43.891,47.425c-0.977-0.977-0.977-2.56,0-3.535c0.977-0.977,2.559-0.977,3.535,0l26.869,26.87 c0.977,0.977,0.977,2.559,0,3.535l-26.869,26.87C46.938,101.653,46.298,101.897,45.658,101.897z"/> </g> </g> <g> <g> <path fill="#5A5B5D" d="M99.396,101.896c-0.64,0-1.279-0.244-1.768-0.732L70.76,74.295c-0.977-0.977-0.977-2.559,0-3.535 l26.869-26.87c0.977-0.977,2.559-0.977,3.535,0c0.977,0.976,0.977,2.559,0,3.535L76.062,72.527l25.102,25.102 c0.977,0.977,0.977,2.559,0,3.535C100.676,101.652,100.036,101.896,99.396,101.896z"/> </g> </g> </g> </g> </g> </g> </svg>',
      'svg_stick_to_bottom_close_show' => '<svg version="1.1" class="svg-icon icon-show" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="148.025px" height="148.042px" viewBox="0 0 148.025 148.042" enable-background="new 0 0 148.025 148.042" xml:space="preserve"> <g> <g> <g> <g> <g> <g> <path fill="#5A5B5D" d="M74.038,148.042c-8.882,0-17.778-1.621-26.329-4.873C14.546,130.561-5.043,96.09,1.132,61.206 c0.241-1.359,1.537-2.268,2.897-2.026c1.359,0.241,2.267,1.538,2.026,2.897c-5.757,32.523,12.508,64.662,43.431,76.418 c17.222,6.551,35.964,6.003,52.771-1.544c16.809-7.547,29.672-21.188,36.221-38.411c6.552-17.222,6.004-35.963-1.543-52.771 c-7.546-16.809-21.188-29.672-38.411-36.222C68.706-1.792,35.266,8.613,17.206,34.85c-0.783,1.138-2.338,1.424-3.478,0.642 c-1.137-0.783-1.424-2.34-0.642-3.478C32.458,3.874,68.324-7.283,100.301,4.873c18.472,7.024,33.103,20.821,41.195,38.848 c8.094,18.027,8.682,38.127,1.655,56.597c-7.023,18.472-20.819,33.102-38.846,41.195 C94.624,145.859,84.342,148.041,74.038,148.042z"/> </g> </g> </g> <g> <g> <g> <g> <g> <path fill="#5A5B5D" d="M53.523,111.167c-0.432,0-0.863-0.111-1.25-0.335c-0.773-0.446-1.25-1.271-1.25-2.165V39.376 c0-0.894,0.477-1.719,1.25-2.165c0.773-0.447,1.727-0.447,2.5,0l60.014,34.646c0.773,0.446,1.25,1.271,1.25,2.165 s-0.477,1.719-1.25,2.165l-60.014,34.645C54.387,111.056,53.955,111.167,53.523,111.167z M56.023,43.706v60.631 l52.514-30.314L56.023,43.706z"/> </g> </g> </g> </g> </g> </g> </g> </g> </svg>',
    );
  }

  public static function get_soundcloud_track_source($che) {
    global $dzsap;
    $fout = '';

    $sw_was_cached = false;


    $cacher = get_option('dzsap_cache_soundcloudtracks');

    if (is_array($cacher) == false) {
      $cacher = array();
    }


    if (isset($cacher[$che['soundcloud_track_id']])) {
      $fout = $cacher[$che['soundcloud_track_id']]['source'];
      $sw_was_cached = true;
    }

//        print_r($cacher); echo ' is cached - '.$sw_was_cached.'||';


    if ($sw_was_cached == false) {

      $aux = DZSHelpers::get_contents('https://api.soundcloud.com/tracks/' . $che['soundcloud_track_id'] . '.json?secret_token=' . $che['soundcloud_secret_token'] . '&client_id=' . $dzsap->mainoptions['soundcloud_api_key']);


      $auxa = json_decode($aux);


      $fout = $auxa->stream_url . '&client_id=' . $dzsap->mainoptions['soundcloud_api_key'];


      $cacher[$che['soundcloud_track_id']] = array(
        'source' => $fout
      );


      if ($fout) {

        update_option('dzsap_cache_soundcloudtracks', $cacher);
      }


    }

    return $fout;
  }


  public static function checkIfPostActuallyExistsById($id) {
    if (FALSE === get_post_status($id)) {    // The post does not exist	}
      return false;
    }
    return true;
  }

  public static function generateExtraButtonsForPlayerDeleteEdit($playerId) {
    global $dzsap, $post;
    $extra_buttons_html = '';


    if (isset($dzsap->mainoptions['dzsaap_enable_allow_users_to_edit_own_tracks'])) {

      // -- button to edit own tracks

//      print_rr($post);

      // todo: not sure if this is the way
//      if($post && ($post->post_type==DZSAP_REGISTER_POST_TYPE_NAME)){
//        $playerId = $post->ID;
//      }

      $id = '';

      if (DZSZoomSoundsHelper::checkIfPostActuallyExistsById($playerId)) {
        $extra_buttons_html .= ' <a rel="nofollow" data-type="iframe" data-source="' . admin_url('post.php') . '?post=' . $playerId . '&action=edit&remove-wp-admin-navigation=on" data-suggested-width="80vw" data-suggested-height="90vh" data-scaling="fill"  class="dzs-button-simple ultibox-item zoomsounds-portal--edit-track-btn" data-playerid="' . $playerId . '"><span class="btn-label">' . esc_html__('Edit', 'dzsap') . '</span></a>';
      }


      wp_enqueue_style('ultibox', $dzsap->base_url . 'libs/ultibox/ultibox.css');
      wp_enqueue_script('ultibox', $dzsap->base_url . 'libs/ultibox/ultibox.js');


    }


    $link = site_url();
    $link = dzs_add_query_arg($link, 'dzsap_action', 'delete_track');
    $link = dzs_add_query_arg($link, 'track_id', $playerId);

    // -- generate for .extra-btns-con

    if (DZSZoomSoundsHelper::checkIfPostActuallyExistsById($playerId)) {
      $extra_buttons_html .= ' <a rel="nofollow" onclick=\'if(!window.confirm("' . esc_html__('Are you sure you want to delete this track ?', 'dzsap') . ')){ return false; }"\' class="zoomsounds-delete-track-btn" href="' . $link . '" data-playerid="' . $playerId . '"><span class="btn-label">' . esc_html__('Delete', 'dzsap') . '</span></a>';
    }


    return $extra_buttons_html;

  }

  public static function sanitize_for_css_class($string) {
//    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
//    $string = str_replace('-', '_', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
  }

  public static function sanitize_for_one_word($string) {
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    $string = str_replace('-', '_', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }

  /** here we will detect video player configs and call parse_items To Be Continued...
   * audio player configuration setup
   * @param $term_name
   * @return $vpsettings['settings']
   */
  public static function getVpSettings($vpconfig_id, $margs = array()) {

    global $dzsap;
    $vpsettingsdefault = array(
      'id' => 'default',
      'skin_ap' => 'skin-wave',
      'skinwave_dynamicwaves' => 'off',
      'skinwave_enablespectrum' => 'off',
      'skinwave_enablereflect' => 'on',
      'skinwave_comments_enable' => 'off',
      'disable_volume' => 'default',
      'playfrom' => 'default',
      'enable_embed_button' => 'off',
      'loop' => 'off',
      'soundcloud_track_id' => '',
      'soundcloud_secret_token' => '',
      'cue_method' => 'on',
    );

    $vpsettings = array();

    $vpconfig_k = null;


    $tryToGetVpConfigDefault = DZSZoomSoundsHelper::getVpConfigFromConfigsDatabase(DZSAP_VPCONFIGS_DEFAULT_SETTINGS_NAME);

    if ($tryToGetVpConfigDefault !== null) {
      $vpsettingsdefault = $tryToGetVpConfigDefault['settings'];
//      print_rr($tryToGetVpConfigDefault);
    }

    // -- if we have config as array
    if (isset($margs['config']) && is_array($margs['config'])) {
      $vpsettings['settings'] = $margs['config'];
    } else {
      $tryToGetVpConfig = DZSZoomSoundsHelper::getVpConfigFromConfigsDatabase($vpconfig_id);


//      print_rr('$tryToGetVpConfig - '.print_r($tryToGetVpConfig,true));
      if ($tryToGetVpConfig !== null) {
        $vpsettings = $tryToGetVpConfig;
      } else {
        $vpsettings['settings'] = $vpsettingsdefault;
      }

      if (is_array($vpsettings) == false || is_array($vpsettings['settings']) == false) {
        $vpsettings = array('settings' => $vpsettingsdefault);
      }
    }

    if (isset($margs['config']) && $margs['config'] == 'temp123') {
      $vpsettings = get_option('dzsap_temp_vpconfig');
    }
//    print_rr('final vpsettings - '.print_r($vpsettings,true));

    return $vpsettings;
  }

  public static function getVpConfigFromConfigsDatabase($vpconfig_id) {
    global $dzsap;
    $vpconfig_k = null;

//    print_rr('$vpconfig_id - '.$vpconfig_id);
//    print_rr($dzsap->mainitems_configs);

    for ($i = 0; $i < count($dzsap->mainitems_configs); $i++) {
      if ((isset($vpconfig_id)) && isset($dzsap->mainitems_configs[$i]) && ($vpconfig_id == $dzsap->mainitems_configs[$i]['settings']['id'])) {
        $vpconfig_k = $i;
      }
    }

    if ($vpconfig_k !== null) {
      return $dzsap->mainitems_configs[$vpconfig_k];
    }

    return null;
  }

  public static function check_playlist_exists($term_name) {


    global $dzsap;

    $new_term_name = $term_name;
    $new_term_slug = $new_term_name;
    $tax = $dzsap->taxname_sliders;


    error_log('term_exists - ' . $new_term_name . ' --- ' . $tax . ' --- ' . print_r(term_exists($new_term_name, $tax), true));

    if (is_array(term_exists($new_term_name, $tax))) {
      error_log('term_exists 22 - ' . $new_term_name . ' --- ' . $tax . ' --- ' . print_r(term_exists($new_term_name, $tax), true) . is_array(term_exists($new_term_name, $tax)));
      return true;
    }
//    return term_exists( $new_term_name, $tax );


    return false;
  }

  public static function sanitize_item_for_parse_items($i, $che, $its) {


    global $dzsap;


    // -- sanitizing
    if (isset($che['wrapper_image']) == false || $che['wrapper_image'] == '') {
      if (isset($che['cover']) && $che['cover']) {
        $che['wrapper_image'] = $che['cover'];
      } else {
        $che['wrapper_image_type'] = '';
      }
    }


    $playerid = '';

    // -- let us assign default
    if ($che['songname']) {

    } else {
      $che['songname'] = 'default';

    }


    if ($che['artistname']) {

    } else {
      $che['artistname'] = 'default';
    }


    if ($che['songname'] == 'default') {
      if (isset($che['the_post_title']) && $che['the_post_title']) {

        $che['songname'] = $che['the_post_title'];
      }
      if ($che['menu_songname'] && $che['menu_songname'] != 'default' && $che['menu_songname'] != 'none') {

        $che['songname'] = $che['menu_songname'];
      }


    }

    if ($che['artistname'] == 'default') {
      if ($che['menu_artistname'] && $che['menu_artistname'] != 'default' && $che['menu_artistname'] != 'none') {
        $che['artistname'] = $che['menu_artistname'];
      }
    }


    $che['extra_html'] = str_replace('{{lsqb}}', '[', $che['extra_html']);
    $che['extra_html'] = str_replace('{{rsqb}}', ']', $che['extra_html']);


    if ($che['source'] && is_numeric($che['source'])) {
      $player_post_id = intval($che['source']);
      $player_post = get_post(intval($che['source']));


//                echo 'che[source] - > '.$che['source'].' ... ';
//                print_r($player_post);

      if ($player_post && $player_post->post_type == 'attachment') {
        $media = wp_get_attachment_url($player_post_id);

        $che['source'] = $media;
        if (isset($playerid)) {

        } else {
          $playerid = $player_post_id;
          $che['playerid'] = $player_post_id;
        }

//                    print_r($media);
      }


      if (isset($che['ID']) && $che['playerid'] == false && is_numeric($che['ID'])) {
        $che['playerid'] = $che['ID'];
      }


      if (isset($its['settings']['js_settings_extrahtml_in_float_right_from_config']) && $its['settings']['js_settings_extrahtml_in_float_right_from_config']) {

        if (isset($che['extra_html_in_controls_right']) && $che['extra_html_in_controls_right']) {


//		            echo 'whyyyy ? ';

        } else {

          // -- we set extra html in controls right for che but what does that help us with ?
          $its['settings']['js_settings_extrahtml_in_float_right_from_config'] = str_replace('{{singlequot}}', '\'', $its['settings']['js_settings_extrahtml_in_float_right_from_config']);
          $che['extra_html_in_controls_right'] = stripslashes($its['settings']['js_settings_extrahtml_in_float_right_from_config']);
        }
      }


      if (isset($its['settings']['js_settings_extrahtml_in_bottom_controls_from_config']) && $its['settings']['js_settings_extrahtml_in_bottom_controls_from_config']) {

        if (isset($che['extra_html_in_bottom_controls']) && $che['extra_html_in_bottom_controls']) {

        } else {

          $che['extra_html_in_bottom_controls'] = $dzsap->sanitize_from_meta_textarea($its['settings']['js_settings_extrahtml_in_bottom_controls_from_config']);
        }
      }
    }


    if (isset($che['playerid']) && $che['playerid'] != '') {
      $playerid = $che['playerid'];
    }


    if ($playerid == '' && isset($che['linktomediafile']) && $che['linktomediafile'] != '') {
      $playerid = $che['linktomediafile'];
    }


    $po = null;


    if ($playerid) {
      $po = get_post($playerid);
//                print_r($po);


      $meta = wp_get_attachment_metadata($playerid);


//                echo 'meta ( '.$playerid.' ) - '; print_rr($meta);
//                echo 'post ( '.$playerid.' ) - '; print_rr($po);


      // -- found player ID end


//	            print_rr($che);


      if ($dzsap->mainoptions['try_to_hide_url'] == 'on') {

      }


//                print_rr($che);


      // -- we need to get source from library on mediafile
      if ($che['type'] == 'mediafile') {
        $che['source'] = '';
      }


      // -- from mediafile
      if (@wp_get_attachment_url($playerid)) {
        if ($che['source'] == '') {

          $che['source'] = @wp_get_attachment_url($playerid);
        }
      }
//                print_rr($che);

      if ($che['source'] == '' && $po) {
        $che['source'] = $po->guid;
//                    print_r($che);
      }


      if ((!isset($che['artistname_from_meta']) || $che['artistname_from_meta'] == '')) {
//                    print_r($meta);
//                    print_r($meta['artist']);


        if (isset($meta['artist'])) {

          $che['artistname_from_meta'] = $meta['artist'];
        }
      };


      if ((!isset($che['songname_from_meta']) || $che['songname_from_meta'] == '')) {
//                    print_r($meta);
//                    print_r($meta['artist']);


        if (isset($meta['title'])) {

          $che['songname_from_meta'] = $meta['title'];
        }
      };
      if ((!isset($che['publisher']) || $che['publisher'] == '')) {
//                    print_r($meta);
//                    print_r($meta['artist']);


        if (isset($meta['publisher'])) {

          $che['publisher'] = $meta['publisher'];
        }
      };


      // -- @deprecated
      if ((!isset($che['waveformbg']) || $che['waveformbg'] == '') && $po && get_post_meta($po->ID, '_waveformbg', true) != '') {
        $che['waveformbg'] = get_post_meta($po->ID, '_waveformbg', true);
      };


      if ((!isset($che['waveformprog']) || $che['waveformprog'] == '') && $po && get_post_meta($po->ID, '_waveformprog', true) != '') {
        $che['waveformprog'] = get_post_meta($po->ID, '_waveformprog', true);
      };
      // -- @deprecated waveform jpeg END


      if ((isset($che['thumb']) == false || $che['thumb'] == '') && isset($po)) {


//                    $che['thumb'] = get_post_meta($po->ID, '_dzsap-thumb', true);

        if (get_post_meta($po->ID, '_dzsap-thumb', true)) {

          $che['thumb'] = get_post_meta($po->ID, '_dzsap-thumb', true);
        } else {

        }
      };


      if ($che['sourceogg'] == '' && isset($po) && get_post_meta($po->ID, '_dzsap_sourceogg', true) != '') {
        $che['sourceogg'] = get_post_meta($po->ID, '_dzsap_sourceogg', true);
      };
    }


    if ($dzsap->mainoptions['try_to_hide_url'] == 'on' && ((isset($che['linktomediafile']) && $che['linktomediafile']) || is_int($playerid) || (isset($che['product_id']) && $che['product_id']))) {

      $nonce = rand(0, 10000);


      $id_for_nonce = '';


      if (is_int($playerid)) {
        $id_for_nonce = $playerid;
      } else {

        if ((isset($che['product_id']) && $che['product_id'])) {
          $id_for_nonce = $che['product_id'];
        }

      }


//                    print_rr($_SERVER);

      $lab = 'dzsap_nonce_for_' . $id_for_nonce . '_ip_' . $_SERVER['REMOTE_ADDR'];

      $lab = DZSZoomSoundsHelper::sanitize_for_one_word($lab);


//                    $_SESSION[$lab] = $nonce;


      $nonce = '{{generatenonce}}';


//                    print_r($_SESSION);

      $src = site_url() . '/index.php?dzsap_action=generatenonce&id=' . $id_for_nonce . '&' . $lab . '=' . $nonce;

      $che['source'] = $src;
    }


//	        echo '$che1 - '; print_rr($che);

//	        $dzsap->get_post_meta_all($playerid);

    if (isset($che['artistname_from_meta'])) {
      if ($che['artistname_from_meta'] && $che['artistname_from_meta'] != 'default') {
        if ($che['artistname'] == '' || $che['artistname'] == 'default') {
          $che['artistname'] = $che['artistname_from_meta'];
        }
      }
    }

//            echo 'che her - '; print_rr($che);


//            echo 'post meta all'; print_rr(get_post_meta($playerid));

    if ($che['songname'] == 'default' || $che['songname'] == '') {

      if (get_post_meta($playerid, 'songname', true)) {
        $che['songname'] = get_post_meta($playerid, 'songname', true);
      } else {

//                    echo 'whaaa';
        if (get_post_meta($playerid, 'dzsap_meta_replace_songname', true)) {
          $che['songname'] = get_post_meta($playerid, 'dzsap_meta_replace_songname', true);
        } else {

          if ($po) {


            // -- parse item get forom post_title
//              print_rr($che);
            if ($po->post_title) {
              if (isset($che['title_is_permalink']) && $che['title_is_permalink'] == 'on') {

                $che['songname'] = ' <a rel="nofollow" href="' . get_permalink($po->ID) . '">' . $po->post_title . '</a>';
              } else {

                $che['songname'] = $po->post_title;
              }
            }

          } else {

            if (isset($che['linktomediafile']) && $che['linktomediafile']) {
              $po_att = get_post($che['linktomediafile']);

              if ($po_att->post_title) {
                $che['songname'] = $po_att->post_title;
              }
            }
          }
        }
      }


    }
    if ($che['artistname'] == 'default') {


      if (get_post_meta($playerid, 'artistname', true)) {
        $che['artistname'] = get_post_meta($playerid, 'artistname', true);
      } else {
        if (get_post_meta($playerid, 'dzsap_meta_replace_artistname', true)) {
          $che['artistname'] = get_post_meta($playerid, 'dzsap_meta_replace_artistname', true);
        } else {

          if (isset($che['linktomediafile']) && $che['linktomediafile']) {
            $po_att = get_post($che['linktomediafile']);

//                    print_rr($po_att);
            $user_info = get_userdata($po_att->post_author);
            if ($user_info->user_login) {
              $che['artistname'] = $user_info->user_login;
            }
          }
        }
      }


    }

    if (isset($che['songname_from_meta'])) {
      if ($che['songname_from_meta'] && $che['songname_from_meta'] != 'default') {

        if ($che['songname'] === '' || $che['songname'] == 'default') {

          $che['songname'] = $che['songname_from_meta'];
        }
      }
    }
    //print_r($che);
    $che['menu_artistname'] = stripslashes($che['menu_artistname']);
    $che['menu_songname'] = stripslashes($che['menu_songname']);

    if ($che['menu_songname'] === '' || $che['menu_songname'] == 'default') {
      $che['menu_songname'] = $che['songname'];
    }
    if ($che['menu_artistname'] === '' || $che['menu_artistname'] == 'default') {
      $che['menu_artistname'] = $che['artistname'];
    }


    if ($che['songname'] == 'none' || $che['songname'] == 'default') {
      $che['songname'] = '';
    }
    if ($che['artistname'] == 'none' || $che['artistname'] == 'default') {
      $che['artistname'] = '';
    }
    if ($che['menu_songname'] == 'none' || $che['menu_songname'] == 'default') {
      $che['menu_songname'] = '';
    }
    if ($che['menu_artistname'] == 'none' || $che['menu_artistname'] == 'default') {
      $che['menu_artistname'] = '';
    }


    if ($che['menu_artistname'] == 'default') {


      if ($che['artistname']) {
        $che['menu_artistname'] = $che['artistname'];
      } else {
        if ($playerid) {


          $che['menu_artistname'] = $po->post_title;
        }
      }


    }


    if ($che['menu_songname'] == 'default') {

      if ($che['songname']) {
        $che['menu_songname'] = $che['songname'];
      } else {
        if ($playerid) {


          if ($po->post_content) {
            $che['menu_songname'] = $po->post_content;
          }


          if ($po->post_excerpt) {
            $che['menu_songname'] = $po->post_excerpt;
          }

          if ($po->post_type == 'attachment') {
            $po_metadata = wp_get_attachment_metadata($playerid);

            //                        print_r($po_metadata);
          }

        }

      }
    }
    if ($che['menu_artistname'] == 'default') {


      $che['menu_artistname'] = '';
    }
    if ($che['menu_songname'] == 'default') {
      $che['menu_songname'] = '';
    }


//	        echo 'che after songname and artist name replace - '; print_rr($che);


    return $che;

//    return false;
  }
}

function dzsap_register_links() {

  global $dzsap;


  register_taxonomy(DZSAP_REGISTER_POST_TYPE_CATEGORY, DZSAP_REGISTER_POST_TYPE_NAME, array('label' => __('Audio Categories', 'dzsap'), 'query_var' => true, 'show_ui' => true, 'hierarchical' => true, 'rewrite' => array('slug' => $dzsap->mainoptions['dzsap_categories_rewrite']),));


  register_taxonomy(DZSAP_REGISTER_POST_TYPE_TAGS, DZSAP_REGISTER_POST_TYPE_NAME, array('label' => __('Song tags', 'dzsap'), 'query_var' => true, 'show_ui' => true, 'hierarchical' => false, 'rewrite' => array('slug' => $dzsap->mainoptions['dzsap_tags_rewrite']),));


  $labels = array(
    'name' => esc_html__('Audio galleries', 'dzsap'),
    'singular_name' => esc_html__('Audio gallery', 'dzsap'),
    'search_items' => esc_html__('Search galleries', 'dzsap'),
    'all_items' => esc_html__('All galleries', 'dzsap'),
    'parent_item' => esc_html__('Parent gallery', 'dzsap'),
    'parent_item_colon' => esc_html__('Parent gallery', 'dzsap'),
    'edit_item' => esc_html__('Edit gallery', 'dzsap'),
    'update_item' => esc_html__('Update gallery', 'dzsap'),
    'add_new_item' => esc_html__('Add playlist', 'dzsap'),
    'new_item_name' => esc_html__('New gallery name', 'dzsap'),
    'menu_name' => esc_html__('Galleries', 'dzsap'),


  );


  $cap_manage_terms = $dzsap->taxname_sliders . '_manage_categories';

  if (current_user_can('manage_options')) {
    $cap_manage_terms = 'manage_options';
  }

  register_taxonomy($dzsap->taxname_sliders, DZSAP_REGISTER_POST_TYPE_NAME, array(

    'label' => esc_html__('Audio Playlists', 'dzsap'),
    'labels' => $labels,
    'query_var' => true,
    'show_ui' => true,
    'hierarchical' => false,
    'rewrite' => array('slug' => $dzsap->mainoptions['dzsap_sliders_rewrite']),
    'show_in_menu' => false,
    'capabilities' => array(
      'manage_terms' => $cap_manage_terms,
      'edit_terms' => $cap_manage_terms,
      'delete_terms' => $cap_manage_terms,
      'assign_terms' => $cap_manage_terms,
    ),
  ));


//        add_action( 'dzsap_sliders_add_tag_form_fields', 'add_feature_group_field', 10, 2 );
  add_action('category_edit_form_fields', 'dzsap_term_meta_fields', 10, 10);


//        add_action( 'dzsap_sliders_add_form_fields', 'add_feature_group_field', 10, 2 );
//        add_action( 'dzsap_sliders_edit_form_fields', 'add_feature_group_field', 10, 10
  add_action('edited_category', 'dzsap_save_taxonomy_custom_meta', 10, 2);

//        add_action( 'created_dzsap_sliders', 'save_feature_meta', 10, 2 );
//        add_action( 'edited_dzsap_sliders', 'save_feature_meta', 10, 2 );


  $labels = array('name' => esc_html__('Audio Items', 'dzsap'), 'singular_name' => esc_html__('Audio Item', 'dzsap'),);

  $permalinks = get_option('dzsap_permalinks');
  //print_r($permalinks);

  $item_slug_permalink = empty($permalinks['item_base']) ? _x('audio', 'slug', 'dzsap') : $permalinks['item_base'];


  $exclude_from_search = false;

  if (isset($dzsap->mainoptions['exclude_from_search']) && $dzsap->mainoptions['exclude_from_search'] == 'on') {
    $exclude_from_search = true;
  }


  $post_supports = array('title', 'editor', 'author', 'thumbnail', 'post-thumbnail', 'comments', 'excerpt', 'custom-fields');
  // -- todo: allow custom-fields in developer mode
  $args = array('labels' => $labels, 'public' => true, 'has_archive' => true, 'hierarchical' => false,
    'supports' => $post_supports,

    'show_in_menu' => true, 'rewrite' => array('slug' => $item_slug_permalink),
    'yarpp_support' => true,
    'show_ui' => true,
    'exclude_from_search' => $exclude_from_search,
    'capability_type' => 'post',

    'capabilities' => array(
      'edit_post' => 'edit_' . DZSAP_REGISTER_POST_TYPE_NAME,
      'edit_posts' => 'edit_' . DZSAP_REGISTER_POST_TYPE_NAME . 's',
    ),
    //'taxonomies' => array('categoryportfolio'),
  );

  if (current_user_can('manage_options')) {

    if (!current_user_can('edit_' . DZSAP_REGISTER_POST_TYPE_NAME)) {

      $role = get_role('administrator');
      $role->add_cap('edit_' . DZSAP_REGISTER_POST_TYPE_NAME);
      $role->add_cap('edit_' . DZSAP_REGISTER_POST_TYPE_NAME . 's');

    }
  }

  register_post_type(DZSAP_REGISTER_POST_TYPE_NAME, $args);
}


function dzsap_term_meta_fields($term) {
  // this will add the custom meta field to the add new term page

  $t_id = $term->term_id;

  // retrieve the existing value(s) for this meta field. This returns an array
  $term_meta = get_option("taxonomy_$t_id");

  $tem = array(
    'name' => 'feed_xml',
    'no_preview' => 'default',
    'title' => __('XML Feed'),
  );

  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label
        for="term_meta[<?php echo $tem['name']; ?>]"><?php echo $tem['title']; ?></label></th>
    <td class="<?php
    if (isset($tem['type']) && $tem['type'] == 'media-upload') {
      echo 'setting-upload';
    }
    ?>">


      <?php


      if (isset($tem['type']) && $tem['type'] == 'media-upload') {
        if ($tem['no_preview'] != 'on') {
          echo '<span class="uploader-preview"></span>';
        }

      }
      ?>



      <?php
      $lab = 'term_meta[' . $tem['name'] . ']';

      $val = '';

      if (isset($term_meta[$tem['name']])) {

        $val = esc_attr($term_meta[$tem['name']]) ? esc_attr($term_meta[$tem['name']]) : '';
        $val = stripslashes($val);
      }

      $class = 'setting-field medium';


      if (isset($tem['type']) && $tem['type'] == 'media-upload') {
        $class .= ' uploader-target';
      }

      //                echo DZSHelpers::generate_input_text($lab, array(
      //                    'class'=>$class,
      //                    'seekval'=>$val,
      //                    'id'=>$lab,
      //                ));

      echo DZSHelpers::generate_input_textarea($lab, array(
        'class' => $class,
        'seekval' => $val,
        'extraattr' => ' style="width: 100%; " rows="5"',
        'id' => $lab,
      ));


      ?>
      <?php

      ?>
      <p class="description"><?php _e('Enter a value for this field', 'pippin'); ?></p>
    </td>
  </tr>
  <?php
}


function dzsap_save_taxonomy_custom_meta($term_id) {
  if (isset($_POST['term_meta'])) {
    $t_id = $term_id;
    $term_meta = get_option("taxonomy_$t_id");
    $cat_keys = array_keys($_POST['term_meta']);
    foreach ($cat_keys as $key) {
      if (isset ($_POST['term_meta'][$key])) {
        $term_meta[$key] = $_POST['term_meta'][$key];
      }
    }
    // Save the option array.
    update_option("taxonomy_$t_id", $term_meta);
  }
}

function dzsap_sliders_save_taxonomy_custom_meta($term_id) {


//		error_log('trying to save term meta '.$term_id);
//		error_log(print_rr($_POST,array('echo'=>false)));
  if (isset($_POST['term_meta'])) {
    $t_id = $term_id;
    $term_meta = get_option("taxonomy_$t_id");
    $cat_keys = array_keys($_POST['term_meta']);
    foreach ($cat_keys as $key) {
      if (isset ($_POST['term_meta'][$key])) {
        $term_meta[$key] = $_POST['term_meta'][$key];
      }
    }
    // Save the option array.
    update_option("taxonomy_$t_id", $term_meta);
  }
}


function dzsap_enqueue_fontawesome() {

  global $dzsap;

  $url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

  if ($dzsap->mainoptions['fontawesome_load_local'] == 'on') {
    $url = $dzsap->base_url . 'libs/fontawesome/font-awesome.min.css';
  }


  wp_enqueue_style('fontawesome', $url);
}


function dzsap_misc_input_text($argname, $pargs = array()) {
  $fout = '';

  $margs = array('type' => 'text', 'class' => '', 'seekval' => '', 'extra_attr' => '',);


  $margs = array_merge($margs, $pargs);

  $type = 'text';
  if (isset($margs['type'])) {
    $type = $margs['type'];
  }
  $fout .= '<input type="' . $type . '"';
  if (isset($margs['class'])) {
    $fout .= ' class="' . $margs['class'] . '"';
  }
  $fout .= ' name="' . $argname . '"';
  if (isset($margs['seekval'])) {
    $fout .= ' value="' . $margs['seekval'] . '"';
  }

  $fout .= $margs['extra_attr'];

  $fout .= '/>';
  return $fout;
}

function dzsap_misc_input_textarea($argname, $otherargs = array()) {
  $fout = '';
  $fout .= '<textarea';
  $fout .= ' name="' . $argname . '"';

  $margs = array(
    'class' => '',
    'val' => '', // === default value
    'seekval' => '', // ===the value to be seeked
    'type' => '',
  );
  $margs = array_merge($margs, $otherargs);


  if ($margs['class'] != '') {
    $fout .= ' class="' . $margs['class'] . '"';
  }
  $fout .= '>';
  if (isset($margs['seekval']) && $margs['seekval'] != '') {
    $fout .= '' . $margs['seekval'] . '';
  } else {
    $fout .= '' . $margs['val'] . '';
  }
  $fout .= '</textarea>';

  return $fout;
}

function dzsap_misc_generate_upload_btn($pargs = array()) {

  global $dzsap;
  $margs = array(
    'label' => 'Upload'
  );

  if ($pargs == '' || is_array($pargs) == false) {
    $pargs = array();
  }

  $margs = array_merge($margs, $pargs);

  $uploadbtnstring = '<button class="button-secondary action upload_file ">' . $margs['label'] . '</button>';


  if ($dzsap->mainoptions['usewordpressuploader'] != 'on') {
    $uploadbtnstring = '<div class="dzs-upload">
<form name="upload" action="#" method="POST" enctype="multipart/form-data">
    	<input type="button" value="' . $margs['label'] . '" class="btn_upl"/>
        <input type="file" name="file_field" class="file_field"/>
        <input type="submit" class="btn_submit"/>
</form>
</div>
<div class="feedback"></div>';
  }

  return $uploadbtnstring;
}


function dzsap_misc_get_ip() {

  if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
  }

  $ip = filter_var($ip, FILTER_VALIDATE_IP);
  $ip = ($ip === false) ? '0.0.0.0' : $ip;


  return $ip;
}

function dzsap_create_user($user_name, $user_email) {
  $user_id = 0;
  $user_id = username_exists($user_name);
  if (!$user_id and email_exists($user_email) == false) {
    $random_password = 'test';
    $user_id = wp_create_user($user_name, $random_password, $user_email);
    update_option('dzsapp_portal_user', $user_id);
  } else {
    $random_password = __('User already exists.  Password inherited.');
  }

  return $user_id;
}


function dzsap_powerpress_shortcode_player() {


  global $powerpress_feed, $dzsap, $post;
  //            print_rr($powerpress_feed);

  // PowerPress settings:
  $GeneralSettings = get_option('powerpress_general');
  //                print_rr($GeneralSettings);


  $feed_slug = 'podcast';


  $EpisodeData = null;
  if (function_exists('powerpress_get_enclosure_data')) {

    $EpisodeData = powerpress_get_enclosure_data($post->ID, $feed_slug);
  }

  //            print_rr($EpisodeData);


  if ($EpisodeData && isset($EpisodeData['url'])) {


    //            echo 'whaaa';
    $dzsap->sliders__player_index++;

    //                $fout = '';


    $src = get_post_meta($post->ID, 'dzsap_woo_product_track', true);


    $dzsap->front_scripts();

    $margs = dzsap_powerpress_generate_margs();


    $args = array();

    $margs['called_from'] = 'pooowerpress';
    $aux = $dzsap->shortcode_player($margs);


    return $aux;


  }

}


function dzsap_powerpress_filter_content($fout) {

  global $post, $powerpress_feed;

  global $dzsap;
//            print_rr($powerpress_feed);

// PowerPress settings:
  $GeneralSettings = get_option('powerpress_general');
//                print_rr($GeneralSettings);


  $feed_slug = 'podcast';


  $EpisodeData = null;
  if (function_exists('powerpress_get_enclosure_data')) {

    $EpisodeData = powerpress_get_enclosure_data($post->ID, $feed_slug);
  }

//            print_rr($EpisodeData);


  if ($EpisodeData && isset($EpisodeData['url'])) {


//            echo 'whaaa';
    $dzsap->sliders__player_index++;

//                $fout = '';


    $src = get_post_meta($post->ID, 'dzsap_woo_product_track', true);


    $dzsap->front_scripts();

    $margs = dzsap_powerpress_generate_margs();


    $args = array();

    $margs['autoplay'] = 'off';
    $aux = $dzsap->shortcode_player($margs);


    return $aux . $fout;


  }

  return $fout;
}

function dzsap_powerpress_get_enclosure_data($feed_slug) {
  global $post, $dzsap;

  $EpisodeData = powerpress_get_enclosure_data($post->ID, $feed_slug);

  //            print_rr($EpisodeData);


  if ($EpisodeData && isset($EpisodeData['url'])) {


    //            echo 'whaaa';
    $dzsap->sliders__player_index++;

    //                $fout = '';


    $src = get_post_meta($post->ID, 'dzsap_woo_product_track', true);


    $dzsap->front_scripts();

    $margs = dzsap_powerpress_generate_margs();


    //        $enc_margs = simple_encrypt(json_encode($margs),'1111222233334444');
    //        $enc_margs = gzcompress(json_encode($embed_margs),9);
    $enc_margs = json_encode($margs);
    $enc_margs = base64_encode(json_encode($margs));
    //        $enc_margs = base64_decode(base64_encode(json_encode($embed_margs)));

    //        $embed_code = '<iframe src=\'' . $dzsap->base_url . 'bridge.php?type=player&margs='.urlencode($enc_margs).'\' style="overflow:hidden; transition: height 0.3s ease-out;" width="100%" height="152" scrolling="no" frameborder="0"></iframe>';


    $embed_url = site_url() . '?action=embed_zoomsounds&type=player&margs=' . urlencode($enc_margs);
    $embed_code = '<iframe src=\'' . $embed_url . '\' style="overflow:hidden; transition: height 0.3s ease-out;" width="100%" height="152" scrolling="no" frameborder="0"></iframe>';


    ?>
    <meta name="twitter:card" content="player">
    <meta name="twitter:site" content="@youtube">
    <meta name="twitter:url" content="<?php echo get_permalink($post->ID); ?>">
    <meta name="twitter:title" content="<?php echo get_permalink($post->post_title); ?>">
    <meta name="twitter:description" content="<?php echo get_permalink($post->post_content); ?>">
    <meta name="twitter:image" content="">
    <meta name="twitter:app:name:iphone" content="<?php echo get_permalink($post->ID); ?>">
    <meta name="twitter:app:name:googleplay" content="<?php echo get_permalink($post->post_title); ?>">
    <meta name="twitter:player" content="<?php echo $embed_url; ?>">
    <meta name="twitter:player:width" content="1280">
    <meta name="twitter:player:height" content="300"><?php


  }
}

function dzsap_powerpress_generate_margs() {

  global $post, $dzsap;

  global $powerpress_feed;
//            print_rr($powerpress_feed);

// PowerPress settings:
  $GeneralSettings = get_option('powerpress_general');
//                print_rr($GeneralSettings);


  $feed_slug = 'podcast';

  $margs = array();

  $EpisodeData = powerpress_get_enclosure_data($post->ID, $feed_slug);

//            print_rr($EpisodeData);


  if ($EpisodeData && isset($EpisodeData['url'])) {


//            echo 'whaaa';
    $dzsap->sliders__player_index++;

//                $fout = '';


    $src = get_post_meta($post->ID, 'dzsap_woo_product_track', true);


    $dzsap->front_scripts();

    $margs = array('config' => 'powerpress_player',);

//        $margs = array_merge($margs, $atts);

//        print_r($margs);
    $margs['source'] = $EpisodeData['url'];
    $margs['called_from'] = 'powerpress';
    $margs['playerid'] = $post->ID;
    $margs['config'] = 'powerpress_player';
    $margs['artistname'] = $post->post_title;
//            $margs['js_settings_extrahtml_in_float_right'] = '<div><span class="display-inline-block">Share:</span>&nbsp;&nbsp;&nbsp;<div class="display-inline-block dzstooltip-con" style=";"><div class="the-icon-bg"></div> <span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right" style="width: auto; white-space: nowrap;">Share on Twitter</span><i class=" svg-icon fa fa-twitter" style="color: #5aacff;"></i></div>   <div class="display-inline-block dzstooltip-con" style=";"><div class="the-icon-bg"></div> <span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right" style="width: auto; white-space: nowrap;">Share on Facebook</span><i class=" svg-icon fa fa-facebook-square" style="color: #2288ff;"></i></div> </div><br><a class="button-grad " href="{{meta2val}}">                                        <i class="fa fa-apple"></i>                                        <span class="i-label">iTunes</span>                                    </a>  <a class="button-grad " href="{{meta1val}}">                                        <i class="fa fa-rss"></i>                                        <span class="i-label">RSS</span>                                    </a>  <a class="button-grad dzsap-multisharer-but " href="#">                                        <i class="fa fa-share "></i>                                        <span class="i-label">Embed</span>                                    </a>  ';

    if (get_the_post_thumbnail_url($post)) {

      $margs['thumb'] = get_the_post_thumbnail_url($post);
    }


    $categories = get_the_terms($post->ID, 'category');

//            print_rr($post);
//            print_rr($categories);
    if (!$categories || is_wp_error($categories))
      $categories = array();

    $categories = array_values($categories);


    if (count($categories)) {


    }
    foreach ($categories as $key => $val) {
//                print_rr($val);


      // Get the URL of this category
      $category_link = get_category_link($val->term_id);

//                print_rr($category_link);
//                libxml_use_internal_errors(false);
//                $myXMLData = DZSHelpers::get_contents($category_link.'feed');


      global $dzsap_got_category_feed;


      $lasttime = get_option('dzsap_last_read_category');

//                echo 'lasttime - '.$lasttime.'<br>';
//                echo 'lasttime ... time()-8 -> '.($lasttime-8).'<br>';
//                echo 'time() - '.time().'<br>';
//                echo 'lasttime==false - '.$lasttime==false.'<br>';
//                echo 'lasttime ... time()-8 - '.(($lasttime<time())-8).'<br>';


      $myXMLData = '';

      if (get_option('taxonomy_' . $val->term_id)) {
        $aux = get_option('taxonomy_' . $val->term_id);

//                    print_rr($aux);

        if (isset($aux['feed_xml'])) {
          $myXMLData = $aux['feed_xml'];
        }


        $myXMLData = stripslashes($myXMLData);
      }


      if ($myXMLData == '' && $dzsap->mainoptions['powerpress_read_category_xml'] == 'on' && ($lasttime == false || $lasttime < time() - 15)) {


        if ($dzsap->debug) {

          print_rr($category_link . 'feed');
        }
        update_option('dzsap_last_read_category', time());
        $myXMLData = @file_get_contents($category_link . 'feed');
//                    $myXMLData = @file_get_contents('https://www.almightyballer.com/category/a-team/buzz-beat/feed/');
//                    $myXMLData = DZSHelpers::get_contents('https://www.almightyballer.com/category/a-team/buzz-beat/feed/');


//                    echo file_get_contents('https://www.almightyballer.com/category/a-team/buzz-beat/feed/');

        if ($dzsap->debug) {
          echo '<pre class="hmm">';
          print_r($myXMLData);
          echo '</pre>';
        }

//                    echo 'yes';

        $dzsap_got_category_feed = true;

      }

      if ($myXMLData) {

//                    print_rr($myXMLData);

        if (strpos($myXMLData, '<?xml') !== false && strpos($myXMLData, '<?xml') < 30) {

//                        $myXMLData=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $myXMLData);;


          try {
//                            $xml = simplexml_load_string($myXMLData);


//                        echo '<pre class="the-xml">';print_r($xml);echo '</pre>';

            preg_match_all("/<itunes:image href=\"(.*?)\"/", $myXMLData, $output_array);;

            if (count($output_array[1])) {
              $margs['thumb'] = $output_array[1][0];

            }

            preg_match_all("/\<title\>(.*?)<\/title>/", $myXMLData, $output_array);

            if (count($output_array[1])) {
              $margs['songname'] = $output_array[1][0];

            }


//                            if($xml){
//
//
//                                if($xml->channel->image[1]->url->__toString()){
//                                    $margs['thumb']=$xml->channel->image[1]->url->__toString();
//                                }
//
//                                if($xml->channel->title->__toString()){
//                                    $margs['songname']=$xml->channel->title->__toString();
//                                }
//
//
//
//
//                            }
          } catch (Exception $e) {
            echo 'xml error';
            error_log(print_rrr($e));
          }

        }

        $margs['cat_feed_data'] = $myXMLData;


      }

    }

  }


  return $margs;


}

function dzsap_admin_meta_download_waveforms() {

  global $post, $dzsap;

  $po_id = $post->ID;

  $aux = '';
  $uploadbtnstring = '<button class="button-secondary action upload_file ">' . esc_html__('Upload', 'dzsap') . '</button>';


  if ($dzsap->mainoptions['skinwave_wave_mode'] != 'canvas') {

    $lab = 'dzsap_meta_waveformbg';
    $val = get_post_meta($po_id, $lab, true);

    $aux .= '<div class="setting type_all type_mediafile_hide">
            <h4 class="setting-label">' . __('WaveForm Background Image', 'dzsap') . '</h4>
' . DZSHelpers::generate_input_text($lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . ' <span class="aux-wave-generator"><button class="btn-autogenerate-waveform-bg button-secondary">' . __("Auto Generate") . '</button></span>
            <div class="sidenote">' . __('Optional waveform image / ', 'dzsap') . ' / ' . __('Only for skin-wave', 'dzsap') . '</div>
        </div>';


    //simple with upload and wave generator
    $lab = 'dzsap_meta_waveformprog';
    $val = get_post_meta($po_id, $lab, true);

    $aux .= '<div class="setting type_all type_mediafile_hide">
            <h4 class="setting-label">' . __('WaveForm Progress Image', 'dzsap') . '</h4>
' . DZSHelpers::generate_input_text($lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . ' <span class="aux-wave-generator"><button class="btn-autogenerate-waveform-prog button-secondary">Auto Generate</button></span>
            <div class="sidenote">' . __('Optional waveform image / ', 'dzsap') . ' / ' . __('Only for skin-wave', 'dzsap') . '</div>
        </div>';
  }

  echo $aux;
}


function dzsap_sanitize_to_extra_html($extra_html, $po = null) {


  global $dzsap;
  $playerid = 0;


  if ($po) {
    if (isset($po->ID)) {

      $playerid = $po->ID;
    }
    if (isset($po['playerid'])) {
      $playerid = $po['playerid'];
    }
  }


//		echo 'playerid - '.$playerid;

//        echo '$extra_html - '.$extra_html; echo ' ||| ';

  $extra_html = str_replace('{{theid}}', $playerid, $extra_html);


//		echo '$extra_html after - '.$extra_html; echo ' ||| *** ||| ';


  $icon_wishlist = 'fa-heart-o';
  if (strpos($extra_html, '{{audio_love_toggler_icon}}') !== false) {

    //	        $arr_wishlist= $dzsap->get_wishlist();


    global $dzsap;

    //            print_rr($dzsap);

//		    echo 'playerid - '.$playerid;
    if ($dzsap && $dzsap->check_if_user_liked_track($playerid)) {
      $icon_wishlist = str_replace('fa-heart-o', 'fa-heart', $icon_wishlist);
    }


    //	        echo '$arr_wishlist - '; print_rr($arr_wishlist);
    //	        if(in_array($po->ID,$arr_wishlist)){
    //	        }
    $extra_html = str_replace('{{audio_love_toggler_icon}}', $icon_wishlist, $extra_html);
  }


  $extra_html = str_replace('{{hearts_svg}}', $dzsap->general_assets['hearts_svg'], $extra_html);
  $extra_html = str_replace('{{site_url}}', site_url(), $extra_html);

  $permalink = '';
  if (isset($po) && $po && isset($po->ID) && $po->ID) {
    $permalink = get_permalink($po->ID);
  }
  $extra_html = str_replace('{{itempermalink}}', $permalink, $extra_html);

  return $extra_html;
}

function dzsap_get_songname_from_attachment($che) {


  $songname = '';
  $attachment_id = '';
//			            print_rr($che);

  if (isset($che['dzsap_meta_source_attachment_id']) && $che['dzsap_meta_source_attachment_id']) {
//			                print_rr($che);
    $attachment_id = $che['dzsap_meta_source_attachment_id'];

  } else {
    if ($che && isset($che['ID']) && $che['ID']) {
      $attachment_id = get_post_meta($che['ID'], 'dzsap_meta_source_attachment_id', true);
    }
  }

  if ($attachment_id) {


    $att = get_post($attachment_id);

//			                echo 'att - <hr>';print_rr($att);


    if (isset($att->post_title) && $att->post_title) {
      $songname = $att->post_title;
    }
  }


  return $songname;
}

function dzsap_sanitize_from_extra_html_props($str, $argPlayerId = '', $che = null) {

  global $dzsap;

  $fout = $str;
  $download_link = '';
  $permalink = '';
  $playerId = '';


  if (!$argPlayerId) {
    if ($che) {
      if ($che['playerid']) {
        $playerId = $che['playerid'];
      }
    }
  } else {
    $playerId = $argPlayerId;
  }
//		            echo 'we hot here';
  if ($playerId) {
    $download_link = dzsap_get_download_link($che, $playerId);
  }


  if (get_permalink($playerId)) {
    $permalink = get_permalink($playerId);
  }

//                    echo '$che[\'extra_html_in_controls_right\'] - '.$che['extra_html_in_controls_right'];

//    error_log('che - '.print_r($che, true));

//    print_rr($che);

  // -- if we have not attached productid, then productid is just playerid
  $productid = $playerId;


  if (isset($che['product_id']) && $che['product_id']) {

    $productid = $che['product_id'];
  } else {
    $allmeta = get_post_meta($playerId);

    $lab = 'dzsap_meta_productid';
    if (isset($allmeta[$lab]) && $allmeta[$lab] && isset($allmeta[$lab][0]) && $allmeta[$lab][0]) {

      $productid = $allmeta[$lab][0];
    }

  }


//    echo 'productid -4 '.$productid;


  if (strpos($fout, 'replacewithproductid') !== false) {
//      error_log('meta che - '.print_r($allmeta, true).' fout - '.$fout);

    $lab = 'dzsap_meta_productid';
//      if(isset($allmeta[$lab]) && $allmeta[$lab] && isset($allmeta[$lab][0])){
    $fout = str_replace('{{replacewithproductid}}', $productid, $fout);
//      }

  }


  $fout = str_replace('{{addtocart}}', add_query_arg(array(
    'add-to-cart' => $productid
  ), dzs_curr_url()), $fout);
  $fout = str_replace('{{downloadlink}}', $download_link, $fout);

  // -- replace with the postid
  $fout = str_replace('{{replacewithpostid}}', $playerId, $fout);
  $fout = str_replace('{{replacewithproductid}}', $playerId, $fout);


  $fout = str_replace('{{posturl}}', $permalink, $fout);

  return $fout;
}


function dzsap_sanitize_from_setting($arg) {

  $arg = stripslashes($arg);
  $arg = str_replace('{{quots}}', '\'', $arg);
  $arg = str_replace(array("\r", "\r\n", "\n"), '', $arg);

  return $arg;
}

function dzsap_sanitize_from_shortcode_attr($arg, $che = array()) {

  $arg = str_replace('{{lsqb}}', '[', $arg);
  $arg = str_replace('{{rsqb}}', ']', $arg);
  $arg = str_replace('&#8221;', '', $arg);

//    print_rr($che);

  $arg = str_replace('{{linkedid}}', '', $arg);

  global $post;

  $pid = '';


  if ($post) {
    $pid = $post->ID;
  }


  $arg = str_replace('{{postid}}', $pid, $arg);

  $lab = 'itunes_link';
  if (isset($che[$lab])) {
    $arg = str_replace('{{' . $lab . '}}', $che[$lab], $arg);
  } else {

    $arg = str_replace('{{' . $lab . '}}', '', $arg);
  }
  $arg = str_replace('&#8221;', '', $arg);

  return $arg;
}

function dzsap_get_download_link($che, $playerid) {

  global $dzsap;

  $download_link = '';

  $link_is_real = false; // -- check if the link is leading to a real post
  if ($playerid) {
    $po = get_post($playerid);

    if (!$po) {
      // -- if number is random then attribute source
      $playerid = '';
      $link_is_real = false;
    } else {

      $link_is_real = true;
    }
  }


  if (isset($che) && is_object($che)) {
    $che = (array)$che;
  }

  // todo: side effect - why do we need this ?
  if (isset($che['source']) == false) {
    if (isset($che['post_type'])) {
      if ($che['post_type'] == 'product') {
        $che['source'] = get_post_meta($che['ID'], 'dzsap_woo_product_track', true);
      }
    }
  }
  // todo: why do we need this ? $dzsap->mainoptions['download_link_links_directly_to_file']=='on' &&


  if ((isset($che) && isset($che['download_custom_link']) && $che['download_custom_link'] && $che['download_custom_link'] != 'off')) {
    // -- it gets replied by whole download custom_link
    $download_link = $che['download_custom_link'];
  } else {
    if ($link_is_real) {
      // -- if playerid is valid
      $download_link = site_url() . '?action=dzsap_download&id=' . $playerid;
      if (isset($che) && isset($che['songname'])) {
        $download_link .= '&songname=' . urlencode($che['songname']);
      }
    } else {
      if ($dzsap->mainoptions['download_link_links_directly_to_file'] == 'on') {
        $download_link = $che['source'];
      } else {
        // -- set link for download link
        $download_link = site_url() . '?action=dzsap_download&link=' . urlencode($che['source']) . '&songname=' . urlencode($che['songname']);
      }
    }
  }


  return $download_link;
}


function dzsap_sanitize_to_css_perc($arg) {


  $fout = $arg;

  if (strpos($arg, '%') === false) {
    $fout .= '%';
  }


  $fout = str_replace('http://', '', $fout);
  $fout = str_replace('https://', '', $fout);

  return $fout;

}


if (function_exists('dzsap_sort_by_likes') == false) {
  function dzsap_sort_by_likes($a, $b) {
    if (isset($a['likes']) && is_numeric($a['likes']) && isset($b['likes']) && is_numeric($b['likes'])) {
      return $b['likes'] - $a['likes'];
    }
  }
}

if (function_exists('dzsap_sort_by_views') == false) {
  function dzsap_sort_by_views($a, $b) {
    if (isset($a['views']) && is_numeric($a['views']) && isset($b['views']) && is_numeric($b['views'])) {
      return $b['views'] - $a['views'];
    }
  }
}

function dzsap_init_arg_submit_contor_60_secs() {
  global $wpdb;
  global $dzsap;


  $date = date('Y-m-d');
  $country = '0';
  $id = $_POST['video_analytics_id'];
  if ($dzsap->mainoptions['analytics_enable_location'] == 'on') {

    if ($_SERVER['REMOTE_ADDR']) {

      $request = wp_remote_get('https://ipinfo.io/' . $_SERVER['REMOTE_ADDR'] . '/json');
      $response = wp_remote_retrieve_body($request);
      $aux_arr = json_decode($response);
//                        print_r($aux_arr);

      if ($aux_arr) {
        $country = $aux_arr->country;
      }
    }
  }


  $userid = '';
  $userid = get_current_user_id();
  if ($dzsap->mainoptions['analytics_enable_user_track'] == 'on') {

    if ($_POST['curr_user']) {
      $userid = $_POST['curr_user'];
    }
  }


  $playerid = $id;

  $table_name = $wpdb->prefix . 'dzsap_activity';


  $results = $GLOBALS['wpdb']->get_results('SELECT * FROM ' . $table_name . ' WHERE id_user = \'' . $userid . '\' AND date=\'' . $date . '\'  AND type=\'' . 'timewatched' . '\' AND id_video=\'' . $playerid . '\'', OBJECT);


//			    print_rr($results);

  if (is_array($results) && count($results) > 0) {


    $val = intval($results[0]->val);
//				    echo '$val  - '.$val;
    $newval = $val + 60;

    $wpdb->update(
      $table_name,
      array(
        'val' => $val + 60,
      ),
      array('ID' => $results[0]->id),
      array(
        '%s',    // value1
      ),
      array('%d')
    );

//				    echo '$newval  - '.$newval;

  } else {
    $currip = dzsap_misc_get_ip();


    $wpdb->insert(
      $table_name,
      array(
        'ip' => $currip,
        'type' => 'timewatched',
        'id_user' => $userid,
        'id_video' => $playerid,
        'date' => $date,
        'val' => 60,
        'country' => $country,
      )
    );
  }


  // -- global table

  $query = 'SELECT * FROM ' . $table_name . ' WHERE id_user = \'0\' AND date=\'' . $date . '\'  AND type=\'' . 'timewatched' . '\' AND id_video=\'' . (0) . '\'';
  if ($dzsap->mainoptions['analytics_enable_location'] == 'on' && $country) {
    $query .= ' AND country=\'' . $country . '\'';
  }
  $results = $GLOBALS['wpdb']->get_results($query, OBJECT);


  if (is_array($results) && count($results) > 0) {


    $val = intval($results[0]->val);
    $newval = $val + 60;

    $wpdb->update(
      $table_name,
      array(
        'val' => $val + 60,
      ),
      array('ID' => $results[0]->id),
      array(
        '%s',    // value1
      ),
      array('%d')
    );


  } else {

    $wpdb->insert(
      $table_name,
      array(
        'ip' => 0,
        'type' => 'timewatched',
        'id_user' => 0,
        'id_video' => 0,
        'date' => $date,
        'country' => $country,
        'val' => 60,
      )
    );
  }

}

function dzsap_ajax_check_init_args() {
  global $dzsap;


//  print_rr($_POST);
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'dzsap_send_total_time_for_track') {
      if (isset($_POST['id_track'])) {
        $po_id = $_POST['id_track'];
        if (update_post_meta($po_id, 'dzsap_total_time', $_POST['postdata'])) {
          echo json_encode(array('ajax_status' => 'success'));
        } else {
          echo json_encode(array('ajax_status' => 'error', 'ajax_message' => 'Failed - maybe it already existed with the same values'));
        }
      }
      die();
    }
  }


  if (isset($_GET['action'])) {

    if ($_GET['action'] == 'ajax_dzsap_submit_contor_60_secs') {
      dzsap_init_arg_submit_contor_60_secs();
      die();
    }

    // -- download get
    if ($_GET['action'] == 'dzsap_download') {
      // -- download here
      $filename = '';

      if (isset($_GET['id']) && $_GET['id']) {
        $po = get_post($_GET['id']);
        $pid = $_GET['id'];

        if ($po && $po->post_title) {
          $filename = $po->post_title;
        }

        if ($dzsap->mainoptions['allow_download_only_for_registered_users'] == 'on') {
          global $current_user;

          if ($current_user->ID) {


            if ($dzsap->mainoptions['allow_download_only_for_registered_users_capability'] && $dzsap->mainoptions['allow_download_only_for_registered_users_capability'] != 'read') {
              if (current_user_can('manage_options') || current_user_can($dzsap->mainoptions['allow_download_only_for_registered_users_capability'])) {

              } else {

                die(__("You do not have permission", 'dzsap'));
              }
            }
          } else {

            die(__("You need to register", 'dzsap'));
          }
        }


        $path = '';

        $mockPostId = 0;
        $mockMargs = array();
//          error_log('$po - 5'.print_r($po,true));
        if ($po->post_type == 'product') {
          $filename = $dzsap->get_track_source($po->ID, $mockPostId, $mockMargs);
//            error_log('product get track source'.print_r($filename,true));

          if (strpos($filename, site_url()) !== false) {
            $path = str_replace(site_url(), ABSPATH, $filename);
          }
        }
        if ($po->post_type == 'attachment') {
          $filename = wp_get_attachment_url($po->ID);
          $path = get_attached_file($po->ID);
        }
        if ($po->post_type == 'dzsap_items') {
          $filename = $dzsap->get_track_source($po->ID, $mockPostId, $mockMargs);
          $path = '';
          if (strpos($filename, site_url()) !== false) {
            $path = str_replace(site_url(), ABSPATH, $filename);
          }
        }

        if ($filename == '') {

          if (isset($_GET['source'])) {
            $filename = $_GET['source'];
          }


          if ($filename == '') {
            if (function_exists('get_field')) {
              $arr = get_field('scratch_preview', $po->ID);


              if ($arr) {

                $media = wp_get_attachment_url($arr);

                $filename = $media;
              }
            }
          }
        }

        // -- force it
        if (isset($_GET['songname']) && $_GET['songname']) {
          $filename = $_GET['songname'];
        }

//                    echo $filename;

        // -- still in download


        $extension = 'mp3';
        $content_type = 'application/octet-stream';

        // -- dzs ap download
        if (strpos($filename, '.m4a') !== false) {
          $extension = 'm4a';
          $content_type = 'audio/mp4';
//						$content_type = 'audio/x-m4a';
        }
        if (strpos($filename, '.wav') !== false) {
          $extension = 'wav';
          $content_type = 'audio/wav';
        }


        $filename_for_download = $filename;
//          error_log('add extension here .. no id', strpos($filename_in_header,'.'));

        $filename_exploder = explode('/', $filename_for_download);
        $filename_for_download = $filename_exploder[count($filename_exploder) - 1];

        if (strpos($filename_for_download, '.') === false) {
          $filename_for_download .= '.' . $extension;
        }


        header("Pragma: public");
        header("Expires: 0");

        header("Content-Type: '.$content_type.'");
        header("Content-Disposition: attachment; filename=\"" . strtolower($filename_for_download) . "\"");
        header("Content-Transfer-Encoding: binary");

        if ($path && file_exists($path)) {

          header('Content-Length: ' . filesize($path));
          readfile($path);
        } else {
          echo file_get_contents($filename);
        }


        $dzsap->insert_activity(array(
          'id_video' => $po->ID,
          'type' => 'download',
        ));


        // --end id


      } else {
        // -- where does link come from ?
        if (isset($_GET['link']) && $_GET['link']) {

//                        $aux  =$_GET['link'];
          $aux = explode('/', $_GET['link']);
          $filename = $aux[count($aux) - 1];

          $filename = html_entity_decode($filename);
          $extension = 'mp3';

          // -- dzsap download from link

          if (strpos($_GET['link'], '.m4a') !== false) {
            $extension = 'm4a';
          }


          $filename_in_header = strtolower($filename);

          if (strpos($filename_in_header, '.') === false) {
            $filename_in_header .= '.' . $extension;
          }

          header("Pragma: public");
          header("Expires: 0");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Cache-Control: public");
          header("Content-Description: File Transfer");
          header("Content-type: application/octet-stream");
          header("Content-Disposition: attachment; filename=\"" . $filename_in_header . "\"");
          header("Content-Transfer-Encoding: binary");


          echo file_get_contents($_GET['link']);


        } else {

          echo esc_html__("You need to set media id", 'dzsap');
        }

      }
      die();
    }
    // -- end download
  }


  if (isset($_GET['dzsap_action']) && $_GET['dzsap_action'] == 'load_charts_html') {
    include("../../class_parts/ajax_load_charts_html.php");
  }


  if (isset($_REQUEST['dzsap_action'])) {

//      echo 'success' . ' ' .$_POST['name']. ' ' .$_REQUEST['dzsap_action'];
    if ($_REQUEST['dzsap_action'] == 'dzsap_import_vp_config') {
//        echo 'success' . ' ' .$_POST['name']. ' ' .$_REQUEST['dzsap_action'];
      $dzsap->import_vpconfig_by_name($_POST['name']);

      die();

    }


    if ($_REQUEST['dzsap_action'] == 'dzsap_import_playlist') {
//        echo 'success' . ' ' .$_POST['name']. ' ' .$_REQUEST['dzsap_action'];
      $name = $_POST['name'];


      $rel_path = 'sampledata/dzsap-playlist--' . $name . '.txt';
      $file_cont = file_get_contents($rel_path, true);

//			    error_log('trying to import - '.$file_cont);
      $sw_import = ZoomSoundsAjaxFunctions::import_slider($file_cont);

      echo json_encode($sw_import);
      die();

    }
  }
  if (isset($_POST['action'])) {

    // -- delete waveforms
    if ($_POST['action'] == 'dzsap_delete_waveforms') {


      $nonce = $_REQUEST['nonce'];
      if (!wp_verify_nonce($nonce, 'dzsap_delete_waveforms_nonce')) {
        // This nonce is not valid.
        die('Security check');
      }


      global $wpdb;

      $wpdb->query(
        $wpdb->prepare(
          "DELETE FROM $wpdb->options WHERE option_name LIKE %s ",
          'dzsap_pcm_data%'
        )
      );


    }
    if ($_POST['action'] == 'dzsap_delete_times') {


      $nonce = $_REQUEST['nonce'];
      if (!wp_verify_nonce($nonce, 'dzsap_delete_times_nonce')) {
        // This nonce is not valid.
        die('Security check');
      }


      global $wpdb;


      $wpdb->query(
        $wpdb->prepare(
          "DELETE FROM $wpdb->options WHERE option_name LIKE %s ",
          'dzsap_total_time%'
        )
      );


    }
    if ($_POST['action'] == 'dzsap_duplicate_dzsap_configs') {

      if (isset($_POST['slidernr'])) {
        if (isset($_GET['page']) && $_GET['page'] == $dzsap->pageName_legacy_sliders_admin_vpconfigs) {
          $aux = ($dzsap->mainitems_configs[$_POST['slidernr']]);
          array_push($dzsap->mainitems_configs, $aux);
          $dzsap->mainitems_configs = array_values($dzsap->mainitems_configs);
          $dzsap->currSlider = count($dzsap->mainitems_configs) - 1;
          update_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS, $dzsap->mainitems_configs);

          wp_redirect(admin_url('admin.php?page=dzsap_configs&currslider=' . $dzsap->currSlider));
          exit;
        }
      }
    }
  }

  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'dzsap_duplicate_dzsap_slider') {

      if (isset($_POST['slidernr'])) {
        if (isset($_GET['page']) && $_GET['page'] == $dzsap->adminpagename) {
          $aux = ($dzsap->mainitems[$_POST['slidernr']]);
          array_push($dzsap->mainitems, $aux);
          $dzsap->mainitems = array_values($dzsap->mainitems);
          $dzsap->currSlider = count($dzsap->mainitems) - 1;
          update_option($dzsap->dbname_mainitems, $dzsap->mainitems);

          wp_redirect(admin_url('admin.php?page=dzsap_menu&currslider=' . $dzsap->currSlider));
          exit;
        }
      }
    }
  }


}

function dzsap_sanitize_to_array_for_parse($its, $margs) {
//        print_r($its);
//        print_r($margs);
  global $dzsap;

  foreach ($its as $lab => $it) {
//            $its[$lab] = $dzsap->object_to_array($it);
    $its[$lab] = (array)$it;


    $thumb = $dzsap->get_post_thumb_src($it->ID);

//            echo ' thumb - ';
//            print_r($thumb);


    $thumb_from_meta = get_post_meta($it->ID, 'dzsrst_meta_item_thumb', true);

    if ($thumb_from_meta) {

      $thumb = $thumb_from_meta;
    }

    if ($thumb) {
//                $its[$lab]->thumbnail = $thumb;
      $its[$lab]['thumbnail'] = $thumb;
    }

//            print_r($margs);


    $its[$lab]['title_permalink'] = get_permalink($it->ID);

    $its[$lab]['price'] = get_post_meta($it->ID, 'dzsrst_meta_item_price', true);

    if ($margs['post_type'] == 'product') {
      if (get_post_meta($it->ID, '_regular_price', true)) {
        $its[$lab]['price'] = '';
        if (function_exists('get_woocommerce_currency_symbol')) {
          $its[$lab]['price'] .= get_woocommerce_currency_symbol();
        }
        $its[$lab]['price'] .= get_post_meta($it->ID, '_regular_price', true);
      }
    }

//            $its[$lab]['ingredients'] = get_post_meta($it->ID, 'dzsrst_meta_item_ingredients',true);
    $its[$lab]['bigimage'] = $dzsap->sanitize_id_to_src(get_post_meta($it->ID, 'dzsrst_meta_item_bigimage', true));


  }

  return $its;
}

function dzsap_object_to_array($data) {
  if (is_array($data) || is_object($data)) {
    $result = array();
    foreach ($data as $key => $value) {
      $result[$key] = dzsap_object_to_array($value);
    }
    return $result;
  }
  return $data;
}


function dzsap_delete_waveform($name) {
  // @name - pcm sanitized source or id


  global $wpdb;

  $wpdb->query(
    $wpdb->prepare(
      "DELETE FROM $wpdb->options
		 WHERE option_name LIKE %s
		",
      ('dzsap_pcm_data_' . $name)
    )
  );
}
