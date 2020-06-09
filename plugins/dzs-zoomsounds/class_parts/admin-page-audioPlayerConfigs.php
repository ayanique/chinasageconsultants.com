<?php



function dzsap_admin_page_vpc() {
  global $dzsap;

  // -- sliders admin video config
  ?>
  <div class="wrap">
    <div class="import-export-db-con">
      <div class="the-toggle"></div>
      <div class="the-content-mask" style="">

        <div class="the-content">


          <form enctype="multipart/form-data" action="" method="POST">
            <div class="one_half">
              <h3><?php _e('Import config', 'dzsap'); ?></h3>
              <input name="importsliderupload" type="file" size="10"/><br/>
            </div>
            <div class="one_half last alignright">
              <input class="button-secondary" type="submit" name="dzsap_import_config" value="Import"/>
            </div>
            <div class="clear"></div>
          </form>


          <div class="clear"></div>

        </div>
      </div>
    </div>
    <h2>DZS <?php _e('ZoomSounds Admin', 'dzsap'); ?> <img alt="" style="visibility: visible;"
                                                           id="main-ajax-loading"
                                                           src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/>
    </h2>
    <noscript><?php _e('You need javascript for this.', 'dzsap'); ?></noscript>
    <div class="top-buttons">
      <a rel="nofollow" href="<?php echo $dzsap->base_url; ?>readme/index.html"
         class="button-secondary action"><?php _e('Documentation', 'dzsap'); ?></a>

    </div>
    <table cellspacing="0" class="wp-list-table widefat dzs_admin_table main_sliders">
      <thead>
      <tr>
        <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('ID', 'dzsap'); ?></th>
        <th class="column-edit"><?php echo esc_html__("Edit", 'dzsap'); ?></th>
        <th class="column-edit"><?php echo esc_html__("Embed", 'dzsap'); ?></th>
        <th class="column-edit"><?php echo esc_html__("Export", 'dzsap'); ?></th>
        <th class="column-edit"><?php echo esc_html__("Duplicate", 'dzsap'); ?></th>

        <th class="column-edit">Delete</th>
      </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <?php
    $url_add = '';
    $url_add = '';
    $items = $dzsap->mainitems_configs;
    //echo count($items);
    //print_r($items);

    $aux = remove_query_arg('deleteslider', dzs_curr_url());
    $aux = admin_url('admin.php?page=' . $dzsap->pageName_legacy_sliders_admin_vpconfigs . '&adder=adder');
    $params = array('currslider' => count($items));
    $url_add = add_query_arg($params, $aux);

    $id_for_preview_player = 'newconfig';


    // -- if NOT then it is
    if (isset($items[$dzsap->currSlider]['settings']['id'])) {
      $id_for_preview_player = ($items[$dzsap->currSlider]['settings']['id']);
    }
    ?>
    <a rel="nofollow" class="button-secondary add-slider"
       href="<?php echo $url_add; ?>"><?php _e('Add Configuration', 'dzsap'); ?></a>
    <form class="master-settings only-settings-con mode_vpconfigs">
    </form>
    <div class="saveconfirmer"><?php _e('Loading...', 'dzsap'); ?></div>
    <a rel="nofollow" href="#" class="button-primary master-save-vpc"></a> <img alt=""
                                                                                style="position:fixed; bottom:18px; right:125px; visibility: hidden;"
                                                                                id="save-ajax-loading"
                                                                                src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/>

    <a rel="nofollow" href="#"
       class="button-primary master-save-vpc"><?php _e('Save All Configs', 'dzsap'); ?></a>
    <a rel="nofollow" href="#" class="button-primary slider-save-vpc"><?php _e('Save Config', 'dzsap'); ?></a>

    <div class="preview-player-iframe-con">

      <iframe class="preview-player-iframe" width="100%" height="300"
              src="<?php echo admin_url('admin.php?page=dzsap-mo&dzsap_preview_player=on&config=' . urlencode($id_for_preview_player) . ''); ?>"></iframe>
      <div class="button-secondary btn-refresh-preview"><i
          class="fa fa-refresh"></i> <?php echo esc_html__("Refresh preview", 'dzsap'); ?></div>
    </div>
  </div>
  <script>
    <?php
    //$jsnewline = '\\' + "\n";

    $aux = str_replace(array("\r", "\r\n", "\n"), '', $dzsap->sliderstructure);
    $aux = str_replace(array("'"), '&quot;', $aux);
    echo "var sliderstructure = '" . $aux . "';
    ";

    $aux = str_replace(array("\r", "\r\n", "\n"), '', $dzsap->videoplayerconfig);
    $aux = str_replace(array("'"), '&quot;', $aux);
    echo "var videoplayerconfig = '" . $aux . "';
    ";
    ?>
    jQuery(document).ready(function ($) {
      sliders_ready($);
      if ($.fn.multiUploader) {
        $('.dzs-multi-upload').multiUploader();
      }
      <?php
      $items = $dzsap->mainitems_configs;
      for ($i = 0; $i < count($items); $i++) {
        //print_r($items[$i]);

        $aux = '';
        if (isset($items[$i]) && isset($items[$i]['settings']) && isset($items[$i]['settings']['id'])) {
          //echo $items[$i]['settings']['id'];
          if ($items[$i]['settings']['id'] == 'temp123') {
            continue;
          }
          $items[$i]['settings']['id'] = str_replace('"', '', $items[$i]['settings']['id']);
          $aux = '{ name: "' . $items[$i]['settings']['id'] . '"}';
        }
        echo "sliders_addslider(" . $aux . ");";
      }
      if (count($items) > 0)
        echo 'sliders_showslider(0);';
      for ($i = 0; $i < count($items); $i++) {
        //echo $i . $dzsap->currSlider . 'cevava';
        if (($dzsap->mainoptions['is_safebinding'] != 'on' || $i == $dzsap->currSlider) && isset($items[$i]) && is_array($items[$i])) {

          //==== jsi is the javascript I, if safebinding is on then the jsi is always 0 ( only one gallery )
          $jsi = $i;
          if ($dzsap->mainoptions['is_safebinding'] == 'on') {
            $jsi = 0;
          }

          for ($j = 0; $j < count($items[$i]) - 1; $j++) {
            echo "sliders_additem(" . $jsi . ");";
          }

//						echo 'items - '; print_rr($items);
          foreach ($items[$i] as $label => $value) {
            if ($label === 'settings') {
              if (is_array($items[$i][$label])) {
                foreach ($items[$i][$label] as $sublabel => $subvalue) {
                  $subvalue = (string)$subvalue;
                  $subvalue = stripslashes($subvalue);
                  $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                  $subvalue = str_replace(array("'"), '"', $subvalue);
                  $subvalue = str_replace(array("</script>"), '{{scriptend}}', $subvalue);
                  // -- only settings
                  echo 'sliders_change(' . $jsi . ', "settings", "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                }
              }
            } else {

              if (is_array($items[$i][$label])) {
                foreach ($items[$i][$label] as $sublabel => $subvalue) {
                  $subvalue = (string)$subvalue;
                  $subvalue = stripslashes($subvalue);
                  $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                  $subvalue = str_replace(array("'"), '"', $subvalue);
                  $subvalue = str_replace(array("</script>"), '{{scriptend}}', $subvalue);
                  if ($label == '') {
                    $label = '0';
                  }


                  echo 'sliders_change(' . $jsi . ', ' . $label . ', "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                }
              }
            }
          }
          if ($dzsap->mainoptions['is_safebinding'] == 'on') {
            break;
          }
        }
      }
      ?>
      jQuery('#main-ajax-loading').css('visibility', 'hidden');
      if (dzsap_settings.is_safebinding == "on") {
        jQuery('.master-save-vpc').remove();
        if (dzsap_settings.addslider == "on") {
          //console.log(dzsap_settings.addslider)
          sliders_addslider();
          window.currSlider_nr = -1
          sliders_showslider(0);
        }
        jQuery('.slider-in-table').each(function () {

        });
      }
      check_global_items();
      sliders_allready();
    });
  </script>
  <?php
}