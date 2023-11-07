jQuery(document).ready(function($) {
  $('.newsroom-archive .form-item-created-min label').html('Date from:');
  $('.newsroom-archive .form-item-created-max label').html('Date to:');



  /*  Mobile slider for homepage news blocks   */
  var slick_slider = function() {
    var width_screen= $(window).width();
    var slider1_is_defined = $('body').find('.our-stories .slick-list').length;
    var slider2_is_defined = $('body').find('.view-learn-more .slick-list').length;
    if(width_screen < 768) {
        if(slider1_is_defined == 0) {
          $('body').find(".our-stories .views-view-responsive-grid").slick({
            lazyLoad: 'ondemand',
            infinite: true,
          });
        }
      if(slider2_is_defined == 0) {
        $('body').find(".view-learn-more .views-view-responsive-grid").slick({
          lazyLoad: 'ondemand',
          infinite: true,
        });
      }

    } else {
      if(slider1_is_defined > 0) {
        $('body').find(".our-stories .views-view-responsive-grid").slick('unslick');
      }
      if(slider2_is_defined > 0) {
        $('body').find(".view-learn-more .views-view-responsive-grid").slick('unslick');
      }
    }
  }
  slick_slider();
  $(window).on('resize', function() {
    slick_slider();
  })



});
