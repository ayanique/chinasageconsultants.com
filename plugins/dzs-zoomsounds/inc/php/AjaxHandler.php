<?php


class AjaxHandler {

  function __construct() {


    add_action('wp_ajax_dzs_get_attachment_src', array($this, 'get_attachment_src'));
    add_action('wp_ajax_dzsap_ajax', array($this, 'saveLegacyitems'));
    add_action('wp_ajax_dzsap_save_configs', array($this, 'save_audioplayer_configs'));
    add_action('wp_ajax_dzsap_ajax_mo', array($this, 'save_mainOptions'));
    add_action('wp_ajax_dzsap_delete_pcm', array($this, 'delete_pcm'));
    add_action('wp_ajax_dzsap_parse_content_to_shortcode', array($this, 'parse_content_to_shortcode'));
    add_action('wp_ajax_dzsap_send_queue_from_sliders_admin', array($this, 'send_queue_from_sliders_admin'));


    // -- getdemo.php
    add_action('wp_ajax_dzsap_create_playlist', 'ZoomSoundsAjaxFunctions::create_playlist_if_it_does_not_exist');
    add_action('wp_ajax_dzsap_import_item_lib', array($this, 'import_item_lib'));

    add_action('wp_ajax_dzsap_front_submitcomment', array($this, 'front_submitcomment'));
    add_action('wp_ajax_dzsap_get_thumb_from_meta', array($this, 'get_thumb_from_meta'));
    add_action('wp_ajax_dzsap_submit_download', array($this, 'submit_download'));

    add_action('wp_ajax_dzsap_submit_views', array($this, 'submit_views'));
    add_action('wp_ajax_nopriv_dzsap_submit_views', array($this, 'submit_views'));

    add_action('wp_ajax_dzsap_submit_like', array($this, 'submit_like'));
    add_action('wp_ajax_dzsap_retract_like', array($this, 'retract_like'));
    add_action('wp_ajax_dzsap_submit_rate', array($this, 'submit_rate'));
    add_action('wp_ajax_dzsap_get_pcm', array($this, 'get_pcm'));
    add_action('wp_ajax_nopriv_dzsap_get_pcm', array($this, 'get_pcm'));
    add_action('wp_ajax_dzsap_add_to_wishlist', array($this, 'add_to_wishlist'));
    add_action('wp_ajax_nopriv_dzsap_add_to_wishlist', array($this, 'add_to_wishlist'));

    add_action('wp_ajax_nopriv_dzsap_front_submitcomment', array($this, 'front_submitcomment'));
    add_action('wp_ajax_nopriv_dzsap_submit_download', array($this, 'submit_download'));
    add_action('wp_ajax_nopriv_dzsap_submit_like', array($this, 'submit_like'));
    add_action('wp_ajax_nopriv_dzsap_retract_like', array($this, 'retract_like'));
    add_action('wp_ajax_nopriv_dzsap_submit_rate', array($this, 'submit_rate'));
    add_action('wp_ajax_dzsap_submit_pcm', array($this, 'submit_pcm'));
    add_action('wp_ajax_nopriv_dzsap_submit_pcm', array($this, 'submit_pcm'));
    add_action('wp_ajax_dzsap_shoutcast_get_streamtitle', array($this, 'shoutcast_get_streamtitle'));
    add_action('wp_ajax_nopriv_dzsap_shoutcast_get_streamtitle', array($this, 'shoutcast_get_streamtitle'));


    add_action('wp_ajax_dzsap_delete_notice', array($this, 'delete_notice'));
    add_action('wp_ajax_dzsap_activate', array($this, 'activate_license'));
    add_action('wp_ajax_dzsap_hide_intro_nag', array($this, 'hide_intro_nag'));
    add_action('wp_ajax_dzsap_deactivate', array($this, 'deactivate_license'));

    add_action('wp_ajax_ajax_dzsap_insert_sample_tracks', array($this, 'submit_sample_tracks'));
    add_action('wp_ajax_nopriv_ajax_dzsap_insert_sample_tracks', array($this, 'submit_sample_tracks'));

    add_action('wp_ajax_ajax_dzsap_remove_sample_tracks', array($this, 'remove_sample_tracks'));
    add_action('wp_ajax_nopriv_ajax_dzsap_remove_sample_tracks', array($this, 'remove_sample_tracks'));
    add_action('wp_ajax_dzsap_import_folder', 'ZoomSoundsAjaxFunctions::ajax_import_folder');
  }


