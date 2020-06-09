<?php

function dzsap_cs_home_before() {
  global $dzsap;
  //    echo 'hmmdada';
  // -- enqueue in cusotmizer

  wp_enqueue_script('dzsap-admin-for-cornerstone', $dzsap->base_url . 'assets/admin/admin-for-cornerstone.js', array('jquery'));
  wp_enqueue_script('dzsap-admin-global', $dzsap->base_url . 'admin/admin_global.js', array('jquery'));
  wp_enqueue_style('dzsap-admin-global', $dzsap->base_url . 'admin/admin_global.css');

}


function dzsap_cs_register_elements() {
  global $dzsap;

//        echo 'ceva';

//        error_log('register_elements');
  cornerstone_register_element('CS_DZSAP', 'dzsap', $dzsap->base_path . 'cs/dzsap');
  cornerstone_register_element('CS_DZSAP_PLAYLIST', 'dzsap_playlist', $dzsap->base_path . 'cs/dzsap_playlist');
//        cornerstone_register_element( 'CS_DZSAP_PLAYLIST', 'dzsap_playlist', $dzsap->base_path . 'includes/dzsap_playlist' );

}

function dzsap_cs_enqueue() {
  global $dzsap;
  $dzsap->enqueue_main_scripts();


}

function dzsap_cs_icon_map($icon_map) {
  global $dzsap;
  $icon_map['dzsap'] = DZSAP_BASE_URL . '/assets/svg/icons.svg';
  return $icon_map;
}