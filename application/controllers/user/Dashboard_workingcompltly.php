<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('post_job_model');
		$this->load->model('Users_model');
		if (!$this->session->userdata('afrebay')) {
			header("location" . base_url() . "login");
		}
	}

	function index() {
		$data['get_service'] = $this->Crud_model->GetData('employer_services', '', "employer_id='" . $_SESSION['afrebay']['userId'] . "'");
		$data['get_job'] = $this->Crud_model->GetData('postjob', '', "user_id='".$_SESSION['afrebay']['userId']."'");
		$data['bid_job'] = $this->db->query("SELECT `postjob`.*, `job_bid`.* FROM `job_bid` JOIN `postjob` ON `postjob`.`id` = `job_bid`.`postjob_id` where `postjob`.user_id = '".$_SESSION['afrebay']['userId']."' AND postjob.is_delete = '0'")->result_array();
		$data['get_subscribe'] = $this->Crud_model->GetData('employer_subscription', '', "employer_id='" . $_SESSION['afrebay']['userId'] . "'");
		$data['get_user'] = $this->Crud_model->get_single('users', "userId ='" . $_SESSION['afrebay']['userId'] . "' and userType='1'");
		$data['get_product'] = $this->Crud_model->GetData('user_product', '', "user_id='".$_SESSION['afrebay']['userId']."' AND status = 1 AND is_delete= 1");
		$this->load->view('header');
		$this->load->view('user_dashboard/dashboard', $data);
		$this->load->view('footer');
	}

	public function view_profile() {
		$user_info = $this->Crud_model->get_single('users', "userId='" . $_SESSION['afrebay']['userId'] . "'");
		$data = array(
			'userinfo' => $user_info,
		);
		$this->load->view('header');
		$this->load->view('user_dashboard/view_profile', $data);
		$this->load->view('footer');
	}

	public function profile() {
	 	$user_id=base64_decode($this->uri->segment(2));
		if($user_id!=''){
			$userid=$user_id;
			$data_request='admin';
			$this->load->view('admin_header');
		} else {
			$userid=$_SESSION['afrebay']['userId'];
			$data_request='user';
			$this->load->view('header');
		}
		$portfolio_content = $this->Crud_model->GetData('users_portfolio', '', "user_id = '" . $_SESSION['afrebay']['userId'] . "'");
		$user_info = $this->Crud_model->get_single('users', "userId='" . $userid . "'");
		$data = array(
			'userinfo' => $user_info,
			'data_request'=>$data_request,
			'portfolio_content'=>$portfolio_content,
		);
		$this->load->view('user_dashboard/profile_settings', $data);
		$this->load->view('footer');
	}

	public function update_profile() {
		if ($_FILES['profilePic']['name'] != '') {
			$_POST['profilePic'] = rand(0000, 9999) . "_" . $_FILES['profilePic']['name'];
			$config2['image_library'] = 'gd2';
			$config2['source_image'] =  $_FILES['profilePic']['tmp_name'];
			$config2['new_image'] =   getcwd() . '/uploads/users/' . $_POST['profilePic'];
			$config2['upload_path'] =  getcwd() . '/uploads/users/';
			$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
			$config2['maintain_ratio'] = FALSE;
			$this->image_lib->initialize($config2);
			if (!$this->image_lib->resize()) {
				echo ('<pre>');
				echo ($this->image_lib->display_errors());
				exit;
			} else {
				$image  = $_POST['profilePic'];
				@unlink('uploads/users/' . $_POST['old_image']);
			}
		} else {
			$image  = $_POST['old_image'];
		}

		if ($_FILES['resume']['name'] != '') {
			$src = $_FILES['resume']['tmp_name'];
			$filEnc = time();
			$avatar = rand(0000, 9999) . "_" . $_FILES['resume']['name'];
			$avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
			$dest = getcwd() . '/uploads/users/resume/' . $avatar1;
			if (move_uploaded_file($src, $dest)) {
				$resume  = $avatar1;
				@unlink('uploads/users/resume/' . $_POST['old_resume']);
			}
		} else {
			if(!empty($_POST['old_resume'])) {
				$resume  = $_POST['old_resume'];
			} else {
				$resume  = '';
			}
		}

		if(!empty($this->input->post('key_skills'))) {
			$key_skills = $this->input->post('key_skills');
			for ($i=0; $i < count($key_skills); $i++) {
				$get_specialist = $this->db->query("SELECT * FROM specialist WHERE specialist_name = '".$key_skills[$i]."'")->result();
				if(empty($get_specialist)) {
					$insrt = array(
						'specialist_name'=>ucfirst($key_skills[$i]),
						'created_date'=>date('Y-m-d H:i:s'),
					);
					$this->db->insert('specialist',$insrt);
				}
			}
			$skills = implode(",",$this->input->post('key_skills',TRUE));
		} else {
			$skills = '';
		}

		$data = array(
			'companyname' => $_POST['companyname'],
			'firstname' => $_POST['firstname'],
			'lastname' => $_POST['lastname'],
			'email' => $_POST['email'],
			'mobile' => $_POST['mobile'],
			'gender' => $this->input->post('gender', TRUE),
			'experience' => $this->input->post('experience', TRUE),
			'skills' => $skills,
			'profilePic' => $image,
			'zip' => $_POST['zip'],
			'address' => $_POST['address'],
			'foundedyear' => $_POST['foundedyear'],
			'teamsize' => $_POST['teamsize'],
			'latitude' => $_POST['latitude'],
			'longitude' => $_POST['longitude'],
			'short_bio' => $_POST['short_bio'],
			'rateperhour' => $_POST['rateperhour'],
			'resume' => $resume,
		);
		//echo "<pre>"; print_r($_FILES['portfolio_file']); die;
		if (!empty($_FILES['portfolio_file']['size'])) {
        	$count = count($_FILES['portfolio_file']['name']);
        	$getData = $this->db->query('DELETE FROM users_portfolio WHERE user_id = "'.$_SESSION['afrebay']['userId'].'"');
	        for ($i=0; $i < $count; $i++) {
	            $src = $_FILES['portfolio_file']['tmp_name'][$i];
	            $filEnc = time();
	            $avatar = rand(0000, 9999) . "_" . $_FILES['portfolio_file']['name'][$i];
	            $avatar1 = str_replace(array('(', ')', ' '), '', $avatar);
	            $dest = getcwd() . '/uploads/users/portfolio_file/' . $avatar1;
	            if (move_uploaded_file($src, $dest)) {
	                $file1  = $avatar1;
	            }
				if(!empty($file1)) {
					$file  = $file1;
				} else if(!empty($_POST['old_portfolio_file'])) {
					$file  = $_POST['old_portfolio_file'];
				} else {
					$file  = "";
				}
	            $details_data = array(
                    'user_id'=> $_SESSION['afrebay']['userId'],
                    'content_title'=> $_POST['content_title'][$i],
                    'portfolio_file'=> $file,
                    'created_date'=> date('Y-m-d H:m:s')
                );
                $this->Crud_model->SaveData('users_portfolio',$details_data);
	        }
        }

		$this->Crud_model->SaveData('users', $data, "userId='" . $_POST['id'] . "'");
		if($_POST['from_data_request']=='admin') {
			$this->session->set_flashdata('message', 'Profile Updated Successfull !');
			redirect(base_url('admin/users'));
		} else {
			$this->session->set_flashdata('message', 'Profile Updated Successfull !');
			redirect(base_url('profile'));
		}
	}

	function getVisIpAddr() {
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        	return $_SERVER['HTTP_CLIENT_IP'];
    	} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        	return $_SERVER['HTTP_X_FORWARDED_FOR'];
    	} else {
        	return $_SERVER['REMOTE_ADDR'];
    	}
	}

	public function subscription() {
		$vis_ip = $this->getVisIPAddr(); // Store the IP address
		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip));
		$countryName = $ipdat->geoplugin_countryName;
		if($countryName == 'Nigeria') {
			$cond = " WHERE subscription_country = 'Nigeria'";
		} else {
			$cond = " WHERE subscription_country = 'Global'";
		}

		if($_SESSION['afrebay']['userType'] == '1') {
			$uType = 'Employee';
		} else {
			$uType = 'Employer';
		}

		$data['get_subscription'] = $this->db->query("SELECT * FROM subscription ".$cond." AND subscription_user_type = '".$uType."'")->result();
		$data['current_plan'] = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status IN (1,2)");
		$data['expired_plan'] = $this->Crud_model->GetData('employer_subscription', '', "employer_id='".$_SESSION['afrebay']['userId']."' AND status = '3'");
		$data['subscription_check'] = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
		$this->load->view('header');
		$this->load->view('user_dashboard/subscription', $data);
		$this->load->view('footer');
	}

	public function products() {
		$data['product_list'] = $this->Crud_model->GetData('user_product', '', "user_id='".$_SESSION['afrebay']['userId']."' AND status = 1 and is_delete = 1");
		$this->load->view('header');
		$this->load->view('user_dashboard/product/list', $data);
		$this->load->view('footer');
	}

	public function myservice() {
		$data['get_services'] = $this->Crud_model->GetData('employer_services', '', "employer_id='" . $_SESSION['afrebay']['userId'] . "'");
		$this->load->view('header');
		$this->load->view('user_dashboard/my_service', $data);
		$this->load->view('footer');
	}

	public function service_form() {
		$get_category = $this->Crud_model->GetData('category');
		$data = array(
			'button' => 'Submit',
			'action' => base_url('user/Dashboard/save_service'),
			'service_name' => set_value('service_name'),
			'category_id' => set_value('category_id'),
			'subcategory_id' => set_value('subcategory_id'),
			'description' => set_value('description'),
			'get_category' => $get_category,
			'id' => set_value('id'),
		);
		$this->load->view('header');
		$this->load->view('user_dashboard/service_form', $data);
		$this->load->view('footer');
	}

	public function update_service_form($id) {
		$service_id = base64_decode($id);
		$get_category = $this->Crud_model->GetData('category');
		$get_subcategory = $this->Crud_model->GetData('sub_category');
		$get_services = $this->Crud_model->get_single('employer_services', "id='" . $service_id . "'");
		$data = array(
			'button' => 'Update',
			'action' => base_url('user/Dashboard/update_service'),
			//'action'=>admin_url('Event/create_action'),
			'service_name' => $get_services->service_name,
			'category_id' => $get_services->category_id,
			'subcategory_id' => $get_services->subcategory_id,
			'description' => $get_services->description,
			'id' => $get_services->id,
			'get_category' => $get_category,
			'get_subcategory' => $get_subcategory,
		);
		$this->load->view('header');
		$this->load->view('user_dashboard/service_form', $data);
		$this->load->view('footer');
	}

	public function save_service() {
		$data = array(
			'employer_id' => $_SESSION['afrebay']['userId'],
			'service_name' => $_POST['service_name'],
			'category_id' => $_POST['category_id'],
			'subcategory_id' => $_POST['subcategory_id'],
			'description' => $_POST['description'],
			'created_date' => date('Y-m-d H:i:s'),
		);
		$this->Crud_model->SaveData('employer_services', $data);
		$this->session->set_flashdata('message', 'Services Created Successfull !');
		redirect(base_url('myservice'));
	}

	public function update_service() {
		$id = $_POST['id'];
		$data = array(
			'service_name' => $_POST['service_name'],
			'category_id' => $_POST['category_id'],
			'subcategory_id' => $_POST['subcategory_id'],
			'description' => $_POST['description'],
		);
		$this->Crud_model->SaveData('employer_services', $data, "id='" . $id . "'");
		$this->session->set_flashdata('message', 'Services Updated Successfully !');
		redirect(base_url('myservice'));
	}

	function delete_service($id) {

		$this->Crud_model->DeleteData('employer_services', "id='" . $id . "'");
		$this->session->set_flashdata('message', 'Service Deleted successfully !');
		redirect(base_url('myservice'));
	}

	public function myjob() {
		$data['get_postjob'] = $this->Crud_model->GetData('postjob', '', "user_id='".$_SESSION['afrebay']['userId']."' ");
		//print_r($data); die();
		$this->load->view('header');
		$this->load->view('user_dashboard/my_job', $data);
		$this->load->view('footer');
	}

	public function buy_subscription() {
		$employer_id = $_SESSION['afrebay']['userId'];
		$data = array(
			'employer_id' => $employer_id,
			'subscription_id' => $_POST['subscription_id'],
			'amount' => $_POST['amount'],
			'created_date' => date('Y-m-d, H:i:s'),
		);
		$this->Crud_model->SaveData('employer_subscription', $data);
		$this->session->set_flashdata('message', 'Subscription purchased Successfull !');
		echo '1';
	}

	////////////////////////////////////////// start job bidding//////////////////
	function jobbid() {
		$this->load->model('Post_job_model');
		if($_SESSION['afrebay']['userType'] == '1'){
			//$data['get_postjob'] = $this->db->query("SELECT postjob.*, job_bid.*, users.* from job_bid JOIN postjob ON job_bid.postjob_id = postjob.id JOIN users ON job_bid.user_id = users.userId WHERE postjob.user_id ='".$_SESSION['afrebay']['userId']."'")
			$cond = "job_bid.user_id='" . $_SESSION['afrebay']['userId'] . "'";
		} else {
			//$data['get_postjob'] = $this->db->query("SELECT postjob.*, job_bid.*, users.* from job_bid JOIN postjob ON job_bid.postjob_id = postjob.id JOIN users ON job_bid.user_id = users.userId WHERE postjob.user_id =")
			$cond = "postjob.user_id='" . $_SESSION['afrebay']['userId'] . "'";
		}
		$data['get_postjob'] = $this->Post_job_model->postjob_bid($cond);
		$this->load->view('header');
		$this->load->view('user_dashboard/my_jobbid', $data);
		$this->load->view('footer');
	}

	function save_postbid() {
		$data = array(
			'postjob_id' => $_POST['postjob_id'],
			'user_id' => $_SESSION['afrebay']['userId'],
			'bid_amount' => $_POST['bid_amount'],
			'currency' => $_POST['currency'],
			//'email' => $_POST['email'],
			'duration' => $_POST['duration'],
			//'phone' => $_POST['phone'],
			'description' => $_POST['description'],
			'created_date' => date('Y-m-d H:i:s'),
		);
		$this->Crud_model->SaveData('job_bid', $data);
		$insert_id = $this->db->insert_id();
		if(!empty($insert_id)) {
			$this->session->set_flashdata('message', 'Bid Submitted Successfully! You will be notified once the Business has approved your bid');
			redirect(base_url("postdetail/".base64_encode($_POST['postjob_id'])), "refresh");
		} else {
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later.');
			redirect(base_url("postdetail/".base64_encode($_POST['postjob_id'])), "refresh");
		}

	}

	/*function changebiddingstatus() {
		print_r($this->input->post()); die;
		$get_data = $this->Crud_model->get_single('job_bid', "id='" . $_POST['jobbid_id'] . "'");
		if ($get_data->bidding_status == 'Pending') {
			$data1 = array(
				'bidding_status' => 'Accept',
			);
			$this->Crud_model->SaveData('job_bid', $data1, "id='" . $_POST['jobbid_id'] . "'");
		}
		$updatepost = array(
			'is_delete' => 1,
		);
		$this->Crud_model->SaveData('postjob', $updatepost, "id='" . $get_data->postjob_id . "'");
		$binddingstatus = $this->Crud_model->GetData('job_bid', '', "postjob_id='" . $get_data->postjob_id . "' and bidding_status='Pending'");
		foreach ($binddingstatus as $row) {
			$data = array(
				'bidding_status' => 'Reject',
			);
			$this->Crud_model->SaveData('job_bid', $data, "id='" . $row->id . "'");
		}
		echo "1";
		exit;
	}*/

	function changebiddingstatus() {
		$bidstatus = $this->input->post('bidstatus');
		$jodBidid = $this->input->post('jodBidid');
		$postJobid = $this->input->post('postJobid');
		$jobbiduserid = $this->input->post('jobbiduserid');
		$jobpostuserid = $this->input->post('jobpostuserid');
		$data1 = array(
			'bidding_status' => $bidstatus,
		);
		$this->Crud_model->SaveData('job_bid', $data1, "id='".$jodBidid."' AND postjob_id='".$postJobid."'");
		if($bidstatus == "Ready for Interview") {
			$this->Crud_model->SaveData('job_bid', $data1, "id='".$jodBidid."' AND postjob_id='".$postJobid."'");
			$binddingstatus = $this->Crud_model->GetData('job_bid', '', "postjob_id = '".$postJobid."' and bidding_status IN ('', NULL, 'Pending', 'Screened Out', 'Screened In')");
			foreach ($binddingstatus as $row) {
				$data = array(
					'bidding_status' => 'Screened Out',
				);
				$this->Crud_model->SaveData('job_bid', $data, "id='" . $row->id . "'");
			}
			// $getChatData = $this->db->query("SELECT * FROM chat WHERE userfrom_id != '".$jobbiduserid."' AND userto_id != '".$jobbiduserid."' AND postjob_id = '".$postJobid."'")->result();
			// if(!empty($getChatData)) {
			// 	$updateChatData = $this->db->query("UPDATE chat SET is_delete = '2' WHERE userfrom_id != '".$jobbiduserid."' AND userto_id != '".$jobbiduserid."' AND postjob_id = '".$postJobid."'");
			// }
			$updatepost = array(
				'is_delete' => 1,
			);
			$this->Crud_model->SaveData('postjob', $updatepost, "id='".$postJobid."'");
		}
		echo "1";
		exit;
	}

	/////////////////////////////////////////  End job bidding////////////////////
	function availability() {
		$this->load->view('header');
		$this->load->view('user_dashboard/calender');
		$this->load->view('footer');
	}

	function booking_history() {
		$this->load->view('header');
		$this->load->view('user_dashboard/booking_history');
		$this->load->view('footer');
	}

	////////////////////////////////// start chat functionality////////////////
	function chat() {
		$data['get_user'] = $this->Crud_model->get_single('users', "userId ='".$_SESSION['afrebay']['userId']."'");
		//$cond = "job_bid.bidding_status='Accept'";
		$cond = "job_bid.bidding_status = 'Screened In'";
		$data['get_jobbid'] = $this->Users_model->get_jobbidding($cond);
		$this->load->view('header');
		$this->load->view('user_dashboard/chat', $data);
		$this->load->view('footer');
	}

	// function showmessage_count() {
	// 	$userId = $this->input->post('userId');
	// 	$user_id = $this->input->post('usertoid');
	// 	$post_id = $this->input->post('postid');
	// 	$getUserType = $this->db->query("Select * FROM users WHERE userId ='".$user_id."'")->result();
	// 	$uType = $getUserType[0]->userType;
	// 	$countMessage = $this->db->query("Select COUNT(id) as msgcount, userfrom_id, userto_id FROM chat WHERE (userfrom_id ='".$usertoid."' AND userto_id ='".$userfromid."') OR (userto_id ='".$usertoid."' AND userfrom_id ='".$userfromid."') AND postjob_id = '".$post_id."' AND status = 0")->result();
	// 	$data = array(
	// 		'userfrom_id' => $countMessage[0]->userfrom_id,
	// 		'userto_id' => $countMessage[0]->userto_id,
	// 		'count' => $countMessage[0]->msgcount,
	// 	);
	// 	echo json_encode($data);
	// }

	function showmessage_count() {
		$user_id = $this->input->post('userId');
		//echo "Select COUNT(id) as msgcount, userto_id FROM chat WHERE userto_id ='".$user_id."' AND status = '0'";
		$getUserType = $this->db->query("Select * FROM users WHERE userId ='".$user_id."'")->result();
		$uType = $getUserType[0]->userType;
		$countMessage = $this->db->query("Select COUNT(id) as msgcount, userfrom_id, userto_id FROM chat WHERE userto_id ='".$user_id."' AND status = '0'")->result();
		$data = array(
			'userfrom_id' => $countMessage[0]->userfrom_id,
			'userto_id' => $countMessage[0]->userto_id,
			'count' => $countMessage[0]->msgcount,
		);
		echo json_encode($data);
	}

	function showmessageCountEach() {
		$userfromid = $this->input->post('userfromid');
		$usertoid = $this->input->post('usertoid');
		$postid = $this->input->post('postid');
		$getEachChatCount = $this->db->query("Select COUNT(id) as msgcount, userfrom_id, userto_id, postjob_id FROM chat WHERE userto_id ='".$userfromid."' AND postjob_id ='".$postid."' AND status = '0'")->result();
		$data = array(
			'userfrom_id' => $getEachChatCount[0]->userfrom_id,
			'userto_id' => $getEachChatCount[0]->userto_id,
			'count' => $getEachChatCount[0]->msgcount,
		);
		echo json_encode($data);
	}

	function showmessage_list() {
		$userdId = $_SESSION['afrebay']['userId'];
		$usert_id = $this->input->post('usert_id');
		$post_id = $this->input->post('post_id');
		$get_data = $this->Users_model->getChat();
		$updatastatus = $this->db->query("UPDATE chat SET status = '1' WHERE (userfrom_id ='".$usert_id."' AND userto_id ='".$userdId."') OR (userto_id ='".$usert_id."' AND userfrom_id ='".$userdId."')");
		$get_chatuser = $this->Crud_model->get_single('users', "userId='" . $_POST['usert_id'] . "'");
		if (!empty($get_chatuser->firstname)) {
			$name = $get_chatuser->firstname . ' ' . $get_chatuser->lastname;
		} else {
			$name = $get_chatuser->companyname;
		}
		if (@$get_chatuser->profilePic && file_exists('uploads/users/' . @$get_chatuser->profilePic)) {
			$userpic = '<img src="' . base_url('uploads/users/' . @$get_chatuser->profilePic) . '" alt="" />';
		} else {
			$userpic = '<img src="' . base_url('uploads/users/user.png') . '" alt="" />';
		}
		$html_data = '<div class="contact-profile">' . $userpic . '<p>' . ucfirst($name) . '</p><div class="social-media"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a><a href="javascript:void(0);" onclick="openVideoCallWindow('.$usert_id.');"><i class="fa fa-video-camera" aria-hidden="true"></i></a><a href="#"><i class="fa fa-cog" aria-hidden="true"></i></a></div></div><div class="messages"><ul>';
		if (!empty($get_data)) {
			foreach ($get_data as $key) {
				if (@$key->profilePic && file_exists('uploads/users/' . @$key->profilePic) && $key->postjob_id == $_POST['post_id']) {
					$from_pic = '<img src="' . base_url('uploads/users/' . @$key->profilePic) . '" alt="" />';
				} else {
					$from_pic = '<img src="' . base_url('uploads/users/user.png') . '" alt="" />';
				}
				if (@$key->profilePic && file_exists('uploads/users/' . @$key->profilePic) && $key->postjob_id == $_POST['post_id']) {
					$to_pic = '<img src="' . base_url('uploads/users/' . @$key->profilePic) . '" alt="" />';
				} else {
					$to_pic = '<img src="' . base_url('uploads/users/user.png') . '" alt="" />';
				}
				if ($key->userfrom_id == $_SESSION['afrebay']['userId'] && $key->userto_id == $_POST['usert_id'] && $key->postjob_id == $_POST['post_id']) {
					$sent = '<li class="sent">' . $from_pic . '<p>' . $key->message . '</p><div style="font-size: 10px;">'.$key->created_date.'</li>';
				} else {
					$sent = '';
				}
				if ($key->userto_id == $_SESSION['afrebay']['userId'] && $key->userfrom_id == $_POST['usert_id'] && $key->postjob_id == $_POST['post_id']) {
					$reply = '<li class="replies">' . $to_pic . '<p>' . $key->message . '</p><div style="font-size: 10px;">'.$key->created_date.'</li>';
				} else {
					$reply = '';
				}
				$html_data .= $sent . $reply;
			}
		} else {
			$html_data .= '<li class="sent"><center>No Messages</center></li>';
		}
		echo json_encode($html_data);
		exit;
	}

	function showmessage_listS() {
		$userfrom_id = $this->input->post('userfromid');
		$user_id = $this->input->post('usertoid');
		$post_id = $this->input->post('postid');
		$get_data = $this->Users_model->getCurrentChat($userfrom_id, $user_id, $post_id);
		$updatastatus = $this->db->query("UPDATE chat SET status = '1' WHERE (userfrom_id ='".$userfrom_id."' AND userto_id ='".$user_id."') OR (userto_id ='".$userfrom_id."' AND userfrom_id ='".$user_id."')");
		$get_chatuser = $this->Crud_model->get_single('users', "userId='" . $user_id . "'");
		if (!empty($get_chatuser->firstname)) {
			$name = $get_chatuser->firstname . ' ' . $get_chatuser->lastname;
		} else {
			$name = $get_chatuser->companyname;
		}
		if (@$get_chatuser->profilePic && file_exists('uploads/users/' . @$get_chatuser->profilePic)) {
			$userpic = '<img src="' . base_url('uploads/users/' . @$get_chatuser->profilePic) . '" alt="" />';
		} else {
			$userpic = '<img src="' . base_url('uploads/users/user.png') . '" alt="" />';
		}
		$html_data = '<div class="contact-profile">' . $userpic . '<p>' . ucfirst($name) . '</p><div class="social-media"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a><a href="javascript:void(0);" onclick="openVideoCallWindow('.$user_id.');"><i class="fa fa-video-camera" aria-hidden="true"></i></a><a href="#"><i class="fa fa-cog" aria-hidden="true"></i></a></div></div><div class="messages"><ul>';
		if (!empty($get_data)) {
			foreach ($get_data as $key) {
				if (@$key->profilePic && file_exists('uploads/users/' . @$key->profilePic) && $key->postjob_id == $post_id) {
					$from_pic = '<img src="' . base_url('uploads/users/' . @$key->profilePic) . '" alt="" />';
				} else {
					$from_pic = '<img src="' . base_url('uploads/users/user.png') . '" alt="" />';
				}
				if (@$key->profilePic && file_exists('uploads/users/' . @$key->profilePic) && $key->postjob_id == $post_id) {
					$to_pic = '<img src="' . base_url('uploads/users/' . @$key->profilePic) . '" alt="" />';
				} else {
					$to_pic = '<img src="' . base_url('uploads/users/user.png') . '" alt="" />';
				}
				if ($key->userfrom_id == $_SESSION['afrebay']['userId'] && $key->userto_id == $user_id && $key->postjob_id == $post_id) {
					$sent = '<li class="sent">' . $from_pic . '<p>' . $key->message . '</p><div style="font-size: 10px;">'.$key->created_date.'</li>';
				} else {
					$sent = '';
				}
				if ($key->userto_id == $_SESSION['afrebay']['userId'] && $key->userfrom_id == $user_id && $key->postjob_id == $post_id) {
					$reply = '<li class="replies">' . $to_pic . '<p>' . $key->message . '</p><div style="font-size: 10px;">'.$key->created_date.'</li>';
				} else {
					$reply = '';
				}
				$html_data .= $sent . $reply;
			}
		} else {
			$html_data .= '<li class="sent"><center>No Messages</center></li>';
		}
		echo json_encode($html_data);
		exit;
	}

	function sent_message() {
		$userfromid = $this->input->post('userfromid');
		$usertoid = $this->input->post('usertoid');
		$updatastatus = $this->db->query("UPDATE chat SET status = '1' WHERE (userfrom_id ='".$usertoid."' AND userto_id ='".$userfromid."') OR (userto_id ='".$usertoid."' AND userfrom_id ='".$userfromid."')");
		if (!empty($this->input->post('usertoid'))) {
			$data = array(
				'userfrom_id' => $userfromid,
				'userto_id' => $usertoid,
				'postjob_id' => $this->input->post('postid'),
				'message' => $this->input->post('message'),
				'created_date' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('chat', $data);
			$lastid = $this->db->insert_id();
			$con = "id='" . $lastid . "'";
			$getdata = $this->Users_model->getmessage($con);
			if (@$getdata->profilePic && file_exists('uploads/users/' . @$getdata->profilePic)) {
				$from_pic = '<img src="' . base_url('uploads/users/' . @$getdata->profilePic) . '" alt="" />';
			} else {
				$from_pic = '<img src="' . base_url('uploads/users/user.png') . '" alt="" />';
			}
			$data = array(
				'result' => 1,
				'userpic' => $from_pic,
			);
			echo json_encode($data);
			exit;
		}
	}
	///////////////////////////////////// end chat/////////////////////////////////
	function video_call() {
		$this->load->view('header');
		$this->load->view('user_dashboard/video_call');
		$this->load->view('footer');
	}

	public function save_event() {
		// $starttime=$_POST['starthours'].':'.$_POST['startminute'].' '.$_POST['starttype'];
		// $endtime=$_POST['endhours'].':'.$_POST['endminute'].' '.$_POST['endtype'];
		$data = array(
			'user_id' => $_SESSION['afrebay']['userId'],
			'event_name' => $_POST['event_name'],
			'event_date' => date('Y-m-d', strtotime($_POST['event_date'])),
			'start_time' => date('H:i', strtotime($_POST['start_time'])),
			'end_time' => date('H:i', strtotime($_POST['end_time'])),
			'description' => $_POST['description'],
			'event_color' => $_POST['event_color'],
			'event_icon' => $_POST['event_icon'],
			'created_date' => date('Y-m-d H:i:s'),
		);
		$this->Crud_model->SaveData('appointment_scheduling', $data);
		$this->session->set_flashdata('message', 'Appointment Created Successfully !');
		redirect(base_url('calender'));
	}

	public function get_events() {
		$events = $this->db->query("select * from appointment_scheduling where user_id='" . $_SESSION['afrebay']['userId'] . "'")->result();
		$data_events = array();

		foreach ($events as $r) {
			$data_events[] = array(
				"id" => $r->id,
				"title" => $r->event_name,
				"start" => date('Y-m-d', strtotime($r->event_date)),
				"description" => $r->description,
				"className" => $r->event_color,
				"icon" => $r->event_icon,
			);
		}
		echo json_encode($data_events);
		exit();
	}

	function change_password() {
		$this->load->view('header');
		$this->load->view('user_dashboard/change_password');
		$this->load->view('footer');
	}

	function update_password() {
		$get_user = $this->Crud_model->get_single('users', "userId='" . $_SESSION['afrebay']['userId'] . "'");
		if ($get_user->password == base64_encode($_POST['cur_password'])) {
			$data = array(
				'password' => base64_encode($_POST['new_password']),
			);
			$this->Crud_model->SaveData('users', $data, "userId='" . $_SESSION['afrebay']['userId'] . "'");
			$this->session->set_flashdata('message', 'Password Reset Successfully !');
			echo "1";
		} else {
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
			echo "0";
		}
	}

	////////////////////////////////// start rating /////////////////////////////////////
	function save_employer_rating() {
		if (!empty($this->input->post('rating'))) {
			$data = array(
				'employer_id' => $_SESSION['afrebay']['userId'],
				'worker_id' => $_POST['user_id'],
				'rating' => $this->input->post('rating', TRUE),
				'subject' => $this->input->post('subject', TRUE),
				'review' => $this->input->post('review', TRUE),
				'created_date' => date('Y-m-d H:i:s'),
			);
			$this->Crud_model->SaveData('employer_rating', $data);
			$this->session->set_flashdata('message', 'Rating successfully');
		} else {
			$this->session->set_flashdata('message', 'Something went wrong. Please try again later!');
		}
		redirect(base_url('worker-detail/' . base64_encode($_POST['user_id'])));
	}
	////////////////////////////////// end rating /////////////////////////////////////

	//////////////////////////////// start education ///////////////////////////
	function education_list()
	{
		$data['education_list'] = $this->Crud_model->GetData('user_education', '', "user_id='".$_SESSION['afrebay']['userId']."' order by id DESC");
		$this->load->view('header');
		$this->load->view('user_dashboard/education/list', $data);
		$this->load->view('footer');
	}
	function add_education()
	{
		$get_education = $this->Crud_model->GetData('user_education', 'id,education', "");
		$get_passing = $this->Crud_model->GetData('user_education', 'id,passing_of_year', "");
		$get_college = $this->Crud_model->GetData('user_education', 'id,college_name', "");
		$get_department = $this->Crud_model->GetData('user_education', 'id,department', "");
		$data = array(
			'button' => 'submit',
			'action' => base_url('user/Dashboard/save_education'),
			'education' => set_value('education'),
			'passing_of_year' => set_value('passing_of_year'),
			'college_name' => set_value('college_name'),
			'department' => set_value('department'),
			'description' => set_value('description'),

			'id' => set_value('id'),
			'get_education' => $get_education,
			'get_passing' => $get_passing,
			'get_college' => $get_college,
			'get_department' => $get_department,
		);

		$this->load->view('header');
		$this->load->view('user_dashboard/education/form', $data);
		$this->load->view('footer');
	}

	public function save_education() {
		$data = array(
			'user_id' => $_SESSION['afrebay']['userId'],
			'education' => $this->input->post('education', TRUE),
			'passing_of_year' => $this->input->post('passing_of_year', TRUE),
			'college_name' => $this->input->post('college_name', TRUE),
			'department' => $this->input->post('department', TRUE),
			'description' => $this->input->post('description', TRUE),

			'created_date' => date('Y-m-d H:i:s'),
		);
		$this->Crud_model->SaveData('user_education', $data);
		$this->session->set_flashdata('message', 'Education Created Successfully !');
		redirect(base_url('education-list'));
	}

	public function update_education($id) {
		$education_id = base64_decode($id);
		$update_education = $this->Crud_model->get_single('user_education', "id='" . $education_id . "'");
		$get_education = $this->Crud_model->GetData('user_education', 'id,education', "");
		$get_passing = $this->Crud_model->GetData('user_education', 'id,passing_of_year', "");
		$get_college = $this->Crud_model->GetData('user_education', 'id,college_name', "");
		$get_department = $this->Crud_model->GetData('user_education', 'id,department', "");
		$data = array(
			'button' => 'update',
			'action' => base_url('user/Dashboard/edit_education'),
			'education' => $update_education->education,
			'passing_of_year' => $update_education->passing_of_year,
			'college_name' => $update_education->college_name,
			'department' => $update_education->department,
			'description' => $update_education->description,
			'id' => $update_education->id,
			'get_education' => $get_education,
			'get_passing' => $get_passing,
			'get_college' => $get_college,
			'get_department' => $get_department,
		);

		$this->load->view('header');
		$this->load->view('user_dashboard/education/form', $data);
		$this->load->view('footer');
	}


	public function edit_education() {
		$id = $_POST['id'];
		$data = array(
			'education' => $this->input->post('education', TRUE),
			'passing_of_year' => $this->input->post('passing_of_year', TRUE),
			'college_name' => $this->input->post('college_name', TRUE),
			'department' => $this->input->post('department', TRUE),
			'description' => $this->input->post('description', TRUE),

		);
		$this->Crud_model->SaveData('user_education', $data, "id='" . $id . "'");
		$this->session->set_flashdata('message', 'Education Updated Successfully !');
		redirect(base_url('education-list'));
	}

	function delete_education(){
		$id = $this->input->post('id');
		$this->Crud_model->DeleteData('user_education', "id='" . $id . "'");
		$this->session->set_flashdata('message', 'Education Deleted successfully !');
		echo '1';
		//redirect(base_url('education-list'));
	}

	function workexperience_list() {
		$data['workexperience_list'] = $this->Crud_model->GetData('user_workexperience', '', "user_id='".$_SESSION['afrebay']['userId']."' order by id DESC");
		$this->load->view('header');
		$this->load->view('user_dashboard/work_experience/list', $data);
		$this->load->view('footer');
	}

	function add_workexperience() {
		$get_designation = $this->Crud_model->GetData('user_workexperience', 'id,designation', "");
		$get_companyname = $this->Crud_model->GetData('user_workexperience', 'id,company_name', "");
		$get_duration = $this->Crud_model->GetData('user_workexperience', 'id,duration', "");

		$data = array(
			'button' => 'submit',
			'action' => base_url('user/Dashboard/save_workexperience'),
			'designation' => set_value('designation'),
			'company_name' => set_value('company_name'),
			//'duration' => set_value('duration'),
			'from_date' => set_value('from_date'),
			'to_date' => set_value('to_date'),
			'description' => set_value('description'),
			'id' => set_value('id'),
			'get_designation' => $get_designation,
			'get_companyname' => $get_companyname,
			'get_duration' => $get_duration,

		);

		$this->load->view('header');
		$this->load->view('user_dashboard/work_experience/form', $data);
		$this->load->view('footer');
	}

	public function save_workexperience() {
		$data = array(
			'user_id' => $_SESSION['afrebay']['userId'],
			'designation' => $this->input->post('designation', TRUE),
			'company_name' => $this->input->post('company_name', TRUE),
			//'duration' => $this->input->post('duration', TRUE),
			'from_date' => $this->input->post('from_date', TRUE),
			'to_date' => $this->input->post('to_date', TRUE),
			'description' => $this->input->post('description', TRUE),
			'created_date' => date('Y-m-d H:i:s'),
		);
		$this->Crud_model->SaveData('user_workexperience', $data);
		$this->session->set_flashdata('message', 'Work Experience Created Successfully !');
		redirect(base_url('workexperience-list'));
	}

	public function update_workexperience($id) {
		$work_id = base64_decode($id);
		$update_data = $this->Crud_model->get_single('user_workexperience', "id='" . $work_id . "'");
		$get_designation = $this->Crud_model->GetData('user_workexperience', 'id,designation', "");
		$get_companyname = $this->Crud_model->GetData('user_workexperience', 'id,company_name', "");
		$get_duration = $this->Crud_model->GetData('user_workexperience', 'id,duration', "");
		$data = array(
			'button' => 'update',
			'action' => base_url('user/Dashboard/edit_workexperience'),
			'designation' => $update_data->designation,
			'company_name' => $update_data->company_name,
			//'duration' => $update_data->duration,
			'from_date' => $update_data->from_date,
			'to_date' => $update_data->to_date,
			'description' => $update_data->description,
			'id' => $update_data->id,
			'get_designation' => $get_designation,
			'get_companyname' => $get_companyname,
			'get_duration' => $get_duration,

		);
		$this->load->view('header');
		$this->load->view('user_dashboard/work_experience/form', $data);
		$this->load->view('footer');
	}


	public function edit_workexperience() {
		$id = $_POST['id'];
		$data = array(
			'designation' => $this->input->post('designation', TRUE),
			'company_name' => $this->input->post('company_name', TRUE),
			//'duration' => $this->input->post('duration', TRUE),
			'from_date' => $this->input->post('from_date', TRUE),
			'to_date' => $this->input->post('to_date', TRUE),
			'description' => $this->input->post('description', TRUE),
		);
		$this->Crud_model->SaveData('user_workexperience', $data, "id='" . $id . "'");
		$this->session->set_flashdata('message', 'Work experience updated successfully !');
		redirect(base_url('workexperience-list'));
	}

	function delete_workexperience() {
		$id = $this->input->post('id');
		$this->Crud_model->DeleteData('user_workexperience', "id='" . $id . "'");
		$this->session->set_flashdata('message', 'Work experience deleted successfully !');
		echo "1";
		// redirect(base_url('workexperience-list'));
	}

	///////////////// end work experience //////////////////////////

	///////////////// User Subscription //////////////////////////
	function userSubscription(){
		$paymentDate = date('Y-m-d H:i:s');
		$n=24;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		;
		$data = array(
			'employer_id' => $this->input->post('user_id'),
			'subscription_id' => $this->input->post('sub_id'),
			'name_of_card' => $this->input->post('sub_name'),
			'email' => $this->input->post('user_email'),
			'amount' => $this->input->post('sub_price'),
			'duration' => $this->input->post('sub_duration'),
			'transaction_id' => "sub_".$randomString,
			'payment_date' => $paymentDate,
			'created_date' => $paymentDate,
			'duration' => $this->input->post('sub_duration'),
			'payment_status' => 'paid',
			'expiry_date' => date("Y-m-d", strtotime('+'.$this->input->post('sub_duration').'days'))
		);
		//print_r($data); die();
		$this->Crud_model->SaveData('employer_subscription', $data);
		$insert_id = $this->db->insert_id();
		if(!empty($insert_id)) {
			echo '1';
		} else {
			echo '2';
		}
	}

	function cancelSubscription() {
		$id = $this->input->post('id');
		$sub_id = $this->input->post('sub_id');
		$amount = $this->input->post('amount');
		if($amount < '1') {
			$subStatus = $this->db->query("UPDATE employer_subscription SET status = '2' WHERE `id` ='".$id."'");
			if($subStatus) {
				echo '1';
			} else {
				echo '2';
			}
		} else {
			require 'vendor/autoload.php';
			require_once APPPATH."third_party/stripe/init.php";
			$stripe = new \Stripe\StripeClient('sk_test_835fqzvcLuirPvH0KqHeQz9K');
			$cnclsubData = $stripe->subscriptions->cancel("$sub_id",[]);
			if($cnclsubData['status'] == 'canceled') {
				$subStatus = $this->db->query("UPDATE employer_subscription SET status = '2' WHERE `id` ='".$id."'");
				if($subStatus) {
					echo '1';
				} else {
					echo '2';
				}
			}
		}
	}

	function checkSubscriptionForUser(){
		//echo "SELECT * FROM employer_subscription WHERE status = '1'"; echo "<br>";
		$getAllSubscription = $this->db->query("SELECT * FROM employer_subscription WHERE status = '1'")-> result_array();
		foreach ($getAllSubscription as $value) {
			$sub_id = $value['transaction_id'];
			$now_date = date('Y-m-d');
			$expiry_date = date('Y-m-d', strtotime($value['expiry_date']));
			$amount = $value['amount'];

			if($expire_date > $now_date) {
				if($amount < '1') {
					$subStatus = $this->db->query("UPDATE employer_subscription SET status = '3' where status = '1'");
					if($subStatus) {
						echo '1';
					} else {
						echo '2';
					}
				} else {
					require 'vendor/autoload.php';
					require_once APPPATH."third_party/stripe/init.php";
					$stripe = new \Stripe\StripeClient('sk_test_835fqzvcLuirPvH0KqHeQz9K');
					$cnclsubData = $stripe->subscriptions->cancel("$sub_id",[]);
					if($cnclsubData['status'] == 'canceled') {
						$subStatus = $this->db->query("UPDATE employer_subscription SET status = '3' where status = '1'");
						if($subStatus) {
							echo '1';
						} else {
							echo '2';
						}
					}
				}
			}
		}
	}

	function add_product() {
		//print_r($this->input->post()); die;
		if(!empty($this->input->post())){
			$data = array(
				'user_id' => $_SESSION['afrebay']['userId'],
				'prod_name' => $this->input->post('prod_name'),
				'prod_description' => $this->input->post('prod_description'),
				'created_date' => date("Y-m-d H:i:s"),
			);
			$this->Crud_model->SaveData('user_product', $data);
			$insert_id = $this->db->insert_id();
			if(!empty($insert_id)) {
				if ($_FILES['prod_image']['name'] != '') {
					$cpt = count($_FILES['prod_image']['name']);
					for($i=0; $i<$cpt; $i++) {
						$_POST['prod_image'] = rand(0000, 9999) . "_" . $_FILES['prod_image']['name'][$i];
						$config2['image_library'] = 'gd2';
						$config2['source_image'] =  $_FILES['prod_image']['tmp_name'][$i];
						$config2['new_image'] =   getcwd() . '/uploads/products/'.$_POST['prod_image'];
						$config2['upload_path'] =  getcwd() . '/uploads/products/';
						$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
						$config2['maintain_ratio'] = FALSE;
						$this->image_lib->initialize($config2);
						//$this->load->library('image_lib', $config2);
						if (!$this->image_lib->resize()) {
							echo ('<pre>');
							echo ($this->image_lib->display_errors());
							exit;
						} else {
							$image  = $_POST['prod_image'];
							@unlink('uploads/products/' . $_POST['old_image']);
						}
						$data_image = array(
							'prod_id' => $insert_id,
							'prod_image' => $image,
							'created_date' => date("Y-m-d H:i:s"),
						);
						$this->Crud_model->SaveData('user_product_image', $data_image);
						$this->session->set_flashdata('message', 'Product Created Successfully !');
					}
				}
			}
			redirect(base_url('product'));
		}

		$this->load->view('header');
		$this->load->view('user_dashboard/product/form', $data);
		$this->load->view('footer');
	}

	public function update_product($id) {
		$product_id = base64_decode($id);
		$update_product = $this->Crud_model->get_single('user_product', "id='" . $product_id . "'");
		$data = array(
			'button' => 'update',
			'action' => base_url('user/Dashboard/edit_product'),
			'product' => $update_product->prod_name,
			'description' => $update_product->prod_description,
			'id' => $update_product->id,
		);
		$this->load->view('header');
		$this->load->view('user_dashboard/product/form', $data);
		$this->load->view('footer');
	}

	public function edit_product() {
		$id = $_POST['id'];
		$data = array(
			'prod_name' => $this->input->post('prod_name', TRUE),
			'prod_description' => $this->input->post('prod_description', TRUE),
		);
		$updateQuery = $this->Crud_model->SaveData('user_product', $data, "id='".$id."'");
		//print_r($_FILES['prod_image']['name'][0]); die;
		if (!empty($_FILES['prod_image']['name'][0])) {
			$cpt = count($_FILES['prod_image']['name']);
			for($i=0; $i<$cpt; $i++) {
				$_POST['prod_image'] = rand(0000, 9999) . "_" . $_FILES['prod_image']['name'][$i];
				$config2['image_library'] = 'gd2';
				$config2['source_image'] =  $_FILES['prod_image']['tmp_name'][$i];
				$config2['new_image'] =   getcwd() . '/uploads/products/'.$_POST['prod_image'];
				$config2['upload_path'] =  getcwd() . '/uploads/products/';
				$config2['allowed_types'] = 'JPG|PNG|JPEG|jpg|png|jpeg';
				$config2['maintain_ratio'] = FALSE;
				$this->image_lib->initialize($config2);
				//$this->load->library('image_lib', $config2);
				if (!$this->image_lib->resize()) {
					echo ('<pre>');
					echo ($this->image_lib->display_errors());
					exit;
				} else {
					$image  = $_POST['prod_image'];
					@unlink('uploads/products/' . $_POST['old_image']);
				}
				$data_image = array(
					'prod_id' => $_POST['id'],
					'prod_image' => $image,
					'created_date' => date("Y-m-d H:i:s"),
				);
				$this->Crud_model->SaveData('user_product_image', $data_image);
			}
		}
		$this->session->set_flashdata('message', 'Product Updated Successfully !');
		redirect(base_url('product'));
	}

	function delete_product() {
		$p_id = $this->input->post('id');
		$delete_prod = $this->db->query("UPDATE user_product SET is_delete = '2' WHERE id = '$p_id'");
		if($delete_prod > 0){
			echo '1';
		} else {
			echo '2';
		}

	}

	function delete_job() {
		$p_id = $this->input->post('id');
		$delete_prod = $this->db->query("DELETE FROM postjob WHERE id = '$p_id'");
		if($delete_prod > 0){
			echo '1';
		} else {
			echo '2';
		}
	}

	function delete_product_image() {
		$p_id = $this->input->post('id');
		$delete_prod = $this->db->query("DELETE FROM user_product_image WHERE id = '$p_id'");
	}
	///////////////// End User Product //////////////////////////

	public function create_availability() {
        /*$start_date = explode(",", $_POST['start_date']);
		$from_time = explode(",", $_POST['from_time']);
		$end_date = explode(",", $_POST['end_date']);
		$to_time = explode(",", $_POST['to_time']);
		$result = count($start_date);
		for($i=0; $i<$result; $i++) {
			$data = array(
				'user_id' => $user_id,
				'start_date' => $start_date[$i],
				'from_time' => $from_time[$i],
				'end_date' => $end_date[$i],
				'to_time' => $to_time[$i],
			);
			$this->Crud_model->SaveData('user_availability', $data);
		}*/
		$user_id = $_POST['user_id'];
        $days = [
            'weekDay1' => ['day'=> $_POST['weekDay1'], 'fromtime' => $_POST['fromtime1'], 'totime' => $_POST['totime1']],
            'weekDay2' => ['day'=> $_POST['weekDay2'], 'fromtime' => $_POST['fromtime2'], 'totime' => $_POST['totime2']],
            'weekDay3' => ['day'=> $_POST['weekDay3'], 'fromtime' => $_POST['fromtime3'], 'totime' => $_POST['totime3']],
            'weekDay4' => ['day'=> $_POST['weekDay4'], 'fromtime' => $_POST['fromtime4'], 'totime' => $_POST['totime4']],
            'weekDay5' => ['day'=> $_POST['weekDay5'], 'fromtime' => $_POST['fromtime5'], 'totime' => $_POST['totime5']],
            'weekDay6' => ['day'=> $_POST['weekDay6'], 'fromtime' => $_POST['fromtime6'], 'totime' => $_POST['totime6']],
            'weekDay7' => ['day'=> $_POST['weekDay7'], 'fromtime' => $_POST['fromtime7'], 'totime' => $_POST['totime7']],
        ];

        $data = [
            'start_date' => date('Y-m-d', strtotime($_POST['starting_date'])),
            'repeat_month' => $_POST['repeat_month'],
            'schedule_status' => '1',
            'user_id' => $user_id,
        ];

        foreach ($days as $key => $times) {
            if(!empty($times['day'])) {
                $data[$key] = $times['day'];
            } else {
                $data[$key] = "";
            }

            if (isset($times['fromtime']) && is_array($times['fromtime'])) {
                $data["{$key}_fromtime"] = implode(',', $times['fromtime']);
            } else {
                $data["{$key}_fromtime"] = '';
            }
            if (isset($times['totime']) && is_array($times['totime'])) {
                $data["{$key}_totime"] = implode(',', $times['totime']);
            } else {
                $data["{$key}_totime"] = '';
            }
        }
        $getData = $this->db->query("SELECT * FROM user_availability WHERE user_id = '".$user_id."' AND repeat_month IN (0,1)")->row();
        if(!empty($getData)) {
            $this->Crud_model->SaveData('user_availability', $data, "user_id='".$user_id."' AND repeat_month IN (0,1)");
        } else {
            $this->Crud_model->SaveData('user_availability', $data);
        }
		echo "1";
    }
    public function createdatewiseavailability() {
        $user_id = $_POST['user_id'];

        $specificdate = explode(',', $_POST['specific_date'][0]);
        $days = [];
        foreach ($specificdate as $key => $value) {
            $days[$key] = [
                'weekDay1' => ['date'=> $value, 'day'=> 'Sunday', 'fromtime' => $_POST['fromtimedate'], 'totime' => $_POST['totimedate']],
                'weekDay2' => ['date'=> $value, 'day'=> 'Monday', 'fromtime' => $_POST['fromtimedate'], 'totime' => $_POST['totimedate']],
                'weekDay3' => ['date'=> $value, 'day'=> 'Tuesday', 'fromtime' => $_POST['fromtimedate'], 'totime' => $_POST['totimedate']],
                'weekDay4' => ['date'=> $value, 'day'=> 'Wednesday', 'fromtime' => $_POST['fromtimedate'], 'totime' => $_POST['totimedate']],
                'weekDay5' => ['date'=> $value, 'day'=> 'Thursday', 'fromtime' => $_POST['fromtimedate'], 'totime' => $_POST['totimedate']],
                'weekDay6' => ['date'=> $value, 'day'=> 'Friday', 'fromtime' => $_POST['fromtimedate'], 'totime' => $_POST['totimedate']],
                'weekDay7' => ['date'=> $value, 'day'=> 'Saturday', 'fromtime' => $_POST['fromtimedate'], 'totime' => $_POST['totimedate']],
            ];
            $data = [
                'start_date' => $value,
                'repeat_month' => '2' ,
                'schedule_status' => '1',
                'user_id' => $user_id,
            ];

            foreach ($days[$key] as $key1 => $times) {
                if(!empty($times['day'])) {
                    $data[$key1] = $times['day'];
                } else {
                    $data[$key1] = "";
                }
                if (isset($times['fromtime']) && is_array($times['fromtime'])) {
                    $data["{$key1}_fromtime"] = implode(',', $times['fromtime']);
                } else {
                    $data["{$key1}_fromtime"] = '';
                }
                if (isset($times['totime']) && is_array($times['totime'])) {
                    $data["{$key1}_totime"] = implode(',', $times['totime']);
                } else {
                    $data["{$key1}_totime"] = '';
                }
            }
            $this->Crud_model->SaveData('user_availability', $data);
        }
        echo "1";
    }

	public function bookSlotforuser() {
		//print_r($this->input->post()); die();
		$employee_id = $this->input->post('employee_id');
		$employer_id = $this->input->post('employer_id');
		$available_id = $this->input->post('available_id');
		$data = array(
			'employee_id' => $employee_id,
			'employer_id' => $employer_id,
			'available_id' => $available_id
		);
		$this->Crud_model->SaveData('user_booking', $data);
		echo "1";
	}

	public function getUserAvailability() {
		//print_r($this->input->post()); die();
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$user_id = $this->input->post('userID');
		//echo "SELECT user_availability.start_date, user_availability.from_time, user_availability.end_date, user_availability.to_time, user_booking.employee_id, user_booking.employer_id, user_booking.available_id, user_booking.bookingTime FROM user_booking RIGHT JOIN user_availability ON user_availability.id = user_booking.available_id where user_availability.user_id = '".$user_id."' AND user_availability.start_date = '".$start_date."' AND user_availability.end_date = '".$end_date."'"; die();
		$getTime = $this->db->query("SELECT user_availability.id, user_availability.start_date, user_availability.from_time, user_availability.end_date, user_availability.to_time, user_booking.employee_id, user_booking.employer_id, user_booking.available_id, user_booking.bookingTime FROM user_booking RIGHT JOIN user_availability ON user_availability.id = user_booking.available_id where user_availability.user_id = '".$user_id."' AND user_availability.start_date = '".$start_date."' AND user_availability.end_date = '".$end_date."'")->result_array();
		echo json_encode($getTime);
	}

	/*public function addBookingTimeData() {
		$start_date = $this->input->post('startDate');
		$employeeID = $this->input->post('employeeID');
		$employerID = $this->input->post('employerID');
		$bookTime = implode(',', $this->input->post('bookTime'));
		$book_time = explode(',', $bookTime);
		$getUserAvailabilityid = $this->db->query("SELECT * FROM user_availability WHERE start_date = '".$start_date."' AND user_id = '".$employeeID."'")->result_array();
		$getuser_booking = $this->db->query("SELECT * FROM user_booking WHERE available_id = '".$getUserAvailabilityid[0]['id']."'")->result_array();
		$booktime = count($book_time);
		if(!empty($getuser_booking)) {
			$this->Crud_model->DeleteData('user_booking', "available_id='".$getUserAvailabilityid[0]['id']."'");
			for($i=0; $i<$booktime; $i++) {
				$data = array(
					'employee_id' => $employeeID,
					'employer_id' => $employerID,
					'available_id' => $getUserAvailabilityid[0]['id'],
					'bookingTime' => $book_time[$i],
				);
				$this->Crud_model->SaveData('user_booking', $data);
			}
		} else {
			for($i=0; $i<$booktime; $i++) {
				$data = array(
					'employee_id' => $employeeID,
					'employer_id' => $employerID,
					'available_id' => $getUserAvailabilityid[0]['id'],
					'bookingTime' => $book_time[$i],
				);
				$this->Crud_model->SaveData('user_booking', $data);
			}
		}
		echo "1";
	}*/

	public function addBookingTimeData() {
		//echo "<pre>"; print_r($_POST); die();
		$avail_id = $this->input->post('avail_id');
		$start_date = $this->input->post('startDate');
		$employeeID = $this->input->post('employeeID');
		$employerID = $this->input->post('employerID');
		$book_time = $this->input->post('bookTime');
		$getuser_booking = $this->db->query("SELECT * FROM user_booking WHERE available_id = '".$avail_id."' AND employee_id = '".$employeeID."' AND employer_id = '".$employerID."'")->result_array();
		if(!empty($getuser_booking)) {
			//$this->Crud_model->DeleteData('user_booking', "available_id='".$avail_id."'");
			$data = array(
				'employee_id' => $employeeID,
				'employer_id' => $employerID,
				'available_id' => $avail_id,
				'bookingTime' => $book_time,
			);
			$this->Crud_model->SaveData('user_booking', $data, "id='".$getuser_booking[0]['id']."'");
		} else {
			$data = array(
				'employee_id' => $employeeID,
				'employer_id' => $employerID,
				'available_id' => $avail_id,
				'bookingTime' => $book_time,
			);
			$this->Crud_model->SaveData('user_booking', $data);
		}
		echo "1";
	}

    public function get_access_token() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://zoom.us/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=account_credentials&account_id=73H-Ll9DSseDWF6dgUeT9A',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic V1pteDVESzVSNHloOXhkQTRiN190QTp1OXBabnFJcUJHNDdOaE5yS3k4M2h3V1I3QnkybjRvMg==',
                'Cookie: __cf_bm=j8d61x5QOrLIXdL1IovzLtyXIDmhn9CSZhJLPEzBUc4-1723196550-1.0.1.1-tBe3gQgo8c.JvYn2UVqs6hszZkGUlR6MX5M_MKK..B02y8K7Tu6MDzl.vu4mM.zJXL_22X.zMNvPfHvvoFVsgw; _zm_chtaid=592; _zm_ctaid=vlK3KdZqThenJprgxfHMRQ.1723189809081.03d77d1c9e5e5b7e047f8eb33209f5d7; _zm_mtk_guid=c133062e5fbc412eace34da570f36f5b; _zm_page_auth=aw1_c_DISK24aaTaWD80m2aQmW0Q; _zm_ssid=us04_c_zAGVzePSRJG3ZCkTQyKfiA; _zm_visitor_guid=c133062e5fbc412eace34da570f36f5b; cred=C1A7EA88374F5E3DEE6F4098789ACC4C'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $this->db->query("UPDATE setting SET zoom_token = '$data->access_token' WHERE id = '1'");
        //return $data->access_token;
        $this->paymentforslotbook();
    }

	public function paymentforslotbook() {
        $accessToken = $this->db->query("SELECT zoom_token FROM setting WHERE id = '1'")->row();
        //echo "<pre>"; print_r($accessToken->zoom_token); die();
        $avail_id = $this->input->post('avail_id');
        $employeeID = $this->input->post('employeeID');
        $employerID = $this->input->post('employerID');
        $rate = $this->input->post('rate');
        $getBookinID = $this->db->query("SELECT * FROM user_booking WHERE available_id = '".$avail_id."' AND employee_id = '".$employeeID."' AND employer_id = '".$employerID."'")->result_array();
        $length = 24;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        $txn = "txn_".$randomString;
        $data = array(
            'booking_id'=> $getBookinID[0]['id'],
            'rate'=> $rate,
            'txn_id'=> $txn,
        );
        $this->Crud_model->SaveData('user_booking_txn', $data);
        // create miting link
        $getavailDate = $this->db->query("SELECT * FROM user_availability WHERE id = '" . $avail_id . "'")->row();
        $getbiduser = $this->db->query("SELECT * FROM users WHERE userId = '" . $employeeID . "'")->row();
        $getbidemail = $getbiduser->email;
        $getbidname = $getbiduser->firstname. ' '.$getbiduser->lastname;
        $getpostuser = $this->db->query("SELECT * FROM users WHERE userId = '" . $employerID . "'")->row();
        $getpostemail = $getpostuser->email;
        $getpostname = $getpostuser->companyname;
        $bookingTime = $getBookinID[0]['bookingTime'];
        $bt = explode(",", $bookingTime);

        $meetingLink = array();
        $meetingPass = array();
        for ($i=0; $i<count($bt); $i++){
            $postData = [
                "topic" => 'Meeting Link1',
                "type" => 2,
                "start_time" => $getavailDate->start_date.'T'.$bt[$i].':00Z',
                "duration" => 40,
                "settings" => [
                    "waiting_room" => false,
                    "host_video" => true,
                    "participant_video" => true,
                    "join_before_host" => true,
                    "mute_upon_entry" => true,
                    "watermark" => true,
                    "audio" => "voip",
                    "auto_recording" => "cloud",
                    "allow_multiple_devices" => true,
                    "registration_type" => 2,
                ]
            ];
            $curl = curl_init();
            curl_setopt_array($curl,
                array(
                    CURLOPT_URL => 'https://api.zoom.us/v2/users/me/meetings',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($postData),
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer '.$accessToken->zoom_token,
                        'Cookie: __cf_bm=GN3ywe1uhIkt8A3lL9gHzHKkp.4qZTLivRpTlPVFJqY-1712669514-1.0.1.1-DJPYX.VcbuLNC1eShWwsac4xiyrEI1D0FAUk6BbEsCgSrHuLUnZNcmSdTgJKAV4dEOMEev5a_8f.MErEwIl5ag; _zm_chtaid=194; _zm_ctaid=bWbmHkt-Rp25q21_dFN0wQ.1712669514172.bc9ee5647144d7a2e253b3c6f2d5b040; _zm_mtk_guid=c133062e5fbc412eace34da570f36f5b; _zm_page_auth=us04_c_4Sx_TLg1RXKKrIYAholtOg; _zm_ssid=us04_c_Ro2izO6ERUGvcEXUNIr5dw; _zm_visitor_guid=c133062e5fbc412eace34da570f36f5b'
                      )
                )
            );
            $response = curl_exec($curl);
            curl_close($curl);
            $decodedData = json_decode($response, true);
            if($decodedData['code'] == "124") {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://zoom.us/oauth/token',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=account_credentials&account_id=73H-Ll9DSseDWF6dgUeT9A',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Authorization: Basic V1pteDVESzVSNHloOXhkQTRiN190QTp1OXBabnFJcUJHNDdOaE5yS3k4M2h3V1I3QnkybjRvMg==',
                        'Cookie: __cf_bm=j8d61x5QOrLIXdL1IovzLtyXIDmhn9CSZhJLPEzBUc4-1723196550-1.0.1.1-tBe3gQgo8c.JvYn2UVqs6hszZkGUlR6MX5M_MKK..B02y8K7Tu6MDzl.vu4mM.zJXL_22X.zMNvPfHvvoFVsgw; _zm_chtaid=592; _zm_ctaid=vlK3KdZqThenJprgxfHMRQ.1723189809081.03d77d1c9e5e5b7e047f8eb33209f5d7; _zm_mtk_guid=c133062e5fbc412eace34da570f36f5b; _zm_page_auth=aw1_c_DISK24aaTaWD80m2aQmW0Q; _zm_ssid=us04_c_zAGVzePSRJG3ZCkTQyKfiA; _zm_visitor_guid=c133062e5fbc412eace34da570f36f5b; cred=C1A7EA88374F5E3DEE6F4098789ACC4C'
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $data = json_decode($response);
                $this->db->query("UPDATE setting SET zoom_token = '$data->access_token' WHERE id = '1'");
                $this->paymentforslotbook();
            }
            //print_r($decodedData); die();
            $meetingLink[$i]= $decodedData['join_url'];
            $joinUrl = "https://us04web.zoom.us/j/".$decodedData['id'];
            $meetingLink[$i]= $joinUrl;
            $meetingpass[$i]= $decodedData['password'];
            if(!empty($decodedData['join_url'])) {
                $this->db->query("UPDATE user_booking SET meeting_link = '".$joinUrl."', meeting_pass = '".$meetingpass."' WHERE id = '".$getBookinID[0]['id']."'");
                $get_setting=$this->Crud_model->get_single('setting');
                $htmlContent = "
                <div style='width:600px; margin: 0 auto;background: #fff;border: 1px solid #e6e6e6;'>
                    <div style='padding: 30px 30px 15px 30px;box-sizing: border-box;'>
                    <img src='cid:Logo' style='width:100px;float: right;margin-top: 0 auto;'>
                    <h3 style='padding-top:40px; line-height: 30px;'>Greetings from<span style='font-weight: 900;font-size: 35px;color: #F44C0D; display: block;'>PayPer LLC</span></h3>
                    <p style='font-size:24px;'>Hello User,</p>
                    <p style='font-size:24px;'>Please find the below meeting info for $getpostname->post_title</p>
                    <p style='font-size:24px;'>Just press the button below and follow the instructions.</p>
                    <p style='text-align: center;'><a href='".$joinUrl."' style='height: 50px; width: 300px; background: rgb(253,179,2); background: linear-gradient(0deg, rgba(253,179,2,1) 0%, rgba(244,77,9,1) 100%); text-align: center; font-size: 18px; color: #fff; border-radius: 12px; display: inline-block; line-height: 50px; text-decoration: none; text-transform: uppercase; font-weight: 600;'>Meeting Link</a></p>
                    <p style='font-size:24px;'>Meeting Passcode: ".$decodedData['password']."</p>
                    <p style='font-size:20px;'>Thank you!</p>
                    <p style='font-size:20px;list-style: none;'>Sincerly</p>
                    <p style='list-style: none;'><b>PayPer LLC</b></p>
                    <p style='list-style:none;'><b>Visit us:</b> <span>$get_setting->address</span></p>
                    <p style='list-style:none'><b>Email us:</b> <span>$get_setting->email</span></p>
                    </div>
                    <table style='width: 100%;'>
                        <tr>
                            <td style='height:30px;width:100%; background: red;padding: 10px 0px; font-size:13px; color: #fff; text-align: center;'>Copyright &copy; <?=date('Y')?> Pay Per Dialog. All rights reserved.</td>
                        </tr>
                    </table>
                </div>";
                require 'vendor/autoload.php';
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->CharSet = 'UTF-8';
                    $mail->SetFrom('info@payperdialog.com', 'Pay Per Dialog');
                    $mail->AddAddress($getbidemail, $getbidname);
                    $mail->AddAddress($getpostemail, $getpostemail);
                    $mail->IsHTML(true);
                    $mail->Subject = "Meeting Link from Pay Per Dialog";
                    $mail->AddEmbeddedImage('uploads/logo/'.$get_setting->flogo, 'Logo');
                    $mail->Body = $htmlContent;
                    //Send email via SMTP
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Host = "smtp.hostinger.com";
                    $mail->Port = 587; //587 465
                    $mail->Username = "info@payperdialog.com";
                    $mail->Password = "PayperLLC@2024";
                    $mail->send();
                } catch (Exception $e) {
                }
            }
        }
        $meetingLink = implode(',', $meetingLink);
        $meetingpass = implode(',', $meetingpass);
        $this->db->query("UPDATE user_booking SET meeting_link = '".$meetingLink."', meeting_pass = '".$meetingpass."' WHERE id = '".$getBookinID[0]['id']."'");
        echo "1";
    }

	public function edit_availability() {
		$avail_id = $_POST['avail_id'];
		$checkBookSlot = $this->db->query("SELECT user_availability.*, user_booking.* FROM user_booking JOIN user_availability ON user_availability.id = user_booking.available_id WHERE user_booking.available_id = '".$avail_id."'")->result_array();
		if(!empty($checkBookSlot)) {
			echo '1';
		} else {
			$getAvailableData = $this->db->query("SELECT * FROM user_availability WHERE id='".$_POST['avail_id']."'")->result_array();
			echo json_encode($getAvailableData);
			//echo '2';
		}
	}

	public function update_availability() {
		//echo "<pre>"; print_r($_POST); die();
		$user_id = $_POST['user_id'];
		$avail_id = $_POST['avail_id'];
		$start_date = $_POST['start_date'];
		$from_time = $_POST['from_time'];
		$end_date = $_POST['end_date'];
		$to_time = $_POST['to_time'];
		$data = array(
			'user_id' => $user_id,
			'start_date' => $start_date,
			'from_time' => $from_time,
			'end_date' => $end_date,
			'to_time' => $to_time,
		);
		//$this->Crud_model->SaveData('user_availability', $data);
		$this->Crud_model->SaveData('user_availability', $data, "id='".$avail_id."'");
		echo "1";
	}

	public function delete_availability() {
		//echo "<pre>"; print_r($_POST); die();
		$avail_id = $_POST['avail_id'];
		$checkBookSlot = $this->db->query("SELECT user_availability.*, user_booking.* FROM user_booking JOIN user_availability ON user_availability.id = user_booking.available_id WHERE user_booking.available_id = '".$avail_id."'")->result_array();
		if(!empty($checkBookSlot)) {
			echo '1';
		} else {
			$this->Crud_model->DeleteData('user_availability', "id='".$_POST['avail_id']."'");
			echo '2';
		}
	}

	/*public function getBookingDetailsforEmployer() {
		//echo "<pre>"; print_r($_POST); die();
		$selectDate = $_POST['selectDate'];
		$employeeId = $_POST['employeeId'];
		$bookingData = $this->db->query("SELECT * FROM user_availability WHERE start_date ='".@$selectDate."' AND end_date ='".@$selectDate."' AND user_id ='".@$employeeId."'")->result_array();
		$avail_id = $bookingData[0]['id'];
		$html .= "<div style='width: 100%; display: inline-block; text-align: center; border-radius: 10px; box-shadow: 0 0 10px #dddddd; height: 340px;'><p style='padding: 20px 0 0 0;font-size: 18px;font-weight: 600;color: #212529;'>".$selectDate."</p>";
		$getBookSlot = $this->db->query("SELECT * FROM user_booking WHERE available_id ='".@$avail_id."' AND employee_id ='".@$employeeId."'")->result_array();
		$bookingTime = $getBookSlot[0]['bookingTime'];
		$bookingTime = explode(',', $bookingTime);
        if(!empty($getBookSlot)) {
        	$html .="<div style='width: 100%; display: inline-block; padding: 0 40px'><div style='width: 100%; border: 1px solid #eee;height: auto;display: inline-block;box-shadow: 0 0 10px #dddddd;'>";
        	for($i = 0; $i < count($bookingTime); $i++) {
        		$getEmployee = $this->db->query("SELECT * FROM users WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
        		$getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '".@$getBookSlot[0]['employer_id']."'")->result_array();
        		$html .="<div style='width: 33.33%;float: left;display: inline-block;'><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px;'>".date('h:i A', strtotime($bookingTime[$i]))." to ".date('h:i A', strtotime($bookingTime[$i]) + 60*60)."</p></div>";
        	}
        	$html .= "<div><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Total Rate: ".count($bookingTime)*@$getEmployee[0]['rateperhour']."</p><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Booked By: ".@$getEmployer[0]['companyname']."</p></div></div></div>";
        } else {
        	$html = "<div style='width: 100%; display: inline-block; text-align: center; border-radius: 10px; box-shadow: 0 0 10px #dddddd; height: 340px;'><p style='padding: 20px 0 0 0;font-size: 18px;font-weight: 600;color: #212529;'>".$selectDate."</p><div style='color: #212529;'>No slot booked for this selected date</div></div>";
        }
        echo $html;
	}*/

	public function getBookingDetailsforEmployer() {
		$selectDate = $_POST['selectDate'];
		$employeeId = $_POST['employeeId'];
		$availableData = $this->db->query("SELECT * FROM user_availability WHERE start_date ='".$selectDate."' AND end_date ='".$selectDate."' AND user_id ='".@$employeeId."'")->result_array();
        $avail_id = $availableData[0]['id'];
        $html .= "<div style='width: 100%;display: inline-block;text-align: center;border-radius: 10px;box-shadow: 0 0 10px #dddddd;height: 400px;overflow-y: scroll;overflow-x: hidden;'><p style='padding: 20px 0 0 0;font-size: 18px;font-weight: 600;color: #212529;'>".$selectDate."</p>";
        $getBookSlot = $this->db->query("SELECT * FROM user_booking WHERE available_id ='".@$avail_id."' AND employee_id ='".@$employeeId."'")->result_array();
        if(!empty($getBookSlot)) {
        	for($i = 0; $i < count($getBookSlot); $i++) {
        		$html .= "<div style='width: 100%; display: inline-block; padding: 0 10px; margin-bottom: 20px;'><div style='width: 100%;display: inline-block;border-radius: 10px;box-shadow: 0 0 10px #dddddd;padding: 20px 0 20px 0;'>";
        		$booking_id = $getBookSlot[$i]['id'];
                $employee_id = $getBookSlot[$i]['employee_id'];
                $employer_id = $getBookSlot[$i]['employer_id'];
                $available_id = $getBookSlot[$i]['available_id'];
                $bookingTime = $getBookSlot[$i]['bookingTime'];
                $bookingTime = explode(',', $bookingTime);
				$meetingLink = explode(',', $getBookSlot[0]['meeting_link']);
				$meetingPass = explode(',', $getBookSlot[0]['meeting_pass']);
                for($j = 0; $j < count($bookingTime); $j++) {
                    $getEmployee = $this->db->query("SELECT * FROM users WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                    $getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '".@$employer_id."'")->result_array();
                    // $html .= "<div style='width: 33.33%;float: left;display: flex; position: relative; align-items: center; justify-content: space-between; flex-direction: row;'><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'>".date('h:i A', strtotime($bookingTime[$j]))." to ".date('h:i A', strtotime($bookingTime[$j]) + 60*60)."</p><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'><a href=".$meetingLink[$j].">Meeting Link</a></p><input type='checkbox' style='position: unset; z-index: 1; opacity: 1; margin: 0px 10px 0px 0px;' id='completecheck' name='completecheck' value='1' onclick='completecheck($booking_id)'></div>";
					$html .= "<div style='width: 100%;float: left;display: flex; position: relative; align-items: center; justify-content: space-between; flex-direction: row;'><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'>".date('h:i A', strtotime($bookingTime[$j]))." to ".date('h:i A', strtotime($bookingTime[$j]) + 60*60)."</p><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'><a href=".$meetingLink[$j].">Meeting Link</a> pass: ".$meetingPass[$j]."</p></div>";
                }
                $html .= "<div><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Total Rate: ".count($bookingTime)*@$getEmployee[0]['rateperhour']."</p><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Booked By: ".@$getEmployer[0]['companyname']."</p></div></div></div>";
            }
        } else {
        	$html .= "<div><div style='color: #212529;'>No slot booked for this selected date</div></div>";
        }
        $html .= "</div>";
        echo $html;
	}

	public function getBookingDetailsforEmployee() {
		$selectDate = $_POST['selectDate'];
		$employeeId = $_POST['employeeId'];
		$availableData = $this->db->query("SELECT user_availability.id as avail_id, user_availability.start_date, user_availability.from_time, user_availability.end_date, user_availability.to_time, user_booking.employee_id, user_booking.employer_id, user_booking.bookingTime FROM user_availability JOIN user_booking ON user_booking.available_id = user_availability.id WHERE user_availability.start_date ='".$selectDate."' AND user_availability.end_date ='".$selectDate."' AND user_booking.employer_id ='".@$employeeId."'")->result_array();
		$html .= "<div style='width: 100%;display: inline-block;text-align: center;border-radius: 10px;box-shadow: 0 0 10px #dddddd;height: 400px;overflow-y: scroll;overflow-x: hidden;'><p style='padding: 20px 0 0 0;font-size: 18px;font-weight: 600;color: #212529;'>".$selectDate."</p>";
        if (!empty($availableData)) {
			foreach ($availableData as $value) {
				$getBookSlot = $this->db->query("SELECT * FROM user_booking WHERE available_id ='".@$value['avail_id']."' AND employer_id ='".@$employeeId."'")->result_array();
				if(!empty($getBookSlot)) {
					for($i = 0; $i < count($getBookSlot); $i++) {
						$html .= "<div style='width: 100%; display: inline-block; padding: 0 10px; margin-bottom: 20px;'><div style='width: 100%;display: inline-block;border-radius: 10px;box-shadow: 0 0 10px #dddddd;padding: 20px 0 20px 0;'>";
						$booking_id = $getBookSlot[$i]['id'];
						$employee_id = $getBookSlot[$i]['employee_id'];
						$employer_id = $getBookSlot[$i]['employer_id'];
						$available_id = $getBookSlot[$i]['available_id'];
						$bookingTime = $getBookSlot[$i]['bookingTime'];
						$bookingTime = explode(',', $bookingTime);
						$meetingLink = explode(',', $getBookSlot[0]['meeting_link']);
						$meetingPass = explode(',', $getBookSlot[0]['meeting_pass']);
						for($j = 0; $j < count($bookingTime); $j++) {
							$getEmployee = $this->db->query("SELECT * FROM users WHERE userId = '".@$employee_id."'")->result_array();
							$getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '".@$employer_id."'")->result_array();
							// $html .= "<div style='width: 100%;float: left;display: flex; position: relative; align-items: center; justify-content: space-between; flex-direction: row;'><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'>".date('h:i A', strtotime($bookingTime[$j]))." to ".date('h:i A', strtotime($bookingTime[$j]) + 60*60)."</p><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'><a href=".$meetingLink[$j].">Meeting Link</a></p><input type='checkbox' style='position: unset; z-index: 1; opacity: 1; margin: 0px 10px 0px 0px;' id='completecheck' name='completecheck' value='1' onclick='completecheck($booking_id)'></div>";
							$html .= "<div style='width: 100%;float: left;display: flex; position: relative; align-items: center; justify-content: space-between; flex-direction: row;'><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'>".date('h:i A', strtotime($bookingTime[$j]))." to ".date('h:i A', strtotime($bookingTime[$j]) + 60*60)."</p><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'><a href=".$meetingLink[$j].">Meeting Link</a> pass: ".$meetingPass[$j]."</p></div>";
						}
						$html .= "<div><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Total Rate: ".count($bookingTime)*@$getEmployee[0]['rateperhour']."</p><p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Booked By: ".@$getEmployer[0]['companyname']."</p></div></div></div>";
					}
				}
			}
		} else {
        	$html .= "<div><div style='color: #212529;'>No slot booked for this selected date</div></div>";
        }
        $html .= "</div>";
        echo $html;
	}

	public function recommended_jobs() {
		$data['usersSkillsData'] = $this->db->query("SELECT userId, skills, experience FROM users WHERE userType = '1' AND userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
		$this->load->view('header');
		$this->load->view('user_dashboard/recommended_jobs', $data);
		$this->load->view('footer');
	}

	public function filterJobDataBySkillset() {
		$skills = $_POST['id'];
		$experience = $_POST['experience'];
		if(!empty($skills)) {
			$recomendedJobList = $this->db->query("SELECT users.companyname, users.profilePic, postjob.* FROM postjob JOIN users ON postjob.user_id = users.userId WHERE (instr(concat(',', required_key_skills, ','), ',$skills,') OR postjob.required_key_skills = '".$skills."') AND postjob.experience_level = '".$experience."' AND `is_delete` = 0")->result_array();
		} else {
			$recomendedJobList = $this->db->query("SELECT users.companyname, users.profilePic, postjob.* FROM postjob JOIN users ON postjob.user_id = users.userId WHERE postjob.experience_level = '".$experience."' AND `is_delete` = 0")->result_array();
		}
		$output .= '<div>';
		if(!empty($recomendedJobList)) {
			foreach ($recomendedJobList as $key) {
				if($key['userType'] == 1){
					$name = $key['firstname'].' '.$key['lastname'];
				} else {
					$name = $key['companyname'];
				}
				if(!empty($key['profilePic']) && file_exists('uploads/users/'.$key['profilePic'])){
					$profile_pic= '<img src="'.base_url('uploads/users/'.$key['profilePic']).'" alt="" />';
				} else {
					$profile_pic= '<img src="'.base_url('uploads/users/user.png').'" alt="" />';
				}
				$get_category=$this->Crud_model->get_single('category',"id='".$key['category_id']."'");
				$get_subcategory=$this->Crud_model->get_single('sub_category',"id='".$key['subcategory_id']."'");
				$string = strip_tags($key['description']);
				if (strlen($string) > 200) {
					$stringCut = substr($string, 0, 200);
					$endPoint = strrpos($stringCut, ' ');
					$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
					$string .= '...';
				}
				$output .= '
				<div class="emply-resume-list">
					<div class="emply-resume-thumb">'.$profile_pic.'</div>
					<div class="emply-resume-info">
						<h3><a href="'.base_url('postdetail/'.base64_encode($key["id"])).'" title="">'.$key["post_title"].'</a></h3>
						<span>'.$get_category->category_name.'</span>
						<span>'.$get_subcategory->sub_category_name.'</span>
						<p><i class="la la-map-marker"></i>'.$key["city"].', '.$key["state"].', '.$key["country"].'</p>
						<span><b>Posted By:</b> '.$name.'</span>
						<div class="Employee-Details">
							<div class="MoreDetailsTxt_'.$key['id'].'">'.$string.'</div>
						</div>
					</div>
				</div>';
			}
			$output .='</div>';
		} else {
            $output .= '<div class="emply-resume-list"><div class="emply-resume-thumb" style="width: 100%;"><h2>No Data Found</h2></div></div>';
        }
		echo $output;
	}

	public function recommended_employee() {
		$data['jobTitleByemployer'] = $this->db->query("SELECT id, post_title, required_key_skills FROM postjob WHERE user_id = '".@$_SESSION['afrebay']['userId']."'")->result_array();
		//$data['jobListByemployer'] = $this->db->query("SELECT * FROM users WHERE userType = '1'")->result_array();
		//$data['jobListByemployer'] = $this->db->query("SELECT * FROM job_bid WHERE bidding_status = 'Ready for Interview'")->result_array();
        $data['jobListByemployer'] = $this->db->query("SELECT postjob.id, postjob.user_id as postuser, postjob.post_title, job_bid.postjob_id, job_bid.user_id as bidUser, job_bid.bidding_status FROM postjob JOIN job_bid ON postjob.id = job_bid.postjob_id WHERE job_bid.bidding_status = 'Ready for Interview' AND postjob.user_id = '".@$_SESSION['afrebay']['userId']."'")->result_array();
		$this->load->view('header');
		$this->load->view('user_dashboard/recommended_employee', $data);
		$this->load->view('footer');
	}

	public function filterEmployeeByJobtitle() {
		//echo "<pre>"; print_r($_POST); die;
		/*$skills = explode(',', $_POST['skill']);
		$count = count($skills);
		$output = '<div>';
		for ($s=0; $s < $count; $s++) {
			if(!empty($skills[0])) {
				$getUser = $this->db->query("SELECT * FROM users WHERE (instr(concat(',', skills, ','), ',$skills[$s],') OR skills = '".$skills[$s]."') AND userType = '1' AND status = '1' AND email_verified = '1'")->result_array();
			} else {
				$getUser = $this->db->query("SELECT * FROM users WHERE userType = '1' AND status = '1' AND email_verified = '1'")->result_array();
			}
			if(!empty($getUser)) {
				foreach ($getUser as $key) {
					if($key['userType'] == 1){
						$name = $key['firstname'].' '.$key['lastname'];
					} else {
						$name = $key['companyname'];
					}
					if(!empty($key['profilePic']) && file_exists('uploads/users/'.$key['profilePic'])){
						$profile_pic= '<img src="'.base_url('uploads/users/'.$key['profilePic']).'" alt="" />';
					} else {
						$profile_pic= '<img src="'.base_url('uploads/users/user.png').'" alt="" />';
					}
					$string = strip_tags($key['short_bio']);
					if (strlen($string) > 200) {
						$stringCut = substr($string, 0, 200);
						$endPoint = strrpos($stringCut, ' ');
						$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
						$string .= '...';
					}
					$output .= '
					<div class="emply-resume-list"><div class="emply-resume-thumb">'.$profile_pic.'</div>
					<div class="emply-resume-info"><h3><a href="'.base_url('worker-detail/'.base64_encode($key["userId"])).'" title="">'.$name.'</a></h3>
					<p><i class="la la-map-marker"></i>'.$key["address"].'</p>
					<div class="Employee-Details"><div class="MoreDetailsTxt_'.$key['id'].'">'.$string.'</div></div></div></div>';
				}
				$output .= '';
			} else {
				$output .= '<div class="emply-resume-list"><div class="emply-resume-thumb" style="width: 100%;"><h2>No Data Found</h2></div></div>';
			}
		}*/
        $postjob_id = $_POST['p_id'];
        if(!empty($postjob_id)) {
            $getUser = $this->db->query("SELECT users.userId, users.firstname, users.lastname, users.address, users.short_bio, users.profilePic FROM users JOIN job_bid ON job_bid.user_id = users.userId WHERE job_bid.id = '".@$postjob_id."'")->result_array();
        } else {
            $getUser = $this->db->query("SELECT postjob.id, postjob.user_id as postuser, postjob.post_title, job_bid.postjob_id, job_bid.user_id as bidUser, job_bid.bidding_status FROM postjob JOIN job_bid ON postjob.id = job_bid.postjob_id WHERE job_bid.bidding_status = 'Ready for Interview' AND postjob.user_id = '".@$_SESSION['afrebay']['userId']."'")->result_array();
        }
        $output = '<div>';
        if(!empty($getUser)) {
            foreach ($getUser as $key) {
                if(!empty($key['profilePic']) && file_exists('uploads/users/'.$key['profilePic'])){
                    $profile_pic= '<img src="'.base_url('uploads/users/'.$key['profilePic']).'" alt="" />';
                } else {
                    $profile_pic= '<img src="'.base_url('uploads/users/user.png').'" alt="" />';
                }
                $string = strip_tags($key['short_bio']);
                if (strlen($string) > 200) {
                    $stringCut = substr($string, 0, 200);
                    $endPoint = strrpos($stringCut, ' ');
                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                    $string .= '...';
                }
                $output .= '
                <div class="emply-resume-list">
                    <div class="emply-resume-thumb">'.$profile_pic.'</div>
                    <div class="emply-resume-info">
                        <h3><a href="'.base_url('worker-detail/'.base64_encode($key["userId"])).'" title="">'.$key['firstname'].' '.$key['lastname'].'</a></h3>
                        <p><i class="la la-map-marker"></i>'.$key["address"].'</p>
                        <div class="Employee-Details">
                            <div class="MoreDetailsTxt_'.$key['id'].'">'.$string.'</div>
                        </div>
                    </div>
                    <div class="view-more-less view-more-less-js"><a href="'.base_url('worker-detail/'.base64_encode($key["userId"])).'#job-overview") target="_blank">Schedule Interview</a></button>
                </div>
                </div>';
            }
            $output .= '';
        } else {
            $output .= '<div class="emply-resume-list"><div class="emply-resume-thumb" style="width: 100%;"><h2>No Data Found</h2></div></div>';
        }
		echo $output;
	}

	public function checktoaggrement() {
		$jobpostuserid = $_POST['userid'];
		$data = array(
			"isAggreed" => 1
		);
		$this->Crud_model->SaveData('users', $data, "userId='" . $jobpostuserid . "'");
		echo "1";
	}

	public function bookingHistory() {
		$this->load->view('header');
		$this->load->view('user_dashboard/bookingHistory');
		$this->load->view('footer');
	}
}