  function send_queue_from_sliders_admin() {

    global $dzsap;


//        print_r($_POST);

    $response = array(
      'report' => 'success',
      'items' => array(),
    );

    $queue_calls = json_decode(stripslashes($_POST['postdata']), true);

//        error_log('$queue_calls - '.print_r($queue_calls,true));

    foreach ($queue_calls as $qc) {

      if ($qc['type'] == 'set_meta_order') {
        foreach ($qc['items'] as $it) {

          update_post_meta($it['id'], 'dzsap_meta_order_' . $qc['term_id'], $it['order']);
        }
      }
      if ($qc['type'] == 'set_meta') {

        if ($qc['lab'] == 'the_post_title' || $qc['lab'] == 'post_content') {


          $aferent_lab = $qc['lab'];

          if ($qc['lab'] == 'the_post_title') {
            $aferent_lab = 'post_title';
          }
          if ($qc['lab'] == 'post_content') {
            $aferent_lab = 'post_content';
          }

          $my_post = array(
            'ID' => $qc['item_id'],
            $aferent_lab => $qc['val'],

          );

          error_log('update post - ' . print_r($my_post, true));

// Update the post into the database
          wp_update_post($my_post);
        } else {

          update_post_meta($qc['item_id'], $qc['lab'], $qc['val']);
        }

      }
      if ($qc['type'] == 'delete_item') {


        $post_id = $qc['id'];


        $term_list = wp_get_post_terms($post_id, $dzsap->taxname_sliders, array("fields" => "all"));


        $response['report_type'] = 'delete_item';
        $response['report_message'] = esc_html__("Item deleted", 'dzsap');


        if (is_array($term_list) && count($term_list) == 1) {

          wp_delete_post($post_id);
        } else {
          wp_remove_object_terms($post_id, $qc['term_slug'], $dzsap->taxname_sliders);
        }

      }
      if ($qc['type'] == 'create_item') {

//                print_r($qc);


        $taxonomy = $dzsap->taxname_sliders;


        $current_user = wp_get_current_user();
        $new_post_author_id = $current_user->ID;


        $args = array(
          'post_title' => __("Insert Name", 'dzsap'),
          'post_content' => 'content here',
          'post_status' => 'publish',
          'post_author' => $new_post_author_id,
          'post_type' => 'dzsap_items',
        );
        //  default_zoomsounds_item_settings


        if (isset($qc['term_slug']) && $qc['term_slug']) {

          $title = substr($qc['term_slug'], 0, 4);


          if (isset($qc['dzsap_meta_order_' . $qc['term_id']])) {
            $title .= $qc['dzsap_meta_order_' . $qc['term_id']];
          }

          $args['post_title'] = $title;

        }


        if ($dzsap->mainoptions['try_to_get_id3_thumb_in_frontend'] == 'on') {

          $title = '';
          $args['post_title'] = $title;
        }


        // -- search for default


//        error_log('post - '.print_r($_POST,true));
//        error_log('$qc - '.print_r($qc,true));


        $the_slug = 'default_zoomsounds_item_settings';
        $the_slug_term = '';

        // -- if we find it we get the settings
        if (isset($qc['term_slug']) && $qc['term_slug']) {
          $the_slug_term .= $the_slug . '_' . $qc['term_slug'];
        }


        $args4 = array(
          'name' => $the_slug,
          'post_type' => 'dzsap_items',
          'post_status' => 'any',
          'numberposts' => 1
        );
        $my_posts = get_posts($args4);
        if ($my_posts) {
          $args = array_merge($args, $dzsap->sanitize_to_gallery_item($my_posts[0]));

//          error_log("dzsap log - FOUND DEFAULT, new args - ".print_r($args,true));
        }


//        error_log('$the_slug_term - '.$the_slug_term);
        if ($the_slug_term) {

          $args4 = array(
            'name' => $the_slug_term,
            'post_type' => 'dzsap_items',
            'post_status' => 'any',
            'numberposts' => 1
          );
          $my_posts = get_posts($args4);
          if ($my_posts) {
            $args = array_merge($args, $dzsap->sanitize_to_gallery_item($my_posts[0]));

//            error_log("dzsap log - FOUND DEFAULT .. for term, new args - ".print_r($args,true));
          }

        }

        // -- end search for default


        if (isset($qc['post_title']) && $qc['post_title']) {
          $args['post_title'] = $qc['post_title'];

        }
        $args['post_status'] = 'publish';


//                $new_created_item = wp_insert_post($args);


//        error_log("prepare args -5 ".print_r($args,true));

        $args['call_from'] = 'send queue from sliders admin';
        $new_created_item = $dzsap->import_demo_insert_post_complete($args);

        if (isset($qc['term_slug']) && $qc['term_slug']) {
          wp_set_post_terms($new_created_item, dzs_sanitize_for_post_terms($qc['term_slug']), $taxonomy);

        }


        foreach ($qc as $lab => $val) {
          if (strpos($lab, 'dzsap_meta') === 0) {
            update_post_meta($new_created_item, $lab, $val);
          }
        }

//        wp_set_post_terms($new_created_item,$arr_cats[0],$taxonomy);

        array_push($response['items'], array(
          'type' => 'create_item',
          'str' => $dzsap->sliders_admin_generate_item(get_post($new_created_item)),
        ));
      }


      if ($qc['type'] == 'duplicate_item') {

//                print_r($qc);


        $reference_po_id = ($qc['id']);

        $sample_post_2_id = $dzsap->duplicate_post($reference_po_id);


//        wp_set_post_terms($sample_post_2_id,$arr_cats[0],$taxonomy);

        array_push($response['items'], array(
          'type' => 'create_item',
          'original_request' => 'duplicate_item',
          'original_post_id' => $reference_po_id,
          'str' => $dzsap->sliders_admin_generate_item(get_post($sample_post_2_id)),
        ));
      }
    }

    echo json_encode($response);
    die();
  }


