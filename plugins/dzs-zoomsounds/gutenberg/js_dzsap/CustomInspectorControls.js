import React from 'react';

const {
  TextControl,
  SelectControl,
} = wp.components;

let __ = (arg) => {
  return arg;
};

if (wp.i18n) {
  __ = wp.i18n.__;
}
const {
  PlainText,
  MediaUpload
} = wp.editor;

export default class CustomInspectorControls extends React.Component {
  constructor(props) {
    super(props);
    this.props = props;
    // console.log('this.props - ', this.props);
  }

  render() {

    const ALLOWED_MEDIA_TYPES = ['audio'];
    let uploadSongLabel = __('Upload song');
    // const self = this;
    return (
      <div className={"components-panel__body is-opened zoomsounds--components-panel__body "}>
        {
          this.props.arr_options.map((el4) => {

            // console.log('el4 - ', el4);
            if (el4.name == 'dzsap_meta_item_source' || el4.name == 'source' || el4.name == 'item_source') {
              return '';
            }
            const props = this.props;

            var args = {
                label: el4.title,
                value: props.attributes[el4.name] ? props.attributes[el4.name] : '',
                instanceId: el4.name,
                onChange: (value) => {
                  props.setAttributes({[el4.name]: value});
                }
                // onChange: (e,arg2) => {console.info(this, e,arg2); onValueChange(e,this)}
              }
            ;


            let Sidenote = null;

            if (el4.sidenote) {
              Sidenote = (
                <div className="sidenote" dangerouslySetInnerHTML={{__html: el4.sidenote}}/>
              )
            }


            if (el4.type == 'text') {
              const atts = {
                className: "zoomsounds-inspector-setting type-"
              };

              atts.className += el4.type;
              return (
                <div {...atts}>
                  <TextControl
                    {...args}
                  />
                  {Sidenote}
                </div>
              )
                ;
            }
            if (el4.type == 'select') {

              if (el4.choices && !(el4.options)) {
                el4.options = el4.choices;
              }

              // delete args.instanceId ;

              // args.options = el4.options;
              // console.info('select args - ',args);
              // console.info('el4.options - ',el4.options);
              const atts = {
                className: "zoomsounds-inspector-setting type-"
              };

              atts.className += el4.type;
              return (
                <div {...atts}>
                  <SelectControl
                    {...args}
                    options={el4.options}
                  />
                  {Sidenote}
                </div>

              )
                ;
            }


            if (el4.type == 'attach') {

              if (el4.upload_type) {

                // args.type = el4.upload_type;
                args.allowedTypes = [el4.upload_type];
              }
              args.onChange = null;


              if (props.attributes[el4.name]) {
                uploadSongLabel = __('Select another upload');
              }

              return (
                <div className="zoomsounds-inspector-setting type-attach">
                  <label className="components-base-control__label">{el4.title}</label>
                  <MediaUpload
                    {...args}
                    onSelect={(imageObject) => {
                      console.log('imageObject - ', imageObject);
                      props.setAttributes({[el4.name]: imageObject.url});
                      console.info(' props - ', props);
                    }}
                    render={({open}) => (
                      <div className="render-song-selector">
                        {props.attributes[el4.name] ? (
                          <PlainText
                            format="string"
                            formattingControls={[]}
                            placeholder={__('Input song name')}
                            onChange={(val) => props.setAttributes({[el4.name]: val})}
                            value={props.attributes[el4.name]}
                          />
                        ) : ""}
                        <button className="button-secondary" onClick={open}>{this.props.uploadButtonLabel}</button>
                      </div>
                    )}
                  />
                </div>
              )
                ;
            }


          })
        }
      </div>
    )
;

  }
}