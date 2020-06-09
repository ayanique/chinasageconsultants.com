window.api_wavesentfromflash = function(arg){
  console.info(window.waves_fieldtaget, arg);
  if(window.waves_fieldtaget){
    window.waves_filename = window.waves_filename.replace('{{dirname}}', dzsap_settings.theurl_forwaveforms);
    window.waves_filename = window.waves_filename.replace('{{uploaddirname}}', dzsap_settings.theurl_forwaveforms);
    window.waves_filename = window.waves_filename.replace(/%20/g, '');
    window.waves_filename = window.waves_filename.replace(/%C3%A9/g, 'é');
    window.waves_filename = window.waves_filename.replace('%2520', '');
    window.waves_fieldtaget.val(window.waves_filename);
    window.waves_fieldtaget.trigger('change');
    if(window.waves_fieldtaget.next().hasClass('aux-wave-generator')){

      window.waves_fieldtaget.next().find('button').show();
      window.waves_fieldtaget.next().find('object').remove();
    }else{


      if(window.waves_fieldtaget.next().find('.aux-wave-generator').length>0){

        window.waves_fieldtaget.next().find('.aux-wave-generator').find('button').show();
        window.waves_fieldtaget.next().find('.aux-wave-generator').find('object').remove();
      }else{

        window.waves_fieldtaget.next().next().find('button').show();
        window.waves_fieldtaget.next().next().find('object').remove();
      }
    }



  }
  //if(window.console) { console.info(window.waves_fieldtaget,arg); };
}


