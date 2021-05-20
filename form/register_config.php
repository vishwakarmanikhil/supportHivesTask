<?php 
	
	include_once("form/dbconfig.php");
	$errors = array(); $error=NULL;

	//check email address already taken or not
	function checkuser_emailexist($con,$user_email){

		$query = $con->prepare("
				SELECT * from user where user_email=:user_email;
		");

		$query->bindParam(":user_email", $user_email);
		$query->execute();

		if ($query->rowCount()==0) {
			return true;
		}
		else{
			return false;
		}

	}


	// function to insert the data into database
	function registerUser($con,$user_account_type, $user_first_name,$user_last_name,$user_email, $phone_number, $mobile_number, $birth_date, $birth_month, $birth_year, $user_password, $user_company_name, $user_company_number, $user_address_line_one, $user_address_line_two, $user_city, $user_state, $user_zipcode, $user_country){
			
			$user_password=password_hash($user_password, PASSWORD_BCRYPT);
			$user_token=bin2hex(random_bytes(15));
			$user_email_status = "inactive";
			
			$query = $con->prepare("
				INSERT INTO user(user_account_type, user_first_name, user_last_name, user_email, user_phone_number, user_mobile_number, birth_date, birth_month, birth_year, user_password, user_company_name, user_company_number, user_address_line_one, user_address_line_two, user_city, user_state, user_zipcode, user_country, user_token, user_email_status) VALUES (:user_account_type, :user_first_name,:user_last_name,:user_email, :phone_number, :mobile_number, :birth_date, :birth_month, :birth_year, :user_password, :user_company_name, :user_company_number, :user_address_line_one, :user_address_line_two, :user_city, :user_state, :user_zipcode, :user_country, :user_token, :user_email_status)
			");

			$query->bindParam(":user_account_type", $user_account_type);
			$query->bindParam(":user_first_name",$user_first_name);
			$query->bindParam(":user_last_name",$user_last_name);
			$query->bindParam(":user_email",$user_email);
			$query->bindParam(":phone_number", $phone_number);
			$query->bindParam(":mobile_number", $mobile_number);			
			$query->bindParam(":birth_date", $birth_date);
			$query->bindParam(":birth_month", $birth_month);
			$query->bindParam(":birth_year", $birth_year);
			$query->bindParam(":user_password",$user_password);
			$query->bindParam(":user_company_name", $user_company_name);
			$query->bindParam(":user_company_number", $user_company_number);
			$query->bindParam(":user_address_line_one", $user_address_line_one);
			$query->bindParam(":user_address_line_two", $user_address_line_two);
			$query->bindParam(":user_city", $user_city);
			$query->bindParam(":user_state", $user_state);
			$query->bindParam(":user_zipcode", $user_zipcode);
			$query->bindParam("user_country", $user_country);
			$query->bindParam(":user_token",$user_token);
			$query->bindParam(":user_email_status",$user_email_status);

			return $query->execute();
	}


	//register form action
	if (isset($_POST['register_user'])) {
		
		if (!isset($_SESSION['user_id'])) {

			$con = connect();

			$user_first_name = strip_tags(trim($_POST['user_first_name']));
			$user_last_name = strip_tags(trim($_POST['user_last_name']));
			$user_email = strip_tags(trim($_POST['user_email']));
			$phone_country_code = strip_tags(trim($_POST['phone_country_code']));
			$user_phone_number = strip_tags(trim($_POST['user_phone_number']));
			$mobile_country_code = strip_tags(trim($_POST['mobile_country_code']));
			$user_mobile_number = strip_tags(trim($_POST['user_mobile_number']));
			$user_password = strip_tags(trim($_POST['user_password']));
			$user_confirm_password = strip_tags(trim($_POST['user_confirm_password']));
			$user_company_name = strip_tags(trim($_POST['user_company_name']));
			$user_company_number = strip_tags(trim($_POST['user_company_number']));
			$user_address_line_one = strip_tags(trim($_POST['user_address_line_one']));
			$user_address_line_two = strip_tags(trim($_POST['user_address_line_two']));
			$user_city = strip_tags(trim($_POST['user_city']));
			$user_state = strip_tags(trim($_POST['user_state']));
			$user_zipcode = strip_tags(trim($_POST['user_zipcode']));


			
			if (!isset($_POST['account_type'])) {
				$errors[]="Please Accept our Privacy & policy!";
			}else{
				$user_account_type = $_POST['account_type'];
			}



			if (!empty($user_first_name)) {
				if (strlen($user_first_name)>4 && strlen($user_first_name)<51) {
					if (!preg_match('/^[a-zA-Z ]*$/',$user_first_name)) {
						$errors[]="Name only contain alphabets";
					}	
				}else{
					$errors[]="First Name range from 4 to 50 characters";
				}
			}else{
				$errors[]="First Name is required!";
			}

			if (!empty($user_last_name)) {
				if (strlen($user_last_name)>4 && strlen($user_last_name)<51) {
					if (!preg_match('/^[a-zA-Z ]*$/',$user_last_name)) {
						$errors[]="Name only contain alphabets";
					}	
				}else{
					$errors[]="Last Name range from 4 to 50 characters";
				}
			}else{
				$errors[]="Last Name is required!";
			}




			$user_email = filter_var($user_email, FILTER_SANITIZE_EMAIL);
			if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				$errors[] = "Email Address is required!";
			}




			if (!empty($user_phone_number)) {
				if (!preg_match('/^[0-9]{4,10}$/',$user_phone_number)) {
					$errors[]="Enter valid phone number";
				}else{
					$phone_number  = $phone_country_code + $user_phone_number;
				}
			}else{
				$errors[]="phone number is required!";
			}

			if (!empty($user_mobile_number)) {
				if (!preg_match('/^[0-9]{4,10}$/',$user_mobile_number)) {
					$errors[]="Enter valid mobile number";
				}else{
					$mobile_number  = $mobile_country_code + $user_mobile_number;
				}
			}else{
				$errors[]="mobile number is required!";
			}			




			if (!isset($_POST['birth_date'])) {
				$errors[]="Please select birth date!";
			}else{
				$birth_date = $_POST['birth_date'];
			}

			if (!isset($_POST['birth_month'])) {
				$errors[]="Please select birth_month!";
			}else{
				$birth_month = $_POST['birth_month'];
			}

			if (!isset($_POST['birth_year'])) {
				$errors[]="Please select birth year!";
			}else{
				$birth_year = $_POST['birth_year'];
			}




			if (empty($user_password)) {
				$errors[]="Enter password!";
			}else{
				if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?._])[A-Za-z\d#$@!%&*?._]{8,16}$/', $user_password)) {
					$errors[]="Your password must be at least 8 characters and less than 17 characters. Atleast 1 uppercase, 1 lowercase, 1 special character(#$@!%&*?._) and 1 number.";
				}
			}

			if (empty($user_confirm_password)) {
				$errors[]="Enter confirm password!";
			}

			if ($user_password != $user_confirm_password) {
				$errors[] = "Password and Confirm Password Mismatch";
			}





			if (empty($user_company_name)) {
				$user_company_name = "none";
			}else{
				if (strlen($user_company_name)>2 && strlen($user_company_name)<101) {
					if (!preg_match('/^[-_.?&#$, a-zA-Z0-9]+$/', $user_company_name)) {
						$errors[] = "enter valid company name";
					}
				}else{
					$errors[] = "company name must be more than 2 characters and less than 100 characters!";
				}
			}

			if (empty($user_company_number)) {
				$user_company_number = "none";
			}else{
				if (!preg_match('/^[0-9]{4,10}$/',$user_company_number)) {
					$errors[]="Enter valid mobile number";
				}
			}	




			
			if (!empty($user_address_line_one)) {

				if (strlen($user_address_line_one)>10 && strlen($user_address_line_one)<101) {
					if (!preg_match('/^[-_.?&#$, a-zA-Z0-9]+$/', $user_address_line_one)) {
						$errors[] = "enter valid address";
					}
				}else{
					$errors[] = "address must be more than 10 characters and less than 100 characters!";
				}
				
			}else{
				$errors[] = "please enter your address";
			}

			if (empty($user_address_line_two)) {

				$user_address_line_two = "none";
				
			}else{
				if (strlen($user_address_line_two)>10 && strlen($user_address_line_two)<101) {
					if (!preg_match('/^[-_.?&#$, a-zA-Z0-9]+$/', $user_address_line_two)) {
						$errors[] = "enter valid address";
					}
				}else{
					$errors[] = "address must be more than 10 characters and less than 100 characters!";
				}
			}


			if (!empty($user_city)) {

				if (strlen($user_city)>5 && strlen($user_city)<50) {
					if (!preg_match('/^[-_.?&#$, a-zA-Z0-9]+$/', $user_city)) {
						$errors[] = "enter valid city name";
					}
				}else{
					$errors[] = "city must be more than 5 characters and less than 50 characters!";
				}
				
			}else{
				$errors[] = "please enter your city name";
			}

			if (!empty($user_state)) {

				if (strlen($user_state)>5 && strlen($user_state)<50) {
					if (!preg_match('/^[-_.?&#$, a-zA-Z0-9]+$/', $user_state)) {
						$errors[] = "enter valid state name";
					}
				}else{
					$errors[] = "state must be more than 5 characters and less than 50 characters!";
				}
				
			}else{
				$errors[] = "please enter your state name";
			}

			if (!empty($user_zipcode)) {

				if (strlen($user_zipcode)>5 && strlen($user_zipcode)<50) {
					if (!preg_match('/^[0-9]*$/', $user_zipcode)) {
						$errors[] = "enter valid zipcode";
					}
				}else{
					$errors[] ="zipcode must be more than 5 characters and less than 50 characters!";
				}
				
			}else{
				$errors[] = "please enter your zipcode";
			}

			if (!isset($_POST['user_country'])) {
				$errors[]="Please select your country name!";
			}else{
				$user_country = $_POST['user_country'];
			}






			if (!isset($_POST['accept_terms_conditions'])) {
				$errors[]="Please Accept our Terms & Conditions!";
			}

			if (!isset($_POST['accept_captcha'])) {
				$errors[]="Incomplete Captcha!";
			}


			

			if(count($errors)===0){

			   if (checkuser_emailexist($con,$user_email)) {

		   			if(registerUser($con,$user_account_type, $user_first_name,$user_last_name,$user_email, $phone_number, $mobile_number, $birth_date, $birth_month, $birth_year, $user_password, $user_company_name, $user_company_number, $user_address_line_one, $user_address_line_two, $user_city, $user_state, $user_zipcode, $user_country)){

		   				echo '<script>alert("User Account Created successfully.")</script>';

			   		}else{
			   			$errors[]="Failed to register please try again.";
			   		}
			   }
			   else{
			   		$errors[]="Email already exists! please choose different email.";
			   }

			}

		}else{
			
			$errors[]="you are already logged in. please logout first to create new account.";
			header("Location: index.html");
		}
	}


 ?>