<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24/04/2019
 * Time: 12:10
 */


class ZoomSoundsAjaxFunctions{
  public static   function import_slider($file_cont) {

    global $dzsap;

    $tax = $dzsap->taxname_sliders;
    $response_arr = array(
      'status'=>'success',
      'slider_name'=>'',
      'slider_slug'=>'',
    );
    try {

      $file_cont = str_replace('\\\\"', '\\"', $file_cont);
      $arr = @json_decode($file_cont, true);

      error_log('content json - ' . print_rr($arr, true));

      if ($arr && is_array($arr)) {

        $type = 'json';
      } else {
        try {

          $arr = unserialize($file_cont);


          error_log('content serial - ' . print_rr($arr, true) . ' - ' . print_rr($file_cont, true));
          $type = 'serial';
        } catch (Exception $e) {

          error_log('failed parsing' . print_rr($file_cont, true));
        }
      }

      if (is_array($arr)) {
        if ($type == 'json') {


          $reference_term_name = $arr['original_term_name'];
          $reference_term_slug = $arr['original_term_slug'];

//			    print_rr($reference_term_name);
//			    print_rr($reference_term_slug);
//			    print_rr($query);
          $original_name = $reference_term_name;
          $original_slug = $reference_term_slug;


          $new_term_slug = $reference_term_slug;
          $new_term_name = $reference_term_name;


          $ind = 1;
          $breaker = 100;


          $tax = $dzsap->taxname_sliders;
          $term = term_exists($new_term_name, $tax);
          if ($term !== 0 && $term !== null) {


            $new_term_name = $original_name . '-' . $ind;
            $new_term_slug = $original_slug . '-' . $ind;
            $ind++;


            // -- we will try to find
            while (1) {

              $term = term_exists($new_term_name, $tax);
              if ($term !== 0 && $term !== null) {

                $new_term_name = $original_name . '-' . $ind;
                $new_term_slug = $original_slug . '-' . $ind;
                $ind++;
              } else {

                error_log("SEEMS THAT TERM DOES NOT EXIST " . $new_term_name . ' ' . $new_term_slug);
                break;
              }

              $breaker--;

              if ($breaker < 0) {
                break;
              }
            }

          } else {


          }


          // -- import slider
          $new_term = wp_insert_term(
            $new_term_name, // the term
            $tax, // the taxonomy
            array(

              'slug' => $new_term_slug,
            )
          );

          $response_arr['slider_name'] = $new_term_name;
          $response_arr['slider_slug'] = $new_term_slug;


          $new_term_id = '';
          if (is_array($new_term)) {

            $new_term_id = $new_term['term_id'];
          } else {
            error_log(' .. ERROR the name is ' . $new_term_name);
            error_log(' .. $tax is ' . $tax);
            error_log(print_r($new_term, true));
          }


          if(!$arr['term_meta']){
            $arr['term_meta'] = array();
          }else{
            error_log('$arr empty ? '.print_r($arr,true));
          }

          $term_meta = array_merge(array(), $arr['term_meta']);

          unset($term_meta['items']);

          update_option("taxonomy_$new_term_id", $term_meta);


          foreach ($arr['items'] as $po) {

            // -i item in

            $args = array_merge(array(), $po);

            // -- we will prefer slug

            error_log('new slug - ' . $new_term_slug);
            $args['term'] = $new_term_slug;
            $args['taxonomy'] = $tax;
            $args['call_from'] = 'import_slider items json';

            $dzsap->import_demo_insert_post_complete($args);


          }

//			$new_term = get_term_by('slug',$new_term_slug,$tax);

//            error_log(print_rr($new_term,array('echo'=>false)));


        }


        // -- legacy
        if ($type == 'serial') {


          $new_term_id = '';
          $new_term = null;
          $original_slug = '';
          $new_term_slug = '';


          foreach ($arr as $lab => $val) {


            if ($lab === 'settings') {


              // -- settings


              $reference_term_name = $val['id'];
              $reference_term_slug = $val['id'];

//			    print_rr($reference_term_name);
//			    print_rr($reference_term_slug);
//			    print_rr($query);
              $original_name = $reference_term_name;
              $original_slug = $reference_term_slug;


              $new_term_slug = $reference_term_slug;
              $new_term_name = $reference_term_name;


              $ind = 1;
              $breaker = 100;


              $term = term_exists($new_term_slug, $tax);
              if ($term !== 0 && $term !== null) {


                while (1) {

                  $term = term_exists($new_term_slug, $tax);
                  if ($term !== 0 && $term !== null) {

                    $ind++;
                    $new_term_slug = $original_slug . '-' . $ind;
                  } else {
                    break;
                  }

                  $breaker--;

                  if ($breaker < 0) {
                    break;
                  }
                }

                $ind++;
                $new_term_name = $original_name . '-' . $ind;
                $new_term_slug = $original_slug . '-' . $ind;
              } else {

              }


              $new_term = wp_insert_term(
                $new_term_name, // the term
                $tax, // the taxonomy
                array(

                  'slug' => $new_term_slug,
                )
              );


              if (is_array($new_term)) {

                $new_term_id = $new_term['term_id'];
              } else {
                error_log(' .. the name is ' . $new_term_name);
                error_log(print_r($new_term, true));
              }


              $term_meta = array_merge(array(), $val);

              unset($term_meta['items']);

              update_option("taxonomy_$new_term_id", $term_meta);
            } else {
              // -- item in serial

              $args = array_merge(array(), $val);

              $args['term'] = $new_term;
              $args['taxonomy'] = $tax;
              $args['post_name'] = $original_slug . '-' . $lab;
              $args['post_title'] = $original_slug . '-' . $lab;

              if (isset($args['menu_artistname'])) {
                $args['post_title'] = $args['menu_artistname'];
              }
              if (isset($args['menu_songname'])) {
                $args['post_content'] = $args['menu_songname'];
              }

              // -- import slider meta values
              foreach ($dzsap->options_item_meta as $oim) {
                $long_name = $oim['name'];

                $short_name = str_replace('dzsap_meta_item_', '', $oim['name']);
                $short_name = str_replace('dzsap_meta_', '', $short_name);


                if (isset($args[$short_name])) {

                  $args[$long_name] = $args[$short_name];
                }
              }


              $args['call_from'] = 'import_slider items serial';

              $dzsap->import_demo_insert_post_complete($args);

            }


          }
        }
      }
    } catch (Exception $err) {
      print_rr($err);
    }

    return $response_arr;

  }

