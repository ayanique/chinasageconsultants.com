<?php

$yesterday = date("d M", time() - 60 * 60 * 24);
$days_2 = date("d M", time() - 60 * 60 * 24 * 2);
$days_3 = date("d M", time() - 60 * 60 * 24 * 3);

//	            echo 'hmm-'.$yesterday.'-'.$days_2;

//                $yesterday = 'ceva';
//	            $days_2 = 'ceva2';

// -- chart

$trackid = $_POST['postdata'];
$url = $_POST['url'];
$sanitized_source = $_POST['sanitized_source'];
$arr = array(
  'labels'=>array(__('Track'),__('Views'),__('Likes')),
  'lastdays'=>array(
    array(

      $days_3,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'4',
        'day_end'=>'3',
        'type'=>'view',
        'get_count'=>'off',
      )),
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'4',
        'day_end'=>'3',
        'type'=>'like',
        'get_count'=>'off',
      )),
    ),
    array(

      $days_2,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'3',
        'day_end'=>'2',
        'type'=>'view',
      )),
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'3',
        'day_end'=>'2',
        'type'=>'like',
      )),
    ),

    array(

      $yesterday,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'2',
        'day_end'=>'1',
        'type'=>'view',
      )),
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'2',
        'day_end'=>'1',
        'type'=>'like',
      )),
    ),
    array(

      __("Today"),
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'1',
        'day_end'=>'0',
        'type'=>'view',
      )),
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'1',
        'day_end'=>'0',
        'type'=>'like',
      )),

    ),
  ),

);

//	            error_log(print_r($arr,true));



?>
  <div class="hidden-data"><?php echo json_encode($arr); ?></div>


<?php



$last_month = date("M", time() - 60 * 60 * 31);
$month_2 = date("M", time() - 60 * 60 * 24 * 62);
$month_3 = date("M", time() - 60 * 60 * 24 * 93);


//	            echo 'hmm-'.$yesterday.'-'.$days_2;

//                $yesterday = 'ceva';
//	            $days_2 = 'ceva2';

$trackid = $_POST['postdata'];
$arr = array(
  'labels'=>array(__('Track'),__('Minutes watched')),
  'lastdays'=>array(
    array(

      $month_3,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'120',
        'day_end'=>'90',
        'type'=>'timewatched',
        'get_count'=>'off',
        'id_user'=>'0',
      )),
    ),
    array(

      $month_2,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'90',
        'day_end'=>'60',
        'type'=>'timewatched',
        'get_count'=>'off',
        'id_user'=>'0',
      )),
    ),
    array(

      $last_month,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'60',
        'day_end'=>'30',
        'type'=>'timewatched',
        'get_count'=>'off',
        'id_user'=>'0',
      )),
    ),

    array(

      "This month",
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'30',
        'day_end'=>'0',
        'type'=>'timewatched',
        'get_count'=>'off',
        'id_user'=>'0',
      )),
    ),
  ),

);

//	            error_log(print_r($arr,true));

?>
  <div class="hidden-data-time-watched"><?php echo json_encode($arr); ?></div>
<?php

$last_month = date("M", time() - 60 * 60 * 31);
$month_2 = date("M", time() - 60 * 60 * 24 * 62);
$month_3 = date("M", time() - 60 * 60 * 24 * 93);


//	            echo 'hmm-'.$yesterday.'-'.$days_2;

//                $yesterday = 'ceva';
//	            $days_2 = 'ceva2';


