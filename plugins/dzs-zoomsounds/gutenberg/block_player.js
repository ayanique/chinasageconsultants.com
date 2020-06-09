/**
 * Block dependencies
 */

// import classnames from 'classnames'; 2

/**
 * Internal block libraries
 */


import './block_player.scss';
import * as configSampleData from './configs/config-samples';
import * as helpers from './js_common/_helpers';
import CustomInspectorControls from './js_dzsap/CustomInspectorControls';

let __ = (arg) => {
  return arg;
};

if (wp.i18n) {
  __ = wp.i18n.__;
}

const {registerBlockType} = wp.blocks;

const {
  RichText,
  PlainText,
  InspectorControls,
  MediaUpload
} = wp.editor;

const {
  TextControl,
  SelectControl,
} = wp.components;

/**
 * Register block
 */

const player_controls = [];
let arr_options = [];
let player_inspector_controls = null;
let player_attributes = {
  text_string: {
    type: 'string',
  },
  button: {
    type: 'string',
    default: 'button',
  },
  examples_con_opened: {
    type: 'boolean',
    default: false,
  },
  backgroundimage: {
    type: 'string',
    default: null, // no image by default!
  }
};
window.addEventListener('load', function () {


  try {
    arr_options = JSON.parse(window.dzsap_settings.player_options);
  } catch (err) {
    console.info('err - ', err, window.dzsap_settings.player_options);
  }
  // console.info('arr_options_player -6 ',arr_options);


  // arr_options.forEach(function(el4,ind) {window.dzsvg_gutenberg_player_options_for_js_init
  //   console.info('el4 - ', el4);
  // })
  // console.info('player_controls- ',player_controls);

  arr_options.forEach((el) => {


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

    // console.log('aux.type - ',aux.type);

    if (aux.type == 'string') {
      player_attributes[el.name] = aux;
    }
  })
});


// console.info('player_attributes - ',player_attributes);
console.info('window.dzsap_gutenberg_player_options_for_js_init - ', window.dzsap_gutenberg_player_options_for_js_init);

