$( document ).ready(function() {
	var width = $(window).width();

	if (width <= 990) {
	 	$("#main").removeClass("sidebar-show");
	}

	$(".show-sidebar").click(function(){
		if($("#main").hasClass("sidebar-show")){
		}else{
			$(".dropdown-menu").css("display", "none");
		}
	});
	$("#content").click(function(){  
		$('.sidebar-show .dropdown-menu').slideUp("fast");
		$("#sidebar-left").removeClass("hidetips");
		$("ul.dropdown-menu").removeClass("open");
	});
	$("a.dropdown-toggle").click(function(){
		if($(this).parent().find("ul.dropdown-menu").hasClass("open")){
			$(this).parent().find("ul.dropdown-menu").removeClass("open");
			$("#sidebar-left").removeClass("hidetips");
		}else{
			$("ul.dropdown-menu").removeClass("open");
			$(this).parent().find("ul.dropdown-menu").addClass("open");
		}
		if($("ul.dropdown-menu").hasClass("open")){
			$("#sidebar-left").addClass("hidetips");
		}else{
			$("#sidebar-left").removeClass("hidetips");
		}
	});

	$("li.dropdown ul.dropdown-menu a.dropdown-toggle").click(function(){
		// $("#sidebar-left").addClass("hidetips");
	});

	$("li.dropdown ul.dropdown-menu a.dropdown-toggle").click(function(){
		// $("#sidebar-left").addClass("hidetips");
	});

	// SCROLL UP
	$("#main").append("<div class='scroll-button'><i class='fa fa-arrow-up' aria-hidden='true'></i></div>");
	$(".scroll-button").click(function(){ 
        $('html,body').animate({ scrollTop: 0 }, 'slow');
        return false; 
    });

    $(window).scroll(function() {
	  var scrollTop = $(window).scrollTop();
	  var save = $(".save").scrollTop();
	  if ( scrollTop > 100 ) { 
	    $(".scroll-button").css("opacity", "1");
	  }else{
	  	$(".scroll-button").css("opacity", "0");
	  }
	  if ( scrollTop > save + 200 ) { 
	    $(".cst-btn-navbutton .btn").addClass("floating");
	  }else{
	  	$(".cst-btn-navbutton .btn").removeClass("floating");
	  }
	});

	// ALERT
	$("p.well").css("top", "10px");
	//	setTimeout(function(){ $("p.well").css("top", "-100px"); }, 3000);

	// TOOLTIP
	$('[data-toggle="tooltip"]').tooltip();
});