// -- time watched
$trackid = $_POST['postdata'];
$arr = array(
  'labels'=>array(__('Track'),__('Number of plays')),
  'lastdays'=>array(
    array(

      $month_3,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'120',
        'day_end'=>'90',
        'type'=>'view',
        'get_count'=>'off',
        'id_user'=>'0',
      )),
    ),
    array(

      $month_2,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'90',
        'day_end'=>'60',
        'type'=>'view',
        'get_count'=>'off',
        'id_user'=>'0',
      )),
    ),
    array(

      $last_month,
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'60',
        'day_end'=>'30',
        'type'=>'view',
        'get_count'=>'off',
        'id_user'=>'0',
      )),
    ),

    array(

      "This month",
      $this->mysql_get_track_activity($trackid, array(
        'get_last'=>'day',
        'day_start'=>'30',
        'day_end'=>'0',
        'type'=>'view',
        'get_count'=>'off',
        'call_from'=>'debug',
        'id_user'=>'0',
      )),
    ),
  ),

);
//error_log('$arr ->2' . print_r($arr,true));
?>
  <div class="hidden-data-month-viewed"><?php echo json_encode($arr); ?></div>

  <div class="dzs-row">
    <div class="dzs-col-md-8">
      <div class="trackchart">

      </div>
    </div>
    <div class="dzs-col-md-4">
      <div class="dzs-row">

        <div class="dzs-col-md-6">
          <h6><?php echo __("Likes Today"); ?></h6>
          <div><span class="the-number"><?php


              $aux = $this->mysql_get_track_activity($trackid, array(
                'get_last'=>'on',
                'interval'=>'24',
                'type'=>'like',
              ));

              echo $aux;

              ?></span> <span class="the-label"><?php ?></span> </div>
        </div>
        <div class="dzs-col-md-6">
          <h6><?php echo __("Plays Today"); ?></h6>
          <div><span class="the-number"><?php


              $aux = $this->mysql_get_track_activity($trackid, array(
                'get_last'=>'on',
                'interval'=>'24',
                'type'=>'view',
              ));

              echo $aux;

              ?></span> <span class="the-label"><?php ?></span> </div>
        </div>
      </div>

      <div class="dzs-row">
        <div class="dzs-col-md-6">


          <h6><?php echo __("Likes This Week"); ?></h6>
          <div><span class="the-number"><?php


              $aux = $this->mysql_get_track_activity($trackid, array(
                'get_last'=>'on',
                'interval'=>'144',
                'type'=>'like',
              ));

              echo $aux;

              ?></span> <span class="the-label"><?php ?></span> </div>
        </div>

        <div class="dzs-col-md-6">
          <h6><?php echo __("Plays This Week"); ?></h6>
          <div><span class="the-number"><?php


              $aux = $this->mysql_get_track_activity($trackid, array(
                'get_last'=>'on',
                'interval'=>'144',
                'type'=>'view',
              ));

              echo $aux;

              ?></span> <span class="the-label"><?php ?></span> </div>
        </div>
      </div>
      <div class="dzs-row">

        <div class="dzs-col-md-6">
          <h6><?php echo __("Likes this month"); ?></h6>
          <div><span class="the-number"><?php


              $aux = $this->mysql_get_track_activity($trackid, array(
                'get_last'=>'on',
                'interval'=>'720',
                'type'=>'like',
              ));

              echo $aux;

              ?></span> <span class="the-label"><?php ?></span> </div>
        </div>
        <div class="dzs-col-md-6">
          <h6><?php echo __("Plays this month"); ?></h6>
          <div><span class="the-number"><?php


              $aux = $this->mysql_get_track_activity($trackid, array(
                'get_last'=>'on',
                'interval'=>'720',
                'type'=>'view',
              ));

              echo $aux;

              ?></span> <span class="the-label"><?php ?></span> </div>
        </div>
      </div>

    </div>
  </div>
  <div class="dzs-row">

    <div class="dzs-col-md-6">
      <div class="trackchart-time-watched">

      </div>
    </div>

    <div class="dzs-col-md-6">
      <div class="trackchart-month-viewed">

      </div>
    </div>
  </div>
  <div class="dzs-row">

    <?php
    global $wp;
//    $curr_url = home_url( $wp->request );
    $curr_url = $url;
    $curr_url = dzs_add_query_arg($curr_url, 'dzsap_action', 'delete_waveforms');
    $curr_url = dzs_add_query_arg($curr_url, 'trackid', $trackid);
    $curr_url = dzs_add_query_arg($curr_url, 'sanitized_source', $sanitized_source);
//    $curr_url = add_query_arg('dzsap_action', 'delete_waveforms', $curr_url);
//    $curr_url = add_query_arg('trackid', $trackid, $curr_url);
//    $curr_url = add_query_arg('sanitized_source', $sanitized_source, $curr_url);
    ?>
    <div class="dzs-col-md-12">
      <span class="btn-zoomsounds " data-playerid="<?php echo $trackid; ?>"><span class="the-icon"><i class="fa fa-tachometer" aria-hidden="true"/></span><span class="btn-label"><?php echo esc_html__('Delete stats','dzsap'); ?></span></span>
      <a class="btn-zoomsounds zoomsounds-delete-waveforms" href="<?php echo $curr_url; ?>"><span class="the-icon"><i class="fa fa-bars" aria-hidden="true"/></span><span class="btn-label"><?php echo esc_html__('Delete waveform data','dzsap'); ?></span></a>
    </div>
  </div>
<?php

die();