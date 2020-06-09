<?php

//print_r($this->mainoptions);

if ($_GET['dzsap_action'] == 'delete_waveforms') {

  if ($this->current_user_has_track($_GET['trackid'])) {

    // -- todo: action
    error_log('delete waveforms');


    dzsap_delete_waveform($_GET['trackid']);
    dzsap_delete_waveform($_GET['sanitized_source']);
  }
}


if ($_GET['dzsap_action'] == 'delete_track') {

  if ($this->current_user_has_track($_GET['track_id'])) {


    wp_delete_post($_GET['track_id']);
  }
}
if ($_GET['dzsap_action'] == 'generatenonce') {

  $id = $_GET['id'];


  $lab = 'dzsap_nonce_for_' . $id . '_ip_' . $_SERVER['REMOTE_ADDR'];
  $lab = DZSZoomSoundsHelper::sanitize_for_one_word($lab);


  $nonce = rand(0, 10000);

  //                $id = $it['id'];


//                error_log('id - '.$id);


  if ($_SESSION[$lab]) {

    $nonce = $_SESSION[$lab];
  } else {

    $_SESSION[$lab] = $nonce;
  }

  $src = site_url() . '/index.php?dzsap_action=get_track_source&id=' . $id . '&' . $lab . '=' . $nonce;

  echo $src;
  die();

}

if ($_GET['dzsap_action'] == 'get_track_source') {
  $id = $_GET['id'];
  $po = (get_post($id));
  $src_url = '';


  $src_url = get_post_meta($po->ID, 'dzsap_woo_product_track', true);


  $playerid = '';
  $args = array();
  if ($src_url == '') {
    $src_url = $this->get_track_source($po->ID, $playerid, $args);
  }


//                echo '$src_url - '.$src_url;


//                error_log('$src_url -> '.$src_url);


  if ($id && $src_url) {


//            echo 'whaaa';
    $this->sliders__player_index++;

    $fout = '';


//                    error_log(print_rrr($_SESSION));
//                    error_log(print_rrr($_GET));


    $lab = 'dzsap_nonce_for_' . $id . '_ip_' . $_SERVER['REMOTE_ADDR'];
    $lab = DZSZoomSoundsHelper::sanitize_for_one_word($lab);

    if ($_SESSION[$lab] == $_GET[$lab]) {


      $extension = "mp3";
      $mime_type = "audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3";
//
//
//                        error_log('src - '.$src);
//
//
//                        error_log('fileSize - '.$fileSize);
//                        error_log('fileSize - '.$fileSize);
//
////                        header('HTTP/1.1 206 Partial Content'); // Allows scanning in a stream.


//                        print_rr($_SERVER);
//                        echo 'site_url - '.site_url().'<br>';
//                        echo 'dirname(dirname(dirname(dirname(__FILE__)))) - '.dirname(dirname(dirname(dirname(__FILE__)))).'<br>';
//                        echo '$src_url - '.$src_url;


      // -- still in get_track_source

      if (strpos($src_url, site_url()) !== false) {

        $src = str_replace(site_url(), dirname(dirname(dirname(dirname(__FILE__)))), $src_url);
        $fileSize = filesize($src);

        header('Accept-Ranges: bytes'); // Allows scanning in a stream based on byte count.
        header('Content-type: ' . $mime_type);
//                        header("Content-transfer-encoding: binary");
        header('Content-length: ' . $fileSize);
        header('Content-Range: bytes ' . '0' . '-' . $fileSize); // This tells the player what byte we're starting with.
        header('Content-Disposition:  filename="' . $src);
        header('X-Pad: avoid browser bug');
        header('Cache-Control: no-cache');


        readfile($src);
        die();
      }
//
//
////                        echo file_get_contents($src);
//                        readfile($src);


//                        $_SESSION['dzsap_nonce_for_'.$id] = 'dada';


      $file = '';
      if (strpos($src_url, site_url()) !== false) {
        $file = str_replace(site_url(), dirname(dirname(dirname(dirname(__FILE__)))), $src_url);

      } else {


        if (ini_get('allow_url_fopen')) {
          echo file_get_contents($src_url);
        } else {


          $ch = curl_init($src_url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_TIMEOUT, 10);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          $cache = curl_exec($ch);
          curl_close($ch);

          echo $cache;
        }
        die();
      }

      $content_type = 'application/octet-stream';


      @error_reporting(0);

      // Make sure the files exists, otherwise we are wasting our time
      if (!file_exists($file)) {
        header("HTTP/1.1 404 Not Found");
        exit;
      }

      // Get file size
      $filesize = sprintf("%u", filesize($file));

      // Handle 'Range' header
      if (isset($_SERVER['HTTP_RANGE'])) {
        $range = $_SERVER['HTTP_RANGE'];
      } elseif ($apache = apache_request_headers()) {
        $headers = array();
        foreach ($apache as $header => $val) {
          $headers[strtolower($header)] = $val;
        }
        if (isset($headers['range'])) {
          $range = $headers['range'];
        } else $range = FALSE;
      } else $range = FALSE;

      //Is range
      if ($range) {
        $partial = true;
        list($param, $range) = explode('=', $range);
        // Bad request - range unit is not 'bytes'
        if (strtolower(trim($param)) != 'bytes') {
          header("HTTP/1.1 400 Invalid Request");
          exit;
        }
        // Get range values
        $range = explode(',', $range);
        $range = explode('-', $range[0]);
        // Deal with range values
        if ($range[0] === '') {
          $end = $filesize - 1;
          $start = $end - intval($range[0]);
        } else if ($range[1] === '') {
          $start = intval($range[0]);
          $end = $filesize - 1;
        } else {
          // Both numbers present, return specific range
          $start = intval($range[0]);
          $end = intval($range[1]);
          if ($end >= $filesize || (!$start && (!$end || $end == ($filesize - 1)))) $partial = false; // Invalid range/whole file specified, return whole file
        }
        $length = $end - $start + 1;
      } // No range requested
      else $partial = false;

      // Send standard headers
      header("Content-Type: $content_type");
      header("Content-Length: $filesize");
      header('Accept-Ranges: bytes');

      // send extra headers for range handling...
      if ($partial) {
        header('HTTP/1.1 206 Partial Content');
        header("Content-Range: bytes $start-$end/$filesize");
        if (!$fp = fopen($file, 'rb')) {
          header("HTTP/1.1 500 Internal Server Error");
          exit;
        }
        if ($start) fseek($fp, $start);
        while ($length) {
          set_time_limit(0);
          $read = ($length > 8192) ? 8192 : $length;
          $length -= $read;
          print(fread($fp, $read));
        }
        fclose($fp);
      } //just send the whole file
      else readfile($file);
      exit;


      /*
      */
    } else {

      die("nonce not correct " . $_SESSION[$lab] . '|' . $_GET[$lab]);
    }


//                    echo 'src - '.$src;


//        print_r($its); print_r($margs); echo 'alceva'.$fout;
  }


  die();

}


