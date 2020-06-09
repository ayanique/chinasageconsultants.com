<?php
// -- [zoomsounds_showcase feed_from="audio_items" count="5"]

$fout = '';
$margs = array(
  'feed_from' => 'audio_items', // -- audio_items ( Audio Items ) or products ( WooCommerce )
  'cat' => '', // -- input a category slug
  'paged' => '', // -- the page number
  'slideshow_time' => '100', // -- slideshow number in seconds for
  'count' => '5', // -- number of items per page
  'orderby' => 'date', // -- date, likes, views
  'ids' => '', // -- select some ids for example 1,2,50 / ids="1,2,3"
  'style' => 'scroller',// -- style - "playlist" or "widget" "player" or "scroller" or "featured_slider"
  'order' => 'DESC', // -- DESC ( descending ) or ASC
  'scroller_per_row' => '3', // -- number of rows per page
  'play_in_footer' => 'off', // -- date, likes, views
);


if (!is_array($pargs)) {
  $pargs = array();
}
$margs = array_merge($margs, $pargs);

//print_rr($margs);

$its = array();
if ($margs['feed_from']) {
  $fout .= '<div class="dzsap-showcase-con">';

  if ($margs['ids']) {

  }

  $wpqargs = array();
  $wpqargs['posts_per_page'] = '-1';
  $wpqargs['post_type'] = 'any';
  $wpqargs['orderby'] = $margs['orderby'];
  $wpqargs['order'] = $margs['order'];

  if ($margs['count']) {

    $wpqargs['posts_per_page'] = $margs['count'];
  }
  if ($margs['orderby'] == 'likes') {
    $wpqargs['posts_per_page'] = '-1';

  }
  if ($margs['feed_from'] == 'audio_items') {
    $wpqargs['post_type'] = 'dzsap_items';
  }


  if ($margs['ids']) {
    $wpqargs['post__in'] = explode(',', $margs['ids']);
  }

//            print_rr($margs['ids']);

  $query = new WP_Query($wpqargs);


//            echo 'query -5 '; print_rr($query);
//            print_rr($query->posts);


  $its = $dzsap->transform_to_array_for_parse($query->posts, $margs);


  if ($margs['orderby'] == 'views') {

//	  print_rr($its);

    usort($its, "dzsap_sort_by_views");
//            print_r($auxa);
//		$its = array_reverse($its);
//            print_r($auxa);

    if ($margs['count']) {

      $its = array_slice($its, 0, intval($margs['count']));   // returns "a", "b", and "c"
    }
  }


  if ($margs['orderby'] == 'likes') {

    usort($its, "dzsap_sort_by_likes");
//            print_r($auxa);
//		$its = array_reverse($its);
//            print_r($auxa);

    if ($margs['count']) {

      $its = array_slice($its, 0, intval($margs['count']));   // returns "a", "b", and "c"
    }
  }


//            echo 'its - ';print_rr($its);


  if ($margs['style'] == 'playlist') {

    $args = array(
      'ids' => '1'
    , 'embedded_in_zoombox' => 'off'
    , 'embedded' => 'off'
    , 'db' => 'main'
    );

//            if ($pargs == '') {
//                $atts = array();
//            }

//            $args = array_merge($args, $atts);

//            $po_array = explode(",", $args['ids']);

    $gallery_id = 'playlist_gallery';

    $fout .= '[zoomsounds id="' . $gallery_id . '" embedded="' . $args['embedded'] . '" extra_classes="from-wc-album" for_embed_ids="' . $margs['ids'] . '"]';


    if ($dzsap->mainoptions['playlists_mode'] == 'normal') {
      $tax = $dzsap->taxname_sliders;
      $reference_term = get_term_by('slug', $gallery_id, $tax);
      $selected_term_id = $reference_term->term_id;
      $term_meta = get_option("taxonomy_$selected_term_id");
    }


//    echo '$selected_term_id - '.$selected_term_id;
    $dzsap->get_its_settings($its, $margs, $term_meta, $selected_term_id);


//    print_rr($its);


    $dzsap->front_scripts();


    $dzsap->sliders_index++;


    $i = 0;
    $k = 0;
    $id = 'playlist_gallery';
    if (isset($margs['id'])) {
      $id = $margs['id'];
    }

    //echo 'ceva' . $id;

//    error_log('$dzsap->mainitems - '.print_r($dzsap->mainitems,true));

    // TODO: legacy, but new ?


//    print_rr($dzsap->mainoptions);
    if ($dzsap->mainoptions['playlists_mode'] == 'legacy') {
      for ($i = 0; $i < count($dzsap->mainitems); $i++) {
        if ((isset($id)) && ($id == $dzsap->mainitems[$i]['settings']['id']))
          $k = $i;
      }
    }


//        print_r($its);

    $enable_likes = 'off';

    $enable_views = 'off';
    $enable_downloads_counter = 'off';


//		print_rr($its);

    $its = array_reverse($its);

    foreach ($its as $it) {

//                $po = get_post($po_id);

//            print_r($po);

//                print_rr($it);


//            echo 'ceva2'.(get_post_meta($po_id,'_waveformprog',true));

//            print_r(wp_get_attachment_metadata($po_id));

      // -- this is settings item .. we don't do nothing
      if (isset($it['design_menu_state'])) {
        continue;
      }

      $po = get_post($it['id']);


      $desc = ' ';
      $title = ' ';
      $title = $po->post_title;
      $desc = $po->post_title;
//                $title = str_replace(array('"', '[',']'),'&quot;',$title);
//                $desc = $po->post_content;
//                $desc = str_replace(array('"', '[',']'),'&quot;',$desc);

      $src = $it['source'];


      if ($dzsap->mainoptions['try_to_hide_url'] == 'on') {

//                    print_r($_SESSION);

        $nonce = '{{generatenonce}}';


        $nonce = rand(0, 10000);

        $id = $it['id'];


        $lab = 'dzsap_nonce_for_' . $id . '_ip_' . $_SERVER['REMOTE_ADDR'];

        $lab = $dzsap->clean($lab);
        $_SESSION[$lab] = $nonce;

        $src = site_url() . '/index.php?dzsap_action=get_track_source&id=' . $id . '&' . $lab . '=' . $nonce;
      }


      $sample_time_start = get_post_meta($it['id'], 'dzsap_woo_sample_time_start', true);
      $sample_time_end = get_post_meta($it['id'], 'dzsap_woo_sample_time_end', true);
      $sample_time_total = get_post_meta($it['id'], 'dzsap_woo_sample_time_total', true);


      $config = 'playlist_player';

      if (isset($margs['player_config']) && $margs['player_config']) {
        $config = $margs['player_config'];
      }


      //called_from="playlist_showcase"

      $fout .= '[zoomsounds_player  source="' . $src . '" config="' . $config . '" playerid="' . $it['id'] . '"  thumb="" autoplay="on" cue="auto" enable_likes="' . $enable_likes . '" enable_views="' . $enable_views . '"  enable_downloads_counter="' . $enable_downloads_counter . '" songname="' . $title . '" artistname="' . $desc . '" init_player="off" called_from="playlist_showcase"';


      if ($sample_time_start) {

        $fout .= ' sample_time_start="' . $sample_time_start . '"';
      }
      if ($sample_time_end) {
        $fout .= ' sample_time_end="' . $sample_time_end . '"';
      }
      if (isset($its['settings'])) {
        if ($its['settings']['enable_likes'] == 'on') {
          $fout .= ' enable_likes="' . 'on' . '"';
        }
        if ($its['settings']['enable_views'] == 'on') {
          $fout .= ' enable_views="' . 'on' . '"';
        }
      }
      if ($sample_time_total) {
        $fout .= ' sample_time_total="' . $sample_time_total . '"';
      }

      $fout .= ']';
    }
    $fout .= '[/zoomsounds]';


//            echo 'shortcode - '.$fout;
//            echo 'do_shortcode - '.do_shortcode($fout);

//    echo $fout;

    $fout = do_shortcode($fout);
  }


  //- list


  $i_number = 0;
  if ($margs['style'] === 'widget_player') {
    $fout .= '<div class="list-tracks-con">';

//            print_r($margs);


//    echo 'its - '; print_rr($its);
    foreach ($its as $track) {

//                print_r($track);


      $link = get_permalink($track['id']);


      $fout .= '<a class="list-track ajax-link" href="' . $link . '">';

      $fout .= '<div class="track-thumb"';

      $l = '';

      if (isset($track['thumbnail'])) {

        $l = $dzsap->sanitize_id_to_src($track['thumbnail']);
      }


      $src_thumb = $l;


      $fout .= ' style="background-image: url(' . $src_thumb . ')"';

      $fout .= '>';
      $fout .= '</div>';


      $fout .= '<div class="track-meta">';
      $fout .= '<span class="track-title"';
      $fout .= '>';

      $fout .= '<span href="">' . $track['title'] . '</span>';

      $fout .= '</span>';


      if (isset($margs['artist_name_is_author_name']) && $margs['artist_name_is_author_name'] === 'on') {
        $track['artistname'] = $track['original_author_name'];
      }

      $fout .= '<div class="track-author"';
      $fout .= '>';

      $fout .= '<span >' . $track['artistname'] . '</span>';

      $fout .= '</div>';

      $fout .= '<div class="track-number"';
      $fout .= '><span class="the-number">';

      $track_number = ($i_number + 1);
      if ($margs['paged']) {
        $track_number += intval($margs['paged']) * $margs['limit_posts'];
      }

      $fout .= $track_number;

      $fout .= '</span></div>';


      $fout .= '</div>';


//			print_rr($margs);
      if ($margs['style_widget_player_show_likes'] === 'on') {
//				print_rr($track);

        $fout .= '<div class="likes-show">';

        $fout .= '<span class="the-count">';

        $str_likes = 0;
        if (isset($track['likes'])) {
          $str_likes = $track['likes'];
        }
        $fout .= $str_likes;
        $fout .= '</span>';

        $fout .= '<i class="fa fa-thumbs-up"></i>';


        $fout .= '</div>';
      }


      $fout .= '</a>';


      $i_number++;

    }
    $fout .= '</div>';


    wp_enqueue_script('audioplayer-showcase', $dzsap->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.js');
    wp_enqueue_style('audioplayer-showcase', $dzsap->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.css');
    wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


  }


  $i_number = 0;
  if ($margs['style'] === 'scroller') {
    $fout .= '<div class="contentscroller auto-init  transition-fade animate-height" data-options=\'{
"settings_direction": "horizontal"
,"settings_onlyone": "off"
,"settings_autoHeight_proportional": "off"
,"settings_autoHeight_proportional_max_height": "700"
,"settings_transition": "fade"
,"design_bulletspos": "none"
,"settings_slideshowTime": "' . $margs['slideshow_time'] . '"
,"per_row": "'.$margs['scroller_per_row'].'"
}\'>';

    $fout .= '<div class="arrowsCon arrow-skin-bare" style="text-align: right;">
<div class="single--arrow arrow-left">
<div class="arrow-con">
<i class="the-icon fa fa-chevron-left"></i>
</div>
</div>
<div class="single--arrow arrow-right">
<div class="arrow-con">
<i class="the-icon fa fa-chevron-right"></i>
</div>
</div>
</div>';

    $fout .= '<div class="items">';

//            print_r($margs);


//        print_rr($its);
    foreach ($its as $track) {

//                print_r($track);


      $link = get_permalink($track['id']);


      $src_thumb = '';
      $src = $track['source'];

      if (isset($track['thumbnail'])) {

        $src_thumb = $dzsap->sanitize_id_to_src($track['thumbnail']);
      }
      if ($src_thumb == '' && isset($track['id'])) {

        $src_thumb = $dzsap->get_thumbnail($track['id']);
      }

//      print_rr($track);
      $track_number = ($i_number + 1);


      $config_args = array(

        'id' => 'default',
        'skin_ap' => 'skin-wave',
        'disable_volume' => 'on',
        'playfrom' => 'default',
        'loop' => 'off',
        'cue_method' => 'on',
      );

      $play_in_footer = 'off';

      if ($margs['play_in_footer'] == 'on') {

        $play_in_footer = 'on';
      }
      if ($play_in_footer) {
        $config_args['play_target'] = 'footer';
      }

      $player_args = array(
        'source' => $src,
        'config' => $config_args,
        'title_is_permalink' => 'on',
        'extra_classes_player' => 'disable-volume center-it disable-all-but-play-btn  button-aspect-noir  button-aspect-noir--filled   ',
        'extraattr' => ' style=" width: 40px!important;height: 40px;"',
      );
      if ($play_in_footer) {
        $player_args['play_target'] = 'footer';
      }

      $fout .= '<div class="csc-item">
      <div class="showcase-scroller-item">
          <div  class="divimage full-square" data-src="' . $src_thumb . '">
  ' . $dzsap->shortcode_player($player_args) . '</div>
  <div class="showcase-scroller-item--meta">
      <div class="showcase-scroller-item--title">' . $track['artistname'] . '</div>
      <div class="showcase-scroller-item--subtitle"><a style="color:inherit;" href="' . get_permalink($track['id']) . '">' . $track['title'] . '</a></div>
  </div>


    </div>
</div>
';


      $i_number++;

    }
    $fout .= '</div>';
    $fout .= '</div>';


    wp_enqueue_script('audioplayer-showcase', $dzsap->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.js');
    wp_enqueue_style('audioplayer-showcase', $dzsap->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.css');

    wp_enqueue_script('dzscsc', $dzsap->base_url . 'libs/contentscroller/contentscroller.js');
    wp_enqueue_style('dzscsc', $dzsap->base_url . 'libs/contentscroller/contentscroller.css');
    wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


  }

  $i_number = 0;
  if ($margs['style'] === 'slider') {
    $fout .= '<div class="contentscroller auto-init  transition-fade animate-height" data-options=\'{
"settings_direction": "horizontal"
,"settings_onlyone": "on"
,"settings_autoHeight_proportional": "off"
,"settings_autoHeight_proportional_max_height": "700"
,"settings_transition": "fade"
,"design_bulletspos": "none"
,"settings_slideshowTime": "' . $margs['slideshow_time'] . '"
}\'>';

    $fout .= '<div class="items">';

//            print_r($margs);


//        print_rr($its);
    foreach ($its as $track) {

//                print_r($track);


      $link = get_permalink($track['id']);


      $src_thumb = '';
      $src = $track['source'];

//      print_rr($track);


      // -- this mode will prefer wrapper_image
      if (isset($track['wrapper_image'])) {

        $src_thumb = $track['wrapper_image'];
      } else {

        if (isset($track['thumbnail'])) {

          $src_thumb = $dzsap->sanitize_id_to_src($track['thumbnail']);
        }
        if ($src_thumb == '' && isset($track['id'])) {

          $src_thumb = $dzsap->get_thumbnail($track['id']);
        }
      }

//      print_rr($track);
      $track_number = ($i_number + 1);


      $fout .= '                        <div class="csc-item" style="position:relative;">
<div  class="divimage" data-src="' . $src_thumb . '"></div>';


      $fout .= '<div class="caption-con mode-appear-from-below show-on-active style-nove">

                    <div class="csc-caption--title">
                       ' . $track['artistname'] . '
                    </div>
                    <div class="csc-caption--subtitle">
                        <a class="csc-caption--subtitle_a" href="' . get_permalink($track['id']) . '">' . $track['title'] . '</a>
                    </div>

                </div>';
      $fout .= '
                        </div>
';


      $i_number++;

    }
    $fout .= '</div>';
    $fout .= '</div>';


    wp_enqueue_script('audioplayer-showcase', $dzsap->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.js');
    wp_enqueue_style('audioplayer-showcase', $dzsap->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.css');

    wp_enqueue_script('dzscsc', $dzsap->base_url . 'libs/contentscroller/contentscroller.js');
    wp_enqueue_style('dzscsc', $dzsap->base_url . 'libs/contentscroller/contentscroller.css');
    wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


  }
  // -- end slider


  $i_number = 0;
  if ($margs['style'] === 'featured_slider') {


    $fout.='<div class="dzs-row margin15">';
    $fout.='<div class="dzs-col-md-8"  style="">';
    $fout.='<div style="padding-top: 67.5%; position:relative;">';
    $fout .= '<div style=" width: 100%; height: 100%; position:absolute; top:0; left:0; " class="contentscroller auto-init  transition-fade animate-height" data-options=\'{
"settings_direction": "horizontal",
"settings_onlyone": "on",
"settings_autoHeight": "off",
"settings_autoHeight_proportional": "off",
"settings_autoHeight_proportional_max_height": "700",
"settings_transition": "fade",
"design_bulletspos": "none",
"outer_thumbs": "#cs2",
"outer_thumbs_keep_same_height": "on",
"settings_slideshowTime": "' . $margs['slideshow_time'] . '"
}\'>';

    $fout .= '<div class="items">';

//            print_r($margs);


//        print_rr($its);
    foreach ($its as $track) {

//                echo ' track-55 '; print_rr($track);


      $link = get_permalink($track['id']);


      $src_thumb = '';
      $src = $track['source'];

//      print_rr($track);


      // -- this mode will prefer wrapper_image
      if (isset($track['wrapper_image'])) {

        $src_thumb = $track['wrapper_image'];
      } else {

        if (isset($track['thumbnail'])) {

          $src_thumb = $dzsap->sanitize_id_to_src($track['thumbnail']);
        }
        if ($src_thumb == '' && isset($track['id'])) {

          $src_thumb = $dzsap->get_thumbnail($track['id'], array(
            'try_to_get_wrapper_image'=>'on'
          ));
        }
      }

//      print_rr($track);
      $track_number = ($i_number + 1);


      $fout .= '<div class="csc-item" style="position:relative;">
<div  class="divimage fullheight" data-src="' . $src_thumb . '"></div>';


      $fout .= '<div class="caption-con mode-appear-from-below show-on-active style-nove">
 <div class="csc-caption--title"> ' . $track['artistname'] . '</div>
 <div class="csc-caption--subtitle">
<a class="csc-caption--subtitle_a" href="' . get_permalink($track['id']) . '">' . $track['title'] . '</a>
</div>
</div>';
      $fout .= '</div>
';


      $i_number++;

    }



    $fout .= '</div>';
    $fout .= '</div>';


    $fout .= '</div>';


    $fout .= '</div>'; // -- end col


    $fout.='<div class="dzs-col-md-4">';
    $fout .= '<div id="cs2" class="contentscroller auto-init is-functional skin-nova transition-fade animate-height" style="height: 400px;" data-options=\'{
    "settings_direction": "vertical",
    "settings_onlyone": "off",
    "design_disableArrows": "on",
    "per_row": "'.$margs['scroller_per_row'].'",
    "nav_type": "slide",
    "settings_autoHeight": "off"
}\'>';

    $fout .= '<div class="items">';

//            print_r($margs);


//        print_rr($its);
    foreach ($its as $track) {

//                print_r($track);


      $link = get_permalink($track['id']);


      $src_thumb = '';
      $src = $track['source'];

//      print_rr($track);


      // -- this mode will prefer wrapper_image

      if (isset($track['thumbnail'])) {

        $src_thumb = $dzsap->sanitize_id_to_src($track['thumbnail']);
      }
      if ($src_thumb == '' && isset($track['id'])) {

        $src_thumb = $dzsap->get_thumbnail($track['id']);
      }


//      print_rr($track);
      $track_number = ($i_number + 1);


      $fout .= '                        <div class="csc-item" style="position:relative;">
<div  class="divimage" data-src="' . $src_thumb . '"></div>';

      $fout .= '</div>
';


      $i_number++;

    }



    $fout .= '</div>';
    $fout .= '</div>';







    $fout .= '</div>'; // -- end col
    $fout .= '</div>'; // -- end row

    wp_enqueue_script('audioplayer-showcase', DZSAP_BASE_URL . 'libs/audioplayer_showcase/audioplayer_showcase.js');
    wp_enqueue_style('audioplayer-showcase', DZSAP_BASE_URL . 'libs/audioplayer_showcase/audioplayer_showcase.css');

    wp_enqueue_script('dzscsc', DZSAP_BASE_URL . 'libs/contentscroller/contentscroller.js');
    wp_enqueue_style('dzscsc', DZSAP_BASE_URL . 'libs/contentscroller/contentscroller.css');



  }
  // -- END featured_slider


  $fout .= '</div>';
}