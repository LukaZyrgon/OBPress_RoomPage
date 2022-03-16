jQuery(window).on("elementor/frontend/init", function () {
  //hook name is 'frontend/element_ready/{widget-name}.{skin} - i dont know how skins work yet, so for now presume it will
  //always be 'default', so for example 'frontend/element_ready/slick-slider.default'
  //$scope is a jquery wrapped parent element
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/RoomPage.default",
    function ($scope, $) {



      $('.single-room-info-categories-bar').click(function() {
        $('.single-room-info-categories-bar').removeClass("active-bar");
        $(this).addClass("active-bar");

        $('.single-room-info-category-section').removeClass("active-section");
        $(".single-room-info-category-section[data-category='"+$(this).attr('data-category')+"']").addClass("active-section");
      });

      $('.room-more-description').click(function() {
        $(".room-description-long").show();
        $(".room-less-description").show();
        $(".room-description-short").hide();
        $(".room-more-description").hide();
      });

      $('.room-less-description').click(function() {
        $(".room-description-long").hide();
        $(".room-less-description").hide();
        $(".room-description-short").show();
        $(".room-more-description").show();
      });

      var url_no_parametres = location.protocol + '//' + location.host + location.pathname;

      $(".ob-searchbar-submit").click(function() {
        // var data = {};
        // var action = "get_data_for_rooms";

        // data.action = action;

        var room_id = $(".single-room").data("room-id");
        var CheckIn = $("#date_from").val();
        var CheckOut = $("#date_to").val(); 
        var ad = $("#ad").val(); 
        var ch = $("#ch").val();
        var ag = $("#ag").val();

        $.get(specialOfferAjax.ajaxurl+"?action=get_data_for_rooms&room_id=" + room_id + "&CheckIn=" +  CheckIn + "&CheckOut=" + 
          CheckOut + "&ad=" + ad + "&ch=" + ch + "&ag=" + ag , function( res ) {
          $("#room-results").empty();
          $("#room-results").html(res);

          console.log("stigo");

          //change url in browser
          // window.history.pushState(  "", "Title", url_no_parametres + "?" + $( $("#rate_plan_form-lp")[0].elements ).not(".chain, #hotel_code").serialize()   );
        })
      });



      /* add or update parameters in url */
      function updateUrlParam(key, value, url) {
          if (!url) url = window.location.href;
          var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
              hash;

          if (re.test(url)) {
              if (typeof value !== 'undefined' && value !== null) {
                  return url.replace(re, '$1' + key + "=" + value + '$2$3');
              } 
              else {
                  hash = url.split('#');
                  url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                  if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
                      url += '#' + hash[1];
                  }
                  return url;
              }
          }
          else {
              if (typeof value !== 'undefined' && value !== null) {
                  var separator = url.indexOf('?') !== -1 ? '&' : '?';
                  hash = url.split('#');
                  url = hash[0] + separator + key + '=' + value;
                  if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
                      url += '#' + hash[1];
                  }
                  return url;
              }
              else {
                  return url;
              }
          }
      }


      /// main


      var width = window.innerWidth;
      var height = window.innerHeight;
      var resolutionMobile = false;
      var resolutionTablet = false;
      var resolution = 1; //1 desktop, 2 tablet, 3 mobile;

      if ( width < 1279 ) { 
        resolution = 3;
      } else{
        resolution = 1;
      }


    }

  );
  
});

jQuery(document).ready(function($){

  $(document).on("click", ".error_message_btn_calendar", function() {
    $("#calendar_dates").click();
  });


  // open calendar when click on Change Search
  $(document).on("click", ".restricted_modify_search", function() {

    $([document.documentElement, document.body]).animate({
        scrollTop: $("#calendar_dates").offset().top - 200
    }, 500);

    $("#calendar_dates").click();

  });


  
});