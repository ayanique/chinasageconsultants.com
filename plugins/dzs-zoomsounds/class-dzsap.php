<?php
//error_log("ceva");
@include_once("configs/constants.php");
@include_once("class_parts/class-ajax-functions.php");
@include_once("inc/php/DZSZoomSoundsHelper.php");
@include_once(DZSAP_BASE_PATH . "inc/php/AjaxHandler.php");
@include_once("inc/portal/showcase-functions.php");
@include_once("inc/php/analytics.php");
@include_once("inc/php/view-functions.php");
@include_once("inc/php/gutenberg-functions.php");
@include_once("inc/php/shortcodes.php");


class DZSAudioPlayer {

  public $base_url;
  public $base_path;
  public $admin_capability = 'manage_options';
  public $dbname_mainitems = 'dzsap_items';
  public $dbname_mainitems_configs = 'dzsap_vpconfigs';
  public $dbname_options = 'dzsap_options';
  public $dbname_dbs = 'dzsap_dbs';

  public $adminpagename = 'dzsap_menu';
  public $pageName_legacy_sliders_admin_vpconfigs = 'dzsap_configs';

  public $adminpagename_mo = 'dzsap-mo';
  public $adminpagename_autoupdater = 'dzsap-autoupdater';
  public $adminpagename_about = 'dzsap-about';
  public $page_mainoptions_link = 'dzsap-mo';
  public $the_shortcode = 'zoomsounds';
  public $mainitems;
  public $mainitems_configs;
  public $mainoptions;
  public $sliders_index = 0;
  public $sliders__player_index = 0;
  public $cats_index = 0;
  public $dbs = array();
  public $currDb = '';
  public $vpconfigsstr = '';
  public $currSlider = '';
  public $current_user_id = 0;
  public $sliderstructure = '';
  public $videoplayerconfig = '';
  public $pluginmode = "plugin";
  public $alwaysembed = "on";

  public $general_assets = array();
  public $sample_data = array();
  private $dbname_sample_data = 'dzsap_sample_data';

  public $options_item_meta = array();
  public $options_item_meta_sanitized = array(); // -- removing dzsap_meta_
  public $og_data = array();


  public $has_generated_product_player = false;
  public $db_has_read_mainitems = false;


  public $options_array_player = array();
  public $options_slider = array();
  public $options_slider_categories_lng = array();
  public $item_meta_categories_lng = array();


  public $sw_enable_multisharer = false;
  private $debug = false;

  private $wc_called_loop_from = '';
  public $footer_style = '';
  public $footer_style_configs = array();
  public $footer_script = '';

  public $taxname_sliders = 'dzsap_sliders';


  public $svg_star = '';
  public $ajax_functions = '';


  public $allowed_tags = array(
    'p' => array(
      'class' => array(),
      'style' => array(),
    ),
    'strong' => array(),
    'em' => array(),
    'br' => array(),
    'a' => array(
      'href' => array(),
      'target' => array(),
      'style' => array(),
      'class' => array(),
    ),
    'span' => array(
      'style' => array(),
      'class' => array(),
    ),
    'i' => array(
      'style' => array(),
      'class' => array(),
    ),
  );


  function __construct() {
    if ($this->pluginmode == 'theme') {
      $this->base_url = THEME_URL . 'plugins/dzs-zoomsounds/';
    } else {
      $this->base_url = plugins_url('', __FILE__) . '/';
    }


    $this->base_path = dirname(__FILE__) . '/';
    $this->general_assets = DZSZoomSoundsHelper::get_assets();


    $this->svg_star = $this->general_assets['svg_star'];

    //clear database
    //update_option($this->dbname_dbs, '');


//return false;


    add_action('init', array($this, 'handle_init'));
    add_action('init', array($this, 'handle_init_end'), 900);

    add_action('widgets_init', array($this, 'handle_widgets_init'));

//        error_log(print_rrr($_GET));

//        echo 'ceva';
    include(dirname(__FILE__) . '/woo/woo-plugin.php');


    if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == $this->taxname_sliders) {
      include_once('admin/sliders_admin.php');
      add_action('in_admin_footer', 'dzsap_sliders_admin');


    }


    add_action('edited_' . $this->taxname_sliders, 'dzsap_sliders_save_taxonomy_custom_meta');
  }


  function db_read_default_opts() {

    global $pagenow;

//        echo $pagenow;


    if (isset($_GET['currslider'])) {
      $this->currSlider = $_GET['currslider'];
    } else {
      $this->currSlider = 0;
    }


    if (isset($_GET) && isset($_GET['dzsap_debug']) && $_GET['dzsap_debug'] == 'on') {
      $this->debug = true;
    }


    if (defined('dzsap_db_mainitems_configs')) {

//            echo "YES".dzsap_db_mainitems_configs;
      $this->mainitems_configs = unserialize(dzsap_db_mainitems_configs);

//            print_rr($this->mainitems_configs);
    } else {


      $this->mainitems_configs = get_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS);

    }

    include("class_parts/options-item-meta.php");
//        echo '$this->mainitems_configs -> '; print_rr($this->mainitems_configs);


    //cho 'ceva'.is_array($this->mainitems_configs);

    // -- lets us import default serialized vpconfigs
    if ($this->mainitems_configs == '' || (is_array($this->mainitems_configs) && count($this->mainitems_configs) == 0)) {
//            echo 'ceva';
      $this->mainitems_configs = array();
      // -- the default configs
      $aux = include_once('configs/vpconfigs_default_serialized.php');;
      $this->mainitems_configs = unserialize($aux);
//            print_r($this->mainitems_configs);
      //$this->mainitems = array();


      // TODO: saving
      update_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS, $this->mainitems_configs);
    }
    $this->vpconfigsstr = '';
    //print_r($this->mainitems_configs);
    $i23 = 0;


    foreach ($this->mainitems_configs as $vpconfig) {
      //print_r($vpconfig);
      $this->vpconfigsstr .= '<option data-sliderlink="' . $i23 . '" value="' . $vpconfig['settings']['id'] . '">' . $vpconfig['settings']['id'] . '</option>';

      $i23++;
    }


    if (defined('dzsap_db_sample_data')) {
      $this->sample_data = unserialize(dzsap_db_sample_data);
    } else {

      $this->sample_data = get_option($this->dbname_sample_data);
    }


    $defaultOpts = $this->general_assets['default_options'];


    if (defined('dzsap_db_mainoptions')) {
      $this->mainoptions = unserialize(dzsap_db_mainoptions);
    } else {

      $this->mainoptions = get_option($this->dbname_options);
    }


    // -- default opts / inject into db
    if ($this->mainoptions == '') {
      // -- new install

      $defaultOpts['playlists_mode'] = 'normal';


      $this->mainoptions = $defaultOpts;
      update_option($this->dbname_options, $this->mainoptions);
    } else {

      // -- previous install

      $defaultOpts['playlists_mode'] = 'legacy';
    }

    $this->mainoptions = array_merge($defaultOpts, $this->mainoptions);
    //print_r($this->mainoptions);
    // -- translation stuff
    load_plugin_textdomain('dzsap', false, basename(dirname(__FILE__)) . '/languages');


    if ($this->mainoptions['i18n_buy'] == '') {
      $this->mainoptions['i18n_buy'] = esc_html__("Buy", 'dzsap');
    }
    if ($this->mainoptions['i18n_play'] == '') {
      $this->mainoptions['i18n_play'] = esc_html__("Play", 'dzsap');
    }
    if ($this->mainoptions['i18n_title'] == '') {
      $this->mainoptions['i18n_title'] = esc_html__("Title", 'dzsap');
    }
    if ($this->mainoptions['i18n_register_to_download'] == '') {
      $this->mainoptions['i18n_register_to_download'] = esc_html__("Register to download", 'dzsap');
    }


    if (isset($_GET['page']) && $_GET['page'] == 'dzsap_menu') {
      if ($this->mainoptions['playlists_mode'] == 'normal') {

        wp_redirect(admin_url('edit-tags.php?taxonomy=dzsap_sliders&post_type=dzsap_items'));
        exit;
      }
    }


    if ($pagenow == 'admin.php' || $this->mainoptions['always_embed'] == 'on') {


      if ($this->mainoptions['playlists_mode'] == 'legacy') {

        $this->db_read_mainitems();
      }
    }


  }


  function handle_init() {
    global $pagenow, $current_user;

//    print_rr($current_user);

    if ($current_user->ID) {
      $this->current_user_id = $current_user->ID;
    }


    $this->item_meta_categories_lng = array(
      'misc' => esc_html__("Miscellaneous", 'dzsap'),
      'extra_html' => esc_html__("Extra HTML", 'dzsap'),
    );


    $this->db_read_default_opts();

    $this->post_options();


//		wp_deregister_script('jquery');


//    require_once("class_parts/options_gallery.php");
    require_once("class_parts/options_array_player.php");


    if (isset($_POST['deleteslider'])) {
      //print_r($this->mainitems);
      if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename) {
        unset($this->mainitems[$_POST['deleteslider']]);
        $this->mainitems = array_values($this->mainitems);
        $this->currSlider = 0;
        //print_r($this->mainitems);
        update_option($this->dbname_mainitems, $this->mainitems);
      }


      if (isset($_GET['page']) && $_GET['page'] == $this->pageName_legacy_sliders_admin_vpconfigs) {
        unset($this->mainitems_configs[$_POST['deleteslider']]);
        $this->mainitems_configs = array_values($this->mainitems_configs);
        $this->currSlider = 0;

        update_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS, $this->mainitems_configs);
      }
    }


    include('inc/php/part-generate-legacy-sliderstructure.php');

    // -- legacy playlist
    $this->itemstructure = $this->generate_item_structure(); // * deprecated


    // todo: why do we have this ?
    include_once "class_parts/vpconfig.php";


    dzsap_gutenberg_init();


    // --- check posts
    if (isset($_GET['dzsap_shortcode_builder']) && $_GET['dzsap_shortcode_builder'] == 'on') {
//            dzsprx_shortcode_builder();

      include_once(dirname(__FILE__) . '/tinymce/popupiframe.php');
      define('DONOTCACHEPAGE', true);
      define('DONOTMINIFY', true);

    }


    if (isset($_GET['dzsap_shortcode_player_builder']) && $_GET['dzsap_shortcode_player_builder'] == 'on') {
//            dzsprx_shortcode_builder();

      include_once(dirname(__FILE__) . '/shortcodegenerator/generator_player.php');
      define('DONOTCACHEPAGE', true);
      define('DONOTMINIFY', true);

    }


    if ($this->mainoptions['replace_powerpress_plugin'] == 'on') {
      add_filter('the_content', array($this, 'filter_the_content'));
    }


    add_shortcode('dzsap_show_curr_plays', array($this, 'show_curr_plays'));
    add_shortcode('zoomsounds_player', array($this, 'shortcode_player'));
    add_shortcode('zoomsounds_player_comment_field', array($this, 'shortcode_player_comment_field'));


    if ($this->mainoptions['replace_playlist_shortcode'] == 'on') {
      add_shortcode('playlist', array($this, 'shortcode_playlist'));

    }
    if ($this->mainoptions['replace_audio_shortcode'] && $this->mainoptions['replace_audio_shortcode'] !== 'off') {
      add_shortcode('audio', array($this, 'shortcode_audio'));
    }


    add_filter('attachment_fields_to_edit', array($this, 'filter_attachment_fields_to_edit'), 10, 2);
    add_filter('attachment_fields_to_save', array($this, "filter_attachment_fields_to_save"), null, 2);


//        return false;


    // -- ajax actions
    add_action('admin_init', array($this, 'handle_admin_init'));


    if ($this->mainoptions['activate_comments_widget'] == 'on') {
      add_action('wp_dashboard_setup', array($this, 'wp_dashboard_setup'));
    }


    if ($this->mainoptions['enable_raw_shortcode'] == 'on') {
      remove_filter('the_content', 'wpautop');
      remove_filter('the_content', 'wptexturize');
      add_filter('the_content', array($this, 'formatter_raw_deprecated'), 99);
    }


    if ($this->mainoptions['tinymce_disable_preview_shortcodes'] != 'on') {
//            add_filter('mce_external_plugins', array( &$this, 'tinymce_external_plugins' ));
//            add_filter('tiny_mce_before_init', array( $this, 'myformatTinyMCE' ) );
    }


    if ($this->mainoptions['analytics_enable'] == 'on') {
      include_once("class_parts/analytics.php");
      add_action('wp_dashboard_setup', array($this, 'wp_dashboard_setup'));
    }


    add_action('admin_menu', array($this, 'handle_admin_menu'));
    add_action('admin_head', array($this, 'handle_admin_head'));
    add_action('admin_footer', array($this, 'handle_admin_footer'));


    add_action('wp_footer', array($this, 'handle_wp_footer'));
    add_action('wp_head', array($this, 'handle_wp_head'));


    add_action('add_meta_boxes', array($this, 'handle_add_meta_boxes'));

    add_action('save_post', array($this, 'admin_meta_save'));

    $this->ajax_functions = new AjaxHandler();


    if ($this->mainoptions['wc_single_product_player'] && $this->mainoptions['wc_single_product_player'] != 'off') {


//            echo ' $this->mainoptions[\'wc_loop_player_position\'] -  '.$this->mainoptions['wc_loop_player_position'];
      if ($this->mainoptions['wc_single_player_position'] == 'top') {
        add_action('woocommerce_single_product_summary', array($this, 'handle_woocommerce_single_product_summary'));
      }
      if ($this->mainoptions['wc_single_player_position'] == 'overlay') {
        add_action('woocommerce_single_product_summary', array($this, 'handle_woocommerce_single_product_summary'));
      }
      if ($this->mainoptions['wc_single_player_position'] == 'bellow') {
//                echo 'hmm';
        add_action('woocommerce_single_product_summary', array($this, 'handle_woocommerce_single_product_summary'));
      }


    }


    // -- loooop
    if ($this->mainoptions['wc_loop_product_player'] && $this->mainoptions['wc_loop_product_player'] != 'off') {
//            echo ' $this->mainoptions[\'wc_loop_player_position\'] -  '.$this->mainoptions['wc_loop_player_position'];
      if ($this->mainoptions['wc_loop_player_position'] == 'top') {
        add_action('woocommerce_before_shop_loop_item', array($this, 'handle_woocommerce_before_shop_loop_item'));
      }


      if ($this->mainoptions['wc_loop_player_position'] == 'overlay') {
        add_action('woocommerce_before_shop_loop_item_title', array($this, 'handle_woocommerce_before_shop_loop_item'));
//        add_action('woocommerce_before_shop_loop_item',array($this,'handle_woocommerce_before_shop_loop_item'));
      }

      if ($this->mainoptions['wc_loop_player_position'] == 'bellow') {
        add_action('woocommerce_after_shop_loop_item', array($this, 'handle_woocommerce_before_shop_loop_item'));
      }


    }


//        add_action('woocommerce_product_thumbnails', array($this, 'test'));
//        add_action('woocommerce_add_to_cart',array($this,'handle_woocommerce_add_to_cart'));
//        add_action('woocommerce_before_shop_loop',array($this,'handle_woocommerce_before_shop_loop'));
//        add_action('woocommerce_after_cart',array($this,'handle_woocommerce_after_cart'));
//        add_filter('wc_add_to_cart_message',array($this,'filter_wc_add_to_cart_message'));


