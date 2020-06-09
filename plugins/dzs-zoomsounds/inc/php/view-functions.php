<?php
function dzsap_generate_javascript_setting_for_player($vpsettings) {

  global $dzsap;
  $fout = '';

  if (isset($vpsettings)) {

    $arrPlayerSettingsArray = include(DZSAP_BASE_PATH . 'configs/config-player-config.php');

//    print_rr($arrPlayerSettingsArray);

    foreach ($arrPlayerSettingsArray as $key => $optArr) {

      $jsName = $key;
      if (isset($optArr['jsName']) && $optArr['jsName']) {
        $jsName = $optArr['jsName'];
      }

      $value = null;

      if (isset($vpsettings[$key])) {
        $value = $vpsettings[$key];
      }


//      print_rr('$key 1 - '.$key. '.$value - '.$value.''.print_r($vpsettings,true));
      if($key=='skinwave_wave_mode_canvas_waves_number' || $key=='skinwave_wave_mode_canvas_waves_padding' || $key=='skinwave_wave_mode_canvas_reflection_size'){
        if(!$value){
          $value = $dzsap->mainoptions[$key];
        }
      }



      if(isset($optArr['default']) && $value!==null && $value===$optArr['default']){
        continue;
      }

//      print_rr('$key 2 - '.$key. '.$value - '.$value.''.print_r($vpsettings,true));
      if ($value!==null) {
        $fout .= ',' . $jsName . ':"' . $dzsap->sanitize_for_javascript_double_quote_value($value) . '"';
      }
    }

  }

  return $fout;
}

