<?php
if(empty($_SESSION['afrebay']['userId']))
{
redirect(base_url('login'));
}
$seg1=$this->uri->segment(1);
$get_setting=$this->Crud_model->get_single('setting');
?>
<section class="dashboard-gig User_Sidemenu max_height EmployersTheme ExpertsTheme EmployeesTheme">
    <div class="container display-table" style="display: block;">
        <div class="completeSub">Please activate a subscription package and complete your profile to proceed with further activities within your dashboard</div>
        <div class="completeSub1">Please complete your profile to proceed with further activities within your dashboard</div>
        <div class="row display-table-row">
            <div class="col-md-12 col-md-12 col-sm-12 hidden-xs for-mobile-sidemenu display-table-cell v-align box" id="navigation">
                <div class="navi">
                    <ul>
                        <?php if($get_setting->required_subscription == '1') { ?>
                        <li <?php if($seg1=='subscription') { ?> class="active" <?php } ?>>
                            <span class="cover"></span>
                            <a href="<?= base_url('subscription')?>"><i class="fa fa-bookmark" aria-hidden="true"></i>
                                <span class="hidden-xs hidden-sm">Subscription</span>
                            </a>
                        </li>
                        <?php } ?>

                        <li <?php if($seg1=='profile') { ?> class="active" <?php } ?>>
                            <span class="cover"></span>
                            <?php 
                            if($get_setting->required_subscription == '1') {
                                $get_sub_data = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
                                if(!empty($get_sub_data)) { ?>
                                    <a href="<?= base_url('profile')?>"><i class="fa fa-user-circle" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Profile</span>
                                    </a>
                                <?php } else { ?>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-user-circle" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Profile</span>
                                    </a>
                                <?php }
                            } else { ?>
                                <a href="<?= base_url('profile')?>"><i class="fa fa-user-circle" aria-hidden="true"></i>
                                    <span class="hidden-xs hidden-sm">Profile</span>
                                </a>
                            <?php } ?>
                        </li>

                        <?php 
                        if($get_setting->required_subscription == '1') {
                            if(@$_SESSION['afrebay']['userType']=='1' || @$_SESSION['afrebay']['userType']=='3') {
                                $get_sub_data = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
                                if(!empty($get_sub_data)) {
                                    $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                    if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio'])) { ?>
                                    <li <?php if($seg1=='education-list') { ?>class="active" <?php } ?>>
                                        <span class="cover"></span>
                                        <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                            <span class="hidden-xs hidden-sm">Education</span>
                                        </a>
                                    </li>
                                    <li <?php if($seg1=='workexperience-list') { ?>class="active" <?php } ?>>
                                        <span class="cover"></span>
                                        <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-id-card" aria-hidden="true"></i>
                                            <span class="hidden-xs hidden-sm">Work Experience</span>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li <?php if($seg1=='education-list') { ?>class="active" <?php } ?>>
                                        <span class="cover"></span>
                                        <a href="<?= base_url('education-list')?>"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                            <span class="hidden-xs hidden-sm">Education</span>
                                        </a>
                                    </li>
                                    <li <?php if($seg1=='workexperience-list') { ?>class="active" <?php } ?>>
                                        <span class="cover"></span>
                                        <a href="<?= base_url('workexperience-list')?>"><i class="fa fa-id-card" aria-hidden="true"></i>
                                            <span class="hidden-xs hidden-sm">Work Experience</span>
                                        </a>
                                    </li>
                                <?php } } else { ?>
                                <li <?php if($seg1=='education-list') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Education</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='workexperience-list') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-id-card" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Work Experience</span>
                                    </a>
                                </li>
                                <?php } 
                            } 
                        } else {
                            if(@$_SESSION['afrebay']['userType']=='1' || @$_SESSION['afrebay']['userType']=='3') {
                            $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                            if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio'])) { ?>
                            <li <?php if($seg1=='education-list') { ?>class="active" <?php } ?>>
                                <span class="cover"></span>
                                <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                    <span class="hidden-xs hidden-sm">Education</span>
                                </a>
                            </li>
                            <li <?php if($seg1=='workexperience-list') { ?>class="active" <?php } ?>>
                                <span class="cover"></span>
                                <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-id-card" aria-hidden="true"></i>
                                    <span class="hidden-xs hidden-sm">Work Experience</span>
                                </a>
                            </li>
                            <?php } else { ?>
                            <li <?php if($seg1=='education-list') { ?>class="active" <?php } ?>>
                                <span class="cover"></span>
                                <a href="<?= base_url('education-list')?>"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                    <span class="hidden-xs hidden-sm">Education</span>
                                </a>
                            </li>
                            <li <?php if($seg1=='workexperience-list') { ?>class="active" <?php } ?>>
                                <span class="cover"></span>
                                <a href="<?= base_url('workexperience-list')?>"><i class="fa fa-id-card" aria-hidden="true"></i>
                                    <span class="hidden-xs hidden-sm">Work Experience</span>
                                </a>
                            </li>
                            <?php }}
                        } ?>
                        

                        <?php 
                        if($get_setting->required_subscription == '1') {
                            if(@$_SESSION['afrebay']['userType']=='2') {
                                $get_sub_data = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
                                if(!empty($get_sub_data)) {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['companyname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['address']) || empty($profile_check[0]['teamsize'])  || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='myjob') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">List of Bids</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-employee') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Recomended Employee</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='myjob') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('myjob')?>"><i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('jobbid')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">List of Bids</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-employee') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('jobbid')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Recomended Employee</span>
                                    </a>
                                </li>
                                <?php } } else { ?>
                                <li <?php if($seg1=='myjob') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">List of Bids</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-employee') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Recomended Employee</span>
                                    </a>
                                </li>
                                <?php } } else {
                                $get_sub_data = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
                                if(!empty($get_sub_data)) {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-jobs') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Recommended Jobs</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('jobbid')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-jobs') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('recommended-jobs')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Recommended Jobs</span>
                                    </a>
                                </li>
                                <?php } } else { ?>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-jobs') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Recommended Jobs</span>
                                    </a>
                                </li>
                                <?php } } 
                        } else {
                            if(@$_SESSION['afrebay']['userType']=='2') {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['companyname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['address']) || empty($profile_check[0]['teamsize'])  || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='myjob') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Applications to your jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-employee') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Ready for Interview</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='booking-history') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Booking History</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='myjob') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('myjob')?>"><i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('jobbid')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Applications to your jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-employee') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('recommended-employee')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Ready for Interview</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='booking-history') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('booking-history')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                    <span class="hidden-xs hidden-sm">Booking History</span>
                                    </a>
                                </li>
                                <?php } } else {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='jobbid') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('jobbid')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">My Jobs</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='recommended-jobs') { ?> class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('recommended-jobs')?>"><i class="fa fa-tasks" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Recommended Jobs</span>
                                    </a>
                                </li>
                                <?php } 
                            }
                        } ?>
                        

                        <?php 
                        if($get_setting->required_subscription == '1') {
                            if(@$_SESSION['afrebay']['userType']=='2') {
                                $get_sub_data = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
                                if(!empty($get_sub_data)) {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['companyname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['address']) || empty($profile_check[0]['teamsize'])  || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationv1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationv"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('chat')?>"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationv1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationv"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <?php } } else { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationv1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationv"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <?php } 
                            } else {
                                $get_sub_data = $this->db->query("SELECT * FROM employer_subscription WHERE employer_id='".$_SESSION['afrebay']['userId']."' AND (status = '1' OR status = '2')")->result_array();
                                if(!empty($get_sub_data)) {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationf1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationf"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='availability') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-calendar" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Availability</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='booking_history') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-list" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Booking History</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('chat')?>"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationf1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationf"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='availability') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('availability')?>"><i class="fa fa-calender" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Availability</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='booking_history') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('booking_history')?>"><i class="fa fa-list" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Booking History</span>
                                    </a>
                                </li>
                                <?php } } else { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationf1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationf"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='availability') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-calender" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Availability</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='booking_history') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-list" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Booking History</span>
                                    </a>
                                </li>
                                <?php } 
                            } 
                        }
                        else
                        {
                            if(@$_SESSION['afrebay']['userType']=='2') {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['companyname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['address']) || empty($profile_check[0]['teamsize'])  || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationv1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationv"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('chat')?>"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationv1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationv"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <?php } } else {
                                $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio'])) { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub1()"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationf1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationf"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='availability') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-calendar" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Availability</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='booking_history') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="javascript:void(0)" onclick="completeSub()"><i class="fa fa-list" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Booking History</span>
                                    </a>
                                </li>
                                <?php } else { ?>
                                <li <?php if($seg1=='chat') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('chat')?>"><i class="fa fa-commenting" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Messages</span>
                                        <?php
                                        $countMessage = $this->db->query("Select COUNT(id) as msgcount FROM chat WHERE userto_id ='".$_SESSION['afrebay']['userId']."' AND status = '0'")->result();
                                        if($countMessage[0]->msgcount != 0) { ?>
                                        <span class="notification notificationf1"><?php echo $countMessage[0]->msgcount;?></span>
                                        <?php } ?>
                                        <span class="notification notificationf"><?php echo $countMessage[0]->msgcount;?></span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='availability') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('availability')?>"><i class="fa fa-calendar" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Availability</span>
                                    </a>
                                </li>
                                <li <?php if($seg1=='booking_history') { ?>class="active" <?php } ?>>
                                    <span class="cover"></span>
                                    <a href="<?= base_url('booking_history')?>"><i class="fa fa-list" aria-hidden="true"></i>
                                        <span class="hidden-xs hidden-sm">Booking History</span>
                                    </a>
                                </li>
                                <?php } 
                            } 
                        } ?>
                    </ul>
                    <input type="hidden" name="userto_id" id="userto_id" value="<?php echo @$_SESSION['afrebay']['userId']?>">
                </div>
            </div>
