function dzsap_receiver(arg){
  var aux = '';
  var bigaux = '';
  //console.log(arg);
  if(window.console) { console.info(arg); };

  //console.log(jQuery('#dzspb-pagebuilder-con'), jQuery('#dzspb-pagebuilder-con').css);
  if(jQuery('#dzspb-pagebuilder-con').length > 0 && jQuery('#dzspb-pagebuilder-con').eq(0).css('display')=='block' && typeof top.dzspb_lastfocused!='undefined'){
    jQuery(top.dzspb_lastfocused).val(arg);
    jQuery(top.dzspb_lastfocused).trigger('change');
  }else{
    //console.info(window.tinyMCE.activeEditor)





    console.info(window.mceeditor_sel, ' --- ', window.htmleditor_sel,jQuery('#wp-content-wrap').hasClass('tmce-active'));

    var ed = null;

    if(jQuery('#wp-content-wrap').hasClass('tmce-active') && window.tinyMCE ){

      ed = window.tinyMCE.activeEditor;
    }else{
      if(window.tinyMCE && window.tinyMCE.activeEditor){
        ed = window.tinyMCE.activeEditor;
      }
    }

    if(ed){
      if(window.mceeditor_sel && window.mceeditor_sel!='notset'){
        if(typeof window.tinyMCE!='undefined'){


          if(typeof window.tinyMCE.activeEditor!='undefined') {
            // window.tinyMCE.activeEditor.selection.moveToBookmark(window.tinymce_cursor);
          }

          // var ed = window.tinyMCE.get('content')

          console.info("CEVA");
          if(typeof window.tinyMCE.execInstanceCommand!='undefined') {
            console.info("CEVA1", el);
            window.tinyMCE.execInstanceCommand(ed.id, 'mceInsertContent', false, arg);
          }else{

            console.info("CEVA2", ed, ed.selection, ed.selection.getContent());
            if(ed && ed.execCommand) {
              console.info("CEVA21");
              ed.execCommand('mceReplaceContent',false, arg);

              if(window.remember_sel){

                // ed.dom.remove(ed.dom.select('div')[0])
                ed.dom.remove(window.remember_sel);

                window.remember_sel = null;
              }
              // window.tinyMCE.get('content').execCommand('mceInsertContent', false, arg);
            }else{

              console.info("CEVA22");
              window.tinyMCE.execCommand('mceReplaceContent',false, arg);
            }
          }
        }


      }else{

        window.tinyMCE.execCommand('mceReplaceContent',false, arg);
      }
    }else{
      aux = jQuery("#content").val();
      bigaux = aux+arg;
      if(window.htmleditor_sel!=undefined && window.htmleditor_sel!=''){
        bigaux = aux.replace(window.htmleditor_sel,arg);
      }
      jQuery("#content").val( bigaux );
    }
  }
  //console.log(bigaux);
  close_ultibox();
}


window.dzsap_prepare_footer_player = function(){
  jQuery('*[name=dzsap_footer_featured_media]').val('fake');
  jQuery('*[name=dzsap_footer_vpconfig]').val('footer-player');
  jQuery('*[name=dzsap_footer_type]').val('fake');
  jQuery('*[name=dzsap_footer_vpconfig]').trigger('change');
}


window.set_curr_page_footer_player = function(c){

  jQuery('*[name=dzsap_footer_enable]').prop('checked',true);
  // jQuery('*[name=dzsap_footer_enable]').trigger('click');
  jQuery('*[name=dzsap_footer_enable]').trigger('change');
  jQuery('*[name=dzsap_footer_feed_type]').val('parent');
  jQuery('*[name=dzsap_footer_feed_type]').trigger('change');
  jQuery('*[name=dzsap_footer_vpconfig]').val(c.src);
  jQuery('*[name=dzsap_footer_vpconfig]').trigger('change');

  console.info('jQuery(\'*[name=dzsap_footer_enable]\') - ',jQuery('*[name=dzsap_footer_enable]'),window);
}