export default registerBlockType('dzsap/gutenberg-player', {
  // Block Title
  title: 'ZoomSounds ' + __('Player'),
  // Block Description
  description: __('Powerful audio player'),
  // Block Category
  category: 'common',
  // Block Icon
  icon: 'format-audio',
  // Block Keywords
  keywords: [
    __('Audio player'),
    __('Sound'),
    __('Song'),
  ],
  attributes: window.dzsap_gutenberg_player_options_for_js_init,
  // Defining the edit interface
  edit: props => {
    const {
      attributes
    } = props;

    const onChangeTweet = value => {
      props.setAttributes({artistname: value});
    };

    const ALLOWED_MEDIA_TYPES = ['audio'];


    // console.log('lets wee what props we have',props);

    let uploadButtonLabel = __('Upload');

    if (props.attributes.dzsap_meta_item_source || props.attributes.source) {
      uploadButtonLabel = __('Select another upload');
    }

    let uploadSongLabel = __('Upload song');


    player_inspector_controls = (
      <CustomInspectorControls
        arr_options={arr_options}
        uploadButtonLabel={uploadButtonLabel}
        {...props}
      />
    );

    // console.info('player_inspector_controls- ',player_inspector_controls);


    function dzsap_setShortcodeAttribute(args) {
      props.setAttributes(args);
    }

    const import_sample = (arg) => {
      // console.log(this, arg);

      if (arg && arg.getAttribute('data-the-name')) {

        // console.log(arg.getAttribute('data-the-name'));
        var theName = arg.getAttribute('data-the-name');
        helpers.postAjax(dzsap_settings.siteurl + '?dzsap_action=dzsap_import_vp_config', 'name=' + theName, (arg) => {

          dzsap_setShortcodeAttribute({source: 'https://zoomthe.me/tests/sound-electric.mp3'});
          dzsap_setShortcodeAttribute({config: theName});
          dzsap_setShortcodeAttribute({artistname: theName});
          dzsap_setShortcodeAttribute({examples_con_opened: !props.attributes.examples_con_opened});


          if (theName === 'sample--boxed-inside') {
            // props.setAttribute()

            dzsap_setShortcodeAttribute({wrapper_image_type: "zoomsounds-wrapper-bg-bellow"});
            dzsap_setShortcodeAttribute({wrapper_image: "https://zoomthe.me/tests/bg_blur.jpg"});

          }
        });
      }
    };

    const examples_con_opened = props.attributes.examples_con_opened;
    const arr_examples = configSampleData.arr_examples;
    const self = this;
    // console.log('props -5 ',props);
    return [
      !!props.isSelected && (
        <InspectorControls key="inspector">
          {player_inspector_controls}
        </InspectorControls>
      ),
      <div className={props.className}>
        <div className={(props.attributes.theme ? 'gt-zoomsounds-main-con-alt' : 'gt-zoomsounds-main-con')}>
          <div className="zoomsounds-containers">
            <h4>{__('Zoomsounds Player')}</h4>
            <div className="react-setting-container">
              <div className="react-setting-container--label">{__('Artist name')}</div>
              <div className="react-setting-container--control">
                <RichText
                  format="string"
                  formattingControls={[]}
                  placeholder={__('Input artist name')}
                  onChange={onChangeTweet}
                  value={props.attributes.artistname}
                />
              </div>
            </div>
            <div className="react-setting-container">
              <div className="react-setting-container--label">{__('Song name')}</div>
              <div className="react-setting-container--control">
                <RichText
                  format="string"
                  formattingControls={[]}
                  placeholder={__('Input song name')}
                  onChange={(val) => props.setAttributes({the_post_title: val})}
                  value={props.attributes.the_post_title}
                />
              </div>
            </div>
            <div className="react-setting-container">
              <div className="react-setting-container--label">{__('Song source')}</div>
              <div className="react-setting-container--control">
                <MediaUpload
                  onSelect={(imageObject) => {
                    // console.log('imageObject - ', imageObject);
                    props.setAttributes({source: imageObject.url});
                    props.setAttributes({playerid: imageObject.id});
                    // console.info(' props - ', props);
                  }}
                  allowedTypes={['audio']}
                  value={props.attributes.source} // make sure you destructured backgroundImage from props.attributes!
                  render={({open}) => (
                    <div className="render-song-selector">
                      {props.attributes.source ? (
                        <RichText
                          format="string"
                          formattingControls={[]}
                          placeholder={__('Input song name')}
                          onChange={(val) => {
                            props.setAttributes({source: val});
                            props.setAttributes({playerid: ''});
                          }}
                          value={props.attributes.source}
                        />
                      ) : ""}
                      <button className="button-secondary" onClick={open}>{uploadSongLabel}</button>
                    </div>
                  )}
                />
              </div>
            </div>

            <div className={examples_con_opened ? "gt-zoomsounds-examples-con opened" : "gt-zoomsounds-examples-con "}>
              <h6 onClick={() => {
                // console.log('click', props.attributes.examples_con_opened, props);

                props.setAttributes({examples_con_opened: !props.attributes.examples_con_opened});
              }}>{__('Examples')} <span className={"the-icon"}> &#x025BF;</span></h6>
              <div className={"sidenote"}>{__('Import examples with one click')}</div>
              <div className={"dzs-player-examples-con"}>
                {arr_examples.map((el) => {
                  return (
                    <div className={"dzs-player-example"} onClick={(e) => {
                      import_sample(e.currentTarget)
                    }} data-the-name={el.name}>
                      <img className={"the-img"} src={dzsap_settings.thepath + el.img}/>
                      <h6 className={"the-label"}>{el.label}</h6>
                    </div>
                  )
                })}
              </div>
            </div>

          </div>

          <p>
            <a className="ctt-btn">
              {props.attributes.button}
            </a>
          </p>
        </div>
      </div>
    ];
  },
  // Defining the front-end interface
  save() {
    // Rendering in PHP
    return null;
  },
});