//        include( dirname(__FILE__).'/woo/woo-plugin.php' );


    if (isset($_GET) && isset($_GET['load-lightbox-css']) && $_GET['load-lightbox-css'] == 'on') {
      header("Content-type: text/css");
      include_once "class_parts/lightbox_css.php";
      die();
    }


    $post_id = '';
    if (isset($_GET['post']) && $_GET['post'] != '') {
      $post_id = $_GET['post'];
    }

    if ($this->mainoptions['try_to_hide_url'] == 'on') {

      if (!session_id()) {
        session_start();
      }
    }


    if (isset($_GET['dzsap_action']) && $_GET['dzsap_action']) {
//            dzsprx_shortcode_builder();


//            dzsprx_shortcode_builder();


      include DZSAP_BASE_PATH . 'class_parts/part-ajax-functions.php';
    }

    //wp_deregister_script('jquery');        wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"), false, '1.9.0');
    wp_enqueue_script('jquery');
    if (is_admin()) {


      if ($pagenow == 'post.php') {
        $po = get_post($post_id);
        if ($po && $po->post_type == 'attachment') {
          wp_enqueue_media();
        }
      }
      if (isset($_GET['page'])) {
        if ($_GET['page'] == DZSAP_ADMIN_PAGENAME_LEGACY_SLIDERS_ADMIN_SLIDERS || $_GET['page'] == DZSAP_ADMIN_PAGENAME_LEGACY_SLIDERS_ADMIN_VPCONFIGS) {
          wp_enqueue_media();
        }
      }


      if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'dzsap_sliders') {
        wp_enqueue_script('jquery-ui-sortable');
        $url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

        if ($this->mainoptions['fontawesome_load_local'] == 'on') {
          $url = $this->base_url . 'libs/fontawesome/font-awesome.min.css';
        }


        wp_enqueue_style('fontawesome', $url);
        wp_enqueue_style('dzs.tooltip', $this->base_url . 'libs/dzstooltip/dzstooltip.css');


        wp_enqueue_media();
      }


      if (isset($_GET['page']) && $_GET['page'] == $this->page_mainoptions_link) {

        DZSZoomSoundsHelper::enqueueScriptsForAdminMainOptions();

      }


      if (current_user_can('manage_options') || current_user_can('edit_posts') || current_user_can('edit_pages') || current_user_can('dzsap_make_shortcode')) {

        wp_enqueue_script('dzsap_htmleditor', $this->base_url . 'shortcodegenerator/add-generators-to-mce.js');
        wp_enqueue_script('dzsap_configreceiver', $this->base_url . 'tinymce/receiver.js');
      }


    } else {
      if (isset($this->mainoptions['always_embed']) && $this->mainoptions['always_embed'] == 'on') {
        $this->front_scripts();
        wp_enqueue_style('ultibox', $this->base_url . 'libs/ultibox/ultibox.css');
        wp_enqueue_script('ultibox', $this->base_url . 'libs/ultibox/ultibox.js');
      }
    }


    dzsap_register_links();
    dzsap_gutenberg_register_scripts();

    $this->check_posts_init();


    if (function_exists('vc_add_shortcode_param')) {
      vc_add_shortcode_param('dzs_add_media_att', 'vc_dzs_add_media_att');
    }

    include_once($this->base_path . 'vc/part-vcintegration.php');
  }

  // --- end handle_init END
  // -----------------------


  function handle_init_end() {


    if ($this->mainoptions['replace_powerpress_plugin'] == 'on') {
      add_shortcode('powerpress', 'dzsap_powerpress_shortcode_player');
    }


//        echo "get_option('dzsap_sample_data_installed') - ".get_option('dzsap_sample_data_installed');

    if (!(get_option('dzsap_sample_data_installed'))) {


      $tax = $this->taxname_sliders;
      $reference_term = get_term_by('slug', 'gallery-1-copy', $tax);

//		    echo '$reference_term - ';print_rr($reference_term);
      if ($reference_term) {

      } else {

        $file_cont = file_get_contents('sampledata/dzsap_export_gallery.txt', true);

//			    error_log('trying to import - '.$file_cont);
        $sw_import = ZoomSoundsAjaxFunctions::import_slider($file_cont);
      }


      update_option('dzsap_sample_data_installed', 'on');

//	        echo ' $file_cont - '.$file_cont;
//	        echo ' $sw_import - '.$sw_import;
    }

  }


  function db_read_mainitems() {


//        echo '$this->db_has_read_mainitems - '.$this->db_has_read_mainitems;
    if ($this->db_has_read_mainitems == false) {

      $currDb = '';
      if (isset($_GET['dbname'])) {
        $this->currDb = $_GET['dbname'];
        $currDb = $_GET['dbname'];
      }


      if ($this->mainoptions['playlists_mode'] == 'normal') {


        $tax = $this->taxname_sliders;

//                echo ' tax - '.$tax;

        $terms = get_terms($tax, array(
          'hide_empty' => false,
        ));


        $this->mainitems = array();
        foreach ($terms as $tm) {

          if ($tm && is_object($tm)) {

            $aux = array(
              'label' => $tm->name,
              'value' => $tm->slug,
              'term_id' => $tm->term_id,
            );

            array_push($this->mainitems, $aux);
          }
        }

//	            print_rr($terms);

      } else {

        // ---------------- deprecated
        // -- LEGACY
        // ---------------- deprecated

        if (isset($_GET['currslider'])) {
          $this->currSlider = $_GET['currslider'];
        } else {
          $this->currSlider = 0;
        }


        $this->dbs = get_option($this->dbname_dbs);
        //$this->dbs = '';
        if ($this->dbs == '') {
          $this->dbs = array('main');
          update_option($this->dbname_dbs, $this->dbs);
        }
        if (is_array($this->dbs) && !in_array($currDb, $this->dbs) && $currDb != 'main' && $currDb != '') {
          array_push($this->dbs, $currDb);
          update_option($this->dbname_dbs, $this->dbs);
        }
        //echo 'ceva'; print_r($this->dbs);
        if ($currDb != 'main' && $currDb != '') {
          $this->dbname_mainitems .= '-' . $currDb;
        }

        $this->mainitems = get_option($this->dbname_mainitems);


        if (is_array($this->mainitems) == false) {
          $this->mainitems = array();
          //$this->mainitems = array();
          update_option($this->dbname_mainitems, $this->mainitems);
        }


      }

      $this->db_has_read_mainitems = true;
    }

  }


  function analytics_get() {
    $this->analytics_views = get_option('dzsap_analytics_views');
    $this->analytics_minutes = get_option('dzsap_analytics_minutes');


    if ($this->mainoptions['analytics_enable_user_track'] == 'on') {
      $this->analytics_users = get_option('dzsap_analytics_users');


      if ($this->analytics_users == false) {
        $this->analytics_users = array();
      }
    }


  }


  function shortcode_player_comment_field() {

    $fout = '';

    global $current_user;


    if ($current_user->ID) {
      $fout .= '<div class="zoomsounds-comment-wrapper">
                <div class="zoomsounds-comment-wrapper--avatar divimage" style="background-image: url(http://www.gravatar.com/avatar/?d=identicon);"></div>
                <div class="zoomsounds-comment-wrapper--input-wrap">
                    <input type="text" class="comment_text" placeholder="' . __("Write a comment") . '"/>
                    <input type="text" class="comment_email" placeholder="' . __("Your email") . '"/>
                    <!--<input type="text" class="comment_user" placeholder="' . __("Your display name") . '"/>-->
                </div>

                <div class="zoomsounds-comment-wrapper--buttons">
                    <span class="dzs-button-dzsap comments-btn-cancel">' . __("Cancel") . '</span>
                    <span class="dzs-button-dzsap comments-btn-submit">' . __("Submit") . '</span>
                </div>
            </div>';
    } else {
      $fout .= __("You need to be logged in to comment");
    }


    return $fout;


  }


  function handle_woocommerce_after_main_content() {
    echo 'woocommerce_after_main_content';
  }

  function handle_woocommerce_after_shop_loop_item() {
    echo 'woocommerce_after_shop_loop_item';
  }

  function handle_woocommerce_shop_loop_item_title() {
    echo 'woocommerce_shop_loop_item_title';
  }

  function handle_woocommerce_single_product_summary() {
//        echo 'woocommerce_single_product_summary';


    global $post;

//        echo 'whaaa';


    if ($this->has_generated_product_player) {
      return false;
    }

    $this->wc_called_loop_from = 'single';

    $id = 0;

    if ($post && $post->ID) {
      $id = $post->ID;
    }

    $product = wc_get_product($id);


//        print_rr($post);
//        print_rr($product);
    if ($product->is_type('grouped')) {
      $children = $product->get_children();

//            print_rr($children);


      $ids = '';


      foreach ($children as $poid) {
        if (get_post_meta($poid, 'dzsap_woo_product_track', true)) {

//                    echo 'whaaa';
          if ($ids) {
            $ids .= ',';
          }
          $ids .= $poid;
        }
      }


//            echo 'ids - '.$ids;


      $fout = '';
      $iout = ''; //items parse


      echo '<div class="wc-dzsap-wrapper for-dzsag ';

      if ($this->mainoptions['wc_single_player_position'] == 'overlay') {
        echo 'go-after-thumboverlay ';
      }

      echo '">';

      if ($ids) {

        echo dzsap_shortcode_showcase(array(

          'feed_from' => 'audio_items',
          'ids' => $ids,
        ));


        $this->has_generated_product_player = true;
      }

      echo '</div>';

    } else {
      $args = array(

        'call_from' => 'handle_woocommerce_single_product_summary',
        'extra_classes' => ' from-wc_generate_player from-wc_single',
      );
      $this->wc_generate_player($id, $args);

    }


  }


  function wc_generate_player($id, $pargs = array()) {


    $margs = array(
      'call_from' => 'default',
      'extra_classes' => ' from-wc_generate_player',
    );


    $margs = array_merge($margs, $pargs);


    if ($this->has_generated_product_player) {
      return false;
    }

    $this->has_generated_product_player = false;


    $post = get_post($id);

    $player_position = $this->mainoptions['wc_loop_player_position'];


    if (strpos($margs['extra_classes'], 'from-wc_single') !== false) {
      $player_position = $this->mainoptions['wc_single_player_position'];

//            echo '$this->mainoptions[\'wc_single_player_position\'] - '.$this->mainoptions['wc_single_player_position'];

    }


    if ($id && get_post_meta($post->ID, 'dzsap_woo_product_track', true)) {

//            echo 'whaaa';
      $this->sliders__player_index++;

      $fout = '';


      $src = get_post_meta($post->ID, 'dzsap_woo_product_track', true);


//            print_rr($post);


      $this->front_scripts();

      $args = array(
        'mp3' => $src,
        'config' => $this->mainoptions['wc_single_product_player'],
      );

//        $args = array_merge($args, $atts);

//        print_r($args);
      $args['source'] = $args['mp3'];
      $args['product_id'] = $id;
      $args['called_from'] = 'single_product_summary';
      $args['config'] = $this->mainoptions['wc_single_product_player'];
      $args['extra_classes'] = $margs['extra_classes'];


      if ($this->wc_called_loop_from == 'loop') {

        $args['config'] = $this->mainoptions['wc_loop_product_player'];
      }

      $playerid = '';
      if ($this->mainoptions['wc_product_play_in_footer'] == 'on') {
        $args['faketarget'] = '.dzsap_footer';
      }


//            print_rr($margs);
      if ($player_position == 'overlay') {

        $args['extra_classes'] = ' prevent-bubble';

//                echo 'shift extra_classes';
      }

      if (strpos($args['source'], 'https://soundcloud.com') !== false) {
        $args['type'] = 'soundcloud';
      }


      $args['songname'] = $post->post_title;
      $args['menu_songname'] = $post->post_title;

      // Get user object
      $recent_author = get_user_by('ID', $post->post_author);
      // Get user display name
      $args['artistname'] = $recent_author->display_name;
      $args['menu_artistname'] = $recent_author->display_name;

      if ($margs['call_from'] == 'wc_loop') {
        $args['songname'] = '<object class="zoomsounds-woocommerce--product-link"><a rel="nofollow" href="' . get_permalink($post->ID) . '">' . $args['songname'] . '</a></object>';
      }


      // -- try to get from reference term
      $tax = $this->taxname_sliders;


      $is_playlist = false;

      $playlist_slug = 'zoomsounds-product-playlist-' . $args['product_id'];

      $reference_term = get_term_by('slug', $playlist_slug, $tax);

      if ($reference_term) {
        $is_playlist = true;

//        echo 'where we at';
//        error_log('( playlist product ) we have reference term - '.print_r($reference_term,true));
      }


      echo '<div class="wc-dzsap-wrapper for-dzsap-player-wc-loop ';


      if ($is_playlist) {
        echo ' is-playlist';
      }

//            print_rr($margs);
//            echo '$player_position - '.$player_position;
      if ($player_position == 'overlay') {
        echo 'go-to-thumboverlay center-ap-inside ';
      }

      echo '">';
//            echo 'whaa';


      $args['thumb_for_parent'] = $this->get_thumbnail($id);


      $it = $post;
      if (get_post_meta($it->ID, 'dzsap_woo_sample_time_start', true)) {
        $args['sample_time_start'] = get_post_meta($it->ID, 'dzsap_woo_sample_time_start', true);
      }
      if (get_post_meta($it->ID, 'dzsap_woo_sample_time_end', true)) {
        $args['sample_time_end'] = get_post_meta($it->ID, 'dzsap_woo_sample_time_end', true);
      }
      if (get_post_meta($it->ID, 'dzsap_woo_sample_time_total', true)) {
        $args['sample_time_total'] = get_post_meta($it->ID, 'dzsap_woo_sample_time_total', true);
      }
//            'sample_time_start' => get_post_meta($it->ID,'dzsap_woo_sample_time_start',true),
//                    'sample_time_end' => get_post_meta($it->ID,'dzsap_woo_sample_time_end',true),
//                    'sample_time_total' => get_post_meta($it->ID,'dzsap_woo_sample_time_total',true),

      $args['autoplay'] = 'off';


//      error_log('margs wc_generate_player - '.print_r($margs,true));
//      error_log('args wc_generate_player - '.print_r($args,true));

      if ($is_playlist) {
//        error_log('( playlist product ) we have reference term - '.print_r($reference_term,true). ' $args[\'source\'] - '.$args['source']. ' -args - '.print_r($args, true));

        $args['id'] = $playlist_slug;

//        print_rr($reference_term);


//        error_log('id -5 '.$args['id'].print_r($args,true));

        echo dzsap_shortcode_playlist_main($args, '');


      } else {

        if ($margs['call_from'] == 'handle_woocommerce_single_product_summary' && $this->mainoptions['wc_single_product_player_shortcode']) {
          // -- if we have shortcode


          $aux = $this->mainoptions['wc_single_product_player_shortcode'];
          $aux = $this->sanitize_from_shortcode_pattern($aux, $post);

          echo do_shortcode($aux);
        } else {

//          $args['product_id'] = '';
//          echo 'args - '; print_rr($args);
          echo $this->shortcode_player($args, '');
        }

      }


      echo '</div><!-- end .wc-dzsap-wrapper -->';

//        print_r($its); print_r($margs); echo 'alceva'.$fout;
    }

  }


  function sanitize_from_shortcode_pattern($aux, $argpo) {


    $a = array();
    $b = array();
    $src = $this->get_track_source($argpo->ID, $a, $b);


    $type = 'audio';

//            print_r($margs);
    if ($argpo->post_type == 'dzsap_items') {
      $type = get_post_meta($argpo->ID, 'dzsap_meta_type', true);
    }

//    $aux = str_replace('[zoomsounds_player','[zoomsounds_player product_id=""',$aux);
    $aux = str_replace('{{source}}', $src, $aux);
    $aux = str_replace('{{postid}}', $argpo->ID, $aux);
    $aux = str_replace('{{thumb}}', $this->get_thumbnail($argpo->ID), $aux);
    $aux = str_replace('{{type}}', $type, $aux);

    return $aux;
  }


  function handle_woocommerce_before_shop_loop_item() {
//        echo 'woocommerce_single_product_summary';


//        echo 'whaa';

    global $post;


    $this->wc_called_loop_from = 'loop';
    if ($post && $post->ID && get_post_meta($post->ID, 'dzsap_woo_product_track', true)) {


      $args = array(

        'call_from' => 'wc_loop',
        'extra_classes' => ' from-wc_generate_player from-wc_loop',
      );

//      print_rr($post);

//      print_rr($args);

      $this->wc_generate_player($post->ID, $args);

    }
//        print_r($its); print_r($margs); echo 'alceva'.$fout;


  }

  function handle_woocommerce_before_shop_loop() {
    echo 'woocommerce_before_shop_loop';
  }


  function handle_woocommerce_add_to_cart() {
    echo 'woocommerce_add_to_cart';
  }

  function handle_woocommerce_after_cart() {
    echo 'woocommerce_after_cart';
  }

  function filter_wc_add_to_cart_message($fout) {
    return 'wc_add_to_cart_message' . $fout . 'wc_add_to_cart_message_end';
  }

  function pcm_check_if_invalid($pcm) {
    return ($pcm == '' || $pcm == '[]' || strpos($pcm, ',') === false || strpos($pcm, 'null') !== false);
  }


  function generate_pcm($che, $pargs = array()) {


    $margs = array(
      'generate_only_pcm' => false, // -- generate only the pcm not the markup
    );

    if (is_array($pargs) == false) {
      $pargs = array();
    }

    $margs = array_merge($margs, $pargs);


    $cheid = '';


    // -- if it's a post... stdObject
    if (isset($che->post_title)) {
      $che = (array)$che;

      $args = array();
      $che['source'] = $this->get_track_source($che['ID'], $che['ID'], $args);
      $che['playerid'] = $che['id'];
    }


    $fout = '';
    $lab = '';

    if (isset($che['playerid']) && $che['playerid']) {
      $lab = $che['playerid'];
    }

    if ($lab == 'fake') {
      return '';
    }


    $pcm = '';

//        echo 'generate_pcm'; print_rr($che);


//    echo 'first lab -> '.$lab;


    // -- get playerid
    $lab_option_pcm = 'dzsap_pcm_data_' . DZSZoomSoundsHelper::sanitize_for_one_word($lab);


    $pcm = get_option($lab_option_pcm);


//    error_log('$lab_option_pcm id step- '.$lab_option_pcm);
//    error_log('get pcm from id ($lab_option_pcm - '.$lab_option_pcm.') - '.$pcm.' pcm .. invalid ?'.($this->pcm_check_if_invalid($pcm))).($pcm=='') .' '. ($pcm=='[]') ||  strpos($pcm,',')===false) '.'  strpos($pcm,'null')===false);


    if ($this->pcm_check_if_invalid($pcm)) {

      $lab = $che['source'];
      $lab_option_pcm = 'dzsap_pcm_data_' . DZSZoomSoundsHelper::sanitize_for_one_word($lab);


      $pcm = get_option($lab_option_pcm);
      // -- get by source
//      error_log('get pcm from source('.$lab.') - '.$pcm);

    }


    if ($this->pcm_check_if_invalid($pcm)) {

      if (isset($che['linktomediafile'])) {
        if ($che['linktomediafile']) {
          $lab_option_pcm = 'dzsap_pcm_data_' . $che['linktomediafile'];
        }
      }
      $pcm = get_option($lab_option_pcm);

    }
//    error_log('$pcm - '.$lab_option_pcm);

//            if( ( $pcm == '' || $pcm== '[]') && isset($che['playerid']) && $che['playerid']){
//                $lab  = 'dzsap_pcm_data_'.$che['playerid'];
//                $pcm = get_option($lab);
//            }

//                    echo 'lab - '.$lab;
//                    $lab = 'dzsap_pcm_data_735';

//                    echo 'lab - '.$lab;

//                    echo 'pcm - '.$pcm;

//    error_log('$lab_option_pcm - '.$lab_option_pcm);
//    error_log('$pcm final - '.$pcm);

//                print_r($che);
//		echo 'lab - '.$lab.' ||| ';
//		echo '$pcm - '.$pcm.' ||| ';

//    echo '$pcm final - '.$pcm;

//    echo 'test - ('.($pcm && $pcm!='[]' && strpos($pcm,',')!==false).')';
    if (!$this->pcm_check_if_invalid($pcm)) {
      $fout .= ' data-pcm=\'' . stripslashes($pcm) . '\'';
    }

    if ($margs['generate_only_pcm'] && $this->pcm_check_if_invalid($pcm)) {
      $fout = stripslashes($pcm);
    }


//    error_log('fout - '.$fout);

//    echo 'fout - '.$fout;
    return $fout;
  }


  function filter_the_content($fout) {

//        echo 'what what';

//        $fout='ceva'.$fout;


    if ($this->mainoptions['replace_powerpress_plugin'] == 'on') {
      return dzsap_powerpress_filter_content($fout);

    }


    return $fout;
  }


  function handle_add_meta_boxes() {


    add_meta_box('dzsap_footer_player_options', esc_html__('Footer Player Settings', 'dzsap'), array($this, 'admin_meta_options'), 'page', 'normal', 'high');
    add_meta_box('dzsap_footer_player_options', esc_html__('Footer Player Settings', 'dzsap'), array($this, 'admin_meta_options'), 'post', 'normal', 'high');
    add_meta_box('dzsap_footer_player_options', esc_html__('Footer Player Settings', 'dzsap'), array($this, 'admin_meta_options'), 'product', 'normal', 'high');


    // -- deprecated!
    add_meta_box('dzsap_waveform_generation', __('ZoomSounds Waveforms'), 'dzsap_admin_meta_download_waveforms', 'download', 'normal', 'high');


    add_meta_box('dzsap_meta_options', esc_html__('Audio Item Settings', 'dzsap'), array($this, 'dzsap_admin_meta_options'), 'dzsap_items', 'normal', 'high');


    $meta_post_array = $this->mainoptions['dzsap_meta_post_types'];


    if ($meta_post_array && is_array($meta_post_array) && count($meta_post_array)) {


      foreach ($meta_post_array as $post_type) {
        if ($post_type == 'dzsap_items') {
          continue;
        }


        add_meta_box('dzsap_meta_options', __('Audio Item Settings'), array($this, 'dzsap_admin_meta_options'), $post_type, 'normal');

      }
    }

    //add_meta_box( 'attachment_video_thumb', __( 'Thumbnail', 'dzsap' ), array($this,'admin_meta_attachment_video_thumb'), 'attachment', 'normal' );

//        if ($this->db_mainoptions['enable_meta_for_pages_too'] == 'on') {
//            add_meta_box('dzsap_meta_options',__('DZS ZoomFolio Settings'),array($this,'admin_meta_options'),'page','normal','high');
//            add_meta_box('dzsap_meta_gallery',__('Item Gallery','dzsap'),array($this,'admin_meta_gallery'),'page','side');
//        }
  }


  function dzsap_admin_meta_options() {
    global $post, $wp_version;
    $struct_uploader = '<div class="dzsap-wordpress-uploader">
<a rel="nofollow" href="#" class="button-secondary">' . __('Upload', 'dzsap') . '</a>
</div>';
    //$wp_version = '3.4.1';
    if ($wp_version < 3.5) {
      $struct_uploader = '<div class="dzs-single-upload">
<input id="files-upload" class="" name="file_field" type="file">
</div>';
    }
    ?>

    <?php
    include_once('class_parts/item-meta.php');

    wp_enqueue_style('dzsselector', $this->base_url . 'libs/dzsselector/dzsselector.css');
    wp_enqueue_script('dzsselector', $this->base_url . 'libs/dzsselector/dzsselector.js');
  }


  function admin_meta_options() {
    global $post, $wp_version;
    $struct_uploader = '
<a rel="nofollow" href="#" class="button-secondary upload-for-target">' . __('Upload', 'dzsap') . '</a>
';
    //$wp_version = '3.4.1';
    if ($wp_version < 3.5) {
      $struct_uploader = '<div class="dzs-single-upload">
<input id="files-upload" class="" name="file_field" type="file">
</div>';
    }


    $vpconfigs_arr = array(
      array('lab' => 'default', 'val' => 'default')
    );

    $i23 = 0;
    foreach ($this->mainitems_configs as $vpconfig) {
      //print_r($vpconfig);


      $auxa = array(
        'lab' => $vpconfig['settings']['id'],
        'val' => $vpconfig['settings']['id'],
        'extraattr' => 'data-sliderlink="' . $i23 . '"',
      );

      array_push($vpconfigs_arr, $auxa);

      $i23++;
    }


    ?>
    <div class="dzsap-meta-bigcon">
      <input type="hidden" name="dzs_nonce" value="<?php echo wp_create_nonce('dzs_nonce'); ?>"/>


      <?php
      ?>


      <div class="dzs-setting">
        <?php
        $lab = 'dzsap_footer_enable';

        echo DZSHelpers::generate_input_text($lab, array(
          'class' => 'fake-input',
          'def_value' => '',
          'seekval' => 'off',
          'input_type' => 'hidden',
        ));
        ?>
        <h4><?php echo __('Enable Sticky Player', 'dzsap'); ?></h4>
        <?php

        echo '<div class="dzscheckbox skin-nova">
                                        ' . DZSHelpers::generate_input_checkbox($lab, array('id' => $lab, 'class' => 'mainsetting dzs-dependency-field', 'val' => 'on', 'seekval' => get_post_meta($post->ID, $lab, true))) . '
                                        <label for="' . $lab . '"></label>
                                    </div>';


        // -- for future we can do a logical set like "(" .. ")" .. "AND" .. "OR"
        $dependency = array(

          array(
            'lab' => 'dzsap_footer_enable',
            'val' => array('on'),
          ),
          //                    'relation'=>'AND',
        );


        ?>

      </div>


      <div data-dependency='<?php echo json_encode($dependency); ?>'>

        <?php


        $feed_type = array(
          array(
            'lab' => 'parent',
            'val' => 'parent',
          ),
          array(
            'lab' => 'custom',
            'val' => 'custom',
          ),
        );
        ?>


        <div class="dzs-setting ">
          <h4><?php echo __('Feed Type', 'dzsap'); ?></h4>
          <?php
          $lab = 'dzsap_footer_feed_type';
          echo DZSHelpers::generate_select($lab, array('class' => 'dzs-style-me  dzs-dependency-field opener-listbuttons', 'options' => $feed_type, 'seekval' => get_post_meta($post->ID, $lab, true)));


          ?>

          <ul class="dzs-style-me-feeder">

            <div class="bigoption">
                          <span class="option-con"><img
                              src="<?php echo $this->base_url; ?>tinymce/img/footer_type_parent.png"><span
                              class="option-label"><?php echo __("Parent Player"); ?></span></span>
            </div>

            <div class="bigoption">
                          <span class="option-con"><img
                              src="<?php echo $this->base_url; ?>tinymce/img/footer_type_media.png"><span
                              class="option-label"><?php echo __("Custom Media"); ?></span></span>
            </div>

          </ul>


          <div class="sidenote">
            <?php echo __("Select parent player for the sticky player to await being played from the outside ( a track on the page or select custom media to set a custom mp3 to play directly in the sticky player."); ?>
          </div>

        </div>


        <div class="dzs-setting vpconfig-wrapper">
          <h4><?php echo __('Player configuration', 'dzsap'); ?></h4>
          <?php
          $lab = 'dzsap_footer_vpconfig';
          echo DZSHelpers::generate_select($lab, array('class' => 'vpconfig-select styleme', 'options' => $vpconfigs_arr, 'seekval' => get_post_meta($post->ID, $lab, true))); ?>

          <div class="edit-link-con" style="margin-top: 10px;"></div>

        </div>


        <?php


        // -- for future we can do a logical set like "(" .. ")" .. "AND" .. "OR"
        $dependency = array(

          array(
            'lab' => 'dzsap_footer_feed_type',
            'val' => array('custom'),
          ),
          //                    'relation'=>'AND',
        );


        ?>

        <div class="dzs-setting" data-dependency='<?php echo json_encode($dependency); ?>'>
          <h4><?php echo __('Featured Media', 'dzsap'); ?></h4>
          <?php
          $lab = 'dzsap_footer_featured_media';
          echo DZSHelpers::generate_input_text($lab, array('class' => 'input-big-image upload-target-prev', 'def_value' => '', 'seekval' => get_post_meta($post->ID, $lab, true))); ?>
          <?php echo $struct_uploader; ?>

        </div>

        <?php


        ?>


        <div class="dzs-setting " data-dependency='<?php echo json_encode($dependency); ?>'>
          <h4><?php echo __('Media Type', 'dzsap'); ?></h4>
          <?php
          $types_arr = array(
            array('lab' => 'audio', 'val' => 'audio'),
            array('lab' => 'shoutcast', 'val' => 'shoutcast'),
            array('lab' => 'soundcloud', 'val' => 'soundcloud'),
            array('lab' => 'youtube', 'val' => 'youtube'),
            array('lab' => 'fake', 'val' => 'fake'),
          );
          $lab = 'dzsap_footer_type';
          echo DZSHelpers::generate_select($lab, array('class' => ' styleme', 'options' => $types_arr, 'seekval' => get_post_meta($post->ID, $lab, true))); ?>

          <div class="edit-link-con"></div>

        </div>


      </div>


    </div>


    <?php
  }

  function admin_meta_save($post_id) {
    global $post;
    if (!$post) {
      return;
    }
    /* Check autosave */
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }
    if (isset($_REQUEST['dzs_nonce'])) {
      $nonce = $_REQUEST['dzs_nonce'];
      if (!wp_verify_nonce($nonce, 'dzs_nonce'))
        wp_die('Security check');
    }
    if (is_array($_POST)) {
      $auxa = $_POST;
      foreach ($auxa as $label => $value) {

        //print_r($label); print_r($value);
        if (strpos($label, 'dzsap_') !== false) {
          dzs_savemeta($post->ID, $label, $value);
        }
      }
    }
  }

  function filter_add_defer_attribute($tag, $handle) {
    // add script handles to the array below
    $scripts_to_defer = array('dzsap');

    foreach ($scripts_to_defer as $defer_script) {
      if ($defer_script === $handle) {

        //  async defer="defer"
        return str_replace(' src', ' src', $tag);
      }
    }
    return $tag;
  }


  function filter_woocommerce_get_settings_pages($settings) {
//        echo 'hmmdada';
//        $settings[] =
//        return $settings;
  }


  function handle_wp_footer() {
    global $post, $wp_query;


    $footer_player_enabled = false;
    $footer_player_source = 'fake';
    $footer_player_config = 'fake';
    $footer_player_type = 'fake';


    if ($this->mainoptions['enable_global_footer_player'] != 'off') {

      $footer_player_enabled = true;
      $footer_player_source = 'fake';
      $footer_player_type = 'fake';
      $footer_player_config = $this->mainoptions['enable_global_footer_player'];
    }

    if ($wp_query && $wp_query->post) {
      if ((get_post_meta($wp_query->post->ID, 'dzsap_footer_featured_media', true) || get_post_meta($wp_query->post->ID, 'dzsap_footer_enable', true) == 'on') && get_post_meta($wp_query->post->ID, 'dzsap_footer_enable', true) != 'off') {

        $footer_player_enabled = true;


//               echo 'get_post_meta($wp_query->post->ID, \'dzsap_footer_type\', true) - '.get_post_meta($wp_query->post->ID, 'dzsap_footer_type', true);
        $footer_player_config = get_post_meta($wp_query->post->ID, 'dzsap_footer_vpconfig', true);
        if (get_post_meta($wp_query->post->ID, 'dzsap_footer_feed_type', true) == 'custom') {

          $footer_player_source = get_post_meta($wp_query->post->ID, 'dzsap_footer_featured_media', true);
          $footer_player_type = get_post_meta($wp_query->post->ID, 'dzsap_footer_type', true);

        }
      }
    }


    if ($footer_player_enabled) {
      if ($footer_player_source) {

        $this->front_scripts();


        $vpsettingsdefault = array(
          'id' => 'default',
          'skin_ap' => 'skin-wave',
          'skinwave_dynamicwaves' => 'off',
          'skinwave_enablespectrum' => 'off',
          'skinwave_enablereflect' => 'on',
          'skinwave_comments_enable' => 'off',
          'skinwave_mode' => 'normal',
        );


        $cue = 'on';
        if ($footer_player_type === 'fake') {

          $cue = 'off';


        }

        $args = array(
          'player_id' => 'dzsap_footer',

          'source' => $footer_player_source,
          'cue' => $cue,
          'config' => $footer_player_config,
          'autoplay' => 'off',
          'type' => $footer_player_type,
        );


        $vpconfig_k = -1;
        $vpconfig_id = $footer_player_config;
        for ($i = 0; $i < count($this->mainitems_configs); $i++) {
          if ((isset($vpconfig_id)) && isset($this->mainitems_configs[$i]) && ($vpconfig_id == $this->mainitems_configs[$i]['settings']['id'])) {
            $vpconfig_k = $i;
          }
        }


        if ($vpconfig_k > -1) {
          $vpsettings = $this->mainitems_configs[$vpconfig_k];
        } else {
          $vpsettings['settings'] = $vpsettingsdefault;
        }


//                print_r($vpsettings);


//                echo 'hmm';


        echo '<div class="dzsap-sticktobottom-placeholder dzsap-sticktobottom-placeholder-for-' . $vpsettings['settings']['skin_ap'] . '"></div>
<section class="dzsap-sticktobottom ';


        // TODO: redundant I guess ( already handled by js )
        if ((isset($vpsettings['settings']['skin_ap']) == false ||
            $vpsettings['settings']['skin_ap'] == 'skin-wave') &&
          (isset($vpsettings['settings']['skinwave_mode']) && $vpsettings['settings']['skinwave_mode'] == 'small'
          )
        ) {
          echo ' dzsap-sticktobottom-for-skin-wave';
        }

//                print_r($vpsettings); echo 'ceva';

        if (isset($vpsettings['settings']['skin_ap']) == false || ($vpsettings['settings']['skin_ap'] == 'skin-silver')) {
          echo ' dzsap-sticktobottom-for-skin-silver';
        }


        echo '">';

        echo '<div class="dzs-container">';


        if (isset($vpsettings['settings']['enable_footer_close_button']) == false || ($vpsettings['settings']['enable_footer_close_button'] == 'on')) {
          echo '<div class="sticktobottom-close-con">' . $this->general_assets['svg_stick_to_bottom_close_hide'] . $this->general_assets['svg_stick_to_bottom_close_show'] . ' </div>';
        }


        $aux = array('called_from' => 'footer_player');

        $args = array_merge($args, $aux);


//                echo 'args - '; print_rr($args);


        echo $this->shortcode_player($args);


        echo '</div>';
        echo '</section>';


      }
    }


    if ($this->mainoptions['extra_js']) {
      echo '<script>';
      echo stripslashes($this->mainoptions['extra_js']);
      echo '</script>';
    }

    if ($this->footer_style) {
      echo '<style class="dzsap-footer-style">';
      echo $this->footer_style;
      echo '</style>';
    }


    if ($this->og_data && count($this->og_data)) {

      $image = '';
//            if (get_post_meta($post->ID, 'dzsvp_thumb', true)) {
//                $image = get_post_meta($post->ID, 'dzsvp_thumb', true);
//            }else{
//
//                $image = $this->sanitize_id_to_src( get_post_thumbnail_id($post->ID) );
//            }


      $image = $this->og_data['image'];


      echo '<meta property="og:title" content="' . $this->og_data['title'] . '" />';

      echo '<meta property="og:description" content="' . strip_tags($this->og_data['description']) . '" />';

      if ($image) {

        echo '<meta property="og:image" content="' . $image . '" />';
      }


    }


    if ($this->sw_enable_multisharer) {
      ?>
      <script>
        window.dzsap_social_feed_for_social_networks = '<h6 class="social-heading"><?php echo addslashes(__("Social Networks", 'dzsap')); ?></h6> <a rel="nofollow" class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://www.facebook.com/sharer.php?u={{shareurl}}&amp;title=test&quot;); return false;"><i class="fa fa-facebook-square"></i><span class="the-tooltip"><?php echo addslashes(__("SHARE ON", 'dzsap')); ?> FACEBOOK</span></a> <a rel="nofollow" class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://twitter.com/share?url={{shareurl}}&amp;text=Check this out!&amp;via=ZoomPortal&amp;related=yarrcat&quot;); return false;"><i class="fa fa-twitter"></i><span class="the-tooltip"><?php echo addslashes(__("SHARE ON", 'dzsap')); ?> TWITTER</span></a> <a rel="nofollow" class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://plus.google.com/share?url={{shareurl}}&quot;); return false; "><i class="fa fa-google-plus-square"></i><span class="the-tooltip"><?php echo addslashes(__("SHARE ON", 'dzsap')); ?> GOOGLE PLUS</span></a>  <a rel="nofollow" class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://www.linkedin.com/shareArticle?mini=true&url={{shareurl}}&title=LinkedIn%20Developer%20Network\n' +
          '&summary={{shareurl}}%20program&source={{shareurl}}&quot; return false; "><i class="fa fa-linkedin"></i><span class="the-tooltip"><?php echo addslashes(__("SHARE ON", 'dzsap')); ?> LINKEDIN</span></a>  <a rel="nofollow" class="social-icon" href="#" onclick="window.dzs_open_social_link(&quot;https://pinterest.com/pin/create/button/?url={{shareurl}}&amp;text=Check this out!&amp;via=ZoomPortal&amp;related=yarrcat&quot;); return false;"><i class="fa fa-pinterest"></i><span class="the-tooltip"><?php echo addslashes(__("SHARE ON", 'dzsap')); ?> PINTEREST</span></a>';


        window.dzsap_social_feed_for_share_link = '<h6 class="social-heading"><?php echo addslashes(__("Share Link", 'dzsap')); ?></h6> <div class="field-for-view field-for-view-link-code">{{replacewithcurrurl}}</div>';


        window.dzsap_social_feed_for_embed_link = ' <h6 class="social-heading"><?php echo addslashes(__("Embed Code", 'dzsap')); ?></h6> <div class="field-for-view field-for-view-embed-code">{{replacewithembedcode}}</div>';
      </script>
      <?php
    }


    if (($this->mainoptions['wc_loop_product_player'] && $this->mainoptions['wc_loop_product_player'] != 'off') || ($this->mainoptions['wc_single_product_player'] && $this->mainoptions['wc_single_product_player'] != 'off')) {


//            echo ' $this->mainoptions[\'wc_loop_player_position\'] -  '.$this->mainoptions['wc_loop_player_position'];


      $player_position = $this->mainoptions['wc_loop_player_position'];


      if ($this->mainoptions['wc_loop_player_position'] == 'overlay') {


        ?>
        <script>
          jQuery(document).ready(function ($) {

            var _body = $('body').eq(0);

            if (_body.hasClass('single-product')) {

              console.info("HMM");
              <?php

              if ($this->mainoptions['wc_single_player_position'] == 'overlay') {
              ?>
              var _c = $('.woocommerce-product-gallery__wrapper').eq(0);
              _c.append($('.go-to-thumboverlay').eq(0));
              var _c2 = $('.go-to-thumboverlay').eq(0);
              _c.css({

                'position': 'relative'
                , 'display': 'block'
              })
              _c2.css({
                'position': 'absolute'
                , 'width': '100%'
                , 'height': '100%'
                , 'top': '0'
                , 'left': '0'
              })
              _c.append($('.go-after-thumboverlay').eq(0));
              var _c2 = $('.go-after-thumboverlay').eq(0);
              _c2.css({
//            'position': 'absolute'
//            ,'width':'100%'
//            ,'height':'100%'
//            ,'top':'0'
//            ,'left':'0'
              });
              <?php
              }
              ?>
            } else {


              $('.go-to-thumboverlay').each(function () {
                var _t = $(this);


                console.log('_t - ', _t, _t.siblings('.wp-post-image'));

                if (_t.siblings('.wp-post-image').length) {
                  _t.parent().css({

                    'position': 'relative'
                    , 'display': 'block'
                  })
                  _t.css({
                    'position': 'absolute'
                    , 'width': '100%'
                    , 'height': _t.siblings('.wp-post-image').eq(0).height()
                    , 'top': '0'
                    , 'left': '0'
                  })
                }
              })
            }

          })

        </script><?php
      }
    }


    if (isset($this->mainoptions['replace_powerpress_plugin']) && $this->mainoptions['replace_powerpress_plugin'] == 'on') {


      ?>
      <style>
        .powerpress_player {
          display: none;
        }
      </style><?php


      global $post;

      global $powerpress_feed;
      //            print_rr($powerpress_feed);

      // PowerPress settings:
      $GeneralSettings = get_option('powerpress_general');
      //                print_rr($GeneralSettings);


      $feed_slug = 'podcast';


      if (function_exists('powerpress_get_enclosure_data') && $post && $post->post_type == 'post') {


        dzsap_powerpress_get_enclosure_data($feed_slug);


      }

    }


    if (isset($_GET['action'])) {
      if ($_GET['action'] == 'embed_zoomsounds') {


        echo '<div class="zoomsounds-embed-con">';

        $args = array();
        if (isset($_GET['type']) && $_GET['type'] == 'gallery') {

          $args = array(
            'id' => $_GET['id'],
            'embedded' => 'on',
          );


          if (isset($_GET['db'])) {
            $args['db'] = $_GET['db'];
          };
          echo dzsap_shortcode_playlist_main($args);

        }
        if (isset($_GET['type']) && $_GET['type'] == 'playlist') {

          $args = array(
            'ids' => $_GET['ids'],
            'embedded' => 'on',
          );


          if (isset($_GET['db'])) {
            $args['db'] = $_GET['db'];
          };
          echo $this->shortcode_playlist($args);

        }


        if (isset($_GET['type']) && $_GET['type'] == 'player') {


//    echo $_GET['margs'];
          $args = array();
          try {
//        echo '.'.stripslashes($_GET['margs']).'.';
            $args = @unserialize((stripslashes($_GET['margs'])));
          } catch (Exception $e) {

//        $args = array();
          }


//    print_r($args);

          if (is_array($args)) {

          } else {
            $args = array();


//        echo 'try json decode -> ';
//        echo stripslashes(stripslashes($_GET['margs']));
//        echo ' <- ';
//
//        echo '
//        try json decode -> ';
//        echo (stripslashes($_GET['margs']));
//        echo ' <- ';


            $args = json_decode((stripslashes(base64_decode($_GET['margs']))), true);

//        print_rr($args);

            if (is_object($args) || is_array($args)) {

            } else {
              $args = array();


            }

          }
//    print_r($args);
          $args['embedded'] = 'on';
          $args['extra_classes'] = ' test';
          $args['called_from'] = 'embed';

//          echo ' args for embed - '; print_rr($args);

          echo $this->shortcode_player($args);

        }
        echo '</div>';
      }
    }


  }

  function formatter_raw_deprecated($content) {
    $new_content = '';
    $pattern_full = '{(\[raw\].*?\[/raw\])}is';
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

    foreach ($pieces as $piece) {
      if (preg_match($pattern_contents, $piece, $matches)) {
        $new_content .= $matches[1];
      } else {
        $new_content .= wptexturize(wpautop($piece));
      }
    }
    return $new_content;
  }


  //include the tinymce javascript plugin
  function tinymce_external_plugins($plugin_array) {
    $plugin_array['ve_zoomsounds_player'] = $this->base_url . '/tinymce/visualeditor/editor_plugin.js';
    $plugin_array['noneditable'] = $this->base_url . '/tinymce/noneditable/plugin.min.js';
    return $plugin_array;
  }

  //include the css file to style the graphic that replaces the shortcode
  function myformatTinyMCE($options) {

    $ext = 'iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src|id|class|title|style],video[source],source[*]';

//    if ( isset( $options['extended_valid_elements'] ) )
//        $options['extended_valid_elements'] .= ',' . $ext;
//    else
//        $options['extended_valid_elements'] = $ext;
//
//
//        $options['media_strict'] = 'false';
//        $options['noneditable_leave_contenteditable'] = 'true';
//


//        $options['content_css'] .= ",".$this->base_url.'/tinymce/visualeditor/editor-style.css';


    if ($this->mainoptions['replace_playlist_shortcode'] == 'on') {


      $options['content_css'] .= "," . $this->base_url . 'audioplayer/audioplayer.css';
    }
    if ($this->mainoptions['replace_audio_shortcode'] && $this->mainoptions['replace_audio_shortcode'] !== 'off') {


      $options['content_css'] .= "," . $this->base_url . 'audioplayer/audioplayer.css';
    }

//    print_r($options);
    return $options;
  }

  public function generate_item_structure($pargs = null) {

    // -- generate the item structure for legacy playlist
    $margs = array(
      'generator_type' => 'normal',
      'type' => '',
      'source' => '',
      'sourceogg' => '',
      'waveformbg' => '',
      'waveformprog' => '',
      'thumb' => '',
      'linktomediafile' => '',
      'playfrom' => '',
      'bgimage' => '',
      'extra_html' => '',
      'extra_html_left' => '',
      'extra_html_in_controls_left' => '',
      'extra_html_in_controls_right' => '',
      'menu_artistname' => '',
      'menu_songname' => '',
      'menu_extrahtml' => '',
    );

    if (is_array($pargs) == false) {
      $pargs = array();
    }

    $margs = array_merge($margs, $pargs);


    $lab = 'type';
    $val = $margs[$lab];


    $uploadbtnstring = '<button class="button-secondary action upload_file ">Upload</button>';


    if ($this->mainoptions['usewordpressuploader'] != 'on') {
      $uploadbtnstring = '<div class="dzs-upload">
<form name="upload" action="#" method="POST" enctype="multipart/form-data">
    	<input type="button" value="Upload" class="btn_upl"/>
        <input type="file" name="file_field" class="file_field"/>
        <input type="submit" class="btn_submit"/>
</form>
</div>
<div class="feedback"></div>';
    }


    $aux = '';
    if ($margs['generator_type'] != 'onlyitems') {
      $aux = '<div class="item-con">
            <div class="item-delete">x</div>
            <div class="item-duplicate"></div>
        <div class="item-preview" style="">
        </div>
        <div class="item-settings-con">';
    }

    $aux .= '<div class="setting type_all">
            <h4 class="non-underline"><span class="underline">' . __('Type', 'dzsap') . '*</span>&nbsp;&nbsp;&nbsp;<span class="sidenote">select one from below</span></h4>

            <div class="main-feed-chooser select-hidden-metastyle select-hidden-foritemtype">
' . DZSHelpers::generate_select('0-0-' . $lab, array('options' => array('mediafile', 'soundcloud', 'shoutcast', 'youtube', 'audio', 'inline'), 'seekval' => $val, 'class' => 'textinput item-type', 'extraattr' => ' data-label="' . $lab . '"')) . '
                <div class="option-con clearfix">

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('Media File', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Link to a media file from your WordPress Media Library.', 'dzsap') . '
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('SoundCloud Sound', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Stream SoundCloud sounds. Input the full link to the sound in the Source field. '
        . 'You will have to input your SoundCloud API Key into ZoomSounds > Settings.', 'dzsap') . '  <a rel="nofollow" href="' . $this->base_url . 'readme/index.html#handbrake" target="_blank" class="">Documentation here</a>.
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('ShoutCast Radio', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Insert a shoutcast radio address. It will have to stream in mpeg format. Input the address, example:  ', 'dzsap') . ' - http://vimeo.com/<strong>55698309</strong>
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('YouTube', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Input the YouTube video id. Warning - will not work on iOS.', 'dzsap') . '
                    </div>
                    </div>
                    
                    
                    
                    <div class="an-option">
                    <div class="an-title">
                    
                    ' . __('Self-Hosted Audio', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Only mp3 is mandatory. Browsers that cannot decode mp3 will use the included Flash Player backup '
        . '. If you want full html5 player, you must set a ogg sound too.', 'dzsap') . '
                    </div>
                    </div>
                    
                    

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('Inline Content', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Insert in the <strong>Source</strong> field custom content ( ie. embed from a custom site ).', 'dzsap') . '
                    </div>
                    </div>
                </div>
            </div>
        </div>';


    $lab = 'source';
    $val = $margs[$lab];


    $aux .= '<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">' . __('Source', 'dzsap') . '*
                <div class="info-con">
                <div class="info-icon"></div>
                <div class="sidenote">' . __('Below you will enter your audio file address. If it is a video from YouTube or Vimeo you just need to enter
                the id of the video in the . The ID is the bolded part http://www.youtube.com/watch?v=<strong>j_w4Bi0sq_w</strong>.
                If it is a local video you just need to write its location there or upload it through the Upload button ( .mp3 format ).', 'dzsap') . '
                    </div>
                </div>
            </div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput main-source type_all upload-type-audio', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . $uploadbtnstring . '
        </div>';


    $lab = 'soundcloud_track_id';
    $val = '';

    if (isset($margs[$lab])) {
      $val = $margs[$lab];
    }


    $aux .= '<div class="setting type_soundcloud">
            <div class="setting-label">' . __('Track ID', 'dzsap') . '
            </div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput ', 'seekval' => $val, 'extraattr' => '')) . '
                <div class="sidenote">' . __('Only for Private Soundcloud files. Guide on how to get the track_id - ', 'dzsap') . ' <a rel="nofollow" href="http://digitalzoomstudio.net/docs/wpzoomsounds/#faq_secret_token">' . __("here") . '</a>' . '
        </div>
        </div>';


    $lab = 'soundcloud_secret_token';
    $val = '';

    if (isset($margs[$lab])) {
      $val = $margs[$lab];
    }


    $aux .= '<div class="setting type_soundcloud">
            <div class="setting-label">' . __('Secret Token', 'dzsap') . '
            </div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput ', 'seekval' => $val, 'extraattr' => '')) . '
                <div class="sidenote">' . __('Only for Private Soundcloud files. Guide on how to get the track_id - ', 'dzsap') . ' <a rel="nofollow" href="http://digitalzoomstudio.net/docs/wpzoomsounds/#faq_secret_token">' . __("here") . '</a>' . '
                    </div>
        </div>';


    $lab = 'sourceogg';
    $val = $margs[$lab];

    $aux .= '<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">HTML5 OGG ' . __('Format', 'dzsap') . '</div>
            <div class="sidenote">' . __('Optional ogg / ogv file', 'dzsap') . ' / ' . __('Only for the Video or Audio type', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . '
        </div>';


    if ($this->mainoptions['skinwave_wave_mode'] != 'canvas') {
      $lab = 'waveformbg';
      $val = $margs[$lab];

      $aux .= '<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">' . __('WaveForm Background Image', 'dzsap') . '</div>
            <div class="sidenote">' . __('Optional waveform image / ', 'dzsap') . ' / ' . __('Only for skin-wave', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . ' <span class="aux-wave-generator"><button class="btn-autogenerate-waveform-bg button-secondary">' . __("Auto Generate") . '</button></span>
        </div>';


      //simple with upload and wave generator
      $lab = 'waveformprog';
      $val = $margs[$lab];

      $aux .= '<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">' . __('WaveForm Progress Image', 'dzsap') . '</div>
            <div class="sidenote">' . __('Optional waveform image / ', 'dzsap') . ' / ' . __('Only for skin-wave', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . ' <span class="aux-wave-generator"><button class="btn-autogenerate-waveform-prog button-secondary">Auto Generate</button></span>
        </div>';
    }


    $lab = 'linktomediafile';
    $val = $margs[$lab];

    $aux .= '<div class="setting type_all">
            <div class="setting-label">' . __('Link To Media File', 'dzsap') . '</div>
            <div class="sidenote">' . __('you can link to a media file in order to have comment / rates - just input the id of the media here or ', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput type_all upload-type-audio upload-prop-id main-media-file', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . dzsap_misc_generate_upload_btn(array('label' => 'Link')) . '
</div>';


    //textarea special thumb
    $lab = 'thumb';
    $val = $margs[$lab];


    $aux .= '
        <div class="setting type_all ">
            <div class="setting-label">' . __('Thumbnail', 'dzsap') . '</div>
            <div class="sidenote">' . __('a thumbnail ', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput main-thumb type_all upload-type-image', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . $uploadbtnstring . '
</div>';


    //simple with upload and wave generator
    $lab = 'playfrom';
    $val = $margs[$lab];

    $aux .= '<div class="setting type_all">
            <div class="setting-label">' . __('Play From', 'dzsap') . '</div>
            <div class="sidenote">' . __('choose a number of seconds from which the track to play from ( for example if set "70" then the track will start to play from 1 minute and 10 seconds ) or input "last" for the track to play at the last position where it was.', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . '
        </div>';


    //simple with upload and wave generator
    $lab = 'bgimage';
    $val = $margs[$lab];

    $aux .= '<div class="setting type_all">
            <div class="setting-label">' . __('Background Image', 'dzsap') . '</div>
            <div class="sidenote">' . __('optional - choose a background image to appear ( needs a wrapper / read docs )', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . dzsap_misc_generate_upload_btn(array('label' => __('Upload', 'dzsap'))) . '
        </div>';


    $lab = 'play_in_footer_player';
    $val = '';

    $aux .= '<div class="setting type_all">
            <div class="setting-label">' . __('Play in footer player', 'dzsap') . '</div>
            <div class="sidenote">' . __('optional - play this track in the footer player ( footer player must be setuped on the page ) ', 'dzsap') . '</div>
' . DZSHelpers::generate_select('0-0-' . $lab, array('class' => 'textinput  styleme', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"', 'options' => array('off', 'on'))) . '
        </div>';


    $lab = 'enable_download_button';
    $val = '';

    $aux .= '<div class="setting type_all">
            <div class="setting-label">' . __('Enable Download Button', 'dzsap') . '</div>
            <div class="sidenote">' . __('optional - Enable Download Button for this track', 'dzsap') . '</div>
' . DZSHelpers::generate_select('0-0-' . $lab, array('class' => 'textinput  styleme', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"', 'options' => array('off', 'on'))) . '
        </div>';


    $lab = 'download_custom_link';
    $val = '';

    if (isset($margs[$lab])) {

      $val = $margs[$lab];
    }

    $aux .= '<div class="setting type_all">
            <div class="setting-label">' . __('Custom Link Download', 'dzsap') . '</div>
            <div class="sidenote">' . __('a custom link for the download button - clicknig it will go to this link if set, if it is not set then it will just download the track', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . '
        </div>';


    $lab = 'songname';
    $val = '';

    if (isset($margs[$lab])) {

      $val = $margs[$lab];
    }

    $aux .= '<div class="setting type_all">
            <div class="setting-label">' . __('Song name', 'dzsap') . '</div>
            <div class="sidenote">' . wp_kses(sprintf(__('leave blank and zoomsounds will try to auto generate song name from mp3 id3 or from attached file meta. Or you can input %s to force no song name in the player', 'dzsap'), '<strong>none</strong>'), $this->allowed_tags) . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . '
        </div>';


    $aux .= '<br>';
    $aux .= '<div class="dzstoggle toggle1" rel="">
        <div class="toggle-title" style="">' . __('Extra HTML Options', 'dzsap') . '</div>
        <div class="toggle-content" style="z-index:5;">';

    $aux .= '<img src="https://lh3.googleusercontent.com/JY9Q72y_Wkx4Au0Ijxjf2GCZUblfYbpyjooMaSt90XG9zOjd7vlddxLJTTX7C2UEV5TqBKBsSaFw3Pr8Psafl8XvzWMOzFaxJfndci9idgqFHSnEw9rd5K92tQyAiVqxPO30qznMwqIjIHQTm2hijSLM2S9OqVinEP_TGoKhtmgrCro7NmsNn0-T4N_Mmn3htOFy4o4mMZciif-zVcQ6T0HTB4n2xzI49Sn_s08ekF8DFwcE58n8Dp5LGfQpUeI8nfK8LSv4mKC1TKiewKkOm-YwGy3bhC8BFRsUXBDHd-YtX0y7HV7SfIg9hvA4QRJHBUQPod5YrDIODH7YLQi7HVIceBwyaYPvTAZEZh5oifrCCj61sSZztfjra-WbcxoRoUVrZSssvxLR1lJgH8WpnxdV-1qmDAr-0p7LKhdJM2_4P79SIOIKuYOWaDyx7GQ8CAjco--fhiwbYCxqgCXyGtRjpGYJV6IEKh7UhwEsNnkUAxWB-YoQrtFgoB3Rw4uFRdQCs--YHTeydLCEaAEL5CNwd6j0hh1UDunj1Xj7bmc=w736-h291-no"/>';

    //textarea simple
    $lab = 'extra_html';
    $val = $margs[$lab];


    $aux .= '
       <div class="setting type_all">
                <div class="setting-label">' . __('Extra HTML', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
                <div class="sidenote">' . __('(1) extra html you may want underneath item', 'dzsap') . '</div>
