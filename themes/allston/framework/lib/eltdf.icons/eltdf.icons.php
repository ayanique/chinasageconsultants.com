<?php

include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.iconcollection.interface.php";
include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.fontawesome.php";
include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.fontelegant.php";
include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.ionicons.php";
include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.lineaicons.php";
include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.linearicons.php";
include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.simplelineicons.php";
include ELATED_FRAMEWORK_ROOT_DIR . "/lib/eltdf.icons/eltdf.dripicons.php";

/*
  Class: AllstonEltdfIconCollections
  A class that initializes Elated Icon Collections
 */
class AllstonEltdfIconCollections {
    private static $instance;
    public $iconCollections;
    public $VCParamsArray;
    public $iconPackParamName;

    private function __construct() {
        $this->iconPackParamName = 'icon_pack';
        $this->initIconCollections();
    }

    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Method that adds individual collections to set of collections
     */
    private function initIconCollections() {
        $this->addIconCollection('font_awesome', new AllstonEltdfIconsFontAwesome("Font Awesome", "fa_icon"));
        $this->addIconCollection('font_elegant', new AllstonEltdfIconsFontElegant("Font Elegant", "fe_icon"));
        $this->addIconCollection('ion_icons', new AllstonEltdfIonIcons("Ion Icons", "ion_icon"));
        $this->addIconCollection('linea_icons', new AllstonEltdfLineaIcons('Linea Icons', 'linea_icon'));
        $this->addIconCollection('linear_icons', new AllstonEltdfLinearIcons('Linear Icons', 'linear_icon'));
        $this->addIconCollection('simple_line_icons', new AllstonEltdfSimpleLineIcons('Simple Line Icons', 'simple_line_icon'));
        $this->addIconCollection('dripicons', new AllstonEltdfDripicons('Dripicons', 'dripicon'));
    }

    public function getIconsMetaBoxOrOption($attributes) {
        $scope = '';
        $label = '';
        $parent = '';
        $name = '';
        $defaul_icon_pack = '';
        $default_icon = '';
        $type = '';
        $field_type = '';

        extract($attributes);

        $icon_collections = $this->getCollectionsWithSocialIcons();
	
	    $options = array(
		    'font_awesome'      => esc_html__( 'Font Awesome', 'allston' ),
		    'font_elegant'      => esc_html__( 'Font Elegant', 'allston' ),
		    'ion_icons'         => esc_html__( 'Ion Icons', 'allston' ),
		    'simple_line_icons' => esc_html__( 'Simple Line Icons', 'allston' )
	    );
	
	    if ( $scope == 'regular' ) {
		    $options = array(
			    'font_awesome'      => esc_html__( 'Font Awesome', 'allston' ),
			    'font_elegant'      => esc_html__( 'Font Elegant', 'allston' ),
			    'ion_icons'         => esc_html__( 'Ion Icons', 'allston' ),
			    'linea_icons'       => esc_html__( 'Linea Icons', 'allston' ),
			    'linear_icons'      => esc_html__( 'Linear Icons', 'allston' ),
			    'simple_line_icons' => esc_html__( 'Simple Line Icons', 'allston' ),
			    'dripicons'         => esc_html__( 'Dripicons', 'allston' )
		    );
	    }
	
	    if ( $type == 'meta-box' ) {
		    allston_eltdf_meta_box_add_field(
			    array(
				    'parent'        => $parent,
				    'type'          => 'select' . $field_type,
				    'name'          => $name,
				    'default_value' => $defaul_icon_pack,
				    'label'         => $label,
				    'options'       => $options
			    )
		    );
	    } else if ( $type == 'option' ) {
		    allston_eltdf_add_admin_field(
			    array(
				    'parent'        => $parent,
				    'type'          => 'select' . $field_type,
				    'name'          => $name,
				    'default_value' => $defaul_icon_pack,
				    'label'         => $label,
				    'options'       => $options
			    )
		    );
	    }
	
	    foreach ( $icon_collections as $collection_key => $collection_object ) {
		    if ( $scope == 'regular' ) {
			    $icons_array = $collection_object->getIconsArray();
		    } else {
			    $icons_array = $collection_object->getSocialIconsArray();
		    }
		
		    $icon_collections_keys = array_keys( $icon_collections );
		
		    unset( $icon_collections_keys[ array_search( $collection_key, $icon_collections_keys ) ] );
		
		    $eltdf_icon_hide_values = $icon_collections_keys;
		    array_push( $eltdf_icon_hide_values, '' ); //add empty value for icon switcher
		
		    $eltdf_icon_pack_container = allston_eltdf_add_admin_container(
			    array(
				    'parent'     => $parent,
				    'name'       => $name . '_' . $collection_object->param . '_container',
				    'simple'     => $field_type == 'simple' ? true : false,
				    'dependency' => array(
					    'hide' => array(
						    $name => $eltdf_icon_hide_values
					    )
				    )
			    )
		    );
		
		    if ( $type == 'meta-box' ) {
			    allston_eltdf_meta_box_add_field(
				    array(
					    'parent'        => $eltdf_icon_pack_container,
					    'type'          => 'select' . $field_type,
					    'name'          => $name . '_' . $collection_object->param,
					    'default_value' => $default_icon,
					    'label'         => $collection_object->title,
					    'options'       => $icons_array
				    )
			    );
		    } else if ( $type == 'option' ) {
			    allston_eltdf_add_admin_field(
				    array(
					    'parent'        => $eltdf_icon_pack_container,
					    'type'          => 'select' . $field_type,
					    'name'          => $name . '_' . $collection_object->param,
					    'default_value' => $default_icon,
					    'label'         => $collection_object->title,
					    'options'       => $icons_array
				    )
			    );
		    }
	    }
    }
	
