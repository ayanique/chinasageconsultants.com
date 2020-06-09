<?php
/// --  important: settings must have the class mainsetting
$this->sliderstructure = '<div class="slider-con" style="display:none;">

        <div class="settings-con">
        <h4>' . __('General Options', 'dzsap') . '</h4>
        <div class="setting type_all">
            <div class="setting-label">' . __('ID', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting main-id" name="0-settings-id" value="default"/>
            <div class="sidenote">' . __('Choose an unique id.', 'dzsap') . '</div>
        </div>
        
        
        <div class="setting type_all">
            <div class="setting-label">' . __('Gallery Skin', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-galleryskin">
                <option>skin-wave</option>
                <option>skin-default</option>
                <option>skin-aura</option>
            </select>
        </div>
        <div class="setting type_all vpconfig-wrapper">
            <div class="setting-label">' . __('ZoomSounds Player Configuration', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme vpconfig-select" name="0-settings-vpconfig">
                <option value="default">' . __('default', 'dzsap') . '</option>
                ' . $this->vpconfigsstr . '
            </select>
            <div class="sidenote" style="">' . __('setup these inside the <strong>ZoomSounds Player Configs</strong> admin', 'dzsap') . ' <a rel="nofollow" id="quick-edit" class="quick-edit-vp" href="' . admin_url('admin.php?page=' . $this->pageName_legacy_sliders_admin_vpconfigs . '&currslider=0&from=shortcodegenerator') . '" class="sidenote" style="cursor:pointer;">' . __("Quick Edit ") . '</a></div>
            <div class="edit-link-con"></div>
        </div>';


$lab = 'mode';
$this->sliderstructure .= '<div class="setting type_all">
            <div class="setting-label">' . __('Mode', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme dzs-dependency-field" name="0-settings-' . $lab . '">
                <option value="mode-normal">' . __("Default") . '</option>
                <option value="mode-showall">' . __("Show All") . '</option>
            </select>
            <div class="sidenote">' . sprintf(__('%sshow all%s lists the players one below the other ', 'dzsap'), '<strong>', '</strong>') . '</div>
        </div>';


$dependency = array(

  array(
    'element' => '0-settings-mode',
    'value' => array('mode-normal'),
  ),
);

$aux = json_encode($dependency);
$aux_dependency_for_mode_normal = str_replace('"', '{quotquot}', $aux);


$dependency = array(

  array(
    'element' => '0-settings-mode',
    'value' => array('mode-showall'),
  ),
);

$aux = json_encode($dependency);
$aux_dependency_for_mode_show_all = str_replace('"', '{quotquot}', $aux);


/*
 *
 *
 *
 *
 */


/*
 *
<div class="setting type_all">
  <div class="setting-label">' . __('Player Navigation', 'dzsap') . '</div>
  <select class="textinput mainsetting styleme" name="0-settings-player_navigation">
    <option value="default">' . __('Default', 'dzsap') . '</option>
    <option value="off">' . __('Force Disable', 'dzsap') . '</option>
    <option value="on">' . __('Force Enable', 'dzsap') . '</option>
  </select>
  <div class="sidenote">' . __('Default will decide automatically if the player needs navigation or no', 'dzsap') . '</div>
</div>
 *
 *
 */

$this->sliderstructure .= '
        
        
        <div class="setting type_all" data-dependency=&quot;' . $aux_dependency_for_mode_show_all . '&quot;>
            <div class="setting-label">' . __('Enable number indicator', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-settings_mode_showall_show_number">
                <option value="on">' . __('on', 'dzsap') . '</option>
                <option value="off">' . __('off', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('Disable arrows for gallery navigation on the player ', 'dzsap') . '</div>
        </div>
        
        
        
        <div class="setting">
            <div class="setting-label">' . __('Background', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting with-colorpicker" name="0-settings-bgcolor" value="transparent"/><div class="picker-con"><div class="the-icon"></div><div class="picker"></div></div>
        </div>
        
        
        
        <div class="setting type_all">
            <div class="setting-label">' . __('Linking', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-settings_enable_linking">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('when selecting a track in the menu the link will update to reflect the new track selected', 'dzsap') . '</div>
        </div>
        
        
        <div class="setting type_all">
            <div class="setting-label">' . __('Order by', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-orderby">
                <option value="custom">' . __('default', 'dzsap') . '</option>
                <option value="rand">' . __('random', 'dzsap') . '</option>
                <option value="ratings">' . __('ratings', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('random or drag and drop', 'dzsap') . '</div>
        </div>
        
        
        
        
        
        <br>
        <div class="dzstoggle toggle1" rel=""  data-dependency=&quot;' . $aux . '&quot;>