</div>';


    $lab = 'extra_html_left';
    $val = $margs[$lab];


    $aux .= '
       <div class="setting type_all">
                <div class="setting-label">' . __('Extra HTML to the Left', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
                <div class="sidenote">' . __('(2) extra html placed in the left of Like button', 'dzsap') . '</div>
</div>';


    $lab = 'extra_html_in_controls_left';
    $val = $margs[$lab];


    $aux .= '
       <div class="setting type_all">
                <div class="setting-label">' . __('Extra HTML in Left Controls', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
                <div class="sidenote">' . __('(3) extra html placed in the player&quot;s ', 'dzsap') . '</div>
</div>';


    $lab = 'extra_html_in_controls_right';
    $val = $margs[$lab];


    $aux .= '
       <div class="setting type_all">
                <div class="setting-label">' . __('Extra HTML in Right Controls', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
                <div class="sidenote">' . __('(3) extra html placed in the player&quot;s ', 'dzsap') . '</div>
</div>';


    $aux .= '</div>
        </div>';


    $aux .= '<div class="dzstoggle toggle1" rel="">
        <div class="toggle-title" style="">' . __('Menu Options', 'dzsap') . '</div>
        <div class="toggle-content">';


    //textarea simple
    $lab = 'menu_artistname';
    $val = $margs[$lab];


    $aux .= '
       <div class="setting type_all">
                <div class="setting-label">' . __('Artist Name', 'dzsap') . '</div>
                <div class="sidenote">' . __('an artist name if you include this item in a playlist', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
</div>';


    //textarea simple
    $lab = 'menu_songname';
    $val = $margs[$lab];


    $aux .= '
       <div class="setting type_all">
                <div class="setting-label">' . __('Song Name', 'dzsap') . '</div>
                <div class="sidenote">' . __('a song name', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
</div>';
    //textarea simple
    $lab = 'menu_extrahtml';
    $val = $margs[$lab];


    $aux .= '
       <div class="setting type_all">
                <div class="setting-label">' . __('Extra HTML', 'dzsap') . '</div>
                <div class="sidenote">' . __('extra html you may want in the menu item', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
</div>';


    $aux .= '</div>
        </div>';


    if ($margs['generator_type'] != 'onlyitems') {
      $aux .= '</div><!--end item-settings-con-->
</div>';
    }


    return $aux;
  }

  function handle_admin_footer() {


    if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'dzsap_sliders') {


      echo '<script>';
      echo 'jQuery(document).ready(function($){';
      echo '$("#toplevel_page_dzsap_menu, #toplevel_page_dzsap_menu > a").addClass("wp-has-current-submenu");';
      echo '$("#toplevel_page_dzsap_menu .wp-first-item").addClass("current");';
      echo '$("#menu-posts-dzsap_items, #menu-posts-dzsap_items>a").removeClass("wp-has-current-submenu wp-menu-open");';
      echo '});';
      echo '</script>';

    }

    if (isset($_GET['dzs_css'])) {

      if ($_GET['dzs_css'] == 'remove_wp_menu') {
        wp_enqueue_style('dzs.remove_wp_bar', $this->base_url . 'tinymce/remove_wp_bar.css');

      }
    }
  }

  function mysql_get_track_activity($track_id, $pargs = array()) {


    // -- get last ON for interval training

    $margs = array(
      'get_last' => 'off',
      'call_from' => 'default',
      'interval' => '24',
      'type' => 'view',
      'table' => 'detect',
      'day_start' => '3',
      'day_end' => '2',
      'get_count' => 'off',
    );

    if ($pargs) {
      $margs = array_merge($margs, $pargs);
    }


    global $wpdb;
    $table_name = $wpdb->prefix . 'dzsap_activity';


    $format_track_id = 'id_video';


    $margs['table'] = $table_name;

    $query = "SELECT ";


    if ($margs['get_count'] == 'on') {

      $query .= 'COUNT(*)';
    } else {

      $query .= '*';
    }

    $query .= " FROM `" . $margs['table'] . "` WHERE `" . $format_track_id . "` = '" . $track_id;


    if (strpos($margs['type'], '%') !== false) {

      $query .= "' AND type LIKE '" . $margs['type'] . "'";
    } else {

      $query .= "' AND type='" . $margs['type'] . "'";
    }


    if ($margs['get_last'] == 'on') {
      $query .= ' AND date > DATE_SUB(NOW(), INTERVAL ' . $margs['interval'] . ' HOUR)';
    }

    if ($margs['get_last'] == 'day') {
      $query .= ' AND date BETWEEN DATE_SUB(NOW(), INTERVAL ' . $margs['day_start'] . ' DAY)
    AND DATE_SUB(NOW(), INTERVAL  ' . $margs['day_end'] . ' DAY)';

//            echo ' query - '.$query;
    }

    // -- interval start / end


//        echo 'query - '.$query."\n"."\n";


    if (isset($margs['id_user'])) {
      $query .= ' AND id_user=\'' . $margs['id_user'] . '\'';
    }


    $results = $GLOBALS['wpdb']->get_results($query, OBJECT);


    $finalval = 0;
    if (is_array($results) && count($results) > 0) {


      if ($margs['get_count'] == 'on') {


        if (isset($results[0])) {
          $results[0] = (array)$results[0];

//				    print_rr($results);
          return $results[0]['COUNT(*)'];

        }
      } else {

        if ($margs['call_from'] == 'debug') {

          error_log(print_rr($results, true));
        }
        foreach ($results as $lab => $aux2) {
          $results[$lab] = (array)$results[$lab];

          $finalval += $results[$lab]['val'];
        }
      }


    }


    return $finalval;


  }


  function wp_dashboard_setup() {


    if ($this->mainoptions['analytics_enable'] == 'on') {

      wp_add_dashboard_widget('dzsap_dashboard_analytics', // Widget slug.
        'ZoomSounds' . esc_html__('Analytics', 'dzsap'), // Title.
        'dzsap_analytics_dashboard_content'

      );
    }

  }
//    function wp_dashboard_setup() {
//
//        wp_add_dashboard_widget(
//            'dzsap_analytics_dashboard_content', // Widget slug.
//            'ZoomSounds Comments Statistic', // Title.
//            array($this, 'dashboard_comments_display') // Display function.
//        );
//    }

  public static function sort_commnr($a, $b) {
    $key = 'commnr';
    return $b[$key] - $a[$key];
  }

  function dashboard_comments_display() {

//	echo "Hello World, I'm a great Dashboard Widget";

    $type = 'attachement';
    $args = array(
      'post_type' => 'attachment',
      'numberposts' => null,
      'posts_per_page' => '-1',
      'post_mime_type' => 'audio',
      'post_status' => null
    );
    $attachments = get_posts($args);

    $arr_attcomms = array();
    foreach ($attachments as $att) {
      $comments_count = wp_count_comments($att->ID);
      $aux = array('id' => $att->ID, 'commnr' => ($comments_count->approved));
      array_push($arr_attcomms, $aux);
    }
    //print_r($arr_attcomms);


    usort($arr_attcomms, array('DZSAudioPlayer', 'sort_commnr'));

//        print_r($arr_attcomms);


    echo '<div id="dzsap_chart_div"></div>';
    //print_r($arr_attcomms);


    ?>
    <script type="text/javascript"><?php

      ?>
      google.load("visualization", "1.0", {"packages": ["corechart"]});


      google.setOnLoadCallback(dzsap_drawChart);


      function dzsap_drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn("string", "Topping");
        data.addColumn("number", "Slices");
        data.addRows([<?php
          $i = 0;
          foreach ($arr_attcomms as $att) {
            echo '';
//            ['Mushrooms', 3],
            $auxpo = get_post($att['id']);
//            print_r($aux);

            if ($i > 0) {
              echo ',';
            }
            echo '["' . $auxpo->post_title . '", ' . $att['commnr'] . ']';
            $i++;
            //echo 'Track <strong>'.$att['id'].'</strong>, '.$auxpo->post_title.' - '.$att['commnr'].' comments<br/>';
          };
          ?>]);
        var options = {
          "title": "' . esc_html__('Number of Comments', 'dzsap') . '",
          "width": "100%",
          "height": 300
        };
        var chart = new google.visualization.PieChart(document.getElementById("dzsap_chart_div"));
        chart.draw(data, options);
      }
    </script><?php


  }

  function handle_wp_head() {

    global $post;
    echo '<script>';
    echo 'window.ajaxurl="' . admin_url('admin-ajax.php') . '";';
    echo 'window.dzsap_init_calls=[];';
    echo 'window.dzsap_curr_user="' . get_current_user_id() . '";';
    echo 'window.dzsap_settings= { dzsap_site_url: "' . site_url() . '/",wpurl: "' . site_url() . '/",version: "' . DZSAP_VERSION . '",ajax_url: "' . admin_url('admin-ajax.php') . '", debug_mode:"' . $this->mainoptions['debug_mode'] . '" ';


//        echo ' $this->mainoptions - '; print_rr($this->mainoptions);
    $lab = 'dzsaap_default_portal_upload_type';
    if ($this->mainoptions[$lab] && $this->mainoptions[$lab] != 'audio') {

      echo ',' . $lab . ':"' . $this->mainoptions[$lab] . '"';
    }
    if ($post && $post->post_type == 'dzsap_items') {
      echo ',playerid: "' . $post->ID . '"';
    }


    echo '}; ';


    if ($this->mainoptions['keyboard_show_tooltips'] != 'off' ||
      $this->mainoptions['keyboard_play_trigger_step_back'] != 'off' ||
      $this->mainoptions['keyboard_step_back_amount'] != '5' ||
      $this->mainoptions['keyboard_step_back'] != '37' ||
      $this->mainoptions['keyboard_step_forward'] != '39' ||
      $this->mainoptions['keyboard_sync_players_goto_prev'] != '' ||
      $this->mainoptions['keyboard_sync_players_goto_next'] != '' ||
      $this->mainoptions['keyboard_pause_play'] != '32'
    ) {

      echo 'window.dzsap_keyboard_controls = {
\'play_trigger_step_back\':\'' . $this->mainoptions['keyboard_play_trigger_step_back'] . '\'
,\'step_back_amount\':\'' . $this->mainoptions['keyboard_step_back_amount'] . '\'
,\'step_back\':\'' . $this->mainoptions['keyboard_step_back'] . '\'
,\'step_forward\':\'' . $this->mainoptions['keyboard_step_forward'] . '\'
,\'sync_players_goto_prev\':\'' . $this->mainoptions['keyboard_sync_players_goto_prev'] . '\'
,\'sync_players_goto_next\':\'' . $this->mainoptions['keyboard_sync_players_goto_next'] . '\'
,\'pause_play\':\'' . $this->mainoptions['keyboard_pause_play'] . '\'
,\'show_tooltips\':\'' . $this->mainoptions['keyboard_show_tooltips'] . '\'
}';
    }

    echo '</script>';

    echo '<style class="dzsap-extrastyling">.feed-dzsap{ display:none; }';
    if ($this->mainoptions['extra_css']) {
      echo $this->mainoptions['extra_css'];
    }
    echo '</style>';


//        echo 'is_tax - '.;


    if (is_tax($this->taxname_sliders) || ($this->mainoptions['single_index_seo_disable'] == 'on' && is_singular('dzsap_items'))) {
      echo '<meta name="robots" content="noindex, follow">';
    }

