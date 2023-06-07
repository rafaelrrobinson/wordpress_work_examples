jQuery( document ).ready(function($) {
  (function($) {
    $.fn.clickToggle = function(func1, func2) {
    var funcs = [func1, func2];
    this.data('toggleclicked', 0);
    this.click(function() {
        var data = $(this).data();
        var tc = data.toggleclicked;
        $.proxy(funcs[tc], this)();
        data.toggleclicked = (tc + 1) % 2;
    });
    return this;
    };
  }(jQuery));

  $('img.circle-spec').on('click', function() {
    $(this).attr('id', 'circle-spec');
  });

  $('#gray-tip').clickToggle(function() {
    $('#whip-spec, #gray-shaft, #gray-handle').hide('fast');
    $('img.circle-spec').attr('id', 'circle-spec');
    $('#gray-tip').animate({right: "+=4%",});
    setTimeout(function(){
      $('#gray-tip').attr('src', '/imgs/blue-close-btn.png');
      $('#tip-spec-zoom').show('fast');
      $('.popper > div').attr('class', 'grow');
      setTimeout(function(){
        $('#tip-box').show('slow');
      }, 1000);
    }, 1000);
  }, function() {
    $('img.circle-spec').attr('id', '');
    $('#gray-tip').animate({right: "-=4%",});
    $('#gray-tip').attr('src', '/imgs/gray-open-btn.png');
    $('#tip-spec-zoom, #tip-box').hide('fast');
    $('.popper > div').attr('class', '');
    $('#whip-spec, #gray-shaft, #gray-handle').show('fast');
  });

  $('#gray-shaft').clickToggle(function() {
    $('#whip-spec, #gray-tip, #gray-handle').hide('fast');
    $('img.circle-spec').attr('id', 'circle-spec');
    setTimeout(function(){
      $('#gray-shaft').attr('src', '/imgs/blue-close-btn.png');
      $('#whip-spec-zoom, #shaft-animation').show('fast');
      $('#shaft-animation').attr('src', '/imgs/shaft-animation.gif');
      setTimeout(function(){
        $('#shaft-box').show('slow');
      }, 1000);
    }, 1000);
  }, function() {
    $('img.circle-spec').attr('id', '');
    $('#gray-shaft').attr('src', '/imgs/gray-open-btn.png');
    $('#whip-spec-zoom, #shaft-box').hide('fast');
    $('#whip-spec, #gray-tip, #gray-handle').show('fast');
    $('#shaft-animation').hide().attr('src', '');
  });

  $('#gray-handle').clickToggle(function() {
    $('#whip-spec, #gray-tip, #gray-shaft').hide('fast');
    $('img.circle-spec').attr('id', 'circle-spec');
    $('#gray-handle').animate({left: "+=20%",});
    setTimeout(function(){
      $('#gray-handle').attr('src', '/imgs/blue-close-btn.png');
      $('#handle-spec-zoom').show('fast');
      $('.handle > div').attr('class', 'grow');
      setTimeout(function(){
        $('#handle-box').show('slow');
      }, 1000);
    }, 1000);
  }, function() {
    $('img.circle-spec').attr('id', '');
    $('#gray-handle').attr('src', '/imgs/gray-open-btn.png');
    $('#gray-handle').animate({left: "-=20%",});
    $('#handle-spec-zoom, #handle-box').hide('fast');
    $('.handle > div').attr('class', '');
    $('#whip-spec, #gray-tip, #gray-shaft').show('fast');
  });

});jQuery( document ).ready(function($) {
  (function($) {
$.fn.clickToggle = function(func1, func2) {
    var funcs = [func1, func2];
    this.data('toggleclicked', 0);
    this.click(function() {
        var data = $(this).data();
        var tc = data.toggleclicked;
        $.proxy(funcs[tc], this)();
        data.toggleclicked = (tc + 1) % 2;
    });
    return this;
};
}(jQuery));

  $('img.circle-spec').on('click', function() {
    $(this).attr('id', 'circle-spec');
  });

  $('#gray-tip').clickToggle(function() {
    $('#whip-spec, #gray-shaft, #gray-handle').hide('fast');
    $('img.circle-spec').attr('id', 'circle-spec');
    $('#gray-tip').animate({right: "+=4%",});
    setTimeout(function(){
      $('#gray-tip').attr('src', '/imgs/blue-close-btn.png');
      $('#tip-spec-zoom').show('fast');
      $('.popper > div').attr('class', 'grow');
      setTimeout(function(){
        $('#tip-box').show('slow');
      }, 1000);
    }, 1000);
  }, function() {
    $('img.circle-spec').attr('id', '');
    $('#gray-tip').animate({right: "-=4%",});
    $('#gray-tip').attr('src', '/imgs/gray-open-btn.png');
    $('#tip-spec-zoom, #tip-box').hide('fast');
    $('.popper > div').attr('class', '');
    $('#whip-spec, #gray-shaft, #gray-handle').show('fast');
  });

  $('#gray-shaft').clickToggle(function() {
    $('#whip-spec, #gray-tip, #gray-handle').hide('fast');
    $('img.circle-spec').attr('id', 'circle-spec');
    setTimeout(function(){
      $('#gray-shaft').attr('src', '/imgs/blue-close-btn.png');
      $('#whip-spec-zoom, #shaft-animation').show('fast');
      $('#shaft-animation').attr('src', '/imgs/shaft-animation.gif');
      setTimeout(function(){
        $('#shaft-box').show('slow');
      }, 1000);
    }, 1000);
  }, function() {
    $('img.circle-spec').attr('id', '');
    $('#gray-shaft').attr('src', '/imgs/gray-open-btn.png');
    $('#whip-spec-zoom, #shaft-box').hide('fast');
    $('#whip-spec, #gray-tip, #gray-handle').show('fast');
    $('#shaft-animation').hide().attr('src', '');
  });

  $('#gray-handle').clickToggle(function() {
    $('#whip-spec, #gray-tip, #gray-shaft').hide('fast');
    $('img.circle-spec').attr('id', 'circle-spec');
    $('#gray-handle').animate({left: "+=20%",});
    setTimeout(function(){
      $('#gray-handle').attr('src', '/imgs/blue-close-btn.png');
      $('#handle-spec-zoom').show('fast');
      $('.handle > div').attr('class', 'grow');
      setTimeout(function(){
        $('#handle-box').show('slow');
      }, 1000);
    }, 1000);
  }, function() {
    $('img.circle-spec').attr('id', '');
    $('#gray-handle').attr('src', '/imgs/gray-open-btn.png');
    $('#gray-handle').animate({left: "-=20%",});
    $('#handle-spec-zoom, #handle-box').hide('fast');
    $('.handle > div').attr('class', '');
    $('#whip-spec, #gray-tip, #gray-shaft').show('fast');
  });

});
