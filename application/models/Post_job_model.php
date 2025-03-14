<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Post_job_model extends My_Model {
    var $column_order = array(null,'postjob.post_title','category.category_name','postjob.duration','postjob.charges',null); //set column field database for datatable orderable
    var $order = array('postjob.id' => 'DESC');
    function __construct() {
        parent::__construct();
    }

	private function _get_datatables_query() {
		$this->db->select('postjob.*,category.category_name,CONCAT(users.firstname,"",users.lastname) as fullname,sub_category.sub_category_name' );
        $this->db->from('postjob');
        $this->db->join('category','category.id=postjob.category_id');
        $this->db->join('users','users.userId=postjob.user_id');
        $this->db->join('sub_category','sub_category.id=postjob.subcategory_id');
        // $this->db->where($cond);
		$i = 0;
        $new_str = preg_replace("/[^a-zA-Z0-9]/", "", $_POST['search']['value']);
        if($new_str) {
            $explode_string = explode(' ', $new_str);
            foreach ($explode_string as $show_string) {
                $cond  = " ";
                $cond.=" (  postjob.post_title LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  category.category_name LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  postjob.duration LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  postjob.charges LIKE '%".trim($show_string)."%' ";
                $cond.=" OR  postjob.status LIKE '%".trim($show_string)."%') ";
                $this->db->where($cond);
            }
        }
        $i++;

        if(isset($_POST['order'])) {
            //print_r($this->column_order);exit;
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

	function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            // $this->db->where();
            // echo $this->db->last_query();die;
        return $query->result();
    }

	public function count_all() {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

	function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function viewdata($con) {
        //echo 'SELECT postjob.*,category.category_name,CONCAT(users.firstname," ",users.lastname) as fullname,users.username,users.address as user_address,sub_category.sub_category_name,users.userType FROM postjob JOIN category ON category.id=postjob.category_id JOIN users ON users.userId=postjob.user_id JOIN sub_category ON sub_category.id=postjob.subcategory_id WHERE'.$con; die();
        $this->db->select('postjob.*,category.category_name,CONCAT(users.firstname," ",users.lastname) as fullname,users.username,users.address as user_address,users.userType' );
        $this->db->from('postjob');
        $this->db->join('category','category.id=postjob.category_id');
        $this->db->join('users','users.userId=postjob.user_id');
        //$this->db->join('sub_category','sub_category.id=postjob.subcategory_id');
        $this->db->where($con);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    function postjobdata($con) {
        $this->db->select('postjob.*,category.category_name,users.profilePic,sub_category.sub_category_name' );
        $this->db->from('postjob');
        $this->db->join('category','category.id=postjob.category_id','left');
        $this->db->join('users','users.userId=postjob.user_id','left');
        $this->db->join('sub_category','sub_category.id=postjob.subcategory_id','left');
        $this->db->where($con);
        $this->db->order_by('postjob.id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    /*function postjob_bid($cond) {
        $this->db->select('postjob.*,job_bid.duration as job_duration,job_bid.bid_amount,job_bid.phone,job_bid.description as job_description,
        job_bid.created_date as job_date,CONCAT(users.firstname,"",users.lastname) as fullname,users.username,job_bid.bidding_status,job_bid.id as jobbid_id');
        $this->db->from('postjob');
        $this->db->join('job_bid','job_bid.postjob_id=postjob.id','left');
        $this->db->join('users','users.userId=job_bid.user_id','left');
        $this->db->where($cond);
        $query = $this->db->get();
        return $query->result();
    }*/

    function postjob_bid($cond) {
        $this->db->select('job_bid.*, job_bid.user_id as userid, job_bid.description, postjob.user_id, postjob.post_title, CONCAT(users.firstname," ",users.lastname) as fullname, users.username, users.profilePic, users.email, users.mobile');
        $this->db->from('job_bid');
        $this->db->join('postjob','job_bid.postjob_id=postjob.id','left');
        $this->db->join('users','users.userId=job_bid.user_id','left');
        $this->db->where($cond);
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getcount() {
        $this->db->select('postjob.*,category.category_name,users.profilePic,sub_category.sub_category_name');
        $this->db->from('postjob');
        $this->db->join('category','category.id=postjob.category_id','left');
        $this->db->join('users','users.userId=postjob.user_id','left');
        $this->db->join('sub_category','sub_category.id=postjob.subcategory_id','left');
        $this->db->where('postjob.is_delete','0');
        $this->db->where('postjob.status','Active');
        $this->db->order_by('postjob.id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    function fetchdata($limit, $start) {
        $this->db->select('postjob.*,category.category_name,users.profilePic,sub_category.sub_category_name');
        $this->db->from('postjob');
        $this->db->join('category','category.id=postjob.category_id','left');
        $this->db->join('users','users.userId=postjob.user_id','left');
        $this->db->join('sub_category','sub_category.id=postjob.subcategory_id','left');
        $this->db->where('postjob.is_delete','0');
        $this->db->where('postjob.status','Active');
        $this->db->limit($limit, $start);
        $this->db->order_by('postjob.id','desc');
        $data = $this->db->get();

        $output = '';
        if(!empty($data)) {
            foreach($data->result_array() as $row) {
                if(strlen($row['description'])>100){
                    $desc= substr($row['description'], 0,100).'...';}
                else {
                    $desc= $row['description'];
                }

                $output .= '<div class="emply-resume-list"><div class="emply-resume-info"><h3><a href="#" title="">'.$row["post_title"].'</a></h3><span>'.$row['category_name'].'</span><span>'.$row['sub_category_name'].' </span><p><i class="la la-map-marker"></i>'. $row['location'].'</p><p>'.$desc.'</p></div><div class="shortlists" style="width:50px;"><a href="'.base_url('postdetail/'.base64_encode($row['id'])).'" title="">Bid Now <i class="la la-plus"></i></a></div></div>';
            }
        } else {
            $output .= '<div class="emply-resume-list"><div class="emply-resume-thumb"><h2>No Data Found</h2></div></div>';
        }
        return $output;
    }

    // pagination subcategory start
    function make_query($title, $location,$days,$category_id,$subcategory_id,$search_title,$search_location,$country,$state,$city,$date_posted,$remote_job,$from_price,$to_price,$job_type,$posted_by,$experience_level,$education) {
        if(isset($title) || isset($location) || isset($days) || isset($category_id)|| isset($subcategory_id) || isset($search_title) || isset($search_location) || isset($country) || isset($state) || isset($city) || isset($date_posted) || isset($remote_job) || isset($from_price) || isset($to_price) || isset($job_type) || isset($posted_by) || isset($experience_level) || isset($education)) {
            $query = "SELECT * FROM postjob WHERE is_delete = '0'";
            if(isset($title) && !empty($title)) {
                $query .= " AND post_title like '%".$title."%'";

            }
            if(isset($location) && !empty($location)) {
                $query .= "AND location like '%".$location."%'";
            }
            if(isset($category_id) && !empty($category_id)) {
                $query .= "AND category_id='".$category_id."'";
            }

            if(isset($subcategory_id) && !empty($subcategory_id)) {
                $query .= "AND subcategory_id='".$subcategory_id."'";
            }

            // if(isset($subcategory_id) && !empty($subcategory_id)) {
            //     $query.=" and (";
            //     foreach ($subcategory_id as $key => $value) {
            //         if($key==0){
            //             $query.="  subcategory_id ='".$value."'";
            //         } else {
            //             $query.="or  subcategory_id ='".$value."'";
            //         }
            //     }
            //     $query.=")";
            // }

            if(isset($days)&& !empty($days)) {
                if($days=='one') {
                    $query .="AND created_date>=NOW()-INTERVAL 1 HOUR";
                } else {
                    $current_date=date('Y-m-d');
                    $dates=date('Y-m-d', strtotime($current_date.'-'.$days.'days'));
                    $query .=" AND created_date>='".$dates."'";
                }
            }

            if(isset($search_title)&& !empty($search_title)) {
                $query .= " AND post_title like '%".$search_title."%'";
            }

            if(isset($search_location) && !empty($search_location)) {
                $query .= " AND location like '%".$search_location."%'";
            }

            if(isset($country) && !empty($country)) {
                $query .= " AND country ='".$country."'";
            }

            if(isset($state) && !empty($state)) {
                $query .= " AND state ='".$state."'";
            }

            if(isset($city) && !empty($city)) {
                $query .= " AND city ='".$city."'";
            }

            if(isset($date_posted) && !empty($date_posted)) {
                $query .= " AND created_date LIKE '%".date('Y-m-d',strtotime($date_posted))."%'";
            }

            if(isset($remote_job) && !empty($remote_job)) {
                $query .= " AND remote ='".$remote_job."'";
            }

            if(isset($from_price) && !empty($from_price)) {
                $query .= " AND charges BETWEEN '".$from_price."' AND '".$to_price."'";
            }

            if(isset($job_type) && !empty($job_type)) {
                $query .= " AND job_type ='".$job_type."'";
            }

            if(isset($posted_by) && !empty($posted_by)) {
                $query .= " AND user_id ='".$posted_by."'";
            }

            if(isset($experience_level) && !empty($experience_level)) {
                $query .= " AND experience_level ='".$experience_level."'";
            }

            if(isset($education) && !empty($education)) {
                $query .= " AND education ='".$education."'";
            }
            return $query;
        }
        //print_r($this->db->last_query()); exit;
    }

    function subcategory_getcount($title, $location,$days,$category_id,$subcategory_id,$search_title,$search_location,$country,$state,$city,$date_posted,$remote_job,$from_price,$to_price,$job_type,$posted_by,$experience_level,$education) {
        $query = $this->make_query($title, $location,$days,$category_id,$subcategory_id,$search_title,$search_location,$country,$state,$city,$date_posted,$remote_job,$from_price,$to_price,$job_type,$posted_by,$experience_level,$education);
        $data = $this->db->query($query);
        return $data->num_rows();
    }

    function subcategory_fetchdata($limit, $start, $title, $location,$days,$category_id,$subcategory_id,$post_id,$search_title,$search_location,$country,$state,$city,$date_posted,$remote_job,$from_price,$to_price,$job_type,$posted_by,$experience_level,$education) {
        if(isset($title) || isset($location) || isset($days) || isset($category_id)|| isset($subcategory_id)|| isset($search_title)|| isset($search_location)|| isset($country)|| isset($state)|| isset($city) || isset($date_posted) || isset($remote_job) || isset($from_price) || isset($to_price) || isset($job_type) || isset($posted_by) || isset($experience_level) || isset($education)){
            $query = $this->make_query($title, $location,$days,$category_id,$subcategory_id,$search_title,$search_location,$country,$state,$city,$date_posted,$remote_job,$from_price,$to_price,$job_type,$posted_by,$experience_level,$education);
            $query .= ' ORDER BY id DESC';
            $query .= ' LIMIT '.$start.', ' . $limit;
            $data = $this->db->query($query);
        } else {
            $query = "SELECT * FROM postjob WHERE is_delete = '0' AND status = 'Active' ORDER BY id DESC";
            $query .= ' LIMIT '.$start.', ' . $limit;
            $data = $this->db->query($query);
        }

        $output = '';
        if($data->num_rows() > 0) {
            foreach($data->result_array() as $row) {
                $get_users=$this->Crud_model->get_single('users',"userId='".$row['user_id']."'");
                //print_r($get_users);
                if($get_users->userType == 1){
                    $name = $get_users->firstname.' '.$get_users->lastname;
                } else {
                    $name = $get_users->companyname;
                }
                $get_category=$this->Crud_model->get_single('category',"id='".$row['category_id']."'");
                $get_subcategory=$this->Crud_model->get_single('sub_category',"id='".$row['subcategory_id']."'");
                if(!empty($get_users->profilePic) && file_exists('uploads/users/'.$get_users->profilePic)){
                    $profile_pic= '<img src="'.base_url('uploads/users/'.$get_users->profilePic).'" alt="" />';
                } else {
                    $profile_pic= '<img src="'.base_url('uploads/users/user.png').'" alt="" />';
                }

                $output .= '<div class="emply-resume-list"><div class="emply-resume-thumb">'.$profile_pic.'</div><div class="emply-resume-info"><h3><a href="'.base_url('postdetail/'.base64_encode($row['id'])).'" title="">'.$row['post_title'].'</a></h3><span>'.$get_category->category_name.'</span><span>'.$get_subcategory->sub_category_name.' </span><p><i class="la la-map-marker"></i>'.$row["city"].', '.$row["state"].', '.$row["country"].'</p><div class="Employee-Details"><div class="MoreDetailsTxt_'.$row['id'].'">'.$row['description'].'</div><a class="btn btn-info More" onclick="MoreDetailsTxt('.$row['id'].')">View Details</a></div></div><div class="shortlists"><a href="'.base_url('employerdetail/'.base64_encode($get_users->userId)).'" class="Emp_Comp"><i class="fa fa-briefcase" aria-hidden="true"></i>'.$name.'</a><a href="'.base_url('postdetail/'.base64_encode($row['id'])).'" title="">Bid Now <i class="la la-plus"></i></a></div></div> ';
            }
        } else {
            $output .= '<div class="emply-resume-list"><div class="emply-resume-thumb"><h2>No Data Found</h2></div></div>';
        }
        return $output;
    }

    function subcategory_fetchdataAPI($limit, $start, $title, $location,$days,$category_id,$subcategory_id,$post_id,$search_title,$search_location,$country,$state,$city) {
        if(isset($title) || isset($location) || isset($days) || isset($category_id)|| isset($subcategory_id)|| isset($search_title)|| isset($search_location)|| isset($country)|| isset($state)|| isset($city)){
            $query = $this->make_query($title, $location,$days,$category_id,$subcategory_id,$search_title,$search_location,$country,$state,$city);
            $query .= ' ORDER BY id DESC';
            $query .= ' LIMIT '.$start.', ' . $limit;
            $data = $this->db->query($query);
        } else {
            $query = "SELECT * FROM postjob WHERE is_delete = '0' AND status = 'Active' ORDER BY id DESC";
            $query .= ' LIMIT '.$start.', ' . $limit;
            $data = $this->db->query($query);
        }
        return $data->result_array();
    }
}