  function submit_download() {
    global $dzsap;

    $aux_likes = 0;
    $playerid = '';

    if (isset($_POST['playerid'])) {
      $playerid = $_POST['playerid'];
      $playerid = str_replace('ap', '', $playerid);
    }

    if (is_numeric($playerid) && get_post_meta($playerid, '_dzsap_downloads', true) != '') {
      $aux_likes = intval(get_post_meta($playerid, '_dzsap_downloads', true));
    }

    if (isset($_COOKIE['downloadsubmitted-' . $playerid])) {

    } else {

    }

    $aux_likes = $aux_likes + 1;


    $dzsap->insert_activity(array(
      'id_video' => $playerid,
      'type' => 'download',
    ));


    if (is_numeric($playerid)) {

      update_post_meta($playerid, '_dzsap_downloads', $aux_likes);
    }


    setcookie("downloadsubmitted-" . $playerid, '1', time() + (intval($dzsap->mainoptions['play_remember_time']) * 60), COOKIEPATH);

    echo 'success';
    die();
  }


  function submit_views() {
    // -- here we record the views
    global $dzsap;

    $aux_likes = 0;
    $playerid = '';
//    error_log(DZSAP_PHP_LOG_LABEL. ' '.DZSAP_PHP_LOG_AJAX_LABEL.' submit_views() -5 ');
//    echo 'submit';

    if (isset($_POST['playerid'])) {
      $playerid = $_POST['playerid'];
      $playerid = str_replace('ap', '', $playerid);
    }

    if (get_post_meta($playerid, '_dzsap_views', true) != '') {
      $aux_likes = intval(get_post_meta($playerid, '_dzsap_views', true));
    }


    dzsap_analytics_submit_into_table(array(
      'type' => 'view',
    ));

//    echo 'success';

    if (isset($_COOKIE['viewsubmitted-' . $playerid])) {

    } else {
      $aux_likes = $aux_likes + 1;


      $dzsap->insert_activity(array(
        'id_video' => $playerid,
        'type' => 'view',
      ));

    }


    update_post_meta($playerid, '_dzsap_views', $aux_likes);


//    error_log(DZSAP_PHP_LOG_LABEL. ' '.DZSAP_PHP_LOG_AJAX_LABEL.'$playerid -6 ' . $playerid);
//    error_log(DZSAP_PHP_LOG_LABEL. ' '.DZSAP_PHP_LOG_AJAX_LABEL.'nrviews -6 ' . $aux_likes);
    echo json_encode(array(
      'response_type' => 'success',
      'number' => $aux_likes,
    ));

    setcookie("viewsubmitted-" . $playerid, '1', time() + (intval($dzsap->mainoptions['play_remember_time']) * 60), COOKIEPATH);

    die();
  }


  function submit_rate() {

    //print_r($_COOKIE);


    $rate_index = 0;
    $rate_nr = 0;
    $playerid = '';

    if (isset($_POST['playerid'])) {
      $playerid = $_POST['playerid'];
      $playerid = str_replace('ap', '', $playerid);
    }

    if (get_post_meta($playerid, '_dzsap_rate_nr', true) != '') {
      $rate_nr = intval(get_post_meta($playerid, '_dzsap_rate_nr', true));
    }
    if (get_post_meta($playerid, '_dzsap_rate_index', true) != '') {
      $rate_index = intval(get_post_meta($playerid, '_dzsap_rate_index', true));
    }


    if (!isset($_COOKIE['dzsap_ratesubmitted-' . $playerid])) {
      $rate_nr++;
    }

    if ($rate_nr <= 0) {
      $rate_nr = 1;
    }


    $rate_index = ($rate_index * ($rate_nr - 1) + intval($_POST['postdata'])) / ($rate_nr);


    setcookie("dzsap_ratesubmitted-" . $playerid, $_POST['postdata'], time() + 36000, COOKIEPATH);


    update_post_meta($playerid, '_dzsap_rate_index', $rate_index);
    update_post_meta($playerid, '_dzsap_rate_nr', $rate_nr);

    echo json_encode(array(
      'index' => $rate_index,
      'number' => $rate_nr,
    ));
    die();
  }


