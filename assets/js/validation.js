jQuery.validator.addMethod("college_name", function(value, element) {
    return this.optional(element) || /^[a-z\-_.,\s]+$/i.test(value);
}, "enter correct college name");

jQuery.validator.addMethod("usernameValidation", function(value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*\d)(?=.*[#$@!%&*?_])[A-Za-z\d#$@!%&*?_]{8,16}$/.test(value);
}, "enter valid username");

jQuery.validator.addMethod("strongPassword", function(value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?_])[A-Za-z\d#$@!%&*?_]{8,16}$/.test(value);
}, "strong Password is required");

jQuery.validator.addMethod("blankNotAllowed", function(value, element) {
    return this.optional(element) || /^\S*$/.test(value);
}, "blank spaces are not allowed");

jQuery.validator.addMethod("validString", function(value, element) {
    return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
}, "Enter valid string");

jQuery.validator.addMethod("filesize", function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

jQuery.validator.addMethod("remarkValidation", function(value, element) {
    return this.optional(element) || /^[\w\-_.,!@$%\s]+$/.test(value);
}, "Enter valid Remark");


//for adding validation css to input field
jQuery.validator.setDefaults({
    highlight: function(element) {
        jQuery(element).closest('.form-control').addClass('is-invalid');
    },
    unhighlight: function(element) {
        jQuery(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
    },
    errorElement: 'span',
    errorClass: 'label label-danger',
    errorPlacement: function(error, element) {
        if(element.parent('.form-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});


//start of jquery validation for Signup form
$( document ).ready( function () {
    $( "#add_user_form" ).validate( {
    normalizer: function( value ) {
        return $.trim( value );
    },
    rules: {
        user_full_name:{
            required:true,
            validString:true,
            minlength: 5,
            maxlength:25
        },
        user_username:{
            required : true,
            minlength: 8,
            maxlength : 16,
            usernameValidation: true
        },
        user_email:{
            required : true,
            email: true
        },
        user_password:{
            required: true,
            strongPassword:true,
            minlength:8,
            maxlength:16
        },
        user_confirm_password:{
            required:true,
            equalTo:"#inputPassword"
        }
    },
    messages: {
        user_full_name:{
            required: "please enter full name",
            validString:"Only alphabets and spaces are allowed",
            minlength:"Enter more than 5 characters",
            maxlength:"less than 26 characters are allowed"
        },
         user_username:{
            required:"please enter username",
            minlength:"Too short > 7",
            maxlength:"Too long < 17",
            usernameValidation: "Your Username must contain 1 alphabets, 1 number with special characters(#$@!%&*?_)"
        }, 
        user_email:{
            required:"please enter E-mail address",
            email:"Enter valid email address!"
        },
        user_password: {
            required: "please enter password",
            strongPassword:"Your password must be at least 8 characters. atleast 1 uppercase and 1 lowercase alphabets, 1 special character(#$@!%&*?_) and 1 number.",
            minlength: "password more than 7 characters",
            maxlength:"password less than 17 characters"
        },
        user_confirm_password:{
            required: "please enter confirm password",
            equalTo:"password and confirm password mismatch"
        }
    }
    });
});