window.dzsap_flash_waves_init = function(){
  var $ = jQuery;

  $(document).delegate('.btn-autogenerate-waveform-bg', 'click', click_btn_autogenerate_waveform_bg);
  $(document).delegate('.btn-autogenerate-waveform-prog', 'click', click_btn_autogenerate_waveform_prog);
  $(document).delegate('.btn-generate-default-waveform-bg', 'click', click_btn_generate_default_waveform_bg);
  $(document).delegate('.btn-generate-default-waveform-prog', 'click', click_btn_generate_default_waveform_prog);
  $(document).on('click', '.regenerate-waveform, .btn-delete-waveform-data', handle_mouse);

  function handle_mouse(e){

    var _t  = ($(this));

    if(e.type=='click'){


      if(_t.hasClass('btn-delete-waveform-data')){

        var r = confirm('are you sure you want to delete waveforms?');

        if(r){

        }else{
          return false;
        }

      }


      if(_t.hasClass('regenerate-waveform')){

        _t.attr('data-player-source', $('#dzsap_woo_product_track').val()); // -- tbc



        var data = {
          action: 'dzsap_delete_pcm'
          ,playerid: _t.attr('data-playerid')
          ,track_src: $('*[name="dzsap_woo_product_track"]').eq(0).val()
        };



        // console.error("TRY TO GET PCM");



        $.ajax({
          type: "POST",
          url: window.ajaxurl,
          data: data,
          success: function (response) {
            //if(typeof window.console != "undefined" ){ console.log('Ajax - get - comments - ' + response); }

            console.groupCollapsed("receivedResponse");
            console.info(response);
            console.groupEnd();


            _t.after('<iframe src="'+dzsap_settings.siteurl+'/?dzsap_generate_pcm='+_t.attr('data-playerid')+'&dzsap_source='+encodeURIComponent(_t.attr('data-player-source'))+'" width="100%" height="180"></iframe>')


            setTimeout(function(){
              _t.next('iframe').remove();
            },10000);


          },
          error: function (arg) {
            if (typeof window.console != "undefined") {
              console.log('Got this from the server: ' + arg, arg);
            }
            ;
          }
        });





        return false;
      }

    }
  }


  function click_btn_autogenerate_waveform_bg(e){
    var _t = $(this);
    var _themedia = '';
    var _con = null;


    // console.info($('.edd_repeatable_upload_field_container'));
    if($('.edd_repeatable_upload_field_container').length>0){

      var val = $('.edd_repeatable_upload_field_container input').eq(0).val();



      console.info($('*[name*="preview_files[0]"]').eq(0).length);
      if($('*[name*="preview_files[0]"]').eq(0).length && String($('*[name*="preview_files[0]"]').eq(0).val()) &&  (String($('*[name*="preview_files[0]"]').eq(0).val()).indexOf('mp3')> String($('*[name*="preview_files[0]"]').eq(0).val()).length-5 || String($('*[name*="preview_files[0]"]').eq(0).val()).indexOf('soundcloud.com')>-1 )  ) {

        val = $('*[name*="preview_files[0]"]').eq(0).val();
      }

      if(_t.parent().prev().prev().hasClass('aux-file-location')){
        _t.parent().prev().prev().html(val);
      }else{

        _t.parent().prev().before('<div class="aux-file-location">'+val+'</div>');
      }

      if(val.indexOf('soundcloud.com/')>-1){
        _t.parent().parent().parent().addClass('item-settings-con type_soundcloud')
      }
    }


    var initial_source = '';
    var is_souncloud = false;

    if(_t.parent().prev().prev().hasClass('aux-file-location')){
      _themedia = _t.parent().prev().prev().html();
    }else{
      if(_t.parent().parent().parent().find('.main-source').length>0){
        _themedia = _t.parent().parent().parent().find('.main-source').eq(0).val();
      }else{
        //console.log(_t.parent().parent().parent().parent().parent());
        if(_t.parent().parent().parent().parent().parent().hasClass('wc-metaboxes-wrapper')){
          _con = _t.parent().parent().parent().parent().parent();
          _themedia = _con.find('input[name="dzsap_woo_product_track"]').eq(0).val();

          if(_con.parent().hasClass('product_data')){
            if(_con.parent().find('input[name="_wc_file_urls[]"]').length>0){

              if(_con.parent().find('input[name="_wc_file_urls[]"]').eq(0).val() && String(_con.parent().find('input[name="_wc_file_urls[]"]').eq(0).val()).indexOf('.mp3')>String(_con.parent().find('input[name="_wc_file_urls[]"]').eq(0).val()).length-5){

                _themedia=_con.parent().find('input[name="_wc_file_urls[]"]').eq(0).val();
              }
            }
          }
          //console.info(_themedia);

        }
      }
    }

    initial_source = _themedia;

    // console.info(initial_source);

    if(_t.parent().parent().parent().hasClass('item-settings-con')){
      var _con = _t.parent().parent().parent();

      console.info(_con);

      if(_con.hasClass('type_soundcloud') && dzsap_settings.soundcloud_apikey){

        if(_con.attr('data-sc_source')){



          _themedia = encodeURIComponent(dzsap_settings.thepath+'soundcloudretriever.php?scurl=' + _con.attr('data-sc_source'));
          _con.attr('data-sc_source', '');
          is_souncloud = true;

        }else{
          var encoded_themedia = encodeURIComponent(_themedia);
          var aux = 'http://api.' + 'soundcloud.com' + '/resolve?url='+_themedia+'&format=json&consumer_key=' + dzsap_settings.soundcloud_apikey;
          // console.info(aux,_themedia);

          if( (o.design_skin=='skin-wave' && !cthis.attr('data-scrubbg')) || is_ie8()){
            o.skinwave_enableReflect='off';
          }

          aux = encodeURIComponent(aux);
          $.getJSON((dzsap_settings.thepath+'soundcloudretriever.php?scurl='+aux), function(data) {

            console.info(data.stream_url+'?consumer_key='+ dzsap_settings.soundcloud_apikey+'&origin=localhost');

            _con.attr('data-sc_source',data.stream_url+'?consumer_key='+ dzsap_settings.soundcloud_apikey+'&origin=localhost');


            _t.trigger('click');
          });

          return false;
        }



      }
    }



    if(typeof dzsap_settings!='undefined'){

      //console.info(_themedia);

      var s_filename_arr = _themedia.split('/');

      //console.info(s_filename_arr);
      var s_filename = s_filename_arr[s_filename_arr.length-1];

      s_filename = encodeURIComponent(s_filename);
      s_filename = s_filename.replace('.', '');


      if(is_souncloud){
        var auxa = initial_source.split('/');

        // console.info(auxa);
        s_filename = auxa[auxa.length-1];
      }

      window.waves_filename = '{{dirname}}waves/scrubbg_'+s_filename+'.png';

      if(dzsap_settings.theurl_forwaveforms != dzsap_settings.thepath){
        window.waves_filename = '{{uploaddirname}}scrubbg_'+s_filename+'.png';
      }


      ///console.info(s_filename);



      var str_sample_time_start = '';
      var str_sample_time_end = '';
      var str_sample_time_total = '';


      if(_con){
        if(_con.find('.sample-time-start-feeder').length>0){
          if(Number(_con.find('.sample-time-start-feeder').eq(0).val())>0){
            str_sample_time_start='&sample_time_start='+Number(_con.find('.sample-time-start-feeder').eq(0).val());
          }
        }
        if(_con.find('.sample-time-end-feeder').length>0){
          if(Number(_con.find('.sample-time-end-feeder').eq(0).val())>0){
            str_sample_time_end='&sample_time_end='+Number(_con.find('.sample-time-end-feeder').eq(0).val());
          }
        }
        if(_con.find('.sample-time-total-feeder').length>0){
          if(Number(_con.find('.sample-time-total-feeder').eq(0).val())>0){
            str_sample_time_total='&sample_time_total='+Number(_con.find('.sample-time-total-feeder').eq(0).val());
          }
        }
      }

      var aux23 = window.waves_filename;

      if(aux23.indexOf('{{uploaddirname}}')>-1){

        aux23 = dzsap_settings.thepath_forwaveforms+'scrubbg_'+s_filename+'.png';
      }



      //console.log(_themedia);

      var aux='<object type="application/x-shockwave-flash" data="'+dzsap_settings.thepath+'wavegenerator.swf" width="230" height="30" id="flashcontent" style="visibility: visible;"><param name="movie" value="'+dzsap_settings.thepath+'wavegenerator.swf"><param name="menu" value="false"><param name="allowScriptAccess" value="always"><param name="scale" value="noscale"><param name="allowFullScreen" value="true"><param name="wmode" value="opaque"><param name="flashvars" value="settings_multiplier='+dzsap_settings.waveformgenerator_multiplier+'&media='+_themedia+'&savetophp_loc='+dzsap_settings.thepath+'savepng.php&savetophp_pngloc='+aux23+'&savetophp_pngprogloc=waves/scrubprog.png&color_wavesbg='+dzsap_settings.color_waveformbg+'&color_wavesprog='+dzsap_settings.color_waveformprog+'&settings_wavestyle='+dzsap_settings.settings_wavestyle+'&settings_onlyautowavebg=on&settings_enablejscallback=on'+str_sample_time_start+str_sample_time_end+str_sample_time_total+'"></object>';


      _t.parent().append(aux);
      if(_t.parent().prev().hasClass('upload-prev')){
        window.waves_fieldtaget = _t.parent().prev();
      }else{
        if(_t.parent().prev().prev().prev().hasClass('upload-prev')){

          window.waves_fieldtaget = _t.parent().prev().prev().prev();
        }else{

          window.waves_fieldtaget = _t.parent().prev().prev();
        }
      }

      //console.info(_t.parent().parent());
      if(_t.parent().parent().prev().hasClass('upload-target-prev')){

        window.waves_fieldtaget = _t.parent().parent().prev();

      }

      console.warn(window.waves_fieldtaget)


      _t.hide();
    }


    return false;
  }


  function click_btn_autogenerate_waveform_prog(e){
    var _t = $(this);
    var _themedia = '';
    var _con = null;


    var initial_source = '';
    var is_souncloud = false;



    if($('.edd_repeatable_upload_field_container').length>0){

      var val = $('.edd_repeatable_upload_field_container input').eq(0).val();



      if($('*[name*="preview_files[0]"]').eq(0).length && String($('*[name*="preview_files[0]"]').eq(0).val()) && (String($('*[name*="preview_files[0]"]').eq(0).val()).indexOf('mp3')> String($('*[name*="preview_files[0]"]').eq(0).val()).length-5 || String($('*[name*="preview_files[0]"]').eq(0).val()).indexOf('soundcloud.com')>-1 )  ) {

        val = $('*[name*="preview_files[0]"]').eq(0).val();
      }

      if(_t.parent().prev().prev().hasClass('aux-file-location')){
        _t.parent().prev().prev().html(val);
      }else{

        _t.parent().prev().before('<div class="aux-file-location">'+val+'</div>');
      }

      if(val.indexOf('soundcloud.com/')>-1){
        _t.parent().parent().parent().addClass('item-settings-con type_soundcloud')
      }
    }


    if(_t.parent().prev().prev().hasClass('aux-file-location')){
      _themedia = _t.parent().prev().prev().html();
    }else{
      if(_t.parent().parent().parent().find('.main-source').length>0){
        _themedia = _t.parent().parent().parent().find('.main-source').eq(0).val();
      }else{
        //console.log(_t.parent().parent().parent().parent().parent());
        if(_t.parent().parent().parent().parent().parent().hasClass('wc-metaboxes-wrapper')){
          _con = _t.parent().parent().parent().parent().parent();
          _themedia = _t.parent().parent().parent().parent().parent().find('input[name="dzsap_woo_product_track"]').eq(0).val();
          //console.info(_themedia);

        }
      }
    }





    initial_source = _themedia;

    // console.info(initial_source);

    if(_t.parent().parent().parent().hasClass('item-settings-con')){
      var _con = _t.parent().parent().parent();

      console.info(_con);

      if(_con.hasClass('type_soundcloud') && dzsap_settings.soundcloud_apikey){

        if(_con.attr('data-sc_source')){



          _themedia = encodeURIComponent(dzsap_settings.thepath+'soundcloudretriever.php?scurl=' + _con.attr('data-sc_source'));
          _con.attr('data-sc_source', '');
          is_souncloud = true;

        }else{
          var encoded_themedia = encodeURIComponent(_themedia);
          var aux = 'http://api.' + 'soundcloud.com' + '/resolve?url='+_themedia+'&format=json&consumer_key=' + dzsap_settings.soundcloud_apikey;
          // console.info(aux,_themedia);

          if( (o.design_skin=='skin-wave' && !cthis.attr('data-scrubbg')) || is_ie8()){
            o.skinwave_enableReflect='off';
          }

          aux = encodeURIComponent(aux);
          $.getJSON((dzsap_settings.thepath+'soundcloudretriever.php?scurl='+aux), function(data) {

            console.info(data.stream_url+'?consumer_key='+ dzsap_settings.soundcloud_apikey+'&origin=localhost');

            _con.attr('data-sc_source',data.stream_url+'?consumer_key='+ dzsap_settings.soundcloud_apikey+'&origin=localhost');


            _t.trigger('click');
          });

          return false;
        }



      }
    }




    if(typeof dzsap_settings!='undefined'){

      //console.info(_themedia);

      var s_filename_arr = _themedia.split('/');

      //console.info(s_filename_arr);
      var s_filename = s_filename_arr[s_filename_arr.length-1];

      s_filename = encodeURIComponent(s_filename);
      s_filename = s_filename.replace('.', '');


      if(is_souncloud){
        var auxa = initial_source.split('/');

        // console.info(auxa);
        s_filename = auxa[auxa.length-1];
      }

      window.waves_filename = '{{dirname}}waves/scrubprog_'+s_filename+'.png';

      if(dzsap_settings.theurl_forwaveforms != dzsap_settings.thepath){
        window.waves_filename = '{{uploaddirname}}scrubprog_'+s_filename+'.png';
      }
      ///console.info(s_filename);



      var str_sample_time_start = '';
      var str_sample_time_end = '';
      var str_sample_time_total = '';


      if(_con){
        if(_con.find('.sample-time-start-feeder').length>0){
          if(Number(_con.find('.sample-time-start-feeder').eq(0).val())>0){
            str_sample_time_start='&sample_time_start='+Number(_con.find('.sample-time-start-feeder').eq(0).val());
          }
        }
        if(_con.find('.sample-time-end-feeder').length>0){
          if(Number(_con.find('.sample-time-end-feeder').eq(0).val())>0){
            str_sample_time_end='&sample_time_end='+Number(_con.find('.sample-time-end-feeder').eq(0).val());
          }
        }
        if(_con.find('.sample-time-total-feeder').length>0){
          if(Number(_con.find('.sample-time-total-feeder').eq(0).val())>0){
            str_sample_time_total='&sample_time_total='+Number(_con.find('.sample-time-total-feeder').eq(0).val());
          }
        }
      }

      var aux23 = window.waves_filename;

      if(aux23.indexOf('{{uploaddirname}}')>-1){

        aux23 = dzsap_settings.thepath_forwaveforms+'scrubprog_'+s_filename+'.png';
      }


      var aux='<object type="application/x-shockwave-flash" data="'+dzsap_settings.thepath+'wavegenerator.swf" width="230" height="30" id="flashcontent" style="visibility: visible;"><param name="movie" value="'+dzsap_settings.thepath+'wavegenerator.swf"><param name="menu" value="false"><param name="allowScriptAccess" value="always"><param name="scale" value="noscale"><param name="allowFullScreen" value="true"><param name="wmode" value="opaque"><param name="flashvars" value="settings_multiplier='+dzsap_settings.waveformgenerator_multiplier+'&media='+_themedia+'&savetophp_loc='+dzsap_settings.thepath+'savepng.php&savetophp_pngloc='+window.waves_filename+'&savetophp_pngprogloc='+aux23+'&color_wavesbg='+dzsap_settings.color_waveformbg+'&color_wavesprog='+dzsap_settings.color_waveformprog+'&settings_wavestyle='+dzsap_settings.settings_wavestyle+'&settings_onlyautowaveprog=on&settings_enablejscallback=on'+str_sample_time_start+str_sample_time_end+str_sample_time_total+'"></object>';


      _t.parent().append(aux);
      if(_t.parent().prev().hasClass('upload-prev')){
        window.waves_fieldtaget = _t.parent().prev();
      }else{

        if(_t.parent().prev().prev().prev().hasClass('upload-prev')){

          window.waves_fieldtaget = _t.parent().prev().prev().prev();
        }else{

          window.waves_fieldtaget = _t.parent().prev().prev();
        }
      }

      //console.info(_t.parent().parent());
      if(_t.parent().parent().prev().hasClass('upload-target-prev')){

        window.waves_fieldtaget = _t.parent().parent().prev();

      }


      _t.hide();
    }


    return false;
  }

  function click_btn_generate_default_waveform_bg(e){
    var _t = $(this);
    var _themedia = dzsap_settings.thepath + '';

    _t.parent().find('.textinput').eq(0).val(_themedia);


    return false;
  }
  function click_btn_generate_default_waveform_prog(e){
    var _t = $(this);
    var _themedia = dzsap_settings.thepath + '';

    _t.parent().find('.textinput').eq(0).val(_themedia);


    return false;
  }
}