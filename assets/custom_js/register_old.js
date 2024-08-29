function btn_register() {
	var base_url=$('#base_url').val();
    var user_type=$('#user_type').val();
	var username=$('#username').val();
	var password=$('#password').val();
	var email=$('#email').val();
    var pattern_email = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	var service=$('#service').val();
	//alert(service);
	var mobile=$('#mobile').val();
    if(user_type=='') {
		$('#err_usertype').fadeIn().html('Please select user type').css('color','red');
		setTimeout(function(){$("#err_usertype").html("&nbsp;");},3000);
		$("#user_type").focus();
		return false;
	}

	if(username=='') {
		$('#err_username').fadeIn().html('Please enter username').css('color','red');
		setTimeout(function(){$("#err_username").html("&nbsp;");},3000);
		$("#username").focus();
		return false;
	}

	if(password=='') {
		$('#err_password').fadeIn().html('Please enter password').css('color','red');
		setTimeout(function(){$("#err_password").html("&nbsp;");},3000);
		$("#password").focus();
		return false;
	}

   	if(password.length<6) {
		$('#err_password').fadeIn().html('please enter at least 6 character').css('color','red');
		setTimeout(function(){$("#err_password").html("&nbsp;");},3000);
		$("#password").focus();
		return false;
	}

	if(email=='') {
		$('#err_email').fadeIn().html('Please enter email').css('color','red');
		setTimeout(function(){$("#err_email").html("&nbsp;");},3000);
		$("#email").focus();
		return false;

	} else if(!pattern_email.test(email)) {
		$("#err_email").fadeIn().html("Please enter valid email");
		setTimeout(function(){$("#err_email").html("&nbsp;");},5000)
		$("#email").focus();
		return false;
	}
	if(service=='') {
		$('#err_service').fadeIn().html('Please select service').css('color','red');
		setTimeout(function(){$("#err_service").html("&nbsp;");},3000);
		$("#service").focus();
		return false;
	}

	if(mobile=='') {
		$('#err_mobile').fadeIn().html('Please enter mobile').css('color','red');
		setTimeout(function(){$("#err_mobile").html("&nbsp;");},3000);
		$("#mobile").focus();
		return false;
	} else if(mobile.length!=10) {
        $("#err_mobile").fadeIn().html("Please enter 10 digit phone").css('color','red');
    	setTimeout(function(){$("#err_mobile").html("&nbsp;");},3000);
        $("#mobile").focus();
        return false;
    }
	$.ajax({
		url: base_url+'save',
		type: 'POST',
		data: {user_type:user_type,username:username,email:email,password:password,service:service,mobile:mobile},
		dataType:'json',
		beforeSend : function(){
			$("#loader").show();
			$(".SignUp_Btn button").prop('disable','true');
		},
		success:function(returndata) {
			//console.log(returndata);
			$("#loader").hide();
			$("#signUp_form")[0].reset();
			if(returndata.result==1) {
				$('#register-messages').show();
				setTimeout(function () {
                 	$('#register-messages').hide();
             	}, 20000);
			}
			if(returndata.result=='0') {
				if(returndata.data=='phone') {
					$("#err_mobile").fadeIn().html("This phone already exists").css('color','red');
					setTimeout(function(){$("#err_mobile").html("&nbsp;");},3000);
					$("#mobile").focus();
					return false;
				}
				if(returndata.data=='email') {
					$('#err_email').fadeIn().html('This email already exists').css('color','red');
					setTimeout(function(){$("#err_email").html("&nbsp;");},3000);
					$("#email").focus();
					return false;
				}
			}
			if(returndata.result==2) {
				$('#err-messages').show();
				setTimeout(function () {
                 	$('#register-messages').hide();
             	}, 20000);
			}
		}
	});
}
