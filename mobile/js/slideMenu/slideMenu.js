

//function mobile_nav(opener, closer, target) {
$.slideMenu = function(opener, closer, target) {
	var total_width = $(target).outerWidth();

	$(target).parent().css({'z-index':'-99'});

	$_show = function(event) {
		//$('body').addClass('nav-visible');
		$(target).addClass('open');
		$(target).parent().css({'z-index':99});
		$('body, html').css('overflow', 'hidden');
		setTimeout(function() {
			$('body').addClass('nav-visible');
		}, 100);
		
	}

	$_hide = function(event) {
		$('body').removeClass('nav-visible');
		$(target).removeClass('open');
		$('body, html').css('overflow', '');
		$(target).parent().delay(500).queue(function (next) {
			 $(this).css('z-index', '-99');
			 next();
		});
	}


	$(opener).on('click touchend', function(e) {
		if(!$(target).hasClass('open'))
			$_show(event);
	});

	$('body').on('click touchend', function(e) {
		if($(this).hasClass('nav-visible')) {
			var container = $(opener+','+target);
			if (!$(e.target).closest(container).length) {
				$_hide(e);
			}
		}
	});
	

	$(closer).on('click touchend', function(e) {
		if($(target).hasClass('open'))
			$_hide(event);
	});
	
}



$.sidebarMenu = function(menu) {
	var animationSpeed = 250,
	subMenuSelector = menu.find('.sub2cha_ul');
	subMenuSelector_except = menu.find('li:not(.defaultOpen) .sub2cha_ul');
	
	$(subMenuSelector_except).css({"display": "none"});
	$(subMenuSelector).parent("li").removeClass("on");
	$(subMenuSelector).parent("li").find(".dep1_link").addClass("opener");
	$(subMenuSelector).parent("li").find("a.dep1_link").attr("href", "#"); //서브메뉴가 있는 대메뉴 링크값 지우기

	$(subMenuSelector_except).parent("li.active").children("ul").slideDown(animationSpeed); 
	$(subMenuSelector).children("li.active").parent().parent("li").addClass("open");
	$(subMenuSelector).children("li.active").parent("ul").slideDown(animationSpeed); 
	$(subMenuSelector).children("li.active").parent("ul").addClass("menu-open");

	$(menu).on('click', 'li .opener', function(e) {
		var $this = $(this);
		var checkElement = $this.next();
		if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
			checkElement.slideUp(animationSpeed, function() {
				checkElement.removeClass('menu-open');
			});
			checkElement.parent("li").removeClass("open");
		}

		//If the menu is not visible
		else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
			var parent = $this.parents('ul:not(.sub3cha_ul)').first(); //Get the parent menu
			var ul = parent.find('ul:not(.sub3cha_ul):visible').slideUp(animationSpeed); //Close all open menus within the parent
			ul.removeClass('menu-open'); //Remove the menu-open class from the parent
			var parent_li = $this.parent("li"); //Get the parent li

			//Open the target menu and add the menu-open class
			checkElement.slideDown(animationSpeed, function() {
				checkElement.addClass('menu-open');
				parent.find('li.open').removeClass('open');
				parent_li.addClass('open');
			});
		}
		//if this isn't a link, prevent the page from being redirected
		if (checkElement.is(subMenuSelector)) {
			e.preventDefault();
		}
	});

}



$(document).ready(function(){
	$.slideMenu('#header .menuOpener', '#navContainer .menuCloser', '.navContainer-inner');
	$.sidebarMenu($('#navContainer .nav_ul'));
});