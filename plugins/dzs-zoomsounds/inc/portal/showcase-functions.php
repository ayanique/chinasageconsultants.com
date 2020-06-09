<?php
function dzsap_shortcode_woo_grid($atts, $content = null) {
  //[dzsap_woo_grid --]



  global $current_user,$dzsap;

  //print_r($current_user->data);
  //echo 'ceva'.isset($current_user->data->user_nicename);
  $dzsap->sliders__player_index++;

  $fout = '';


  $dzsap->front_scripts();
  wp_enqueue_style('dzs.zoomsounds-grid', $dzsap->base_url . 'audioplayer/audioportal-grid.css');

  $margs = array(
    'style' => 'under', // -- "under", "noir", "style1", "style2", "style3", "style4"
    'vpconfig' => '', // -- the player configuration
    'faketarget' => '', // -- ".dzsap_footer" will play tracks in footer
    'type' => 'product', // -- audio_items or product
    'title_is_permalink' => 'off', // -- title links to post
    'cats' => '', // -- the category id
    'count' => '10', // -- posts per page
    'ids' => '', // -- manual select ids
    'author_id' => '', // -- author id
    'extra_classes' => '', // -- extra classes
    'layout' => '4-cols', // -- the layout "3-cols"
    'pagination' => 'off', // -- the layout "3-cols"
    'settings_wpqargs' => '', // -- input options like "posts_per_page=7"
  );

  if ($atts) {

    $margs = array_merge($margs, $atts);
  }


  $args_wpqargs = array();
  $margs['settings_wpqargs'] = html_entity_decode($margs['settings_wpqargs']);
  parse_str($margs['settings_wpqargs'], $args_wpqargs);


  $wpqargs = array(
    'post_type' => $margs['type'],
    'posts_per_page' => '-1',
  );

  if ($margs['count']) {
    $wpqargs['posts_per_page'] = $margs['count'];
  }

  if (!isset($args_wpqargs) || $args_wpqargs == false || is_array($args_wpqargs) == false) {
    $args_wpqargs = array();
  }

  $taxonomy = 'product_cat';


  if ($wpqargs['post_type'] == 'audio_items') {
    $taxonomy = 'dzsap_category';
  }

  if ($margs['type'] == 'attachment') {
    $wpqargs['post_mime_type'] = 'audio/mpeg';
//            $wpqargs['post_mime_type'] = 'image';

    $wpqargs['post_parent'] = null;
    $wpqargs['post_status'] = 'inherit';
  }

  $paged = '1';

  if($wpqargs['posts_per_page']!='-1'){
    if(isset($_GET['dzsapp_paged'])){
      $paged = $_GET['dzsapp_paged'];
    }
    $wpqargs['paged'] = $paged;
  }

  if ($margs['cats']) {


    $thecustomcats = array();
    $thecustomcats = explode(',', $margs['cats']);
    $thecustomcats = array_values($thecustomcats);

    foreach ($thecustomcats as $lab => $val) {

      $thecustomcats[$lab] = $dzsap->sanitize_term_slug_to_id($val, $taxonomy);
    }

    if ($wpqargs['post_type'] == 'product' || $wpqargs['post_type'] == 'audio_items') {
      $wpqargs['tax_query'] = array(
        array(
          'taxonomy' => $taxonomy,
          'field' => 'id',
          'terms' => $thecustomcats,
        )
      );
    }


    if ($wpqargs['post_type'] == 'attachment') {
    }


  }


  if (isset($_GET['query_song_tag']) && $_GET['query_song_tag']) {


    $taxonomy = 'dzsap_tags';

    $tax_query = array(

      'taxonomy' => $taxonomy,
      'field' => 'slug',
      'terms' => $_GET['query_song_tag'],
    );
    if (isset($wpqargs['tax_query']) && count($wpqargs['tax_query'])) {

      array_push($wpqargs['tax_query'], $tax_query);
    } else {
      $wpqargs['tax_query'] = array(
        $tax_query
      );
    }
  }

//        print_rr($thecustomcats);

  if ($margs['ids']) {

    $aux_arr = explode(',', $margs['ids']);

    $wpqargs['post__in'] = $aux_arr;


  }

  $str_layout = '';

  $str_layout .= 'dzs-layout--' . $margs['layout'];

  $wpqargs = array_merge($wpqargs, $args_wpqargs);


//    $margs['author_id'] = str_replace('{{author_id}}')
  if ($margs['author_id']) {
    $wpqargs['author'] = $margs['author_id'];
  }
//    print_rr($wpqargs);


  // -- wp query here
  $query = new WP_Query($wpqargs);


  $its = $query->posts;


//        echo ' query -5'; print_rr($query);;

  if ($margs['style'] == 'noir' || $margs['style'] == 'style1' || $margs['style'] == 'style2') {

    $fout .= '<div class="dzsap-grid '.$margs['extra_classes'].' ' . $str_layout . ' style-' . $margs['style'] . '">';
  } else {
    $fout .= '<div class="dzsap-woo-grid '.$margs['extra_classes'].' style-' . $margs['style'] . '">';

  }


  if ($margs['style'] == 'style4') {
    $fout .= '<ul class="style-nova">';
  }
  if ($margs['style'] == 'style3') {
    $fout .= '<div class="dzsap-header-tr">
                            <div class="column-for-player">' . $dzsap->mainoptions['i18n_play'] . '</div>
                            <div class="column-for-title">' . $dzsap->mainoptions['i18n_title'] . '</div>
                            <div class="column-for-buy">' . $dzsap->mainoptions['i18n_buy'] . '</div>
                        </div>';

//            print_r($its);
  }


  if(intval($query->found_posts) > intval($wpqargs['posts_per_page'])){
    if($margs['pagination']=='auto'){
      $margs['pagination'] = 'on';
    }
  }




  // -- start the loop
  foreach ($its as $it) {


    $src = get_post_meta($it->ID, 'dzsap_woo_product_track', true);

    if ($margs['type'] == 'product') {
      if ($src == '') {
        $aux = get_post_meta($it->ID, '_downloadable_files', true);
        if ($aux && is_array($aux)) {

          $aux = array_values($aux);


          if (isset($aux[0]) && isset($aux[0]['file']) && strpos(strtolower($aux[0]['file']), '.mp3') !== false) {

            $src = $aux[0]['file'];
          }
        }

//                    echo '$aux - ';print_r($aux);
      }
    }

    $type = 'audio';

//            print_r($margs);
    if ($margs['type'] == 'dzsap_items') {
      $src = get_post_meta($it->ID, 'dzsap_meta_item_source', true);
      $type = get_post_meta($it->ID, 'dzsap_meta_type', true);
    }

    if ($margs['type'] == 'attachment') {
      $src = $it->guid;

//                print_r($margs);
    }

    $buy_link = site_url() . '/cart/?add-to-cart=' . $it->ID;


//            print_r($it);
//            echo 'hmm';
//            echo dzs_curr_url();
    $buy_link = DZSHelpers::remove_query_arg(dzs_curr_url(), '0');
    $buy_link = DZSHelpers::remove_query_arg(dzs_curr_url(), 'dzswtl_action');
    $buy_link = add_query_arg(array(
      'add-to-cart' => $it->ID

    ), $buy_link);

    if (strpos($buy_link, '?') === false) {

      $buy_link = str_replace('&add-to-cart', '?add-to-cart', $buy_link);
    }

    if (get_post_meta($it->ID, 'dzsap_woo_custom_link', true)) {

      $buy_link = get_post_meta($it->ID, 'dzsap_woo_custom_link', true);
    }


    if ($src) {

    } else {
      continue;
    }

    if ($margs['style'] == 'noir' || $margs['style'] == 'style1' || $margs['style'] == 'style2') {
      $fout .= '<div class="dzs-layout-item "';
      $fout .= '>';
      $fout .= '<div class="grid-object ';


      $fout .= '"';
      $fout .= '>';
    } else {

      if ($margs['style'] != 'style4') {
        $fout .= '<div class="grid-object ';

        if ($src) {
          $fout .= ' zoomsounds-woo-grid-item';
        }
        $fout .= '">';
      }
    }


    $cue = 'on';
    $thumb_url = '';
    $title = '';

    $shortdesc = '';
    $longdesc = '';


    $price = get_post_meta($it->ID, 'dzsap_meta_item_price', true);

    if ($margs['type'] == 'product') {
      if (get_post_meta($it->ID, '_regular_price', true)) {
        $price = '';
        if (function_exists('get_woocommerce_currency_symbol')) {
          $price .= get_woocommerce_currency_symbol();
        }
        $price .= get_post_meta($it->ID, '_regular_price', true);
      }
    }


    if ($margs['faketarget']) {

//                    $type='fake';

    }

    $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($it->ID), 'large');
    if (is_array($thumb_url) && isset($thumb_url[0])) {
      $thumb_url = $thumb_url[0];
    }
    if ($margs['type'] == 'attachment' && get_post_meta($it->ID, '_dzsap-thumb', true)) {
      $thumb_url = get_post_meta($it->ID, '_dzsap-thumb', true);
    }


    $html_meta_artist = '';

    $title = $it->post_title;
    $shortdesc = get_post_meta($it->ID, 'dzsap_woo_subtitle', true);
    $longdesc = $it->post_excerpt;

    $user_info = get_userdata($it->post_author);
//            print_r($it);
//            print_r($user_info);
    $author_name = $user_info->data->display_name;

    if ($title) {
      $html_meta_artist = '<div class="meta-artist"><span class="the-artist">' . $author_name . '</span><span class="the-name">' . $title . '</span></div>';
    }


    $str_pcm = '';

    if ($dzsap->mainoptions['skinwave_wave_mode'] == 'canvas') {
//                print_r($che);


      $args = array(
        'source' => $src,
        'linktomediafile' => $it->ID,
        'playerid' => $it->ID,
      );

      $str_pcm .= $dzsap->generate_pcm($args);
    } else {

    }


    $wavebg = get_post_meta($it->ID, 'dzsap_woo_product_track_waveformbg', true);
    $waveprog = get_post_meta($it->ID, 'dzsap_woo_product_track_waveformprog', true);

    if ($margs['style'] == 'under') {

      // -- under here

//                print_r($it);


      if ($margs['faketarget']) {

//                    $type='fake';

      }

      $args = array(

        'source' => $src,
        'cue' => $cue,
        'config' => $margs['vpconfig'],
        'autoplay' => 'off',
        'show_tags' => 'on',
        'title_is_permalink' => $margs['title_is_permalink'],
        'type' => $type,
        'faketarget' => $margs['faketarget'],
        'sample_time_start' => get_post_meta($it->ID, 'dzsap_woo_sample_time_start', true),
        'sample_time_end' => get_post_meta($it->ID, 'dzsap_woo_sample_time_end', true),
        'sample_time_total' => get_post_meta($it->ID, 'dzsap_woo_sample_time_total', true),
        'playerid' => $it->ID,
        'thumb' => $dzsap->get_thumbnail($it->ID),
        'thumbnail' => $dzsap->get_thumbnail($it->ID),
        'called_from' => 'woogrid under',
      );


//                print_r($args);

      $taxonomy = 'dzsap_tags';


      $term_list = wp_get_post_terms($it->ID, $taxonomy, array("fields" => "all"));


//	            echo '$it->ID - '.$it->ID;print_rr($term_list);


      $fout .= $dzsap->shortcode_player($args);

    }


    if ($margs['style'] == 'style4') {


      $fout .= '<li><div class="li-thumb" style="background-image: url(' . $thumb_url . ')">';


      $args = array(

        'source' => $src,
        'cue' => $cue,
        'extra_classes_player' => 'center-it',
        'config' => array(
          'skin_ap' => 'skin-customcontrols'
        ),
        'inner_html' => ' <div class="custom-play-btn playbtn-darkround" data-border-radius="5px" data-size="30px"></div>
        <div class="custom-pause-btn pausebtn-darkround" data-border-radius="5px" data-size="30px"></div>

        <div class="meta-artist-con">

            <span class="the-artist">' . $title . '</span>
            <span class="the-name">' . $shortdesc . '</span>
        </div>',
        'autoplay' => 'off',
        'type' => $type,
        'faketarget' => $margs['faketarget'],
        'sample_time_start' => get_post_meta($it->ID, 'dzsap_woo_sample_time_start', true),
        'sample_time_end' => get_post_meta($it->ID, 'dzsap_woo_sample_time_end', true),
        'sample_time_total' => get_post_meta($it->ID, 'dzsap_woo_sample_time_total', true),
        'playerid' => $it->ID,
        'called_from' => 'woogrid style4',
      );


//                print_r($args);

      $fout .= $dzsap->shortcode_player($args);

      $fout .= '</div><div class="li-meta"> <a rel="nofollow" class="ajax-link track-title" href="' . $it->ID . '">' . $title . '</a><div class=" track-by">' . esc_html__("by", 'dzsap') . ' ' . $author_name . '</div><div class="the-price">' . esc_html__("Free", 'dzsap') . '</div></div></li>';


      // -- end style4

    }


    if ($margs['style'] == 'noir') {


//                print_r($it);

//                echo 'test'.$wavebg;


//                print_r($it);


      if ($margs['faketarget']) {

//                    $type='fake';

      }

      $args = array(

        'source' => $src,
        'cue' => $cue,
        'config' => $margs['vpconfig'],
        'autoplay' => 'off',
        'type' => $type,
        'faketarget' => $margs['faketarget'],
        'sample_time_start' => get_post_meta($it->ID, 'dzsap_woo_sample_time_start', true),
        'sample_time_end' => get_post_meta($it->ID, 'dzsap_woo_sample_time_end', true),
        'sample_time_total' => get_post_meta($it->ID, 'dzsap_woo_sample_time_total', true),
        'playerid' => $it->ID,
        'called_from' => 'woogrid noir',
      );


//                print_r($args);

      $fout .= $dzsap->shortcode_player($args);

      $fout .= '

                        <h4 class="the-title">' . $title . '</h4>
                        <div class="the-price">' . $price . '</div>

                         <a rel="nofollow"  href="' . $buy_link . '" class="dzs-button-dzsap padding-small"><span class="the-bg"></span><span class="the-text">' . $dzsap->mainoptions['i18n_buy'] . '</span></a>';
    }


    if ($margs['style'] == 'style1') {


//                print_r($it);

//                echo 'test'.$wavebg;


      if ($margs['type'] == 'attachment') {
        $shortdesc = $it->post_content;
      }

//                print_r($thumb_url);

      $buystring = ' <a rel="nofollow" href="' . $buy_link . '" class="button-buy" style="font-size: 16px;">' . $dzsap->mainoptions['i18n_buy'] . '</a>&nbsp;';


      $waveformbg_str = '';
      $waveformprog_str = '';

      if ($margs['type'] == 'attachment') {
        $buystring = '';

//                    echo 'ceva'.get_post_meta($it->ID,'_waveformbg',true);

        if (get_post_meta($it->ID, '_waveformbg', true)) {
          $wavebg .= get_post_meta($it->ID, '_waveformbg', true);
        }

        if (get_post_meta($it->ID, '_waveformprog', true)) {
          $waveprog = get_post_meta($it->ID, '_waveformprog', true);
        }

      }

      if ($thumb_url) {

        $fout .= '<img src="' . $thumb_url . '" class="fullwidth"/>';
      }


      // daon pizda masi
      // test test test test test2134541234567890 123456678o90

//                print_r($margs);


//                echo 'ceva'.$waveformbg_str;

      $fout .= '<div class="label-artist"> <a rel="nofollow" href="' . get_permalink($it->ID) . '">' . $title . '</a></div>
<div class="label-song">' . $shortdesc . '</div>
<div class="dzsap-grid-meta-buy" style="margin-top: 15px;">
' . $buystring;
      if ($src) {
        $fout .= '
<span href="#" class="button-buy audioplayer-song-changer from-style-1" style="font-size: 16px; background-color: #a861c6" data-fakeplayer="' . $margs['faketarget'] . '"  style="" data-thumb="' . $thumb_url . '"  data-bgimage="img/bg.jpg"';


        $fout .= $str_pcm;


        $fout .= ' data-type="' . $type . '" data-playerid="' . $it->ID . '" data-source="' . $src . '" >' . $dzsap->mainoptions['i18n_play'] . '
' . $html_meta_artist . '
</span>';

      }
      $fout .= '
</div>';
//$longdesc


    }


    if ($margs['style'] == 'style2') {

//                echo 'ceva';

//                print_r($it);


      if ($margs['faketarget']) {

//                    $type='fake';

      }

      $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($it->ID), 'large');
      if (is_array($thumb_url) && isset($thumb_url[0])) {
        $thumb_url = $thumb_url[0];
      }
      if ($margs['type'] == 'attachment') {
        $thumb_url = get_post_meta($it->ID, '_dzsap-thumb', true);
      }


      $title = $it->post_title;
      $shortdesc = get_post_meta($it->ID, 'dzsap_woo_subtitle', true);
      $longdesc = $it->post_excerpt;


      if ($margs['type'] == 'attachment') {
        $shortdesc = $it->post_content;
      }

//                print_r($thumb_url);


      $buystring = ' <a rel="nofollow" href="' . $buy_link . '" class="button-buy" style="font-size: 16px;">' . $dzsap->mainoptions['i18n_buy'] . '</a>&nbsp;';

      if ($margs['type'] == 'attachment') {
        $buystring = '';
      }


      $fout .= '<div class="dzsap-grid-style2-item">';

      if (isset($margs['style2_hover']) && $margs['style2_hover'] == 'play') {

        $fout .= '<div class="divimage" style="width: 100%; padding-top: 100%; background-image:url(' . $thumb_url . ');"></div>';
      } else {

        if ($thumb_url) {

          $fout .= '<img src="' . $thumb_url . '" class="fullwidth"/>';
        }

      }
      $fout .= '<div class="centered-content-con"><div class="centered-content">';


      if (isset($margs['style2_hover']) && $margs['style2_hover'] == 'play') {


        if ($src) {


          $args = array(

            'source' => $src,
            'cue' => $cue,
            'extra_classes_player' => 'center-it',
            'config' => array(
              'skin_ap' => 'skin-customcontrols'
            ),
            'inner_html' => ' <div class="custom-play-btn playbtn-darkround" data-border-radius="5px" data-size="30px"></div>
        <div class="custom-pause-btn pausebtn-darkround" data-border-radius="5px" data-size="30px"></div>

        <div class="meta-artist-con">

            <span class="the-artist">' . $title . '</span>
            <span class="the-name">' . $shortdesc . '</span>
        </div>',
            'autoplay' => 'off',
            'type' => $type,
            'faketarget' => $margs['faketarget'],
            'sample_time_start' => get_post_meta($it->ID, 'dzsap_woo_sample_time_start', true),
            'sample_time_end' => get_post_meta($it->ID, 'dzsap_woo_sample_time_end', true),
            'sample_time_total' => get_post_meta($it->ID, 'dzsap_woo_sample_time_total', true),
            'playerid' => $it->ID,
            'called_from' => 'woogrid style2 grid play',
          );
          $fout .= $dzsap->shortcode_player($args);


        }

      } else {
        $fout .= '<div class="label-artist">' . $title . '</div>
<div class="label-song">' . $shortdesc . '</div>
<div class="dzsap-grid-meta-buy" style="margin-top: 15px;">
' . $buystring;


        if ($src) {

          $fout .= '
<span href="#" class="button-buy audioplayer-song-changer" style="font-size: 16px; background-color: #a861c6" data-fakeplayer="' . $margs['faketarget'] . '"  style="" data-thumb="' . $thumb_url . '"  data-bgimage="img/bg.jpg" data-scrubbg="' . $wavebg . '" data-scrubprog="' . $waveprog . '"  data-playerid="' . $it->ID . '" data-type="' . $type . '" data-source="' . $src . '" >' . $dzsap->mainoptions['i18n_play'] . '
' . $longdesc . '
</span>';
        }
        $fout .= '</div>';
      }


      $fout .= '
</div>
</div>';


      $fout .= '
</div>';


      if (isset($margs['style2_hover']) && $margs['style2_hover'] == 'play') {
        $fout .= '<h3>';
        $fout .= $title;
        $fout .= '</h3>';
      }


    }


    if ($margs['style'] == 'style3') {

//                echo 'ceva';

//                print_r($it);


      if ($margs['faketarget']) {

//                    $type='fake';

      }

      $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($it->ID), 'large');
      if (is_array($thumb_url) && isset($thumb_url[0])) {
        $thumb_url = $thumb_url[0];
      }


      if ($margs['type'] == 'attachment') {
        $thumb_url = get_post_meta($it->ID, '_dzsap-thumb', true);
      }


      $title = $it->post_title;
      $shortdesc = get_post_meta($it->ID, 'dzsap_woo_subtitle', true);
      $longdesc = $it->post_excerpt;


      if (get_permalink($it->ID)) {

        $title = ' <a rel="nofollow" href="' . get_permalink($it->ID) . '">' . $title . '</a>';
      }


      if ($margs['type'] == 'attachment') {
        $shortdesc = $it->post_content;
      }