//        print_rr($post);
    if ($this->mainoptions['replace_powerpress_plugin'] == 'on') {

      global $post;

      if ($post) {
        if ($post->ID != '4812' && $post->ID != '23950') {
//                if($post->ID!='23950'){
          $this->mainoptions['replace_powerpress_plugin'] = 'off';
//                    echo "CEVA";
        }
      }

    }


    if (isset($_GET['action'])) {
      if ($_GET['action'] == 'embed_zoomsounds') {

        // -- embedded css
        ?>
        <style>
          html, body {
            background-color: transparent;
          }

          body > * {
            display: none !important;
          }

          body > .dzsap-main-con {
            display: block !important;
          }

          body .zoomsounds-embed-con {
            display: block !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
          }
        </style>
        <script>
          document.addEventListener("DOMContentLoaded", function () {
            var nodes = document.querySelector('.zoomsounds-embed-con');
            document.body.append(nodes);
          });
        </script><?php

      }
    }


    if (isset($_GET['dzsap_generate_pcm']) && $_GET['dzsap_generate_pcm']) {

      include DZSAP_BASE_PATH.'class_parts/part-regenerate-waves-player.php';
    }

    dzsap_shortcode_init_listeners();
  }

  public function enqueue_main_scripts() {
    wp_enqueue_script('dzsap', $this->base_url . "audioplayer/audioplayer.js", array('jquery'), DZSAP_VERSION);
    wp_enqueue_style('dzsap', $this->base_url . 'audioplayer/audioplayer.css', array(), DZSAP_VERSION);
  }


  function duplicate_post($reference_po_id, $pargs = array()) {


    $margs = array(
      'new_term_slug' => '',
      'call_from' => 'default',
      'new_tax' => 'dzsap_sliders',
    );

    $margs = array_merge($margs, $pargs);

    $reference_po = get_post($reference_po_id);


    $current_user = wp_get_current_user();
    $new_post_author_id = $current_user->ID;

    $args = array(
      'post_title' => $reference_po->post_title,
      'post_content' => $reference_po->post_content,
      'post_status' => 'publish',
      'post_author' => $new_post_author_id,
      'post_type' => $reference_po->post_type,
    );


    $sample_post_2_id = wp_insert_post($args);


    /*
		 * get all current post terms ad set them to the new post draft
		 */
    $taxonomies = get_object_taxonomies($reference_po->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
    foreach ($taxonomies as $taxonomy) {
      if ($margs['new_term_slug']) {
        if ($taxonomy == 'dzsap_sliders') {
          continue;
        }
      }
      $post_terms = wp_get_object_terms($reference_po_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($sample_post_2_id, $post_terms, $taxonomy, false);
    }


    // -- for duplicate term
    if ($margs['new_term_slug']) {

      wp_set_object_terms($sample_post_2_id, $margs['new_term_slug'], $margs['new_tax'], false);
    } else {

    }


    /*
		 * duplicate all post meta just in two SQL queries
		 */
    global $wpdb;
    $sql_query_sel = array();
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$reference_po_id");
    if (count($post_meta_infos) != 0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        if ($meta_key == '_wp_old_slug' || $meta_key == '_dzsap_likes' || $meta_key == '_dzsap_views') {
          continue;
        }
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[] = "SELECT $sample_post_2_id, '$meta_key', '$meta_value'";
      }
      $sql_query .= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }

    return $sample_post_2_id;
  }


  function sliders_admin_generate_item_meta_cat($cat, $po, $pargs = array()) {

    // -- generate options for sliders admin category


    $margs = array(

      'for_shortcode_generator' => false,
      'for_item_meta' => false,
    );

    $margs = array_merge($margs, $pargs);

    $fout = '';
    // -- we need real location, not insert-id
    $struct_uploader = '<div class="dzs-wordpress-uploader ">
     <a rel="nofollow" href="#" class="button-secondary">' . __('Upload', 'dzsvp') . '</a>
</div>';


    // -- generate item category ( for sliders admin )
    foreach ($this->options_item_meta as $lab => $oim) {


      $oim = array_merge(array(
        'category' => '',
        'no_preview' => '',
        'it_is_for' => 'item_meta',
        'input_extra_classes' => '',
      ), $oim);


      // -- some sanitizing
      if ($oim['type'] == 'image') {
        $oim['type'] = 'attach';
      }


      if (isset($oim['options'])) {
        if (isset($oim['choices']) == false) {
          $oim['choices'] = $oim['options'];
        }
      }

      if ($oim['category'] == $cat) {

      } else {
        if ($cat == 'main') {
          if ($oim['category'] == '') {


          } else {
            continue;
          }
        } else {
          continue;
        }
      }

      if ($oim['it_is_for'] == 'shortcode_generator') {


//	            print_rr($margs);
        if ($margs['for_shortcode_generator'] == false) {
          continue;
        }
      }

      if ($oim['it_is_for'] == 'for_item_meta_only') {


//	            print_rr($margs);
        if ($margs['for_item_meta'] == false) {
          continue;
        }
      }


      if ($oim['type'] == 'dzs_row') {
        $fout .= '<section class="dzs-row">';
        continue;

      }
      if ($oim['type'] == 'dzs_col_md_6') {
        $fout .= '<section class="dzs-col-md-6">';
        continue;

      }
      if ($oim['type'] == 'dzs_col_md_12') {
        $fout .= '<section class="dzs-col-md-6">';
        continue;

      }

      if ($oim['type'] == 'dzs_row_end') {
        $fout .= '</section><!--dzs row end-->';
        continue;

      }
      if ($oim['type'] == 'dzs_col_md_6_end') {
        $fout .= '</section><!--dzs dzs_col_md_6_end end-->';
        continue;

      }
      if ($oim['type'] == 'dzs_col_md_12_end') {
        $fout .= '</section><!--dzs dzs_col_md_12_end end-->';
        continue;

      }
      if ($oim['type'] == 'custom_html') {
        $fout .= $oim['custom_html'];
        continue;

      }


      $fout .= '<div class="setting ';
      $option_name = $oim['name'];
      $fout .= ' data-option-name-' . $option_name . '';

      if ($oim['type'] == 'attach') {
        $fout .= ' setting-upload';
      }

      $fout .= '" ';

      $fout .= ' data-option-name="' . $option_name . '"';

      if (isset($oim['dependency']) && $oim['dependency']) {
        $fout .= ' data-dependency=\'' . json_encode($oim['dependency']) . '\'';
      }


      $fout .= '>';


      if ((strpos($option_name, 'item_source') || $option_name == 'source')) {

//		        error_log('add attachment id');

        $lab_aux = 'dzsap_meta_source_attachment_id';
        $val_aux = '';
        if ($po) {

          $val_aux = get_post_meta($po->ID, $lab_aux, true);
        }


        $class = 'setting-field shortcode-field';

        if ($margs['for_shortcode_generator']) {
          $class .= ' insert-id';
        }

        // -- source

        $class .= $oim['input_extra_classes'];

        $fout .= DZSHelpers::generate_input_text($lab_aux, array(
          'class' => $class,
          'seekval' => $val_aux,
          'input_type' => 'hidden',
        ));
      }

      $fout .= '<h5 class="setting-label setting-label-item-meta-cat">' . $oim['title'] . '</h5>';


      if ($oim['type'] == 'attach') {


        if ($oim['no_preview'] != 'on') {
          $fout .= '<span class="uploader-preview"></span>';
        }
      }


      if ($margs['for_shortcode_generator']) {
        $option_name = str_replace('dzsap_meta_item_', '', $option_name);
        $option_name = str_replace('dzsap_meta_', '', $option_name);

        if ($option_name == 'the_post_title') {
          $option_name = 'songname';
        }
      }

      $extraattr_input = '';

      if (isset($oim['extraattr_input']) && $oim['extraattr_input']) {
        $extraattr_input .= $oim['extraattr_input'];
      }

      $val = '';

      if ($po && is_int($po->ID)) {

        $val = get_post_meta($po->ID, $option_name, true);
      }

      if ($po && $option_name == 'the_post_title') {
        $val = $po->post_title;
      }
      if ($po && $option_name == 'post_content') {
        $val = $po->post_content;
      }

      $class = 'setting-field medium';

      if ($oim['type'] == 'attach') {
        $class .= ' uploader-target';
      }

      if ($margs['for_shortcode_generator']) {
        $class .= ' shortcode-field';
      }

//        print_rr($oim);
      $class .= $oim['input_extra_classes'];

//      echo 'class - '.$class;
      if ($oim['type'] == 'attach') {


        if (isset($oim['upload_type']) && $oim['upload_type']) {
          $class .= ' upload-type-' . $oim['upload_type'];
        }
        $class .= 'setting-field shortcode-field';

        if ($option_name == 'source' && $margs['for_shortcode_generator']) {
          $class .= ' insert-id';
        }

        $fout .= DZSHelpers::generate_input_text($option_name, array(
          'class' => $class,
          'seekval' => $val,
          'extraattr' => $extraattr_input,
        ));
      }
      if ($oim['type'] == 'text') {
        $fout .= DZSHelpers::generate_input_text($option_name, array(
          'class' => $class,
          'seekval' => $val,
          'extraattr' => $extraattr_input,
        ));
      }
      if ($oim['type'] == 'textarea') {
        $fout .= DZSHelpers::generate_input_textarea($option_name, array(
          'class' => $class,
          'seekval' => $val,
          'extraattr' => $extraattr_input,
        ));
      }
      if ($oim['type'] == 'select') {


        $class = '';

        if (isset($oim['class'])) {
          $class .= $oim['class'];
        }
        $class .= ' dzs-style-me skin-beige setting-field';

        if (isset($oim['select_type']) && $oim['select_type']) {
          $class .= ' ' . $oim['select_type'];
        }
        if ($margs['for_shortcode_generator']) {
          $class .= ' shortcode-field';
        }

        $fout .= DZSHelpers::generate_select($option_name, array(
          'class' => $class,
          'seekval' => $val,
          'options' => $oim['choices'],
          'extraattr' => $extraattr_input,
        ));

        if (isset($oim['select_type']) && $oim['select_type'] == 'opener-listbuttons') {

          $fout .= '<ul class="dzs-style-me-feeder">';

          foreach ($oim['choices_html'] as $oim_html) {

            $fout .= '<li>';
            $fout .= $oim_html;
            $fout .= '</li>';
          }

          $fout .= '</ul>';
        }


      }

      if ($oim['type'] == 'attach') {


        if (current_user_can('upload_files')) {
          $fout .= '<div class="dzs-wordpress-uploader here-uploader ">
 <a rel="nofollow" href="#" class="button-secondary';


          if (isset($oim['upload_btn_extra_classes']) && $oim['upload_btn_extra_classes']) {
            $fout .= ' ' . $oim['upload_btn_extra_classes'];
          }

          $fout .= '">' . esc_html__('Upload', 'dzsvp') . '</a>
</div>';


        }
//			    $fout.= $struct_uploader;
      }

      if (isset($oim['sidenote']) && $oim['sidenote']) {
        $fout .= '<div class="sidenote">' . $oim['sidenote'] . '</div>';
      }


      if (isset($oim['sidenote-2']) && $oim['sidenote-2']) {


        $sidenote_2_class = '';

        if (isset($oim['sidenote-2-class'])) {
          $sidenote_2_class = $oim['sidenote-2-class'];
        }
        $fout .= '<div class="sidenote-2 ' . $sidenote_2_class . '">' . $oim['sidenote-2'] . '</div>';
      }


      $fout .= '
                    </div>';


    }


    return $fout;
  }

  function sliders_admin_generate_item($po) {


    $fout = '';
    $thumb = '';
    $thumb_from_meta = '';
    // -- we need real location, not insert-id
    $struct_uploader = '<div class="dzs-wordpress-uploader ">
     <a rel="nofollow" href="#" class="button-secondary">' . __('Upload', 'dzsvp') . '</a>
</div>';


    $po_id = '';
    if ($po && is_int($po->ID)) {

      $thumb = $this->get_post_thumb_src($po->ID);

      $po_id = $po->ID;
//            echo ' thumb - ';
//            print_r($thumb);


      $thumb_from_meta = get_post_meta($po->ID, 'dzsap_meta_item_thumb', true);
    }

    if ($thumb_from_meta) {

      $thumb = $thumb_from_meta;
    }

    $thumb_url = '';
    if ($thumb) {
      $thumb_url = $this->sanitize_id_to_src($thumb);

//                    echo ' thumb - '.$this->sanitize_id_to_src($thumb);
    }


    if ($po_id) {

      $fout .= '<div class="slider-item dzstooltip-con for-click';

      if ($po && $po->ID == 'placeholder') {
        $fout .= ' slider-item--placeholder';
      }

      $fout .= '" data-id="' . $po->ID . '">';


//            $fout.='<div class="auxdev-dzs-meta-order" style="display:none; " >'.get_post_meta($po->ID,'dzsap_meta_order_54',true).'</div>';


      $fout .= '<div class="divimage" style="background-image:url(' . $thumb_url . ');"></div>';
      $fout .= '<div class="slider-item--title" >' . $po->post_title . '</div>';

      $fout .= '<div class="delete-btn item-control-btn"><i class="fa fa-times-circle-o"></i></div>
<div class="clone-item-btn item-control-btn"><i class="fa fa-clone"></i></div>
<div class="dzstooltip dzstooltip-legacy skin-black transition-fade arrow-top align-center">
<div class="dzstooltip--selector-top"></div>
<div class="dzstooltip--content">';


      $fout .= '<div class="dzs-tabs dzs-tabs-meta-item  skin-default " data-options=\'{ "design_tabsposition" : "top"
,"design_transition": "fade"
,"design_tabswidth": "default"
,"toggle_breakpoint" : "200"
,"settings_appendWholeContent": "true"
,"toggle_type": "accordion"
}
\' style=\'padding: 0;\'>

                <div class="dzs-tab-tobe">
                    <div class="tab-menu ">' . esc_html__("General", 'dzsap') . '
    </div>
    <div class="tab-content tab-content-item-meta-cat-main">

' . $this->sliders_admin_generate_item_meta_cat('main', $po) . '
    </div>
    </div>
    ';


      foreach ($this->item_meta_categories_lng as $lab => $val) {


        ob_start();
        ?>

        <div class="dzs-tab-tobe">
        <div class="tab-menu ">
          <?php
          echo($val);
          ?>
        </div>
        <div class="tab-content tab-content-cat-<?php echo $lab; ?>">


          <?php
          echo $this->sliders_admin_generate_item_meta_cat($lab, $po);
          ?>


        </div>
        </div><?php

        $fout .= ob_get_clean();


      }

      $fout .= '</div>';// -- end tabs


      $fout .= '</div>';
      $fout .= '</div>';
      $fout .= '</div>';
    }

    return $fout;
  }


  function sanitize_for_javascript_double_quote_value($arg) {

    $arg = str_replace('"', '', $arg);

    if ($arg == '/') {
      $arg = '';
    }

    return $arg;

  }

  function generate_extra_css_player($pargs = array()) {


    $margs = array(

      'colorhighlight' => '',
      'skin_ap' => '',
      'selector' => '',
      'call_from' => '',
    );

    $margs = array_merge($margs, $pargs);

    $selector = $margs['selector'];

    $colorHighlight = $this->sanitize_to_hex_color_without_hash($margs['colorhighlight']);

    $fout = '';
    if ($margs['skin_ap'] == 'skin-wave') {
      $fout .= $selector . ' .player-but .the-icon-bg, ' . $selector . ' .playbtn .the-icon-bg , ' . $selector . ' .pausebtn .the-icon-bg, ' . $selector . '.skin-wave .ap-controls .scrubbar .scrubBox-hover { background-color: #' . $colorHighlight . ';   border-color: #' . $colorHighlight . ';   } ' . $selector . ' .meta-artist .the-artist { color: #' . $colorHighlight . '; opacity:0.7;} ' . $selector . ' .volume_active { background-color: #' . $colorHighlight . ';} ';
    }

    $fout .= '' . $selector . ' .meta-artist .the-songname, ' . $selector . ' .meta-artist .the-songname>a, ' . $selector . ' .meta-artist .the-songname object>a { color: #' . $colorHighlight . '; }';


    if ($margs['skin_ap'] == 'skin-pro') {
      $selector = '' . $selector . '.skin-pro';
      $fout .= $selector . ' .ap-controls .scrubbar .scrub-prog{  background-color: #' . $colorHighlight . ';  }';
    }


    if ($margs['skin_ap'] == 'skin-minimal') {
      $fout .= $selector . ' .skin-minimal--inner-bg-under, ' . $selector . ' .skin-minimal--inner-inner-bg{  background-color: #' . $colorHighlight . ';  }';
    }

    return $fout;
  }

  function sanitize_to_hex_color_without_hash($arg) {


    $arg = str_replace('#', '', $arg);

    return $arg;
  }

  function handle_admin_head() {
    // on every admin page <head>
    //echo 'ceva23';
    ///siteurl : "'.site_url().'",
    $aux = admin_url('admin.php?page=' . $this->adminpagename);

    if (isset($_GET['page']) && $_GET['page'] == $this->pageName_legacy_sliders_admin_vpconfigs) {
      $aux = admin_url('admin.php?page=' . $this->pageName_legacy_sliders_admin_vpconfigs);
    }

    if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename_about) {

      wp_enqueue_style('dzsap', $this->base_url . 'libs/videogallery/vplayer.css');
      wp_enqueue_script('dzsap', $this->base_url . "libs/videogallery/vplayer.js");
    }


    wp_enqueue_style('dzsap_admin_global', $this->base_url . 'admin/admin_global.css', array(), DZSAP_VERSION);
    wp_enqueue_script('dzsap_admin_global', $this->base_url . 'admin/admin_global.js', array('jquery'), DZSAP_VERSION);
    if ($this->mainoptions['activate_comments_widget'] == 'on') {
      wp_enqueue_script('googleapi', 'https://www.google.com/jsapi');
    }

    wp_enqueue_style('ultibox', $this->base_url . 'libs/ultibox/ultibox.css');
    wp_enqueue_script('ultibox', $this->base_url . 'libs/ultibox/ultibox.js');

    wp_enqueue_style('dzsselector', $this->base_url . 'libs/dzsselector/dzsselector.css');
    wp_enqueue_script('dzsselector', $this->base_url . 'libs/dzsselector/dzsselector.js');


    $params = array('currslider' => '_currslider_');
    $newurl = add_query_arg($params, $aux);

    $params = array('deleteslider' => '_currslider_');
    $delurl = add_query_arg($params, $aux);

    $theurl_forwaveforms = $this->base_url;
    $thepath_forwaveforms = $this->base_url;

    if (isset($this->mainoptions['use_external_uploaddir']) && $this->mainoptions['use_external_uploaddir'] == 'on') {
//            $theurl_forwaveforms = site_url('wp-content') . '/upload/';

      $upload_dir = wp_upload_dir();
      $theurl_forwaveforms = $upload_dir['url'] . '/';

      $aux = $upload_dir['path'] . '/';
      $thepath_forwaveforms = str_replace('\\', '/', $aux);
    }

    DZSZoomSoundsHelper::enqueueScriptsForAdminGeneral();
    ?>
    <script><?php

      // -- admin head

      //        echo 'window.dzsap_settings= { dzsap_site_url: "' . site_url() . '/",wpurl: "' . site_url() . '/",version: "' . DZSAP_VERSION . '",ajax_url: "' . admin_url('admin-ajax.php') . '", debug_mode:"'.$this->mainoptions['debug_mode'].'" }; ';

      echo 'window.ultibox_options_init = {
                \'settings_deeplinking\' : \'off\'
                ,\'extra_classes\' : \'close-btn-inset\'
            };
            
        window.init_zoombox_settings = { settings_disableSocial : "on" ,settings_deeplinking : "off" }; window.dzsap_settings = { thepath: "' . $this->base_url . '",the_url: "' . $this->base_url . '",theurl_forwaveforms: "' . $theurl_forwaveforms . '",siteurl: "' . site_url() . '",site_url: "' . site_url() . '",admin_url: "' . admin_url() . '"
            ,thepath_forwaveforms: "' . $thepath_forwaveforms . '"
            , is_safebinding: "' . $this->mainoptions['is_safebinding'] . '", admin_close_otheritems:"' . $this->mainoptions['admin_close_otheritems'] . '",settings_wavestyle:"' . $this->mainoptions['settings_wavestyle'] . '"
,url_vpconfig:"' . admin_url('admin.php?page=' . $this->pageName_legacy_sliders_admin_vpconfigs . '&currslider={{currslider}}') . '"
,shortcode_generator_url: "' . admin_url('admin.php?page=' . $this->page_mainoptions_link) . '&dzsap_shortcode_builder=on"
,shortcode_generator_player_url: "' . admin_url('admin.php?page=' . $this->page_mainoptions_link) . '&dzsap_shortcode_player_builder=on"
,translate_add_gallery : "' . esc_html__('Add Playlist', 'dzsap') . '"
,translate_add_player : "' . esc_html__('Add Player', 'dzsap') . '"
,translate_nag_intro_title : "' . esc_html__('Welcome to ZoomSounds Audio Player', 'dzsap') . '"
,translate_nag_intro_col1 : "' . esc_html__('Players can be setup from the ZoomSounds Player Gutenberg block or the shortcode generator in the classic block, with the possibility to import players with one click.', 'dzsap') . '"
,translate_nag_intro_col2 : "' . esc_html__('Playlists can be setup from the ZoomSounds Playlist Gutenberg block or the shortcode generator in the classic block, with the possibility to import playlists with one click.', 'dzsap') . '"
,translate_nag_intro_1 : "' . esc_html__('Thank you for installing', 'dzsap') . ' <strong>ZoomSounds Audio Player</strong>, ' . esc_html__(' you can create playlists from the Playlists menu, players configurations from the submenu here or just use custom data and tailor it to your needs.', 'dzsap') . '"
,translate_nag_intro_title_1 : "' . esc_html__('Players', 'dzsap') . '"
,translate_nag_intro_title_2 : "' . esc_html__('Playlists', 'dzsap') . '"';

      //echo 'hmm';


      if ($this->mainoptions['soundcloud_api_key']) {
        echo ',soundcloud_apikey : "' . $this->mainoptions['soundcloud_api_key'] . '"';
      }


      // -- playlists admin
      if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename && (isset($this->mainitems[$this->currSlider]) == false || $this->mainitems[$this->currSlider] == '')) {
        echo ', addslider:"on"';
      }
      // -- configs admin
      if (isset($_GET['page']) && $_GET['page'] == $this->pageName_legacy_sliders_admin_vpconfigs && (isset($this->mainitems_configs[$this->currSlider]) == false || $this->mainitems_configs[$this->currSlider] == '')) {
        echo ', addslider:"on"';
      }


      echo ',urldelslider:"' . $delurl . '", urlcurrslider:"' . $newurl . '", currSlider:"' . $this->currSlider . '", currdb:"' . $this->currDb . '", color_waveformbg:"' . $this->sanitize_to_hex_color_without_hash($this->mainoptions['color_waveformbg']) . '", color_waveformprog:"' . $this->sanitize_to_hex_color_without_hash($this->mainoptions['color_waveformprog']) . '", waveformgenerator_multiplier:"' . $this->mainoptions['waveformgenerator_multiplier'] . '"';

      //      echo ',nag_intro_data: "' . 'on' . '"'; wp_enqueue_style('dzs.tooltip', $this->base_url . 'libs/dzstooltip/dzstooltip.css');
      if (!(isset($this->mainoptions['acknowledged_intro_data']) && $this->mainoptions['acknowledged_intro_data'] == 'on')) {


        echo ',nag_intro_data: "' . 'on' . '"';
        wp_enqueue_style('dzs.tooltip', $this->base_url . 'libs/dzstooltip/dzstooltip.css');

      }



      echo ',sliders:[';

      $this->db_read_mainitems();

      if ($this->mainoptions['playlists_mode'] == 'normal') {

//        print_rr($this->mainitems);
        foreach ($this->mainitems as $mainitem) {
          echo '{ value: "' . $mainitem['value'] . '",label: "' . $mainitem['label'] . '",term_id: "' . $mainitem['term_id'] . '" },';
        }
      } else {

        foreach ($this->mainitems as $mainitem) {
          echo '{ value: "' . dzs_sanitize_for_js_double_quote($mainitem['settings']['id']) . '",label: "' . dzs_sanitize_for_js_double_quote($mainitem['settings']['id']) . '" },';
        }
      }
      echo ']';


      include("class_parts/options-item-meta.php");


      // -- from options-item-meta
      echo ',player_options:\'';
      echo addslashes(json_encode($this->options_item_meta_sanitized));
      echo '\'';
      echo '};';

      ?>
      window.dzsap_gutenberg_player_options_for_js_init = {};
      try {
        JSON.parse(dzsap_settings.player_options).forEach((el) => {


          let aux = {};

          aux.type = 'string';
          if ((el.type)) {
            aux.type = el.type;
          }
          if ((el['default'])) {

            aux['default'] = el['default'];
          }

          // -- sanitizing
          if (aux.type == 'text') {
            aux.type = 'string';
          }

          // console.log('aux.type - ',aux.type, aux);

          if (aux.type == 'string' || aux.type == 'attach' || aux.type == 'select') {
            window.dzsap_gutenberg_player_options_for_js_init[el.name] = aux;
          }

        })
      } catch (err) {
        console.info('no options');
      }
      window.dzsap_gutenberg_playlist_options_for_js_init = {
        'dzsap_select_id': {
          'type': 'string',
          'default': 'songs-with-thumbnails'
        }, 'examples_con_opened': {'type': 'string', 'default': ''}
      };
      ; <?php


      ?></script><?php

    // -- admin_head


//        error_log('$this->mainoptions[\'enable_auto_backup\'] - '.$this->mainoptions['enable_auto_backup']);
    if ($this->mainoptions['enable_auto_backup'] == 'on') {
//            $this->do_backup();
      $last_backup = get_option('dzsap_last_backup');


//            error_log('$last_backup - '.$last_backup) ;
      if ($last_backup) {

        $timestamp = time();
        if (abs($timestamp - $last_backup) > (3600 * 24 * 1)) {

          $this->do_backup();
        }

      } else {
        $this->do_backup();
      }
    }
