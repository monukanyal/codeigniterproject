function setHeight() {
  	windowHeight = $(window).innerHeight();
  	$('.site-wrapper').css('height', windowHeight);
}

var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null; 
    window.onwheel = null; 
    window.ontouchmove = null;  
    document.onkeydown = null;  
}

$(document).ready(function() {

	$('a').click(function(){
	var top = $( $.attr(this, 'href') );
    if (!top.length) {
        return;
    }
	    $('html, body').animate({
	        scrollTop: top.offset().top
	    }, 500);
	    return false;
	});

	// $( '.site-wrapper' ).bind( 'mousewheel DOMMouseScroll', function ( e ) {
	// 	var e0 = e.originalEvent,
	// 	delta = e0.wheelDelta || -e0.detail;
	// 	this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
	// 	e.preventDefault();
	// });

	// $(document).scroll(function(e){
	var top = $('.carousel-top').offset().top - $(document).scrollTop();
	//     if (top < 250){
	//        disableScroll();
	//     }
	// });

      	// var lastScrollTop = 0;
       //  $(window).scroll(function(event){
       //  	var sectionIndex = $('#fp-nav a.active').parent().index();
       //      var st = $(this).scrollTop();
       //      if ((st > lastScrollTop) && (sectionIndex==1)){
       //          disableScroll();
       //      }
       //      if (st > lastScrollTop && sectionIndex==2){
       //      	console.log("down");
       //          enableScroll();
       //      }
       //      if ((st < lastScrollTop) && (sectionIndex==2 || sectionIndex==1)){
       //          disableScroll();
       //      }
       //      console.log(sectionIndex);
       //      if (st < lastScrollTop && sectionIndex==0){
       //      	console.log("up");
       //          enableScroll();
       //      }
       //      lastScrollTop = st;
       //  });

  //       $(window).bind('scroll', function(event) {
		//     if (event.originalEvent.wheelDelta >= 0) {
		//         if (sectionIndex==2 || sectionIndex==1){
	 //                disableScroll();
	 //            }
	 //            if (sectionIndex==0){
	 //                enableScroll();
	 //            }
		//     }
		//     else {
		//         if (top < 250 || sectionIndex==1){
	 //                disableScroll();
	 //            }
	 //            if (sectionIndex==2){
	 //                enableScroll();
	 //            }
		//     }
		// });

	  setHeight();
	  
	  $(window).resize(function() {
	    setHeight();
	  });


	//   jQuery(document).ready(function($){ // document ready
  
	//    var stickyTop = $('.site-wrapper').offset().top; // returns number   
	  
	//    $(window).scroll(function(){ // scroll event
	  
	//      var windowTop = $(window).scrollTop(); // returns number
	//       if (stickyTop < windowTop) {
	//         $('.site-wrapper').css({ position: 'fixed', top: '-20px' });
	//       }
	//       else {
	//         $('.site-wrapper').css('position','relative');
	//       }
	  
	//    });
	 
	// });


});