  function shoutcast_get_streamtitle() {

    //print_r($_COOKIE);

    echo ZoomSoundsAjaxFunctions::shoutcast_get_now_playing($_GET['source']);

    die();
  }


  function submit_pcm() {

    //print_r($_COOKIE);

    $lab = '';

    if ($_POST['playerid']) {

      $lab = 'dzsap_pcm_data_' . (DZSZoomSoundsHelper::sanitize_for_one_word($_POST['playerid']));
    }


//        update_option("dzsap_ceva", "ceva");
//        update_option($lab, "ceva");

    if ((isset($_POST['call_from']) && $_POST['call_from'] = 'manual_wave_overwrite') || strpos($_POST['postdata'], ',') !== false) {

      $_POST['postdata'] = stripslashes($_POST['postdata']);
      update_option($lab, $_POST['postdata']);

      if (isset($_POST['source'])) {

        $lab = 'dzsap_pcm_data_' . (DZSZoomSoundsHelper::sanitize_for_one_word($_POST['source']));
        $_POST['postdata'] = stripslashes($_POST['postdata']);
        update_option($lab, $_POST['postdata']);

        $arr_pcm_to_id_links = array();
        if (get_option('dzsap_pcm_to_id_links')) {
          $arr_pcm_to_id_links = get_option('dzsap_pcm_to_id_links');
        }

        $arr_pcm_to_id_links[$_POST['playerid']] = $_POST['source'];
        update_option('dzsap_pcm_to_id_links', $arr_pcm_to_id_links);


        // -- if we have source then just link to id
      }
//        echo $lab. ' ';


      echo 'success';
    }

    die();
  }


  function submit_sample_tracks() {
    global $dzsap;

    //print_r($_COOKIE);

    $dzsap->sample_data = array(
      'media' => array(),
    );


    include("class_parts/sample_submit_tracks.php");


    echo 'success';

    die();
  }


  function remove_sample_tracks() {
    global $dzsap;

    //print_r($_COOKIE);


//        print_r($dzsap->sample_data);


    foreach ($dzsap->sample_data['media'] as $pid) {
      wp_delete_post($pid);
    };

    $dzsap->sample_data = false;
    update_option($dzsap->dbname_sample_data, $dzsap->sample_data);


    echo 'success';

    die();
  }


  function submit_like() {

    //print_r($_COOKIE);

    global $dzsap;
    global $current_user;

    $aux_likes = 0;
    $playerid = '';


    $user_id = -1;
    if ($current_user->ID) {
      $user_id = $current_user->ID;
    }


    if (isset($_POST['playerid'])) {
      $playerid = $_POST['playerid'];
      $playerid = str_replace('ap', '', $playerid);
    }


    if (get_post_meta($playerid, '_dzsap_likes', true) != '') {
      $aux_likes = intval(get_post_meta($_POST['playerid'], '_dzsap_likes', true));
    }


    $aux_likes = $aux_likes + 1;

    update_post_meta($playerid, '_dzsap_likes', $aux_likes);

//	    $dzsap->analytics_submit_into_table(array(
//		    'type'=>'like',
//	    ));
//	    echo 'success';


    setcookie("dzsap_likesubmitted-" . $playerid, '1', time() + 36000, COOKIEPATH);


    error_log('submit like to user meta - ' . $user_id);
    if ($user_id > 0) {
      $aux_likes_arr = array();
      $aux_likes_arr_test = get_user_meta($user_id, '_dzsap_likes');
      if (is_array($aux_likes_arr_test)) {
        $aux_likes_arr = $aux_likes_arr_test;
      };

      if (!in_array($playerid, $aux_likes_arr)) {
        array_push($aux_likes_arr, $playerid);

        update_user_meta($user_id, '_dzsap_likes', $aux_likes_arr);
      }
    };

    $dzsap->insert_activity(array(
      'id_video' => $playerid,
      'type' => 'like',
    ));

    echo json_encode(array(
      'status' => 'success',
      'nr_likes' => $aux_likes,
    ));
    die();
  }


  function retract_like() {
    global $dzsap;

    //print_r($_COOKIE);


    $aux_likes = 1;
    $playerid = '';

    if (isset($_POST['playerid'])) {
      $playerid = $_POST['playerid'];
      $playerid = str_replace('ap', '', $playerid);
    }


    if (get_post_meta($playerid, '_dzsap_likes', true) != '') {
      $aux_likes = intval(get_post_meta($_POST['playerid'], '_dzsap_likes', true));
    }

    $aux_likes = $aux_likes - 1;

    update_post_meta($playerid, '_dzsap_likes', $aux_likes);

    setcookie("dzsap_likesubmitted-" . $playerid, '', time() - 36000, COOKIEPATH);


    $user_id = 0;
    $current_user = wp_get_current_user();

    if ($current_user) {
      if ($current_user->ID) {
        $user_id = $current_user->ID;
      }
    }


    $dzsap->delete_activity(array(
      'id_video' => $playerid,
      'id_user' => $user_id,
      'type' => 'like',
    ));

    echo json_encode(array(
      'status' => 'success',
      'nr_likes' => $aux_likes,
    ));
    die();
  }


