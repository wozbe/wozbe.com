var messages = {
  error: 'error',
  missingFields: 'missing fields'
};

var managerNavbarWithHash = function () {
  var navbarPositionTop = jQuery('#navbar').position().top;
  
  var shiftWindow = function() { 
    window.scrollBy(0, -70); 
  };
  
  jQuery(document).ready(function () {
    //delay window position
    setTimeout(function () {
      if (window.location.hash && jQuery(window).scrollTop() >= navbarPositionTop) {
        shiftWindow();
      }
    }, 1);
  });
  
  window.addEventListener("hashchange", shiftWindow);
}();

//fixed navbar on scroll when necessary
var managerNavbar = function() {
  jQuery('#navbar-mock').hide();

  var navbarPositionTop = jQuery('#navbar').position().top;
  
  var navbarFixed = function () {
    jQuery('#navbar').addClass('navbar-fixed-top');
    jQuery('#navbar-mock').show();
    jQuery('#navbar .brand').show();
  };
  
  var navbarUnFixed = function () {
    jQuery('#navbar').removeClass('navbar-fixed-top');
    jQuery('#navbar-mock').hide();
    jQuery('#navbar .brand').hide();
  };
  
  var checkPosition = _.throttle(function () {
    if(jQuery(window).scrollTop() >= navbarPositionTop) {
      navbarFixed();
    }
    else {
      navbarUnFixed();
    }
  }, 100);

  jQuery(window).scroll(checkPosition);
}();


var managerContactForm = function() {
  jQuery('#zone-contact form').on('submit', function() {
    var email = $('#contactEmail').val();
    var message = $('#contactMessage').val();
    var $alerts = $('#zone-contact .alerts');
    var $mailTemplate = $('#mail-template');

    if(email === '' || message === '') {
      $alerts.append(Mustache.render($mailTemplate.html(), {
        class: "alert-error",
        title: messages.error,
        message: messages.missingFields
      }));
    } else {
        // appel Ajax
        $.ajax({
          url: jQuery(this).attr('action'), // le nom du fichier indiqué dans le formulaire
          type: jQuery(this).attr('method'), // la méthode indiquée dans le formulaire (get ou post)
          data: jQuery(this).serialize(), // je sérialise les données (voir plus loin), ici les $_POST
          success: function(data) { // je récupère la réponse du fichier PHP
            $alerts.append(Mustache.render($mailTemplate.html(), {
              class: "alert-success",
              title: data.title,
              message: data.message
            }));
          },
          error: function(jqXHR, textStatus, errorThrown) { // je récupère la réponse du fichier PHP
            $alerts.append(Mustache.render($mailTemplate.html(), {
              class: "alert-error",
              title: messages.error,
              message: jqXHR.responseText
            }));
          }
        });
    }
    return false;
  });
}();
