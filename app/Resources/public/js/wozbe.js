var messages = {
  error: 'error',
  missingFields: 'missing fields'
};

//managerNavbarWithHash
(function () {
  'use strict';
  
  var navbarPositionTop = jQuery('#navbar').position().top;
  
  var shiftWindow = function() { 
    window.scrollBy(0, -70); 
  };
  
  var isContentHidden = function() {
    return (jQuery(window).scrollTop() >= navbarPositionTop);
  };
  
  jQuery(document).ready(function () {
    //delay window position
    setTimeout(function () {
      if (window.location.hash && isContentHidden()) {
        shiftWindow();
      }
    }, 1);
  });
  
  window.addEventListener('hashchange', shiftWindow);
}());

//fixed navbar on scroll when necessary
(function() {
  'use strict';
  
  jQuery('#navbar-mock').hide();

  var navbarPositionTop = jQuery('#navbar').position().top;
  var navbarWidthFixed = jQuery('#navbar').data('width-fixed');
  var isNavbarFixed = false;
  
  var navbarFixed = function () {
    if(!isNavbarFixed) {
      isNavbarFixed = true;
      
      jQuery('#navbar').addClass('navbar-fixed-top');
      jQuery('#navbar-mock').show();
      jQuery('#navbar .brand').show();
    }
  };
  
  var navbarUnFixed = function () {
    if(isNavbarFixed) {
      isNavbarFixed = false;
      
      jQuery('#navbar').removeClass('navbar-fixed-top');
      jQuery('#navbar-mock').hide();
      jQuery('#navbar .brand').hide();
    }
  };
  
  var checkPosition = _.throttle(function () {
    if(jQuery(window).width() >= navbarWidthFixed && jQuery(window).scrollTop() >= navbarPositionTop) {
      navbarFixed();
    }
    else {
      navbarUnFixed();
    }
  }, 100);

  jQuery(window).scroll(checkPosition);
}());

//managerContactForm
(function() {
  'use strict';
  
  jQuery('.zone-contact form').on('submit', function() {
    var email = $('#contactEmail').val();
    var message = $('#contactMessage').val();
    var $alerts = $('.zone-contact .alerts');
    var $mailTemplate = $('#mail-template');

    if(email === '' || message === '') {
      $alerts.append(Mustache.render($mailTemplate.html(), {
        class: 'alert-error',
        title: messages.error,
        message: messages.missingFields
      }));
    } else {
        // appel Ajax
        $.ajax({
          url: jQuery(this).attr('action'),
          type: jQuery(this).attr('method'),
          data: jQuery(this).serialize(),
          success: function(data) {
            $alerts.append(Mustache.render($mailTemplate.html(), {
              class: 'alert-success',
              title: data.title,
              message: data.message
            }));
          },
          error: function(jqXHR) {
            $alerts.append(Mustache.render($mailTemplate.html(), {
              class: 'alert-error',
              title: messages.error,
              message: jqXHR.responseText
            }));
          }
        });
    }
    return false;
  });
}());