//                print_r($thumb_url);

//                echo '$buy_link - '.$buy_link;

      $buystring = ' <a rel="nofollow" href="' . $buy_link . '" class="button-buy grid-buy-btn" style="font-size: 16px;">' . $dzsap->mainoptions['i18n_buy'] . '</a>';

      if ($margs['type'] == 'attachment') {
        $buystring = '';
      }

//                print_r($margs);
//                print_r($it);
      $args = array(

        'source' => $src,
        'cue' => $cue,
        'height' => '',
        'extra_classes_player' => 'position-relative',
        'config' => array(

          'skin_ap' => 'skin-customcontrols'
        ),
        'autoplay' => 'off',
        'type' => $type,
        'faketarget' => $margs['faketarget'],
        'inner_html' => ' <div class="custom-play-btn position-relative playbtn-darkround" data-border-radius="5px" data-size="30px"></div>
        <div class="custom-pause-btn position-relative pausebtn-darkround" data-border-radius="5px" data-size="30px"></div>

        <div class="meta-artist-con">

            <span class="the-artist">' . $title . '</span>
            <span class="the-name">' . $shortdesc . '</span>
        </div>',
        'sample_time_start' => get_post_meta($it->ID, 'dzsap_woo_sample_time_start', true),
        'sample_time_end' => get_post_meta($it->ID, 'dzsap_woo_sample_time_end', true),
        'sample_time_total' => get_post_meta($it->ID, 'dzsap_woo_sample_time_total', true),
        'playerid' => $it->ID,
        'called_from' => ' woo_grid',
      );


