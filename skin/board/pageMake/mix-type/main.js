//var _isNowLast = false;   // what we do - swiper 留덉�留� �щ씪�대뱶 泥댄겕 蹂���
var _hoverId;                                                                       // main visual pagination canvas 愿��� 蹂��섎뱾
var canvas, width, height, ctx, x, y, radius, circum, start, finish, curr, motion;  // main visual pagination canvas 愿��� 蹂��섎뱾
var _mainVisSwiper;         // main key visual swiper 蹂���
var _kvNum = 0;             // main key visual �щ씪�대뱶 �섎쾭 泥댄겕 蹂��� 
var _kvNextNum = 0;         // main key visual �щ씪�대뱶 �섎쾭 泥댄겕 蹂���
var _kvNextNumToLeft = 0;   // main key visual �щ씪�대뱶 �섎쾭 泥댄겕 蹂���
var _progressBarMotion;     // main key visual - Progress Bar 蹂���
var _mainKVideo             // main key visual - video
var _playTime               // main key visual - autoplay �ъ깮�쒓컙
var _txtFadeInMotion;        // main key visual �щ씪�대뱶 �꾪솚 �� �띿뒪�� fadeIn 紐⑥뀡 (2021-07-19 異붽�)
var _originMotion;           // main KV �띿뒪�몃え��
var wedoSwiper;             // what we do �ㅼ��댄띁
var mainPopupSwiper;        // main popup 硫붿씤 �앹뾽 �ㅼ��댄띁
var _beforeWidth;

