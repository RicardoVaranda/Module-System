function login(username, password){

	if(!document.getElementById("loginForm")){
		console.error('Fail - Login Form was not found');
		return;
	}

	$("#user").click();
	$("#user").writeText(username);
	$("#username").val(username);
	$("#pass").writeVal(password);
	setInterval(function(){
		$("#loginForm").submit();
	}, 4000);

}

function viewElectives(){

	if(!$(".electives-menu")){
		console.error('Fail - Electives were not found on this page.');
		return;
	}

	$(".electives-menu").click();

}

(function($) {
    $.fn.writeText = function(content) {
        var contentArray = content.split(""),
            current = 0,
            elem = this;
        setInterval(function() {
            if(current < contentArray.length) {
                elem.text(elem.text() + contentArray[current++]);
            }
        }, 300);
    };

    $.fn.writeVal = function(content) {
        var contentArray = content.split(""),
            current = 0,
            elem = this;
        setInterval(function() {
            if(current < contentArray.length) {
                elem.val(elem.val() + contentArray[current++]);
            }
        }, 300);
    };
    
})(jQuery);