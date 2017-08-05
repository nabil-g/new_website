$(window).load(function () {

  var term = $('.terminal');


  var prompt = function () {
    term.append("<br>~$  " + "<form class='prompt'><input id='promptField' type='text'></form>");
    $('input').focus();

    $('.prompt').submit(function (e) {
      e.preventDefault();
      console.log('submitted');
      var input = $('#promptField').val();
      if (input.length > 0) {
        console.log('fffdf');
        $(this).replaceWith($(this).children().val());
        term.append('<span></span>');
        $('.terminal:last-child').typed({
          strings: ["Hi there. I'm a 25 y.o. junior web developer, full of ideas and motivation. To get more info, enter one of these commands."],
          showCursor: false,
          onStringTyped: prompt
        });
      }
    });


  };

  term.typed({
    strings: ["Hi there. I'm a 25 y.o. junior web developer, full of ideas and motivation. To get more info, enter one of these commands."],
    showCursor: false,
    onStringTyped: prompt
  });




});
