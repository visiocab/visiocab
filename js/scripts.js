
$(document).ready(function(){
	
	// Validate
	// http://bassistance.de/jquery-plugins/jquery-plugin-validation/
	// http://docs.jquery.com/Plugins/Validation/
	// http://docs.jquery.com/Plugins/Validation/validate#toptions

	$('#login-form').validate({
	    rules: {
	      username: {
	        required: true,
	        email: true
	      },
	      password: {
	        required: true
	      }
	    },
			messages: {
			    username: {
			      required: "Your email address is your username",
			      email: "Your email address must be in the format of name@domain.com"
			    }
			},
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

		$('#register-form').validate({
	    rules: {
	      first_name: {
	        minlength: 2,
	        required: true
	      },
	      last_name: {
	        minlength: 2,
	        required: true
	      },
	      email: {
	        required: true,
	        email: true
	      },
	      password2: {
	      	minlength: 8,
	        required: true
	      },
		  confirm_password: {
	        required: true,
			equalTo: "#password2"
		  }
	
	    },
			messages: {
			    name: "Please specify your name",
			    email: {
			      required: "We need your email address to contact you",
			      email: "Your email address must be in the format of name@domain.com"
			    },
			    password2: "Minimum of 8 characters required",
			},
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element
				.text('OK!').addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
	  });

}); // end document.ready
