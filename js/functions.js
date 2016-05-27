/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */

 /* BackgroundCheck
   http://kennethcachia.com/background-check
   v1.2.2 */

!function(a,b){"function"==typeof define&&define.amd?define(b):a.BackgroundCheck=b(a)}(this,function(){"use strict";function a(a){if(void 0===a||void 0===a.targets)throw"Missing attributes";H.debug=d(a.debug,!1),H.debugOverlay=d(a.debugOverlay,!1),H.targets=g(a.targets),H.images=g(a.images||"img",!0),H.changeParent=d(a.changeParent,!1),H.threshold=d(a.threshold,50),H.minComplexity=d(a.minComplexity,30),H.minOverlap=d(a.minOverlap,50),H.windowEvents=d(a.windowEvents,!0),H.maxDuration=d(a.maxDuration,500),H.mask=d(a.mask,{r:0,g:255,b:0}),H.classes=d(a.classes,{dark:"background--dark",light:"background--light",complex:"background--complex"}),void 0===B&&(h(),B&&(C.style.position="fixed",C.style.top="0px",C.style.left="0px",C.style.width="100%",C.style.height="100%",window.addEventListener(G,x.bind(null,function(){k(),w()})),window.addEventListener("scroll",x.bind(null,w)),k(),w()))}function b(){B=null,C=null,D=null,H={},E&&clearTimeout(E)}function c(a){z("debug")&&console.log(a)}function d(a,b){return e(a,typeof b),void 0===a?b:a}function e(a,b){if(void 0!==a&&typeof a!==b)throw"Incorrect attribute type"}function f(a){for(var b,d,e=[],f=0;f<a.length;f++)if(b=a[f],e.push(b),"IMG"!==b.tagName){if(d=window.getComputedStyle(b).backgroundImage,d.split(/,url|, url/).length>1)throw"Multiple backgrounds are not supported";if(!d||"none"===d)throw"Element is not an <img> but does not have a background-image";e[f]={img:new Image,el:e[f]},d=d.slice(4,-1),d=d.replace(/"/g,""),e[f].img.src=d,c("CSS Image - "+d)}return e}function g(a,b){var c=a;if("string"==typeof a?c=document.querySelectorAll(a):a&&1===a.nodeType&&(c=[a]),!c||0===c.length||void 0===c.length)throw"Elements not found";return b&&(c=f(c)),c=Array.prototype.slice.call(c)}function h(){C=document.createElement("canvas"),C&&C.getContext?(D=C.getContext("2d"),B=!0):B=!1,i()}function i(){z("debugOverlay")?(C.style.opacity=.5,C.style.pointerEvents="none",document.body.appendChild(C)):C.parentNode&&C.parentNode.removeChild(C)}function j(a){var d=(new Date).getTime()-a;c("Duration: "+d+"ms"),d>z("maxDuration")&&(console.log("BackgroundCheck - Killed"),q(),b())}function k(){F={left:0,top:0,right:document.body.clientWidth,bottom:window.innerHeight},C.width=document.body.clientWidth,C.height=window.innerHeight}function l(a,b,c){var d,e;return-1!==a.indexOf("px")?d=parseFloat(a):-1!==a.indexOf("%")?(d=parseFloat(a),e=d/100,d=e*b,c&&(d-=c*e)):d=b,d}function m(a){var b=window.getComputedStyle(a.el);a.el.style.backgroundRepeat="no-repeat",a.el.style.backgroundOrigin="padding-box";var c=b.backgroundSize.split(" "),d=c[0],e=void 0===c[1]?"auto":c[1],f=a.el.clientWidth/a.el.clientHeight,g=a.img.naturalWidth/a.img.naturalHeight;"cover"===d?f>=g?(d="100%",e="auto"):(d="auto",c[0]="auto",e="100%"):"contain"===d&&(1/g>1/f?(d="auto",c[0]="auto",e="100%"):(d="100%",e="auto")),d="auto"===d?a.img.naturalWidth:l(d,a.el.clientWidth),e="auto"===e?d/a.img.naturalWidth*a.img.naturalHeight:l(e,a.el.clientHeight),"auto"===c[0]&&"auto"!==c[1]&&(d=e/a.img.naturalHeight*a.img.naturalWidth);var h=b.backgroundPosition;"top"===h?h="50% 0%":"left"===h?h="0% 50%":"right"===h?h="100% 50%":"bottom"===h?h="50% 100%":"center"===h&&(h="50% 50%"),h=h.split(" ");var i,j;return 4===h.length?(i=h[1],j=h[3]):(i=h[0],j=h[1]),j=j||"50%",i=l(i,a.el.clientWidth,d),j=l(j,a.el.clientHeight,e),4===h.length&&("right"===h[0]&&(i=a.el.clientWidth-a.img.naturalWidth-i),"bottom"===h[2]&&(j=a.el.clientHeight-a.img.naturalHeight-j)),i+=a.el.getBoundingClientRect().left,j+=a.el.getBoundingClientRect().top,{left:Math.floor(i),right:Math.floor(i+d),top:Math.floor(j),bottom:Math.floor(j+e),width:Math.floor(d),height:Math.floor(e)}}function n(a){var b,c,d;if(a.nodeType){var e=a.getBoundingClientRect();b={left:e.left,right:e.right,top:e.top,bottom:e.bottom,width:e.width,height:e.height},d=a.parentNode,c=a}else b=m(a),d=a.el,c=a.img;d=d.getBoundingClientRect(),b.imageTop=0,b.imageLeft=0,b.imageWidth=c.naturalWidth,b.imageHeight=c.naturalHeight;var f,g=b.imageHeight/b.height;return b.top<d.top&&(f=d.top-b.top,b.imageTop=g*f,b.imageHeight-=g*f,b.top+=f,b.height-=f),b.left<d.left&&(f=d.left-b.left,b.imageLeft+=g*f,b.imageWidth-=g*f,b.width-=f,b.left+=f),b.bottom>d.bottom&&(f=b.bottom-d.bottom,b.imageHeight-=g*f,b.height-=f),b.right>d.right&&(f=b.right-d.right,b.imageWidth-=g*f,b.width-=f),b.imageTop=Math.floor(b.imageTop),b.imageLeft=Math.floor(b.imageLeft),b.imageHeight=Math.floor(b.imageHeight),b.imageWidth=Math.floor(b.imageWidth),b}function o(a){var b=n(a);a=a.nodeType?a:a.img,b.imageWidth>0&&b.imageHeight>0&&b.width>0&&b.height>0?D.drawImage(a,b.imageLeft,b.imageTop,b.imageWidth,b.imageHeight,b.left,b.top,b.width,b.height):c("Skipping image - "+a.src+" - area too small")}function p(a,b,c){var d=a.className;switch(c){case"add":d+=" "+b;break;case"remove":var e=new RegExp("(?:^|\\s)"+b+"(?!\\S)","g");d=d.replace(e,"")}a.className=d.trim()}function q(a){for(var b,c=a?[a]:z("targets"),d=0;d<c.length;d++)b=c[d],b=z("changeParent")?b.parentNode:b,p(b,z("classes").light,"remove"),p(b,z("classes").dark,"remove"),p(b,z("classes").complex,"remove")}function r(a){var b,d,e,f,g=a.getBoundingClientRect(),h=0,i=0,j=0,k=0,l=z("mask");if(g.width>0&&g.height>0){q(a),a=z("changeParent")?a.parentNode:a,d=D.getImageData(g.left,g.top,g.width,g.height).data;for(var m=0;m<d.length;m+=4)d[m]===l.r&&d[m+1]===l.g&&d[m+2]===l.b?k++:(h++,b=.2126*d[m]+.7152*d[m+1]+.0722*d[m+2],e=b-j,i+=e*e,j+=e/h);k<=d.length/4*(1-z("minOverlap")/100)&&(f=Math.sqrt(i/h)/255,j/=255,c("Target: "+a.className+" lum: "+j+" var: "+f),p(a,j<=z("threshold")/100?z("classes").dark:z("classes").light,"add"),f>z("minComplexity")/100&&p(a,z("classes").complex,"add"))}}function s(a,b){return a=(a.nodeType?a:a.el).getBoundingClientRect(),b=b===F?b:(b.nodeType?b:b.el).getBoundingClientRect(),!(a.right<b.left||a.left>b.right||a.top>b.bottom||a.bottom<b.top)}function t(a){for(var b,c=(new Date).getTime(),d=a&&("IMG"===a.tagName||a.img)?"image":"targets",e=a?!1:!0,f=z("targets").length,g=0;f>g;g++)b=z("targets")[g],s(b,F)&&("targets"!==d||a&&a!==b?"image"===d&&s(b,a)&&r(b):(e=!0,r(b)));if("targets"===d&&!e)throw a+" is not a target";j(c)}function u(a){var b=function(a){var b=0;return"static"!==window.getComputedStyle(a).position&&(b=parseInt(window.getComputedStyle(a).zIndex,10)||0,b>=0&&b++),b},c=a.parentNode,d=c?b(c):0,e=b(a);return 1e5*d+e}function v(a){var b=!1;return a.sort(function(a,c){a=a.nodeType?a:a.el,c=c.nodeType?c:c.el;var d=a.compareDocumentPosition(c),e=0;return a=u(a),c=u(c),a>c&&(b=!0),a===c&&2===d?e=1:a===c&&4===d&&(e=-1),e||a-c}),c("Sorted: "+b),b&&c(a),b}function w(a,b,d){if(B){var e=z("mask");c("--- BackgroundCheck ---"),c("onLoad event: "+(d&&d.src)),b!==!0&&(D.clearRect(0,0,C.width,C.height),D.fillStyle="rgb("+e.r+", "+e.g+", "+e.b+")",D.fillRect(0,0,C.width,C.height));for(var f,g,h=d?[d]:z("images"),i=v(h),j=!1,k=0;k<h.length;k++)f=h[k],s(f,F)&&(g=f.nodeType?f:f.img,0===g.naturalWidth?(j=!0,c("Loading... "+f.src),g.removeEventListener("load",w),i?g.addEventListener("load",w.bind(null,null,!1,null)):g.addEventListener("load",w.bind(null,a,!0,f))):(c("Drawing: "+f.src),o(f)));d||j?d&&t(d):t(a)}}function x(a){z("windowEvents")===!0&&(E&&clearTimeout(E),E=setTimeout(a,200))}function y(a,b){if(void 0===H[a])throw"Unknown property - "+a;if(void 0===b)throw"Missing value for "+a;if("targets"===a||"images"===a)try{b=g("images"!==a||b?b:"img","images"===a?!0:!1)}catch(c){throw b=[],c}else e(b,typeof H[a]);q(),H[a]=b,w(),"debugOverlay"===a&&i()}function z(a){if(void 0===H[a])throw"Unknown property - "+a;return H[a]}function A(){for(var a,b=z("images"),c=[],d=0;d<b.length;d++)a=n(b[d]),c.push(a);return c}var B,C,D,E,F,G=void 0!==window.orientation?"orientationchange":"resize",H={};return{init:a,destroy:b,refresh:w,set:y,get:z,getImageData:A}});

 var beryl = {};

jQuery(window).load(function() {

});

if ( jQuery('.content-wrapper > article').length ) {
	jQuery('.content-wrapper > article').first().addClass('first-post');
};

if ( jQuery('.content-wrapper > article').length >= 2 ) {
	jQuery('body').addClass('scroll-down-visible');
};

jQuery(document).ready(function($) {
	jQuery(window).on("popstate", function() {
		jQuery('.site-logo').click();
	});

	jQuery(document).on('click', '.post-read-more', function(e) {
		e.preventDefault();
		jQuery(this).parent().parent().parent().addClass('show-right-content');
		jQuery('body').addClass('post-shown');

		// Set old url
		var old_href = window.location.href;
		jQuery('#current-page-url').val( old_href );

		// Change URL
		var href = jQuery(this).attr('href');
		history.pushState({page: href}, '', href);

		// Check image brightness for menu
		if ( !jQuery('.content-wrapper article.post-in-sight .post-middle-picture').hasClass('no-image') ) {
			setTimeout(function() {
				BackgroundCheck.refresh();
			}, 350);
		};
		
		// Check background color for logo
		if ( jQuery('.site-logo').hasClass('text') ) {
			setTimeout(function() {
				if ( beryl_isDark(jQuery('.content-wrapper article.post-in-sight .post-right-content').css("background-color")) ) {
					jQuery('.menu-icon-wrapper').addClass('white-menu');
					jQuery('.menu-icon-wrapper').removeClass('black-menu');
				} else {
					jQuery('.menu-icon-wrapper').addClass('black-menu');
					jQuery('.menu-icon-wrapper').removeClass('white-menu');
				}
			}, 300);
		};
	});

	jQuery('.content-wrapper > article').first().addClass('post-in-sight');

	$(window).bind('mousewheel', function(event) {
		// Stop instant scrolling
		if ( jQuery('body').hasClass('posts-scrolling') || jQuery('body').hasClass('show-menu') ) {
			return;
		};
		jQuery('body').addClass('posts-scrolling');

		setTimeout(function() {
			jQuery('body').removeClass('posts-scrolling');
		}, 1000);

		// Check scroll direction
		if (event.originalEvent.wheelDelta >= 0) {
			// Scroll up
			var current = jQuery('.content-wrapper > article.post-in-sight');
			var next = current.prev();

			beryl_scroll_posts(current, next);
		} else {
			// Scroll down
			var current = jQuery('.content-wrapper > article.post-in-sight');
			var next = current.next();

			beryl_scroll_posts(current, next);
		}
	});

	jQuery(document).on('click', '.post-pagination-item', function() {
		// Stop instant scrolling
		if ( jQuery('body').hasClass('posts-scrolling') ) {
			return;
		};
		jQuery('body').addClass('posts-scrolling');

		setTimeout(function() {
			jQuery('body').removeClass('posts-scrolling');
		}, 1000);

		var prev_index = jQuery('.post-pagination-item.active').index();
		jQuery('.post-pagination-item').removeClass('active');
		jQuery(this).addClass('active');
		var current_index = jQuery('.post-pagination-item.active').index();

		var current = jQuery( jQuery('.content-wrapper > article').get( prev_index ) );

		if ( prev_index > current_index ) {
			var next = current.prev();
		} else {
			var next = current.next();
		}

		beryl_scroll_posts(current, next, true);
	});

	jQuery(document).on('click', '.site-logo', function() {
		if ( jQuery('#current-page-url').val() == '') {
			window.location.href = beryl_loc.home_url;
		} else if ( jQuery('.post-wrapper.show-right-content').length ) {
			jQuery('.post-wrapper.show-right-content').removeClass('show-right-content');
			jQuery('body').removeClass('post-shown');

			var href = jQuery('#current-page-url').val();
			history.pushState({page: href}, '', href);

			// Check image brightness for menu
			if ( !jQuery('.content-wrapper article.post-in-sight .post-middle-picture').hasClass('no-image') ) {
				setTimeout(function() {
					BackgroundCheck.refresh();
				}, 250);
			};
		}
	});

	jQuery(document).on('click', '.main-navigation-container .sb-icon-search', function() {
		jQuery(this).parent().find('input[type=submit]').click();
	});

	// Set middle menu height
	var admin_menu = 0;
	if ( jQuery('body').hasClass('admin-bar') ) {
		admin_menu = 32;
	}
	jQuery('#middle-menu').height(jQuery(window).height()-jQuery('#bottom-menu').height()-83-admin_menu);

	jQuery(document).on('click', '.scroll-down', function() {
		var current = jQuery('.post-pagination-item.active');
		var next = current.next();
		if ( next.length ) {
			next.click();
		};
	});

	if ( jQuery('body').hasClass('pull-page-content') ) {
		jQuery('.post-wrapper').addClass('show-right-content');
	};

	if ( jQuery('.post-image-container').length ) {
		BackgroundCheck.init({
			targets: '.menu-icon-wrapper, .site-logo',
			images: '.post-image-container'
		});
	}

	if ( jQuery('.site-logo').hasClass('text') ) {
		if ( beryl_isDark(jQuery('.content-wrapper article.post-in-sight .post-left-content').css("background-color")) ) {
			jQuery('.site-logo').addClass('white-text');
			jQuery('.site-logo').removeClass('black-text');
		} else {
			jQuery('.site-logo').addClass('black-text');
			jQuery('.site-logo').removeClass('white-text');
		}
	};
});

function beryl_scroll_posts( current, next, pagination ) {
	if ( jQuery('.post-wrapper.show-right-content').length ) {
		return;
	};
	pagination = pagination || false;
	if ( !pagination ) {
		var next_post = next;
		if ( !next_post.length ) {
			// No next post
			return;
		} else {
			current.removeClass('post-in-sight');
			next_post.addClass('post-in-sight');
		}		
	} else {
		var next_post = jQuery('.post-pagination-item.active');
	}

	jQuery('.content-wrapper > article').removeClass('first-post');
	jQuery('body').addClass('posts-scrolling-effect');

	setTimeout(function() {
		jQuery('body').removeClass('posts-scrolling-effect');
	}, 300);

	jQuery('.content-wrapper > article').each(function() {
		jQuery(this).css({
			'-webkit-transform': 'translateY(-'+next_post.index()*100+'%)',
			'-moz-transform': 'translateY(-'+next_post.index()*100+'%)',
			'-ms-transform': 'translateY(-'+next_post.index()*100+'%)',
			'-o-transform': 'translateY(-'+next_post.index()*100+'%)',
			'transform': 'translateY(-'+next_post.index()*100+'%)'
		});
	});

	// Check image brightness for menu
	if ( !jQuery('.content-wrapper article.post-in-sight .post-middle-picture').hasClass('no-image') ) {
		setTimeout(function() {
			BackgroundCheck.refresh();
		}, 250);
	};
	

	// Check background color for logo
	if ( jQuery('.site-logo').hasClass('text') ) {
		setTimeout(function() {
			if ( beryl_isDark(jQuery('.content-wrapper article.post-in-sight .post-left-content').css("background-color")) ) {
				jQuery('.site-logo').addClass('white-text');
				jQuery('.site-logo').removeClass('black-text');
			} else {
				jQuery('.site-logo').addClass('black-text');
				jQuery('.site-logo').removeClass('white-text');
			}
		}, 300);
	};

	// Update pagination
	jQuery('.post-pagination-item').removeClass('active');
	jQuery( jQuery('.post-pagination-item').get( next_post.index() ) ).addClass('active');

	if ( pagination ) {
		jQuery('.content-wrapper article').removeClass('post-in-sight');
		jQuery( jQuery('.content-wrapper > article').get( next_post.index() ) ).addClass('post-in-sight');
	}

	// Add last post class
	var post_count = jQuery('.content-wrapper > article').length;
	if ( next_post.index()+1 == post_count ) {
		jQuery('body').addClass('last-post');
	} else {
		jQuery('body').removeClass('last-post');
	}
}

function beryl_isDark( color ) {
	var match = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(color);
	return ( match[1] & 255 )
		 + ( match[2] & 255 )
		 + ( match[3] & 255 )
		   < 3 * 256 / 2;
}

function clearInput (input, inputValue) {
	"use strict";

	if (input.value === inputValue) {
		input.value = '';
	}
}

( function( $ ) {
	var body    = $( 'body' ),
		_window = $( window );

	$('.scroll-to-top').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	jQuery(document).scroll(function() {
		if ( jQuery(document).scrollTop() >= 200 ) {
			jQuery('.site-header').addClass('scrolled');
		} else {
			jQuery('.site-header').removeClass('scrolled');
		}
	});

	// Enable menu toggle for small screens.
	( function() {
		var nav = $( '#primary-navigation' ), button, menu;
		if ( ! nav ) {
			return;
		}

		button = nav.find( '.menu-toggle' );
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		$( '.menu-toggle' ).on( 'click.beryl', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();

	/*
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	_window.on( 'hashchange.beryl', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
				element.tabIndex = -1;
			}

			element.focus();

			// Repositions the window on jump-to-anchor to account for header height.
			window.scrollBy( 0, -80 );
		}
	} );

	$( function() {

		/*
		 * Fixed header for large screen.
		 * If the header becomes more than 48px tall, unfix the header.
		 *
		 * The callback on the scroll event is only added if there is a header
		 * image and we are not on mobile.
		 */
		if ( _window.width() > 781 ) {
			var mastheadHeight = $( '#masthead' ).height(),
				toolbarOffset, mastheadOffset;

			if ( mastheadHeight > 48 ) {
				body.removeClass( 'masthead-fixed' );
			}

			if ( body.is( '.header-image' ) ) {
				toolbarOffset  = body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
				mastheadOffset = $( '#masthead' ).offset().top - toolbarOffset;

				_window.on( 'scroll.beryl', function() {
					if ( ( window.scrollY > mastheadOffset ) && ( mastheadHeight < 49 ) ) {
						body.addClass( 'masthead-fixed' );
					} else {
						body.removeClass( 'masthead-fixed' );
					}
				} );
			}
		}

		// Focus styles for menus.
		$( '.primary-navigation, .secondary-navigation' ).find( 'a' ).on( 'focus.beryl blur.beryl', function() {
			$( this ).parents().toggleClass( 'focus' );
		} );
	} );
} )( jQuery );

/*------------------------------------------------------------
 * FUNCTION: Scroll Page Back to Top
 * Used for ajax navigation scroll position reset
 *------------------------------------------------------------*/

function scrollPageToTop(){
	// Height hack for mobile/tablet
	jQuery('body').css('height', 'auto');
	jQuery("html, body").animate({ scrollTop: 0 }, "slow");

	// if( beryl.device != 'desktop' ){
		// jQuery('body').scrollTop(0);
	// }else{
	//  jQuery('.content-wrapper').scrollTop(0);
	// }

	jQuery('body').css('height', '');
}

(function() {

	// detect if IE : from http://stackoverflow.com/a/16657946      
	var ie = (function(){
		var undef,rv = -1; // Return value assumes failure.
		var ua = window.navigator.userAgent;
		var msie = ua.indexOf('MSIE ');
		var trident = ua.indexOf('Trident/');

		if (msie > 0) {
			// IE 10 or older => return version number
			rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		} else if (trident > 0) {
			// IE 11 (or newer) => return version number
			var rvNum = ua.indexOf('rv:');
			rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
		}

		return ((rv > -1) ? rv : undef);
	}());


	// disable/enable scroll (mousewheel and keys) from http://stackoverflow.com/a/4770179                  
	// left: 37, up: 38, right: 39, down: 40,
	// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
	var keys = [37, 38, 39, 40], wheelIter = 0;

	function preventDefault(e) {
		e = e || window.event;
		if (e.preventDefault)
		e.preventDefault();
		e.returnValue = false;  
	}

	function keydown(e) {
		for (var i = keys.length; i--;) {
			if (e.keyCode === keys[i]) {
				preventDefault(e);
				return;
			}
		}
	}

	function touchmove(e) {
		preventDefault(e);
	}

	function wheel(e) {
		// for IE 
		//if( ie ) {
			//preventDefault(e);
		//}
	}

	function disable_scroll() {
		window.onmousewheel = document.onmousewheel = wheel;
		document.onkeydown = keydown;
		document.body.ontouchmove = touchmove;
	}

	function enable_scroll() {
		window.onmousewheel = document.onmousewheel = document.onkeydown = document.body.ontouchmove = null;  
	}

	var docElem = window.document.documentElement,
		scrollVal,
		isRevealed, 
		noscroll, 
		isAnimating;

	function scrollY() {
		return window.pageYOffset || docElem.scrollTop;
	}

	function scrollPage() {
		scrollVal = scrollY();
		
		if( noscroll && !ie ) {
			if( scrollVal < 0 ) return false;
			// keep it that way
			window.scrollTo( 0, 0 );
		}

		if( jQuery('body').hasClass( 'notrans' ) ) {
			jQuery('body').removeClass( 'notrans' );
			return false;
		}

		if( isAnimating ) {
			return false;
		}
		
		if( scrollVal <= 0 && isRevealed ) {
			toggle(0);
		}
		else if( scrollVal > 0 && !isRevealed ){
			toggle(1);
		}
	}

	function toggle( reveal ) {
		isAnimating = true;
		
		if( reveal ) {
			jQuery('body').addClass( 'modify' );
		}
		else {
			noscroll = true;
			disable_scroll();
			jQuery('body').removeClass( 'modify' );
		}

		// simulating the end of the transition:
		setTimeout( function() {
			isRevealed = !isRevealed;
			isAnimating = false;
			if( reveal ) {
				noscroll = false;
				enable_scroll();
			}
		}, 600 );
	}

	if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

		// refreshing the page...
		var pageScroll = scrollY();
		noscroll = pageScroll === 0;

		disable_scroll();

		if( pageScroll ) {
			isRevealed = true;
			jQuery('body').addClass( 'notrans' );
			jQuery('body').addClass( 'modify' );
		}

		
	} else if ( jQuery('body').hasClass('single-post') && /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		jQuery('body').addClass( 'notrans' );
		jQuery('body').addClass( 'modify' );
	}
	
})();

(function() {
	/* In animations (to close icon) */

	var beginAC = 80,
		endAC = 320,
		beginB = 80,
		endB = 320;

	function inAC(s) {
		s.draw('80% - 240', '80%', 0.3, {
			delay: 0.1,
			callback: function() {
				inAC2(s)
			}
		});
	}

	function inAC2(s) {
		s.draw('100% - 545', '100% - 305', 0.6, {
			easing: ease.ease('elastic-out', 1, 0.3)
		});
	}

	function inB(s) {
		s.draw(beginB - 60, endB + 60, 0.1, {
			callback: function() {
				inB2(s)
			}
		});
	}

	function inB2(s) {
		s.draw(beginB + 120, endB - 120, 0.3, {
			easing: ease.ease('bounce-out', 1, 0.3)
		});
	}

	/* Out animations (to burger icon) */

	function outAC(s) {
		s.draw('90% - 240', '90%', 0.1, {
			easing: ease.ease('elastic-in', 1, 0.3),
			callback: function() {
				outAC2(s)
			}
		});
	}

	function outAC2(s) {
		s.draw('20% - 240', '20%', 0.3, {
			callback: function() {
				outAC3(s)
			}
		});
	}

	function outAC3(s) {
		s.draw(beginAC, endAC, 0.7, {
			easing: ease.ease('elastic-out', 1, 0.3)
		});
	}

	function outB(s) {
		s.draw(beginB, endB, 0.7, {
			delay: 0.1,
			easing: ease.ease('elastic-out', 2, 0.4)
		});
	}

	/* Scale functions */

	function addScale(m) {
		jQuery(m).addClass('scaled');
	}

	function removeScale(m) {
		jQuery(m).removeClass('scaled');
	}

	/* Awesome burger scaled */

	var pathD = document.getElementById('pathD'),
		pathE = document.getElementById('pathE'),
		pathF = document.getElementById('pathF'),
		segmentD = new Segment(pathD, beginAC, endAC),
		segmentE = new Segment(pathE, beginB, endB),
		segmentF = new Segment(pathF, beginAC, endAC),
		wrapper2 = document.getElementById('menu-icon-wrapper2'),
		trigger2 = document.getElementById('menu-icon-trigger2'),
		toCloseIcon2 = true;

	wrapper2.style.visibility = 'visible';

	trigger2.onclick = function() {
		addScale(wrapper2);
		if (toCloseIcon2) {
			inAC(segmentD);
			inB(segmentE);
			inAC(segmentF);
			jQuery('body').addClass('show-menu menu-color');
		} else {
			outAC(segmentD);
			outB(segmentE);
			outAC(segmentF);
			jQuery('body').removeClass('show-menu');
			setTimeout(function() {
				jQuery('body').removeClass('menu-color');
			}, 300);
		}
		toCloseIcon2 = !toCloseIcon2;
		setTimeout(function() {
			removeScale(wrapper2);
		}, 450);
	};

})();