  function import_item_lib() {
    global $dzsap;


    $cont = '';

    $dzsap->db_read_mainitems();

    if ($_POST['demo'] == 'sample_vimeo_channel33') {

    } else {

      $url = 'https://zoomthe.me/updater_dzsap/getdemo.php?demo=' . $_POST['demo'] . '&purchase_code=' . $dzsap->mainoptions['dzsap_purchase_code'] . '&site_url=' . urlencode(site_url());
      $cont = file_get_contents($url);
    }


    //        echo $url;


    $resp = json_decode($cont, true);


    if ($resp['response_type'] == 'success') {

      //            print_r($resp);
      foreach ($resp['items'] as $lab => $it) {
        //                print_r($it);


//                print_r($it);

        if ($it['type'] == 'slider_import') {

          $sw_import = true;
          $slider = unserialize($it['src']);


          //                    print_r($slider);
          foreach ($dzsap->mainitems as $mainitem) {
            //                        print_r($mainitem);

            if ($slider['settings']['id'] === $mainitem['settings']['id']) {

              //                            echo '$slider[\'settings\'][\'id\'] - '.$slider['settings']['id'].' - $mainitem[\'settings\'][\'id\'] - '.$mainitem['settings']['id'];
              $sw_import = false;
            }
          }

          //                    print_r($slider);
          //                    echo '$sw_import - '.$sw_import;


          if ($sw_import) {


            array_push($dzsap->mainitems, $slider);


            update_option($dzsap->dbname_mainitems, $dzsap->mainitems);
          }
        }


        if ($it['type'] == 'set_curr_page_footer_player') {

//                    error_log("SET FOOTER PLAYER - ".print_rr($_POST, array('echo'=>false)));

          if (isset($_POST['post_id']) && $_POST['post_id']) {
            $id = $_POST['post_id'];

            update_post_meta($id, 'dzsap_footer_enable', 'on');
            update_post_meta($id, 'dzsap_footer_feed_type', 'parent');
            update_post_meta($id, 'dzsap_footer_vpconfig', $it['src']);
//	                    error_log("DID IT");
          }
        }
        if ($it['type'] == 'apconfig_import') {

          $sw_import = true;
          $slider = unserialize($it['src']);


          //                    print_r($slider);
          error_log('$slider[\'settings\'][\'id\'] - ' . print_r($slider['settings']['id'], true));
          error_log('mainitems_configs - ' . print_r($dzsap->mainitems_configs, true));


          foreach ($dzsap->mainitems_configs as $mainitem) {
            //                        print_r($mainitem);

            if ($slider['settings']['id'] === $mainitem['settings']['id']) {

              //                            echo '$slider[\'settings\'][\'id\'] - '.$slider['settings']['id'].' - $mainitem[\'settings\'][\'id\'] - '.$mainitem['settings']['id'];
              $sw_import = false;
            }
          }

          //                    print_r($slider);
          //                    echo '$sw_import - '.$sw_import;


          if ($sw_import) {


            array_push($dzsap->mainitems_configs, $slider);


            error_log('mainitems_configs - ' . print_r($dzsap->mainitems_configs, true));
            update_option($dzsap->dbname_mainitems_configs, $dzsap->mainitems_configs);
          }
        }


        if ($it['type'] == 'dzsap_category') {


          $args = $it;


          $args['taxonomy'] = 'dzsap_category';
          $dzsap->import_demo_create_term_if_it_does_not_exist($args);


        }
        if ($it['type'] == 'product_cat') {


          $args = $it;


          $args['taxonomy'] = 'product_cat';
          $dzsap->import_demo_create_term_if_it_does_not_exist($args);


        }
        if ($it['type'] == 'dzsap_items') {


          $args = $it;


          $taxonomy = 'dzsap_category';

          if (isset($args['post_type']) && $args['post_type'] == 'product') {


            $taxonomy = 'product_cat';
          }
          if ($args['term_slug']) {


            $term = get_term_by('slug', $args['term_slug'], $taxonomy);


            if ($term) {


              $args['term'] = $term;


            }


            $args['taxonomy'] = $taxonomy;

          }


          $args['call_from'] = 'import item lib';

          $dzsap->import_demo_insert_post_complete($args);


        }
      }
    }


    echo json_encode($resp);
    die();
  }


  function delete_notice() {


    //        print_r($_POST);

    update_option($_POST['postdata'], 'seen');
    die();
  }