<div class="toggle-title" style="">' . __('Menu Options', 'dzsap') . '</div>
<div class="toggle-content">


<div class="setting type_all" data-dependency=&quot;' . $aux . '&quot;>
            <div class="setting-label">' . __('Menu Position', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-menuposition">
                <option>bottom</option>
                <option>none</option>
                <option>top</option>
            </select>
        </div>
        <div class="setting type_all" data-dependency=&quot;' . $aux . '&quot; >
            <div class="setting-label">' . __('Menu State', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-design_menu_state">
                <option value="open">' . __("Open") . '</option>
                <option value="closed">' . __("Closed") . '</option>
            </select>
            <div class="sidenote">' . __('If you set this to closed, you should enable the <strong>Menu State Button</strong> below. ', 'dzsap') . '</div>
        </div>
        <div class="setting type_all" data-dependency=&quot;' . $aux . '&quot;>
            <div class="setting-label">' . __('Menu State Button', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-design_menu_show_player_state_button">
                <option>off</option>
                <option>on</option>
            </select>
        </div>
        <div class="setting type_all" >
            <div class="setting-label">' . __('Facebook Share', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-menu_facebook_share">
                <option>auto</option>
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">' . __('enable a facebook share button in the menu ', 'dzsap') . '</div>
        </div>
        <div class="setting type_all" >
            <div class="setting-label">' . __('Like Button', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-menu_like_button">
                <option>auto</option>
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">' . __('enable a like button in the menu ', 'dzsap') . '</div>
        </div>


</div>
</div>


        <div class="dzstoggle toggle1" rel="">
<div class="toggle-title" style="">' . __('Autoplay Options', 'dzsap') . '</div>
<div class="toggle-content">


        <div class="setting type_all">
            <div class="setting-label">' . __('Cue First Media', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-cuefirstmedia">
                <option value="on">' . __('on', 'dzsap') . '</option>
                <option value="off">' . __('off', 'dzsap') . '</option>
            </select>
        </div>

        <div class="setting type_all">
            <div class="setting-label">' . __('Autoplay', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-autoplay">
                <option value="on">' . __('on', 'dzsap') . '</option>
                <option value="off">' . __('off', 'dzsap') . '</option>
            </select>
        </div>
        
        
        
        <div class="setting type_all">
            <div class="setting-label">' . __('Autoplay Next', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-autoplaynext">
                <option value="on">' . __('on', 'dzsap') . '</option>
                <option value="off">' . __('off', 'dzsap') . '</option>
            </select>
        </div>
</div>
</div>
        
        
        <div class="dzstoggle toggle1" rel="">
<div class="toggle-title" style="">' . __('Play / Like Settings', 'dzsap') . '</div>
<div class="toggle-content">


<div class="setting type_all">
            <div class="setting-label">' . __('Enable Play Count', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_views">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('enable play count - warning: the media file has to be attached to a library item ( the Link To Media field .. ) ', 'dzsap') . '</div>
        </div>


<div class="setting type_all">
            <div class="setting-label">' . __('Enable Downloads Counter', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_downloads_counter">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('enable download count - warning: the media file has to be attached to a library item ( the Link To Media field .. ) ', 'dzsap') . '</div>
        </div>

        <div class="setting type_all">
            <div class="setting-label">' . __('Enable Like Count', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_likes">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('enable like count - warning: the media file has to be attached to a library item ( the Link To Media field .. ) ', 'dzsap') . '</div>
        </div>


        <div class="setting type_all">
            <div class="setting-label">' . __('Enable Rating', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_rates">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('enable rating - warning: the media file has to be attached to a library item ( the Link To Media field .. ) ', 'dzsap') . '</div>
        </div>



</div>
</div>





        
        
        <div class="dzstoggle toggle1" rel="">
<div class="toggle-title" style="">' . __('Force Dimensions', 'dzsap') . '</div>
<div class="toggle-content">


        <div class="setting type_all">
            <div class="setting-label">' . __('Force Width', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-width" value=""/>
            <div class="sidenote">' . __('Force a fix width, leave blank for responsive mode ', 'dzsap') . '</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Force Height', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-height" value=""/>
            <div class="sidenote">' . __('Force a fix height, leave blank for default mode ', 'dzsap') . '</div>
        </div>
        
        
        
        <div class="setting type_all" data-dependency=&quot;' . $aux . '&quot;>
            <div class="setting-label">' . __('Menu Maximum Height', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-design_menu_height" value="default"/>
        </div>
        
</div>
</div>

        

        </div><!--end settings con-->

        <div class="master-items-con mode_all">
        <div class="items-con "></div>
        <a rel="nofollow" href="#" class="add-item"></a>
        </div><!--end master-items-con-->
        <div class="clear"></div>
        </div>';