//	    $this->do_backup();
    if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename) {
    }
    if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == $this->taxname_sliders) {

      ?>
      <style>body.taxonomy-dzsap_sliders .wrap, .dzsap-sliders-con {
          opacity: 0;
          transition: opacity 0.3s ease-out;
        }

        body.taxonomy-dzsap_sliders.sliders-loaded .wrap, body.taxonomy-dzsap_sliders.sliders-loaded .dzsap-sliders-con {
          opacity: 1;
        }
      </style>
      <?php
    }
  }


  function import_demo_create_term_if_it_does_not_exist($pargs = array()) {


    $margs = array(

      'term_name' => '',
      'slug' => '',
      'taxonomy' => '',
      'description' => '',
      'parent' => '',
    );

    $margs = array_merge($margs, $pargs);

    $term = get_term_by('slug', $margs['slug'], $margs['taxonomy']);


    if ($term) {

    } else {


      $args = array(
        'description' => $margs['description'],
        'slug' => $margs['slug'],


      );

      if ($margs['parent']) {
        $args['parent'] = $margs['parent'];
      }

      $term = wp_insert_term($margs['term_name'], $margs['taxonomy'], $args);

    }
    return $term;

  }


  function import_demo_create_attachment($img_url, $port_id, $img_path) {


    $attachment = array(
      'guid' => $img_url,
      'post_mime_type' => 'image/jpeg',
      'post_title' => preg_replace('/\.[^.]+$/', '', basename($img_url)),
      'post_content' => '',
      'post_status' => 'inherit'
    );

    // Insert the attachment.
    $attach_id = wp_insert_attachment($attachment, $img_url, $port_id);


    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata($attach_id, $img_path);
    //        die();
    wp_update_attachment_metadata($attach_id, $attach_data);

    return $attach_id;
  }


  function import_demo_create_portfolio_item($pargs = array()) {


    $margs = array(

      'post_title' => '',
      'post_content' => '',
      'post_status' => '',
      'post_type' => 'dzsvcs_port_items',
    );

    $margs = array_merge($margs, $pargs);


    $args = array(
      'post_type' => $margs['post_type'],
      'post_title' => $margs['post_title'],
      'post_content' => $margs['post_content'],
      'post_status' => $margs['post_status'],


      /*other default parameters you want to set*/
    );


    $post_id = wp_insert_post($args);

    return $post_id;


  }

  function import_demo_insert_post_complete($pargs = array()) {


    $margs = array(

      'post_title' => '',
      'call_from' => 'default',

      'post_content' => '',
      'post_type' => 'dzsap_items',
      'post_status' => 'publish',
      'post_name' => '',
      'img_url' => '',
      'img_path' => '',
      'term' => '',
      'taxonomy' => '',
      'attach_id' => '',
      'dzsvp_thumb' => '',
      'dzsvp_item_type' => 'detect',
      'dzsvp_featured_media' => '',


    );

    $margs = array_merge($margs, $pargs);


    if ($margs['post_name']) {


      $ind = 1;
      $breaker = 100;


      $the_slug = $margs['post_name'];
      $original_slug = $margs['post_name'];
      $args = array(
        'name' => $the_slug,
        'post_type' => $margs['post_type'],
        'post_status' => 'publish',
        'numberposts' => 1
      );
      $my_posts = get_posts($args);
      if ($my_posts) {


        while (1) {

          $the_slug = $margs['post_name'];
          $original_slug = $margs['post_name'];
          $args = array(
            'name' => $the_slug,
            'post_type' => $margs['post_type'],
            'post_status' => 'publish',
            'numberposts' => 1
          );
          $my_posts = get_posts($args);
          if ($my_posts) {

            $ind++;
            $margs['post_name'] = $original_slug . '-' . $ind;
          } else {
            break;
          }

          $breaker--;

          if ($breaker < 0) {
            break;
          }
        }

        $ind++;

        $margs['post_name'] = $original_slug . '-' . $ind;
      } else {

      }


    }

    $args = array(
      'post_type' => $margs['post_type'],
      'post_title' => $margs['post_title'],

      'post_content' => $margs['post_content'],
      'post_status' => $margs['post_status'],


      /*other default parameters you want to set*/
    );


    if ($margs['post_name']) {
      //            $args['name']=$margs['post_name'];
      $args['post_name'] = $margs['post_name'];
    }


    if ($margs['term']) {

      $term = $margs['term'];
    }
    $taxonomy = $margs['taxonomy'];

    if ($margs['img_url']) {

      $img_url = $margs['img_url'];
    }
    $img_path = $margs['img_path'];


    //        print_rr($margs);


    error_log(' item import - ' . print_rr($margs, true) . print_rr($args, true));
    $port_id = $this->import_demo_create_portfolio_item($args);

    if ($margs['term']) {
      $term = $margs['term'];


      if (is_object($margs['term']) && isset($margs['term']->term_id)) {
        $term = $margs['term']->term_id;
      } else {

        if (is_array($margs['term']) && isset($margs['term']['term_id'])) {
          $term = $margs['term']['term_id'];
        }
      }
      wp_set_post_terms($port_id, $term, $taxonomy);
    }


    foreach ($margs as $lab => $val) {
      if (strpos($lab, 'dzsap_') === 0) {

        update_post_meta($port_id, $lab, $val);
      }
    }


    //        update_post_meta($port_id,'q_meta_post_media',$img_url);


    if ($margs['attach_id']) {

      set_post_thumbnail($port_id, $margs['attach_id']);
    } else {

      if ($margs['img_url']) {
        $attach_id = $this->import_demo_create_attachment($img_url, $port_id, $img_path);
        set_post_thumbnail($port_id, $attach_id);

        $this->import_demo_last_attach_id = $attach_id;
      }

    }


    return $port_id;


  }

  function do_backup() {
    // -- generate backup

    $timestamp = time();

//        echo 'time - '.$timestamp;

    $data = get_option($this->dbname_mainitems);

    if (is_array($data)) {
      $data = serialize($data);
    }

//        echo ' data - '.$data;
//        file_put_contents('backups/backup_'.$timestamp,$data);
    $upload_dir = wp_upload_dir();
//        file_put_contents($this->base_path . 'backups/backup_' . $timestamp . '.txt', $data);


    error_log('do_backup()' . ' ' . time());

    if (file_exists($upload_dir['basedir'] . '/dzsap_backups')) {

//            echo 'dada';
    } else {

//            echo 'nunu';
      mkdir($upload_dir['basedir'] . '/dzsap_backups', 0755);
    }

    file_put_contents($upload_dir['basedir'] . '/dzsap_backups/backup_' . $timestamp . '.txt', $data);


//        $theurl_forwaveforms = $upload_dir['url'].'/';

//        echo $upload_dir['basedir'] . '/dzsap_backups/backup_' . $timestamp . '.txt';

//        print_r($upload_dir);

    update_option('dzsap_last_backup', $timestamp);


    if ($this->mainoptions['playlists_mode'] == 'normal') {


      $terms = get_terms($this->taxname_sliders, array(
        'hide_empty' => false,
      ));

      foreach ($terms as $term) {

        $data = $this->playlist_export($term->term_id);

        if (is_array($data)) {
          $data = json_encode($data);
        }
//                file_put_contents($this->base_path . 'backups/backup_' . $adb . '_' . $timestamp . '.txt', $data);
        file_put_contents($upload_dir['basedir'] . '/dzsap_backups/backup_' . $term->slug . '_' . $timestamp . '.txt', $data);
      }
    } else {

      if (is_array($this->dbs)) {
        foreach ($this->dbs as $adb) {
          $data = get_option($this->dbname_mainitems . '-' . $adb);

          if (is_array($data)) {
            $data = serialize($data);
          }
//                file_put_contents($this->base_path . 'backups/backup_' . $adb . '_' . $timestamp . '.txt', $data);
          file_put_contents($upload_dir['basedir'] . '/dzsap_backups/backup_' . $adb . '_' . $timestamp . '.txt', $data);


        }
      }
    }

    $logged_backups = array();
    try {

      $logged_backups = json_decode(get_option('dzsap_backuplog'), true);
    } catch (Exception $err) {

    }
    if (is_array($logged_backups) == false) {
      $logged_backups = array();
    }


    array_push($logged_backups, time());
    if (count($logged_backups) > 5) {
      array_shift($logged_backups);
    }


    update_option('dzsap_backuplog', json_encode($logged_backups));
  }

  function playlist_export($term_id, $pargs = array()) {


    $margs = array(
      'download_export' => false
    );

    $margs = array_merge($margs, $pargs);

    $term_meta = get_option("taxonomy_$term_id");

//		print_rr($term_meta);

    $tax = $this->taxname_sliders;

    $reference_term = get_term_by('id', $term_id, $tax);

//	        print_rr($reference_term);


    $reference_term_name = $reference_term->name;
    $reference_term_slug = $reference_term->slug;
    $selected_term_id = $reference_term->term_id;


    if ($selected_term_id) {

      $args = array(
        'post_type' => 'dzsap_items',
        'numberposts' => -1,
        'posts_per_page' => -1,
        //                'meta_key' => 'dzsap_meta_order_'.$selected_term,

        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
          'relation' => 'OR',
          array(
            'key' => 'dzsap_meta_order_' . $selected_term_id,
            //                        'value' => '',
            'compare' => 'EXISTS',
          ),
          array(
            'key' => 'dzsap_meta_order_' . $selected_term_id,
            //                        'value' => '',
            'compare' => 'NOT EXISTS'
          )
        ),
        'tax_query' => array(
          array(
            'taxonomy' => $tax,
            'field' => 'id',
            'terms' => $selected_term_id // Where term_id of Term 1 is "1".
          )
        ),
      );

      $my_query = new WP_Query($args);

//            print_r($my_query);


//            print_r($my_query->posts);


      $arr_export = array(
        'original_term_id' => $selected_term_id,
        'original_term_slug' => $reference_term_slug,
        'original_term_name' => $reference_term_name,
        'original_site_url' => site_url(),
        'export_type' => 'meta_term',
        'term_meta' => $term_meta,
        'items' => array(),
      );

      foreach ($my_query->posts as $po) {

//                print_r($po);


        $po_sanitized = $this->sanitize_to_gallery_item($po);


        array_push($arr_export['items'], $po_sanitized);

//                print_rr($po);
//                print_rr($po_sanitized);
//			        print_rr($po);
      }


      if ($margs['download_export']) {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . "dzsap_export_" . $reference_term_slug . ".txt" . '"');
      }

      return $arr_export;
    } else {
      return array();
    }
  }

  function get_wishlist() {


    $arr_wishlist = array();

    if (get_user_meta(get_current_user_id(), 'dzsap_wishlist', true) && get_user_meta(get_current_user_id(), 'dzsap_wishlist', true) != 'null') {
      try {

        $arr_wishlist = json_decode(get_user_meta(get_current_user_id(), 'dzsap_wishlist', true), true);
      } catch (Exception $e) {

      }
    }

    return $arr_wishlist;
  }


  function sanitize_term_slug_to_id($arg, $taxonomy_name = 'dzsvideo_category') {


    if (is_numeric($arg)) {

    } else {

      $term = get_term_by('slug', $arg, $taxonomy_name);

      if ($term) {
        $arg = $term->term_id;
      }
//                    echo 'new term_id - '; print_r($term_id);
    }


    return $arg;
  }


  function shortcode_audio($atts, $content = null) {
    global $current_user;

    //print_r($current_user->data);
    //echo 'ceva'.isset($current_user->data->user_nicename);
    // -- [zoomsounds_player source="pathto.mp3"]


    $this->sliders__player_index++;

    $fout = '';


    $this->front_scripts();

    $margs = array(
      'mp3' => '',
      'config' => 'default',
    );

    $margs = array_merge($margs, $atts);

    $margs['source'] = $margs['mp3'];
    $margs['config'] = $this->mainoptions['replace_audio_shortcode'];
    $margs['called_from'] = 'audio_shortcode';


    $audio_attachments = get_posts(array(
      'post_type' => 'attachment',
      'post_mime_type' => 'audio'
    ));

//	    print_rr($audio_attachments);

    $pid = 0;
    foreach ($audio_attachments as $lab => $val) {


      if ($val->guid == $margs['source']) {
        $pid = $val->ID;
        break;
      }
    }

    if ($pid) {
//	        $po = get_post($pid);

//	        print_rr($po);

      $margs['source'] = $pid;
    }


    if ($this->mainoptions['replace_audio_shortcode_extra_args']) {
      try {

        $arr = json_decode($this->mainoptions['replace_audio_shortcode_extra_args'], true);

//	            echo 'arr - '; print_rr($arr);
        $margs = array_merge($margs, $arr);
      } catch (Exception $e) {


      }
    }

    if ($this->mainoptions['replace_audio_shortcode_play_in_footer'] == 'on') {
      $margs['play_target'] = 'footer';
    }

    $playerid = '';

    $fout .= $this->shortcode_player($margs, $content);

//        print_r($its); print_r($margs); echo 'alceva'.$fout;

    return $fout;
  }


  /**
   *
   * @param $sourceid
   * @param $playerid - will mutate
   * @param $margs - will mutate
   * @return bool|false|mixed|string
   */
  function get_track_source($sourceid, &$playerid, &$margs) {

//        echo 'ceva = alceva';
    if ((intval($sourceid))) {
      $player_post_id = intval($sourceid);
      $player_post = get_post(intval($sourceid));

      if ($player_post && $player_post->post_type == 'attachment') {
        $media = wp_get_attachment_url($player_post_id);

//                echo 'media - '.$media;
        $sourceid = $media;
        if ($playerid) {

        } else {
          $playerid = $player_post_id;
          $margs['playerid'] = $player_post_id;
        }

//                    print_r($media);
      }
      if ($player_post && $player_post->post_type == 'product') {


        $sourceid = get_post_meta($player_post->ID, 'dzsap_woo_product_track', true);


        if ($sourceid == '') {
          $aux = get_post_meta($player_post->ID, '_downloadable_files', true);
          if ($aux && is_array($aux)) {
            $aux = array_values($aux);

            if (isset($aux[0]) && isset($aux[0]['file']) && strpos(strtolower($aux[0]['file']), '.mp3') !== false) {
              $sourceid = $aux[0]['file'];
            }
          }

//                    echo '$aux - ';print_r($aux);
        }

        if ($playerid) {

        } else {
          $playerid = $player_post_id;
          $margs['playerid'] = $player_post_id;
        }

//                    print_r($media);
      }
      if ($player_post && $player_post->post_type == 'dzsap_items') {
        $sourceid = get_post_meta($player_post->ID, 'dzsap_meta_item_source', true);
      }


      if ($sourceid == '') {
        if (function_exists('get_field')) {
          $arr = get_field('long_preview', $player_post_id);


          if ($arr) {

            $media = wp_get_attachment_url($arr);

//                echo 'media - '.$media;
            $sourceid = $media;
          }

          if ($sourceid == '') {
            if (function_exists('get_field')) {
              $arr = get_field('short_preview', $player_post_id);


              if ($arr) {

                $media = wp_get_attachment_url($arr);

//                echo 'media - '.$media;
                $sourceid = $media;
              }
            }
          }
        }
      }
    } else {


      if ($sourceid == '{{postid}}') {

        global $post;


        if ($post) {
          $player_post = $post;
        }


        $sourceid = get_post_meta($player_post->ID, 'dzsap_woo_product_track', true);


        if ($sourceid == '') {
          $aux = get_post_meta($player_post->ID, '_downloadable_files', true);
          if ($aux && is_array($aux)) {

            $aux = array_values($aux);


            if (isset($aux[0]) && isset($aux[0]['file']) && strpos(strtolower($aux[0]['file']), '.mp3') !== false) {

              $sourceid = $aux[0]['file'];
            }
          }

//                    echo '$aux - ';print_r($aux);
        }


        if ($margs['playerid'] == '') {
          $margs['playerid'] = $player_post->ID;
        }


      }


//                echo 'whaaaa';
    }

    return $sourceid;
  }


  function get_zoomsounds_player_config_settings($config_name) {


    $vpsettingsdefault = array(
      'id' => 'default',
      'skin_ap' => 'skin-wave',
      'skinwave_dynamicwaves' => 'off',
      'skinwave_enablespectrum' => 'off',
      'skinwave_enablereflect' => 'on',
      'skinwave_comments_enable' => 'off',
      'disable_volume' => 'default',
      'playfrom' => 'default',
      'enable_embed_button' => 'off',
      'loop' => 'off',
      'soundcloud_track_id' => '',
      'soundcloud_secret_token' => '',
    );

    $vpsettings = array();

    $vpconfig_k = -1;

    $vpsettings = array();
    $vpconfig_id = $config_name;


    if (is_array($config_name)) {


      $vpsettings['settings'] = $config_name;


    } else {

      for ($i = 0; $i < count($this->mainitems_configs); $i++) {
        if ((isset($vpconfig_id)) && ($vpconfig_id == $this->mainitems_configs[$i]['settings']['id'])) {
          $vpconfig_k = $i;
        }
      }


      if ($vpconfig_k > -1) {
        $vpsettings = $this->mainitems_configs[$vpconfig_k];
      } else {
        $vpsettings['settings'] = $vpsettingsdefault;
      }

      if (is_array($vpsettings) == false || is_array($vpsettings['settings']) == false) {
        $vpsettings = array('settings' => $vpsettingsdefault);
      }
    }

    return $vpsettings;
  }


  function show_curr_plays($pargs = array(), $content = '') {

    $fout = '';


    $str_views = $this->mainoptions['str_views'];


    global $post;


    if (isset($pargs['id'])) {
      $post = get_post($pargs['id']);
    }


    if ($post) {

      $aux = get_post_meta($post->ID, '_dzsap_views', true);
      if ($aux == '') {
        $aux = 0;
      }
      $fout = str_replace('{{get_plays}}', $aux, $str_views);

//	    $fout.=' ';

    }
    return $fout;
  }

  function call_js_init() {

    $fout = '';

    if ($this->mainoptions['script_init_method'] == 'javascript_array') {
      $fout .= 'if(window.dzsap_init_calls){window.dzsap_init_calls.push(function ($){';
    } else {
      $fout .= 'jQuery(document).ready(function ($){';
    }

    return $fout;
  }

  function call_js_end() {

    $fout = '';

    if ($this->mainoptions['script_init_method'] == 'javascript_array') {
      $fout .= ' });}';
    } else {
      $fout .= ' });';
    }


    return $fout;
  }

  function shortcode_player($pargs = array(), $content = '') {
    //[zoomsounds_player source="pathto.mp3" artistname="" songname=""]
    global $current_user, $post;

    //print_r($current_user->data);
    //echo 'ceva'.isset($current_user->data->user_nicename);
    $this->sliders__player_index++;

    $fout = '';


    $player_idx = $this->sliders__player_index;


    $this->front_scripts();

    $margs = array(
      'width' => '100%',
      'config' => 'default',
      'height' => '300',
      'source' => '',
      'sourceogg' => '',
      'coverimage' => '',
      'waveformbg' => '',
      'waveformprog' => '',
      'cue' => 'auto',
      'loop' => 'off',
      'autoplay' => 'off',
      'show_tags' => 'off',
      'type' => 'audio',
      'player' => '',
      'itunes_link' => '',
      'playerid' => '', // -- if player id okay
      'thumb' => '',
      'thumb_for_parent' => '',
      'mp4' => '',
      'openinzoombox' => 'off',
      'enable_likes' => 'off',
      'enable_downloads_counter' => 'off',
      'enable_views' => 'off',
      'enable_rates' => 'off',
      'title_is_permalink' => 'off',
      'playfrom' => 'off',
      'artistname' => 'default',
      'songname' => 'default',
      'single' => 'on',
      'embedded' => 'off', // -- in case it is embedded, we might remove embed button from conifg
      'divinsteadofscript' => 'off',
      'init_player' => 'on',
      'faketarget' => '',
      'sample_time_start' => '',
      'sample_time_end' => '',
      'sample_time_total' => '',
      'feed_type' => '',
      'extra_init_settings' => '',
      'player_index' => $player_idx,
      'inner_html' => '',
      'extraattr' => '',
      'extra_classes' => '',
      'content_inner' => '', // -- will replace content inner
      'extra_html' => '',
      'extra_html_in_controls_right' => '',
      'js_settings_extrahtml_in_float_right' => '', // -- js settings extra html in float right .. configs will go into extra_html_in_controls_right
      'play_target' => 'default', // -- "default" or "footer"
      'dzsap_meta_source_attachment_id' => '',
      'outer_comments_field' => '',
      'extra_classes_player' => '',
      'called_from' => 'player',
    );

    $default_margs = array_merge(array(), $margs);

    if (isset($pargs) && is_array($pargs)) {
      $margs = array_merge($margs, $pargs);
    }

//    print_rr($margs);

//    echo ' zoomsounds_player -> '; print_rr($margs);
    if ($content) {
      $margs['content_inner'] = $content;
    }


    if (isset($margs['dzsap_meta_item_source']) && $margs['dzsap_meta_item_source'] && (!($margs['source']) || $margs['source'] == '')) {
      $margs['source'] = $margs['dzsap_meta_item_source'];
    }
    if (isset($margs['item_source']) && $margs['item_source'] && (!($margs['source']) || $margs['source'] == '')) {
      $margs['source'] = $margs['item_source'];
    }
    if (isset($margs['the_post_title']) && $margs['the_post_title'] && (!($margs['songname']))) {
      $margs['songname'] = $margs['the_post_title'];
    }


    $original_player_margs = array_merge($margs, array());

    $original_source = $margs['source'];

//		echo 'margs - '; print_rr($margs);


    $embed_margs = array();


    // -- embed margs
    foreach ($margs as $lab => $arg) {
      if (isset($margs[$lab])) {
        if (isset($default_margs[$lab]) == false || $margs[$lab] !== $default_margs[$lab]) {
          $embed_margs[$lab] = $margs[$lab];
        }
      }
    }
    if (isset($embed_margs['cat_feed_data'])) {
      unset($embed_margs['cat_feed_data']);
    }


//        print_r($embed_margs);


//	    echo ' margs init shortcode_player() - '; print_rr($margs);

    if ($margs['feed_type'] == 's3') {

      // -- amazon s3
      // todo: maybe move to parse_items

      $path = dirname(__FILE__) . '/class_parts/aws/aws-autoloader.php';

//            echo 'file_exists($path) - '.file_exists($path);

      if (file_exists($path)) {

//                echo 'ceva';

        require_once($path);


        $s3 = null;


        try {

          $s3 = new Aws\S3\S3Client(array(

            'credentials' => array(
              'key' => $this->mainoptions['aws_key'],
              'secret' => $this->mainoptions['aws_key_secret']
            ),
            'version' => 'latest',
            'region' => $this->mainoptions['aws_region']
          ));
        } catch (Exception $e) {


          echo 'cannot load aws - ';
          print_rr($e);

          $credentials = new Credentials($this->mainoptions['aws_key'], $this->mainoptions['aws_key_secret']);

          $s3_client = new S3Client(array(
            'version' => 'latest',
            'region' => $this->mainoptions['aws_region'],
            'credentials' => $credentials
          ));
        }


        if ($s3) {


          $cmd = $s3->getCommand('GetObject', array(
            'Bucket' => $this->mainoptions['aws_bucket'],
            'Key' => $original_source,
            'ResponseContentDisposition' => 'filename=' . str_replace(array('%21', '%2A', '%27', '%28', '%29', '%20'), array('!', '*', '\'', '(', ')', ' '), rawurlencode('ceva' . '.' . pathinfo('ceva', PATHINFO_EXTENSION)))
          ));

//	            echo 'cmd - '; print_rr($cmd);

          $req = $s3->createPresignedRequest($cmd, '1 day');
          $url = (string)$req->getUri();


          $margs['source'] = $url;
        }

      } else {
        echo 'install amazon s3';
      }


    }


    $playerid = '';


    $player_post = null;
    $player_post_id = 0;


//        echo 'ceva';
//        print_rr($margs);


    if ($margs['play_target'] == 'footer') {
      if (isset($margs['faketarget']) && $margs['faketarget']) {

      } else {
        $margs['faketarget'] = '.dzsap_footer';
      }
    }


    $po = null;


    if (is_int(intval($margs['source']))) {
      $po = get_post($margs['source']);

      if ($po) {
        if ($po->post_type == $this->dbname_mainitems) {


          $margs['post_content'] = $po->post_content;

        }
      }


//		    echo "HIER";
    }


    if ($margs['source'] == '{{postid}}') {
      if ($post) {
        $margs['source'] = $post->ID;
      }
    }
//	    echo 'whaa'; print_rr($margs);


    if ($margs['source']) {
//            echo $margs['source'];
//            echo is_int(intval($margs['source']));

      if ($this->get_track_source($margs['source'], $playerid, $margs) != $margs['source']) {

//                echo '$margs[\'source\'] - ';print_rr($margs['source']); echo '('.is_numeric($margs['source']).')';
        if (is_numeric($margs['source'])) {

          if (isset($margs['playerid']) == false || $margs['playerid'] == '') {

            $margs['playerid'] = $margs['source'];
          }
        }
        $margs['source'] = $this->get_track_source($margs['source'], $playerid, $margs);
      }


    }


//        echo ' margs hier - '; print_rr($margs);


//        print_rr($margs);
    $i = 0;


    $vpsettings = DZSZoomSoundsHelper::getVpSettings($margs['config'], $margs);


    //print_r($vpsettings);

//		echo 'margs - '; print_rr($margs);
//		echo 'vpsettings - '; print_rr($vpsettings);

    if (isset($margs['embedded']) && $margs['embedded'] == 'on') {

      $vpsettings['enable_embed_button'] = 'off';

      // -- todo: multisharer does not load well in iframe .. try to place it in a tooltip maybe ? or iframemax height 100vh
//        $vpsettings['menu_right_enable_multishare'] = 'off';
    }
    if (isset($margs['playerid']) && $margs['playerid']) {

    } else {


      if (is_numeric($margs['source'])) {
        $margs['playerid'] = $margs['source'];
      } else {

//	            $fout.=' data-player-id="'.dzs_clean_string($che['source']).'"';
        $margs['playerid'] = $this->encode_to_number($margs['source']);
      }


      if ($margs['dzsap_meta_source_attachment_id'] && is_numeric($margs['dzsap_meta_source_attachment_id'])) {

//			    echo 'whaaa';
        $margs['playerid'] = dzsap_sanitize_from_shortcode_attr($margs['dzsap_meta_source_attachment_id']);
      }

    }


//	    echo ' margs hier 2 - '; print_rr($margs);
//	    echo ' margs - '; print_rr($margs);


    if ($vpsettings['settings']['skin_ap'] == 'null') {
      $vpsettings['settings']['skin_ap'] = 'skin-wave';
    }
    if ($vpsettings['settings']['skin_ap'] == 'skin-wave') {
      if ($margs['waveformbg'] == '') {
      }
      if ($margs['waveformprog'] == '') {
      }
//            print_r($margs);
    }


    $its = array(0 => $margs, 'settings' => array());

    $its['settings'] = array_merge($its['settings'], $vpsettings['settings']);
    $its['playerConfigSettings'] = $vpsettings['settings'];


    if ($margs['enable_views'] == 'on') {
      $its['settings']['enable_views'] = 'on';
    }


    $margs = array_merge($margs, $vpsettings['settings']);


    // -- lets overwrite some settings that we forced from shortcode args

//    echo 'margs - ' ; print_rr($margs);

    if (isset($pargs['enable_embed_button']) && $pargs['enable_embed_button']) {

      $margs['enable_embed_button'] = $pargs['enable_embed_button'];
    }


//	    echo ' margs hier 2 - '; print_rr($margs);


    if (isset($margs['js_settings_extrahtml_in_float_right_from_config']) && $margs['js_settings_extrahtml_in_float_right_from_config']) {


//            print_rr($its[0]);

//      echo 'enter here';

      // -- we enter here from array_merge with vpsettings

      $margs['js_settings_extrahtml_in_float_right_from_config'] = dszap_sanitize_to_extra_html($margs['js_settings_extrahtml_in_float_right_from_config'], $its[0]);


      $margs['js_settings_extrahtml_in_float_right_from_config'] = str_replace(array("\r", "\r\n", "\n"), '', $margs['js_settings_extrahtml_in_float_right_from_config']);


      // -- we do not need this
//      $margs['js_settings_extrahtml_in_float_right'].=do_shortcode($margs['js_settings_extrahtml_in_float_right_from_config']);
      $margs['extra_html_in_controls_right'] .= do_shortcode($margs['js_settings_extrahtml_in_float_right_from_config']);
    }


    if (isset($margs['settings_extrahtml_after_playpause'])) {

    } else {
      $margs['settings_extrahtml_after_playpause'] = '';
    }
    if (isset($its[0]['settings_extrahtml_after_playpause'])) {

    } else {
      $its[0]['settings_extrahtml_after_playpause'] = '';
    }


    if (isset($margs['settings_extrahtml_after_playpause_from_config']) && $margs['settings_extrahtml_after_playpause_from_config']) {

      $margs['settings_extrahtml_after_playpause_from_config'] = dzsap_sanitize_from_setting($margs['settings_extrahtml_after_playpause_from_config']);


      $margs['settings_extrahtml_after_playpause'] = do_shortcode($margs['settings_extrahtml_after_playpause_from_config']);
      $its[0]['settings_extrahtml_after_playpause'] = do_shortcode($margs['settings_extrahtml_after_playpause_from_config']);
    }


    if (isset($margs['settings_extrahtml_after_con_controls'])) {

    } else {
      $margs['settings_extrahtml_after_con_controls'] = '';
    }
    if (isset($its[0]['settings_extrahtml_after_con_controls'])) {

    } else {
      $its[0]['settings_extrahtml_after_con_controls'] = '';
    }


    if (isset($margs['settings_extrahtml_after_con_controls_from_config']) && $margs['settings_extrahtml_after_con_controls_from_config']) {
      $margs['settings_extrahtml_after_con_controls_from_config'] = str_replace(array("\r", "\r\n", "\n"), '', $margs['settings_extrahtml_after_con_controls_from_config']);

      $margs['settings_extrahtml_after_con_controls'] .= do_shortcode($margs['settings_extrahtml_after_con_controls_from_config']);
      $its[0]['settings_extrahtml_after_con_controls'] .= do_shortcode($margs['settings_extrahtml_after_con_controls_from_config']);

    }

//        print_rr($margs);


    if (isset($margs['cat_feed_data'])) {

      include_once "class_parts/powerpress_cat_feed_data.php";
    }


    if ($post && isset($post->ID)) {

      $margs['js_settings_extrahtml_in_float_right'] = str_replace('{{meta1val}}',
        get_post_meta($post->ID, 'dzsap_meta_extra_meta_label_1', true),
        $margs['js_settings_extrahtml_in_float_right']
      );
      $margs['js_settings_extrahtml_in_float_right'] = str_replace('{{meta2val}}', get_post_meta($post->ID, 'dzsap_meta_extra_meta_label_2', true), $margs['js_settings_extrahtml_in_float_right']);
      $margs['js_settings_extrahtml_in_float_right'] = str_replace('{{meta3val}}', get_post_meta($post->ID, 'dzsap_meta_extra_meta_label_3', true), $margs['js_settings_extrahtml_in_float_right']);
    }


//        print_r($margs); print_r($its); print_r($vpsettings);

//        print_r($margs);


    $has_extra_html = false;

    // -- enable likes in player
    if (isset($margs) && ($margs['enable_views'] == 'on' || $margs['enable_downloads_counter'] == 'on' || $margs['enable_likes'] == 'on' || $margs['enable_rates'] == 'on' || (isset($margs['extra_html']) && $margs['extra_html']))) {
      $has_extra_html = true;
    }


    $margs['extra_html'] = dzsap_sanitize_from_shortcode_attr($margs['extra_html'], $margs);

//        echo 'margs - '; print_rr($margs);


    // -- END sanitize $margs


//	    echo ' margs init shortcode_player() - '; print_rr($margs);


//        $enc_margs = simple_encrypt(json_encode($margs),'1111222233334444');
//        $enc_margs = gzcompress(json_encode($embed_margs),9);
//        $enc_margs = json_encode($embed_margs);


//        echo '$embed_margs -> '; print_rr($embed_margs);
    $enc_margs = base64_encode(json_encode($embed_margs));
//        $enc_margs = base64_decode(base64_encode(json_encode($embed_margs)));

//        $embed_code = '<iframe src=\'' . $this->base_url . 'bridge.php?type=player&margs='.urlencode($enc_margs).'\' style="overflow:hidden; transition: height 0.3s ease-out;" width="100%" height="152" scrolling="no" frameborder="0"></iframe>';


//    echo '$enc_margs -> '; print_rr($enc_margs);

    $embed_code = $this->generate_embed_code(array(
      'call_from' => 'shortcode_player',
      'enc_margs' => $enc_margs,
    ));

//    echo '$embed_code after process -2 '; print_rr($embed_code);

    $margs['embed_code'] = $embed_code;

    $margs['has_extra_html'] = $has_extra_html;
//        echo ' has extra html - '.$has_extra_html;


    if ($margs['openinzoombox'] != 'on') {

//            if(isset($margs['called_from'])==false || $margs['called_from']==''){
//            }
//            $args = array('called_from'=> 'player');
//            $args = array_merge($margs, $args);
//            $fout.='make playir ->';

      if ($margs['itunes_link']) {

        if (isset($its[0]['extra_html']) == false) {
          $its[0]['extra_html'] = '';
        }

        $its[0]['extra_html'] .= '  <a rel="nofollow" href="' . $margs['itunes_link'] . '" target="_blank" class=" btn-zoomsounds btn-itunes "><span class="the-icon"><i class="fa fa-apple"></i></span><span class="the-label ">iTunes</span></a>';
      }

//            print_r($margs);
      $margs['the_content'] = $content;

//            print_rr($margs);

//            if($margs['songname']=='default'){
//                $margs['songname']='';
//            }
//            if($margs['artistname']=='default'){
//                $margs['artistname']='';
//            }
      if ($margs['songname'] && $margs['songname'] != 'default') {

        if (isset($its[0]['menu_songname']) == false || !($its[0]['menu_songname'] && $its[0]['menu_songname'] != 'default')) {

          $its[0]['menu_songname'] = $margs['songname'];
        }
      }
      if ($margs['artistname'] && $margs['artistname'] != 'default') {

        if (isset($its[0]['menu_artistname']) == false || !($its[0]['menu_artistname'] && $its[0]['menu_artistname'] != 'default')) {

          $its[0]['menu_artistname'] = $margs['artistname'];
        }
      }


      $lab = 'title_is_permalink';
      if (isset($margs[$lab]) && $margs[$lab]) {
        $its[0][$lab] = $margs[$lab];
      }
      if (isset($margs['product_id']) && $margs['product_id']) {

        $pid = $margs['product_id'];


//	            echo 'all meta - '.print_rr(get_post_meta($pid),true);
        if (get_post_meta($pid, 'dzsap_meta_replace_artistname', true)) {

          $its[0]['artistname'] = get_post_meta($pid, 'dzsap_meta_replace_artistname', true);
        }
      }


//            echo 'margs 5-  ';print_rr($margs);


//            $its[0] = $this->sanitize_to_gallery_item($its[0]);


//            print_rr($its);

//            echo 'start parse_items from shortcode_player*()';
//            print_rr($margs);

//      error_log('we are getting ready to parse_items');
      $fout .= $this->parse_items($its, $margs);

//      error_log('parse result - '.$this->parse_items($its, $margs));

    }


//        print_rr($margs);

    $player_id = $margs['playerid'];

//	    print_rr($margs);


    // -- normal mode
    if ($margs['init_player'] == 'on') {


      $this->enqueue_main_scripts();

      if ($margs['openinzoombox'] != 'on') {
        if ($margs['divinsteadofscript'] != 'on') {
          $fout .= '<script>';
        } else {
          $fout .= '<div class="toexecute">';
        }


//                print_r($its);

//                echo 'what what in the butt: '.$playerid;

        $str_id = '';
        if ($margs['playerid']) {

          $str_id .= '.ap' . $margs['playerid'];
        }


        $fout .= $this->call_js_init();

        if ($this->mainoptions['js_init_timeout']) {
          $fout .= ' setTimeout(function(){';
        }


        if ($margs['cue'] == 'auto') {
          if (isset($its['settings']['cue_method']) && $its['settings']['cue_method']) {
            $margs['cue'] = $its['settings']['cue_method'];
          } else {
            $margs['cue'] = 'on';
          }
        }


        $fout .= 'var settings_ap' . DZSZoomSoundsHelper::sanitize_for_one_word($player_id) . ' = ';


        $str_post_id = '';

        if ($post) {
          $str_post_id = '_' . $post->ID;
        }

        $fout .= dzsap_generate_audioplayer_settings(array(
          'call_from' => 'shortcode_player',
          'enc_margs' => $enc_margs,
        ), $vpsettings, $its, $margs);

        $fout .= '; ';


        $fout .= 'try{ ';


//        $fout.='console.log(\'%c ap init -> \', "background-color: #00ffff", ".ap_idx'.$str_post_id.'_'.$player_idx.'", jQuery(".ap_idx'.$str_post_id.'_'.$player_idx.'")); ';
        $fout .= 'dzsap_init(".ap_idx' . $str_post_id . '_' . $player_idx . '",settings_ap' . DZSZoomSoundsHelper::sanitize_for_one_word($player_id) . '); }catch(err){ console.warn("cannot init player", err); ';

        $fout .= '}';


        if ($this->mainoptions['js_init_timeout']) {
          $fout .= '}, ' . $this->mainoptions['js_init_timeout'] . ');';
        }

        $fout .= $this->call_js_end();

        // -- end push call


        //console.info("inited", $(".ap_idx'.$str_post_id.'_'.$player_idx.'"));

        if ($margs['divinsteadofscript'] != 'on') {
          $fout .= '</script>';
        } else {
          $fout .= '</div>';
        }
      } else {
        // ------ zoombox open

        wp_enqueue_style('ultibox', $this->base_url . 'libs/ultibox/ultibox.css');
        wp_enqueue_script('ultibox', $this->base_url . 'libs/ultibox/ultibox.js');

        $fout .= ' <a rel="nofollow" href="' . $margs['source'] . '" data-sourceogg="' . $margs['sourceogg'] . '" data-waveformbg="' . $margs['waveformbg'] . '" data-waveformprog="' . $margs['waveformprog'] . '" data-type="' . $margs['type'] . '" data-coverimage="' . $margs['coverimage'] . '" class="zoombox effect-justopacity">' . $content . '</a>';


        if ($margs['divinsteadofscript'] != 'on') {
          $fout .= '<script>';
        } else {
          $fout .= '<div class="toexecute">';
        }
        $fout .= '(function(){
var auxap = jQuery(".audioplayer-tobe").last();
jQuery(document).ready(function ($){
var settings_ap' . DZSZoomSoundsHelper::sanitize_for_one_word($player_id) . ' = ';

        // -- zoombox open
        $fout .= dzsap_generate_audioplayer_settings(array(
          'call_from' => 'zoombox_open',
        ), $vpsettings);

        $fout .= '
};
$(".zoombox").zoomBox({audioplayer_settings: settings_ap' . DZSZoomSoundsHelper::sanitize_for_one_word($player_id) . '});
});
})();';

        if ($margs['divinsteadofscript'] != 'on') {
          $fout .= '</script>';
        } else {
          $fout .= '</div>';
        }


      }
    }


    $extra_buttons_html = '';

    if ($this->mainoptions['analytics_enable'] == 'on') {

      if (current_user_can('manage_options')) {

//		        print_rr($margs);


        if ($margs['called_from'] != 'footer_player') {

          // -- the stats

//          print_rr($margs);

//          $i_fout.='';

          $extra_buttons_html .= '<span class="btn-zoomsounds stats-btn" data-playerid="' . $margs['playerid'] . '"  data-sanitized_source="' . DZSZoomSoundsHelper::sanitize_for_one_word($margs['source']) . '" data-url="' . dzs_curr_url() . '" ><span class="the-icon"><i class="fa fa-tachometer" aria-hidden="true"></i></span><span class="btn-label">' . esc_html__('Stats', 'dzsap') . '</span></span>';


          // -- some portal delete button : todo: complete


        }


        wp_enqueue_script('audioplayer-showcase', $this->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.js');
        wp_enqueue_style('audioplayer-showcase', $this->base_url . 'libs/audioplayer_showcase/audioplayer_showcase.css');
        wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


//			    wp_enqueue_style('dzsap_showcase', $this->base_url . 'front-dzsvp.css');
//			    wp_enqueue_script('dzsap_showcase', $this->base_url . 'front-dzsvp.js');
      }


    }
    if ($margs['called_from'] != 'footer_player') {

      if ($this->current_user_has_track($margs['playerid'])) {

        $extra_buttons_html .= DZSZoomSoundsHelper::generateExtraButtonsForPlayerDeleteEdit($margs['playerid']);

      }
    }

    if ($extra_buttons_html && $margs['called_from'] != 'playlist_showcase') {
//      echo '$this->mainoptions[\'enable_aux_buttons\'] - '. $this->mainoptions['enable_aux_buttons'];
      if ($this->mainoptions['enable_aux_buttons'] == 'on') {
        $fout .= '<div class="extra-btns-con">';
        $fout .= $extra_buttons_html;
        $fout .= '</div>';
      }

    }


//        print_r($its); print_r($margs); echo 'alceva'.$fout;

    $this->enqueue_main_scripts();
    return $fout;
  }

  function generate_embed_code($pargs = array()) {

    $margs = array(
      'extra_classes' => 'search-align-right',
      'call_from' => 'default',
      'enc_margs' => '',
    );

    $embed_code = '';
    if (!is_array($pargs)) {
      $pargs = array();
    }
    $margs = array_merge($margs, $pargs);

//    echo 'margs generate_embed_code -6 '; print_rr($margs);
    $embed_code = '<iframe src=\'' . site_url() . '?action=embed_zoomsounds&type=player&margs=' . urlencode($margs['enc_margs']) . '\' style="overflow:hidden; transition: height 0.3s ease-out;" width="100%" height="152" scrolling="no" frameborder="0"></iframe>';
    $embed_code = str_replace('"', "'", $embed_code);
    $embed_code = htmlentities($embed_code, ENT_QUOTES);

    return $embed_code;

  }


  function current_user_has_track($id, $pargs = array()) {

    $po = get_post($id);

    $margs = array(
      'allow_manage_control' => true,
    );
    if (!is_array($pargs)) {
      $pargs = array();
    }
    $margs = array_merge($margs, $pargs);

    if ($margs['allow_manage_control']) {
      if (current_user_can('manage_options')) {
        return true;
      }
    }

    if ($po) {
      if ($po->post_author == $this->current_user_id) {
        return true;
      }
    }

    return false;
  }

  function get_avatar_url($arg) {
    preg_match("/src='(.*?)'/i", $arg, $matches);
    if (isset($matches[1])) {
      return $matches[1];
    }
    return '';
  }

  function log_event($arg) {
    $fil = dirname(__FILE__) . "/log.txt";
    $fh = @fopen($fil, 'a');
    @fwrite($fh, ($arg . "\n"));
    @fclose($fh);
  }


  function get_post_meta_all($argid) {
    $arr = get_post_meta($argid);

    print_rr($arr);

    return $arr;
  }

  function encode_to_number($string) {
    return substr(sprintf("%u", crc32($string)), 0, 8);
    $ans = array();
    $string = str_split($string);
    #go through every character, changing it to its ASCII value
    for ($i = 0; $i < count($string); $i++) {

      #ord turns a character into its ASCII values
      $ascii = (string)ord($string[$i]);

      #make sure it's 3 characters long
      if (strlen($ascii) < 3)
        $ascii = '0' . $ascii;
      $ans[] = $ascii;
    }

    #turn it into a string
    return implode('', $ans);
  }


  function get_thumbnail($id, $pargs = array()) {

    $margs = array(
      'size' => 'thumbnail',
      'try_to_get_wrapper_image' => 'off',
    );
    if (!is_array($pargs)) {
      $pargs = array();
    }
    $margs = array_merge($margs, $pargs);

    $imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
    //                echo 'ceva'; print_r($imgsrc);


    //            print_r($author_data);


    $thumb = '';

    if ($margs['try_to_get_wrapper_image'] == 'on' && $id && get_post_meta($id, 'dzsap_meta_wrapper_image', true)) {
      $thumb = get_post_meta($id, 'dzsap_meta_wrapper_image', true);

    } else {

      if ($imgsrc) {

        if (is_array($imgsrc)) {
          $thumb = $imgsrc[0];
        } else {
          $thumb = $imgsrc;
        }

      } else {
        if (get_post_meta($id, 'dzsvp_thumb', true)) {
          $thumb = get_post_meta($id, 'dzsvp_thumb', true);
        } else {
          if (get_post_meta($id, 'dzsap_meta_item_thumb', true)) {
            $thumb = get_post_meta($id, 'dzsap_meta_item_thumb', true);
          }
        }
      }
    }

    return $thumb;
  }

  function get_views_for_track($argid) {
    error_log('get_views -analytics_views- (' . $argid . ')' . get_post_meta($argid, '_dzsap_views', true));
    return get_post_meta($argid, '_dzsap_views', true);
  }

  function get_likes_for_track($argid) {

//        echo 'argid - '.$argid.' get_post_meta($argid,\'_dzsap_likes\',true) -  '.get_post_meta($argid,'_dzsap_likes',true).'<br><br>';

    if (get_post_meta($argid, '_dzsap_likes', true)) {
      return get_post_meta($argid, '_dzsap_likes', true);
    } else {
      return 0;
    }
  }

  function transform_to_array_for_parse($argits, $pargs = array()) {
    // -- used in showcase shortcode ( front_shortcode_showcase.php )


    global $post;
    $margs = array(
      'type' => 'video_items',
      'mode' => 'posts',
    );

    if (!is_array($pargs)) {
      $pargs = array();
    }
    $margs = array_merge($margs, $pargs);


    $its = array();


//        print_r($argits);

    foreach ($argits as $it) {


//            print_r($it);


      $aux25 = array();

      $aux25['extra_classes'] = '';


      if ($margs['feed_from'] == 'audio_items') {
        $it_id = $it->ID;
        $aux25['id'] = $it->ID;
        $imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($it_id), "full");
//                echo 'ceva'; print_r($imgsrc);


//            print_r($author_data);


        if ($imgsrc) {

          if (is_array($imgsrc)) {
            $aux25['thumbnail'] = $imgsrc[0];
          } else {
            $aux25['thumbnail'] = $imgsrc;
          }

        } else {
          if (get_post_meta($it_id, 'dzsvp_thumb', true)) {
            $aux25['thumbnail'] = get_post_meta($it_id, 'dzsvp_thumb', true);
          }
        }


        $aux25['type'] = get_post_meta($it_id, 'dzsvp_item_type', true);
        $aux25['date'] = $it->post_date;


//                print_r($margs);

        // -- we need this for view in shortcodes
        $aux25['views'] = $this->get_views_for_track($it_id);
        $aux25['likes'] = $this->get_likes_for_track($it_id);
        if (isset($margs['orderby'])) {

          if ($margs['orderby'] == 'views') {

          }
          if ($margs['orderby'] == 'likes') {


//            if($this->get_likes_for_track($it_id)){
////                            echo 'found likes - '; print_rr($aux25);
//            }
          }
        }


//                $aux = get_post_meta($it_id, 'dzsap_woo_product_track', true);


        $args = array();
        $aux = $this->get_track_source($it_id, $it_id, $args);


        $aux25['source'] = $aux;

//                echo 'aux - '.$aux;


        $thumb = $this->get_post_thumb_src($it_id);

//            echo ' thumb - ';
//            print_r($thumb);


        $thumb_from_meta = get_post_meta($it_id, 'dzsap_meta_item_thumb', true);

        if ($thumb_from_meta) {

          $thumb = $thumb_from_meta;
        }

        if ($thumb) {
//                $its[$lab]->thumbnail = $thumb;
          $aux25['thumbnail'] = $thumb;
        }


        if (isset($it->post_title)) {

          $aux25['title'] = $it->post_title;
        }
        $aux25['id'] = $it_id;


        $aux25['permalink'] = get_permalink($it_id);
        $aux25['permalink_to_post'] = get_permalink($it_id);

//                if ($margs['linking_type'] == 'zoombox') {
//                    $aux25['permalink'] = $aux25['source'];
//                }


//                print_r($margs);


//                print_r($it);


        $maxlen = 50;
        if (isset($margs['desc_count'])) {

          $maxlen = $margs['desc_count'];
        }

//            print_r($margs);

        if ($maxlen == 'default') {

          if ($margs['mode'] == 'scrollmenu') {
            $maxlen = 50;
          }
        }
        if ($maxlen == 'default') {
          $maxlen = 100;
        }


        if (isset($margs['desc_readmore_markup']) && $margs['desc_readmore_markup'] == 'default') {
          if ($margs['mode'] == 'scrollmenu') {
            $margs['desc_readmore_markup'] = ' <span style="opacity:0.75;">[...]</span>';
          }
        }
        if (isset($margs['desc_readmore_markup']) && $margs['desc_readmore_markup'] == 'default') {
          $margs['desc_readmore_markup'] = '';
        }


//                $aux25['description'] = $this->sanitize_description($it->post_content, array('desc_count' => intval($maxlen), 'striptags' => 'on', 'try_to_close_unclosed_tags' => 'on', 'desc_readmore_markup' => $margs['desc_readmore_markup'],));


        if ($post && $post->ID === $it_id) {
          $aux25['extra_classes'] .= ' active';
        }


        if ($it) {

          $user_info = get_userdata($it->post_author);
//          print_rr($post);
//          echo 'user_info -> '; print_rr($user_info);

          // -- artist name

          if (isset($user_info->user_nicename) && $user_info->user_nicename) {
            $aux25['artistname'] = $user_info->user_nicename;
          } else {

            if (isset($user_info->first_name) && $user_info->first_name) {
              $aux25['artistname'] = $user_info->last_name . " " . $user_info->first_name;
            } else {
              if (isset($user_info->user_login) && $user_info->user_login) {
                $aux25['artistname'] = $user_info->user_login;
              }
            }
          }
          $aux25['original_author_name'] = $aux25['artistname'];


          if (get_post_meta($it_id, 'dzsap_meta_replace_artistname', true)) {

            $aux25['artistname'] = get_post_meta($it_id, 'dzsap_meta_replace_artistname', true);
          }

          if (get_post_meta($it_id, 'dzsap_meta_replace_menu_artistname', true)) {

            $aux25['menu_artistname'] = get_post_meta($it_id, 'dzsap_meta_replace_menu_artistname', true);
          }

          if (get_post_meta($it_id, 'dzsap_meta_replace_menu_songname', true)) {

            $aux25['menu_songname'] = get_post_meta($it_id, 'dzsap_meta_replace_menu_songname', true);
          }

          $lab = 'wrapper_image';
          if (get_post_meta($it_id, 'dzsap_meta_' . $lab, true)) {

            $aux25[$lab] = get_post_meta($it_id, 'dzsap_meta_' . $lab, true);
          }


          $aux25['sourceogg'] = '';


          // -- get from post title

//        echo 'aux25 - '; print_rr($aux25);
//          print_rr(get_post_meta($it_id));

          if (isset($post->post_title)) {

            $aux25['songname'] = $post->post_title;
          }

//                echo 'aux25';
//                print_rr($aux25);
          array_push($its, $aux25);
        }
      }


    }


    return $its;

  }


  function shortcode_playlist($atts) {

    //[playlist ids="2,3,4"]

    global $current_user;
    $fout = '';
    $iout = ''; //items parse

    $margs = array(
      'ids' => '1'
    , 'embedded_in_zoombox' => 'off'
    , 'embedded' => 'off'
    , 'db' => 'main'
    );

    if ($atts == '') {
      $atts = array();
    }

    $margs = array_merge($margs, $atts);


//        print_rr($margs);

    $po_array = explode(",", $margs['ids']);

    $fout .= '[zoomsounds id="playlist_gallery" embedded="' . $margs['embedded'] . '" for_embed_ids="' . $margs['ids'] . '"]';


    //===setting up the db
    $currDb = '';
    if (isset($margs['db']) && $margs['db'] != '') {
      $this->currDb = $margs['db'];
      $currDb = $this->currDb;
    }
    $this->dbs = get_option($this->dbname_dbs);

    //echo 'ceva'; print_r($this->dbs);
    if ($currDb != 'main' && $currDb != '') {
      $this->dbname_mainitems .= '-' . $currDb;
      $this->mainitems = get_option($this->dbname_mainitems);
    }
    // -- setting up the db END


    $this->front_scripts();


    $this->sliders_index++;


    $i = 0;
    $k = 0;
    $id = 'playlist_gallery';
    if (isset($margs['id'])) {
      $id = $margs['id'];
    }

    //echo 'ceva' . $id;


    $term_meta = array();
    $its = array(
      'settings' => array(),
    );
    $selected_term_id = '';


    $args = array(
      'id' => $id,
      'called_from' => 'shortcode_playlist',
    );
    $this->get_its_items($its, $args);

    if ($this->mainoptions['playlists_mode'] == 'normal') {
      $tax = $this->taxname_sliders;
      $reference_term = get_term_by('slug', $id, $tax);
      $selected_term_id = $reference_term->term_id;
      $term_meta = get_option("taxonomy_$selected_term_id");
    }


    $this->get_its_settings($its, $margs, $term_meta, $selected_term_id);


//    error_log('its in shortcode_playlist - '.print_r($its,true));

    $enable_likes = 'off';

    $enable_views = 'off';
    $enable_downloads_counter = 'off';

    if ($its) {
      $lab = 'enable_views';
      if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
        $enable_views = $its['settings'][$lab];
      }
      $lab = 'enable_likes';
      if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
        $enable_likes = $its['settings'][$lab];
      }
      $lab = 'enable_downloads_counter';
      if (isset($its['settings'][$lab]) && $its['settings'][$lab]) {
        $enable_downloads_counter = $its['settings'][$lab];
      }
    }


    foreach ($po_array as $po_id) {


      if (is_numeric($po_id)) {

        $po = get_post($po_id);
//            echo 'ceva2'.(get_post_meta($po_id,'_waveformprog',true));

//            print_r(wp_get_attachment_metadata($po_id));


//        echo ' get from post title ';
        $title = $po->post_title;
        $title = str_replace(array('"', '[', ']'), '&quot;', $title);
        $desc = $po->post_content;
        $desc = str_replace(array('"', '[', ']'), '&quot;', $desc);
        $fout .= '[zoomsounds_player source="' . $po->guid . '" config="playlist_player" playerid="' . $po_id . '" thumb="" autoplay="on" cue="on" enable_likes="' . $enable_likes . '" enable_views="' . $enable_views . '"  enable_downloads_counter="' . $enable_downloads_counter . '" songname="' . $title . '" artistname="' . $desc . '" init_player="off"]';
      } else {

        $fout .= '[zoomsounds_player source="' . $po_id . '" config="playlist_player" playerid="' . $po_id . '" thumb="" autoplay="off" cue="on" enable_likes="' . $enable_likes . '" enable_views="' . $enable_views . '"  enable_downloads_counter="' . $enable_downloads_counter . '"  init_player="off"]';
      }

    }
    $fout .= '[/zoomsounds]';


