<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/REST_Controller.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Authentication extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel');
    }

	public function registration() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			$validate = $this->Crud_model->get_single('users',"email = '".$formdata['email']."'");
			if(!empty($validate)) {
				$msg = 'Sorry this member already exist, try with another email.';
				$response = array('status'=> 'error','result'=> $msg);
			} else {
				$data=array(
					'userType' => $formdata['user_type'],
					'firstname' => $formdata['first_name'],
					'lastname' => $formdata['last_name'],
					'companyname' => $formdata['company_name'],
					'email' => $formdata['email'],
					'address' => $formdata['location'],
					'latitude' => $formdata['latitude'],
					'longitude' => $formdata['longitude'],
					'password' => base64_encode($formdata['password']),
					'created'=> date('Y-m-d H:i:s'),
					'status'=> 0
				);

				$result = $this->Mymodel->insert('users',$data);
				if($formdata['first_name']) {
					$fullname = $formdata['first_name']." ".$formdata['last_name'];
				} else {
					$fullname = $formdata['company_name'];
				}

				$insert_id = $this->db->insert_id();
				$get_setting = $this->Crud_model->get_single('setting');
				if(!empty($insert_id)) {
					$data=array(
						'activationURL' => base_url() . "email-verification/" . urlencode(base64_encode($insert_id)),
						'imagePath' => base_url().'uploads/logo/'.$get_setting->flogo,
						'fullname' => $fullname,
					);
					$message = "<body><div style='width:600px;margin: 0 auto;background: #fff; border: 1px solid #e6e6e6;'><div style='padding: 30px 30px 15px 30px;box-sizing: border-box;'><img src='cid:Logo' style='width:100px;float: right;margin-top: 0 auto;'><h3 style='padding-top:40px; line-height: 30px;'>Greetings from<span style='font-weight: 900;font-size: 25px;color: #F44C0D; display: block;'>Pay Per Dialog</span></h3><p style='font-size: 17px; margin: 0;'>Hello $fullname,</p><p style='font-size: 17px; margin: 5px 0 0 0;'>Thank you for registration on Pay Per Dialog.</p><p style='font-size: 17px; margin: 5px 0 0 0;'>Please click the button below to verify your email address.</p><p style='text-align: center;'><a href='".base_url() . "email-verification/" . urlencode(base64_encode($insert_id))."' style='height: 50px; width: 220px; background: rgb(253,179,2); background: linear-gradient(0deg, rgba(253,179,2,1) 0%, rgba(244,77,9,1) 100%); text-align: center; font-size: 18px; color: #fff; border-radius: 12px; display: inline-block; line-height: 50px; text-decoration: none; text-transform: uppercase; font-weight: 600;'>ACTIVATE</a></p><p style='font-size: 17px; margin: 5px 0 0 0;'>Thank you!</p><p style='font-size: 17px; margin: 5px 0 0 0; list-style: none;'>Sincerly</p><p style='list-style: none;margin: 5px 0 0 0;font-size: 15px;'><b>Pay Per Dialog</b></p><p style='list-style: none;margin: 5px 0 0 0;font-size: 10px;'><b>Visit us:</b> <span>$get_setting->address</span></p><p style='list-style: none;margin: 5px 0 0 0;font-size: 10px;'><b>Email us:</b> <span>$get_setting->email</span></p></div><table style='width: 100%;'><tr><td style='height:30px;width:100%; background: red;padding: 10px 0px; font-size:13px; color: #fff; text-align: center;'>Copyright &copy; <?=date('Y')?> Pay Per Dialog. All rights reserved.</td></tr></table></div></body>";
					require 'vendor/autoload.php';
					$mail = new PHPMailer(true);
					$mail->CharSet = 'UTF-8';
					$mail->SetFrom('info@payperdialog.com', 'Pay Per Dialog');
					$mail->AddAddress($formdata['email']);
					$mail->IsHTML(true);
					$mail->Subject = 'Verify Your Email Address From Pay Per Dialog';
					$mail->AddEmbeddedImage('uploads/logo/'.$get_setting->flogo, 'Logo');
					$mail->Body = $message;
					//Send email via SMTP
					$mail->IsSMTP();
					$mail->SMTPAuth   = true;
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail->Host       = "smtp.hostinger.com";
					$mail->Port       = 587; //587 465
					$mail->Username   = "info@payperdialog.com";
					$mail->Password   = "PayperLLC@2024";
					$mail->send();
					$msg = "We have sent an activation link to your account to continue with the registration process.";
					$response = array('status'=> 'success','result'=> $msg);
				} else {
					$msg = "Something went wrong. Please, try again later.";
					$response = array('status'=> 'error','result'=> $msg);
				}
			}
		} catch (\Exception $e) {
			$response = array('status'=> 'error','result'=> $e->getMessage());
	    }
		echo json_encode($response);
	}

    public function login() {
        try {
            $formdata = json_decode(file_get_contents('php://input'), true);
            $email = $formdata["email"];
    		$password = $formdata["password"];
			$check_user = $this->db->query("SELECT * FROM users WHERE email = '".$email."' AND password = '".base64_encode($password)."' AND status = '1'")->result_array();
			if(!empty($check_user)) {
                $msg = 'Logged in successfully';
                $get_setting=$this->Crud_model->get_single('setting');
				if($get_setting->required_subscription == '1') {
	            	if($check_user['0']['userType'] == '1') {
	    				$check_sub = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$check_user['0']['userId']."' AND status IN (1,2)");
	    				if(empty($check_sub)) {
							$response = array('status'=> 'success','result'=> $check_user);
							$response = array_merge($response, array("subscription"=> "0"));
	    				} else {
	    					$profile_check = $this->db->query("SELECT `firstname`, `lastname`, `email`, `gender`, `address`, `zip`, `short_bio` FROM `users` WHERE userId = '".@$check_user['0']['userId']."'")->result_array();
	    					if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['zip']) || empty($profile_check[0]['short_bio'])) {
	                            $response = array('status'=> 'success','result'=> $check_user);
	                            $response = array_merge($response, array("profile"=> "0"));
	    					} else {
	                            $response = array('status'=> 'success','result'=> $check_user);
	                            $response = array_merge($response, array("profile"=> "1"));
	                        }
	    				}
	    			} else if ($check_user['0']['userType'] == '2') {
	    				$check_sub = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$check_user['0']['userId']."' AND status IN (1,2)");
	    				if(empty($check_sub)) {
	                        $response = array('status'=> 'success','result'=> $check_user);
	                        $response = array_merge($response, array("subscription"=> "0"));
	                    } else {
	                    	$profile_check = $this->db->query("SELECT `profilePic`, `companyname`, `email`, `mobile`,`address`, `foundedyear`, `teamsize`, `short_bio` FROM `users` WHERE userId = '".@$check_user['0']['userId']."'")->result_array();
	                        if(empty($profile_check[0]['companyname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['address']) || empty($profile_check[0]['teamsize'])  || empty($profile_check[0]['short_bio'])) {
	                        	$response = array('status'=> 'success','result'=> $check_user);
	                        	$response = array_merge($response, array("profile"=> "0"));
	                    	} else {
	                            $response = array('status'=> 'success','result'=> $check_user);
	                            $response = array_merge($response, array("profile"=> "1"));
	                    	}
	                    }
	    			} else if ($_SESSION['afrebay']['userType'] == '3') {
						$check_sub = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status IN (1,2)");
						if(empty($check_sub)) {
							redirect('subscription');
						} else {
							$profile_check = $this->db->query("SELECT `firstname`, `lastname`, `email`, `gender`, `address`, `zip`, `short_bio` FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
							if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['zip']) || empty($profile_check[0]['short_bio'])) {
								redirect('profile');
							} else {
								redirect('jobbid');
							}
						}
					} else {
	                    $response = array('status'=> 'success','result'=> $check_user);
	                    $response = array_merge($response, array("profile"=> "1"));
	    			}
	    		} else {
	    			if($check_user['0']['userType'] == '1') {
	    				$profile_check = $this->db->query("SELECT `firstname`, `lastname`, `email`, `gender`, `address`, `zip`, `short_bio` FROM `users` WHERE userId = '".@$check_user['0']['userId']."'")->result_array();
    					if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['zip']) || empty($profile_check[0]['short_bio'])) {
                            $response = array('status'=> 'success','result'=> $check_user);
                            $response = array_merge($response, array("profile"=> "0", "required_subscription"=> "0"));
    					} else {
                            $response = array('status'=> 'success','result'=> $check_user);
                            $response = array_merge($response, array("profile"=> "1", "required_subscription"=> "1"));
                        }
	    			} else if ($check_user['0']['userType'] == '2') {
	    				$profile_check = $this->db->query("SELECT `profilePic`, `companyname`, `email`, `mobile`,`address`, `foundedyear`, `teamsize`, `short_bio` FROM `users` WHERE userId = '".@$check_user['0']['userId']."'")->result_array();
                        if(empty($profile_check[0]['companyname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['address']) || empty($profile_check[0]['teamsize'])  || empty($profile_check[0]['short_bio'])) {
                        	$response = array('status'=> 'success','result'=> $check_user);
                        	$response = array_merge($response, array("profile"=> "0", "required_subscription"=> "0"));
                    	} else {
                            $response = array('status'=> 'success','result'=> $check_user);
                            $response = array_merge($response, array("profile"=> "1", "required_subscription"=> "1"));
                    	}
	                } else if ($_SESSION['afrebay']['userType'] == '3') {
						$check_sub = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status IN (1,2)");
						if(empty($check_sub)) {
							redirect('subscription');
						} else {
							$profile_check = $this->db->query("SELECT `firstname`, `lastname`, `email`, `gender`, `address`, `zip`, `short_bio` FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
							if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['zip']) || empty($profile_check[0]['short_bio'])) {
								redirect('profile');
							} else {
								redirect('jobbid');
							}
						}
					} else {
	                    $response = array('status'=> 'success','result'=> $check_user);
	                    $response = array_merge($response, array("profile"=> "1", "required_subscription"=> "0"));
	    			}
	    		}
            } else {
                $msg = 'Invalid Email Address or Password';
                $response = array('status'=> 'error','result'=> $msg);
            }
        } catch (\Exception $e) {
            $response = array('status'=> 'error', 'result'=> $e->getMessage());
        }
        echo json_encode($response);
    }

    public function send_forget_password() {
        try {
            $formdata = json_decode(file_get_contents('php://input'), true);
        	if(!empty($formdata['email'])) {
         		$get_email = $this->Crud_model->get_single('users',"email = '".$formdata['email']."'");
             	if(!empty($get_email)) {
                 	$numbers = rand(000000,999999);
    				$data1 = array(
    					'forgot_otp' => $numbers
    				);
    				$this->Crud_model->SaveData('users',$data1,"email = '".$get_email->email."'");
					$get_setting = $this->Crud_model->get_single('setting');
    				//$htmlContent = $this->load->view('email_template/forgot_password',$data,TRUE);
                 	$htmlContent = "<div style='width:600px;margin: 0 auto;background: #fff; border: 1px solid #e6e6e6;'><div style='padding: 30px 30px 15px 30px;box-sizing: border-box;'><img src='cid:Logo' style='width:100px;float: right;margin-top: 0 auto;'><h3 style='padding-top:40px; line-height: 30px;'>Greetings from<span style='font-weight: 900;font-size: 25px;color: #505050; display: block;'>Pay Per Dialog</span></h3><p style='font-size: 24px; margin: 0;'>Verification code</p><p style='font-size: 17px; margin: 5px 0 0 0;'>Please use the verification code below to sign in.</p><p style='font-size: 22px; margin: 5px 0 0 0;'><b>$numbers</b></p><p style='font-size: 17px; margin: 5px 0 0 0;'>If you didn’t request this, you can ignore this email.</p><p style='font-size: 17px; margin: 5px 0 0 0;'>Thank you!</p><p style='font-size: 17px; margin: 5px 0 0 0; list-style: none;'>Sincerly</p><p style='list-style: none;margin: 5px 0 0 0;font-size: 15px;'><b>Pay Per Dialog</b></p><p style='list-style: none;margin: 5px 0 0 0;font-size: 10px;'><b>Visit us:</b><span>$get_setting->address</span></p><p style='list-style: none;margin: 5px 0 0 0;font-size: 10px;'><b>Email us:</b><span>$get_setting->email</span></p></div><table style='width: 100%;'><tr><td style='height:30px; width:100%; background: #7e0e14; padding: 10px 0px; font-size:13px; color: #fff; text-align: center;'>Copyright &copy; <?=date('Y')?> Pay Per Dialog. All rights reserved.</td></tr></table></div>";
    				require 'vendor/autoload.php';
    				$mail = new PHPMailer(true);
    				try {
    					//Server settings
    					$mail->CharSet = 'UTF-8';
    					$mail->SetFrom('info@payperdialog.com', 'Pay Per Dialog');
    					$mail->AddAddress($formdata['email']);
    					$mail->IsHTML(true);
    					$mail->Subject = "Forgot Password Confirmation message from Pay Per Dialog";
    					$mail->AddEmbeddedImage('uploads/logo/'.$get_setting->flogo, 'Logo');
    					$mail->Body = $htmlContent;
    					//Send email via SMTP
    					$mail->IsSMTP();
						$mail->SMTPAuth   = true;
						$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
						$mail->Host       = "smtp.hostinger.com";
						$mail->Port       = 587; //587 465
						$mail->Username   = "info@payperdialog.com";
						$mail->Password   = "PayperLLC@2024";
						$mail->send();
    					$msg = 'Please check your inbox. We have sent you an email to reset your password.';
    					$response = array('status'=> 'success','result'=> $msg);
    				} catch (Exception $e) {
    					$msg = 'Something went wrong. Please try again later!';
    					$response = array('status'=> 'error','result'=> $msg);
    				}
             	} else {
       				$msg = 'Invalid Email Id!';
       				$response = array('status'=> 'error','result'=> $msg);
       			}
    		} else {
				$msg = 'Please enter a valid email address';
				$response = array('status'=> 'error','result'=> $msg);
			}
        } catch (\Exception $e) {
            $response = array('status'=> 'error','result'=> $e->getMessage());
        }
        echo json_encode($response);
	}

	public function set_new_password() {
		try {
			$formdata = json_decode(file_get_contents('php://input'), true);
			if(!empty($formdata['u_otp'])) {
		 		$check_otp = $this->Crud_model->GetData('users','',"forgot_otp='".$formdata['u_otp']."'",'','','','1');
		 		if(!empty($check_otp)) {
		 			$get_email = $this->Crud_model->GetData('users','',"forgot_otp='".$formdata['u_otp']."'",'','','','1');
		 			if(!empty($get_email)) {
						$data = array('password' => md5($formdata['new_password']));
					 	$con="userId='".$get_email->userId."'";
					 	$this->Crud_model->SaveData('users',$data, $con);
					 	$data1 = array(
	    					'forgot_otp' => ""
	    				);
					 	$this->Crud_model->SaveData('users',$data1,"userId='".$get_email->userId."'");
					 	$response = array('status'=> 'success','result'=> 'You have reset your password successfully. Please try to login.');
		            } else {
		            	$response = array('status'=> 'error','result'=> 'Something went wrong. Please try again later!');
		            }
		 		} else {
		 			$response = array('status'=> 'error','result'=> 'Invalid OTP');
		 		}
	        }
		} catch (Exception $e) {
			$response = array('status'=> 'error','result'=> $e->getMessage());
        }
        echo json_encode($response);
	}

    public function logout() {
	    unset($_SESSION['afrebay']);
        $response = array('status'=> 'success','result'=> 'You have logged out.');
		echo json_encode($response);
	}
}
