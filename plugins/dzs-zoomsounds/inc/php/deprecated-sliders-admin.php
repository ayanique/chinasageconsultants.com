<?php ?>
<div class="wrap">
  <div class="import-export-db-con">
    <div class="the-toggle"></div>
    <div class="the-content-mask" style="">

      <div class="the-content">
        <h2><?php echo __("Whole Database"); ?></h2>
        <form enctype="multipart/form-data" action="" method="POST">

          <div class="">
            <h3><?php echo __("Import Whole Database"); ?></h3>
            <input name="dzsap_importdbupload" type="file" size="10"/><br/>
          </div>
          <div class="">
            <input class="button-secondary" type="submit" name="dzsap_importdb" value="Import"/>
          </div>
          <div class="clear"></div>
        </form>


        <div class="">
          <h3><?php echo __("Export Whole Database"); ?></h3>
        </div>
        <div class="">
          <form action="" method="POST"><input class="button-secondary" type="submit" name="dzsap_exportdb"
                                               value="Export"/></form>
        </div>
        <br>
        <br>
        <h1><?php echo __("OR"); ?></h1>
        <br>
        <br>


        <h2><?php echo __("Single Slider"); ?></h2>


        <form enctype="multipart/form-data" action="" method="POST">
          <div class="">
            <h3><?php echo __("Import a Single Slider"); ?></h3>
            <input name="importsliderupload" type="file" size="10"/><br/>
          </div>
          <div class="">
            <input class="button-secondary" type="submit" name="dzsap_importslider" value="Import"/>
          </div>
          <div class="clear"></div>
        </form>

      </div>
    </div>
  </div>
  <h2>DZS <?php _e('ZoomSounds Admin', 'dzsap'); ?>&nbsp; <span
      style="font-size:13px; font-weight: 100;">version <?php echo DZSAP_VERSION; ?></span> <img alt=""
                                                                                                 style="visibility: visible;"
                                                                                                 id="main-ajax-loading"
                                                                                                 src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/>
  </h2>
  <noscript><?php _e('You need javascript for this.', 'dzsap'); ?></noscript>
  <div class="top-buttons">
    <a href="<?php echo $this->base_url; ?>readme/index.html"
       class="button-secondary action"><?php _e('Documentation', 'dzsap'); ?></a>
    <div class="super-select db-select dzsap">
      <button class="button-secondary btn-show-dbs">Current Database - <span class="strong currdb"><?php
          if ($this->currDb == '') {
            echo 'main';
          } else {
            echo $this->currDb;
          }
          ?></span></button>
      <select class="main-select hidden"><?php
        //print_r($this->dbs);

        if (is_array($this->dbs)) {
          foreach ($this->dbs as $adb) {
            $params = array('dbname' => $adb);
            $newurl = add_query_arg($params, dzs_curr_url());
            echo '<option' . ' data-newurl="' . $newurl . '"' . '>' . $adb . '</option>';
          }
        } else {
          $params = array('dbname' => 'main');
          $newurl = add_query_arg($params, dzs_curr_url());
          echo '<option' . ' data-newurl="' . $newurl . '"' . ' selected="selected"' . '>' . $adb . '</option>';
        }
        ?></select>
      <div class="hidden replaceurlhelper"><?php
        $params = array('dbname' => 'replaceurlhere');
        $newurl = add_query_arg($params, dzs_curr_url());
        echo $newurl;
        ?></div>
    </div>
  </div>
  <table cellspacing="0" class="wp-list-table widefat dzs_admin_table main_sliders">
    <thead>
    <tr>
      <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('ID', 'dzsap'); ?></th>
      <th class="column-edit">Edit</th>
      <th class="column-edit">Embed</th>
      <th class="column-edit">Export</th>
      <th class="column-edit">Duplicate</th>
      <?php
      if ($this->mainoptions['is_safebinding'] != 'on') {
        ?>
        <?php
      }
      ?>
      <th class="column-edit">Delete</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <?php
  $url_add = '';
  $url_add = '';
  $items = $this->mainitems;
  //echo count($items);

  $aux = remove_query_arg('deleteslider', admin_url('admin.php?page=' . $this->adminpagename . '&adder=adder'));

  $nextslidernr = count($items);
  if ($nextslidernr < 1) {
    //$nextslidernr = 1;
  }
  $params = array('currslider' => $nextslidernr);
  $url_add = add_query_arg($params, $aux);
  ?>
  <a class="button-secondary add-slider" href="<?php echo $url_add; ?>"><?php _e('Add Playlist', 'dzsap'); ?></a>
  <form class="master-settings">
  </form>
  <div class="saveconfirmer"><?php _e('Loading...', 'dzsap'); ?></div>
  <a href="#" class="button-primary master-save"></a> <img alt=""
                                                           style="position:fixed; bottom:18px; right:125px; visibility: hidden;"
                                                           id="save-ajax-loading"
                                                           src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/>

  <a href="#" class="button-primary master-save"><?php _e('Save All Galleries', 'dzsap'); ?></a>
  <a href="#" class="button-primary slider-save"><?php _e('Save Gallery', 'dzsap'); ?></a>