  function deactivate_license() {
    global $dzsap;

    $dzsap->mainoptions['dzsap_purchase_code'] = '';
    $dzsap->mainoptions['dzsap_purchase_code_binded'] = 'off';
    update_option($dzsap->dbname_options, $dzsap->mainoptions);

    die();
  }


  function activate_license() {
    global $dzsap;


    $dzsap->mainoptions['dzsap_purchase_code'] = $_POST['postdata'];
    $dzsap->mainoptions['dzsap_purchase_code_binded'] = 'on';
    update_option($dzsap->dbname_options, $dzsap->mainoptions);

    die();

  }


  function hide_intro_nag() {
    global $dzsap;


    $dzsap->mainoptions['acknowledged_intro_data'] = $_POST['postdata'];
    update_option($dzsap->dbname_options, $dzsap->mainoptions);

    die();

  }


  function parse_content_to_shortcode() {


    error_log('$_POST[\'postdata\'] - ' . $_POST['postdata']);

    echo do_shortcode(stripslashes($_POST['postdata']));

    die();
  }


  function delete_pcm() {

    //print_r($_POST);


    $playerid = $_POST['playerid'];


    $lab = 'dzsap_pcm_data_' . (DZSZoomSoundsHelper::sanitize_for_one_word($_POST['playerid']));


    delete_option($lab);

    if (isset($_POST['track_src'])) {

      $lab = 'dzsap_pcm_data_' . (DZSZoomSoundsHelper::sanitize_for_one_word($_POST['track_src']));


      delete_option($lab);
    }
    echo 'success - ' . $lab;
    die();
  }


  function get_attachment_src() {

    $fout = wp_get_attachment_image_src($_POST['id'], 'full');


//    error_log('fout - get_attachment_src() - '.print_r($fout,true));

    if (isset($fout[0])) {

      echo $fout[0];
    }
    die();
  }

  function saveLegacyitems() {
    global $dzsap;
    //---this is the main save function which saves item
    $auxarray = array();
    $mainarray = array();

    //print_r($dzsap->mainitems);
    //parsing post data
    parse_str($_POST['postdata'], $auxarray);


    if (isset($_POST['currdb'])) {
      $dzsap->currDb = $_POST['currdb'];
    }
    //echo 'ceva'; print_r($dzsap->dbs);
    if ($dzsap->currDb != 'main' && $dzsap->currDb != '') {
      $dzsap->dbname_mainitems .= '-' . $dzsap->currDb;
    }
    //echo $dzsap->dbname_mainitems;
    if (isset($_POST['sliderid'])) {
      //print_r($auxarray);
      $mainarray = get_option($dzsap->dbname_mainitems);
      foreach ($auxarray as $label => $value) {
        $aux = explode('-', $label);
        $tempmainarray[$aux[1]][$aux[2]] = $auxarray[$label];
      }
      $mainarray[$_POST['sliderid']] = $tempmainarray;
    } else {
      foreach ($auxarray as $label => $value) {
        //echo $auxarray[$label];
        $aux = explode('-', $label);
        $mainarray[$aux[0]][$aux[1]][$aux[2]] = $auxarray[$label];
      }
    }
    echo $dzsap->dbname_mainitems;
//        print_r($_POST);
//        print_r($dzsap->currDb);
    echo isset($_POST['currdb']);
//        print_r($mainarray);
    update_option($dzsap->dbname_mainitems, $mainarray);
    echo 'success';
    die();
  }


  function save_audioplayer_configs() {
    // -- this is the main save function which saves configs
    global $dzsap;

    $dataArrayFromPost = array();
    $mainarray = array();

    //parsing post data
    parse_str($_POST['postdata'], $dataArrayFromPost);

//    print_r($dataArrayFromPost);
//        echo 'auxarray ->> '; print_rr($dataArrayFromPost);


    if (isset($_POST['currdb'])) {
      $dzsap->currDb = $_POST['currdb'];
    }
    //echo 'ceva'; print_r($dzsap->dbs);
    if ($dzsap->currDb != 'main' && $dzsap->currDb != '') {
      $dzsap->dbname_mainitems_configs .= '-' . $dzsap->currDb;
    }
    //echo $dzsap->dbname_mainitems;


    if (isset($_POST['sliderid'])) {
      //print_r($dataArrayFromPost);
      $mainarray = get_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS);
      foreach ($dataArrayFromPost as $label => $value) {
        $aux = explode('-', $label);
        $tempmainarray[$aux[1]][$aux[2]] = $dataArrayFromPost[$label];
      }

//			echo '$tempmainarray ->> '; print_rr($tempmainarray);
      $mainarray[$_POST['sliderid']] = $tempmainarray;
    } else {


      if (isset($_POST['slider_name'])) {


        if ($_POST['slider_name'] == 'temp123') {

        }
        $dataArrayFromPost['0-settings-id'] = $_POST['slider_name'];


        $vpconfig_k = count($dzsap->mainitems_configs);
        $vpconfig_id = $_POST['slider_name'];
        for ($i = 0; $i < count($dzsap->mainitems_configs); $i++) {
          if ((isset($vpconfig_id)) && ($vpconfig_id == $dzsap->mainitems_configs[$i]['settings']['id'])) {
            $vpconfig_k = $i;
          }
        }


        $mainarray = get_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS);
        foreach ($dataArrayFromPost as $label => $value) {
          $aux = explode('-', $label);
          $tempmainarray[$aux[1]][$aux[2]] = $dataArrayFromPost[$label];
        }


        if ($_POST['slider_name'] == 'temp123') {

//		            echo 'tempmainarray - '; print_rr($tempmainarray);
          update_option('dzsap_temp_vpconfig', $tempmainarray);
        } else {

          $mainarray[$vpconfig_k] = $tempmainarray;
        }


//		        echo 'mainarray ->> '; print_rr($mainarray);

      } else {

        foreach ($dataArrayFromPost as $label => $value) {
          //echo $dataArrayFromPost[$label];
          $aux = explode('-', $label);
          $mainarray[$aux[0]][$aux[1]][$aux[2]] = $dataArrayFromPost[$label];
        }
      }

    }


