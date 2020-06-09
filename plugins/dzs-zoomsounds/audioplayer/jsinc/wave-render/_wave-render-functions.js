const dzsapHelpers = require('../_dzsap_helpers');
const dzsapConstants = require('../../configs/_constants').constants;
exports.wave_mode_canvas_try_to_get_pcm = function (selfClass, pargs) {


  var margs = {};

  var $ = jQuery;

  if (pargs) {
    margs = $.extend(margs, pargs);
  }
  var self = this;

  // console.log('this -5 ', this);

  var o = selfClass.initOptions;

  if (selfClass.src_real_mp3 == 'fake') {
    return false;
  }

  if (selfClass.cthis.attr('data-pcm')) {


  } else {
    // -- we do not have pcm so we get it

    var data = {
      action: 'dzsap_get_pcm',
      postdata: '1',
      source: selfClass.cthis.attr('data-source'),
      playerid: selfClass.identifier_pcm
    };

    if (selfClass.urlToAjaxHandler) {
      $.ajax({
        type: "POST",
        url: selfClass.urlToAjaxHandler,
        data: data,
        success: function (response) {
          if (response) {

            if (response != '0' && response.indexOf(',') > -1) {

              selfClass.cthis.attr('data-pcm', response);
              selfClass.isRealPcm = true;

              if (selfClass._scrubbar.css('opacity') == '0') {

              }

              setTimeout(function () {


                selfClass.cthis.addClass('scrubbar-loaded');
                selfClass.calculate_dims_time();
                setTimeout(function () {

                  // calculate_dims();

                }, 100);
              }, 100);
              // showselfClass._scrubbar();
            } else {

              selfClass.isPcmTryingToGenerate = true;
              self.scrubModeWave__initGenerateWaveData(selfClass, {
                'call_from': 'no response from pcm ajax, generate it'
              });
            }

            // console.log('pcm_try_to_generate - ',pcm_try_to_generate);
          } else {

            if (o.cue == 'on') {

              selfClass.isPcmTryingToGenerate = true;
              // -- inside get_pcm
              self.scrubModeWave__initGenerateWaveData(selfClass, {
                'call_from': 'pcm_data_try_to_generate .. no data-pcm'
              });
            } else {

              selfClass.isPcmPromisingToGenerateOnMetaLoad = true; // -- we are promising generating on meta load
              if (o.pcm_data_try_to_generate_wait_for_real_pcm === 'on') {

                // console.log('ceva - ',pcm_promise_generate_on_meta_load)
                // console.log('selfClass.cself meta loaded ? ',selfClass.cself.hasClass('meta-loaded'), selfClass.cself)

                var default_pcm = [];

                for (var i3 = 0; i3 < 200; i3++) {
                  default_pcm[i3] = Number(Math.random()).toFixed(3);
                }
                default_pcm = JSON.stringify(default_pcm);
                self.scrubModeWave__transitionIn(selfClass, default_pcm);

                selfClass.isRealPcm = false;
              }
            }
          }

        },
        error: function (arg) {
          if (typeof window.console != "undefined") {
            // console.log('Got this from the server: ' , arg);
          }
          ;
        }
      });
      selfClass.isPcmTryingToGenerate = false;
    } else {

    }
  }
}


