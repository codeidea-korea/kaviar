var _this_scroll = 0;       // 스크롤 up & down 체크위한 변수
var _allMenuMotionVar = []; // 전체메뉴 모션 리셋위한 변수
var _isScrollTop;          // scrollTop 변수
var _device = '';           // 접속 device 체크 위한 변수
var _deviceCondition = '';  // 해상도 따른 device 체크 위한 변수
var _browser = '';          // browser 체크 위한 변수
var _irScheduleSwiper;      // IR > 개요 - IR일정 스와이퍼 변수
var _popupId, _target;        // popup 관련 변수
var _newsLetterCount = 0;    // About us > 뉴스레터 구독 약관동의 동의 갯수 count
var _titleTxt;              // About us > 뉴스레터 구독 title 교체 위한 변수

var commonScript = (function(){
  
  var _getScrollObjY = function(){
    var scrollArray =[];
    var pHeight;
    if(_device == "pc"){
      pHeight = 300;
    }else{
      pHeight = 150;
    }
    $(".scrollMotion").each(function(index){
      scrollArray.push(parseInt($(".scrollMotion").eq(index).offset().top) + pHeight);
    });
    return scrollArray;
  }  

  var _getScrollObjY2 = function () { // brand scroll late
    var scrollArray = [];
    var pHeight;
    if (_device == "pc") {
      pHeight = 450;
    } else {
      pHeight = 250;
    }
    $(".scrollMotion2").each(function (index) {
      scrollArray.push(parseInt($(".scrollMotion2").eq(index).offset().top) + pHeight);
    });
    return scrollArray;
  }

  return {
    deviceChk : function(){
      // 디바이스 체크
      if(/Android/i.test(navigator.userAgent)) {
        _device = 'android';
      } else if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        return navigator.userAgent.match(/(iPhone|iPod)/g) ? device='ios' : device='ipad';
      }else {
        _device = 'pc';
      }

      // 브라우저 체크
      var agent = navigator.userAgent.toLowerCase(),
        name = navigator.appName;

      if(name === 'Microsoft Internet Explorer' || agent.indexOf('trident') > -1 || agent.indexOf('edge/') > -1) {
        _browser = 'ie';
        $("html").addClass("ie");
      } else if(agent.indexOf('safari') > -1) { // Chrome or Safari
        if(agent.indexOf("chrome") > -1){
          _browser = 'chrome';
          $("html").addClass("chrome");
          $(".test_txt").html(_browser);
        }else{
          _browser = 'safari';
          $("html").addClass("safari");
          $(".test_txt").html(_browser);
        }
      } else if(agent.indexOf('firefox') > -1) { // Firefox
        _browser = 'firefox';
      }
    },
    commonPartCallFn: function(){
      if($("#wrap").hasClass("main")){
        $("header").empty().load("./header.html");
        $("footer").empty().load("./footer.html", function() {
          commonScript.commonMotion();
          commonScript.gnbFn();
          commonScript.resizeFn();
          commonScript.stickNavigationyFn();
          commonScript.totalSrch();
          commonScript.customScrollFn();
        });
      }else{
        $("header").empty().load("../header.html");
        $("footer").empty().load("../footer.html", function() {
          commonScript.commonMotion();
          commonScript.gnbFn();
          commonScript.resizeFn();
          commonScript.stickNavigationyFn();
          commonScript.totalSrch();
          commonScript.customScrollFn();
        });
      }
    },
    commonMotion: function(){
      tabTriggerReset(); // our field txt 고정 트리거 함수 호출


      $(".btn_top").on("click", function(){
        gsap.to($("html, body"), 1.5, {scrollTop:0, ease:Power3.easeOut});
      });

      if($("#wrap").hasClass("sub")){
        $("#header").addClass("up_scroll");
      }

      // footer family site 열기
      $("footer .family_site .open_btn").on("click", function(){
        $("body").addClass("overflow_hidden");
        $(".family_site_popup").fadeIn(300);
        $(".family_site_popup .pop_con").css({"marginTop": -$(".family_site_popup .pop_con").innerHeight()*.5, "marginLeft": -$(".family_site_popup .pop_con").innerWidth()*.5})
        $(".family_site_popup .pop_con").attr("tabindex", 0).focus();
      });

      // footer family site 닫기
      $(".family_site_popup .pop_con .close_btn").on("click", function(){
        $("body").removeClass("overflow_hidden");
        $(".family_site_popup").fadeOut(300);
        $("footer .family_site .open_btn").attr("tabindex", 0).focus();
      });

      // ie 일때 말줄임
      if(_browser == "ie"){
        // $(".card_list .title").addClass("ie");
        $(".ir_news_list .title").addClass("ie");
        $(".total_srch_area .srch_con_list .con_txt").addClass("ie");
      }

      // Sustainability > 동반성장개요 페이지
      if($(".sus_growth_sum").size() != 0){
        $("html").addClass("sus_growth_sum_page");
      }

      // tab 버튼 title값 변경
      if($(".tab_btn_area").size() > 0){
        $(".tab_btn_area").find("button").each(function(q){
          $(this).on("click", function(){
            $(".tab_btn_area").find("button").removeClass("on");
            $(this).addClass("on");
            $(".tab_btn_area").find("button").attr("title","선택안됨");
            $(this).attr("title","선택됨");
            if($(".sub_visual.business").size() <= 0){
              $("*").not(".tab_btn_area, .sub_visual").removeClass("active");
            }

            if($(".sub_our_field").size() > 0){
              if(q == 3){
                $("#cont_wrap").addClass("pb0");
              }else{
                $("#cont_wrap").removeClass("pb0");
              }
            }

            if($(".total_srch_area").size() > 0){
              if(q == 0){
                $(".tab_con").show()
              }else{
                $(".tab_con").hide();
                $(".tab_con").eq(q-1).show();
              }
            }else{
              $(".tab_con").hide();
              $(".tab_con").eq(q).show();
            }

            scrollMotionTrigger()
            tabTriggerReset();// our field txt 고정 트리거 함수 호출
            $(window).scroll();
          });
        })
      }

      // 체크아이콘 눌렀을 시, 팝업 열 때
      $(".btn_open_pop").on("click", function(){
        $(".dimd").addClass("top_index");

        if(!$(this).hasClass("checked")){ // 동의하기 전
          _popupId = '#' + $(this).attr("data-target");
          _target = $(this);
          $(".dimd").fadeIn();
          $(_popupId).fadeIn().attr("tabindex","0").focus();

          if(window.innerWidth <= 1023){
            $(".letter_agree_pop .pop_con .custom_scroll_area").css("max-height", $(".letter_agree_pop:visible .pop_con").height() - 30 - $(".letter_agree_pop:visible .pop_con .small_tit").height() - $(".letter_agree_pop:visible .pop_con .cho_btn_area").height() - 20);
          }
          
          $("body").addClass("overflow_hidden");
        }else{ // 동의한 후
          $(this).removeClass("checked").parents(".list").removeClass("on");
          _titleTxt =  $(this).parents(".list").find(".chk_txt_area button span").html();
          $(this).parents(".list").find("button").attr("title", _titleTxt + " 팝업 열기");
          if($(".pr_newsletter .agree_list_w .list .chk_icon_area button.checked").size() != $(".pr_newsletter .agree_list_w .list").size()){
            $(".pr_newsletter .agree_area .btn_total_agree").removeClass("on");
          }
        }
      });
      
      // 전체동의 버튼 눌렀을 시
      $(".btn_total_agree").on("click", function(){
        _target = $(this);

        if(!$(this).hasClass("on")){
          $(this).addClass("clicked");
          $(".dimd").fadeIn();
          $(".pop_up").fadeIn().attr("tabindex","0");
          $(".pop_up").eq(0).focus();
          $("body").addClass("overflow_hidden");
        }else{
          $(".pr_newsletter .agree_list_w .list").removeClass("on");
          $(".pr_newsletter .agree_list_w .list .chk_icon_area button").removeClass("checked");
          $(this).removeClass("on");

          $(".pr_newsletter .agree_list_w .list").each(function(q){
            $(".pr_newsletter .agree_list_w .list").eq(q).find("button").attr("title", $(".pr_newsletter .agree_list_w .list").eq(q).find(".chk_txt_area button span").html() + " 팝업 열기");
          });          
        }
      });

      // 팝업 닫기 눌렀을 시
      $(".pop_close").on("click", function(){
        if($(".btn_total_agree").hasClass("clicked")){
          if($(".pop_up:visible").size() == 1){
            $(this).parents(".pop_up").fadeOut();
            $(".dimd").fadeOut(function(){
              $(".dimd").removeClass("top_index");
            });
            $("body").removeClass("overflow_hidden");
            _target.attr("tabindex","0").focus();
            $(".btn_total_agree").removeClass("clicked");
          }else{
            $(this).parents(".pop_up").hide();
          }
        }else{
          $(this).parents(".pop_up").fadeOut();

          if($(".pop_up:visible").size() == 1){
            $(".dimd").fadeOut(function(){
              $(".dimd").removeClass("top_index");
            });
            $("body").removeClass("overflow_hidden");
            _target.attr("tabindex","0").focus();
          }
        }
      });

      // 만14 이상 동의 버튼 눌렀을 경우
      $(".btn_open_pop2").on("click", function(){
        if($(".btn_open_pop2").hasClass("checked") === true) {
            $(".pr_newsletter .agree_list_w .list").eq(1).removeClass("on");
            $(".pr_newsletter .agree_list_w .list").eq(1).find(".chk_icon_area button").removeClass("checked");
        } else {
            $(".pr_newsletter .agree_list_w .list").eq(1).addClass("on")
            $(".pr_newsletter .agree_list_w .list").eq(1).find(".chk_icon_area button").addClass("checked");
        }
      });
      
      // 동의 버튼 눌렀을 경우
      $(".btn_agree").on("click", function(){
        //_newsLetterCount++;

        $(".pr_newsletter .agree_list_w .list").eq($(this).parents(".pop_up").index()).addClass("on");

        _titleTxt = $(".pr_newsletter .agree_list_w .list").eq($(this).parents(".pop_up").index()).find(".chk_txt_area button span").html();

        $(".pr_newsletter .agree_list_w .list").eq($(this).parents(".pop_up").index()).find(".chk_icon_area button").attr("title", _titleTxt + " 동의 해제");
        $(".pr_newsletter .agree_list_w .list").eq($(this).parents(".pop_up").index()).find(".chk_icon_area button").addClass("checked");

        if($(".pr_newsletter .agree_list_w .list .chk_icon_area button.checked").size() == $(".pr_newsletter .agree_list_w .list").size()){
          $(".pr_newsletter .agree_area .btn_total_agree").addClass("on");
        }
      });

      // 거부 버튼 눌렀을 경우
      $(".btn_denial").on("click", function(){
        $(".pr_newsletter .agree_list_w .list").eq($(this).parents(".pop_up").index()).removeClass("on");
        $(".pr_newsletter .agree_list_w .list").eq($(this).parents(".pop_up").index()).find(".chk_icon_area button").attr("title", _titleTxt + " 팝업 열기");
        $(".pr_newsletter .agree_list_w .list").eq($(this).parents(".pop_up").index()).find(".chk_icon_area button").removeClass("checked");

        $(".pr_newsletter .agree_area .btn_total_agree").removeClass("on");
      });
    },
    gnbFn: function(){
      var gnbNum = -1;

      if($("#header").size() != 0){
        $("#header nav .gnb").on("mouseenter focusin", function(){
          $("#header").addClass("mouse_hover overflow_hidden");
          $(".dimd").stop(true, true).fadeIn(400);
        });
  
        $("#header nav .gnb").on("mouseleave", function(){
          $("#header").removeClass("mouse_hover overflow_hidden");
          $(".dimd").stop(true, true).fadeOut(400);
          $("#header nav .gnb > li .two_pack").css("display","none");
          $("#header nav .gnb > li").removeClass("on");
          $("#header nav .gnb > li .two_pack > li").removeClass("on");
        });
  
        $("#header nav .gnb > li").each(function(q){
          //$(this).mouseenter(function(){
          $(this).on("mouseenter focusin", function(){
            if(gnbNum != $(this).index()){
              $("#header nav .two_pack > li").removeClass("on");
            }
  
            $(this).siblings().removeClass("on");
            $(this).addClass("on");
            $("#header nav .gnb > li .two_pack").css("display","none");
            $("#header nav .gnb > li").eq($(this).index()).find(".two_pack").css("display","table");
  
            gnbNum = $(this).index();
          });
        });
  
        $("#header nav .two_pack > li").each(function(q){
          $(this).mouseenter(function(){
            $(this).siblings().removeClass("on");
            $(this).addClass("on");
          });
        });
  
        // 전체메뉴-열기
        $("#header .util_area .btn_menu").on("click", function(){        
          $(".all_menu").fadeIn(200, function(){
            //$(".all_menu").addClass("open"); // 2021-06-22 whale 브라우저때문에 삭제처리 (웨일은 스크롤바 영역을 차지하지 않음)
            $("body").addClass("overflow_hidden");
            gsap.to($(".all_menu .gnb"), 1, {opacity:1, delay:0.2, ease:Power3.easeOut});
            if(window.innerWidth < 768) {
              gsap.to($(".all_menu .bottom_fixed_area"), 1, {opacity:1, delay:0.27, ease:Power3.easeOut});
            }
          });
        });

        // 언어선택 팝업 열기
        $("#header .util_area .lang_area .btn_lang").on("click", function(){
          $("#header .util_area .lang_area .lang_open").show();
        });

        // 언어선택 팝업 닫기
        $("#header .util_area .lang_area .lang_open a:first-child").on("click", function(){
          $("#header .util_area .lang_area .lang_open").hide();
        });
      }

      if($(".all_menu").size() != 0){
        // 전체메뉴-닫기
        $(".all_menu .btn_close").on("click", function(){
          $(".all_menu").removeClass("open clicked");
          $("body").removeClass("overflow_hidden");
  
          $(".all_menu").fadeOut(200, function(){
            $(".all_menu .gnb").addClass("initial");
            $(".all_menu .gnb > li .one_depth").removeClass("on");
            $(".all_menu .gnb > li .two_pack_wrap").slideUp(0);
            gsap.to($(".all_menu .gnb"), 0, {opacity:0});
            if(window.innerWidth < 768) {
              gsap.to($(".all_menu .bottom_fixed_area"), 0, {opacity:0});
            }
            curAllMenuNum = -1;
          });
        });
  
        // 전체메뉴 아코디언
        var curAllMenuNum = -1;
        $(".all_menu .gnb > li .one_depth").each(function(q){
          $(this).on("click", function(){
            $(".all_menu").addClass("clicked");
  
            if(curAllMenuNum == q){
              $(".all_menu").removeClass("clicked");
              $(".all_menu .gnb").addClass("initial");
              $(".all_menu .gnb > li .one_depth").removeClass("on");
              $(".all_menu .gnb > li").eq(q).find(".two_pack_wrap").stop(true, true).slideUp(350);
  
              curAllMenuNum = -1;
              $(".all_menu .gnb > li .one_depth").attr("title","하위 메뉴 열기");
              
            }else{
              $(".all_menu .gnb").removeClass("initial");
              $(".all_menu .gnb > li .one_depth").removeClass("on");
              $(".all_menu .gnb > li .two_pack_wrap").stop(true, true).slideUp(350);
              $(".all_menu .gnb > li .one_depth").attr("title","하위 메뉴 열기");
              curAllMenuNum = q;
              $(this).attr("title","하위 메뉴 닫기");
              $(this).addClass("on");
              $(this).next().stop(true, true).slideDown(350);
            }
          });
        });
      }
    },
    stickNavigationyFn: function(){
      setTimeout(function () {
        if(!$(".sticky_area .button_open").hasClass("on")){
          $(".sticky_area .button_open").addClass("on");
        }
      },1500);

      $(".sticky_area .button_open").on("click", function(){
        $(".sticky_area .nav_popup").css("opacity",1);
        gsap.to($(".sticky_area .nav_popup"), 1, {bottom:0, ease:Power4.easeOut});
      });

      $(".sticky_area .nav_popup .button_close").on("click", function(){
        if(_deviceCondition == "pc"){
          gsap.to($(".sticky_area .nav_popup"), 1.2, {bottom:-500, ease:Power4.easeOut});
        }else{
          $(".sticky_area .nav_popup").css("opacity",1);
          gsap.to($(".sticky_area .nav_popup"), 1.2, {bottom:-$(".sticky_area .nav_popup").innerHeight(), ease:Power4.easeOut});
        }
      });
    },
    totalSrch : function(){
      $(".btn_sch").on("click", function(){
        $(".total_srch_menu").fadeIn(300, function(){
          $(".total_srch_menu .srch_content").addClass("active")
        });
        $("body").addClass("overflow_hidden");
      });

      $(".total_srch_menu .close_btn").on("click", function(){
        $(".total_srch_menu").fadeOut(300, function(){
          $(".total_srch_menu .srch_content").removeClass("active")
        });
        $("body").removeClass("overflow_hidden");
      });
    },
    customScrollFn: function(){
      if($(".custom_scroll").size() != 0){
        $(".custom_scroll").mCustomScrollbar();
      }
    },
    scrollFn: function(){
      // not IE
      $(window).on("scroll", function(){
        _isScrollTop =  $(window).scrollTop();

        if(_isScrollTop >= 100){
          $(".btn_top").fadeIn(300);
          if(_deviceCondition == "pc"){
            if($(".sticky_area").size() != 0){
              gsap.to((".sticky_area .button_open"), 0.8, {bottom:120, ease:Power3.easeOut});
            }
          }else{
            if($(".sticky_area").size() != 0){
              gsap.to((".sticky_area .button_open"), 0.8, {bottom: 58, ease:Power3.easeOut});
            }
          }
        }else{
          $(".btn_top").fadeOut(300);
          if(_deviceCondition == "pc"){
            if($(".sticky_area").size() != 0){
              gsap.to((".sticky_area .button_open"), 0.8, {bottom:60, ease:Power3.easeOut});
            }
          }else{
            if($(".sticky_area").size() != 0){
              gsap.to((".sticky_area .button_open"), 0.8, {bottom:0, ease:Power3.easeOut});
            }
          }
        }

        if($(".lnb_area").size()!=0){
          if(_isScrollTop >= $(".lnb_area").offset().top + $(".lnb_area").innerHeight() - 100){          
              $(".lnb_area .lnb_wrap").addClass("fixed");
          }else{
              $(".lnb_area .lnb_wrap").removeClass("fixed");
          }
        }

        if(_isScrollTop > _this_scroll) { // down
          if(_isScrollTop > 0){
            if($("#header").size() != 0){
              if($("#wrap").hasClass("sub_our_field")){
                gsap.to(("#header"), 1, {top:-110, ease:Power3.easeOut});
              }else{
                if($(window).scrollTop() > 100){
                  gsap.to(("#header"), 1, {top:-110, ease:Power3.easeOut});
                }
              }
            }
          }
        }
        
        if(_isScrollTop < _this_scroll) { // up
          if(_isScrollTop != 0 && _isScrollTop > 0){
            $("#header").addClass("up_scroll");
            gsap.to(("#header"), 1.3, {top:0, ease:Power3.easeOut});
            $("#header.typeb").removeClass("top");
          }else{
            if(!$("#wrap").hasClass("sub")){
              $("#header").removeClass("up_scroll");
            }
            gsap.to(("#header.typeb"), 1.3, {top:50, ease:Power3.easeOut});
            $("#header.typeb").addClass("top");
          }
        }
        _this_scroll = _isScrollTop;

        //scrollMotion
        /*if($(".scrollMotion").length != 0){
          $(".scrollMotion").each(function(index){ 
            if(_isScrollTop + $(window).height() > _getScrollObjY()[index]) $(".scrollMotion").eq(index).addClass("active");
          });
        }
        //scrollMotion2
        if($(".scrollMotion2").length != 0){
          $(".scrollMotion2").each(function(index){
            if(_isScrollTop + $(window).height() > _getScrollObjY2()[index]) $(".scrollMotion2").eq(index).addClass("active");
          });
        }*/
      });$(window).scroll()

      // for IE > Sustainability > 동반성장 개요
      $("body").on("scroll", function(){
        _isScrollTop =  $("body").scrollTop();

        if(_isScrollTop >= 100){
          $(".btn_top").fadeIn(300);
        }else{
          $(".btn_top").fadeOut(300);
        }

        /*if(_isScrollTop + $(window).height() >= $("footer").offset().top){
          $(".btn_top").addClass("on")
        }else{
          $(".btn_top").removeClass("on")
        }*/

        if($(".lnb_area").size()!=0){
          if(_isScrollTop >= $(".lnb_area").offset().top + $(".lnb_area").innerHeight() - 100){          
              $(".lnb_area .lnb_wrap").addClass("fixed");
          }else{
              $(".lnb_area .lnb_wrap").removeClass("fixed");
          }
        }

        if(_isScrollTop > _this_scroll) { // down
          if(_isScrollTop > 0){
            if($("#header").size() != 0){
              gsap.to(("#header"), 1, {top:-110, ease:Power3.easeOut});
            }
          }
        }
        
        if(_isScrollTop < _this_scroll) { // up
          if(_isScrollTop != 0 && _isScrollTop > 0){
            $("#header").addClass("up_scroll");
            gsap.to(("#header"), 1.3, {top:0, ease:Power3.easeOut});
            $("#header.typeb").removeClass("top");
          }else{
            if(!$("#wrap").hasClass("sub")){
              $("#header").removeClass("up_scroll");
            }
            gsap.to(("#header.typeb"), 1.3, {top:50, ease:Power3.easeOut});
            $("#header.typeb").addClass("top");
          }
        }
        _this_scroll = _isScrollTop;
      });

    },
    swiperFn: function(){
      lnbSwiper = new Swiper('.lnb_wrap .swiper-container', {
        //speed : 1500,
        slidesPerView : 'auto',
        //observer : true,
        //observeParents : true,
        //allowTouchMove: false,
        on : {
          init: function(){
            //this.slideTo($(".lnb_wrap .swiper-container .btn_lnb.on").index());
          },
          transitionEnd : function(){
            $(".lnb_area").removeClass("start");
            $(".lnb_area").removeClass("end");

            if(lnbSwiper.isEnd) {
              $(".lnb_area").addClass("end");
            }
            if(lnbSwiper.isBeginning) {
              $(".lnb_area").addClass("start");
            }

            if($(".lnb_wrap .swiper-wrapper").position().left <= 0){
              $(".lnb_area").addClass("start");
            }else{
              $(".lnb_area").removeClass("start");
            }
          }
        }
      });

      if($(".lnb_wrap").size() > 0){
        lnbSwiper.slideTo($(".lnb_wrap .swiper-container .btn_lnb.on").index())
      }

      tabSwiper = new Swiper('.tab_btn_area.swiper-container', {
        //speed : 1500,
        slidesPerView : 'auto',
        observer : true,
        observeParents : true,
        //allowTouchMove: false,
        on : {
          init: function(){
          },
        }
      });
    },
    accordionFn: function(){
      $(".accordion_type .list").each(function(q){
        $(this).find(".click_con").on("click", function(){
          if(!$(this).parents(".list").hasClass("on")){
              $(this).attr("title","내용 닫기");
              $(this).parents(".list").addClass("on");
              $(this).parents(".list").find(".hide_con").stop(true, true).slideDown(300);
          }else{
            $(this).attr("title","Open Content");
            $(this).parents(".list").removeClass("on");
            $(this).parents(".list").find(".hide_con").stop(true, true).slideUp(300);
          }
        });
      });
    },
    selectFn: function(){
      var familySiteOptNum = [];

      $(".select_wrap").each(function(q){
        $(this).find("select").on("click", function(){
          if(!$(this).hasClass("open")){
            $(this).addClass("open");
            $(this).parents(".select_wrap").addClass("on");
          }else{
            $(this).removeClass("open");

            if(familySiteOptNum[q] == $(this).find("option:selected").index()){
              $(this).parents(".select_wrap").removeClass("on");
            }

            familySiteOptNum[q] = $(this).find("option:selected").index();
            $(this).parents(".select_wrap").removeClass("on");
          }
        });


        $(this).find("select").on("focus", function(){
          $(this).parents(".select_wrap").addClass("on")
          $(".test_txt").html("focus");
        });

        $(this).find("select").on("focusout", function(){
          $(".test_txt").html("focusout");
        });

        $(this).find("select").on("blur", function(){
          $(this).removeClass("open");
          $(this).parents(".select_wrap").removeClass("on")
          $(".test_txt").html("blur");
        });

        $(this).find("select").on("change", function(){
          $(this).parents(".select_wrap").removeClass("on")
          $(".test_txt").html("change");
        });
      });
    },
    resizeFn: function(){
      $(window).resize(function(){
        $(".total_srch_menu").height(window.innerHeight);
        $(".family_site_popup .pop_con").css({"marginTop": -$(".family_site_popup .pop_con").innerHeight()*.5, "marginLeft": -$(".family_site_popup .pop_con").innerWidth()*.5});

        if($("#header .gnb").is(":visible") == false){
          $("#header").removeClass("mouse_hover overflow_hidden");
        }else{
          if($("#header nav .gnb > li").hasClass("on")){
            $("#header").addClass("mouse_hover overflow_hidden");
          }
        }


        if(window.innerWidth > 1023 ){
          // about us > 뉴스레터 구독
          $(".letter_agree_pop .pop_con .custom_scroll_area").css("max-height", "306px");
        }else{
          // about us > 뉴스레터 구독
          $(".letter_agree_pop .pop_con .custom_scroll_area").css("max-height", $(".letter_agree_pop:visible .pop_con").height() - 30 - $(".letter_agree_pop:visible .pop_con .small_tit").height() - $(".letter_agree_pop:visible .pop_con .cho_btn_area").height() - 20);
        }

        // 해상도 따른 pc, mobile 구분
        if(window.innerWidth > 768 ){ // pc
          _deviceCondition = "pc";

          if($(".sticky_area").size() > 0){
            gsap.to($(".sticky_area .button_open"), 0, {bottom: 58, ease:Power3.easeOut});
            gsap.to($(".sticky_area .nav_popup"), 0, {bottom: -500, ease:Power3.easeOut});
          }
        }else{ // mobile
          _deviceCondition = "mobile";

          if($(".sticky_area").size() > 0){
            gsap.to($(".sticky_area .button_open"), 0, {bottom: 0, ease:Power3.easeOut});
            gsap.to($(".sticky_area .nav_popup"), 0, {bottom:-$(".sticky_area .nav_popup").innerHeight(), ease:Power3.easeOut});
          }
        }

        if(_browser == "ie" && $(".sus_growth_sum").size() != 0){
          // fixed 되는 요소 너비값 지정 (미지정 시 스크롤 바 위를 덮어버림)
          $("#header, .footer_bg, .go_con, .all_menu, .dimd").width($("#wrap").width());
        }

      }).resize();
    },
    printFn: function(){
      window.onbeforeprint = function (ev) {
        $(".scrollMotion, .scrollMotion2").addClass("active");

        $("#header").addClass("for_print").css("top",0);
        $("header.business").addClass("for_print");
        $("header.business").removeClass("scroll");
        $(".sub_our_field .cloud_area .cloud_bg_area").addClass("for_print");

        $(".table_type .table_wrap").css("overflow-x","hidden"); // table 가로 스크롤 해제
        $(".table_type .table_wrap table").css("width","100%");

        $(".tab_btn_area.full").addClass("for_print");
        $(".tab_btn_area.full .swiper-wrapper").css("width","100%");

        $(".policy_div .pin-spacer").removeAttr("style"); // 빌링시스템 이용약관 강제로 fixed 풀기
        $(".policy_div .fixed_area").removeAttr("style"); 

        $(".service_sec .fixed_area .pin-spacer").removeAttr("style");
        $(".service_sec .fixed_area .img_box").removeAttr("style"); // 모든 법인 페이지 imgbox 강제로 fixed 풀기

        // $(".sub_our_field .txt_fixed_area .pin-spacer").removeAttr("style");
        // $(".sub_our_field .txt_fixed_area .fixed_txt").removeAttr("style");// 아워필드 고정 텍스트 강제로 fixed 풀기

        $(".sub_our_field .parallax_area .parallax_img").css("top", 0);

        $(".sub_our_field .cloud_area .pin-spacer").removeAttr("style");
        $(".sub_our_field .cloud_area .cloud_bg_area").removeAttr("style");
        $(".sub_our_field .cloud_area .cloud_bg_area .bg").removeAttr("style");
        $(".sub_our_field .cloud_area .cloud_txt_area .of_small_tit").removeClass("font_white");

        $(".company_info .fixed_visual .pin-spacer").removeAttr("style");
        $(".company_info .fixed_visual .bg_area").removeAttr("style");

        $(".about_his .his_list .pin-spacer").removeAttr("style"); // 연혁
        $(".about_his .his_list .img_wrap").removeAttr("style");
        $(".about_his .his_list .img_wrap .img_area").removeAttr("style");
      };

      window.onafterprint = function (ev) {
        location.reload();
      };

      $('.print_btn').on("click",function() {
        //gsap.to($("#cont_wrap"), 0, {scale: 0.8});

        
        
        /*gsap.to($("#header"), 0, {width: "60%", left:"50%", x:"-50%"});
        gsap.to($("footer"), 0, {width: "50%", left:"50%", x:"-50%"});*/


        // $("body").css("zoom", ".5")
        // $("footer").css("zoom", ".62")
        // $("header").css("zoom", ".62")
        // gsap.to($("#wrap"), 0, {width: "100%"});
        if($("html.ie").size() > 0){
          //gsap.to($("#wrap"), 0, {width: 2600, scale:0.6, transformOrigin: "center top", left:"50%", x:"-50%"});
          // gsap.to($("html.ie .parallax_area .parallax_img img"), 0, {position: "static", x:0, y:0});

          // $("#cont_wrap").css("zoom", ".5")
          // $("footer").css("zoom", ".62")
          // $("header").css("zoom", ".62")
        }

        window.print();
        location.reload();
      });
    },
  }
})();

