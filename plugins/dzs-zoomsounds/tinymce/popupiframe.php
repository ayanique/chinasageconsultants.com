<?php
// some total cache vars that needs to be like this

function dzsap_shortcode_builder() {
  global $dzsap;


  $sample_data_installed = false;
  if ($dzsap->sample_data && is_array($dzsap->sample_data)) {
    $sample_data_installed = true;
  }


  $ids = '';


  if(isset($dzsap->sample_data['media'])){
  for ($i = 0; $i < count($dzsap->sample_data['media']); $i++) {

    if ($i > 0) {
      $ids .= ',';
    }


    $ids .= $dzsap->sample_data['media'][$i];
  }
  }



  ?>

  <style>
    .setting #wp-content-editor-tools {
      padding-top: 0;
    }

    body .sidenote {
      color: #777777;
    }
    #wpbody-content{
    float:none;
    }
    .clear{
    clear:both;
    }
  </style>
  <script>
    <?php
    if (isset($_GET['sel'])) {
      $aux = str_replace(array("\r", "\r\n", "\n"), '', $_GET['sel']);
      $aux = str_replace("'", '"', $aux);
      echo 'window.dzsprx_sel = \'' . stripslashes($aux) . '\'';


    }
    ?>
    window.sg1_shortcode = '[zoomsounds_player source="https://digitalzoomstudio.net/links/sample-mp3.php" config="skinwave-with-comments" playerid="<?php echo $dzsap->sample_data['media'][0]; ?>" autoplay="on" cue="on" enable_likes="off" enable_views="off" songname="Track 1 from stephaniequinn.com" artistname="Steph"]';
    window.sg3_shortcode = '[zoomsounds_player source="https://digitalzoomstudio.net/links/sample-mp3.php" config="sample--skin-aria" playerid="<?php echo $dzsap->sample_data['media'][0]; ?>" thumb="" autoplay="on" cue="on" enable_likes="off" enable_views="off" songname="Track 1 from stephaniequinn.com" artistname="Steph"]';
    window.sg2_shortcode = '[dzsap_woo_grid type="attachment" style="style1" faketarget=".dzsap_footer" ids="<?php echo $ids; ?>" ]';
  </script>
  <style>
    #dzsap-shortcode-tabs .tab-menu-con.is-always-active .tab-menu {
      padding-left: 15px;

    }

    #dzsap-shortcode-tabs .tab-menu-con.is-always-active .tab-menu:before {
      display: none;;
    }
  </style>
  <div class="wrap <?php
  if ($sample_data_installed) {
    echo 'sample-data-installed';
  }
  ?>">
    <h6><strong>ZoomSounds <?php echo esc_html__("Playlist", 'dzsap'); ?></strong> <em><?php echo esc_html__("shortcode generator", 'dzsap'); ?></em></h6>

    <div class="dzstoggle " rel="">
      <div class="toggle-title" style=""><?php echo esc_html__('Import sample data', 'dzsap'); ?></div>
      <div class="toggle-content">


        <p><?php echo esc_html__("You can generate an example from the preview", 'dzsap'); ?></p>

        <?php
        if ($sample_data_installed === false) {
          echo '<p><button id="" class="button-secondary insert-sample-tracks">Insert Sample Data</button></p>';
        } else {

          echo '<p><button id="" class="button-secondary remove-sample-tracks">Remove Sample Data</button></p>';
        }
        ?>


        <div class="dzspb_lay_row shortcode-generator-cols">

          <div class="dzspb_layb_one_third">
            <?php
            echo '<img class="fullwidth" src="' . $dzsap->base_url . 'tinymce/img/sg1.png"/>';
            ?>
            <h3><?php echo __('Player with Wave and Comments'); ?></h3>
            <p>
              <button class="button-primary sg-1"<?php
              if ($sample_data_installed === false) {
                echo 'disabled';
              }
              ?>><?php echo __('Insert Shortcode'); ?></button>
            </p>
            <p
              class="sidenote sidenote-for-sample-data-not-installed"><?php echo __('Install sample data first, to generate this example'); ?></p>
          </div>
          <div class="dzspb_layb_one_third">
            <?php
            echo '<img  class="fullwidth" src="' . $dzsap->base_url . 'tinymce/img/sg2.png"/>';
            ?>

            <h3><?php echo __('Bottom Player with Grid Display'); ?></h3>
            <p>
              <button class="button-primary sg-2"<?php
              if ($sample_data_installed === false) {
                echo 'disabled';
              }
              ?>><?php echo __('Insert Shortcode'); ?></button>
            </p>
            <p
              class="sidenote sidenote-for-sample-data-not-installed"><?php echo __('Install sample data first, to generate this example'); ?></p>
          </div>
          <div class="dzspb_layb_one_third">
            <?php
            echo '<img class="fullwidth" src="' . $dzsap->base_url . 'tinymce/img/sg3.png"/>';
            ?>

            <h3><?php echo __('Audio Player with Custom Skin'); ?></h3>
            <p>
              <button class="button-primary sg-3"<?php
              if ($sample_data_installed === false) {
                echo 'disabled';
              }
              ?>><?php echo __('Insert Shortcode'); ?></button>
            </p>
            <p
              class="sidenote sidenote-for-sample-data-not-installed"><?php echo __('Install sample data first, to generate this example'); ?></p>
          </div>
        </div>


      </div>
    </div>
    <div class="clear"></div>

    <div class="flex-hr-nice-container">
    <div>
    </div>
    <div class="niceHr-label">
    <?php echo esc_html__("OR", 'dzsap'); ?>
    </div>
    <div>
    </div>
