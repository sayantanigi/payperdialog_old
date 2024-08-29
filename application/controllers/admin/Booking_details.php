<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_details extends MY_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('Bookingdetails_model');
    }

    function index() {
        $header = array('title' => 'Booking Details');
        $userdetails = $this->db->query("SELECT `users`.`userId`, `users`.`firstname`, `users`.`lastname`, `users`.`email`, `users`.`userType`, `user_availability`.`id` as `user_availability_id`, `user_availability`.`user_id`, `user_availability`.`start_date`, `user_availability`.`from_time`, `user_availability`.`end_date`, `user_availability`.`to_time`, `user_booking`.`id`, `user_booking`.`employee_id`, `user_booking`.`employer_id`, `user_booking`.`available_id`, `user_booking`.`bookingTime`, `user_booking_txn`.`id`, `user_booking_txn`.`booking_id`, `user_booking_txn`.`rate`, `user_booking_txn`.`txn_id` FROM `user_availability` join `users` ON `user_availability`.`user_id` = `users`.`userId` join `user_booking` ON `user_availability`.`id` = `user_booking`.`available_id` join `user_booking_txn` ON `user_booking_txn`.`booking_id` = `user_booking`.`id`")->result_array();
        $data = array(
            'heading' => 'Booking Details',
            'userbookingDetails' => $userdetails
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/booking_details/list',$data);
        $this->load->view('admin/footer');
    }

    function userbookingDetails($id) {
        $userId = $id;
        //$get_userdata=$this->Crud_model->get_single('users',$con);
        $get_userdata = $this->db->query("SELECT user_availability.id as 'user_availability_id', user_availability.user_id, user_availability.start_date, user_availability.from_time, user_availability.end_date, user_availability.to_time, user_booking.id AS booking_id, user_booking.employee_id, user_booking.employer_id, user_booking.available_id, user_booking.bookingTime, user_booking_txn.id, user_booking_txn.booking_id, user_booking_txn.rate, user_booking_txn.txn_id FROM user_availability JOIN users ON user_availability.user_id = users.userId JOIN user_booking ON user_availability.id = user_booking.available_id JOIN user_booking_txn ON user_booking_txn.booking_id = user_booking.id WHERE user_availability.user_id = '$userId' AND user_booking.employee_id = '$userId'")->result_array();
        $header = array('title' => 'Booking Details');
        $data = array(
            'heading' => 'Booking Details',
            'get_userdata' => $get_userdata,
        );
        $this->load->view('admin/header', $header);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/booking_details/view',$data);
        $this->load->view('admin/footer');
    }

    public function change_status() {
        if($_POST['status']=='1') {
            $statuss='0';
        } else if($_POST['status']=='0'){
            $statuss='1';
        }
        $data=array(
            'status'=>$statuss,
        );
        $this->Crud_model->SaveData("users",$data,"userId='".$_POST['id']."'");
    }
}
//end controller

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
