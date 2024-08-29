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
		$formdata = json_decode(file_get_contents('php://input'), true);
		$validate=$this->Crud_model->get_single('users',"email='".$formdata['email']."'");
		if(!empty($validate)) {
			$response = array('status'=> 1,'msg'=>'Sorry this member already exist, try with another email.');
			echo json_encode($response);
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
				'password' => md5($formdata['password']),
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
			$get_setting=$this->Crud_model->get_single('setting');
			if(!empty($insert_id)) {
				$data=array(
					'activationURL' => base_url() . "email-verification/" . urlencode(base64_encode($insert_id)),
					'imagePath' => base_url().'uploads/logo/'.$get_setting->flogo,
					'fullname' => $fullname,
				);
				$message = $this->load->view('email_template/signup',$data,TRUE);
				require 'vendor/autoload.php';
				$mail = new PHPMailer(true);
				try {
					$mail->CharSet = 'UTF-8';
					$mail->SetFrom('no-reply@goigi.com', 'Afrebay');
					$mail->AddAddress($formdata['email']);
					$mail->IsHTML(true);
					$mail->Subject = 'Verify Your Email Address From Afrebay';
					$mail->Body = $message;
					$mail->IsSMTP();
					$mail->SMTPAuth   = true;
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail->Host       = "smtp.gmail.com";
					$mail->Port       = 587; //587 465
					$mail->Username   = "no-reply@goigi.com";
					$mail->Password   = "wj8jeml3eu0z";
					$mail->send();
					$response['status'] = "2";
					$response['msg'] = "We have sent an activation link to your account to continue with the registration process.";
			        echo json_encode($response);
				} catch (Exception $e) {
					$response['status'] = "3";
		            $response['msg'] = "Your message could not be sent. Please, try again later.";
                    echo json_encode($response);
				}
			} else {
				$response['status'] = "4";
				$response['msg'] = "Something went wrong. Please, try again later.";
				echo json_encode($response);
			}
		}
	}

    public function login() {
        $formdata = json_decode(file_get_contents('php://input'), true);
        $email = $formdata["email"];
		$password = $formdata["password"];
        if($this->Mymodel->check_record($email, $password)) {
            $response = array('status'=> 1,'msg'=>'Logged in successfully!');
            if($_SESSION['afrebay']['userType'] == '1') {
				$check_sub = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status IN (1,2)");
				if(empty($check_sub)) {
					//redirect('subscription');
                    $response = array('status'=> 3,'msg'=>'Redirecting to subscription Page.');
				} else {
					$profile_check = $this->db->query("SELECT `firstname`, `lastname`, `email`, `gender`, `address`, `zip`, `short_bio` FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
					if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['zip']) || empty($profile_check[0]['short_bio'])) {
                        //redirect('profile');
                        $response = array('status'=> 4,'msg'=>'Redirecting to profile Page.');
					} else {
                        //redirect('jobbid');
                        $response = array('status'=> 5,'msg'=>'Redirecting to jobbid Page.');
					}
				}
			} else if ($_SESSION['afrebay']['userType'] == '2') {
				$check_sub = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status IN (1,2)");
				if(empty($check_sub)) {
                    //redirect('subscription');
                    $response = array('status'=> 3,'msg'=>'Redirecting to subscription Page.');
                } else {
                	$profile_check = $this->db->query("SELECT `profilePic`, `companyname`, `email`, `mobile`,`address`, `foundedyear`, `teamsize`, `short_bio` FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                    if(empty($profile_check[0]['companyname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['address']) || empty($profile_check[0]['teamsize'])  || empty($profile_check[0]['short_bio'])) {
                    	//redirect('profile');
                        $response = array('status'=> 4,'msg'=>'Redirecting to profile Page.');
                	} else {
                		//redirect('dashboard');
                        $response = array('status'=> 5,'msg'=>'Redirecting to dashboard Page.');
                	}
                }
			} else {
				//redirect('login');
                $response = array('status'=> 6,'msg'=>'Redirecting to dashboard Page.');
			}
        } else {
            $response = array('status'=> 2,'msg'=>'Invalid Email Address or Password.');
        }
        echo json_encode($response);
    }

    public function send_forget_password() {
        $formdata = json_decode(file_get_contents('php://input'), true);
    	if(!empty($formdata['email'])) {
     		$get_email = $this->Crud_model->get_single('users',"email='".$formdata['email']."'");
         	if(!empty($get_email)) {
             	$data=array(
					'email'=>$get_email->email
				);
				$htmlContent = $this->load->view('email_template/forgot_password',$data,TRUE);
				require 'vendor/autoload.php';
				$mail = new PHPMailer(true);
				try {
					//Server settings
					$mail->CharSet = 'UTF-8';
					$mail->SetFrom('no-reply@goigi.com', 'Afrebay');
					$mail->AddAddress($formdata['email']);
					$mail->IsHTML(true);
					$mail->Subject = "Forgot Password Confirmation message from AFREBAY";
					$mail->Body = $htmlContent;
					//Send email via SMTP
					$mail->IsSMTP();
					$mail->SMTPAuth   = true;
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
					$mail->Host       = "smtp.gmail.com";
					$mail->Port       = 587; //587 465
					$mail->Username   = "no-reply@goigi.com";
					$mail->Password   = "wj8jeml3eu0z";
					$mail->send();
					$response = array('status'=> 1,'msg'=>'Please check your inbox. We have sent you an email to reset your password.');
				} catch (Exception $e) {
					$response = array('status'=> 2,'msg'=>'Something went wrong. Please try again later!');
				}
         	} else {
   				$response = array('status'=> 3,'msg'=>'Invalid Email Id!');
   			}
			echo json_encode($response);
		}
	}

    public function logout() {
	    unset($_SESSION['afrebay']);
        $response = array('status'=> 1,'msg'=>'You have logged out.');
		echo json_encode($response);
	}
}
