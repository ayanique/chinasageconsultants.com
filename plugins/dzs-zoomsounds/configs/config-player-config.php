<?php


return array(

  'disable_volume' => array(
    'category'=>'developer_options',
    'default'=>'default',
    'jsName'=>'disable_volume', // -- js option name, if not default
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),

  'skin_ap' => array(
    'category'=>'developer_options',
    'default'=>'skin-default',
    'jsName'=>'design_skin', // -- js option name, if not default
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'player_pause_method' => array(
    'category'=>'developer_options',
    'default'=>'pause',
    'jsName'=>'pause_method', // -- js option name, if not default
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'playfrom' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'default_volume' => array(
    'category'=>'developer_options',
    'default'=>'default',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'disable_scrubbar' => array(
    'category'=>'developer_options',
    'default'=>'default',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'design_animateplaypause' => array(
    'category'=>'developer_options',
    'default'=>'default',
    'jsName'=>'design_animateplaypause', // -- js option name, if not default
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_dynamicwaves' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'settings_exclude_from_list' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'enable_embed_button' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_enablespectrum' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'jsName'=>'skinwave_enableSpectrum',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_enablereflect' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_mode' => array(
    'category'=>'developer_options',
    'default'=>'normal',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_wave_mode' => array(
    'category'=>'developer_options',
    'default'=>'canvas',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'preload_method' => array(
    'category'=>'developer_options',
    'default'=>'metadata',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_wave_mode_canvas_mode' => array(
    'category'=>'developer_options',
    'default'=>'normal',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_wave_mode_canvas_normalize' => array(
    'category'=>'developer_options',
    'default'=>'on',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'player_navigation' => array(
    'category'=>'developer_options',
    'default'=>'default',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'restyle_player_over_400' => array(
    'category'=>'developer_options',
    'default'=>'',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'restyle_player_under_400' => array(
    'category'=>'developer_options',
    'default'=>'',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),

  'skinwave_timer_static' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'design_wave_color_bg' => array(
    'category'=>'developer_options',
    'default'=>'',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'design_wave_color_progress' => array(
    'category'=>'developer_options',
    'default'=>'',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_wave_mode_canvas_waves_number' => array(
    'category'=>'developer_options',
    'default'=>'',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_wave_mode_canvas_waves_padding' => array(
    'category'=>'developer_options',
    'default'=>'',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_wave_mode_canvas_reflection_size' => array(
    'category'=>'developer_options',
    'default'=>'',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'preview_on_hover' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
  'skinwave_comments_enable' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),

  'autoplay' => array(
    'category'=>'developer_options',
    'default'=>'off',
    'type'=>'select',
    'select_type'=>'  ',
    'title'=>esc_html__('Enable legacy','dzsvg').' <strong>Gutenberg</strong> '.esc_html__('blocks','dzsvg'),
    'extra_classes'=>'',
    'sidenote'=>__("select the type of media"),
    'choices'=>array(
      array(
        'label'=>esc_html__("Disable",'dzsvg'),
        'value'=>'off',
      ),
      array(
        'label'=>esc_html__("Enable",'dzsvg'),
        'value'=>'on',
      ),
    ),
  ),
);