//                print_r($args);


      /*
               *
               * <div  data-type="audio" class="audioplayer-tobe skin-customcontrols auto-init position-relative "   data-fakeplayer="'.$margs['faketarget'].'"  data-source="'.$src.'"  data-scrubbg="'.$wavebg.'" data-scrubprog="'.$waveprog.'" data-playfrom="last" data-type="'.$type.'" ';


              $fout.=$str_pcm;

              if($thumb_url){

                  $fout.=' data-thumb="'.$thumb_url.'"';
              }

              $fout.='>



  </div>
               */


      $fout .= '<div class="dzsap-product-tr">
<div class="column-for-player">
';
      $fout .= $dzsap->shortcode_player($args);

      $fout .= '

</div>';

      $fout .= '
<div class="column-for-title">';


      /*
              $fout.=$title;

              if($shortdesc){
                  $fout.='- '.$shortdesc;
              }
              */


      $fout .= '';


//                $author_user = get_user_by('id',$it->post_author);

//                print_r($author_user);

      $fout .= $title;

      $fout .= ' - ' . $author_name;


      $fout .= '</div>';


//                print_r($it);


      $fout .= '<div class="column-for-buy">' . $buystring . '</div>
</div>';


    }


    if ($margs['style'] == 'noir' || $margs['style'] == 'style1' || $margs['style'] == 'style2') {
      $fout .= '</div>';
      $fout .= '</div>';
    } else {

      if ($margs['style'] != 'style4') {
        $fout .= '</div>';
      }
    }
  }


  if ($margs['style'] == 'style4') {
    $fout .= '</ul>';
  }





  if($margs['pagination']==='on'){
    $fout.='<div class="dzs-pagination-con">';
    $fout.= dzs_pagination($query->max_num_pages, 3, array(

      'container_class'=>'dzs-pagination ',
      'include_raquo'=>true,
      'style'=>'div',
      'paged'=>$paged,
      'a_class'=>'pagination-item',
      'wrap_before_text'=>'',
      'wrap_after_text'=>'',
      'link_style'=>'dzsapp_paged',
    ));
    $fout.='</div>';
  }
  $fout .= '</div>';

//        print_r($its); print_r($margs); echo 'alceva'.$fout;

  return $fout;
}