<style>
    .completeSub {display: none; text-align: center; margin-top: 20px; color: #ed1c24; font-size: 20px;}
    .completeSub1 {display: none; text-align: center; margin-top: 20px; color: #ed1c24; font-size: 20px;}
    .User_Sidemenu .hidden-xs.display-table-cell .navi ul li a { padding: 15px 15px !important; }
    .dashboard-gig .hidden-xs {font-size: 13px !important;}

    <?php if($_SESSION['afrebay']['userType'] == '2') { ?>
    /* Theme 1 */
    .dashboard-gig.EmployersTheme,
    .dashboard-gig.EmployersTheme .cardak,
    .dashboard-gig.EmployersTheme .navi ul li span.cover,
    .dashboard-gig.EmployersTheme .navi ul li.active a,
    .dashboard-gig.EmployersTheme .navi ul li a:hover,
    .dashboard-gig.EmployersTheme .navi ul,
    .dashboard-gig.EmployersTheme .navi ul li a {background: #def7ff !important; color: #39839b !important;}
    .dashboard-gig.EmployersTheme .navi ul li a i {color: #39839b !important;}
    .dashboard-gig.EmployersTheme hr {border-top: 1px solid #39839b !important;}
    .dashboard-gig.EmployersTheme .form-design form .cardak .profile-dsd input {background: #fff !important;}
    .dashboard-gig.EmployersTheme .text-success-msg {color: #39839b !important;}
    <?php } else if($_SESSION['afrebay']['userType'] == '3') {?>
     /* Theme 2 */
    .dashboard-gig.ExpertsTheme,
    .dashboard-gig.ExpertsTheme .cardak,
    .dashboard-gig.ExpertsTheme .navi ul li span.cover,
    .dashboard-gig.ExpertsTheme .navi ul li.active a,
    .dashboard-gig.ExpertsTheme .navi ul li a:hover,
    .dashboard-gig.ExpertsTheme .navi ul,
    .dashboard-gig.ExpertsTheme .navi ul li a {background: #f0fff0 !important; color: #318131 !important;}
    .dashboard-gig.ExpertsTheme .navi ul li a i {color: #318131 !important;}
    .dashboard-gig.ExpertsTheme hr {border-top: 1px solid #318131 !important;}
    .dashboard-gig.ExpertsTheme .form-design form .cardak .profile-dsd input {background: #fff !important;}
    .dashboard-gig.EmployersTheme .text-success-msg {color: #318131 !important;}
    <?php } else { ?>
    .dashboard-gig.EmployeesTheme,
    .dashboard-gig.EmployeesTheme .cardak,
    .dashboard-gig.EmployeesTheme .navi ul li span.cover,
    .dashboard-gig.EmployeesTheme .navi ul li.active a,
    .dashboard-gig.EmployeesTheme .navi ul li a:hover,
    .dashboard-gig.EmployeesTheme .navi ul,
    .dashboard-gig.EmployeesTheme .navi ul li a {background: #fff !important;}
    .dashboard-gig.EmployeesTheme .navi ul li.active a,
    .dashboard-gig.EmployeesTheme .navi ul li a:hover,
    .dashboard-gig.EmployeesTheme .navi ul li a {color: #ED1C24 !important;}
    .dashboard-gig.EmployeesTheme .navi ul li a i {color: #ED1C24 !important;}
    .dashboard-gig.EmployeesTheme hr {border-top: 1px solid #ddd !important;}
    .dashboard-gig.EmployeesTheme .form-design form .cardak .profile-dsd input,
    .dashboard-gig.EmployeesTheme .Admin_Profile .cardak .gender select {background: #fff !important;}
    .dashboard-gig.EmployeesTheme .Admin_Profile .cardak .key-skill .pf-field {padding: 0 !important;}
    .dashboard-gig.EmployeesTheme .text-success-msg {color: #ED1C24 !important;}
    <?php } ?>
</style>
<script>
function completeSub() {
    $('.completeSub').show();
    setTimeout(function(){
        $('.completeSub').fadeOut('slow');
    },4000);
}

function completeSub1() {
    $('.completeSub1').show();
    setTimeout(function(){
        $('.completeSub1').fadeOut('slow');
    },4000);
}

function load_unseen_notification() {
    $('.notificationv1').hide();
    $('.notificationf1').hide();
    var userId = "<?php echo @$_SESSION['afrebay']['userId']?>";
    $.ajax({
        url:"<?= base_url('user/dashboard/showmessage_count') ?>",
        method:"POST",
        data:{userId:userId},
        dataType:"json",
        success:function(data) {
            //console.log(userId);
            //console.log(data);
            <?php if(@$_SESSION['afrebay']['userType']=='2') { ?>
            if(data.count > 0) {
                $('.notificationv').show();
                $('.notificationv').text(data.count);
            } else {
                $('.notificationv').hide();
            }
            <?php } else { ?>
            if(data.count > 0) {
                $('.notificationf').show();
                $('.notificationf').text(data.count);
            } else {
                $('.notificationf').hide();
            }
            <?php } ?>
        }
    });
}

$(document).ready(function(){
    $('.notificationv').hide();
    $('.notificationf').hide();
    setInterval(function(){
        load_unseen_notification();
    }, 5000);
})
</script>
