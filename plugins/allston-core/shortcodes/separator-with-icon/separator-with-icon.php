<?php
namespace AllstonCore\CPT\Shortcodes\SeparatorWithIcon;

use AllstonCore\Lib;

class SeparatorWithIcon implements Lib\ShortcodeInterface {

    private $base;

    function __construct() {
        $this->base = 'eltdf_separator_with_icon';
        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {

        vc_map(
            array(
                'name'                    => esc_html__('Separator With Icon', 'allston-core'),
                'base'                    => $this->getBase(),
                'category'                => esc_html__('by ALLSTON', 'allston-core'),
                'icon'                    => 'icon-wpb-separator-with-icon extended-custom-icon',
                'show_settings_on_create' => true,
                'class'                   => 'wpb_vc_separator_with_icon',
                'custom_markup'           => '<div></div>',
                'params'                  => array_merge(
                    \AllstonEltdfIconCollections::get_instance()->getVCParamsArray(),
                    array(
                        array(
                            'type'       => 'colorpicker',
                            'heading'    => esc_html__('Separator Color', 'allston-core'),
                            'param_name' => 'sep_color',
                            'value'      => ''
                        ),
                    )
                )
            ));

    }

    public function render($atts, $content = null) {
        $args = array(
            'sep_color' => ''
        );

        $default_atts = array_merge($args, allston_eltdf_icon_collections()->getShortcodeParams());
        $params       = shortcode_atts($default_atts, $atts);

        $iconPackName = allston_eltdf_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);

        extract($params);

        $params['icon']            = $params[$iconPackName];
        $params['separator_style'] = $this->getSeparatorStyle($params);

        $html = allston_core_get_shortcode_module_template_part('templates/separator-with-icon', 'separator-with-icon', '', $params);

        return $html;
    }

    private function getSeparatorStyle($params) {
        $styles = array();

        if($params['sep_color'] !== '') {
            $styles[] = 'border-top: 1px solid '.$params['sep_color'];
        }

        return $styles;
    }


}