var testScript = (function(){
  return {
    initiMotion: function(){
      _originMotion = gsap.to($(".main_visual .swiper-slide:first-child .txt_area"), 5, {opacity:1, ease:Power4.easeOut, onComplete:function(){
        $(".main_visual").removeClass("first");
      }});
    },
    mainMotionTest : function(){
      $('body').on("mousewheel", function(){
        if($("#wrap").hasClass("ie")){
          event.preventDefault();

          var wheelDelta = event.wheelDelta;

          var currentScrollPosition = window.pageYOffset;
          window.scrollTo(0, currentScrollPosition - wheelDelta);
        }
      });

      $('body').keydown(function(e){
        if($("#wrap").hasClass("ie")){
          e.preventDefault();
          var currentScrollPosition = window.pageYOffset;

          switch(e.which){
            case 38: // up 諛⑺뼢��
              window.scrollTo(0, currentScrollPosition - 120);
              break;
            case 40: // down 諛⑺뼢��
              window.scrollTo(0, currentScrollPosition + 120);
              break;
            default: return;
          }
        }
      })
    },
    triggerFn: function(){
      // vision
      $(".basic_motion").each(function(q){
        gsap.to($(this), {
          scrollTrigger: {
            trigger: $(this),
            start: "top 75%",
            end:"+=180%",
            scrub: 1,
            //markers: true,
            toggleClass: {targets: $(this), className: "active"}
          },
        });
      });

      if(!$("html").hasClass("ie")){
        ScrollTrigger.matchMedia({	
          // desktop
          "(min-width: 1024px)": function() {
            /*ScrollTrigger.create({
              trigger: ".wedo_area .title",
              start: "top 160px",
              endTrigger : ".wedo_area .list_wrap .list:last-child" ,
              end: "bottom-=440px 205px",
              scrub: 1,
              //pin: true,
              markers: true,
              toggleClass: {targets: $(".wedo_area .title"), className: "on"},
              onUpdate: function(){
              },
            });*/
            
            /* 2022-05-18 異붽� */
            $(".text_area .txt_wrap").css({top: "50%",transform: "translateY(-50%)",opacity: 1,transition: "top .6s"});
            ScrollTrigger.create({
              trigger: ".text_area",
              start: "top top",
              end: "+=200%",
              scrub: 1,
              pin: true,
              // markers: true,
              onUpdate: function(self) {
                if (self.progress.toFixed(3) >= 0 && self.progress.toFixed(3) < 0.4) {
                  gsap.to(".text_area .txt_wrap", .5, {delay: .2, opacity: 1});
                  gsap.to(".text_area .area-bg", .4, {delay: .2, opacity: 0});
                  gsap.to(".text_area .download_area", .5, {delay: .2, opacity: 0, top: 100, display: 'none'});
                  $(".text_area").css({'z-index': 0});

                }
                else {
                  gsap.to(".text_area .txt_wrap", .5, {delay: .2, opacity: 0});
                  gsap.to(".text_area .area-bg", .4, {delay: .2, opacity: 1});
                  gsap.to(".text_area .download_area", .5, {delay: .2, opacity: 1, top: 0, display: 'block'});
                  $(".text_area").css({'z-index': 999});
                }

				gsap.to(".text_area .area-bg", {
                  scrollTrigger: {
                    trigger: ".video_area",
                    start: "top 40%",
                    end: "bottom center",
                    scrub: 1,
                    //markers: true,
                    toggleClass: {
                      targets: ".text_area .area-bg",
                      className: "active"
                    },
                  },
                });
              }, 
            });

			gsap.to(".video_area .width_video", {
			  scrollTrigger: {
				trigger: ".video_area",
				start: "top 80%",
				end: "+=90%",
				scrub: 1,
				toggleClass: {
				  targets: ".width_video",
				  className: "on"
				},
				// markers: true,
				onUpdate: function(self) {
				  gsap.to($(".video_area .width_video"), 1, {width: 80 + (self.progress.toFixed(3) * 20) + "%", marginTop: 1200 - (self.progress.toFixed(3) * 1200),ease: Power4.easeOut}); 
				}, /* 留덉쭊媛� 600-> 1200 �섏젙 */
			  },
			  width: "100%",
			  marginTop: 0,
			});
            /* // 2022-05-18 異붽� */

            gsap.to($(".wedo_area .wedo_inner"), {
              scrollTrigger: {
                trigger: ".wedo_area .title",
                start: "top 160px",
                endTrigger : ".wedo_area .list_wrap .list:last-child" ,
                end: "bottom-=440px 205px",
                scrub: 1,
                pin: true,
                //markers: true,
              },
            });
          },
          
           /* 2022-05-18 異붽� */
          //m
          "(max-width: 1024px)": function() {
            ScrollTrigger.create({
              trigger: ".text_area",
              start: "top top",
              end: "+=200%",
              scrub: 1,
              pin: true,
              // markers: true,
              onUpdate: function(self) {
                if (self.progress.toFixed(3) >= 0 && self.progress.toFixed(3) < 0.4) {
                  gsap.to(".text_area .txt_wrap", .5, {delay: .2, opacity: 1});
                  gsap.to(".text_area .area-bg", .4, {delay: .2, opacity: 0});
                  gsap.to(".text_area .download_area", .5, {delay: .2, opacity: 0, top: 100, display: 'none'});
                  $(".text_area").css({'z-index': 0});

                }
                else {
                  gsap.to(".text_area .txt_wrap", .5, {delay: .2, opacity: 0});
                  gsap.to(".text_area .area-bg", .4, {delay: .2, opacity: 1});
                  gsap.to(".text_area .download_area", .5, {delay: .2, opacity: 1, top: 0, display: 'block'});
                  $(".text_area").css({'z-index': 999});
                }

				gsap.to(".text_area .area-bg", {
                  scrollTrigger: {
                    trigger: ".video_area",
                    start: "top 30%",
                    end: "bottom center",
                    scrub: 1,
                    //markers: true,
                    toggleClass: {
                      targets: ".text_area .area-bg",
                      className: "active"
                    },
                  },
                });
              }
            });

			$(".video_area .width_video").css({'margin-top': '1200px'});
			gsap.to(".video_area .width_video", {
			  scrollTrigger: {
				trigger: ".video_area",
				start: "top 80%",
				end: "+=90%",
				scrub: 1,
				toggleClass: {
				  targets: ".width_video",
				  className: "on"
				},
				onUpdate: function(self) {
				  gsap.to($(".video_area .width_video"), 1, {width: 80 + (self.progress.toFixed(3) * 20) + "%", marginTop: 1200 - (self.progress.toFixed(3) * 1200),ease: Power4.easeOut}); 
				},/* 留덉쭊媛� 600-> 1200 �섏젙 */
			  },
			  width: "100%",
			  marginTop: 0,
			}); 
			
          }
          /* // 2022-05-18 異붽� */
        });
      }

      /*gsap.to(".vision_area .img_wrap", {
        scrollTrigger: {
          trigger: ".vision_area .img_wrap",
          start: "center center",
          end:"+=73%",
          scrub: 1,
          pin: true,
          //markers: true,
        },
      });*/

      /*var backgroundChange1 = gsap.timeline();
      backgroundChange1.fromTo(".content", {'background-color': '#1F1F1F'}, {'background-color': '#fff'}, 0);
      ScrollTrigger.create({
          animation: backgroundChange1,
          trigger: ".wedo_area",
          start: "75% center",
          end: "bottom",
          scrub: true,
          //markers: true,
      });*/

      // vision
      
      gsap.to(".video_area .fixed_video", {
        scrollTrigger: {
          trigger: ".video_area .fixed_video",
          start: "top top",
          //endTrigger : ".news_area",
          endTrigger : ".wedo_area .flow_area",
          end: "bottom bottom",
          //end:"max",
          //scrub: 1,
          pin: true,
          //id:"video fixed",
          //markers: true,
          onUpdate: function(){
            
          },
        },
      });

    /*2022-05-18 �섏젙 */
      gsap.to(".video_area .width_video", {
        scrollTrigger: {
          trigger: ".video_area",
          start: "top 80%",
          end: "+=90%",
          scrub: 1,
          toggleClass: {targets: ".width_video", className: "on"},
          //markers: true,
          onUpdate: function(self){
            gsap.to($(".video_area .width_video"), 1, {width:80 + (self.progress.toFixed(3) * 20) + "%", marginTop: 1200 - (self.progress.toFixed(3) * 1200), ease:Power4.easeOut});
          },
        },
        //width: "100%",
        //marginTop: 0,
      });
      /* // 2022-05-18 �섏젙 */

      // our field
      /*gsap.to(".wedo_area .title p", {
        scrollTrigger: {
          trigger: ".wedo_area",
          start: "top 80%",
          end: "+=20%",
          //end: "bottom 50%",
          scrub: 1,
          //markers: true,
        },
        margin:0,
        opacity:1,
      });*/

      gsap.to(".wedo_area .flow_area .txt_div", {
        scrollTrigger: {
          trigger: ".wedo_area",
          start: "top 80%",
          end: "+=20%",
          //end: "bottom 50%",
          scrub: 1,
          //markers: true,
        },
        top:-120,
        opacity:0.7,
      });
      
      $(".wedo_area .flow_area .list_wrap .list .img_div").each(function(q){
        gsap.to($(this).find("img"), 2, {
          scrollTrigger: {
            trigger: $(this),
            start: "top bottom",
            end: "bottom bottom",
            end: "+=100%",
            //scrub: 1,
            //markers: true,
          },
          scale:1,
        });
      });



      

      $(".wedo_area .flow_area .list_wrap .list:nth-child(odd)").each(function(q){
        /*ScrollTrigger.matchMedia({	
          // desktop
          "(min-width: 1024px)": function() {
            gsap.to($(this), {
              scrollTrigger: {
                //trigger: ".wedo_area .flow_area",
                trigger: $(this),
                start: "top center",
                endTrigger: $(".news_area"),
                //end: "+=500%",
                end: "bottom bottom",
                scrub: 1,
                //markers: true,
              },
              top:-450,
            });
          },
        });*/



        gsap.to($(this), {
          scrollTrigger: {
            trigger: ".wedo_area .flow_area",
            start: "top center",
            endTrigger: $(".news_area"),
            //end: "+=500%",
            end: "bottom bottom",
            scrub: 1,
            //markers: true,
          },
          top:-450,
        });
      });

      $(".wedo_area .flow_area .list_wrap .list:nth-child(even)").each(function(q){
        gsap.to($(this), {
          scrollTrigger: {
            trigger: ".wedo_area .flow_area",
            start: "top center",
            endTrigger: $(".news_area"),
            //end: "+=500%",
            end: "bottom bottom",
            scrub: 1,
            //markers: true,
          },
          top:-200,
        });
      });

      /*$(".wedo_area .flow_area .list_wrap .list .img_div img").each(function(q){
        gsap.to($(this), {
          scrollTrigger: {
            trigger: ".wedo_area .flow_area",
            start: "top center",
            end: "+=500%",
            scrub: 1,
            //markers: true,
          },
          top:400,
        });

        gsap.to($(this).parents(".list:nth-child(even)"), {
          scrollTrigger: {
            trigger: ".wedo_area .flow_area",
            start: "top center",
            end: "+=500%",
            scrub: 1,
          },
          top:-200,
        });

        gsap.to($(this).parents(".list:nth-child(odd)"), {
          scrollTrigger: {
            trigger: ".wedo_area .flow_area",
            start: "top center",
            end: "+=500%",
            scrub: 1,
          },
          top:-650,
        });
      });*/

      /*$(".wedo_area .flow_area .list_wrap .list:nth-child(odd)").each(function(q){
        gsap.to($(this), {
          scrollTrigger: {
            //trigger: $(this),
            trigger: ".wedo_area .flow_area",
            start: "top center",
            end: "+=500%",
            //scrub: 1,
            //markers: true,
            //toggleClass: {targets: $(this), className: "on"}
          },
          top:-150,
        });
      });*/
    },
    swiperFn: function(){
      _progressBarMotion = gsap.to($(".main_visual .progress_bar .bar"), 5, {width:"100%", ease:"none", onComplete:function(){
        _mainVisSwiper.slideNext();
      }});

      _mainVisSwiper = new Swiper('.main_visual .swiper-container', {
        loop: true,
        //speed : 1500, //origin
        speed : 2500,
        observer : true,
        observeParents : true,
        allowTouchMove: false,
        effect: 'fade',
        /*autoplay: {
          delay: 5000,
          disableOnInteraction: false,
          //waitForTransition: true,
        },*/
        pagination: {
          el: '.main_visual .swiper-pagination',
          clickable: true,
        },
        /*breakpoints: {
          1025: {
            allowTouchMove: true,
          },
        },*/
        navigation: {
          nextEl: '.main_visual .swiper-button-next',
          prevEl: '.main_visual .swiper-button-prev',
        },
        on : {
          init: function(){
          },
          slideChangeTransitionStart: function(){
            if($(".main_visual .swiper-slide-active video").size() != 0){
              if($(".main_visual .swiper-slide").not(".swiper-slide-active, swiper-slide-duplicate-active").find("video").size() != 0){
                $(".main_visual .swiper-slide").not(".swiper-slide-active, swiper-slide-duplicate-active").find("video").get(0).pause();
              }

              $(".main_visual .swiper-slide-active video").get(0).currentTime = 0;
              
              _playTime = $(".main_visual .swiper-slide-active video")[0].duration;
            }else{
              _playTime = 5;
            }
            
            gsap.fromTo($(".main_visual .swiper-slide-active .img_area, .main_visual .swiper-slide-duplicate-active .img_area"), 15, {scale:1.1}, {scale:1, ease:Power4.easeOut});
            
            $(".main_visual .vis_control_area .pagination .list").removeClass("active");
            $(".main_visual .vis_control_area .pagination .list").eq(this.realIndex).addClass("active");

            if($(".main_visual .swiper-slide-active").attr("data-swiper-slide-index") != 0){
              $(".main_visual").removeClass("first");
            }

            // text 紐⑥뀡
            if($(".main_visual").hasClass("first")){ // 泥섏쓬 濡쒕뱶�덉쓣 �뚮뒗 湲��� 泥쒖쿇�� �щ씪吏�寃� �좊젮怨�
              //_originMotion = gsap.to($(".main_visual .swiper-slide-active .txt_area"), 5, {opacity:1, ease:Power4.easeOut});
              //$(".main_visual").removeClass("first");
            }else{
              _originMotion.kill();
              gsap.to($(".main_visual .swiper-slide").not(".swiper-slide-active, swiper-slide-duplicate-active").find(".txt_area"), 0.9, {opacity:0, ease:Power4.easeOut});

              if(_txtFadeInMotion != undefined){
                _txtFadeInMotion.kill();
              }

              _txtFadeInMotion = gsap.to($(".main_visual .swiper-slide-active .txt_area, .main_visual .swiper-slide-duplicate-active .txt_area"), 1.2, {opacity:1, ease:Power4.easeOut});
            }
          },
          slideChangeTransitionEnd: function(){
            if(!$(".main_visual .control_area .vis_control").hasClass("pause")){
              if($(".main_visual .swiper-slide-active video").size() != 0){
                $(".main_visual .swiper-slide-active video").get(0).pause();
                $(".main_visual .swiper-slide-active video").get(0).currentTime = 0;
                $(".main_visual .swiper-slide-active video").get(0).play();
              }
              _progressBarMotion.duration(_playTime).restart();
            }
          },
        },
      });

      if(_deviceCondition == "mobile"){
        if(_mainVisSwiper != undefined){
          _mainVisSwiper.allowTouchMove = true;
        }
      }else{
        if(_mainVisSwiper != undefined){
          _mainVisSwiper.allowTouchMove = false;
        }
      }

      $(".main_visual .swiper-button-next, .main_visual .swiper-button-prev, .main_visual .control_area .swiper-pagination .swiper-pagination-bullet").on("click", function(){
        _progressBarMotion.pause();
      })

      

      mainPopupSwiper = new Swiper('.main_popup .swiper-container', {
        slidePerView: "auto",
        speed : 1700,
        observer : true,
        observeParents : true,
        //autoHeight: true,
        loop: true,
        autoplay: {
          delay: 2000,
          disableOnInteraction: false,
          //waitForTransition: true,
        },
        pagination: {
          el: '.main_popup .swiper-pagination',
        },
        navigation: {
          nextEl: '.main_popup .swiper-button-next',
          prevEl: '.main_popup .swiper-button-prev',
        },
        on : {
          init: function(){
          },
          slideChangeTransitionStart: function(){
          },
          slideNextTransitionStart: function(){// to right
          },
        }
      });
    },
    mainScrollFn: function(){
      $(window).on("scroll", function(){
        // news
        if($(window).scrollTop() + $(window).height()*0.8 >= $(".news_area").offset().top){
          $(".news_area").addClass("on");
        }
        
      });$(window).scroll()
    },
    mouseWheelFn: function(){
      $(window).on('mousewheel DOMMouseScroll', function(e) {
        var E = e.originalEvent;
        delta = 0;
        if (E.detail) {
        }else{
          delta = E.wheelDelta;
          deltaY = E.deltaY
          if(delta > 0){
            // up
          }else{
            // down
          }
        }
      });

      /*$(".wedo_area .swiper-slide.first").on('mousewheel DOMMouseScroll', function(e) {
        var E = e.originalEvent;
        delta = 0;
        if (E.detail) {
        }else{
          delta = E.wheelDelta;
          deltaY = E.deltaY

          // if($(".wedo_area").hasClass("fixed")){
          //   wedoSwiper.mousewheel.enable();
          // }

          if(delta > 0){
            // up

            if(wedoSwiper.activeIndex == 0){
              wedoSwiper.mousewheel.disable();
            }else{
              wedoSwiper.mousewheel.enable();
            }
          }else{
            // down
            if($(".wedo_area").hasClass("fixed")){
              wedoSwiper.mousewheel.enable();
            }
          }
        }
      });

      $(".wedo_area .swiper-slide.last").on('mousewheel DOMMouseScroll', function(e) {
        var E = e.originalEvent;
        delta = 0;
        if (E.detail) {
        }else{
          delta = E.wheelDelta;
          deltaY = E.deltaY

          // if($(".wedo_area").hasClass("fixed")){
          //   wedoSwiper.mousewheel.enable();
          //   $(window).scrollTop($(".wedo_area").offset().top);
          // }

          if(delta > 0){
            // up
            if($(".wedo_area").hasClass("fixed")){
              wedoSwiper.mousewheel.enable();
            }
          }else{
            // down

            if(_isNowLast){
              wedoSwiper.mousewheel.disable();
            }else{
              wedoSwiper.mousewheel.enable();
            }
          }
        }
      });*/
    },
    circleEffectCanvas : function (id, rad) {
      _hoverId = id;
      if($("#" + _hoverId).length == 0) return false;

      // CANVAS
      canvas = document.getElementById(_hoverId),
      width = canvas.width,
      height = canvas.height;

      // CANVAS PROPERTIES
      ctx = canvas.getContext("2d");

      ctx.strokeStyle = "#ffffff";

      // CANVAS MATHS
      x = width / 2,
      y = height / 2,
      radius = rad,
      circum = Math.PI * 2,
      start = Math.PI / -2, // Start position (top)
      finish = 270, // Finish (in %)
      curr = 0; // Current position (in %)

      // Animate function
      motion;
      function animate(draw_to) {

        ctx.clearRect(0, 0, width, height);
        ctx.beginPath();
        ctx.arc(x, y, radius, start, draw_to, false);
        ctx.stroke();
        curr++;
        if (curr < finish + 1) {
          motion = requestAnimationFrame(function () {
              animate(circum * curr / 270 + start);
          });
        }          
      }

      animate();
    },
    mainFn: function(){

      scrollMotionTrigger();

      // main KV
      $(".vis_control").on("click", function(){
        if(!$(this).hasClass("pause")){ // �쇱떆�뺤� �섍린
          $(this).addClass("pause");
          $(this).attr("title", "�먮룞 �ъ깮 �쒖옉");
          //_mainVisSwiper.autoplay.stop();
          _progressBarMotion.pause();
          if($(".main_visual .swiper-slide-active video").size() != 0){
            $(".main_visual .swiper-slide-active video").get(0).pause();
          }
        }else{ // �ъ깮 �섍린
          $(this).removeClass("pause");
          $(this).attr("title", "�먮룞 �ъ깮 硫덉땄");
          _progressBarMotion.play();
          if($(".main_visual .swiper-slide-active video").size() != 0){
            $(".main_visual .swiper-slide-active video").get(0).play();
          }
        }
      });

      // main KV �쇱떆�뺤� 踰꾪듉
      $(".main_kv_indi > div").on("click", function(){
        if($(".vis_control").hasClass("pause")){
          $(".main_visual .vis_control_area .pagination .list canvas").css("display","none");
          $(".main_visual .vis_control_area .pagination .list.now_pause:after").css("display","block");
        }
      });

      // what we do �곸뿭
      $(".wedo_area .txt_area .list").each(function(q){
        $(this).on("focusin", function(){
          $(".wedo_area .txt_area .list").removeClass("show");
          $(this).addClass("show");
        });
      });

      // 硫붿씤 �앹뾽 main popup �リ린 踰꾪듉
      if($(".main_popup").is(':visible')){
        $("body").addClass("overflow_hidden");
      }
      $(".main_popup .pop_close").on("click", function(){
        $(".main_popup").stop().fadeOut(300);
        $("body").removeClass("overflow_hidden");
      });

      // 硫붿씤 �앹뾽 main popup �ъ깮/�쇱떆�뺤� 踰꾪듉
      $(".main_popup .pop_con .control_area .btn_control").on("click", function(){
        if(!$(this).hasClass("now_pause")){
          $(this).addClass("now_pause");
          mainPopupSwiper.autoplay.stop();
        }else{
          $(this).removeClass("now_pause");
          mainPopupSwiper.autoplay.start();
        }
      });
    },
    resizeFn: function(){
      $(window).resize(function(){
        $(".video_area .pin-spacer, .fixed_video").css("width", window.innerWidth);

        $(".main_visual").height(window.innerHeight);

        if(_deviceCondition == "mobile"){
          if(_mainVisSwiper != undefined){
            _mainVisSwiper.allowTouchMove = true;
          }
        }else{
          if(_mainVisSwiper != undefined){
            _mainVisSwiper.allowTouchMove = false;
          }
        }

        if(_beforeWidth < window.innerWidth && _deviceCondition == "pc"){
          if($(".width_video").hasClass("end")){
            //$(".fixed_video").width($(window).width());
            //$(".video_area .pin-spacer").css({"width": window.innerWidth, "border":"5px solid red"});
            $(".fixed_video").css({"width": $(window).width(), "maxWidth": $(window).width()});
          }
        }

        _beforeWidth = window.innerWidth;

      }).resize();
    },
  }
})();

