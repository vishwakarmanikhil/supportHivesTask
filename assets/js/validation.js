//custom jquery vaidation methods
jQuery.validator.addMethod("lettersonlys", function(value, element) {
    return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
}, "Letters only please");
jQuery.validator.addMethod("numbersonlys", function(value, element) {
    return this.optional(element) || /^[0-9]*$/.test(value);
}, "Letters only please");

jQuery.validator.addMethod("strongPassword", function(value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?_])[A-Za-z\d#$@!%&*?_]{8,16}$/.test(value);
}, "strong Password is required");

jQuery.validator.addMethod("blankNotAllowed", function(value, element) {
    return this.optional(element) || /^\S*$/.test(value);
}, "blank spaces are not allowed");

jQuery.validator.addMethod("validString", function(value, element) {
    return this.optional(element) || /^[-_.?&#$, a-zA-Z0-9]+$/.test(value);
}, "Enter valid string");

jQuery.validator.addMethod("remarkValidation", function(value, element) {
    return this.optional(element) || /^[\w\-_.,!@$%\s]+$/.test(value);
}, "Enter valid Remark");

jQuery.validator.addMethod("validPhoneNumber", function(value, element) {
    return this.optional(element) || /^[0-9]{4,10}$/.test(value);
}, "enter valid phone number!");

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
    $( "#register_form" ).validate( {
    normalizer: function( value ) {
        return $.trim( value );
    },
    rules: {
        account_type:{
            required:true
        },
        user_first_name:{
            required:true,
            lettersonlys:true,
            minlength: 5,
            maxlength:25
        },
        user_last_name:{
            required:true,
            lettersonlys:true,
            minlength: 5,
            maxlength:25
        },
        user_email:{
            required : true,
            email: true
        },
        user_phone_number:{
            required:true,
            validPhoneNumber: true
        },
        user_mobile_number:{
            required:true,
            validPhoneNumber: true
        },
        birth_date:{
            required : true
        },
        birth_month:{
            required : true
        },
        birth_year:{
            required : true
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
        },
        user_company_name:{
            validString: true,
            minlength: 2,
            maxlength: 100
        },
        user_company_number:{
            validPhoneNumber: true,
        },
        user_address_line_one:{
            required: true,
            validString: true,
            minlength: 10,
            maxlength: 100
        },
        user_address_line_two:{
            validString: true,
            minlength: 10,
            maxlength: 100
        },
        user_city:{
            required: true,
            validString: true,
            minlength: 2,
            maxlength: 50,
        },
        user_state:{
            required: true,
            validString: true,
            minlength: 2,
            maxlength: 50,
        },
        user_zipcode:{
            required: true,
            numbersonlys: true,
            minlength: 4,
            maxlength:50
        },
        user_country:{
            required: true,
        },
        accept_terms_conditions:{
            required: true
        },
        accept_captcha:{
            required: true
        }
    },
    messages: {
        account_type:{
            required: "please select account type"
        },
        user_first_name:{
            required: "please enter first name",
            lettersonlys:"Only alphabets and spaces are allowed",
            minlength:"Enter more than 5 characters",
            maxlength:"less than 26 characters are allowed"
        },
        user_last_name:{
            required: "please enter last name",
            lettersonlys:"Only alphabets and spaces are allowed",
            minlength:"Enter more than 5 characters",
            maxlength:"less than 26 characters are allowed"
        },
        user_email:{
            required:"please enter E-mail address",
            email:"Enter valid email address!"
        },
        user_phone_number:{
            required : "please enter phone number",
            validPhoneNumber: "please enter valid phone number"
        },
        user_mobile_number:{
            required : "please enter Mobile number",
            validPhoneNumber: "please enter valid mobile number"
        },
        birth_date:{
            required : "please select birth date"
        },
        birth_month:{
            required : "please select birth month"
        },
        birth_year:{
            required : "please select birth year"
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
        },
        user_company_name:{
            validString: "enter valid company name",
            minlength: "minimum 2 characters are required",
            maxlength: "maximum 100 characters are allowed"
        },
        user_company_number:{
            validPhoneNumber: "enter valid company number"
        },
        user_address_line_one:{
            required: "please enter address",
            validString: "enter valid address",
            minlength: "minimum 10 characters are required",
            maxlength: "maximum 100 characters are allowed"
        },
        user_address_line_two:{
            validString: "enter valid address",
            minlength: "minimum 10 characters are required",
            maxlength: "maximum 100 characters are allowed"
        },
        user_city:{
            required: "please enter city",
            validString: "enter valid city name",
            minlength: "minimum 2 characters are required",
            maxlength: "maximum 50 characters are allowed",
        },
        user_state:{
            required: "please enter state",
            validString: "enter valid city name",
            minlength: "minimum 2 characters are required",
            maxlength: "maximum 50 characters are allowed",
        },
        user_zipcode:{
            required: "please enter zipcode",
            numbersonlys: "Enter valid zipcode",
            minlength: "minimum 4 characters are required",
            maxlength : "maximum 50 characters are allowed"
        },
        user_country:{
            required: "Please select your country"
        },
        accept_terms_conditions:{
            required: "please accept terms and condition to proceed"
        },
        accept_captcha:{
            required: "Incomplete reCaptcha!"
        }
    },
    errorPlacement: function(error, element) {
        if (element.attr("name") == "account_type"){
            error.insertAfter(".account_type_area");
        }else if (element.attr("name") == "accept_terms_conditions"){
            error.insertAfter(".accept_terms_conditions_area");
        }else if (element.attr("name") == "accept_captcha"){
            error.insertAfter(".captcha-form-item");
        }else{
            error.insertAfter(element);
        }
    }
    });
});