</div>


    <div class="sc-menu">
      <div class="setting type_any">
        <h3><?php echo esc_html__("Select a Playlist to Insert", 'dzsap'); ?></h3>
        <select class="styleme" name="dzsap_selectid">
          <?php

          $dzsap->db_read_mainitems();


          if ($dzsap->mainoptions['playlists_mode'] == 'normal') {

            foreach ($dzsap->mainitems as $mainitem) {
//              print_rr($mainitem);

$term_id = '';

if(isset($mainitem['term_id'])){
  $term_id = $mainitem['term_id'];
}

              echo '<option value="' . $mainitem['value'] . '"';
              if($term_id){
                echo ' data-term_id="' . $term_id . '"';
              }
              echo '>' . $mainitem['label'] . '</option>';
            }
          } else {

            foreach ($dzsap->mainitems as $mainitem) {
              echo '<option>' . ($mainitem['settings']['id']) . '</option>';
            }
          }
          ?>
        </select>
        <div class="sidenote"><?php echo esc_html__('Quick edit the gallery - ', 'dzsap'); ?> <a class="ultibox-item-delegated" id="sg_gallery_edit_link" data-source="" data-type="iframe" href="#"><?php echo esc_html__('here', 'dzsap'); ?></a></div>


    <div class="dzstoggle " rel="">
      <div class="toggle-title" style=""><h6><?php echo esc_html__('Force sizes', 'dzsap'); ?></h6></div>
      <div class="toggle-content">


      <div class="setting type_any">
        <h4><?php echo esc_html__("Force Width", 'dzsap'); ?></h4>
        <input class="textinput" name="width"/>
      </div>


      <div class="setting type_any">
        <h4><?php echo esc_html__("Force Height", 'dzsap'); ?></h4>
        <input class="textinput" name="height"/>
      </div>
