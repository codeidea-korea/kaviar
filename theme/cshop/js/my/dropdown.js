/*
	sidebar-menu.js
*/

$.sidebarMenu = function(menu) {
	var animationSpeed = 250,
	subMenuSelector = menu.find('.shopCate_2cha_ul');
	subMenuSelector_except = menu.find('li:not(.defaultOpen) .shopCate_2cha_ul');
	
	$(subMenuSelector_except).css({"display": "none"});
	//$(subMenuSelector).parent("li").find(".a_1cha").addClass("opener"); //링크값이 없는(.null)일때는 a태그도 오프너
	$(subMenuSelector).parent("li").find(".a_1cha").after('<span class="opener icon">메뉴열기</span>');
	//$(subMenuSelector).parent("li").find("a.dep1_link").attr("href", "#") //서브메뉴가 있는 대메뉴 링크값 지우기
	
	$(subMenuSelector).parent("li.active").addClass("open");
	//$(subMenuSelector).parent("li.active").children("ul").slideDown(animationSpeed);
	$(subMenuSelector_except).parent("li.active").children("ul").slideDown(animationSpeed); 
	$(subMenuSelector).parent("li.active").children("ul").addClass("menu-open");

	$(subMenuSelector).children("li.active").parent().parent("li").addClass("open");
	$(subMenuSelector).children("li.active").parent("ul").slideDown(animationSpeed); 
	$(subMenuSelector).children("li.active").parent("ul").addClass("menu-open");	

	$(menu).on('click', 'li .opener', function(e) {
		var $this = $(this);
		//var checkElement = $this.next();
		var checkElement = $this.parent().find('.shopCate_2cha_ul');
		if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
			checkElement.slideUp(animationSpeed, function() {
				checkElement.removeClass('menu-open');
			});
			checkElement.parent("li").removeClass("open");
		}

		//If the menu is not visible
		else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
			var parent = $this.parents('ul:not(.sub3cha_ul)').first(); //Get the parent menu
			var ul = parent.find('li:not(.defaultOpen) ul:not(.sub3cha_ul):visible').slideUp(animationSpeed); //Close all open menus within the parent
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

$(document).ready(function () {
	$.sidebarMenu($('._shopCate .shopCate_1cha_ul'));
});
