$(document).ready(function(){
	var image = document.getElementById('background');
    image.onload = function() {
        var engine = new RainyDay({image: this});
		engine.rain([ [0, 2, 20] ], 100);
	};
    image.crossOrigin = 'anonymous';
    image.src = 'http://i.imgur.com/5ribRIk.jpg';

    var audio = $('#audio');
	audio.prop('volume', .7); /* (.1 это 0.1) */

	var textArray = [
		"А ты готов к новым переменам?",
		"Новый HVNC/Socks bot",
		"Всё мы под колпаком...",
		"Скоро."
	];
	$('#pretext-project').text(textArray[Math.floor(Math.random() * textArray.length)]);
	setInterval(function(){
		$('#pretext-project').text(textArray[Math.floor(Math.random() * textArray.length)]);
	}, 10000);
	var state = null;
	var speed = 500;
	var loginstate = null;
	
	$("#content").load("main.txt");
	
	$("#login").click(function(){
		if(state)
		{
			$("#name-project, #pretext-project").animate({'left':'50%', 'margin-left': -$('#name-project, #pretext-project').width()/2}, speed);
			$("#logo").animate({"left":"50%", "margin-left": -$("#logo").width()/2}, speed);
			$("#content").addClass("animated bounceOutRight");
			setTimeout(function(){$("#content").removeClass("animated bounceOutRight").hide();},500);
			state = null;
		}
		if(!loginstate){
			$("#name-project, #pretext-project").animate({"width": "40%","margin-left": "0","left":"0"}, speed);
			$("#logo").animate({"margin-left": $("#name-project").width()/2 - 141,"left":"0"}, speed);
			$("#loginf").addClass("animated bounceInRight").show();
			setTimeout(function(){$("#loginf").removeClass("animated bounceInRight");},500);
			loginstate = true;
		}else{
			$("#name-project, #pretext-project").animate({'left':'50%', 'margin-left': -$('#name-project, #pretext-project').width()/2}, speed);
			$("#logo").animate({"left":"50%", "margin-left": -$("#logo").width()/2}, speed);
			$("#loginf").addClass("animated bounceOutRight");
			setTimeout(function(){$("#loginf").removeClass("animated bounceOutRight").hide();},500);
			loginstate = null;
		}
	});
	
	
	$("#info").click(function(){
		
		if(loginstate){
			$("#name-project, #pretext-project").animate({'left':'50%', 'margin-left': -$('#name-project, #pretext-project').width()/2}, speed);
			$("#logo").animate({"left":"50%", "margin-left": -$("#logo").width()/2}, speed);
			$("#loginf").addClass("animated bounceOutRight");
			setTimeout(function(){$("#loginf").removeClass("animated bounceOutRight").hide();},500);
			loginstate = null;
		}
		
		if(!state){
			$("#name-project, #pretext-project").animate({"width": "40%","margin-left": "0","left":"0"}, speed);
			$("#logo").animate({"margin-left": $("#name-project").width()/2 - 141,"left":"0"}, speed);
			$("#content").addClass("animated bounceInRight").show();
			setTimeout(function(){$("#content").removeClass("animated bounceInRight");},500);
			state = true;
		}else{
			$("#name-project, #pretext-project").animate({'left':'50%', 'margin-left': -$('#name-project, #pretext-project').width()/2}, speed);
			$("#logo").animate({"left":"50%", "margin-left": -$("#logo").width()/2}, speed);
			$("#content").addClass("animated bounceOutRight");
			setTimeout(function(){$("#content").removeClass("animated bounceOutRight").hide();},500);
			state = null;
		}
	});
	
	
});