</div>
</div>
      <!--
      <div class="setting type_any">
          <h3>Select a Pagination Method</h3>
          <select class="styleme" name="ddzsap_settings_separation_mode">
              <option>normal</option>
              <option>pages</option>
              <option>scroll</option>
              <option>button</option>
          </select>
          <div class="sidenote">Useful if you have many videos and you want to separate them somehow.</div>
      </div>
      <div class="setting type_any">
          <h3>Select Number of Items per Page</h3>
          <input name="ddzsap_settings_separation_pages_number" value="5"/>
          <div class="sidenote">Useful if you have many videos and you want to separate them somehow.</div>
      </div>
      -->
      <div class="clear"></div>
      <br/>
      

    </div>


    <div class="shortcode-output"></div>

    <div class="bottom-right-buttons">

      <button id=""
              class="button-secondary insert-sample-library"><?php echo __("One Click Install Example"); ?></button>
      <span style="font-size: 11px; opacity: 0.5;"><?php echo __("OR", 'dzsvg'); ?></span>
      <button id="insert_tests" class="button-primary insert-tests"><?php echo __("Insert Gallery"); ?></button>
    </div>


    <div id="import-sample-lib" class="show-in-ultibox">
      <?php

      echo '<h3>' . __("Import Demo", 'dzsap') . '</h3>';


      $args = array(
        'featured_image' => $dzsap->base_url . 'img/sample_gallery_1.jpg',
        'title' => 'Sample Gallery',
        'demo-slug' => 'sample-gallery-1',
      );

      dzsap_generate_example_lib_item($args);


      $args = array(
        'featured_image' => $dzsap->base_url . 'img/sample_grid_style_1.jpg',
        'title' => 'Grid Style 1',
        'demo-slug' => 'sample_grid_style_1',
      );

      dzsap_generate_example_lib_item($args);


      $args = array(
        'featured_image' => $dzsap->base_url . 'img/sample_soundcloud_gallery_just_thumbs.jpg',
        'title' => 'Soundcloud Thumbnail Grid',
        'demo-slug' => 'sample_soundcloud_gallery_just_thumbs',
      );


      dzsap_generate_example_lib_item($args);


      $args = array(
        'featured_image' => $dzsap->base_url . 'img/sample_player_with_buttons.jpg',
        'title' => 'Player with Buttons',
        'demo-slug' => 'sample_player_with_buttons',
      );


      dzsap_generate_example_lib_item($args);


      $args = array(
        'featured_image' => $dzsap->base_url . 'assets/sampledata_img/single_player_wrapper.jpg',
        'title' => 'Single player with rectangle',
        'demo-slug' => 'single_player_wrapper',
      );


      dzsap_generate_example_lib_item($args);


      $args = array(
        'featured_image' => $dzsap->base_url . 'assets/sampledata_img/single_wave_and_single_jtap.jpg',
        'title' => 'Two players',
        'demo-slug' => 'single_wave_and_single_jtap',
      );


      dzsap_generate_example_lib_item($args);


      $lab = 'small_play_and_pause';


      $args = array(
        'featured_image' => $dzsap->base_url . 'assets/sampledata_img/' . $lab . '.jpg',
        'title' => 'Small play and pause controls',
        'demo-slug' => $lab,
      );


      dzsap_generate_example_lib_item($args);


      $lab = 'consecutive_player';


      $args = array(
        'featured_image' => $dzsap->base_url . 'assets/sampledata_img/' . $lab . '.jpg',
        'title' => 'Consecutive player',
        'demo-slug' => $lab,
      );


      dzsap_generate_example_lib_item($args);


      ?>
    </div>


  </div><?php
}


$dzsap_example_lib_index = 0;
function dzsap_generate_example_lib_item($pargs) {
  global $dzsap_example_lib_index, $dzsap;

  $margs = array(
    'featured_image' => '',
    'title' => '',
    'demo-slug' => '',
  );


  $margs = array_merge($margs, $pargs);

  if ($dzsap_example_lib_index % 3 == 0) {
    echo '<div class="dzs-row">';

  }


  ?>
  <div class="dzs-col-md-4">
  <div class="lib-item <?php


  if ($dzsap->mainoptions['dzsap_purchase_code_binded'] == 'on') {

  } else {

    echo ' dzstooltip-con';

    echo ' disabled';
  }


  ?>" data-demo="<?php echo $margs['demo-slug']; ?>"><?php


    if ($dzsap->mainoptions['dzsap_purchase_code_binded'] == 'on') {

    } else {

      ?>
      <div class=" dzstooltip skin-black arrow-bottom align-left">
        <?php echo __("You need to activate zoomsounds with purchase code before importing demos");
        ?>
      </div>
      <?php
    }


    ?>
    <i class="fa  fa-lock lock-icon"></i>
    <div class="loading-overlay">
      <i class="fa fa-spin fa-circle-o-notch loading-icon"></i>
    </div>
    <div class="divimage" style="background-image:url(<?php echo $margs['featured_image']; ?>); "></div>
    <h5><?php echo $margs['title'];; ?></h5>

  </div>

  </div><?php


  if ($dzsap_example_lib_index % 3 == 2) {

    echo '</div>';
  }


  $dzsap_example_lib_index++;


}