exports.scrubModeWave__checkIfWeShouldTryToGetPcm = function (selfClass, pargs) {

  let isWeShouldGetPcm = false;


  // console.log('  selfClass.isPcmTryingToGenerate ( on scrubModeWave__checkIfWeShouldTryToGetPcm )  - ', selfClass.isPcmTryingToGenerate);
  if (selfClass.isPcmTryingToGenerate) {
    return false;
  }


  if (selfClass.isPcmPromisingToGenerateOnMetaLoad) {
    selfClass.isPcmTryingToGenerate = true;
    isWeShouldGetPcm = true;

  }

  // console.log('selfClass - ', selfClass);
  if (!(selfClass.cthis.attr('data-pcm'))) {
    // console.log('selfClass - ', selfClass);


    if (!selfClass.urlToAjaxHandler) {

      // -- if we do not have url to ajax handler then it's clear we should generate smth..

      selfClass.isPcmTryingToGenerate = true;
      isWeShouldGetPcm = true;
    }

  }

  // debugger;
  if (isWeShouldGetPcm) {

    this.scrubModeWave__initGenerateWaveData(selfClass, {
      'call_from': 'pcm_data_try_to_generate .. no data-pcm'
    });
  }
}
exports.scrubModeWave__transitionIn = function (selfClass, argpcm) {

  //console.log('generate_wave_data_animate',cthis);
  var o = selfClass.initOptions;


  selfClass._scrubbar.find('.scrub-bg-img,.scrub-prog-img').removeClass('transitioning-in');
  selfClass._scrubbar.find('.scrub-bg-img,.scrub-prog-img').addClass('transitioning-out');
  ;

  dzsapHelpers.scrubbar_modeWave_setupCanvas({
    'prepare_for_transition_in': true
  }, selfClass);

  dzsapHelpers.draw_canvas(selfClass._scrubbarbg_canvas.get(0), argpcm, "#" + o.design_wave_color_bg, {
    call_from: 'canvas_generate_wave_data_animate_pcm_bg',
    selfClass,
    'skinwave_wave_mode_canvas_waves_number': parseInt(o.skinwave_wave_mode_canvas_waves_number),
    'skinwave_wave_mode_canvas_waves_padding': parseInt(o.skinwave_wave_mode_canvas_waves_padding)
  });
  dzsapHelpers.draw_canvas(selfClass._scrubbarprog_canvas.get(0), argpcm, '#' + o.design_wave_color_progress, {
    call_from: 'canvas_generate_wave_data_animate_pcm_prog',
    selfClass,
    'skinwave_wave_mode_canvas_waves_number': parseInt(o.skinwave_wave_mode_canvas_waves_number),
    'skinwave_wave_mode_canvas_waves_padding': parseInt(o.skinwave_wave_mode_canvas_waves_padding)
  });


  setTimeout(() => {
    dzsapHelpers.scrubbar_modeWave_clearObsoleteCanvas(selfClass);
  }, 300);

  // -- warning - not always real pcm
  selfClass.isRealPcm = true;

  selfClass.scrubbar_reveal();
}


exports.scrubModeWave__initGenerateWaveData = function (selfClass, pargs) {


  var $ = jQuery;
  var o = selfClass.initOptions;
  var margs = {
    'call_from': 'default'
    , 'call_attempt': 0
  };
  var self = this


  if (pargs) {
    margs = $.extend(margs, pargs);
  }

  if (selfClass.isRealPcm) {
    return false;
  }

  if (selfClass.src_real_mp3 == 'fake') {
    return false;
  }


  if (selfClass.isPcmTryingToGenerate) {

  } else {
    setTimeout(function () {
      margs.call_attempt++;
      if (margs.call_attempt < 10) {
        self.scrubModeWave__initGenerateWaveData(margs);
        console.log('%c [dzsap] trying to regenerate ', dzsapConstants.DEBUG_STYLE_1);
      }
    }, 1000)
    return false;
  }


  // console.log('scrubModeWave__initGenerateWaveData()', margs);


  // console.log('init_generate_wave_data', selfClass.cthis.attr('data-source'));
  if (window.WaveSurfer) {
    // console.log('wavesurfer already loaded');
    selfClass.scrubModeWave__generateWaveData(selfClass, {
      'call_from': 'wavesurfer already loaded'
    });
  } else {
    var scripts = document.getElementsByTagName("script");


    var baseUrl = '';
    for (var i23 in scripts) {
      if (scripts[i23] && scripts[i23].src) {
        if (scripts[i23].src.indexOf('audioplayer.js') > -1) {
          break;
        }
      }
    }
    var baseUrl_arr = String(scripts[i23].src).split('/');
    for (var i24 = 0; i24 < baseUrl_arr.length - 1; i24++) {
      baseUrl += baseUrl_arr[i24] + '/';
    }

    var url = baseUrl + 'wavesurfer.js';


    if (o.pcm_notice == 'on') {

      selfClass.cthis.addClass('errored-out');
      selfClass.cthis.append('<div class="feedback-text pcm-notice">please wait while pcm data is generated.. </div>');
    }


    window.dzsap_wavesurfer_load_attempt++;

    if (window.dzsap_wavesurfer_load_attempt > 2) {
      url = dzsapConstants.URL_WAVESURFER;
    }
    if (window.dzsap_wavesurfer_load_attempt < 6) {
      // console.log('load wavesurfer');
      $.ajax({
        url: url,
        dataType: "script",
        success: function (arg) {
          //console.log(arg);
          self.scrubModeWave__generateWaveData(selfClass, {
            'call_from': 'load_script'
            , 'wavesurfer_url': url
          });


        },
        error: function (arg) {

        }
      });
    }
  }
}
exports.scrubModeWave__generateWaveData = function (selfClass, pargs) {

  var $ = jQuery;
  var o = selfClass.initOptions;

  var margs = {
    call_from: 'default'
  }
  var self = this;

  if (pargs) {
    $.extend(margs, pargs);
  }


  if (selfClass.src_real_mp3 != 'fake') {

  } else {
    return false;
  }


  // -- make sure we are generating only once
  if (window.dzsap_generating_pcm) {
    setTimeout(function () {
      self.scrubModeWave__generateWaveData(selfClass, margs)
    }, 1000);
    return false;
  }
  window.dzsap_generating_pcm = true;


  var id = 'wavesurfer' + Math.ceil(Math.random() * 10000);
  selfClass.cthis.append('<div id="' + id + '" class="hidden"></div>');

  var wavesurfer = WaveSurfer.create({
    container: '#' + id
    , normalize: true
    , pixelRatio: 1
  });


  if (String(selfClass.cthis.attr('data-source')).indexOf('https://soundcloud.com') == 0 || selfClass.cthis.attr('data-source') == 'fake') {
    return;
  }
  if (String(selfClass.cthis.attr('data-source')).indexOf('https://api.soundcloud.com') == 0) {
  }


  // console.log(' selfClass.src_real_mp3 - '+selfClass.src_real_mp3, selfClass.src_real_mp3);
  try {
    wavesurfer.load(selfClass.src_real_mp3);
  } catch (err) {
    console.log("WAVE SURFER NO LOAD");
  }


  wavesurfer.on('ready', function () {
    //            wavesurfer.play();
    console.log('[dzsap] generating wave data for ', selfClass.identifier_pcm);

    var accuracy = 100;
    if (selfClass._cmedia && selfClass._cmedia.duration && selfClass._cmedia.duration > 1000) {
      accuracy = 100;
    }

    // console.log(selfClass._cmedia, selfClass._cmedia.duration);

    var ar_str = [];
    if (wavesurfer && wavesurfer.exportPCM) {

      ar_str = wavesurfer.exportPCM(o.wavesurfer_pcm_length, accuracy, true);
    } else {
      ar_str = dzsapHelpers.generateFakeArrayForPcm();
    }

    self.scrubModeWave__sendPcm(selfClass, ar_str);

    self.scrubModeWave__transitionIn(selfClass, ar_str);


  });

  wavesurfer.on('error', function (err, err2) {
    var default_pcm = [];

    for (var i3 = 0; i3 < 200; i3++) {
      default_pcm[i3] = Math.abs(Number(Math.random()).toFixed(3));
    }
    default_pcm = JSON.stringify(default_pcm);

    console.log('[dzsap] error while generating pcm - ', err)
    self.scrubModeWave__sendPcm(selfClass, default_pcm);
    self.scrubModeWave__transitionIn(selfClass, default_pcm);
  });

}