//        echo 'fout - '.$fout;
    $fout = do_shortcode($fout);

//        print_r($margs);

    return $fout;
  }


  function sanitize_to_gallery_item($che) {

    $po_id = $che->ID;


    $che = (array)$che;


    $user_info = get_userdata($che['post_author']);

    if (isset($user_info) && $user_info && isset($user_info->first_name) && $user_info->first_name) {

      $che['artistname'] = $user_info->last_name . " " . $user_info->first_name;
    } else {

      if (isset($user_info->user_login)) {
        $che['artistname'] = $user_info->user_login;
      }
    }


    if (get_post_meta($po_id, 'dzsap_meta_replace_artistname', true)) {

      $che['artistname'] = get_post_meta($po_id, 'dzsap_meta_replace_artistname', true);
    }

    if (get_post_meta($po_id, 'dzsap_meta_replace_menu_artistname', true)) {

      $che['menu_artistname'] = get_post_meta($po_id, 'dzsap_meta_replace_menu_artistname', true);
    }

    if (get_post_meta($po_id, 'dzsap_meta_replace_menu_songname', true)) {

      $che['menu_songname'] = get_post_meta($po_id, 'dzsap_meta_replace_menu_songname', true);
    }


    $che['sourceogg'] = '';
    $che['source'] = get_post_meta($po_id, 'dzsap_meta_item_source', true);

    $che['songname'] = $che['post_title'];
    $che['playfrom'] = '0';
    $che['thumb'] = get_post_meta($po_id, 'dzsap_meta_item_thumb', true);
    $che['type'] = get_post_meta($po_id, 'dzsap_meta_type', true);
    $che['playerid'] = $po_id;


//        echo 'get_post_meta - '; print_rr(get_post_meta($po_id));


    // -- sanitize to gallery item
    foreach ($this->options_item_meta as $oim) {

//        echo 'oim - '; print_rr($oim);

      if (isset($oim['name'])) {
        if ($oim['name'] === 'post_content') {
          continue;
        }


        $long_name = $oim['name'];
        $short_name = str_replace('dzsap_meta_item_', '', $oim['name']);
        $short_name = str_replace('dzsap_meta_', '', $short_name);


        $che[$oim['name']] = get_post_meta($po_id, $oim['name'], true);
        $che[$short_name] = get_post_meta($po_id, $long_name, true);
      } else {
        continue;
      }
    }

//    echo 'che - '; print_rr($che);


    $lab = 'dzsap_meta_source_attachment_id';
    if (get_post_meta($po_id, $lab, true)) {
      $che[$lab] = get_post_meta($po_id, $lab, true);
    }


    return $che;
  }

  function get_its_items(&$its, $margs) {
    // -- from @margs we need id

//    if(isset($margs['called_from']) && $margs['called_from']=='shortcode_playlist'){
//    error_log('get_its_items - '.print_r($margs,true));
//    }
//    error_log('get_its_items - '.print_r($margs,true));
//    print_rr($this->mainoptions);
    if ($this->mainoptions['playlists_mode'] == 'normal') {

      // -- try to get from reference term
      $tax = $this->taxname_sliders;


      $reference_term = get_term_by('slug', $margs['id'], $tax);

//      if(isset($margs['called_from']) && $margs['called_from']=='shortcode_playlist'){
//        error_log('$reference_term - '.print_r($reference_term,true));
//      }

      if ($reference_term) {

//        error_log('(get_its_items) we found - '.print_r($reference_term,true));

      } else {
        // -- reference term does not exist..

        $directores = get_terms('dzsap_sliders');
//        print_rr($directores);

        $args = $margs;
        $args['id'] = $directores[0]->slug;
//        error_log('(get_its_items) we did not found ... found .. we are selecting - '.print_r($directores[0]));
        if ($margs['called_from'] != 'redo') {
          $args['called_from'] = 'redo';
          return dzsap_shortcode_playlist_main($args);
        }
        return '';
      }

      $selected_term_id = $reference_term->term_id;

      $term_meta = get_option("taxonomy_$selected_term_id");


//    print_rr($reference_term);


      // -- main order
      if ($selected_term_id) {

        $args = array(
          'post_type' => 'dzsap_items',
          'numberposts' => -1,
          'posts_per_page' => -1,
          //                'meta_key' => 'dzsap_meta_order_'.$selected_term,

          'orderby' => 'meta_value_num',
          'order' => 'ASC',

          'tax_query' => array(
            array(
              'taxonomy' => $tax,
              'field' => 'id',
              'terms' => $selected_term_id // Where term_id of Term 1 is "1".
            )
          ),
        );


//		        print_rr($term_meta);


        if (isset($term_meta['orderby'])) {
          if ($term_meta['orderby'] == 'rand') {
            $args['orderby'] = $term_meta['orderby'];
          }
          if ($term_meta['orderby'] == 'custom') {
            $args['meta_query'] = array(
              'relation' => 'OR',
              array(
                'key' => 'dzsap_meta_order_' . $selected_term_id,
                //                        'value' => '',
                'compare' => 'EXISTS',
              ),
              array(
                'key' => 'dzsap_meta_order_' . $selected_term_id,
                //                        'value' => '',
                'compare' => 'NOT EXISTS'
              )
            );
          }
          if ($term_meta['orderby'] == 'ratings_score') {
            $args['orderby'] = 'meta_value_num';

            $key = '_dzsap_rate_index';
            $args['meta_query'] = array(
              'relation' => 'OR',
              array(
                'key' => $key,
                'compare' => 'EXISTS',
              ),
              array(
                'key' => $key,
                'compare' => 'NOT EXISTS'
              )
            );
            $args['meta_type'] = 'NUMERIC';
            $args['order'] = 'DESC';

          }
          if ($term_meta['orderby'] == 'ratings_number') {
            $args['orderby'] = 'meta_value_num';

            $key = '_dzsap_rate_nr';
            $args['meta_query'] = array(
              'relation' => 'OR',
              array(
                'key' => $key,
                'compare' => 'EXISTS',
              ),
              array(
                'key' => $key,
                'compare' => 'NOT EXISTS'
              )
            );
            $args['meta_type'] = 'NUMERIC';
            $args['order'] = 'DESC';

//                        echo 'cev';

//                        print_rr($args);
          }
        }
        $my_query = new WP_Query($args);

//            print_r($my_query);


//            print_r($my_query->posts);

        foreach ($my_query->posts as $po) {

//                print_r($po);


          $por = $this->sanitize_to_gallery_item($po);

          array_push($its, $por);

//			        print_rr($po);
        }
      }
    } else {
      // -- legacy mode

      if (isset($margs['id'])) {
        $id = $margs['id'];
      }

      //echo 'ceva' . $id;
      for ($i = 0; $i < count($this->mainitems); $i++) {

        if (isset($this->mainitems[$i]) && isset($this->mainitems[$i]['settings'])) {

          if ((isset($id)) && ($id == $this->mainitems[$i]['settings']['id'])) {
            $k = $i;
          }
        }
      }
      $its = $this->mainitems[$k];
    }


  }


  function get_its_settings(&$its, $margs, $term_meta, $selected_term_id) {

    $its_settings_default = array(
      'galleryskin' => 'skin-wave',
      'vpconfig' => 'default',
      'bgcolor' => 'transparent',
      'width' => '',
      'height' => '',
      'autoplay' => '',
      'autoplaynext' => 'on',
      'autoplay_next' => '',
      'menuposition' => 'bottom',
    );
    if ($this->mainoptions['playlists_mode'] == 'normal') {
      $its_settings_default['id'] = $selected_term_id;
    }

    if (isset($its['settings']) == false) {
      $its['settings'] = array();
    }

    $its['settings'] = array_merge($its_settings_default, $its['settings']);


    if ($this->mainoptions['playlists_mode'] == 'normal') {
//		    print_rr($term_meta);
      if (is_array($term_meta)) {

        foreach ($term_meta as $lab => $val) {
          if ($lab == 'autoplay_next') {

            $lab = 'autoplaynext';
          }
          $its['settings'][$lab] = $val;

        }
      }
    }
  }


  function is_bot() {

//        return true;
    return (
    (isset($_SERVER['HTTP_USER_AGENT'])
      && preg_match('/bot|crawl|slurp|spider|metrix|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
    )
    );
  }


  function sanitize_from_meta_textarea($arg) {

    $arg = stripslashes($arg);
    $arg = str_replace('{{quots}}', '\'', $arg);

    return $arg;

  }


  function parse_items($its, $pargs = array()) {
    // -- returns only the html5 gallery items

    global $post;

    $fout = '';
    $start_nr = 0; // -- the i start nr
    $end_nr = 0; // --  the i start nr
    $nr_per_page = 5;

    $margs = array(
      'menu_facebook_share' => 'auto',
      'menu_like_button' => 'auto',
      'gallery_skin' => 'skin-wave',
      'called_from' => 'skin-wave',
      'skinwave_mode' => 'normal',
      'single' => 'off',
      'wrapper_image' => '',
      'extraattr' => '',
      'extra_classes' => '',
      'wrapper_image_type' => '', // zoomsounds-wrapper-bg-bellow or zoomsounds-wrapper-bg-center ( set in item options )
    );

    $margs = array_merge($margs, $pargs);

//    error_log('parse_items margs - '.print_r($margs,true));

//        echo 'parse_items margs -'; print_rr($margs);
//        echo 'parse_items $its -'; print_rr($its);


//        echo 'start its - '; print_rr($its);


    // -- sanitizing
    if ($margs['wrapper_image'] == '') {
      if (isset($margs['cover']) && $margs['cover']) {
        $margs['wrapper_image'] = $margs['cover'];
      } else {
        $margs['wrapper_image_type'] = '';
      }
    }

    // -- count
    foreach ($its as $key => $val) {
      if (is_numeric($key)) {
        $end_nr++;
      }
    }

//	    echo 'margs init - '; print_rr($margs);
    if (isset($its['settings'])) {

      if (isset($its['settings']['enable_views']) == false) {
        $its['settings']['enable_views'] = 'off';
      }
      if (isset($its['settings']['enable_likes']) == false) {
        $its['settings']['enable_likes'] = 'off';
      }
      if (isset($its['settings']['enable_rates']) == false) {
        $its['settings']['enable_rates'] = 'off';
      }
      if (isset($its['settings']['enable_downloads_counter']) == false) {
        $its['settings']['enable_downloads_counter'] = 'off';
      }


      if (isset($margs['enable_views']) && $margs['enable_views'] === 'on') {
        $its['settings']['enable_views'] = 'on';
      }
      if (isset($margs['enable_downloads_counter']) && $margs['enable_downloads_counter'] === 'on') {
        $its['settings']['enable_downloads_counter'] = 'on';
      }

      if (isset($margs['enable_likes']) && $margs['enable_likes'] === 'on') {
        $its['settings']['enable_likes'] = 'on';
      }
      if (isset($margs['enable_rates']) && $margs['enable_rates'] === 'on') {
        $its['settings']['enable_rates'] = 'on';
      }
      if ($margs['single'] == 'on' && isset($its['settings']['id']) && $its['settings']['id']) {
        $its['settings']['vpconfig'] = $its['settings']['id'];
      }


      if (isset($its['settings']['enable_alternate_layout']) && $its['settings']['enable_alternate_layout'] === 'on') {
        $margs['enable_alternate_layout'] = 'on';
        $margs['skinwave_mode'] = 'alternate';
      }
    }


//        echo 'parsed string: ';
//            echo 'its - '; print_rr($its);
//            print_rr($margs);


//        echo '$start_nr - '.$start_nr;
//        echo '$end_nr - '.$end_nr;


    if ($margs['called_from'] == 'gallery') {
//      error_log('$start_nr here - '.$start_nr.'$end_nr - '.$end_nr);
//      error_log('$i_fout here - '.$i_fout);
    }


    for ($i = $start_nr; $i < $end_nr; $i++) {


      $i_fout = '';
      $che = array(
        'menu_artistname' => 'default',
        'menu_songname' => 'default',
        'menu_extrahtml' => '',
        'extra_html' => '',
        'called_from' => '',
        'songname' => '',
        'artistname' => '',
        'show_tags' => 'off',
        'playerid' => '', // -- playerid for database
      );

      $playerid = '';
      $playerid_is_fake = false; // -- if we assign a random number here , then it is fake

//      print_rr(print_r($its,true). '$i  - ('.$i.')');
      if (is_array($its[$i]) == false) {
        $its[$i] = array();
      }

      $che = array_merge($che, $its[$i]);


      if (isset($che['ID']) && $che['playerid'] == false && is_numeric($che['ID'])) {
        $che['playerid'] = $che['ID'];
      }


      if (isset($che['playerid']) && $che['playerid'] != '') {
        $playerid = $che['playerid'];
      }


      if ($playerid) {

      } else {

        $playerid = $this->encode_to_number($che['source']);
        $playerid_is_fake = true;
      }


//      echo 'che 1 ';   print_rr($che);
      $che = DZSZoomSoundsHelper::sanitize_item_for_parse_items($i, $che, $its);


//      echo 'che 2 ';   print_rr($che);

      if ($che['show_tags'] == 'on') {


        $taxonomy = 'dzsap_tags';


//		            echo '$playerid - '.$playerid;
        $term_list = wp_get_post_terms($playerid, $taxonomy, array("fields" => "all"));


        if (is_array($term_list) && count($term_list) > 0) {


          // -- todo: outside player, do we need it inside ?
          $i_fout .= '<div class="tag-list">';

          $cach_tag = $term_list[0];
          $i_fout .= ' <a rel="nofollow" class="dzsap-tag" href="';


          $i_fout .= add_query_arg(array(
            'query_song_tag' => $cach_tag->slug
          ), dzs_curr_url());

          $i_fout .= '">';
          $i_fout .= $cach_tag->name;
          $i_fout .= '</a>';
          if (count($term_list) > 1) {


            $i_fout .= '<span class="dzstooltip-con" style=""><span class="dzstooltip arrow-from-end transition-slidein arrow-top align-right skin-black" style="width: auto;white-space:nowrap;">';

            foreach ($term_list as $lab => $term) {


              if ($lab) {


                $cach_tag = $term;
                $i_fout .= ' <a rel="nofollow" class="dzsap-tag" href="';


                $i_fout .= add_query_arg(array(
                  'query_song_tag' => $cach_tag->slug
                ), dzs_curr_url());

                $i_fout .= '">';
                $i_fout .= $cach_tag->name;

                $i_fout .= '</a>';

              }

            }
            $i_fout .= '</span>';

            $i_fout .= '<span class="the-label">...</span>';
          }

          $i_fout .= '</div>';

        }

      }

//            echo 'che init - '; print_rr($che);


      $meta = array();


      $type = 'audio';

      if (isset($che['type']) && $che['type'] != '') {
        $type = $che['type'];
      }

      if ($type == 'inline') {
        $i_fout .= $che['source'];
        continue;
      }


      if ($che['source'] == '' || $che['source'] == ' ') {
        continue;
      }
//            print_r($che); echo $playerid;


      if (isset($_GET['fromsharer']) && $_GET['fromsharer'] == 'on') {
        if (isset($_GET['audiogallery_startitem_ag1']) && $_GET['audiogallery_startitem_ag1']) {


          if ($i == $_GET['audiogallery_startitem_ag1']) {
//            print_rr($che);

            $this->og_data = array(
              'title' => $che['menu_songname'],
              'image' => $che['thumb'],
              'description' => __("by") . ' ' . $che['menu_artistname'],
            );
          }
        }
      }

      if (strpos($che['source'], 'soundcloud.com') !== false) {
        if (isset($che['soundcloud_track_id']) && isset($che['soundcloud_secret_token']) && $che['soundcloud_track_id'] && $che['soundcloud_secret_token']) {


//                print_r($auxa);

          $che['source'] = DZSZoomSoundsHelper::get_soundcloud_track_source($che);
//                    $che['type']='audio';

          if ($type == 'soundcloud') {
            $type = 'audio';
          }
        }
      }


      $the_player_id = '';

      if ($playerid) {

        $the_player_id = 'ap' . $playerid . '';
      }


//            print_rr($margs);
//            print_rr($che);
      if (isset($margs['player_id']) && $margs['player_id']) {

      } else {

        if (isset($margs['playerid']) && $margs['playerid']) {
          $margs['player_id'] = $margs['playerid'];
        }
      }

      if (isset($margs['player_id']) && $margs['player_id']) {
//                print_r($margs);
        $the_player_id = $margs['player_id'];
      } else {

        if (isset($margs['player_id']) && $margs['player_id']) {
//                print_r($margs);
          $the_player_id = $margs['player_id'];
        }
      }


//            echo '$its - '.print_rr($its,true);
//            echo '$che - '.print_rr($che,true);
//            echo 'hmm - '; print_rr($margs);  print_rr($its);

//            echo ' chec before extra_html do_shortcode '; print_rr($che);


      if (isset($its['playerConfigSettings'])) {
        $che['extra_html'] = DZSZoomSoundsHelper::parseItemDetermineExtraHtml($che['extra_html'], $its['playerConfigSettings']);
      }

      $che['extra_html'] = do_shortcode(dzsap_sanitize_from_extra_html_props($che['extra_html'], '', $che));


//            print_rr($che);


      if ($the_player_id) {
        if (isset($che['itunes_link']) && $che['itunes_link']) {

        } else {
          if ($che['playerid']) {
            if (get_post_meta($che['playerid'], 'dzsap_meta_itunes_link', true)) {
              $che['itunes_link'] = get_post_meta($che['playerid'], 'dzsap_meta_itunes_link', true);

            }

          }
        }
      }


      if ((isset($che['extrahtml_in_bottom_controls_from_player']) && $che['extrahtml_in_bottom_controls_from_player'])) {

        $che['extra_html'] .= wp_kses(do_shortcode(dzsap_sanitize_from_shortcode_attr($che['extrahtml_in_bottom_controls_from_player']), $che), $this->allowed_tags);
      } else {
        if ((isset($che['extra_html_in_bottom_controls']) && $che['extra_html_in_bottom_controls'])) {

          $che['extra_html'] .= do_shortcode($che['extra_html_in_bottom_controls']);

        }
      }


//            echo 'che[source] - > '.$che['source'].' ... ';

//            echo '$che - '; print_rr($che);


      // -- end ID was determined


//      echo 'che - '; print_rr($che);

//      if($margs['called_from']=='gallery'){ error_log('$fout here - '.$i_fout); };


//      if($margs['called_from']=='gallery'){ error_log('$che here - '.print_r($che,true)); };
      // -- we are going to now show non public tracks
      if ($this->mainoptions['show_only_published'] == 'on') {

        if (isset($che['ID']) && $che['ID']) {


//        echo ' get_post_status ( $ID )  - '; echo get_post_status ( $che['ID'] ) ;

          if (($che['post_type'] != 'dzsap_items') && get_post_status($che['ID']) !== 'publish') {
            continue;
          }
        }
      }


//      if($margs['called_from']=='gallery'){ error_log('$che here - '.print_r($che,true)); };
//            echo '$its - '; print_rr($its);
//            echo '$che - '; print_rr($che);


//	        print_rr($this->mainoptions);
//	        echo 'che -6'; print_rr($che);


//            print_rr($che);


      // -- player

      $fout .= '<style class="player-custom-style">';
      $selector = 'body .audioplayer.playerid-' . $margs['playerid'] . ':not(.a)';
      $colorHighlight = '';

      if(isset($its['playerConfigSettings']['colorhighlight'])){
        $colorHighlight = $its['playerConfigSettings']['colorhighlight'];
      }
      $fout .= $this->generate_extra_css_player(array(
        'skin_ap' => $its['playerConfigSettings']['skin_ap'],
        'selector' => $selector,
        'colorhighlight' => $colorHighlight,
      ));
      $fout .= '</style>';

      $str_tw = '';


      if (isset($margs['single']) && $margs['single'] == 'on') {
        if (isset($margs['width']) && isset($margs['height'])) {

          // -- some sanitizing
          $tw = $margs['width'];
          $th = $margs['height'];

          if ($tw != '') {
            if (strpos($tw, "%") === false && $tw != 'auto') {
              $str_tw = ' width: ' . $tw . 'px;';
            } else {
              $str_tw = ' width: ' . $tw . ';';
            }
          }

//                    print_r($margs); echo $str_tw; echo $str_th;


        }
      }


      $thumb_link_attr = '';
      $fakeplayer_attr = '';
      $thumb_for_parent_attr = '';

      $pcm = '';

      // -- we get data-pmc here
      if ($this->mainoptions['skinwave_wave_mode'] == 'canvas') {
//        print_rr($che);
        $pcm = $this->generate_pcm($che);
      }


      // -- parse the item
      $i_fout .= '<div class="audioplayer-tobe';


      $str_post_id = '';

      if ($post) {
        $str_post_id = '_' . $post->ID;
      }


      $i_fout .= ' playerid-' . $margs['playerid'];


      if (isset($its[$i]['player_index']) && $its[$i]['player_index']) {
        $i_fout .= ' ap_idx' . $str_post_id . '_' . $its[$i]['player_index'];
      }

      if (isset($margs['single']) && $margs['single'] == 'on') {
        $i_fout .= ' is-single-player';
      }

//            print_r($che);
//            print_r($its);

//            print_r($its['settings']);
//            print_r($margs);

      if ($its && $its['settings'] && isset($its['settings']['vpconfig']) && $its['settings']['vpconfig']) {
        $aux = str_replace(' ', '-', $its['settings']['vpconfig']);
        $i_fout .= ' apconfig-' . $aux;


//                print_r($margs);
//                print_r($its);


        if (isset($margs['skin_ap']) && $margs['skin_ap']) {


          if ($margs['called_from'] == 'gallery') {

            $i_fout .= ' ' . $margs['skin_ap'];
          }


        }

//                print_r($its['settings']);

        if (isset($its['settings']['button_aspect']) && $its['settings']['button_aspect'] != 'default') {
          $i_fout .= ' ' . $its['settings']['button_aspect'];

          if (isset($its['settings']['colorhighlight']) && $its['settings']['colorhighlight']) {
            // TODO: maybe force aspect noir filled ? if aspect noir is set


          }
        }
      }


      if (isset($che['wrapper_image_type']) && $che['wrapper_image_type']) {

        $i_fout .= ' ' . $che['wrapper_image_type'];
      }
      if (isset($margs['extra_classes_player'])) {
        $i_fout .= ' ' . $margs['extra_classes_player'];
      }

      if ($margs['called_from'] == 'footer_player' || $margs['called_from'] == 'player' || $margs['called_from'] == 'gallery') {

//                print_r($its);
//                print_r($margs);
        $i_fout .= ' ' . $margs['skin_ap'];
      }


      if (isset($margs['enable_alternate_layout']) && $margs['skinwave_mode'] == 'normal' && $margs['enable_alternate_layout'] == 'on') {
        $i_fout .= ' alternate-layout';
      }

      if (isset($its['settings']['extra_classes_player'])) {
        $i_fout .= ' ' . $its['settings']['extra_classes_player'];
      }
      if (isset($its['settings']['skinwave_mode'])) {

        if ($margs['skinwave_mode'] == 'alternate') {
          $i_fout .= ' alternate-layout';
        }
        if ($margs['skinwave_mode'] == 'nocontrols') {
          $i_fout .= ' skin-wave-mode-nocontrols';
        }
      }

      $i_fout .= ' ' . $the_player_id;

//            print_rr($che);

//            print_rr($its);

      if (isset($its['settings']) && isset($its['settings']['disable_volume']) && $its['settings']['disable_volume'] == 'on') {
        $i_fout .= ' disable-volume';
      }

      if (isset($che['extra_classes']) && $che['extra_classes']) {
        $i_fout .= ' ' . $che['extra_classes'];
      }
      if (isset($che['embedded']) && $che['embedded'] == 'on') {
        $i_fout .= ' ' . ' is-in-embed-player';
      }


      $i_fout .= '" ';
      // -- end class


      $i_fout .= ' style="';
      if ($margs['called_from'] == 'player') {
        $i_fout .= ' opacity: 0; ';
      }
      $i_fout .= '' . $str_tw . '';
      $i_fout .= '"';


      $the_player_id = str_replace('ap', '', $the_player_id);
//	        echo 'get_post_meta($the_player_id ( '.$the_player_id.' ),\'dzsap_total_time\',true) from parse_items - '.get_post_meta($the_player_id,'dzsap_total_time',true).' -> '.intval(get_post_meta($the_player_id,'dzsap_total_time',true));

//            print_rr($margs);


      $post_type = '';

      if ($che['playerid']) {

        $po = get_post($che['playerid']);

        if ($po) {
          if ($po->post_type) {
            $post_type = $po->post_type;
          }
        }

        if ($post_type) {

          $i_fout .= ' data-posttype="' . $post_type . '"';

          $che['post_type'] = $post_type;
        }
      }

      if (isset($che['product_id']) && $che['product_id']) {

        $i_fout .= ' data-product_id="' . $che['product_id'] . '"';
      }

      if (isset($che['type_normal_stream_type']) && $che['type_normal_stream_type']) {

        $i_fout .= ' data-streamtype="' . dzsap_sanitize_from_shortcode_attr($che['type_normal_stream_type']) . '"';
      }
//      print_rr($che);


      // -- try to set from cache total time
      if ($this->mainoptions['try_to_cache_total_time'] == 'on' && isset($margs['source']) && $margs['source'] != 'fake' && get_post_meta($the_player_id, 'dzsap_total_time', true)) {
//	            echo 'whaaa ';
        $i_fout .= ' data-sample_time_total="' . intval(get_post_meta($the_player_id, 'dzsap_total_time', true)) . '"';
      }


      if ($this->check_if_user_played_track($playerid) === true) {
        $i_fout .= ' data-viewsubmitted="on"';
      }

//            echo '$the_player_id - '.$the_player_id;

      if ($the_player_id != '') {
        $the_player_id_sanitized_to_number = str_replace('ap', '', $the_player_id);


        if ($margs['called_from'] == 'footer_player') {

          $i_fout .= ' id="dzsap_footer"';
        } else {
          $i_fout .= ' id="ap' . $the_player_id_sanitized_to_number . '"';
        }

        $i_fout .= ' data-playerid="' . $the_player_id_sanitized_to_number . '"';
      };

      $i_fout .= ' data-sanitized_source="' . DZSZoomSoundsHelper::sanitize_for_one_word($che['source']) . '"';


      $i_fout .= $margs['extraattr'];


//	        echo '$this->mainoptions[\'try_to_get_id3_thumb_in_frontend\'] - '.$this->mainoptions['try_to_get_id3_thumb_in_frontend'];


      if (isset($che['dzsap_meta_source_attachment_id']) && $che['dzsap_meta_source_attachment_id']) {

      } else {
        // -- try to get dzsap_meta_source_attachment_id if it's a dzsap_item
        if ($che['playerid']) {


          if (get_post_meta($che['playerid'], 'dzsap_meta_source_attachment_id', true)) {
            $che['dzsap_meta_source_attachment_id'] = get_post_meta($che['playerid'], 'dzsap_meta_source_attachment_id', true);
          }


        }
      }


      if ($this->mainoptions['try_to_get_id3_thumb_in_frontend'] == 'on') {


        if (isset($che['dzsap_meta_source_attachment_id']) && $che['dzsap_meta_source_attachment_id']) {

          if (!(isset($che['thumb']) && $che['thumb'])) {

            // -- get base64 data in frontend


            //                echo '$attachment_id - '; print_rr($attachment_id);


            $file = get_attached_file($che['dzsap_meta_source_attachment_id']);

            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $metadata = wp_read_audio_metadata($file);

            //	                echo 'metadata -> '; print_rr($metadata);

            if ($metadata && isset($metadata['image']) && isset($metadata['image']['data'])) {


              //	                    echo 'lala';
              $che['thumb'] = 'data:image/jpeg;base64,' . base64_encode($metadata['image']['data']);
            }

          }


          if (!(isset($che['artistname']) && $che['artistname'])) {


            $file = get_attached_file($che['dzsap_meta_source_attachment_id']);

            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $metadata = wp_read_audio_metadata($file);


          }

        }
      }


      if ($che['thumb'] && $che['thumb'] != 'default') {

        $che['thumb'] = $this->sanitize_id_to_src($che['thumb']);
      } else {
        if (isset($che['post_type']) && $che['post_type']) {
          $che['thumb'] = $this->get_thumbnail($che['playerid']);
        }
      }


      if (isset($che['thumb']) && $che['thumb'] == 'none') {
        $che['thumb'] = '';
      }
      if (isset($che['thumb']) && $che['thumb']) {
        $i_fout .= ' data-thumb="' . $che['thumb'] . '"';
      };
      if (isset($che['thumb_for_parent']) && $che['thumb_for_parent']) {

        $thumb_for_parent_attr .= ' data-thumb_for_parent="' . $che['thumb_for_parent'] . '"';
      };
      $i_fout .= $thumb_for_parent_attr;

      if (isset($che['thumb_link']) && $che['thumb_link']) {
        $thumb_link_attr .= ' data-thumb_link="' . $che['thumb_link'] . '"';
      };

      $i_fout .= $thumb_link_attr;
      if (isset($che['wrapper_image']) && $che['wrapper_image']) {
        $i_fout .= ' data-wrapper-image="' . $this->sanitize_id_to_src($che['wrapper_image']) . '" ';
      }

      if (isset($che['publisher']) && $che['publisher']) {
        $i_fout .= ' data-publisher="' . $che['publisher'] . '"';
      };


      if (isset($che['sample_time_start']) && $che['sample_time_start']) {
        if ($this->mainoptions['sample_time_pseudo'] == 'pseudo') {
          $i_fout .= ' data-pseudo-sample_time_start="' . $che['sample_time_start'] . '"';
        } else {

          // -- not pseudo
          $i_fout .= ' data-sample_time_start="' . $che['sample_time_start'] . '"';
        }
      }

      if (isset($che['sample_time_end']) && $che['sample_time_end']) {
        if ($this->mainoptions['sample_time_pseudo'] == 'pseudo') {
          $i_fout .= ' data-pseudo-sample_time_end="' . $che['sample_time_end'] . '"';
        } else {

          // -- not pseudo
          $i_fout .= ' data-sample_time_end="' . $che['sample_time_end'] . '"';
        }
      }

      if ($this->mainoptions['try_to_cache_total_time'] == 'on' && isset($che['sample_time_total']) && $che['sample_time_total']) {
        $i_fout .= ' data-sample_time_total="' . $che['sample_time_total'] . '"';
      }


      if ($margs['called_from'] == 'gallery') {

//                print_r($che);
      }


      if (isset($che['play_in_footer_player']) && ($che['play_in_footer_player'] == 'default' || $che['play_in_footer_player'] === '')) {
        $che['play_in_footer_player'] = 'off';

      }
      // -- [ gallery ] override player preference
      if (isset($its['settings']['gallery_play_in_footer_player']) && $its['settings']['gallery_play_in_footer_player'] == 'on') {
        $che['play_in_footer_player'] = $its['settings']['gallery_play_in_footer_player'];
      }

//      echo '  margs , $che , $its'; print_rr($margs); print_rr($che); print_rr($its);

      if (isset($che['play_in_footer_player']) && $che['play_in_footer_player'] == 'on') {

        $fakeplayer_attr = ' data-fakeplayer=".dzsap_footer"';
      };


      if ($this->mainoptions['skinwave_wave_mode'] == 'canvas') {
//                print_r($che);


        $i_fout .= $pcm;
      } else {
        if (isset($che['waveformbg']) && $che['waveformbg'] != '') {
          $i_fout .= ' data-scrubbg="' . $che['waveformbg'] . '"';
        };
        if (isset($che['waveformprog']) && $che['waveformprog'] != '') {
          $i_fout .= ' data-scrubprog="' . $che['waveformprog'] . '"';
        };
      }

      if ($type != '') {

        if ($type == 'detect') {
          if ($che['source']) {

            if ($che['source'] != sanitize_youtube_url_to_id($che['source'])) {
              $type = 'youtube';
              $che['source'] = sanitize_youtube_url_to_id($che['source']);
            }
          }
        }
        $i_fout .= ' data-type="' . $type . '"';
      };


      if (($this->mainoptions['developer_check_for_bots_and_dont_reveal_source'] == 'on' && $this->is_bot() == false) || $this->mainoptions['developer_check_for_bots_and_dont_reveal_source'] != 'on') {

        if (isset($che['source']) && $che['source'] != '') {
          $i_fout .= ' data-source="' . dzsap_sanitize_from_shortcode_attr($che['source']) . '"';
        };
        if (isset($che['sourceogg']) && $che['sourceogg'] != '') {
          $i_fout .= ' data-sourceogg="' . $che['sourceogg'] . '"';
        };
      }

      if (isset($che['bgimage']) && $che['bgimage'] != '') {
        $i_fout .= ' data-bgimage="' . $che['bgimage'] . '"';
        $i_fout .= ' data-wrapper-image="' . $che['bgimage'] . '"';
      };


//            print_r($che);
      if ($che['playfrom']) {
        $i_fout .= ' data-playfrom="' . $che['playfrom'] . '"';
      };

//                    print_r($margs);;
      if (isset($margs['faketarget']) && $margs['faketarget']) {
        $fakeplayer_attr = ' data-fakeplayer="' . $margs['faketarget'] . '"';
      }

      $i_fout .= $fakeplayer_attr;

      $i_fout .= '>';


      if (isset($che['replace_songname']) && $che['replace_songname']) {

        $che['songname'] = $che['replace_songname'];
      }


      if ($che['songname'] == 'default' || $che['songname'] == '{{id3}}') {
        // -- lets see id3 tag

//		        echo 'ABSPATH - '.ABSPATH.'|||';
//		        echo 'get_home_url - '.get_home_url();

        $home_url = get_home_url();


        if (strpos($che['source'], $home_url) !== false) {
          $mp3path = str_replace($home_url, ABSPATH, $che['source']);

//			        echo '$mp3path - '.$mp3path;
//			        echo 'function_exists(\'id3_get_tag\') - '.function_exists('id3_get_tag');

          if (function_exists('id3_get_tag')) {

            $tag = id3_get_tag($mp3path);

          } else {


            if (dzsap_get_songname_from_attachment($che)) {
              $che['songname'] = dzsap_get_songname_from_attachment($che);
            }


//
//				        print_rr($metadata);
          }
        } else {


          // -- outer domain source;
          if (dzsap_get_songname_from_attachment($che)) {
            $che['songname'] = dzsap_get_songname_from_attachment($che);
          }

        }
      }

//	        echo ' che after id3 analyze'; print_rr($che);

      if ($che['songname'] == 'default') {
        $che['songname'] = '';
      }


      if ($che['artistname'] == 'none') {
        $che['artistname'] = '';
      }


      if ($che['songname'] == 'none') {
        $che['songname'] = '';
      }


      if ($che['artistname'] == 'default') {
        $che['artistname'] = '';
      }

//            print_rr($che);
      if ($che['songname'] == 'default' || $che['songname'] == '{{id3}}') {
        $che['songname'] = '';
      }


//            print_r($che);


//            print_rr($che);

      if (isset($che['player_id']) && $che['player_id'] == 'dzsap_footer') {
        $che['menu_artistname'] = ' ';
        $che['menu_songname'] = ' ';
      }

      $meta_artist_html = '';


      $has_artist_name = false;
//            print_rr($che);
      if ((isset($che['artistname']) && $che['artistname']) || (isset($che['songname']) && $che['songname']) || $margs['called_from'] == 'footer_player') {
        $meta_artist_html .= '<div class="meta-artist track-meta-for-dzsap">';
        $meta_artist_html .= '<span class="the-artist first-line">';


        if ($che['artistname']) {
          $has_artist_name = true;


          $meta_artist_html .= '<span class="first-line-label">' . $che['artistname'] . '</span>';
        }


        if (isset($margs['settings_extrahtml_after_artist'])) {
          $meta_artist_html .= wp_kses(do_shortcode($margs['settings_extrahtml_after_artist']), $this->allowed_tags);
        }

//                print_rr($margs);

        $meta_artist_html .= '</span>';
        if ($che['songname'] != '' || $che['called_from'] == 'footer_player') {

          if ($has_artist_name) {
            // todo: why ? aw .. for a space.. but could be adjusted manually
//            $meta_artist_html.='&nbsp;';
          }

          $meta_artist_html .= '<span class="the-name the-songname second-line">' . $che['songname'] . '</span>';
        }

        $meta_artist_html .= '</div>';
      }


//      echo 'che 5 ';   print_rr($che);


      if ($che['artistname']) {

        $i_fout .= '<div class="feed-dzsap feed-artist-name">' . $che['artistname'] . '</div>';
      }
      if ($che['songname']) {

        $i_fout .= '<div class="feed-dzsap feed-song-name">' . $che['songname'] . '</div>';
      }

      $i_fout .= $meta_artist_html;

//            print_rr($che);

      if (isset($che['wrapper_image_type']) && $che['wrapper_image_type']) {


        if ($che['wrapper_image_type'] == 'zoomsounds-wrapper-bg-bellow') {

          $this->sw_enable_multisharer = true;
          $i_fout .= '<div href="#" class=" dzsap-wrapper-but dzsap-multisharer-but "><span class="the-icon">{{svg_share_icon}}</span> </div>';

          $i_fout .= '<div href="#" class=" dzsap-wrapper-but btn-like "><span class="the-icon">{{heart_svg}}</span> </div>';
        }

      }


      // -- menu
      if ($che['menu_artistname'] != '' || $che['menu_songname'] != '' || (isset($che['thumb']) && $che['thumb'] != '')) {
        $i_fout .= '<div class="menu-description">';
        if (isset($che['thumb']) && $che['thumb']) {
          $i_fout .= '<div class="menu-item-thumb-con"><div class="menu-item-thumb" style="background-image: url(' . $che['thumb'] . ')"></div></div>';
        }


//                print_r($margs);

        if ($margs['gallery_skin'] == 'skin-aura') {
          $i_fout .= '<div class="menu-artist-info">';
        }


        $i_fout .= '<span class="the-artist">' . $che['menu_artistname'] . '</span>';
        $i_fout .= '<span class="the-name">' . $che['menu_songname'] . '</span>';


        if ($margs['gallery_skin'] == 'skin-aura') {
          $i_fout .= '</div>';
        }

        if (isset($_COOKIE['dzsap_ratesubmitted-' . $playerid])) {
          $che['menu_extrahtml'] = str_replace('download-after-rate', 'download-after-rate active', $che['menu_extrahtml']);
        } else {
          if (isset($_COOKIE['commentsubmitted-' . $playerid])) {
            $che['menu_extrahtml'] = str_replace('download-after-rate', 'download-after-rate active', $che['menu_extrahtml']);
          };
        }


//                print_r($margs);
        if ($margs['gallery_skin'] == 'skin-aura') {
          $i_fout .= '<div class="menu-item-views"><svg class="svg-icon" version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="11.161px" height="12.817px" viewBox="0 0 11.161 12.817" enable-background="new 0 0 11.161 12.817" xml:space="preserve"> <g> <g> <g> <path fill="#D2D6DB" d="M8.233,4.589c1.401,0.871,2.662,1.77,2.801,1.998c0.139,0.228-1.456,1.371-2.896,2.177l-4.408,2.465 c-1.44,0.805-2.835,1.474-3.101,1.484c-0.266,0.012-0.483-1.938-0.483-3.588V3.666c0-1.65,0.095-3.19,0.212-3.422 c0.116-0.232,1.875,0.613,3.276,1.484L8.233,4.589z"/> </g> </g> </g> </svg> <span class="the-count">' . get_post_meta($playerid, '_dzsap_views', true) . '</span></div>';


          if ($margs['menu_facebook_share'] == 'auto' || $margs['menu_facebook_share'] == 'on' || $margs['menu_like_button'] == 'auto' || $margs['menu_like_button'] == 'on') {

            $i_fout .= '<div class="float-right">';
            if ($margs['menu_facebook_share'] == 'auto' || $margs['menu_facebook_share'] == 'on') {

              $i_fout .= ' <a rel="nofollow" class="btn-zoomsounds-menu menu-facebook-share"  onclick=\'window.dzs_open_social_link("http://www.facebook.com/sharer.php?u={{shareurl}}",this); return false;\'><i class="fa fa-share" aria-hidden="true"></i></a>';
            }
            if ($margs['menu_like_button'] == 'auto' || $margs['menu_like_button'] == 'on') {

              $i_fout .= ' <a rel="nofollow" class="btn-zoomsounds-menu menu-btn-like "><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';

            }

            $i_fout .= '</div>';
          }
        }


        $i_fout .= stripslashes($che['menu_extrahtml']);
        $i_fout .= '</div>';
      }

//            print_r($its);
      if (isset($its['settings']['skinwave_comments_enable']) && $its['settings']['skinwave_comments_enable'] == 'on') {

        if ($playerid != '') {

          $i_fout .= '<div class="the-comments">';
          $comms = get_comments(array('post_id' => $playerid));
//                    echo 'cevacomm'; print_r($comms);
          foreach ($comms as $comm) {


            $i_fout .= '<span class="dzstooltip-con" style="left:' . dzsap_sanitize_to_css_perc($comm->comment_author_url) . '"><span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black" style="width: 250px;"><span class="the-comment-author">@' . $comm->comment_author . '</span> says:<br>' . $comm->comment_content . '</span><div class="the-avatar" style="background-image: url(https://secure.gravatar.com/avatar/' . md5($comm->comment_author_email) . '?s=20)"></div></span>';


          }
          $i_fout .= '</div>';


          wp_enqueue_style('dzs.tooltip', $this->base_url . 'libs/dzstooltip/dzstooltip.css');
        }
      }

      if (isset($its['settings']) && $its['settings']['skin_ap'] && ($its['settings']['skin_ap'] == 'skin-customcontrols' || $its['settings']['skin_ap'] == 'skin-customhtml')) {


        if ($margs['the_content']) {

          $i_fout .= do_shortcode($margs['the_content']);


        } else {


//                    $vpset = $this->get_zoomsounds_player_config_settings($this->mainoptions['enable_global_footer_player']);
          if (isset($margs['settings_extrahtml_in_player']) && $margs['settings_extrahtml_in_player']) {

            $i_fout .= $this->sanitize_from_meta_textarea($margs['settings_extrahtml_in_player']);


          } else {
            $i_fout .= ' <div class="custom-play-btn"><div class=" play-button-con"  style="color: #cb1919; width: 25px; height: 25px;"><i class="fa fa-play" style="font-size: 12px;"></i></div></div>  <div class="custom-pause-btn"><div class=" play-button-con "  style="color: #cb1919; width: 25px; height: 25px;"><i class="fa fa-pause" style="font-size: 12px;"></i></div></div>';
          }
        }
//                print_r($margs);
      }
      // --- extra html meta
//            print_r($its);
//            print_r($margs);


      if ($this->debug) {
        print_rr($che);
      }


      $che_post = null;
      if ($playerid && $playerid_is_fake === false) {
        $che_post = get_post($playerid);
      }


//      error_log('$its[\'settings\'] -52 '.print_r($its['settings'],true));
//      error_log('che -52 '.print_r($che,true));


//      error_log('$its[\'settings\'] - '.print_r($its['settings'],true));
      if (isset($its['settings']) && ($its['settings']['enable_views'] == 'on' || $its['settings']['enable_downloads_counter'] == 'on' || $its['settings']['enable_likes'] == 'on' || $its['settings']['enable_rates'] == 'on' || (isset($its['settings']['menu_right_enable_info_btn']) && $its['settings']['menu_right_enable_info_btn'] == 'on') || (isset($che['extra_html']) && $che['extra_html'])

          || (isset($its['settings']['menu_right_enable_info_btn']) && $its['settings']['menu_right_enable_info_btn'] == 'on'))
        || (isset($its['settings']['menu_right_enable_multishare']) && $its['settings']['menu_right_enable_multishare'] == 'on') || (isset($che['enable_download_button']) && $che['enable_download_button'] == 'on')
        || (isset($che['extra_html_in_controls_right']) && $che['extra_html_in_controls_right'])
        || (isset($che['extra_html_in_bottom_controls']) && $che['extra_html_in_bottom_controls'])
        || (isset($che['extrahtml_in_float_right_from_player']) && $che['extrahtml_in_float_right_from_player'])
        || (isset($che['extra_html_left']) && $che['extra_html_left'])
      ) {
        $aux_extra_html = '';


        if (isset($che['extra_html_left'])) {

          $che['extra_html_left'] = wp_kses($che['extra_html_left'], $this->allowed_tags);
        }


        if ((isset($che['extra_html_left']) && $che['extra_html_left'])) {
          $aux_extra_html .= '<div class="extra-html--left">' . $che['extra_html_left'] . '</div>';
          $aux_extra_html .= '<-- END .extra-html--left -->';
        }


        $aux_extra_html_left = '';
        if ($its['settings']['enable_likes'] == 'on') {
          $aux_extra_html_left .= $this->mainoptions['str_likes_part1'];

          if (isset($_COOKIE["dzsap_likesubmitted-" . $playerid])) {
            $aux_extra_html_left = str_replace('<span class="btn-zoomsounds btn-like">', '<span class="btn-zoomsounds btn-like active">', $aux_extra_html_left);
          }
        }


//                print_r($che);


        if ((isset($che['enable_download_button']) && $che['enable_download_button'] == 'on')) {


          $download_link = '';


          $download_link = dzsap_get_download_link($che, $playerid);

          $download_str = ' <a rel="nofollow" target="_blank" href="' . $download_link . '" download class="btn-zoomsounds btn-zoomsounds-download"';


          if ($this->mainoptions['register_to_download_opens_in_new_link'] == 'on') {
            $download_str .= ' target="_blank"';
          }

          $download_str .= '><span class="the-icon"><i class="fa fa-get-pocket"></i></span><span class="the-label">' . $this->mainoptions['i18n_free_download'] . '</span></a>';


          $allow_download = true;


          if ($this->mainoptions['allow_download_only_for_registered_users'] == 'on') {

            // dzstooltip-con" style="top:10px;"><span class="dzstooltip arrow-from-start transition-slidein arrow-bottom skin-black align-right" style="width: auto; white-space: nowrap;">Add to Cart</span>
            global $current_user;

//                        print_rr($current_user);


            if ($current_user->ID) {

              if ($this->mainoptions['allow_download_only_for_registered_users_capability'] && $this->mainoptions['allow_download_only_for_registered_users_capability'] != 'read') {
                if (current_user_can($this->mainoptions['allow_download_only_for_registered_users_capability']) == false) {


                  $allow_download = false;

                }
              }

            } else {

              $allow_download = false;
            }


          }
          if (current_user_can('manage_options')) {
            $allow_download = true;

          }

          if ($allow_download == false) {


            // -- download button


            $download_str = '<span href="' . $download_link . '" class="btn-zoomsounds btn-zoomsounds-download  dzstooltip-con "><span class="tooltip-indicator"><span class="the-icon"><i class="fa fa-get-pocket"></i></span><span class="the-label" style="opacity:0.5">' . $this->mainoptions['i18n_free_download'] . '</span></span> <span class="dzstooltip arrow-from-start transition-slidein arrow-bottom talign-start style-rounded color-dark-light align-right" style="width: auto; white-space: nowrap;"><span class="dzstooltip--inner">' . $this->mainoptions['i18n_register_to_download'] . '</span></span> </span>';
          }


          // data-playerid="'.$playerid.'"
          $aux_extra_html_left .= $download_str;

        }

        // -- end download button


//                echo 'margs - '; print_rr($margs);
        if (isset($margs['single']) && $margs['single'] == 'on') {
          if (isset($margs['enable_embed_button']) && ($margs['enable_embed_button'] == 'on' || $margs['enable_embed_button'] == 'in_extra_html')) {

            if (isset($margs['embed_code']) && $margs['embed_code'] && $margs['embedded'] != 'on') {

              $aux_extra_html_left .= '<span class=" btn-zoomsounds dzstooltip-con btn-embed">  ';


              $aux_extra_html_left .= '<span class="tooltip-indicator"><span class="the-icon"><i class="fa fa-share"></i></span><span class="the-label ">' . __('Embed') . '</span></span>';


              $aux_extra_html_left .= '<span class="dzstooltip transition-slidein arrow-bottom talign-start style-rounded color-dark-light " style="width: 350px; "><span class="dzstooltip--inner"><span style="max-height: 150px; overflow:hidden; display: block; white-space: normal; font-weight: normal">{{embed_code}}</span> <span class="copy-embed-code-btn"><i class="fa fa-clipboard"></i> ' . esc_html__('Copy Embed', 'dzsap') . '</span> </span></span> ';


              $aux_extra_html_left .= '</span>';
            }
          }
        }


        if ($aux_extra_html_left) {

          $aux_extra_html .= '<div class="extra-html--left ">';
          $aux_extra_html .= $aux_extra_html_left;
          $aux_extra_html .= '</div><!-- end .extra-html--left-->';
        }


        if ($its['settings']['enable_rates'] == 'on') {
//                    $aux_extra_html.='<div class="star-rating-con"><div class="star-rating-bg"></div><div class="star-rating-set-clip" style="width: ';

          $aux = get_post_meta($playerid, '_dzsap_rate_index', true);

          // -- 1 to 5
          if ($aux == '') {
            $aux = 0;
          } else {
            $aux = floatval($aux) / 5;
          }
          if ($aux > 5) {
            $aux = 5;
          }

          $perc = floatval(($aux) * 100);


          $aux_extra_html .= '<div class="star-rating-con" data-initial-rating-index="' . $aux . '">';

//						echo 'whyy?';

          $arte_stars = '<span class="rating-bg"><span class="rating-inner">{{starssvg}}</span></span><span class="rating-prog" style="width: ' . $perc . '%;"><span class="rating-inner">{{starssvg}}</span></span>';


          $arte_stars = str_replace('{{starssvg}}', $this->svg_star . $this->svg_star . $this->svg_star . $this->svg_star . $this->svg_star, $arte_stars);

          $aux_extra_html .= $arte_stars;
          $aux_extra_html .= '</div>';


        }


//                print_r($its);

//                error_log('$playerid - '.$playerid);
        if ($its['settings']['enable_views'] == 'on') {
          $aux_extra_html .= $this->mainoptions['str_views'];


//          error_log('get_views -analytics_views- ('.$playerid.')'.get_post_meta($playerid, '_dzsap_views', true));
          $aux = get_post_meta($playerid, '_dzsap_views', true);
          if ($aux == '') {
            $aux = 0;
          }
          $aux_extra_html = str_replace('{{get_plays}}', $aux, $aux_extra_html);
        }
        if ($its['settings']['enable_downloads_counter'] == 'on') {
          $aux_extra_html .= $this->mainoptions['str_downloads_counter'];
          $aux = get_post_meta($playerid, '_dzsap_downloads', true);
          if ($aux == '') {
            $aux = 0;
          }
          $aux_extra_html = str_replace('{{get_downloads}}', $aux, $aux_extra_html);
        }


        if ($its['settings']['enable_likes'] == 'on') {
          $aux_extra_html .= $this->mainoptions['str_likes_part2'];

          $nr_likes = $this->get_likes_for_track($playerid);

//                    echo '$playerid - '.$playerid;
          if ($nr_likes == '' || $nr_likes == '-1') {
            $nr_likes = 0;
          }
          $aux_extra_html = str_replace('{{get_likes}}', $nr_likes, $aux_extra_html);
        }


        if ($its['settings']['enable_rates'] == 'on') {
          $aux_extra_html .= $this->mainoptions['str_rates'];
          $aux = get_post_meta($playerid, '_dzsap_rate_nr', true);
          if ($aux == '') {
            $aux = 0;
          }
          $aux_extra_html = str_replace('{{get_rates}}', $aux, $aux_extra_html);

          if (isset($_COOKIE['dzsap_ratesubmitted-' . $playerid])) {
            $aux_extra_html .= '{{ratesubmitted=' . $_COOKIE['dzsap_ratesubmitted-' . $playerid] . '}}';
          };
        }


        if ((isset($che['extra_html']) && $che['extra_html'])) {
          $aux_extra_html .= '' . $che['extra_html'];
        }


        if ((isset($che['extra_html_in_controls_left']) && $che['extra_html_in_controls_left'])) {
          $i_fout .= '<div class="extra-html-in-controls-left" style="opacity:0;">' . $che['extra_html_in_controls_left'] . '</div>';
        }


//                echo '$start_nr - '.$start_nr;
//                echo '$end_nr - '.$end_nr;
//                echo '$i - '.$i;
//                print_r($its);


        $str_info_btn = '';
        $str_multishare_btn = '';
        $str_extra_html_in_right_controls = '';

//        echo ' $its[\'settings\'] - 55'; print_rr($its['settings']);
//        echo ' $che - '; print_rr($che);


        $post_content = '';

//        print_rr($che);

        if (isset($che['post_content']) && $che['post_content']) {
          $post_content = $che['post_content'];
        } else {
          if (isset($che['content_inner']) && $che['content_inner']) {
            $post_content = $che['content_inner'];
          }
        }


//        echo '$its[\'settings\'] - '.print_rr($its['settings'],true);
        if ((isset($its['settings']['menu_right_enable_info_btn']) && $its['settings']['menu_right_enable_info_btn'] == 'on') && isset($che) && $post_content) {


          // -- infobtn / info button

          $str_info_btn .= do_shortcode('[player_button extra_classes="dzsap-btn-info" style="player-but"  icon="fa-info" link=""]' . wpautop(do_shortcode($post_content)) . '[/player_button]');


        }

        if (isset($its['settings']['menu_right_enable_multishare']) && $its['settings']['menu_right_enable_multishare'] == 'on') {
          $this->sw_enable_multisharer = true;
          $str_multishare_btn .= ' <div class="player-but sharer-dzsap-but dzsap-multisharer-but"><div class="the-icon-bg"></div>{{svg_share_icon}}</div>';
        }


//                echo 'we arrived hier'; print_rr($che);
        if ((isset($che['extra_html_in_controls_right']) && $che['extra_html_in_controls_right'])) {
          $che['extra_html_in_controls_right'] = dzsap_sanitize_from_extra_html_props($che['extra_html_in_controls_right'], $che['playerid'], $che);


          $str_extra_html_in_right_controls .= '' . (do_shortcode($che['extra_html_in_controls_right'])) . '';


          if ($che_post) {

            $str_extra_html_in_right_controls = '' . dzsap_sanitize_to_extra_html($str_extra_html_in_right_controls, $che) . '';
          }

        }

        if (isset($che['extrahtml_in_float_right_from_player']) && $che['extrahtml_in_float_right_from_player']) {

          $str_extra_html_in_right_controls .= '' . do_shortcode(dzsap_sanitize_from_shortcode_attr($che['extrahtml_in_float_right_from_player'], $che)) . '';
        }

//                echo '$str_extra_html_in_right_controls - '.$str_extra_html_in_right_controls.'|';

        if (strpos($str_extra_html_in_right_controls, 'dzsap-multisharer-but') !== false) {

          $this->sw_enable_multisharer = true;

        }


//	            echo 'its- ';print_rr($its);
//	            echo 'margs- ';print_rr($margs);
//	            echo '$str_extra_html_in_right_controls -3> ';print_rr($str_extra_html_in_right_controls);
        if (isset($its['settings']) && ($str_info_btn || $str_multishare_btn || $str_extra_html_in_right_controls)) {


          // -- extra-html in right controls set in parse_items
          $i_fout .= '<div class="extra-html-in-controls-right" style="opacity:0;">';


          $i_fout .= $str_info_btn;
          $i_fout .= $str_multishare_btn;
          $i_fout .= $str_extra_html_in_right_controls;


          $i_fout .= '</div>';
        }


//                echo 'hmmdada';
        if (strpos($aux_extra_html, '<i class="fa') !== false) {


          $url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

          if ($this->mainoptions['fontawesome_load_local'] == 'on') {
            $url = $this->base_url . 'libs/fontawesome/font-awesome.min.css';
          }


          wp_enqueue_style('fontawesome', $url);

        }


//	            echo '$aux_extra_html - '; print_rr($aux_extra_html);


        $i_fout .= '<div class="extra-html" data-playerid="' . $che['playerid'] . '" style="opacity:0;">' . ($aux_extra_html) . '</div>';
      }


      if ($margs['called_from'] == 'single_product_summary') {

        if (isset($margs['product_id'])) {

          if ($this->mainoptions['wc_product_play_in_footer'] == 'on') {


//                    print_rr($margs);

            $vpset = $this->get_zoomsounds_player_config_settings($this->mainoptions['enable_global_footer_player']);

//                    print_rr($vpset);


//                    print_rr($margs);


            $price = '';

            if (get_post_meta($margs['product_id'], '_regular_price', true)) {
              if (function_exists('get_woocommerce_currency_symbol')) {
                $price .= get_woocommerce_currency_symbol();
              }
              if (get_post_meta($margs['product_id'], '_sale_price', true)) {

                $price .= get_post_meta($margs['product_id'], '_sale_price', true);
              } else {

                $price .= get_post_meta($margs['product_id'], '_regular_price', true);
              }
            }


            if (isset($vpset['settings']['extra_classes_player']) && strpos($vpset['settings']['extra_classes_player'], 'skinvariation-wave-righter') !== false) {

              $i_fout .= '<div class="feed-dzsap-for-extra-html-right"><form method="post" style="margin: 0!important; "><button class="zoomsounds-add-tocart-btn" name="add-to-cart" value="' . $margs['product_id'] . '"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;<span class="the-price">' . $price . '</span></button></form></div>';
            }


          }
        }

      }


      if (isset($che['inner_html']) && $che['inner_html']) {
        $i_fout .= $che['inner_html'];
      }


      if (isset($che['settings_extrahtml_after_playpause']) && $che['settings_extrahtml_after_playpause']) {
        $i_fout .= '<div class="feed-dzsap feed-dzsap-after-playpause">';
        $i_fout .= '<span class="con-after-playpause">';


        $i_fout .= $che['settings_extrahtml_after_playpause'];
        $i_fout .= '</span>';
        $i_fout .= '</div>';
      }


      if (isset($che['settings_extrahtml_after_con_controls']) && $che['settings_extrahtml_after_con_controls']) {


        $che['settings_extrahtml_after_con_controls'] = dzsap_sanitize_from_extra_html_props($che['settings_extrahtml_after_con_controls'], '', $che);
        $i_fout .= '<div class="feed-dzsap feed-dzsap-after-con-controls">';
        $i_fout .= '<span class="con-after-con-controls">';
        $i_fout .= $che['settings_extrahtml_after_con_controls'];
        $i_fout .= '</span>';
        $i_fout .= '</div>';
      }


      $i_fout .= '</div>';

      if (isset($che['apply_script'])) {

      }


      if (isset($its['settings']) && $its['settings']['skin_ap'] && ($its['settings']['skin_ap'] == 'skin-customhtml')) {


        $i_fout = $this->sanitize_from_meta_textarea($margs['settings_extrahtml_in_player']);

        $i_fout = str_replace('{{artist_complete_html}}', $meta_artist_html, $i_fout);


        $lab = 'source';

        if (isset($che[$lab])) {
          $i_fout = str_replace('{{' . $lab . '}}', $che[$lab], $i_fout);
        } else {

          $i_fout = str_replace('{{' . $lab . '}}', '', $i_fout);
        }
        $lab = 'type';

        if (isset($che[$lab])) {
          $i_fout = str_replace('{{' . $lab . '}}', $che[$lab], $i_fout);
        } else {

          $i_fout = str_replace('{{' . $lab . '}}', '', $i_fout);
        }

        $lab = 'thumb';

        if (isset($che[$lab])) {
          $i_fout = str_replace('{{' . $lab . '}}', $che[$lab], $i_fout);
        } else {

          $i_fout = str_replace('{{' . $lab . '}}', '', $i_fout);
        }
        $lab = 'pcm';

        $i_fout = str_replace('{{' . $lab . '}}', $pcm, $i_fout);

        $lab = 'fakeplayer_attr';
        $i_fout = str_replace('{{' . $lab . '}}', $fakeplayer_attr, $i_fout);

        $lab = 'thumb_for_parent_attr';
        $i_fout = str_replace('{{' . $lab . '}}', $thumb_for_parent_attr, $i_fout);

        $lab = 'thumb_link';
        $i_fout = str_replace('{{' . $lab . '}}', $thumb_link_attr, $i_fout);

      }

      $fout .= $i_fout;


    }


    return $fout;
  }

  function check_if_user_played_track($track_id) {

    global $current_user;

//        echo 'current_user - ';print_r($current_user);

    if ($current_user && isset($current_user->data) && $current_user->data && isset($current_user->data->ID) && $current_user->data->ID) {
      //--- if user logged in

//            echo 'dadada';
      return $this->mysql_check_if_user_did_activity($current_user->data->ID, $track_id, 'view');
    } else {
      if (isset($_COOKIE['viewsubmitted-' . $track_id])) {
        return true;
      }
      return false;
    }
  }


  function check_if_user_liked_track($track_id, $id_user = 0) {

    global $current_user;

//        echo 'current_user - ';print_r($current_user);


    if ($id_user == 0 && $current_user && isset($current_user->data) && $current_user->data && isset($current_user->data->ID) && $current_user->data->ID) {
      $id_user = $current_user->data->ID;
    }

    if ($id_user) {
      //--- if user logged in

//            echo 'dadada';

      // todo: maybe not permanent

//            if (isset($_COOKIE['dzsap_likesubmitted-' . $track_id])) {
//                return true;
//            }

//            echo ' $id_user-'.$id_user.'| - ( $track_id - '.$track_id.' ) -- $this->mysql_check_if_user_did_activity($id_user, $track_id,\'like\') -> '.($this->mysql_check_if_user_did_activity($id_user, $track_id,'like'));

      return $this->mysql_check_if_user_did_activity($id_user, $track_id, 'like');
    } else {

//            echo 'check_if_user_liked_track - $_COOKIE '; print_rr($_COOKIE);
      if (isset($_COOKIE['likesubmitted-' . $track_id])) {
        return true;
      }
      if (isset($_COOKIE['dzsap_likesubmitted-' . $track_id])) {
        return true;
      }
      return false;
    }
  }

  function mysql_check_if_user_did_activity($id_user, $track_id, $type = 'view') {


//	    print_rr($this->mainoptions);
    if ($this->mainoptions['wpdb_enable'] == 'on') {
      global $wpdb;


      $currip = dzsap_misc_get_ip();
      $date = date('Y-m-d H:i:s');
      $table_name = $wpdb->prefix . 'dzsap_activity';

      $user_id = 0;

//        echo '$id_user - '.$id_user.' track_id - '.$track_id;
//                    error_log('adding '.$table_name);

//            echo 'get_option(\'dzsap_table_activity_created\') - '.get_option('dzsap_table_activity_created');
      if (get_option('dzsap_table_activity_created')) {

        $table_name = $wpdb->prefix . 'dzsap_activity';
        $query = "SELECT * FROM $table_name WHERE `id_user` = '$id_user' AND `id_video`='$track_id' AND `type`='$type'";


//        echo $query;
        $mylink = $wpdb->get_row($query);

//                echo 'mylink -> '; print_r($mylink);

        if ($mylink && isset($mylink->id)) {
          return true;
        }
      }


      return false;
    }


  }


  function get_post_thumb_src($it_id) {
    $imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($it_id), "full");

    if ($imgsrc && $imgsrc[0]) {

      return $imgsrc[0];
    }
    return '';
  }


  function sanitize_id_to_src($arg) {

//        echo ' arg - '.$arg;
    if (is_numeric($arg)) {

      $imgsrc = wp_get_attachment_image_src($arg, 'full');
//            print_r($imgsrc);
//            echo ' $imgsrc - '.$imgsrc;
      return $imgsrc[0];
    } else {
      return $arg;
    }


  }



  function delete_activity($pargs = array()) {
    if ($this->mainoptions['wpdb_enable'] == 'on') {
      global $wpdb;


      $margs = array(
        'type' => 'download',
        'id_user' => '',
        'id_video' => '',
      );

      if ($pargs == '' || is_array($pargs) == false) {
        $pargs = array();
      }

      $margs = array_merge($margs, $pargs);

      $currip = dzsap_misc_get_ip();
      $date = date('Y-m-d H:i:s');


      if (get_option('dzsap_table_activity_created')) {
        $table_name = $wpdb->prefix . 'dzsap_activity';

        $user_id = 0;
        $current_user = wp_get_current_user();

        if ($current_user) {
          if ($current_user->ID) {
            $user_id = $current_user->ID;
          }
        }

//                    error_log('adding '.$table_name);

        $args = array(
          'ip' => $currip,
          'type' => $margs['type'],
          'id_user' => $user_id,
          'id_video' => $margs['id_video'],
          'date' => $date,
        );


        $sql = "
                DELETE FROM $table_name
		 WHERE type = '" . $margs['type'] . "'
		";

        if ($user_id) {
          $sql .= "AND id_user='" . $user_id . "'";
        }
        if ($margs['id_video']) {
          $sql .= "AND id_video='" . $margs['id_video'] . "'";
        }

        $wpdb->prepare(
          $sql, array()
        );


        error_log('adding ' . $table_name . ' deleting args - ' . print_r($args, true));

      } else {

        $this->create_activity_table();
      }
    }

  }

  function insert_activity($pargs = array()) {


//	    error_log('$this->mainoptions[\'wpdb_enable\'] - '.($this->mainoptions['wpdb_enable']));
    if ($this->mainoptions['wpdb_enable'] == 'on') {
      global $wpdb;


      $margs = array(
        'type' => 'download',
        'id_user' => '',
        'id_video' => '',
      );

      if ($pargs == '' || is_array($pargs) == false) {
        $pargs = array();
      }

      $margs = array_merge($margs, $pargs);

      $currip = dzsap_misc_get_ip();
      $date = date('Y-m-d H:i:s');


      if (get_option('dzsap_table_activity_created')) {
        $table_name = $wpdb->prefix . 'dzsap_activity';

        $user_id = 0;
        $current_user = wp_get_current_user();

        if ($current_user) {
          if ($current_user->ID) {
            $user_id = $current_user->ID;
          }
        }

//                    error_log('adding '.$table_name);

        $args = array(
          'ip' => $currip,
          'type' => $margs['type'],
          'id_user' => $user_id,
          'id_video' => $margs['id_video'],
          'date' => $date,
        );


        if ($margs['type'] == 'like' || $margs['type'] == 'download') {
          $args['val'] = 1;
        }

        error_log('adding ' . $table_name . ' insert args - ' . print_r($args, true));

        $wpdb->insert($table_name, $args);
      } else {

        $this->create_activity_table();
      }
    }

  }


  function handle_widgets_init() {


//	    error_log("HMM");
    include_once "widget.php";
    $dzsap_widget = new DZSAP_Tags_Widget();

    $dzsap_widget::register_this_widget();

    add_action('widgets_init', array($dzsap_widget, 'register_this_widget'));
  }

  function handle_admin_init() {

//        echo 'ceva';
    if ($this->mainoptions['analytics_enable'] == 'on') {

      wp_enqueue_script('google.charts', 'https://www.gstatic.com/charts/loader.js');

      if ($this->mainoptions['analytics_enable_location'] == 'on') {

        wp_enqueue_script('google.maps', 'https://www.google.com/jsapi');
      }
    }

    add_settings_section('dzsap-permalink', __('Audio Items Permalink Base', 'dzsap'), array($this, 'permalink_settings'), 'permalink');


    if ($this->mainoptions['analytics_table_created'] == 'off') {

      dzsap_analytics_table_create();
    }

  }


  function permalink_settings() {

    echo wpautop(__('These settings control the permalinks used for products. These settings only apply when <strong>not using "default" permalinks above</strong>.', 'dzsap'));

    $permalinks = get_option('dzsap_permalinks');
    $dzsap_permalink = $permalinks['item_base'];
    //echo 'ceva';

    $item_base = _x('audio', 'default-slug', 'dzsap');

    $structures = array(0 => '', 1 => '/' . trailingslashit($item_base));
    ?>
    <table class="form-table">
      <tbody>
      <tr>
        <th><label><input name="dzsap_permalink" type="radio" value="<?php echo $structures[0]; ?>"
                          class="dzsaptog" <?php checked($structures[0], $dzsap_permalink); ?> /> <?php _e('Default'); ?>
          </label></th>
        <td><code><?php echo home_url(); ?>/?audio=sample-item</code></td>
      </tr>
      <tr>
        <th><label><input name="dzsap_permalink" type="radio" value="<?php echo $structures[1]; ?>"
                          class="dzsaptog" <?php checked($structures[1], $dzsap_permalink); ?> /> <?php _e('Product', 'dzsap'); ?>
          </label></th>
        <td><code><?php echo home_url(); ?>/<?php echo $item_base; ?>/sample-item/</code></td>
      </tr>
      <tr>
        <th><label><input name="dzsap_permalink" id="dzsap_custom_selection" type="radio" value="custom"
                          class="tog" <?php checked(in_array($dzsap_permalink, $structures), false); ?> />
            <?php _e('Custom Base', 'dzsap'); ?></label></th>
        <td>
          <input name="dzsap_permalink_structure" id="dzsap_permalink_structure" type="text"
                 value="<?php echo esc_attr($dzsap_permalink); ?>" class="regular-text code"> <span
            class="description"><?php _e('Enter a custom base to use. A base <strong>must</strong> be set or WordPress will use default instead.', 'dzsap'); ?></span>
        </td>
      </tr>
      </tbody>
    </table>
    <script type="text/javascript">
      jQuery(function () {
        jQuery('input.dzsaptog').change(function () {
          jQuery('#dzsap_permalink_structure').val(jQuery(this).val());
        });

        jQuery('#dzsap_permalink_structure').focus(function () {
          jQuery('#dzsap_custom_selection').click();
        });
      });
    </script>
    <?php
  }


  function check_posts_init() {

    dzsap_ajax_check_init_args();

  }


  function handle_admin_menu() {
    DZSZoomSoundsHelper::registerDzsapPages();

  }

  function admin_page_about() {

    include_once('class_parts/admin-page-about.php');


    wp_enqueue_style('dzstabsandaccordions', $this->base_url . 'libs/dzstabsandaccordions/dzstabsandaccordions.css');
    wp_enqueue_script('dzstabsandaccordions', $this->base_url . "libs/dzstabsandaccordions/dzstabsandaccordions.js");
    $url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

    if ($this->mainoptions['fontawesome_load_local'] == 'on') {
      $url = $this->base_url . 'libs/fontawesome/font-awesome.min.css';
    }


    wp_enqueue_style('fontawesome', $url);

  }


  function admin_page_autoupdater() {
    include_once DZSAP_BASE_PATH . 'class_parts/admin-page-autoupdater.php';
    dzsap_admin_page_autoupdater();
  }


  function admin_scripts() {
  }

  function front_scripts() {
    $this->enqueue_main_scripts();
  }


  function admin_page_mainoptions() {
    //print_r($this->mainoptions);
    if (isset($_POST['dzsap_delete_plugin_data']) && $_POST['dzsap_delete_plugin_data'] == 'on') {


      // -- delete plugin data

      if ($this->dbs && is_array($this->dbs) && count($this->dbs)) {

        foreach ($this->dbs as $db) {

          $aux = $this->dbname_mainitems;
          $aux .= '-' . $db;

          delete_option($this->$aux);
        }
      }

      delete_option($this->dbname_dbs);

      delete_option($this->dbname_mainitems);
      delete_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS);
      delete_option($this->dbname_options);
    }


    if (isset($_GET['dzsap_shortcode_builder']) && $_GET['dzsap_shortcode_builder'] == 'on') {
      dzsap_shortcode_builder();
    } elseif (isset($_GET['dzsap_shortcode_player_builder']) && $_GET['dzsap_shortcode_player_builder'] == 'on') {


      dzsap_shortcode_player_builder();
    } elseif (isset($_GET['dzsap_preview_player']) && $_GET['dzsap_preview_player'] == 'on') {

      include_once "class_parts/admin-preview-player.php";


      dzsap_preview_player();
    } else {

      include_once "class_parts/admin-page-mainoptions.php";
    }
    //print_r($this->mainoptions);
    ?>


    <div class="clear"></div><br/>
    <?php
  }


  function admin_page() {

    // -- old Sliders Admin
    include_once "inc/php/deprecated-sliders-admin.php";
  }

  function admin_page_vpc() {

    include_once DZSAP_BASE_PATH . "class_parts/admin-page-audioPlayerConfigs.php";

    dzsap_admin_page_vpc();
  }

  function post_options() {
    //// POST OPTIONS ///

    if (isset($_POST['dzsap_exportdb'])) {


      //===setting up the db
      $currDb = '';
      if (isset($_POST['currdb']) && $_POST['currdb'] != '') {
        $this->currDb = $_POST['currdb'];
        $currDb = $this->currDb;
      }

      //echo 'ceva'; print_r($this->dbs);
      if ($currDb != 'main' && $currDb != '') {
        $this->dbname_mainitems .= '-' . $currDb;
        $this->mainitems = get_option($this->dbname_mainitems);
      }
      //===setting up the db END

      header('Content-Type: text/plain');
      header('Content-Disposition: attachment; filename="' . "dzsap_backup.txt" . '"');
      echo serialize($this->mainitems);
      die();
    }

    if (isset($_POST['dzsap_exportslider'])) {


      //===setting up the db
      $currDb = '';
      if (isset($_POST['currdb']) && $_POST['currdb'] != '') {
        $this->currDb = $_POST['currdb'];
        $currDb = $this->currDb;
      }


      $this->db_read_mainitems();

      //echo 'ceva'; print_r($this->dbs);
      if ($currDb != 'main' && $currDb != '') {
        $this->dbname_mainitems .= '-' . $currDb;
        $this->mainitems = get_option($this->dbname_mainitems);
      }
      //===setting up the db END
      //print_r($currDb);

      header('Content-Type: text/plain');
      header('Content-Disposition: attachment; filename="' . "dzsap-slider-" . $_POST['slidername'] . ".txt" . '"');
      //print_r($_POST);

      error_log("EXPORTING SLIDER ( currdb - " . $currDb . " )" . print_rr($this->mainitems, array('echo' => false)));
      echo serialize($this->mainitems[$_POST['slidernr']]);
      die();
    }

    if (isset($_POST['dzsap_exportslider_config'])) {


      //===setting up the db
      $currDb = '';


      error_log('hmm');

      $this->db_read_mainitems();

      //echo 'ceva'; print_r($this->dbs);

      //===setting up the db END
      //print_r($currDb);

      header('Content-Type: text/plain');
      header('Content-Disposition: attachment; filename="' . "dzsap-slider-" . $_POST['slidername'] . ".txt" . '"');
      //print_r($_POST);

      error_log("EXPORTING SLIDER CONFIG ( currdb - " . $currDb . " )" . print_rr($this->mainitems_configs, array('echo' => false)));
      echo serialize($this->mainitems_configs[$_POST['slidernr']]);
      die();
    }


    if (isset($_POST['dzsap_importdb'])) {
      //print_r( $_FILES);
      $file_data = file_get_contents($_FILES['dzsap_importdbupload']['tmp_name']);
      $aux = unserialize($file_data);

      if (is_array($aux)) {

        $this->mainitems = array_merge($this->mainitems, $aux);
        update_option($this->dbname_mainitems, $this->mainitems);
      }
    }

    if (isset($_POST['dzsap_importslider'])) {
      //print_r( $_FILES);
      $file_data = file_get_contents($_FILES['importsliderupload']['tmp_name']);
      $auxslider = unserialize($file_data);
      //replace_in_matrix('http://localhost/wpmu/eos/wp-content/themes/eos/', THEME_URL, $this->mainitems);
      //replace_in_matrix('http://eos.digitalzoomstudio.net/wp-content/themes/eos/', THEME_URL, $this->mainitems);
      //echo 'ceva';
      //print_r($auxslider);
      $this->mainitems = get_option($this->dbname_mainitems);
      //print_r($this->mainitems);
      $this->mainitems[] = $auxslider;

      update_option($this->dbname_mainitems, $this->mainitems);
    }

    if (isset($_POST['dzsap_import_config'])) {
      //print_r( $_FILES);
      $file_data = file_get_contents($_FILES['importsliderupload']['tmp_name']);
      $this->import_vpconfig_serialized($file_data);
    }

    if (isset($_POST['dzsap_saveoptions'])) {
      $this->mainoptions['usewordpressuploader'] = $_POST['usewordpressuploader'];
      $this->mainoptions['embed_prettyphoto'] = $_POST['embed_prettyphoto'];
      $this->mainoptions['use_external_uploaddir'] = $_POST['use_external_uploaddir'];
      $this->mainoptions['disable_prettyphoto'] = $_POST['disable_prettyphoto'];


      update_option($this->dbname_options, $this->mainoptions);
    }
  }

  function import_vpconfig_by_name($name) {
//    error_log('import_vpconfig_by_name - ' . print_r($this->base_url, true));
    if ($name) {


//          error_log('$this->base_url - '. print_r($this->base_url,true));


//        error_log('file - '.print_r($this->base_url.'sampledata/dzsap-slider-'.$name.'.txt',true));

      $rel_path = 'sampledata/dzsap-slider-' . $name . '.txt';
      $this->import_vpconfig_serialized(file_get_contents($this->base_url . $rel_path));
    }
  }

  function import_vpconfig_serialized($file_data) {

    try {

      $auxslider = unserialize($file_data);

//        error_log('$auxslider - '.print_r($auxslider,true). 'is_object($auxslider) - ('.is_object($auxslider).') $file_data - '.$file_data);
      //replace_in_matrix('http://localhost/wpmu/eos/wp-content/themes/eos/', THEME_URL, $this->mainitems);
      //replace_in_matrix('http://eos.digitalzoomstudio.net/wp-content/themes/eos/', THEME_URL, $this->mainitems);
      //echo 'ceva';
      //print_r($auxslider);
      if ((is_object($auxslider) || is_array($auxslider)) && $auxslider['settings']) {

        $this->mainitems_configs = get_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS);
        //print_r($this->mainitems);
        $this->mainitems_configs[] = $auxslider;

        update_option(DZSAP_DBNAME_AUDIO_PLAYERS_CONFIGS, $this->mainitems_configs);
      }
    } catch (Exception $e) {
      error_log('e import_vpconfig_serialized -> ' . print_r($e, true));
    }
  }


  function filter_attachment_fields_to_edit($form_fields, $post) {


    $vpconfigsstr = '';
    $the_id = $post->ID;
    $post_type = get_post_mime_type($the_id);
    //print_r($this->mainitems_configs);
    ////print_r($post);


    if (strpos($post_type, "audio") === false) {
      return $form_fields;
    }

    foreach ($this->mainitems_configs as $vpconfig) {
      //print_r($vpconfig);
      $vpconfigsstr .= '<option value="' . $vpconfig['settings']['id'] . '">' . $vpconfig['settings']['id'] . '</option>';
    }


    $html_sel = '<select class="styleme" id="attachments-' . $post->ID . '-dzsap-config" name="attachments[' . $post->ID . '][dzsap-config]"><option value="default">Default Settings</option>';
    $html_sel .= $vpconfigsstr;
    $html_sel .= '</select>';
    //$html_sel.='<div>'.$post_type.'</div>';

    $form_fields['dzsap-config'] = array(
      'label' => 'ZoomSounds Player Config',
      'input' => 'html',
      'html' => $html_sel,
      'helps' => 'choose a configuration for the player / edit in ZoomSounds > Player Configs',
    );


    if ($this->mainoptions['skinwave_wave_mode'] != 'canvas') {

      $lab = 'waveformbg';
//        print_r($post);

      $loc = $post->guid;

      if (wp_get_attachment_url($post->id)) {
        $loc = wp_get_attachment_url($post->id);
      }

//        echo 'url -> '.$loc;

      $html_input = '<div class="aux-file-location" style="display:none;">' . $loc . '</div><input id="attachments-' . $post->ID . '-' . $lab . '" class="textinput upload-prev main-thumb" name="attachments[' . $post->ID . '][' . $lab . ']"';
      if (get_post_meta($the_id, '_' . $lab, true) != '') {
        $html_input .= ' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
      }
      $html_input .= '/><span class="aux-wave-generator"><button class="btn-autogenerate-waveform-bg button-secondary">' . esc_html__('Auto generate', 'dzsap') . '</button></span> &nbsp;<button class="btn-generate-default-waveform-bg button-secondary">' . esc_html__('Default waveform', 'dzsap') . '</button>';

      $form_fields[$lab] = array(
        'label' => 'Waveform Background',
        'input' => 'html',
        'html' => $html_input,
        'helps' => '* only for skin-wave / the path to the waveform bg file / auto generate the wave form by cliking the auto generate button and then the orange button that appears ( wait for loading ) <br> <em>note: only recommded for regular songs ( under 5-6 minutes ) - anything else then that is very cpu extensive / better to use a fake waveform ( the default waveform button ) ',
      );


      $lab = 'waveformprog';
      $html_input = '<div class="aux-file-location" style="display:none;">' . $loc . '</div><input id="attachments-' . $post->ID . '-' . $lab . '" class="textinput upload-prev main-thumb" name="attachments[' . $post->ID . '][' . $lab . ']"';
      if (get_post_meta($the_id, '_' . $lab, true) != '') {
        $html_input .= ' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
      }
      $html_input .= '/><span class="aux-wave-generator"><button class="btn-autogenerate-waveform-prog button-secondary">' . esc_html__('Auto generate', 'dzsap') . '</button></span> &nbsp;<button class="btn-generate-default-waveform-prog button-secondary">' . esc_html__('Default waveform', 'dzsap') . '</button>';

      $form_fields[$lab] = array(
        'label' => 'Waveform Progress',
        'input' => 'html',
        'html' => $html_input,
        'helps' => '* only for skin-wave / the path to the waveform progress file / auto generate the wave form by cliking the auto generate button and then the orange button that appears',
      );

    }


    $lab = 'dzsap-thumb';
    $html_input = '<input id="attachments-' . $post->ID . '-' . $lab . '" class="upload-target-prev" name="attachments[' . $post->ID . '][' . $lab . ']"';
    if (get_post_meta($the_id, '_' . $lab, true) != '') {
      $html_input .= ' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
    }
    $html_input .= '/> <a rel="nofollow" href="#" class="upload-for-target button-secondary">' . esc_html__('Upload', 'dzsap') . '</a>';

    $form_fields[$lab] = array(
      'label' => __('Thumbnail', 'dzsap'),
      'input' => 'html',
      'html' => $html_input,
      'helps' => __('choose a thumbnail / optional', 'dzsap'),
    );


    $lab = 'dzsap_sourceogg';
    $html_input = '<input id="attachments-' . $post->ID . '-' . $lab . '" class="upload-target-prev upload-type-audio" name="attachments[' . $post->ID . '][' . $lab . ']"';
    if (get_post_meta($the_id, '_' . $lab, true) != '') {
      $html_input .= ' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
    }
    $html_input .= '/><button class="upload-for-target button-secondary">' . __('Upload', 'dzsap') . '</button>';

    $form_fields[$lab] = array(
      'label' => esc_html__('OGG Source', 'dzsap'),
      'input' => 'html',
      'html' => $html_input,
      'helps' => 'optional - if you do not set this, the full flash player backup will kick in.',
    );


    return $form_fields;
  }

  function filter_attachment_fields_to_save($post, $attachment) {
    //print_r($post);
    $pid = $post['ID'];
    $lab = 'waveformbg';
    //print_r($attachment);
    if (isset($attachment[$lab])) {
      update_post_meta($pid, '_' . $lab, $attachment[$lab]);
    }
    $lab = 'waveformprog';
    if (isset($attachment[$lab])) {
      update_post_meta($pid, '_' . $lab, $attachment[$lab]);
    }
    $lab = 'dzsap-thumb';
    if (isset($attachment[$lab])) {
      update_post_meta($pid, '_' . $lab, $attachment[$lab]);
    }
    $lab = 'dzsap_sourceogg';
    if (isset($attachment[$lab])) {
      update_post_meta($pid, '_' . $lab, $attachment[$lab]);
    }
    return $post;
  }

}


$dzsap_got_category_feed = false;

