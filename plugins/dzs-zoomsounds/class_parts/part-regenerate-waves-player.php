<?php


$id = DZSZoomSoundsHelper::sanitize_for_one_word($_GET['dzsap_generate_pcm']);

$lab = 'dzsap_pcm_data_' . ($id);


update_option($lab, '');

$a = array();
$b = array();
$source = $this->get_track_source($id, $a, $b);


if ($source) {

  $lab = 'dzsap_pcm_data_' . (DZSZoomSoundsHelper::sanitize_for_one_word($source));
  update_option($lab, '');
}
//	                echo 'source - '.$source;


?>
  <style>
    html {
      margin-top: 0 !important;
    }

    body > * {
      opacity: 0;
      display: none;
    }

    body > #ap_regenerate {
      opacity: 1;
      display: block;
    }
  </style>
  <script>
    jQuery(document).ready(function ($) {
      var aux = '';

      $('body').addClass('dzsap-ready');

      $('body').prepend('<div id="ap_regenerate" data-type="audio" class="audioplayer-tobe skin-wave " data-source="<?php echo $_GET['dzsap_source']; ?>" data-playerid="<?php echo $_GET['dzsap_generate_pcm']; ?>" data-playfrom="0"> </div>');

      // -- waveform regeneration ( generate_pcm )

      setTimeout(function () {
        dzsap_init(".audioplayer-tobe", {
          autoplay: "off",
          skinwave_mode: 'normal',
          settings_php_handler: window.ajaxurl // -- the path of the publisher.php file, this is used to handle comments, likes etc.,
          skinwave_wave_mode: 'canvas' // --- "normal" or "canvas",
          skinwave_wave_mode_canvas_waves_number: '3' // --- the number of waves in the canvas,
          skinwave_wave_mode_canvas_waves_padding: '1' // --- padding between waves,
          skinwave_wave_mode_canvas_reflection_size: '0.25' // --- the reflection size,
          pcm_data_try_to_generate: 'on' // --- try to find out the pcm data and sent it via ajax ( maybe send it via php_handler,
          skinwave_comments_enable: 'off' // -- enable the comments, publisher.php must be in the same folder as this html, also if you want the comments to automatically be taken from the database remember to set skinwave_comments_retrievefromajax to ON,
          failsafe_repair_media_element: 500 // -- light or full,
          settings_extrahtml_in_float_right: '<div class="orange-button dzstooltip-con" style="top:10px;"><span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right" style="width: auto; white-space: nowrap;">Add to Cart</span><i class="fa fa-shopping-cart"></i></div><div class="orange-button dzstooltip-con" style="top:10px;"><span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right" style="width: auto; white-space: nowrap;">Download</span><i class="fa fa-download"></i></div>'
        })
      })

//        $('body').children().css('display','none');
    });
    //    jQuery('body').children().css('display','none');
    console.info('regenerate waves');
  </script>


<?php
$this->enqueue_main_scripts();