//    echo '$mainarray - ';
//    print_rr($mainarray);

    update_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS, $mainarray);




    $response = array(
      'ajax_status' => 'success',
    );
    echo json_encode($response);

    die();
  }

  function save_mainOptions() {
    global $dzsap;
    $mainOptionsFromPost = array();
    //parsing post data
    parse_str($_POST['postdata'], $mainOptionsFromPost);
//        print_r($mainOptionsFromPost);

    $mainOptionsFromPost_default = array(
      'use_external_uploaddir' => 'off'
    );


    $mainOptionsFromPost = array_merge($mainOptionsFromPost_default, $mainOptionsFromPost);

    if (isset($mainOptionsFromPost['dzsaap_enable_unregistered_submit']) && $mainOptionsFromPost['dzsaap_enable_unregistered_submit'] == 'on') {


      $user_name = 'portal_user';
      $user_email = 'portal_user@gmail.com';
      $user_id = dzsap_create_user($user_name, $user_email);

      error_log('dzsapp_portal_user new user - ' . $user_id);


    }
    if (isset($mainOptionsFromPost['dzsaap_enable_allow_users_to_edit_own_tracks']) && $mainOptionsFromPost['dzsaap_enable_allow_users_to_edit_own_tracks'] == 'on') {

      $role = get_role('subscriber');

//      $role->add_cap('read', 1);
      $role->remove_cap('edit_posts');
      $role->remove_cap('dzsap_items');
      $role->add_cap('read_' . DZSAP_REGISTER_POST_TYPE_NAME);
      $role->add_cap('edit_' . DZSAP_REGISTER_POST_TYPE_NAME);
      $role->add_cap('edit_' . DZSAP_REGISTER_POST_TYPE_NAME . 's');
    }


    if ($mainOptionsFromPost['use_external_uploaddir'] == 'on') {
      $path_uploaddir = dirname(dirname(dirname(__FILE__))) . '/upload';
      if (is_dir($path_uploaddir) === false) {
        mkdir($path_uploaddir, 0755);
      }
    }


    if (isset($mainOptionsFromPost['track_downloads']) && $mainOptionsFromPost['track_downloads'] == 'on' || isset($mainOptionsFromPost['analytics_enable']) && $mainOptionsFromPost['analytics_enable'] == 'on') {
//            echo 'hmmdadadadada';


      $this->create_activity_table();

      $mainOptionsFromPost['wpdb_enable'] = 'on';

    }

    if (isset($mainOptionsFromPost['analytics_enable']) && $mainOptionsFromPost['analytics_enable'] == 'off') {

      $mainOptionsFromPost['wpdb_enable'] = 'off';
    }

//        error_log('auxarray - '. print_rr($mainOptionsFromPost,true));

    update_option(DZSAP_DBNAME_OPTIONS, $mainOptionsFromPost);
    die();
  }


  function add_to_wishlist() {

    global $dzsap;

    $arr_wishlist = $dzsap->get_wishlist();


    if ($_POST['wishlist_action'] == 'add') {
//	        echo 'addd';
      array_push($arr_wishlist, $_POST['playerid']);

//	        echo '$arr_wishlist 1 - '; print_rr($arr_wishlist);
    } else {

      foreach ($arr_wishlist as $lab => $val) {
        if ($val == $_POST['playerid']) {
          unset($arr_wishlist[$lab]);
        }
      }
    }

//        echo '$_POST - '; print_rr($_POST);
//        echo 'playerid - '; print_rr($_POST['playerid']);
//        echo '$arr_wishlist - '; print_rr($arr_wishlist);


    update_user_meta(get_current_user_id(), 'dzsap_wishlist', json_encode($arr_wishlist));


    die();
  }

  function get_pcm() {
    // todo: not useful
//    echo '';

    global $dzsap;

    $id = '';


    if (isset($_POST['playerid']) && $_POST['playerid']) {
      $id = $_POST['playerid'];

    } else {

      if (isset($_POST['source']) && $_POST['source']) {
        $id = ($_POST['source']);
      }
    }


    echo $dzsap->generate_pcm($_POST, array(
      'generate_only_pcm' => true
    ));

    die();

    // -- no-go after this

    $id = DZSZoomSoundsHelper::sanitize_for_one_word($id);


    $fout = '';
    $lab = 'dzsap_pcm_data_' . $id;


    $pcm = '';
    $pcm = get_option($lab);

//        echo 'pcm - '.$pcm. ' - source ( $lab - '.$lab.' ) |||'."\n\n";
//                echo ' source ( dzsap_pcm_data_'.DZSZoomSoundsHelper::sanitize_for_one_word($che['source']).' )';

    if ($pcm == '' || $pcm == '[]') {

//            if(isset($che['linktomediafile'])){
//                if($che['linktomediafile']){
//                    $lab  = 'dzsap_pcm_data_'.$che['linktomediafile'];
//                }
//            }


      // -- its ok because playerid is prioritary
      if (($pcm == '' || $pcm == '[]') && isset($_POST['source']) && $_POST['source']) {
        $lab = 'dzsap_pcm_data_' . $_POST['source'];
        $pcm = get_option($lab);
      }

//                    echo 'lab - '.$lab;
//                    $lab = 'dzsap_pcm_data_735';

//                    echo 'lab - '.$lab;

//                    echo 'pcm - '.$pcm;

    }


    echo $pcm;


    die();
  }

  function get_thumb_from_meta() {

    //print_r($_POST);


//        echo 'hmm';

    $pid = $_POST['postdata'];


//        print_r($file);

//        print_r($metadata);


    if (get_post_meta($pid, '_dzsap-thumb', true)) {

      echo get_post_meta($pid, '_dzsap-thumb', true);
    } else {


      $upload_dir = wp_upload_dir();
      $upload_dir_url = $upload_dir['url'] . '/';
      $upload_dir_path = $upload_dir['path'] . '/';


//            print_r($upload_dir);


      $file = get_attached_file($pid);
      $metadata = wp_read_audio_metadata($file);
//            echo 'image data - ';
      if (isset($metadata['image']) && $metadata['image']['data']) {
//                echo base64_encode($metadata['image']['data']);


        file_put_contents($upload_dir_path . 'audio_image_' . $pid . '.jpg', $metadata['image']['data']);


        echo $upload_dir_url . 'audio_image_' . $pid . '.jpg';

      }
    }


//        $meta = wp_get_attachment_metadata($_POST['postdata']);

//        print_r($meta);


    die();
  }

  function front_submitcomment() {

    //print_r($_POST);

    $time = current_time('mysql');

    $playerid = $_POST['playerid'];
    $playerid = str_replace('ap', '', $playerid);

    $email = '';
    $comm_author = $_POST['skinwave_comments_account'];


    $user_id = get_current_user_id();
    $user_data = get_userdata($user_id);

//        print_r($user_data);

    if (isset($user_data->data)) {

      if (isset($user_data->data->ID)) {
        $email = $user_data->data->user_email;
        $comm_author = $user_data->data->user_login;
      }
    }


    $data = array(
      'comment_post_ID' => $playerid,
      'comment_author' => $comm_author,
      'comment_author_email' => $email,
      'comment_author_url' => $_POST['comm_position'],
      'comment_content' => $_POST['postdata'],
      'comment_type' => '',
      'comment_parent' => 0,
      'user_id' => 1,
      'comment_author_IP' => '127.0.0.1',
      'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
      'comment_date' => $time,
      'comment_approved' => 1,
    );

    wp_insert_comment($data);


    setcookie("commentsubmitted-" . $playerid, '1', time() + 36000, COOKIEPATH);

    print_r($data);

    echo 'success';
    die();
  }


  function create_activity_table() {

    global $wpdb;


    $auxarray['wpdb_enable'] = 'on';

    $table_name = $wpdb->prefix . 'dzsap_activity';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      //table not in database. Create new table
      $charset_collate = $wpdb->get_charset_collate();

      $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          type varchar(100) NOT NULL,
          id_user int(10) NOT NULL,
          ip varchar(255) NOT NULL,
          id_video varchar(255) NOT NULL,
          date datetime NOT NULL,
          UNIQUE KEY id (id)
     ) $charset_collate;";
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

    } else {
    }

    update_option('dzsap_table_activity_created', 'on');
  }


}