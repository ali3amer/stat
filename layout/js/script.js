/*global $,console */

$(function () {

    'use strict';


      // Hide placeholder

    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder', '');

    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));

    });

      // Asterisk
/*
    $('input').each(function () {

        if ($(this).attr('required') === 'required') {

            $(this).after('<span class="asterisk">*</span>');


        }

    });
*/

    // Show Password

    var pass = $('.password');

    $('.show-pass').hover(function () {

        pass.attr('type', 'text');

    }, function () {

        pass.attr('type', 'password');

    });


    //Alert On Delete


    $('.confirm').click(function () {

        return confirm('هل تريد الحذف');

    });

  $('.reportok').click(function () {

    return confirm('هل تريد إعتماد التقرير');

  });




    // Start SelectBoxIt

  /*$("select").selectBoxIt({

        autoWidth: false,


    });*/

    $('#state').change(function () {

      var stateid = $(this).val();

      $('#city').removeAttr('disabled');
/*
      $('#city option').each(function () {
        console.log($(this).data('id'));

        if ($(this).data('id') != stateid && $(this).data('id') != 0) {
          $(this).fadeOut();

        } else {
          $(this).fadeIn();
        }
      });*/

      /*$.ajax({
        url: "../../getcity.php",
        type: "POST",
        data: {stateid: stateid},
        dataType: 'html',
        success: function () {
          $('#city').html(data);
        }
      });*/

    });


});
