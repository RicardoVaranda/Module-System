var UserisFocus = false;
$(document).ready(function(){
	var day = moment().format('D');
	var weekday = moment().format('dddd');
	var month = moment().format('MMMM');
	var date = weekday+", "+month+" "+day;
	var setTime = function(){
		var time = moment().format('HH') + ":" + moment().format('mm');
		$("#time").html(time);
	};
	setTime();
	setInterval(function(){setTime()}, 1000);
	$("#date").html(date);
	optimize();
	var dropped=false;
	var mouseY;
	var moveCover = function(to){
		if(dropped==false){
			if(to=="top"){
				$("#loginCover").animate({top:"-110%"});
			}
			else if(to=="bottom"){
				$("#loginCover").animate({top:"0%"});
			}
			dropped==true;
			setTimeout(function(){
				dropped==false;
			},750);
		}
	}
	$(function() {
		$("#loginCover").draggable({
			axis:"y",
			containment:[-window.innerWidth*1.2,-window.innerHeight*1.2,0,0],
			stop:function(e){
				var elTop = $("#loginCover").position().top;
				var area = window.innerHeight*-0.3;
				if(area<elTop){moveCover("bottom");}
				else{moveCover("top");}
			}
		});
		$(".draggable").disableSelection();
	});
	$("#loginCover").mousedown(function(e){
		mouseY = e.clientY;
	});
	$("#loginCover").mouseup(function(e){
		if(mouseY==e.clientY) moveCover("top");
	});
	var images=['eye_active.jpg','eye_hover.jpg'];
	for (var i = images.length - 1; i >= 0; i--) {
		var image = '<img src="'+ "images/" + images[i] +'">';
		$(image).load();
	};
	$("#showPass").mousedown(function(){
		$("input[type='password']").attr("type", "text");
	});
	$("#showPass").mouseup(function(){
		$("input[type='text']").attr("type", "password");
	});
	$("#submit").click(function(){
		if($("#pass").val()!="" && $("#username").val()!=""){
			$("#loginPage").addClass("flipped");
			setTimeout(function(){$("#loginForm").submit();}, 600);
		}
		else{
			if($("#username").val()==""){
				$("#user").css("outline", "3px solid rgb(235, 46, 46)");
			}
			if($("#pass").val()==""){
				$("#loginForm").css("outline", "3px solid rgb(235, 46, 46)");
			}
		}
	});
	var changeUser = function(){
		$("#user").attr("ContentEditable", "true");
		$("#user").html("");
		$("#user").focus();
	};
	$("#notyou").click(function(){changeUser();});
	$("#user").click(function(){if(UserisFocus==false){changeUser();}});
	$("#user").blur(function(){
		UserisFocus = false;
		$("#user").attr("ContentEditable", "false");
		$("#username").val($("#user").html());
		$("#user").css("outline", "none");
		if($("#user").html()==""){$("#user").html("[Username]");}
	});
	$("#user").focus(function() {
		UserisFocus = true;
	    var $this = $(this);
	    $this.select();
	    $this.mouseup(function() {
	        $this.unbind("mouseup");
	        return false;
	    });
	});
	$('#user').bind("enterKey",function(e){
	   $("#user").html($("#user").html().replace("<br>", "").replace("<br>", ""));
	   $("#pass").focus();
	});
	$('#user').keyup(function(e){
		if(e.keyCode == 13)$(this).trigger("enterKey");
	});
});
var getEl = function(el){return document.getElementById(el);}
var optimize = function(){
	$("#loginFormCenter").css("marginTop",window.innerHeight/5+"px");
};
window.onresize=function(){optimize();};