  public static function create_playlist_if_it_does_not_exist(){

    global $dzsap;


    if(isset($_POST['term_name'])){


      $new_term_name = $_POST['term_name'];
      $new_term_slug = $new_term_name;
      $tax = $dzsap->taxname_sliders;


      $term = term_exists( $new_term_name, $tax );

//      echo 'term - '.print_r($term,true);

      if ( !(0 !== $term && null !== $term) ) {

        // -- import slider
        $new_term = wp_insert_term(
          $new_term_name, // the term
          $tax, // the taxonomy
          array(

            'slug' => $new_term_slug,
          )
        );


        $new_term_id = '';
        if(is_array($new_term)){

          $new_term_id = $new_term['term_id'];
        }else{
          error_log(' .. ERROR the name is '.$new_term_name);
          error_log(' .. $tax is '.$tax);
          error_log(print_r($new_term,true));
        }

        echo ''.$new_term_id;
      }else{

        echo ''.''.$term['term_id'];
        error_log('.. create_playlist_if_it_does_not_exist term exists'.$new_term_name);


//        $term = get_term_by('slug', $new_term_name, $tax);
        error_log('.. term exists'.print_r($term,true));
      }


    }
    die();
  }

  public static function shoutcast_get_now_playing($arg){


    $final_metadata = array();
    $source = $arg;
    $url_vars = parse_url($source);
    $host = $url_vars['host'];
    $path = isset($url_vars['path'])?$url_vars['path']:'/';


    $url = $source;
    $ch = curl_init($url);

    $headers = array(
      'GET '.$path.' HTTP/1.0',
      'Host: ' . $url_vars['host'] . '',
      'Connection: Close',
      'User-Agent: Winamp',
      'Accept: */*',
      'icy-metadata: 1',
      'icy-prebuffer: 2314',
    );

    $construct_url = $url_vars['scheme'] . '://'. $url_vars['host'] . $path;


    $err_no = '';
    $err_str = '';

    $fp = @fsockopen($url_vars['host'], $url_vars['port'], $err_no, $err_str, 10);


//  print_r($url_vars); echo '<br><br>';
//  print_r($fp); echo '<br><br>';

    if ($fp) {


      $headers_str = '';

      foreach ($headers as $key=>$val){
        $headers_str.=$val.'\r\n';
      }



//    echo $headers_str . '<-headers_str<br><br>';

      define('CRLF', "\r\n");


      $headers_str = 'GET '.$path.' HTTP/1.0' . CRLF .
        'Host: ' . $url_vars['host'] . CRLF .
        'Connection: Close' . CRLF .
        'User-Agent: Winamp 2.51' . CRLF .
        'Accept: */*' . CRLF .
        'icy-metadata: 1'.CRLF.
        'icy-prebuffer: 65536'.CRLF. CRLF;


      fwrite($fp, $headers_str);

      stream_set_timeout($fp, 2, 0);
      $response = "";

      while (!feof($fp)){



        $line = fgets($fp, 4096);
        if('' == trim($line)){
          break;
        }
        $response .= $line;
      }

//    echo 'response ->> <pre>'; print_r($response); echo '</pre><--';


      preg_match_all('/(.*?):(.*)[^|$]/', $response, $fout_arr);

//    echo 'response ->> <pre>'; print_r($fout_arr); echo '</pre><--';

      if(isset($fout_arr[1])){

        $final_arr = array();
        foreach ($fout_arr[1] as $key=>$val){
          $final_arr[$val] = $fout_arr[2][$key];
        }


//      echo '$final_arr ->> <pre>'; print_r($final_arr); echo '</pre><--';









        // -- snippet from https://stackoverflow.com/questions/15803441/php-script-to-extract-artist-title-from-shoutcast-icecast-stream
        if (!isset($final_arr['icy-metaint'])){
          $data = ''; $metainterval = 512;
          while(!feof($fp)){
            $data .= fgetc($fp);
            if (strlen($data) >= $metainterval) break;
          }

          $matches = array();
          preg_match_all('/([\x00-\xff]{2})\x0\x0([a-z]+)=/i', $data, $matches, PREG_OFFSET_CAPTURE);
          preg_match_all('/([a-z]+)=([a-z0-9\(\)\[\]., ]+)/i', $data, $matches, PREG_SPLIT_NO_EMPTY);


//        echo '<pre>';var_dump($matches);echo '</pre>';


          $title = $artist = '';
          foreach ($matches[0] as $nr => $values){
            $offset = $values[1];
            $length = ord($values[0]{0}) +
              (ord($values[0]{1}) * 256)+
              (ord($values[0]{2}) * 256*256)+
              (ord($values[0]{3}) * 256*256*256);
            $info = substr($data, $offset + 4, $length);
            $seperator = strpos($info, '=');
            $final_metadata[substr($info, 0, $seperator)] = substr($info, $seperator + 1);
            if (substr($info, 0, $seperator) == 'title') $title = substr($info, $seperator + 1);
            if (substr($info, 0, $seperator) == 'artist') $artist = substr($info, $seperator + 1);
          }
          $final_metadata['streamtitle'] = $artist . ' - ' . $title;
        }else{
          $metainterval = $final_arr['icy-metaint'];
          $intervals = 0;
          $metadata = '';
          while(1){
            $data = '';
            while(!feof($fp)){
              $data .= fgetc($fp);
              if (strlen($data) >= $metainterval) break;
            }
            //$dzsap->print_data($data);
            $len = join(unpack('c', fgetc($fp))) * 16;
            if ($len > 0){
              $metadata = str_replace("\0", '', fread($fp, $len));
              break;
            }else{
              $intervals++;
              if ($intervals > 100) break;
            }
          }
          $metarr = explode(';', $metadata);
          foreach ($metarr as $meta){
            $t = explode('=', $meta);
            if (isset($t[0]) && trim($t[0]) != ''){
              $name = preg_replace('/[^a-z][^a-z0-9]*/i','', strtolower(trim($t[0])));
              array_shift($t);
              $value = trim(implode('=', $t));
              if (substr($value, 0, 1) == '"' || substr($value, 0, 1) == "'"){
                $value = substr($value, 1);
              }
              if (substr($value, -1) == '"' || substr($value, -1) == "'"){
                $value = substr($value, 0, -1);
              }
              if ($value != ''){
                $final_metadata[$name] = $value;
              }
            }
          }
        }



//      echo '$final_metadata ->> <pre>'; print_r($final_metadata); echo '</pre><--';
      }

      fclose($fp);
    }


    if(isset($final_metadata) && isset($final_metadata['streamtitle'])){
      return $final_metadata['streamtitle'];


    }else{
      return 'Song name not found';
    }


  }

