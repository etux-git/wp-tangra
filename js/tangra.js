jQuery(document).ready(function() {
  
  jQuery('#menu-pages > li').removeClass('jsHover');
  jQuery('.nav-services > li').removeClass('jsHover');
  
  jQuery('#menu-pages .sub-menu').attr({
    'role': "menu",
    'aria-hidden': "true"
  });
  jQuery('.nav-services .sub-menu').attr({
    'role': "menu",
    'aria-hidden': "true"
  });
    
  jQuery('#menu-pages > li').focusin(function() {
    jQuery('#menu-pages > li').not(this).removeClass('jsHover').find('ul[aria-hidden="false"]').attr('aria-hidden', 'true')
    jQuery(this).addClass('jsHover').find('ul[aria-hidden="true"]').attr('aria-hidden', 'false')
  });
  jQuery('.nav-services > li').focusin(function() {
    jQuery('.nav-services > li').not(this).removeClass('jsHover').find('ul[aria-hidden="false"]').attr('aria-hidden', 'true')
    jQuery(this).addClass('jsHover').find('ul[aria-hidden="true"]').attr('aria-hidden', 'false')
  });
  
  jQuery('#menu-pages > li').focusout(function() {
    jQuery(this).removeClass('jsHover')
  });
  jQuery('.nav-services > li').focusout(function() {
    jQuery(this).removeClass('jsHover')
  });
  
});

jQuery(document).ready(function() {
  var offset = 220;
  var duration = 500;
  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > offset) {
      jQuery('.link-to-top a').fadeIn(duration);
    } else {
      jQuery('.link-to-top a').fadeOut(duration);
    }
  });
  jQuery('.link-to-top a').click(function(event) {
    event.preventDefault();
    jQuery('html, body').animate({scrollTop: 0}, duration);
    return false;
  })
  
  jQuery('.wp-video').removeAttr('style');
  
});