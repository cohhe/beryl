/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */

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
		}
	});

	jQuery(document).on('click', '.main-navigation-container .sb-icon-search', function() {
		jQuery(this).parent().find('input[type=submit]').click();
	});

	// Set middle menu height
	jQuery('#middle-menu').height(jQuery(window).height()-jQuery('#bottom-menu').height()-83);

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
		m.className = 'menu-icon-wrapper scaled';
	}

	function removeScale(m) {
		m.className = 'menu-icon-wrapper';
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