function dzsap_generate_audioplayer_settings($pargs = array(), $vpsettings = array(), $its = array(), $prev_func_margs = array()) {
  // -- @call from shortcode_player

  global $current_user, $post, $dzsap;
  $margs = array(
    'extra_classes' => 'search-align-right',
    'call_from' => 'default',
    'playerid' => '12345',
    'enc_margs' => '',
  );

  $fout = '';

  if (!is_array($pargs)) {
    $pargs = array();
  }
  $margs = array_merge($margs, $pargs);


  $player_id = $margs['playerid'];

  $fout .= '{';


  $preload_method = 'metadata';
  $design_animateplaypause = 'off';

  if (isset($vpsettings['preload_method'])) {
    $preload_method = $vpsettings['preload_method'];
  }
  if (isset($vpsettings['design_animateplaypause'])) {
    $design_animateplaypause = $vpsettings['design_animateplaypause'];
  }

  $loop = 'off';
  if (isset($vpsettings['loop']) && $vpsettings['loop'] == 'on') {
    $loop = $vpsettings['loop'];
  }

  $has_extra_html = false;

  // -- enable likes in player
  if (isset($prev_func_margs) && ($prev_func_margs['enable_views'] == 'on' || $prev_func_margs['enable_downloads_counter'] == 'on' || $prev_func_margs['enable_likes'] == 'on' || $prev_func_margs['enable_rates'] == 'on' || (isset($prev_func_margs['extra_html']) && $prev_func_margs['extra_html']))) {
    $has_extra_html = true;
  }


//                print_r($prev_func_margs);
  if (isset($prev_func_margs['loop']) && $prev_func_margs['loop'] == 'on') {
    $loop = 'on';
  }


  if ($margs['call_from'] == 'zoombox_open') {

    $fout .= '
    design_skin: "' . $vpsettings['settings']['skin_ap'] . '"
    ,skinwave_dynamicwaves:"' . $vpsettings['settings']['skinwave_dynamicwaves'] . '"
    ,disable_volume:"' . $vpsettings['settings']['disable_volume'] . '"
    ,disable_volume:"' . $vpsettings['settings']['loop'] . '"
    ,skinwave_enableSpectrum:"' . $vpsettings['settings']['skinwave_enablespectrum'] . '"
    ,skinwave_enableReflect:"' . $vpsettings['settings']['skinwave_enablereflect'] . '"
    ,skinwave_comments_enable:"' . $vpsettings['settings']['skinwave_comments_enable'] . '"';

    $fout .= ',settings_php_handler:window.ajaxurl';
    if (isset($vpsettings['settings']['settings_backup_type']) && $vpsettings['settings']['settings_backup_type']) {
      $fout .= ',settings_backup_type:"' . $vpsettings['settings']['settings_backup_type'] . '"';
    }
    if ($vpsettings['settings']['skinwave_comments_enable'] == 'on') {
      if (isset($current_user->data->user_nicename)) {
        $fout .= ',skinwave_comments_account:"' . $current_user->data->user_nicename . '"';
        $fout .= ',skinwave_comments_avatar:"' . $dzsap->get_avatar_url(get_avatar($current_user->data->ID, 20)) . '"';
        $fout .= ',skinwave_comments_playerid:"' . $prev_func_margs['playerid'] . '"';
      }
    }


    if (isset($vpsettings['settings']['disable_scrubbar'])) {
      $fout .= ',disable_scrub:"' . $vpsettings['settings']['disable_scrubbar'] . '"';
    }
  }


  // -- shortcode
  if ($margs['call_from'] == 'shortcode_player') {

    $fout .= '  design_skin: "' . $vpsettings['settings']['skin_ap'] . '"  ,autoplay: "' . $prev_func_margs['autoplay'] . '"';


    $fout .= dzsap_generate_javascript_setting_for_player($vpsettings['settings']);


    if ($dzsap->mainoptions['analytics_enable'] == 'on') {
      $fout .= ',action_video_contor_60secs : window.dzsap_wp_send_contor_60_secs';
    }

    $fout .= '  ,loop:"' . $loop . '"  ,cue: "' . $prev_func_margs['cue'] . '"  ,embedded: "' . $prev_func_margs['embedded'] . '"  ,preload_method:"' . $preload_method . '" ,design_animateplaypause:"' . $design_animateplaypause . '"  ';


    if ($dzsap->mainoptions['player_pause_method'] == 'stop') {
      $fout .= ',pause_method:"' . $dzsap->mainoptions['player_pause_method'] . '"';
    }


    if (get_post_meta($player_id, 'dzsap_total_time', true)) {

    } else {
      if ($prev_func_margs['type'] != 'fake' && $dzsap->mainoptions['try_to_cache_total_time'] == 'on') {
        $fout .= ',"action_received_time_total":' . 'window.dzsap_send_total_time' . '';
      }
    }


    if (isset($prev_func_margs['outer_comments_field']) && $prev_func_margs['outer_comments_field'] == 'on') {
      $fout .= ',skinwave_comments_mode_outer_selector: ".zoomsounds-comment-wrapper"';
    }

    if ($dzsap->mainoptions['mobile_disable_footer_player'] == 'on') {
      if (isset($prev_func_margs['called_from']) && $prev_func_margs['called_from'] == 'footer_player') {

        $fout .= ',mobile_delete: "on"';

      } else {
        $fout .= ',mobile_disable_fakeplayer: "on"';
      }
    }

    if ($dzsap->mainoptions['soundcloud_api_key']) {
      $fout .= ',soundcloud_apikey:"' . $dzsap->mainoptions['soundcloud_api_key'] . '"';
    }

    $fout .= ',settings_php_handler:window.ajaxurl';
    if (isset($vpsettings['settings']['skinwave_comments_enable']) && $vpsettings['settings']['skinwave_comments_enable'] == 'on') {
      if (isset($current_user->data->user_nicename)) {
        $fout .= ',skinwave_comments_account:"' . $current_user->data->user_nicename . '"';
        $fout .= ',skinwave_comments_avatar:"' . $dzsap->get_avatar_url(get_avatar($current_user->data->ID, 20)) . '"';
      }
    }




    $fout .= ',skinwave_wave_mode:"' . $dzsap->mainoptions['skinwave_wave_mode'] . '"';

//    $fout .= ',design_color_highlight: "' . $dzsap->sanitize_to_hex_color_without_hash($color_waveformprog) . '"';

    if ($its['settings']['skin_ap'] == 'skin-pro') {

    }



    if (isset($dzsap->mainoptions['skinwave_wave_mode_canvas_normalize']) && $dzsap->mainoptions['skinwave_wave_mode_canvas_normalize'] == 'off') {
      $fout .= ',skinwave_wave_mode_canvas_normalize:"' . $dzsap->mainoptions['skinwave_wave_mode_canvas_normalize'] . '"';
    }



    $lab = 'footer_btn_playlist';
    if ($prev_func_margs['called_from'] == 'footer_player' && isset($its['settings'][$lab]) && $its['settings'][$lab] && $its['settings'][$lab] == 'on') {
      $fout .= ',' . $lab . ':"' . $its['settings'][$lab] . '"';
      $fout .= ',construct_player_list_for_sync:"on"';
    }


    $fout .= ',skinwave_comments_playerid:"' . $prev_func_margs['playerid'] . '"';


    if ($prev_func_margs['js_settings_extrahtml_in_float_right']) {

      // -- here we set it
      $fout .= ',settings_extrahtml_in_float_right: \'' . $prev_func_margs['js_settings_extrahtml_in_float_right'] . '\'';


      if (strpos($prev_func_margs['js_settings_extrahtml_in_float_right'], 'dzsap-multisharer-but') !== false) {

        $dzsap->sw_enable_multisharer = true;

      }

    }



    if ($prev_func_margs['embedded'] != 'on') {

      $shouldShowEmbedButton = !!(isset($vpsettings['settings']['enable_embed_button']) && ($vpsettings['settings']['enable_embed_button'] == 'on' || $vpsettings['settings']['enable_embed_button'] == 'in_player_controls' || $vpsettings['settings']['enable_embed_button'] == 'in_extra_html' || $vpsettings['settings']['enable_embed_button'] == 'in_lightbox'));

      if ($shouldShowEmbedButton) {
        $enc_margs = '';
        $embed_code = '';


        // -- if we have embed_code already set
        if (isset($prev_func_margs['embed_code']) && $prev_func_margs['embed_code']) {
          $embed_code = $prev_func_margs['embed_code'];
        } else {

          if (isset($prev_func_margs['enc_margs'])) {
            $enc_margs = $prev_func_margs['enc_margs'];
          }
          if ($enc_margs) {

            $embed_code = $dzsap->generate_embed_code(array(
              'call_from' => 'shortcode_player',
              'enc_margs' => $enc_margs,
            ));
          }
        }

        $fout .= ',embed_code:"' . $embed_code . '"
';

        if ($has_extra_html) {

        } else {

          if ($vpsettings['settings']['enable_embed_button'] == 'on' || $vpsettings['settings']['enable_embed_button'] == 'in_player_controls') {

            $fout .= ',enable_embed_button:"' . 'on' . '"';
          }

        }
      }
    }


//                print_r($dzsap->mainoptions);

    if ($dzsap->mainoptions['failsafe_repair_media_element'] == 'on') {
      $fout .= ',failsafe_repair_media_element:1000';
    }

    if ($dzsap->mainoptions['construct_player_list_for_sync'] == 'on') {
      $fout .= ',construct_player_list_for_sync:"' . $dzsap->mainoptions['construct_player_list_for_sync'] . '"';
    }


    if ($dzsap->mainoptions['soundcloud_api_key']) {
      $fout .= ',php_retriever:"' . $dzsap->base_url . 'soundcloudretriever.php" ';
    }

    $fout .= $prev_func_margs['extra_init_settings'];
  }
  $fout .= '}';

  return $fout;
}

