
$( document ).ready(function() {
    $("#btn").click(
		function(){
			sendAjaxForm('result_form', 'ajax_form', 'login.php');
			return false; 
		}
	);
});
 
function sendAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url:     url, 
        type:     "POST", 
        dataType: "html", 
        data: $("#"+ajax_form).serialize(),  
        success: function(response) { 
        	result = $.parseJSON(response);
			
			if(result.name == "405"){
				location.reload();
			}else{
				$('#result_form').html("<div class='alert'><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>"+result.name+"</div>");
			}
    	},
    	error: function(response) {
            $('#result_form').html('Ошибка входа!');
    	}
 	});
}