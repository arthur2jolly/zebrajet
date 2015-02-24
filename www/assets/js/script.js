

// Adds a class 'js_on' to the <html> tag if JavaScript is enabled,
// also helps remove flickering...
document.documentElement.className += 'js_on';


// Add Cufon fonts
Cufon.set('fontFamily', 'ITC Lubalin Graph Std Book');
Cufon.replace('#slogan', {textShadow:'0 1px #FFF'});
Cufon.replace('h1', {textShadow:'0 1px #FFF'});
Cufon.replace('h2:not(.slide-desc h2)', {textShadow:'0 1px #FFF'});
Cufon.replace('h3:not(.twtr-widget, .slide-desc h2)', {textShadow:'0 1px #FFF'});
Cufon.replace('h3.bottom-col-title'); // no text shadow
Cufon.replace('h4:not(.twtr-widget, #bottom .latest_posts h4)', {textShadow:'0 1px #FFF'});
Cufon.replace('h5', {textShadow:'0 1px #FFF'});
Cufon.replace('h6', {textShadow:'0 1px #FFF'});
Cufon.replace('#page-content #page-title h2', {textShadow:'0 1px #000'});
Cufon.replace('#slogan', { fontFamily: 'Marker Felt' });

/*
jQuery(document).ready(function($){
  $('p.signup-button a')
    .css({ 'backgroundPosition': '0 0' })
    .hover(function(){
	$(this).stop()
	  .animate({
	    'opacity': 0
	  }, 650);
	  },
	  function(){
	    $(this).stop()
	      .animate({
		'opacity': 1
	      }, 650);
	  }
    );
});
*/
// Scroll to Top script
jQuery(document).ready(function($){
    $('a[href=#top]').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });
});



/**
 * CoolInput Plugin
 *
 * @version 1.5 (10/09/2009)
 * @requires jQuery v1.2.6+
 * @author Alex Weber <alexweber.com.br>
 * @author Evan Winslow <ewinslow@cs.stanford.edu> (v1.5)
 * @copyright Copyright (c) 2008-2009, Alex Weber
 * @see http://remysharp.com/2007/01/25/jquery-tutorial-text-box-hints/
 *
 * Distributed under the terms of the GNU General Public License
 * http://www.gnu.org/licenses/gpl-3.0.html
 */
jQuery(document).ready(function($){
    $.fn.coolinput=function(b){
	var c={
	    hint:null,
	    source:"value",
	    blurClass:"blur",
	    iconClass:false,
	    clearOnSubmit:true,
	    clearOnFocus:true,
	    persistent:true
	};if(b&&typeof b=="object")
	    $.extend(c,b);else
	    c.hint=b;return this.each(function(){
	    var d=$(this);var e=c.hint||d.attr(c.source);var f=c.blurClass;function g(){
		if(d.val()=="")
		    d.val(e).addClass(f)
		    }
	    function h(){
		if(d.val()==e&&d.hasClass(f))
		    d.val("").removeClass(f)
		    }
	    if(e){
		if(c.persistent)
		    d.blur(g);if(c.clearOnFocus)
		    d.focus(h);if(c.clearOnSubmit)
		    d.parents("form:first").submit(h);if(c.iconClass)
		    d.addClass(c.iconClass);g()
		}
	    })
	}
    });
/*
jQuery(document).ready(function($){
	// first input box is a search box, notice passing of a custom class and an icon to the coolInput function
	$('#search_field').coolinput({
		blurClass: 'inputbox',
		iconClass: 'search_icon'
	});
	$('#signup-field').coolinput({
		blurClass: 'inputbox',
		iconClass: 'signup_icon'
	});
});
*/

// initialise Superfish Menu
/*
jQuery(document).ready(function($){
    $("ul.sf-menu").supersubs({
	minWidth:    12,   // minimum width of sub-menus in em units
	maxWidth:    32,   // maximum width of sub-menus in em units
	extraWidth:  1     // extra width can ensure lines don't sometimes turn over
			   // due to slight rounding differences and font-family
    }).superfish({	   // call supersubs first, then superfish, so that subs are not display:none when measuring. Call before initialising containing tabs for same reason.
	delay:       500,  // the delay in milliseconds that the mouse can remain outside a submenu without it closing
	autoArrows:  false,
	dropShadows: false
    });
});
*/

// ThumbCaption script
jQuery(document).ready(function($){
    $(".portfolioImgThumb").hover(function(){
	    var info=$(this).find(".hover-opacity");
	    info.stop().animate({opacity:0.4},400);
    },
    function(){
	    var info=$(this).find(".hover-opacity");
	    info.stop().animate({opacity:1},400);
    });

    $(".postImage").hover(function(){
	    var info=$(this).find(".hover-opacity");
	    info.stop().animate({opacity:0.6},400);
    },
    function(){
	    var info=$(this).find(".hover-opacity");
	    info.stop().animate({opacity:1},400);
    });
});



// jQuery Validate
/*
jQuery(document).ready(function($){

    $("#contactForm").validate({
	rules: {
		contact_name: {
			required: true,
			minlength: 2
		},
		contact_email: {
			required: true,
			email: true
		},
		contact_message: "required"
	},
	messages: {
		contact_name: {
			required: "Please enter a name",
			minlength: "Your name must consist of at least 2 characters"
		},
		contact_email: "Please enter a valid email address",
		contact_message: "<br />Please enter your message"
	}
    });
});
*/
/*
jQuery(function($){
   $("#contact_phone_NA_format").mask("(999) 999-9999");
   $("#contact_ext_NA_format").mask("? 99999");
});
*/


