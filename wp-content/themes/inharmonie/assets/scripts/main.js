/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        // if ($('body.single-blog').length) {
        //     var urlAbsolute = "http://www.petinsuranceaustralia.com.au/wp-content/uploads/logo-mobile.jpg";
        //     $('a.ss-button-facebook, a.ss-button-googleplus, a.ss-button-twitter, a.ss-button-linkedin, a.ss-button-pinterest, a.ss-button-xing').attr("src", urlAbsolute);
        // }

        $("header.navbar .navbar-toggleable-xs .menu-primary-navigation-container ul.nav li.dropdown a").each(function() {
            if ($(this).hasClass("dropdown-toggle")) {             
                $(this).prepend("<i class='fa fa-angle-down' aria-hidden='true'></i>");
            }
        }); 
  
        $(".section.timeline .slides").prepend('<div class="dots"></div>');
        $("body.single-event .right-side aside.widget_search form label input").attr("placeholder", "Name / Keyword");

        $("header.navbar .navbar-toggleable-xs .menu-primary-navigation-container ul.nav li.dropdown").hover(function(){
            $(this).addClass("open");
            }, function(){
            $(this).removeClass("open");
        });


        var postsArr = new Array(),
            $postsList = $('.two_column_wrapper ul.gform_fields');

        //Create array of all posts in lists
        $postsList.find('li').each(function(){
            postsArr.push($(this).html());
        })

        //Split the array at this point. The original array is altered.
        var firstList = postsArr.splice(0, Math.round(postsArr.length / 2)),
            secondList = postsArr,
            ListHTML = '';

        function createHTML(list){
            ListHTML = '';
            for (var i = 0; i < list.length; i++) {
                ListHTML += '<li>' + list[i] + '</li>'
            };
        }

        //Generate HTML for first list
        createHTML(firstList);
        $postsList.html(ListHTML);

        //Generate HTML for second list
        createHTML(secondList);
        //Create new list after original one
        $postsList.after('<ul class="gform_fields"></ul>').next().html(ListHTML);






        var windowsize = $(window).width();
        if (windowsize < 992) {
          $("#copywrite .container #gform_widget-2").insertBefore($("#copywrite .container #text-2"));
          $("#copywrite .container #text-3").insertBefore($("#copywrite .container #text-2"));
        } else {
          $("#copywrite .container #text-2").insertBefore($("#copywrite .container #gform_widget-2"));
        }

        $(window).resize(function(){
          var windowsize = $(window).width();
          if (windowsize < 992) {
            $("#copywrite .container #gform_widget-2").insertBefore($("#copywrite .container #text-2"));
            $("#copywrite .container #text-3").insertBefore($("#copywrite .container #text-2"));
          } else {
            $("#copywrite .container #text-2").insertBefore($("#copywrite .container #gform_widget-2"));
          }

        });



        if ($('body.clients').length) {
          var $container = $('.client-listings');

          $container.isotope({
            itemSelector: '.cell'
          });
        }

        if ($('.newsletter form .wpcf7-form-control-wrap').length) {
            $('.newsletter form .wpcf7-form-control-wrap + br').remove();
        }


        /* Speakers Slider*/
        if ($('body.single-event').length) {
            // Variables

            $('.slider.responsive').slick({
              dots: true,
                prevArrow: $('.prev'),
                nextArrow: $('.next'),
              infinite: false,
              speed: 300,
              slidesToShow: 1,
              slidesToScroll: 1,
              responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
              ]
            });
        }

      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired

        $.stellar({
          horizontalScrolling: false,
          verticalOffset: 40
        });

        $(".chatMessage .col-sm-4.button .msp-preset-btn-84").click(function(){
          $(".chatMessage .gform_wrapper").slideToggle("slow");

          if ($(".chatMessage .gform_wrapper").is(':visible')) {
             $("html, body").animate({scrollTop: $(".chatMessage .gform_wrapper").offset().top});
          }
        });

        $('.listings .type-stories p a').text('Read More');
        $('.listings .type-leaders p a').text('Read More');

        $(".our-services .articles").click(function (e) {
            e.stopPropagation();

            var element = jQuery('.excerpt').clone();
            element.appendTo('some element');

            $(this).children('.excerpt').toggle();
        });


        $('.our-services .articles').click(function(){
        var hidden = $('.hidden');
        if (hidden.hasClass('visible')){
            hidden.animate({"left":"-1000px"}, "slow").removeClass('visible');
        } else {
            hidden.animate({"left":"0px"}, "slow").addClass('visible');
        }
        });

        $(".isotope-filter ul.filters").wrapAll( "<div class='container' />");





        $(".section.timeline .slides .slide:first").addClass('active');
        $(".section.timeline .slides-content .slide:first").addClass('active');

        $('.section.timeline .slides .slide .date').click( function(e) {
            e.preventDefault(); // prevent the default action
            e.stopPropagation(); // stop the click from bubbling

            $(this).closest('ul').find('.active').removeClass('active');
            $(this).parent().addClass('active');

            var countLI = $(this).parent('li').index();
            console.log( countLI );

            $(".section.timeline .slides-content .slide").removeClass('active');
            $(".section.timeline .slides-content").find('.slide').eq(countLI - 1).addClass('active');
            // $(".section.timeline .slides-content").find('.slide').nth-child(countLI).addClass('active');
        });



        var equalheight;
        equalheight = function(container){
          var currentTallest = 0,
            currentRowStart = 0,
            topPosition = 0,
            currentDiv = 0,
            rowDivs = [],
            $el;
          $(container).each(function() {

            $el = $(this);
            $($el).height('auto');
            topPosition = $el.position().top;

            if (currentRowStart !== topPosition) {
              for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
              }
              rowDivs.length = 0; // empty the array
              currentRowStart = topPosition;
              currentTallest = $el.height();
              rowDivs.push($el);
            } else {
              rowDivs.push($el);
              currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
              rowDivs[currentDiv].height(currentTallest);
            }
          });
        };

        $(window).load(function() {
          equalheight('.single-services .breakdown h2');
          equalheight('.stories-article .left-side .related-articles .cols .article .title');
          equalheight('.leaders-article .left-side .related-articles .cols .article .title');
          equalheight('.featured-team-article .cols .summary');
          equalheight('.featured-team-article .cols .title');
          equalheight('.featured-stories-three-article .cols .title');
          equalheight('.featured-stories-three-article .cols .summary');
          equalheight('body.events .event_featured div');
        });

        $(window).resize(function(){
          waitForFinalEvent(function() {
            equalheight('.single-services .breakdown h2');
            equalheight('.stories-article .left-side .related-articles .cols .article .title');
            equalheight('.leaders-article .left-side .related-articles .cols .article .title');
            equalheight('.featured-team-article .cols .summary');
            equalheight('.featured-team-article .cols .title');
            equalheight('.featured-stories-three-article .cols .title');
            equalheight('.featured-stories-three-article .cols .summary');
            equalheight('body.events .event_featured div');
          }, 300)  ;
        });


        $(".host-an-event .two_column_wrapper form.two_column .gform_body ul li .ginput_container table.gfield_list input").attr("placeholder", "Speaker*").val("").focus().blur();
        $(".host-an-event .two_column_wrapper form.two_column .gform_body ul li .ginput_container table.gfield_list td.gfield_list_icons img.add_list_item").attr("src","http://conversionadvantage-staging.com/inharmonie/wp-content/themes/inharmonie/dist/images/add-speaker.jpg");


        if ($('body.team').length) {
          $(".featured-team-article .cols:nth-child(1)").removeClass("col-md-6");
          $(".featured-team-article .cols:nth-child(1)").addClass("col-md-12");
        }


      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About page
    'about': {
      init: function() {
        // JavaScript to be fired on the about page
      },
      finalize: function() {
        // JavaScript to be fired on the about page, after the init JS
      }
    },
    // Team page
    'team': {
      init: function() {
        // JavaScript to be fired on the team page
      },
      finalize: function() {
        // JavaScript to be fired on the team page, after the init JS
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.


var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();
