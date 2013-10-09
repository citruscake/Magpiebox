(function() {
  $(function() {
    var createPopover, emailCheck, toggleSubmit;
    emailCheck = function(email) {
      var regex;
      regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    };
    createPopover = function(element, message) {
      console.log(message);
      $(element).popover({
        content: message
      });
      return $(element).popover('show');
    };
    toggleSubmit = function(isLoading) {
      if (isLoading === true) {
        $('#submit_contact_us_button button').css('padding-top', '0.4em');
        $('#submit_contact_us_button button').css('padding-bottom', '0.4em');
        return $('#submit_contact_us_button button').html("<img src=\"/img/ajax-loader.gif\"/>");
      } else {
        $('#submit_contact_us_button button').css('padding', '6px 12px');
        return $('#submit_contact_us_button button').html("Send <span class=\"glyphicon glyphicon-envelope\"></span>");
      }
    };
    return $(document).ready(function() {
      $('#logo_frame img').load = function() {
        return $(this).baseline(21);
      };
      $('.body-container img').load = function() {
        return $(this).baseline(21);
      };
      $('#main_image_container img').load = function() {
        return $(this).baseline(21);
      };
      $('img').load = function() {
        return $(this).baseline(21);
      };
      console.log("fmoo");
      $('body').on('focus', 'input, textarea', function(event) {
        var id;
        id = event.target.id;
        $('#' + id).animate({
          'border-color': '#333333'
        }, 100);
        return $('#' + event.target.id).parent().popover('destroy');
      });
      $('body').on('focusout', 'input, textarea', function(event) {
        var id;
        id = event.target.id;
        return $('#' + id).animate({
          'border-color': '#999999'
        }, 100);
      });
      $('body').on('focusout', '#email_address', function(event) {
        return $('#email_address').trigger('keyup');
      });
      $('body').on('keyup', '#email_address', function(event) {
        var email_address, isEmail;
        email_address = $('#email_address').val();
        if (email_address !== "") {
          isEmail = emailCheck(email_address);
          if (isEmail === true) {
            return $('#contact_email_symbol_container').html("<span class=\"glyphicon glyphicon-ok\"></span>");
          } else {
            return $('#contact_email_symbol_container').html("<span class=\"glyphicon glyphicon-remove\"></span>");
          }
        } else {
          return $('#contact_email_symbol_container').html("");
        }
      });
      return $('body').on('click', '#submit_contact_us_button', function(event) {
        var data, email_address, full_name, isLoading, isTimerDone, message_body, message_subject;
        event.preventDefault();
        email_address = $('#email_address').val();
        full_name = $('#full_name').val();
        message_subject = $('#message_subject').val();
        message_body = $('#message_body').val();
        if (email_address === "") {
          return createPopover('#email_address', "Please enter your email address.");
        } else if (emailCheck(email_address) === false) {
          return createPopover('#email_address', "Your email address is invalid.");
        } else if (full_name === "") {
          return createPopover('#full_name', "Please give your name.");
        } else if (message_subject === "") {
          return createPopover('#message_subject', "Please give your message subject.");
        } else if (message_body === "") {
          return createPopover('#message_body', "Please give your message body.");
        } else {
          isLoading = true;
          isTimerDone = false;
          toggleSubmit(isLoading);
          $(this).doTimeout('change_button', 300, function() {
            isTimerDone = true;
            if (isLoading === false) {
              return toggleSubmit(isLoading);
            }
          });
          data = {
            email_address: $('#email_address').val(),
            full_name: $('#full_name').val(),
            message_subject: $('#message_subject').val(),
            message_body: $('#message_body').val()
          };
          return $.post('/main/contact', data, function(json) {
            var error, response, success;
            isLoading = false;
            if (isTimerDone === true) {
              toggleSubmit(isLoading);
            }
            response = $.parseJSON(json);
            if (response.status === "success") {
              alert - (success = $('#content .container-fluid #contact_container .form-row .alert-success'));
              alert - success.css('display', 'block');
              alert - success.animate({
                'opacity': 1
              }, 300);
            } else {
              alert - (error = $('#content .container-fluid #contact_container .form-row .alert-danger'));
              alert - error.css('display', 'block');
              alert - error.animate({
                'opacity': 1
              }, 300);
            }
            $('body').off('click', '#submit_contact_us_button');
            $('#submit_contact_us_button button').attr('disabled', true);
            $('#contact_container label, #submit_contact_us_button, #message_body_container, #email_address_container, #contact_email_symbol_container, #full_name_container, #message_subject_container').animate({
              'opacity': 0.4
            }, 300);
            return $('#contact_container input, #contact_container textarea').prop('disabled', true);
          });
        }
      });
    });
  });

}).call(this);