exports.scrubModeWave__sendPcm = function (selfClass, ar_str) {
  var $ = jQuery;


  try {
    // -- convert to absolute
    ar_str = JSON.stringify(JSON.parse(String(ar_str)).map(Math.abs));
  } catch (err) {
    console.log(err);
  }

  selfClass.cthis.attr('data-pcm', ar_str);
  if (selfClass._feed_fakeButton && selfClass._feed_fakeButton.attr) {
    selfClass._feed_fakeButton.attr('data-pcm', ar_str);
  }
  if (selfClass._sourcePlayer && selfClass._sourcePlayer.attr) {
    selfClass._sourcePlayer.attr('data-pcm', ar_str);
  }


  // console.log("which is fake player ? ", selfClass.cthis, selfClass._actualPlayer, _sourcePlayer);


  selfClass.cthis.find('.pcm-notice').fadeOut("fast");
  selfClass.cthis.removeClass('errored-out');


  // console.log('generating wave data for '+selfClass.cthis.attr('data-source'));
  // console.log('%c selfClass.identifier_pcm before- ','color: #dd0022; background-color: #eee;', selfClass.identifier_pcm, selfClass.cthis);

  if (!selfClass.identifier_pcm) {
    selfClass.identifier_pcm = selfClass.cthis.attr('data-source');


    if (selfClass.original_real_mp3) {
      selfClass.identifier_pcm = selfClass.original_real_mp3;
    }
  }


  // console.log('%c selfClass.identifier_pcm- ','color: #dd0022; background-color: #eee;', selfClass.identifier_pcm, selfClass.cthis);


  var data = {
    action: 'dzsap_submit_pcm'
    , postdata: ar_str
    , playerid: selfClass.identifier_pcm
    , source: selfClass.cthis.attr('data-source')
  };


  window.dzsap_generating_pcm = false;


  if (selfClass.urlToAjaxHandler) {


    $.ajax({
      type: "POST",
      url: selfClass.urlToAjaxHandler,
      data: data,
      success: function (response) {

      }
    });
  }
}

