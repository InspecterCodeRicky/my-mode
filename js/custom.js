(function ($) {
  "use strict";
  // menu fixed js code
  $(window).scroll(function () {
    var window_top = $(window).scrollTop() + 1;
    if (window_top > 50) {
      $('.main_menu').addClass('menu_fixed animated fadeInDown');
    } else {
      $('.main_menu').removeClass('menu_fixed animated fadeInDown');
    }
  });
  
  if (document.getElementById('default-select')) {
		$('select').niceSelect();
  }
  
  $('.filter-show-btn a').on('click', function(e) {
    $('.search_filter_iner').addClass('filter_box_open')
  })
  $('.back-btn').on('click', function() {
    $('.search_filter_iner').removeClass('filter_box_open')
  })
  $("#open_box_form").on("click", function() {
    $('.search_filter_iner').addClass('filter_box_open')
  })

  var valSpan = $(".progress_bar .pie-wrapper span.label").text()
  valSpan = valSpan.replace('%', '')
  const progressVal = (valSpan * 3.6)
  $(".left-side").css('transform', 'rotate(' + progressVal+'deg)')
  if(valSpan <= 50) {
    $(".right-side").css('display', 'none')
  } else {
    $('.pie').css('clip', 'rect(auto, auto, auto, auto)')
    $(".right-side").css('transform', 'rotate(180deg)')
  }
}(jQuery));