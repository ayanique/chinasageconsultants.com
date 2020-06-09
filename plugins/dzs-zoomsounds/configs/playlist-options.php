<?php
$arr_off_on  =array(
  array(
    'label'=>esc_html__("Off",'dzsap'),
    'value'=>'off',
  ),
  array(
    'label'=>esc_html__("On",'dzsap'),
    'value'=>'on',
  ),
);

return array(



  array(
    'name'=>'galleryskin',
    'type'=>'select',
    'category'=>'main',
    'select_type'=>'opener-listbuttons',
    'title'=>esc_html__('Gallery Skin','dzsap'),
    'extra_classes'=>'opener-listbuttons-flex-full',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Wave",'dzsap'),
        'value'=>'skin-wave',
      ),
      array(
        'label'=>esc_html__("Default",'dzsap'),
        'value'=>'skin-default',
      ),
      array(
        'label'=>esc_html__("Aura",'dzsap'),
        'value'=>'skin-aura',
      ),
    ),
    'choices_html'=>array(
      '<span class="option-con"><img src="'.$dzsap->base_url.'img/galleryskin-wave.jpg"/><span class="option-label">'.esc_html__("Wave",'dzsap').'</span></span>',
      '<span class="option-con"><img src="'.$dzsap->base_url.'img/galleryskin-default.jpg"/><span class="option-label">'.esc_html__("Default",'dzsap').'</span></span>',
      '<span class="option-con"><img src="'.$dzsap->base_url.'img/galleryskin-aura.jpg"/><span class="option-label">'.esc_html__("Aura",'dzsap').'</span></span>',
    ),


  ),



  array(
    'name'=>'vpconfig',
    'title'=>esc_html__('Player Configuration','dzsap'),
    'description'=>esc_html__('choose the gallery skin','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>array(
    ),
  ),
  array(
    'name'=>'mode',
    'title'=>esc_html__('Mode','dzsap'),
    'description'=>esc_html__('choose the gallery mode','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>array(
      array(
        'label'=>esc_html__("Default",'dzsap'),
        'value'=>'mode-normal',
      ),
      array(
        'label'=>esc_html__("Show all",'dzsap'),
        'value'=>'mode-showall',
      ),
    ),
  ),
  array(
    'name'=>'settings_navigation_method',
    'title'=>esc_html__('Navigation method','dzsap'),
    'description'=>esc_html__('choose how the playlist scrolls','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>array(
      array(
        'label'=>esc_html__("On mouse move",'dzsap'),
        'value'=>'mouseover',
      ),
      array(
        'label'=>esc_html__("No scroll necessary",'dzsap'),
        'value'=>'full',
      ),
      array(
        'label'=>esc_html__("Normal scroll",'dzsap'),
        'value'=>'legacyscroll',
      ),
    ),
    'dependency'=>array(
      array(
        'element'=>'term_meta[mode]',
        'value'=>array('mode-normal'),
      ),
    ),
  ),
  array(
    'name'=>'settings_mode_showall_show_number',
    'title'=>esc_html__('Mode Showall Number','dzsap'),
    'description'=>esc_html__('display the number','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
    'dependency'=>array(
      array(
        'element'=>'term_meta[mode]',
        'value'=>array('mode-showall'),
      ),
    ),
  ),
  array(
    'name'=>'mode_showall_layout',
    'title'=>esc_html__('Mode Showall Layout','dzsap'),
    'description'=>esc_html__('Number of items per row','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>array(
      array(
        'label'=>esc_html__("Default",'dzsap'),
        'value'=>'',
      ),
      array(
        'label'=>esc_html__("Two per row",'dzsap'),
        'value'=>'two-per-row',
      ),
      array(
        'label'=>esc_html__("Three per row",'dzsap'),
        'value'=>'three-per-row',
      ),
      array(
        'label'=>esc_html__("Four per row",'dzsap'),
        'value'=>'three-per-row',
      ),
    ),
    'dependency'=>array(
      array(
        'element'=>'term_meta[mode]',
        'value'=>array('mode-showall'),
      ),
    ),
  ),
  array(
    'name'=>'enable_linking',
    'title'=>esc_html__('Linking','dzsap'),
    'description'=>esc_html__('choose the gallery skin','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>$arr_off_on,
  ),
  array(
    'name'=>'orderby',
    'title'=>esc_html__('Order by','dzsap'),
    'description'=>esc_html__('choose an order','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>array(
      array(
        'label'=>esc_html__("Custom",'dzsap'),
        'value'=>'custom',
      ),
      array(
        'label'=>esc_html__("Random",'dzsap'),
        'value'=>'rand',
      ),
      array(
        'label'=>esc_html__("Ratings score",'dzsap'),
        'value'=>'ratings_score',
      ),
      array(
        'label'=>esc_html__("Ratings number",'dzsap'),
        'value'=>'ratings_number',
      ),
    ),

  ),
  array(
    'name'=>'gallery_play_in_footer_player',
    'title'=>esc_html__('Play target','dzsap'),
    'description'=>esc_html__('choose if players play inline or play in the footer player','dzsap'),
    'type'=>'select',
    'category'=>'main',
    'options'=>array(
      array(
        'label'=>esc_html__("Inline",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Footer / sticky player",'dzsap'),
        'value'=>'on',
      ),
    ),

  ),

  array(
    'name'=>'bgcolor',
    'title'=>esc_html__('Background Color','dzsap'),
    'category'=>'appearence',
    'description'=>esc_html__('for tag color ','dzsap'),
    'type'=>'color',
  ),
  array(
    'name'=>'disable_player_navigation',
    'title'=>esc_html__('Disable Player Navigation','dzsap'),
    'category'=>'appearence',
    'description'=>esc_html__('Disable arrows for gallery navigation on the player','dzsap'),
    'type'=>'select',
    'options'=>$arr_off_on,
  ),
  array(
    'name'=>'enable_bg_wrapper',
    'title'=>esc_html__('Enable background wrapper','dzsap'),
    'category'=>'appearence',
    'description'=>wp_kses(sprintf(__('Enable a background wrapper for all the gallery, as seen %shere%s','dzsap'),'<a href="https://previews.envatousercontent.com/files/242206229/index-gallery.html" target="_blank">','</a>'),$dzsap->allowed_tags),
    'type'=>'select',
    'options'=>$arr_off_on,
  ),
  array(
    'name'=>'menuposition',
    'title'=>esc_html__('Menu Position','dzsap'),
    'description'=>esc_html__('Menu Position if the mode allows it','dzsap'),

    'type'=>'select',
    'category'=>'menu',
    'options'=>array(
      array(
        'label'=>esc_html__("Bottom",'dzsap'),
        'value'=>'bottom',
      ),
      array(
        'label'=>esc_html__("Top",'dzsap'),
        'value'=>'top',
      ),
      array(
        'label'=>esc_html__("Hide",'dzsap'),
        'value'=>'none',
      ),
    ),
  ),
  array(
    'name'=>'design_menu_state',
    'title'=>esc_html__('Menu State','dzsap'),
    'description'=>esc_html__('If you set this to closed, you should enable the <strong>Menu State Button</strong> below. ','dzsap'),

    'type'=>'select',
    'category'=>'menu',
    'options'=>array(
      array(
        'label'=>esc_html__("Open",'dzsap'),
        'value'=>'open',
      ),
      array(
        'label'=>esc_html__("Closed",'dzsap'),
        'value'=>'closed',
      ),

    ),
  ),
  array(
    'name'=>'design_menu_show_player_state_button',
    'title'=>esc_html__('Menu State Button','dzsap'),
    'description'=>esc_html__('If you set this to closed, you should enable the <strong>Menu State Button</strong> below. ','dzsap'),

    'type'=>'select',
    'category'=>'menu',
    'options'=>$arr_off_on,
  ),
  array(
    'name'=>'menu_facebook_share',
    'title'=>esc_html__('Facebook Share','dzsap'),
    'description'=>esc_html__('enable a facebook share button in the menu ','dzsap'),

    'type'=>'select',
    'category'=>'menu',
    'options'=>array(
      array(
        'label'=>esc_html__("Auto",'dzsap'),
        'value'=>'auto',
      ),
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
  ),
  array(
    'name'=>'menu_like_button',
    'title'=>esc_html__('Like button','dzsap'),
    'description'=>esc_html__('enable a like button in the menu ','dzsap'),

    'type'=>'select',
    'category'=>'menu',
    'options'=>array(
      array(
        'label'=>esc_html__("Auto",'dzsap'),
        'value'=>'auto',
      ),
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
  ),
  array(
    'name'=>'design_menu_height',
    'title'=>esc_html__('Menu Maximum Height','dzsap'),
    'description'=>sprintf(esc_html__('input a height in pixels / or input %s to show all menu items','dzsap'),'<strong>auto</strong>'),


    'type'=>'text',
    'category'=>'menu',

  ),
  array(
    'name'=>'cuefirstmedia',
    'title'=>esc_html__('Cue First media','dzsap'),


    'type'=>'select',
    'category'=>'autoplay',
    'options'=>array(
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
    ),
  ),
  array(
    'name'=>'autoplay',
    'title'=>esc_html__('Autoplay','dzsap'),


    'type'=>'select',
    'category'=>'autoplay',
    'options'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
  ),
  array(
    'name'=>'autoplay_next',
    'title'=>esc_html__('Autoplay next','dzsap'),


    'type'=>'select',
    'category'=>'autoplay',
    'options'=>array(
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
    ),
  ),


  array(
    'name'=>'mode_normal_video_mode',
    'title'=>esc_html__('Playlist mode','dzsap'),
    'description'=>esc_html__('(beta)','dzsap'). ' '.esc_html__('setting this to on will enable autoplay next video on mobile - plus it will only use one player for the playlist','dzsap'),

    'type'=>'select',
    'category'=>'autoplay',
    'options'=>array(
      array(
        'label'=>esc_html__("Multiple players",'dzsap'),
        'value'=>'',
      ),
      array(
        'label'=>esc_html__("One player",'dzsap'),
        'value'=>'one',
      ),
    ),
  ),

  array(
    'name'=>'enable_views',
    'title'=>esc_html__('Enable play count','dzsap'),


    'type'=>'select',
    'category'=>'counters',
    'options'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
  ),
  array(
    'name'=>'enable_downloads_counter',
    'title'=>esc_html__('Enable downloads counter','dzsap'),


    'type'=>'select',
    'category'=>'counters',
    'options'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
  ),
  array(
    'name'=>'enable_likes',
    'title'=>esc_html__('Enable like count','dzsap'),


    'type'=>'select',
    'category'=>'counters',
    'options'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
  ),
  array(
    'name'=>'enable_rates',
    'title'=>esc_html__('Enable rating','dzsap'),


    'type'=>'select',
    'category'=>'counters',
    'options'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsap'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsap'),
        'value'=>'on',
      ),
    ),
  ),
);