  public static function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
      $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
      if (!is_dir($path)) {
        $results[] = $path;
      }
    }

    return $results;
  }
  public static   function ajax_import_folder() {
    // -- called from js dzsap_import_folder
//    global $dzsap;
//      echo 'ceva';
    $dir = $_POST['payload'];

    $response_arr = array();


    $response_arr['type'] = 'success';


    $files = array();
    ZoomSoundsAjaxFunctions::getDirContents($dir, $files);

    $valid_extensions = array('mp3', 'm4a');

    $results = array();
    foreach ($files as $lab => $val) {

      $sw_continue = false;

      foreach ($valid_extensions as $vlid) {

        if (strpos(strtolower($val), $vlid) !== false) {
          $sw_continue = true;
        }
      }


      if ($sw_continue === false) {
        continue;
      }

      $final_url = str_replace($_SERVER['DOCUMENT_ROOT'], $_SERVER['HTTP_ORIGIN'], $val);
      $arr = explode(DIRECTORY_SEPARATOR, $final_url);
      $name = $arr[count($arr) - 1];


      foreach ($valid_extensions as $vlid) {
        $name = str_replace('.' . $vlid, '', $name);
      }

      $aux = array(
        'name' => $name,
        'url' => $final_url,
        'path' => $val,
      );
      array_push($results, $aux);
    }

    $response_arr['files'] = $results;
//		print_rr($results);
//    print_rr($_SERVER);
//      echo $_SERVER['DOCUMENT_ROOT'];
//      echo $_SERVER['HTTP_ORIGIN'];

    echo json_encode($response_arr);

    die();
  }


}