</div>
<script>
  <?php
  //$jsnewline = '\\' + "\n";
  $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->sliderstructure);
  $aux = str_replace(array("'"), '&quot;', $aux);
  echo "var sliderstructure = '" . $aux . "';
    ";
  $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->itemstructure);
  $aux = str_replace(array("'"), '&quot;', $aux);
  echo "var itemstructure = '" . $aux . "';
    ";
  $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->videoplayerconfig);
  $aux = str_replace(array("'"), '&quot;', $aux);
  echo "var videoplayerconfig = '" . $aux . "';
    ";
  ?>
  jQuery(document).ready(function ($) {
    sliders_ready($);
    if (jQuery.fn.multiUploader) {
      jQuery('.dzs-multi-upload').multiUploader();
    }
    <?php
    $items = $this->mainitems;
    for ($i = 0; $i < count($items); $i++) {
      //print_r($items[$i]);
      $aux = '';
      if (isset($items[$i]) && isset($items[$i]['settings']) && isset($items[$i]['settings']['id'])) {
        //echo $items[$i]['settings']['id'];

        $items[$i]['settings']['id'] = str_replace('"', '', $items[$i]['settings']['id']);
        $aux = '{ name: "' . $items[$i]['settings']['id'] . '"}';
      }

      echo "sliders_addslider(" . $aux . ");";
    }
    if (count($items) > 0)
      echo 'sliders_showslider(0);';
    for ($i = 0; $i < count($items); $i++) {
      //echo $i . $this->currSlider . 'cevava';
      if (($this->mainoptions['is_safebinding'] != 'on' || $i == $this->currSlider) && is_array($items[$i])) {

        // -- jsi is the javascript I, if safebinding is on then the jsi is always 0 ( only one gallery )
        $jsi = $i;
        if ($this->mainoptions['is_safebinding'] == 'on') {
          $jsi = 0;
        }

        for ($j = 0; $j < count($items[$i]) - 1; $j++) {
          echo "sliders_additem(" . $jsi . ");";
        }

        foreach ($items[$i] as $label => $value) {
          if ($label === 'settings') {
            if (is_array($items[$i][$label])) {
              foreach ($items[$i][$label] as $sublabel => $subvalue) {
                $subvalue = (string)$subvalue;
                $subvalue = stripslashes($subvalue);
                $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                $subvalue = str_replace(array("'"), '"', $subvalue);
                $subvalue = str_replace(array("</script>"), '{{scriptend}}', $subvalue);

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
        if ($this->mainoptions['is_safebinding'] == 'on') {
          break;
        }
      }
    }
    ?>
    jQuery('#main-ajax-loading').css('visibility', 'hidden');
    if (dzsap_settings.is_safebinding == "on") {
      jQuery('.master-save').remove();
      if (dzsap_settings.addslider == "on") {
        sliders_addslider();
        window.currSlider_nr = -1
        sliders_showslider(0);
      }
      jQuery('.slider-in-table').each(function () {
//                        jQuery(this).children('.button_view').eq(3).remove();
      });
    }
    check_global_items();
    sliders_allready();
  });
</script>