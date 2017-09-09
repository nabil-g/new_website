$(window).load(function () {

  $('main').fadeIn(1500, function () {
    term.typed({
      strings: [lang.greetings],
      showCursor: false,
      typeSpeed: 0,
      onStringTyped: mainPromptCallback
    });
  });

  var term = $('.terminal');
  var lang;
  var msgData = {};

// callback after different typed
  var mainPromptCallback = function () {
    $('#mainPromptField').val("");
    $('#mainPrompt').show();
    $('input:visible').focus();
  };

  var namePromptCallback = function () {

  };

  var mailPromptCallback = function () {

  };

  var msgPromptCallback = function () {

  };


// selecting the right language
  if (localStorage.lang == "fr") {
    // french version
    lang = french;
  } else if (localStorage.lang == "en") {
    // english version
    lang = english;
  } else if (navigator.language == "fr" || "fr-BE" || "fr-CA"  || "fr-CH" || "fr-LU") {
    // french version by default
    lang = french;
  } else {
    // english version by default
    lang = english;
  }



  $('#mainPrompt').submit(function (e) {
    e.preventDefault();
    var input = $("#mainPromptField").val();
    input = input.toLowerCase();
    if (input == "skills") {
      $(this).hide();
      term.append("~$  " + ($('#mainPromptField').val()) + "<br>");
      term.append('<span></span>');
      $('span:last-of-type').typed({
        strings: ["x" + "<br>"],
        showCursor: false,
        onStringTyped: mainPromptCallback
      });
    }
  });


  $('#namePrompt').submit(function (e) {
    e.preventDefault();
    var input = $("#namePromptField").val();
    if (input.length > 0) {
      $(this).hide();
    }
  });

  $('#mailPrompt').submit(function (e) {
    e.preventDefault();
    var input = $("#mailPromptField").val();
    if (input.length > 0) {
      $(this).hide();
    }
  });

  $('#msgPrompt').submit(function (e) {
    e.preventDefault();
    var input = $("#msgPromptField").val();
    if (input.length > 0) {
      $(this).hide();
    }
  });

  $(document).click(function () {
    $('input').focus();
  });

});