$(document).ready(function(){
  testScript.initiMotion();
});

$(window).load(function(){
  //testScript.mainMotionTest();
  testScript.triggerFn();
  testScript.swiperFn();
  testScript.mainScrollFn();
  testScript.mouseWheelFn();
  testScript.mainFn();
  testScript.resizeFn();
  //testScript.circleEffectCanvas("timerPagination0", 9);
});

/*function animate(draw_to) {

  ctx.clearRect(0, 0, width, height);
  ctx.beginPath();
  ctx.arc(x, y, radius, start, draw_to, false);
  ctx.stroke();
  curr++;
  if (curr < finish + 1) {
    motion = requestAnimationFrame(function () {
        animate(circum * curr / 260 + start);
    });
  }          
}*/

function scrollMotionTrigger(){
  if($(".scrollMotion").size() > 0 || $(".scrollMotion2").size() > 0){
    $(".scrollMotion:visible").each(function(q){
      gsap.to($(this), {
        scrollTrigger: {
          trigger: $(this),
          start: "top 75%",
          end:"bottom center",
          toggleClass: {targets: $(".scrollMotion:visible").eq(q), className: "active"},
          once: true,
          //markers: true,
        },
      });
    });

    $(".scrollMotion2:visible").each(function(q){
      gsap.to($(this), {
        scrollTrigger: {
          trigger: $(this),
          start: "top 90%",
          end:"bottom center",
          toggleClass: {targets: $(".scrollMotion2:visible").eq(q), className: "active"},
          once: true,
          //markers: true,
        },
      });
    });
  }
}