$(window).on("load", function(){
  commonScript.deviceChk();
  //commonScript.commonPartCallFn();
  commonScript.commonMotion();  
  commonScript.stickNavigationyFn();
  commonScript.totalSrch();
  commonScript.scrollFn();
  commonScript.swiperFn();
  commonScript.accordionFn();
  commonScript.selectFn();
  commonScript.resizeFn();
  commonScript.printFn();
  commonScript.customScrollFn();
  //commonScript.testFn();
});

$(document).on("ready", function(){
  commonScript.gnbFn();
});


function tabTriggerReset() {
  // our field 왼쪽 텍스트 고정 공통
  // about us 사업장 유럽법인 career
  if($(".sub_our_field .txt_fixed_area").size() > 0){
    ScrollTrigger.matchMedia({
      "(min-width : 1024px)": function(){
        gsap.to(".txt_fixed_area .right_div", {
          scrollTrigger: {
            trigger: ".txt_fixed_area .left_div .fixed_txt",
            start: "-200px 0",
            endTrigger: $(".txt_fixed_area .right_div .con_div:last-child"),
            end:"top-=50px 200px",
            //end:$(".business_area .txt_box").outerHeight() + 280,
            //scrub: true,
            pin:true,
            //markers: true,
          },
        });
      }
    });
  }
}