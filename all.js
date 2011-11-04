// All the jQuery function that WordPress used
// Add empty span tag at menu which have drop-down meun
jQuery("ul.sub-menu:not(.sub-menu .sub-menu)").parent().append('<div class="menu-mark" ></div>');
jQuery("ul.children:not(.children .children)").parent().append('<div class="menu-mark" ></div>');

jQuery("ul.sub-menu ul.sub-menu:not(.sub-menu .sub-menu .sub-menu)").parent().append('<div class="menu-mark2" ></div>');
jQuery("ul.children ul.children:not(.children .children .children)").parent().append('<div class="menu-mark2" ></div>');

// Drop down menu slide function
var mouseover_tid = [];
var mouseout_tid = [];
jQuery('.header_menu ul > li').each(function(index) {
	jQuery(this).hover(function() {
		var _self = this;
		clearTimeout(mouseout_tid[index]);
		mouseover_tid[index] = setTimeout(function() {
			jQuery(_self).find('ul:eq(0)').slideDown('fast');
		},
		200);
	},
	function() {
		var _self = this;
		clearTimeout(mouseover_tid[index]);
		mouseout_tid[index] = setTimeout(function() {
			jQuery(_self).find('ul:eq(0)').slideUp('fast');
		},
		200);
	});
});
// Top colourful bar
jQuery(document).ready(function() {
	jQuery("#top-bar").animate({
		width: "100%"
	},
	{
		queue: false,
		duration: 5000
	});
	// Mouse over search box focus function
	jQuery("#s").mouseover(function() {
		jQuery(this).focus().val([""]);
	});
	// Link sparkling function
	jQuery(".post_meta li,body a:not(.post_meta li a)").hover(function() {
		if (!jQuery(this).is(":animated")) {
			jQuery(this).animate({
				opacity: ".7"
			},
			220).animate({
				opacity: "1"
			},
			180);
		}
	});
	jQuery(function() {
		jQuery('a[href*=#]').click(function() {
			if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
				var $target = jQuery(this.hash);
				$target = $target.length && $target || jQuery('[name=' + this.hash.slice(1) + ']');
				if ($target.length) {
					var targetOffset = $target.offset().top - 100;
					jQuery('html,body').animate({
						scrollTop: targetOffset
					},
					1000);
					return false;
				}
			}
		});
	});
	// hide #return_top first
	jQuery("#return_top").hide();
	// fade in #return_top
	jQuery(function() {
		jQuery(window).scroll(function() {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('#return_top').fadeIn();
			} else {
				jQuery('#return_top').fadeOut();
			}
		});
	});

	// When a link is clicked
	jQuery("a.tab").click(function() {

		// switch all tabs off
		jQuery(".active").removeClass("active");

		// switch this tab on
		jQuery(this).addClass("active");

		// slide all content up
		jQuery(".content").slideUp();

		// slide this content up
		var content_show = jQuery(this).attr("title");
		jQuery("#" + content_show).slideDown();

	});

	jQuery('#tab-title span').click(function() {
		jQuery(this).addClass("selected").siblings().removeClass();
		jQuery("#tab-content > .widget-container").slideUp('1500').eq(jQuery('#tab-title span').index(this)).slideDown('1500');
	});

});