	public function getVCParamsArray( $iconPackDependency = array(), $iconCollectionPrefix = "", $emptyIconPack = false ) {
		if ( $emptyIconPack ) {
			$iconCollectionsVC = $this->getIconCollectionsVCEmpty();
		} else {
			$iconCollectionsVC = $this->getIconCollectionsVC();
		}
		
		$iconPackParams = array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon Pack', 'allston' ),
			'param_name'  => $this->iconPackParamName,
			'value'       => $iconCollectionsVC,
			'save_always' => true
		);
		
		if ( $iconPackDependency !== "" ) {
			$iconPackParams["dependency"] = $iconPackDependency;
		}
		
		$iconPackParams = array( $iconPackParams );
		
		$iconSetParams = array();
		if ( is_array( $this->iconCollections ) && count( $this->iconCollections ) ) {
			foreach ( $this->iconCollections as $key => $collection ) {
				$iconSetParams[] = array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon', 'allston' ),
					'param_name'  => $iconCollectionPrefix . $collection->param,
					'value'       => $collection->getIconsArray(),
					'dependency'  => array( 'element' => $this->iconPackParamName, 'value' => array( $key ) ),
					'save_always' => true
				);
			}
		}
		
		return array_merge( $iconPackParams, $iconSetParams );
	}
	
	public function getSocialVCParamsArray( $iconPackDependency = array(), $iconCollectionPrefix = "", $emptyIconPack = false ) {
		if ( $emptyIconPack ) {
			$iconCollectionsVC = $this->getSocialIconCollectionsVCEmpty();
		} else {
			$iconCollectionsVC = $this->getSocialIconCollectionsVC();
		}
		
		$iconPackParams = array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon Pack', 'allston' ),
			'param_name'  => $this->iconPackParamName,
			'value'       => $iconCollectionsVC,
			'save_always' => true
		);
		
		if ( $iconPackDependency !== "" ) {
			$iconPackParams["dependency"] = $iconPackDependency;
		}
		
		$iconPackParams = array( $iconPackParams );
		
		$iconSetParams = array();
		if ( is_array( $this->iconCollections ) && count( $this->iconCollections ) ) {
			foreach ( $this->iconCollections as $key => $collection ) {
				if($collection->hasSocialIcons()) {
					$iconSetParams[] = array(
						'type'        => 'dropdown',
						'class'       => '',
						'heading'     => esc_html__( 'Icon', 'allston' ),
						'param_name'  => $iconCollectionPrefix . $collection->param,
						'value'       => $collection->getSocialIconsArrayVC(),
						'dependency'  => array( 'element' => $this->iconPackParamName, 'value' => array( $key ) ),
						'save_always' => true
					);
				}
			}
		}
		
		return array_merge( $iconPackParams, $iconSetParams );
	}
	
	public function getIconWidgetParamsArray() {
		
		$iconPackParams[] = array(
			'type'    => 'dropdown',
			'name'    => 'icon_pack',
			'title'   => esc_html__( 'Icon Pack', 'allston' ),
			'options' => array(
				'font_awesome'      => esc_html__( 'Font Awesome', 'allston' ),
				'font_elegant'      => esc_html__( 'Font Elegant', 'allston' ),
				'ion_icons'         => esc_html__( 'Ion Icons', 'allston' ),
				'linea_icons'       => esc_html__( 'Linea Icons', 'allston' ),
				'linear_icons'      => esc_html__( 'Linear Icons', 'allston' ),
				'simple_line_icons' => esc_html__( 'Simple Line Icons', 'allston' ),
				'dripicons'         => esc_html__( 'Dripicons', 'allston' )
			)
		);
		
		$iconSetParams = array();
		if ( is_array( $this->iconCollections ) && count( $this->iconCollections ) ) {
			foreach ( $this->iconCollections as $key => $collection ) {
				$iconSetParams[] = array(
					'type'    => 'dropdown',
					'title'   => $collection->title . esc_html__( ' Icon', 'allston' ),
					'name'    => $collection->param,
					'options' => array_flip( $collection->getIconsArray() )
				);
			}
		}
		
		return array_merge( $iconPackParams, $iconSetParams );
	}
	
	public function getSocialIconWidgetMultipleParamsArray( $count ) {
		$iconOps           = array();
		$iconCollectionsVC = $this->getCollectionsWithSocialIcons();
		
		$iconPackParams[] = array(
			'type'    => 'dropdown',
			'name'    => 'icon_pack',
			'title'   => esc_html__( 'Icon Pack', 'allston' ),
			'options' => array(
				'font_awesome'      => esc_html__( 'Font Awesome', 'allston' ),
				'font_elegant'      => esc_html__( 'Font Elegant', 'allston' ),
				'ion_icons'         => esc_html__( 'Ion Icons', 'allston' ),
				'simple_line_icons' => esc_html__( 'Simple Line Icons', 'allston' ),
			)
		);
		
		for ( $n = 1; $n <= $count; $n ++ ) {
			
			if ( is_array( $iconCollectionsVC ) && count( $iconCollectionsVC ) ) {
				foreach ( $iconCollectionsVC as $key => $collection ) {
					$iconOps[] = array(
						'type'    => 'dropdown',
						'name'    => $collection->param . '_' . $n,
						'title'   => sprintf( esc_html__( 'Icon %s %s Icon', 'allston' ), $n, $collection->title ),
						'options' => array_flip( $collection->getSocialIconsArrayVC() )
					);
				}
			}
			
			$iconOps[] = array(
				'type'  => 'textfield',
				'name'  => 'link_' . $n,
				'title' => sprintf( esc_html__( 'Link %s', 'allston' ), $n )
			);
			
			$iconOps[] = array(
				'type'    => 'dropdown',
				'name'    => 'target_' . $n,
				'title'   => sprintf( esc_html__( 'Link Target %s', 'allston' ), $n ),
				'options' => allston_eltdf_get_link_target_array()
			);
		}
		
		return array_merge( $iconPackParams, $iconOps );
	}
	
	public function getSocialIconWidgetParamsArray() {
		$iconCollectionsVC = $this->getCollectionsWithSocialIcons();
		
		$iconPackParams[] = array(
			'type'    => 'dropdown',
			'title'   => esc_html__( 'Icon Pack', 'allston' ),
			'name'    => 'icon_pack',
			'options' => array(
				'font_awesome'      => esc_html__( 'Font Awesome', 'allston' ),
				'font_elegant'      => esc_html__( 'Font Elegant', 'allston' ),
				'ion_icons'         => esc_html__( 'Ion Icons', 'allston' ),
				'simple_line_icons' => esc_html__( 'Simple Line Icons', 'allston' )
			)
		);
		
		$iconSetParams = array();
		if ( is_array( $iconCollectionsVC ) && count( $iconCollectionsVC ) ) {
			foreach ( $iconCollectionsVC as $key => $collection ) {
				$iconSetParams[] = array(
					'type'    => 'dropdown',
					'title'   => $collection->title . esc_html__( ' Icon', 'allston' ),
					'name'    => $collection->param,
					'options' => array_flip( $collection->getSocialIconsArrayVC() )
				);
			}
		}
		
		return array_merge( $iconPackParams, $iconSetParams );
	}
	
	public function getCollectionsWithIcons() {
		$collectionsWithIcons = array();
		
		foreach ( $this->iconCollections as $key => $collection ) {
			$collectionsWithIcons[ $key ] = $collection;
		}
		
		return $collectionsWithIcons;
	}
	
	public function getCollectionsWithSocialIcons() {
		$collectionsWithSocial = array();
		
		foreach ( $this->iconCollections as $key => $collection ) {
			if ( $collection->hasSocialIcons() ) {
				$collectionsWithSocial[ $key ] = $collection;
			}
		}
		
		return $collectionsWithSocial;
	}
	
	public function getIconSizesArray() {
		return array(
			"Tiny"       => "fa-lg",
			"Small"      => "fa-2x",
			"Medium"     => "fa-3x",
			"Large"      => "fa-4x",
			"Very Large" => "fa-5x"
		);
	}
	
	public function getIconSizeClass( $iconSize ) {
		switch ( $iconSize ) {
			case "fa-lg":
				$iconSize = "eltdf-tiny-icon";
				break;
			case "fa-2x":
				$iconSize = "eltdf-small-icon";
				break;
			case "fa-3x":
				$iconSize = "eltdf-medium-icon";
				break;
			case "fa-4x":
				$iconSize = "eltdf-large-icon";
				break;
			case "fa-5x":
				$iconSize = "eltdf-huge-icon";
				break;
			default:
				$iconSize = "eltdf-small-icon";
		}
		
		return $iconSize;
	}
	
	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function getIconCollectionParamNameByKey( $key ) {
		$collection = $this->getIconCollection( $key );
		
		if ( $collection ) {
			return $collection->param;
		}
		
		return false;
	}
	
	public function getShortcodeParams( $iconCollectionPrefix = "" ) {
		$iconCollectionsParam = array();
		foreach ( $this->iconCollections as $key => $collection ) {
			$iconCollectionsParam[ $iconCollectionPrefix . $collection->param ] = '';
		}
		
		return array_merge( array( $this->iconPackParamName => '', ), $iconCollectionsParam );
	}
	
	public function addIconCollection( $key, $value ) {
		$this->iconCollections[ $key ] = $value;
	}
	
	public function getIconCollection( $key ) {
		if ( array_key_exists( $key, $this->iconCollections ) ) {
			return $this->iconCollections[ $key ];
		}
		
		return false;
	}
	
	public function getIconCollectionIcons( iAllstonEltdfIconCollection $collection ) {
		return $collection->getIconsArray();
	}
	
	public function getIconCollectionsVC() {
		$vc_array = array();
		foreach ( $this->iconCollections as $key => $collection ) {
			$vc_array[ $collection->title ] = $key;
		}
		
		return $vc_array;
	}
	
	public function getSocialIconCollectionsVC() {
		$vc_array = array();
		foreach ( $this->iconCollections as $key => $collection ) {
			if($collection->hasSocialIcons()) {
				$vc_array[ $collection->title ] = $key;
			}
		}
		
		return $vc_array;
	}
	
	public function getIconCollectionsVCExclude( $exclude ) {
		$array = $this->getIconCollectionsVC();
		
		if ( is_array( $exclude ) && count( $exclude ) ) {
			foreach ( $exclude as $key ) {
				if ( ( $x = array_search( $key, $array ) ) !== false ) {
					unset( $array[ $x ] );
				}
			}
			
		} else {
			if ( ( $x = array_search( $exclude, $array ) ) !== false ) {
				unset( $array[ $x ] );
			}
		}
		
		return $array;
	}
	
	public function getIconCollectionsKeys() {
		return array_keys( $this->iconCollections );
	}
	
	/**
	 * Method that returns an array of 'param' attribute of each icon collection
	 * @return array array of param attributes
	 */
	public function getIconCollectionsParams() {
		$paramArray = array();
		if ( is_array( $this->iconCollections ) && count( $this->iconCollections ) ) {
			foreach ( $this->iconCollections as $key => $obj ) {
				$paramArray[] = $obj->param;
			}
		}
		
		return $paramArray;
	}
	
	/**
	 * Method that returns an array of 'param' attribute of each icon collection with social icons
	 * @return array array of param attributes
	 */
	public function getSocialIconCollectionsParams() {
		$paramArray = array();
		
		if ( is_array( $this->getCollectionsWithSocialIcons() ) && count( $this->getCollectionsWithSocialIcons() ) ) {
			foreach ( $this->getCollectionsWithSocialIcons() as $key => $obj ) {
				$paramArray[] = $obj->param;
			}
		}
		
		return $paramArray;
	}
	
	public function getIconCollections() {
		$array = array();
		
		foreach ( $this->iconCollections as $key => $collection ) {
			$array[ $key ] = $collection->title;
		}
		
		return $array;
	}
	
	public function getIconCollectionsEmpty( $no_empty_key = "" ) {
		$array                  = array();
		$array[ $no_empty_key ] = esc_html__( 'No Icon', 'allston' );
		
		foreach ( $this->iconCollections as $key => $collection ) {
			$array[ $key ] = $collection->title;
		}
		
		return $array;
	}
	
	public function getIconCollectionsVCEmpty() {
		$vc_array                                           = array();
		$vc_array[ esc_html__( 'No Icon', 'allston' ) ] = '';
		
		foreach ( $this->iconCollections as $key => $collection ) {
			$vc_array[ $collection->title ] = $key;
		}
		
		return $vc_array;
	}
	
	public function getSocialIconCollectionsVCEmpty() {
		$vc_array                                           = array();
		$vc_array[ esc_html__( 'No Icon', 'allston' ) ] = '';
		
		foreach ( $this->iconCollections as $key => $collection ) {
			if($collection->hasSocialIcons()) {
				$vc_array[ $collection->title ] = $key;
			}
		}
		
		return $vc_array;
	}
	
	public function getIconCollectionsVCEmptyExclude( $key ) {
		$array = $this->getIconCollectionsVCEmpty();
		
		if ( ( $x = array_search( $key, $array ) ) !== false ) {
			unset( $array[ $x ] );
		}
		
		return $array;
	}
	
	public function getIconCollectionsExclude( $exclude ) {
		$array = $this->getIconCollections();
		
		if ( is_array( $exclude ) && count( $exclude ) ) {
			foreach ( $exclude as $exclude_key ) {
				if ( array_key_exists( $exclude_key, $array ) ) {
					unset( $array[ $exclude_key ] );
				}
			}
		} else {
			if ( array_key_exists( $exclude, $array ) ) {
				unset( $array[ $exclude ] );
			}
		}
		
		return $array;
	}
	
	public function hasIconCollection( $key ) {
		return array_key_exists( $key, $this->iconCollections );
	}
	
	/**
	 * Method that renders icon for given icon pack
	 *
	 * @param $icon string to render
	 * @param $iconPack string to render icon from
	 * @param $params array for icon
	 *
	 * @return mixed
	 */
	public function renderIcon( $icon, $iconPack, $params = array() ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconObject = $this->getIconCollection( $iconPack );
			
			return $iconObject->render( $icon, $params );
		}
	}
	
	public function enqueueStyles() {
		if ( is_array( $this->iconCollections ) && count( $this->iconCollections ) ) {
			foreach ( $this->iconCollections as $collection_key => $collection_obj ) {
				wp_enqueue_style( 'eltdf-' . $collection_key, $collection_obj->styleUrl );
			}
		}
	}
	
	# HEADER AND SIDE MENU ICONS
	public function getSearchIcon( $iconPack, $return ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getSearchIcon();
			
			if ( $return ) {
				return $iconHTML;
			} else {
				echo wp_kses_post( $iconHTML );
			}
		}
	}
	
	public function getSearchClose( $iconPack, $return ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getSearchClose();
			
			if ( $return ) {
				return $iconHTML;
			} else {
				echo wp_kses_post( $iconHTML );
			}
		}
	}
	
	public function getDropdownCartIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getDropdownCartIcon();
			
			echo wp_kses_post( $iconHTML );
		}
	}
	
	public function getMenuIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getMenuIcon();
			
			echo wp_kses_post( $iconHTML );
		}
	}
	
	public function getMenuCloseIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getMenuCloseIcon();
			
			echo wp_kses_post( $iconHTML );
		}
	}
	
	public function getBackToTopIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getBackToTopIcon();
			
			echo wp_kses_post( $iconHTML );
		}
	}
	
	public function getMobileMenuIcon( $iconPack, $return = false ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getMobileMenuIcon();
			
			if ( $return ) {
				return $iconHTML;
			} else {
				echo wp_kses_post( $iconHTML );
			}
		}
	}
	
	public function getQuoteIcon( $iconPack, $return = false ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			$iconHTML    = $iconsObject->getQuoteIcon();
			
			if ( $return ) {
				return $iconHTML;
			} else {
				echo wp_kses_post( $iconHTML );
			}
		}
	}
	
	# SOCIAL SIDEBAR ICONS
	public function getFacebookIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			
			return $iconsObject->getFacebookIcon();
		}
	}
	
	public function getTwitterIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			
			return $iconsObject->getTwitterIcon();
		}
	}
	
	public function getGooglePlusIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			
			return $iconsObject->getGooglePlusIcon();
		}
	}
	
	public function getLinkedInIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			
			return $iconsObject->getLinkedInIcon();
		}
	}
	
	public function getTumblrIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			
			return $iconsObject->getTumblrIcon();
		}
	}
	
	public function getPinterestIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			
			return $iconsObject->getPinterestIcon();
		}
	}
	
	public function getVKIcon( $iconPack ) {
		if ( $this->hasIconCollection( $iconPack ) ) {
			$iconsObject = $this->getIconCollection( $iconPack );
			
			return $iconsObject->getVKIcon();
		}
	}
}

if ( ! function_exists( 'allston_eltdf_activate_theme_icons' ) ) {
	function allston_eltdf_activate_theme_icons() {
		global $allston_eltdf_IconCollections;
		$allston_eltdf_IconCollections = AllstonEltdfIconCollections::get_instance();
	}
	
	add_action( 'after_setup_theme', 'allston_eltdf_activate_theme_icons' );
}