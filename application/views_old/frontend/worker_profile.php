<?php
if (!empty($get_banner->image) && file_exists('uploads/banner/' . $get_banner->image)) {
    $banner_img = base_url("uploads/banner/" . $get_banner->image);
} else {
    $banner_img = base_url("assets/images/resource/mslider1.jpg");
} ?>

<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Employee Details</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="overlape freelancer-details-page">
    <div class="block remove-top Worker_Detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="cand-single-user"> -->
                    <div class="worker_cand-single-user">
                        <div class="row m-0">
                            <div class="col-lg-2 col-md-4 col-sm-12">
                                <div class="can-detail-s">
                                    <div class="cst">
                                        <?php if (!empty($user_detail->profilePic) && file_exists('uploads/users/' . @$user_detail->profilePic)) { ?>
                                            <img src="<?= base_url('uploads/users/' . @$user_detail->profilePic) ?>" alt="" />
                                        <?php } else { ?>
                                            <img src="<?= base_url('uploads/users/user.png') ?>" alt="" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-4 col-sm-12 Worker_Head_Text">
                                <div class="Worker_Head_Text_Data">
                                    <h3><?php if (!empty($user_detail->firstname)) {
                                            echo $user_detail->firstname . ' ' . $user_detail->lastname;
                                        } else {
                                            echo $user_detail->username;
                                        } ?></h3>
                                    <p>Member Since, <?= date('Y', strtotime(@$user_detail->created)) ?></p>
                                    <p><i class="la la-map-marker"></i><?= @$user_detail->address ?></p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 Worker_Head_Social">
                                <div class="Worker_Head_Social_Data">
                                    <div class="download-cv">
                                        <a class="btn btn-info" href="<?= base_url('uploads/users/resume/' . @$user_detail->resume) ?>" title="" download>Download CV <i class="la la-download"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <ul class="cand-extralink">
                        <li><a href="#about" title="">About</a></li>
                        <li><a href="#education" title="">Education</a></li>
                        <li><a href="#experience" title="">Work Experience</a></li>
                        <li><a href="#skills" title="">Professional Skill Set</a></li>
                    </ul>
                    <div class="cand-details-sec">
                        <div class="row">
                            <div class="col-lg-8 column">
                                <div class="cand-details" id="about">
                                    <h2>About This Employee</h2>
                                    <p>
                                        <?= @$user_detail->short_bio; ?>
                                    </p>

                                    <div class="edu-history-sec" id="education">
                                        <h2>Education</h2>
                                        <?php if (!empty($user_education)) {
                                            foreach ($user_education as $edu) { ?>
                                                <div class="edu-history">
                                                    <i class="la la-graduation-cap"></i>
                                                    <div class="edu-hisinfo">
                                                        <h3><?= ucfirst($edu->education) ?> in <?= $edu->department ?> depertment</h3>
                                                        <i><?= $edu->passing_of_year ?></i>
                                                        <span><?= $edu->college_name ?></span>
                                                        <p><?= $edu->description ?></p>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                    <div class="edu-history-sec" id="experience">
                                        <h2>Work & Experience</h2>
                                        <?php if (!empty($user_work)) {
                                            foreach ($user_work as $row) { ?>
                                                <div class="edu-history style2">
                                                    <i></i>
                                                    <div class="edu-hisinfo">
                                                        <h3><?= ucfirst($row->designation) ?><span><?= $row->company_name ?></span></h3>
                                                        <i><?= date('d-m-Y', strtotime($row->from_date)) . ' to ' . date('d-m-Y', strtotime($row->to_date)) ?></i>
                                                        <p><?= $row->description ?></p>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                    <?php if (!empty($user_detail->skills)) { ?>
                                    <div class="progress-sec" id="skills">
                                        <h2>Professional Skill Set</h2>
                                        <div class="progress-sec" style="text-transform: uppercase;">
                                            <span><?= @$user_detail->skills ?></span>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-4 column">
                                <div class="job-overview">
                                    <h3>Candidate Overview</h3>
                                    <ul>
                                        <li>
                                            <i class="la la-mars-double"></i>
                                            <h3>Gender</h3>
                                            <span><?= @$user_detail->gender ?></span>
                                            <input type="hidden" name="rateperhour" id="rateperhour" value="<?= @$user_detail->rateperhour?>">
                                        </li>
                                    </ul>
                                </div>
                                <!-- Calender -->
                                <div class="Calender_Pick" id="calendar"></div>
                                <?php 
                                if (!empty(@$_SESSION['afrebay']['userId'])) { 
                                    $checkBookSlot = $this->db->query("SELECT user_availability.id as avail_id, user_availability.user_id, user_availability.start_date, user_availability.from_time, user_availability.end_date, user_availability.to_time, user_booking.id as boooking_id, user_booking.employee_id, user_booking.employer_id, user_booking.available_id, user_booking.bookingTime FROM user_booking JOIN user_availability ON user_availability.id = user_booking.available_id WHERE user_booking.employer_id = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                    if(!empty($checkBookSlot)) {
                                        $availability = $this->db->query("SELECT user_availability.id as avail_id, user_availability.user_id, user_availability.start_date, user_availability.from_time, user_availability.end_date, user_availability.to_time, user_booking.id as boooking_id, user_booking.employee_id, user_booking.employer_id, user_booking.available_id, user_booking.bookingTime FROM user_booking JOIN user_availability ON user_availability.id = user_booking.available_id WHERE user_booking.employer_id = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                                        if(!empty($availability)) { ?>
                                        <div class="job-overview" style="height: 382px; overflow: auto; margin-top: 0px;">
                                            <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">Start Date</p>
                                            <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">From Time</p>
                                            <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">To Time</p>
                                            <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">End Date</p>
                                            <?php $i=1; 
                                            foreach ($availability as $value) { ?>
                                            <!-- <div> -->
                                                <div class="job-overview" style="width: 80%; background: #c7c7c7; margin: 0 0 5px 0 !important; padding: 0px; cursor: pointer;">
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('d-m-Y', strtotime($value['start_date']));?></p>
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('h:i A', strtotime($value['from_time']))?></p>
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('h:i A', strtotime($value['to_time']));?></p>
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('d-m-Y', strtotime($value['end_date']))?></p>
                                                </div>
                                                <div class="job-overview job_overview_main" id="job_overview_main_<?= $i?>" style="width: 15%; background: #c7c7c7; margin: 0 0 5px 10px !important; padding: 0px; cursor: pointer;">
                                                    <p style="width: 100%; display: inline-block; float: left; text-align: center; color: #000; font-size: 13px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">View</p>
                                                </div>
                                            <!-- </div> -->
                                            <div style="width: 100%;display: inline-block;background: #e1dfdf;margin: 0 0 5px 0;border-radius: 10px;padding: 10px;text-align: center;" id="job_overview_sub_<?= $i?>" class="job_overview_sub">
                                            <?php $getBookSlot = $this->db->query("SELECT * FROM user_booking WHERE employer_id ='".@$_SESSION['afrebay']['userId']."' and available_id = '".$value['avail_id']."'")->result_array();
                                            //echo "<pre>"; print_r($getBookSlot);
                                            $bookingTime = $getBookSlot[0]['bookingTime'];
                                            $bookingTime = explode(',', $bookingTime);
                                            if(!empty($getBookSlot)) { ?>
                                                <div style="width: 100%; display: inline-block;">
                                                    <div>Booked Slot</div>
                                                    <?php for($i = 0; $i < count($bookingTime); $i++) { 
                                                    $getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '".$getBookSlot[0]['employer_id']."'")->result_array();?>
                                                    <div>
                                                        <p style="width: 50%;display: inline-block;float: left;margin: 0px;font-size: 14px;"><?= date('h:i A', strtotime($bookingTime[$i]))?> to <?= date('h:i A', strtotime($bookingTime[$i]) + 60*60)?></p>
                                                    </div>
                                                    <?php } ?>
                                                    <div>
                                                        <p style="width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;">Total Rate: <?= count($bookingTime)*@$user_detail->rateperhour?></p>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <p style="margin: 0px;">No slot booked for this date</p>
                                            <?php } ?>
                                            </div>
                                            <?php $i++; } ?>
                                        </div>
                                        <input type="hidden" name="bookTime" id="bookTime" value="">
                                        <?php } else { ?>
                                        <div class="job-overview" style="text-align: center;">No data added for availability</div>
                                        <?php } } else { ?>
                                        <div class="job-overview" style="height: auto; overflow: auto; margin-top: 0px; text-align: center;">No slot booked</div>
                                    <?php } } ?> 

                                <?php if (!empty($_SESSION['afrebay']['userId']) && $_SESSION['afrebay']['userType'] == 2) { ?>
                                <div class="quick-form-job">
                                    <h3>Rate This Freelancer</h3>
                                    <form method="post" action="<?= base_url('user/dashboard/save_employer_rating') ?>">
                                        <div class="row m-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <span class="star-rating star-5">
                                                    <input type="radio" name="rating" value="1"><i></i>
                                                    <input type="radio" name="rating" value="2"><i></i>
                                                    <input type="radio" name="rating" value="3"><i></i>
                                                    <input type="radio" name="rating" value="4"><i></i>
                                                    <input type="radio" name="rating" value="5"><i></i>
                                                </span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 Form_Subject">
                                                <input type="text" placeholder="Enter Subject" name="subject" required />
                                                <input type="hidden" value="<?= @$user_detail->userId ?>" name="user_id">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 Form_Textarea">
                                                <textarea placeholder="Enter review" name="review"></textarea>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 Form_Btn">
                                                <button class="submit btn btn-info">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['afrebay']['userId']?>">
<?php //if($_SESSION['afrebay']['userId'] == 1) { ?>
<!-- Calender Add modal -->
<div class="modal fade edit-form" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Add Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class="alert alert-danger " role="alert" id="danger-alert" style="display: none;">
                        End date should be greater than start date.
                    </div>
                    <div class="form-group">
                        <label for="start-date">Start date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start-date" id="start-date" placeholder="start-date" required>
                    </div>
                    <div class='form-group date'>
                        <table class="table jobsites" id="purchaseTableclone1">
                            <tr class="color">
                                <th>Time <span style="color:red;">*</span></th>
                                <th><button type="button" class="btn btn-info addMoreBtn" onclick="add_row()">Add</button></th>
                            </tr>
                            <tbody id="clonetable_feedback1">
                                <tr>
                                    <td><input type="time" name="time" id="time1" class="form-control" required></td>
                                    <td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(this)">X</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="end-date">End date</label>
                        <input type="date" class="form-control" name="end-date" id="end-date" placeholder="end-date">
                    </div>
                    <div class="form-group">
                        <label for="event-color">Color</label>
                        <input type="color" class="form-control" id="event-color" value="#3788d8">
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <!-- <button type="submit" class="btn btn-success" id="submit-button1">Schedule</button> -->
                    <input type="button" class="btn btn-success" id="submit-button" value="Schedule">
                </div>
            </form>
        </div>
    </div>
    <script>
        function add_row() {
            var y=document.getElementById('clonetable_feedback1');
            var new_row = y.rows[0].cloneNode(true);
            var len = y.rows.length;
            new_number=Math.round(Math.exp(Math.random()*Math.log(10000000-0+1)))+0;
            var inp3 = new_row.cells[0].getElementsByTagName('input')[0];
            inp3.value = '';
            inp3.id = 'service'+(len+1);
            var submit_btn =$('#submit').val();
            y.appendChild(new_row);
        }

        function remove(row) {
            var y=document.getElementById('purchaseTableclone1');
            var len = y.rows.length;
            if(len>2) {
                var i= (len-1);
                document.getElementById('purchaseTableclone1').deleteRow(i);
            }
        }
    </script>
</div>

<div class="modal fade edit-form" id="bookingmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Book Slot</h5>
                <button type="button" class="bookBtn-close btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeBook()"></button>
            </div>
            <form id="myForm" class="avail_time">
                <div class="modal-body">
                    <div class="alert alert-danger " role="alert" id="danger-alert" style="display: none;">
                        End date should be greater than start date.
                    </div>
                    <div class='form-group date'>
                        <table class="table jobsites" id="purchaseTableclone1">
                            <tr class="color" style="text-align: center;">
                                <th>Available Time<span style="color:red;">*</span></th>
                            </tr>
                            <tbody id="clonetable_feedback1" class="bookingcontent">
                                <input type="hidden" name="avail_id" id="avail_id" value="">
                                <input type="hidden" name="start_date" id="start_date" value="">
                                <input type="hidden" name="from_time" id="from_time" value="">
                                <input type="hidden" name="end_date" id="end_date" value="">
                                <input type="hidden" name="to_time" id="to_time" value="">
                                <input type="hidden" name="userID" id="userID" value="<?= @$user_detail->userId?>">
                                <input type="hidden" name="employerID" id="employerID" value="<?= @$_SESSION['afrebay']['userId']?>">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <!-- <button type="submit" class="btn btn-success" id="submit-button1">Schedule</button> -->
                    <input type="button" class="btn btn-success" id="submit-button" value="Book Now" onclick="aggrement1()">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit-form" id="aggrementmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content" style="width: 510px; height: 620px; overflow: auto;">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">User's Aggrement</h5>
                <button type="button" class="bookBtn-close btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeaggrmnt()"></button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class='form-group date'>
                        <?php 
                        $privacy = $this->db->query("SELECT `title`, `description` FROM manage_cms WHERE id = '3'")->result_array();
                        $terms = $this->db->query("SELECT `title`, `description` FROM manage_cms WHERE id = '1'")->result_array();
                        ?>
                        <div>
                            <p><?= ucwords($privacy[0]['title']); ?></p>
                            <div><?= ucwords($privacy[0]['description']); ?></div>
                        </div>
                        <div>
                            <p><?= ucwords($terms[0]['title']); ?></p>
                            <div><?= ucwords($privacy[0]['description']); ?></div>
                        </div>
                    </div>
                    <div class="form-group date">
                        <input type="checkbox" id="aggrchck" name="vehicle2" value="1" style="opacity: 1; z-index: 50; margin-top: 9px;">
                        <p style="display: inline-block; margin-left: 25px; margin-top: 0px; margin-bottom: 0px;" class="user_aggrmnt">I have read and agree to PayperLLC aggrement and Policy.</p>
                        <p class="erroraggr" style="margin: 0;width: 100%;text-align: center;color: red;font-size: 12px;">Please check the checkbox.</p>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <!-- <button type="submit" class="btn btn-success" id="submit-button1">Schedule</button> -->
                    <input type="button" class="btn btn-success" id="submit-button" value="Next" onclick="bookNow()">
                </div>
            </form>
        </div>
    </div>
</div>
<?php //} ?>
<style>
    .dashboard-gig a:focus, a:hover, a {text-decoration: none !important;}#calendar {width: 100%;margin: 0;box-shadow: 0 0 10px #dddddd;display: inline-block;padding: 20px;border-radius: 10px;margin-bottom: 20px;}.fc-event {border: 1px solid #eee !important;}.fc-content {padding: 3px !important;}.fc-content .fc-title {display: block !important;overflow: hidden;text-align: center;font-size: 12px;font-weight: 500;text-align: center;}.fc-customButton-button {font-size: 13px !important;position: absolute;top: 60px;left: 50%;transform: translateY(-50%);}.form-group {margin-bottom: 1rem;}.form-group>label {margin-bottom: 10px;}#delete-modal .modal-footer>.btn {border-radius: 3px !important;padding: 0px 8px !important;font-size: 15px;}.fc-scroller {overflow-y: hidden !important;}.context-menu {position: absolute;z-index: 1000;background-color: #fff;border: 1px solid #ccc;border-radius: 4px;box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);padding: 5px;}.context-menu ul {list-style-type: none;margin: 0;padding: 0;}.context-menu ul>li {display: block;padding: 5px 15px;list-style-type: none;color: #333;display: block;cursor: pointer;margin: 0 auto;transition: 0.10s;font-size: 13px;}.context-menu ul>li:hover {color: #fff;background-color: #007bff;border-radius: 2px;}.fa, .fas {font-size: 13px;margin-right: 4px;}button:focus {box-shadow: none !important;}.Calender_Pick .fc-header-toolbar {display: flex;flex-direction: column;}.Calender_Pick .fc-header-toolbar {display: flex;flex-direction: column;margin-bottom: 0px !important;}.Calender_Pick .fc-left {width: 100%;height: 35px;display: flex;justify-content: flex-start;align-items: flex-start;}.Calender_Pick .fc-left h2 {font-weight: 600;font-size: 18px;}.Calender_Pick .fc-center {position: relative;height: 45px;width: 100%; display: none;}.Calender_Pick .fc-center button {transform: translateY(0);position: absolute;top: 0;height: 35px;left: 0;width: 100px;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;font-size: 13px !important;}.Calender_Pick .fc-right {width: 100%;height: 45px;display: flex;align-items: flex-start;justify-content: space-between;}.Calender_Pick .fc-right button {border: 0;height: 35px;width: 100px;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;opacity: 1;font-size: 13px !important;}.Calender_Pick .fc-button-group {height: 35px;border-radius: 50px;}.Calender_Pick .fc-button-group button {background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;display: flex;align-items: center;justify-content: center;width: 60px !important;}.Calender_Pick .fc-button-group button span {font-size: 13px;}.Calender_Pick .fc-day-grid-container {height: auto !important;border-bottom: 1px solid #ddd;}.Calender_Pick .fc-view-container .fc-head-container {color: #ED1C24 !important;}div.modal.edit-form.Modal_Show {display: flex !important;align-items: center;justify-content: center;}.edit-form .modal-content {width: 500px;}.edit-form .modal-content .modal-body {border-radius: 0;}.edit-form .modal-content #myForm .form-group label {padding: 0;font-size: 16px;}.edit-form .modal-content #myForm .form-group #event-title {padding: 10px !important;font-size: 15px;}.edit-form .modal-content .modal-footer button {height: 35px;display: flex;align-items: center;justify-content: center;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;letter-spacing: 1px;}
    #err-messages{display: none; text-align: center;}
    #submit-button {/*height: 35px !important;*/display: flex !important;align-items: center !important;justify-content: center !important;border-radius: 50px !important;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0 !important;letter-spacing: 1px !important;}
    .jconfirm-content-pane {text-align: center !important;}
    /*.jconfirm-buttons {margin-right: 21% !important;}*/
    .fc .fc-row .fc-content-skeleton table, .fc .fc-row .fc-content-skeleton td, .fc .fc-row .fc-helper-skeleton td {padding: 0px !important;}
    .fc-event:before, .fc-event-dot:before {bottom: -3px !important; width: 45px !important;}
    .fc-content .fc-title {font-size: 9px !important;}
    .jobsites tbody td {padding: 5px;}
    .jobsites tbody td input {position: unset; opacity: 1; margin-right: 10px;}
    .jconfirm.jconfirm-white .jconfirm-box .jconfirm-buttons button.btn-default, .jconfirm.jconfirm-light .jconfirm-box .jconfirm-buttons button.btn-default {float: left;}
    .paynow_btn {margin-right: 130px !important;}
    .prompt_login {margin-right: 156px !important;}
    .book_warning {margin-right: 160px !important;}
    .paydone_btn {margin-right: 160px !important;}
</style>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css'>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/uuid@8.3.2/dist/umd/uuidv4.min.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
function availTime(start_date, from_time, end_date, to_time, bookingTime) {
    from_time = from_time.replace(':00', '').trim();
    to_time =  to_time.replace(':00', '').trim();
    var arr = [];
    for( var i=from_time; i<=to_time; i++ ) {
        arr.push(i+":00");
    }
    var str = arr.toString();
    var output= str.split(',');
    var bookingTime = bookingTime.toString();
    var bookingTime = bookingTime.split(',');

    $.each(output,function(i) {
        if(bookingTime.indexOf(output[i]) != -1) {
            $('.bookingcontent').append('<tr><td class="pastHours"><input type="checkbox" class="pasthours" id="pastHours_'+output[i].replace(':00', '').trim()+'" name="pastHours[]" value="'+output[i]+'" required checked onclick="removeSlot('+output[i].replace(':00', '').trim()+')">'+output[i]+'</td></tr>');
        } else {
            $('.bookingcontent').append('<tr><td class="pastHours"><input type="checkbox" class="pasthours" id="pastHours_'+output[i].replace(':00', '').trim()+'" name="pastHours[]" value="'+output[i]+'" required onclick="removeSlot('+output[i].replace(':00', '').trim()+')">'+output[i]+'</td></tr>');
        }
    });
}

function aggrement1() {
    const aggrementmodal = new bootstrap.Modal(document.getElementById('aggrementmodal'));
    aggrementmodal. show();
}

function bookNow() {
    if($("#aggrchck").is(":checked")) { 
        var avail_id = $('#avail_id').val();
        var startDate = $('#start_date').val();
        var employeeID = $('#userID').val();
        var employerID = $('#employerID').val();
        var bookTime = [];
        $(".pasthours:checked").each(function(){
            bookTime.push($(this).val());
        });
        var arr = [];
        var bookTime = bookTime.toString();
        var output = bookTime.split(',');
        //alert(output.length);
        $.each(output,function(i) {
            s_time = parseFloat(output[i]) + 1;
            arr.push("<div>"+output[i]+" to "+s_time+":00</div>");
        });
        var rate = output.length * $('#rateperhour').val();
        var finalrate = "<div><p style='color: #000;'>Total Rate: "+rate+"</p><div>";
        finalshow = arr.join('')+ "" + finalrate;
        $('#bookTime').val(bookTime);
        $.ajax({
            type:"post",
            url:"<?php echo base_url()?>user/Dashboard/addBookingTimeData",
            data:{avail_id: avail_id, startDate: startDate, employeeID: employeeID, employerID: employerID, bookTime: bookTime},
            success:function(returndata) {
                if(returndata == 1) {
                    $.confirm({
                        title: '',
                        content: finalshow+" Pay now to book your slot.",
                        buttons: {
                            somethingElse: {
                                text: 'Pay Now',
                                btnClass: 'btn-secondary paynow_btn',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    $.ajax({
                                        type:"post",
                                        url:"<?php echo base_url()?>user/Dashboard/paymentforslotbook",
                                        data:{avail_id: avail_id, employeeID: employeeID, employerID: employerID, rate: rate},
                                        success:function(returndata) {
                                            if(returndata == 1) {
                                                $.confirm({
                                                    title: '',
                                                    content: rate+" Paid. Your slot booked successfuly.",
                                                    buttons: {
                                                        somethingElse: {
                                                            text: 'Ok',
                                                            btnClass: 'btn-secondary paydone_btn',
                                                            keys: ['enter', 'shift'],
                                                            action: function(){
                                                                location.reload();
                                                            }
                                                        }
                                                    }
                                                });
                                            } else {
                                                $.alert({
                                                    title: '',
                                                    content: "Something went wrong. Please try again later.",
                                                });
                                                return false;
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    });
                } else {
                    $.alert({
                        title: '',
                        content: "Something went wrong. Please try again later.",
                    });
                    return false;
                }
            }
        });
    } else {
        $('.erroraggr').show();
        setTimeout(() => {
            $('.erroraggr').hide();
        }, 5000);
    }
}

$(window).on('load', function() {
    $(".fc-center button").click(function() {
        $(".edit-form").addClass("Modal_Show");
    });

    $(".edit-form .btn-close").click(function() {
        $(".edit-form").removeClass("Modal_Show");
    });
});

function closeBook() {
    location.reload();
}

function closeaggrmnt() {
    location.reload();
}

function bookSlot(id) {
    //alert(id);
    var available_id = id;
    var employee_id = $('#employee_id').val();
    var employer_id = $('#employer_id').val();
    $.ajax({
        type:"post",
        url:"<?php echo base_url()?>user/Dashboard/bookSlotforuser",
        data:{available_id: available_id, employee_id: employee_id, employer_id: employer_id},
        success:function(returndata) {
            if(returndata == 1) {
                $.confirm({
                    title: '',
                    content: "Slot Booked successfuly",
                    buttons: {
                        somethingElse: {
                            text: 'Ok',
                            btnClass: 'btn-secondary',
                            keys: ['enter', 'shift'],
                            action: function(){
                                location.reload();
                            }
                        }
                    }
                });
            } else {
                $.alert({
                    title: '',
                    content: "Something went wrong. Please try again later.",
                });
                return false;
            }
        }
    });
} 

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const myModal = new bootstrap.Modal(document.getElementById('form'));
    const dangerAlert = document.getElementById('danger-alert');
    const close = document.querySelector('.btn-close');
    //const bookclose = document.querySelector('.bookBtn-close');
    const bookingModal = new bootstrap.Modal(document.getElementById('bookingmodal'));
    const myEvents =[
        <?php 
        if(!empty($_SESSION['afrebay']['userId'])) {
        $availability = $this->db->query("SELECT * FROM user_availability WHERE user_id = '".$user_detail->userId."'")->result_array();
        if(!empty($availability)) { 
        foreach ($availability as $value) { 
        $checkBookSlot = $this->db->query("SELECT * FROM user_booking WHERE available_id ='".$value['id']."'")->result_array(); 
        if(!empty($checkBookSlot)) { ?>
        {
            title:'Booked',
            start: '<?= date('Y-m-d', strtotime($value['start_date']))?>',
            end: '<?= date('Y-m-d', strtotime($value['end_date']))?>',
            backgroundColor: 'red'
        },
        <?php } else { ?>
        {
            title:'Available',
            start: '<?= date('Y-m-d', strtotime($value['start_date']))?>',
            end: '<?= date('Y-m-d', strtotime($value['end_date']))?>',
            backgroundColor: 'green'
        },
        <?php } } } } ?>
    ];
    const calendar = new FullCalendar.Calendar(calendarEl, {
        customButtons: {
            customButton: {
                text: 'Availability',
                click: function() {
                    <?php if(!empty($_SESSION['afrebay']['userId'])) { ?>
                        myModal.show();
                    <?php } else { ?>
                        window.location.href = "<?php echo base_url('login')?>";
                    <?php } ?>
                    const modalTitle = document.getElementById('modal-title');
                    const submitButton = document.getElementById('submit-button');
                    modalTitle.innerHTML = 'Availability'
                    submitButton.innerHTML = 'Availability'
                    submitButton.classList.remove('btn-primary');
                    submitButton.classList.add('btn-success');
                    close.addEventListener('click', () => {
                        myModal.hide();
                        //bookingModal.hide();
                    })
                }
            }
        },
        header: {
            center: 'customButton',
            right: 'today, prev,next '
        },
        plugins: ['dayGrid', 'interaction'],
        selectable: true,
        events: myEvents,
    });
    calendar.on('select', function(info) {
    <?php if(@$_SESSION['afrebay']['userType'] == '2') { ?>
        bookingModal.show();
        const startDateInput = document.getElementById('start-date');
        startDateInput.value = info.startStr;
        userID = $('#userID').val();
        $.ajax({
            type:"post",
            url:"<?php echo base_url()?>user/Dashboard/getUserAvailability",
            data:{start_date: startDateInput.value, end_date: startDateInput.value, userID: userID},
            success:function(returndata) {
                var json = $.parseJSON(returndata);
                //console.log(json.length);
                if(json.length > 0) {
                    //console.log("result===>", json);
                    $('#avail_id').val(json[0].id);
                    $('#start_date').val(json[0].start_date);
                    $('#from_time').val(json[0].from_time);
                    $('#end_date').val(json[0].end_date);
                    $('#to_time').val(json[0].to_time);
                    var booking_Time = [];
                    for(let b = 0; b < json.length; b++) {
                        booking_Time.push(json[b].bookingTime);
                    }
                    availTime(json[0].start_date, json[0].from_time, json[0].end_date, json[0].to_time, booking_Time);
                } else {
                    /*setTimeout(function() {
                        $('#myForm').append('<div>No slot available for this date</div>');
                    }, 3000)*/
                    $('.avail_time').html('<div style="text-align: center; padding: 0 0 50px 0;">No slot available for this date</div>');
                }
            }
        });
    <?php } else if(@$_SESSION['afrebay']['userType'] == '1') { ?>
    $.confirm({
        title: '',
        content: "Booking feature is not available for employee",
        buttons: {
            somethingElse: {
                text: 'Ok',
                btnClass: 'btn-secondary book_warning',
                keys: ['enter', 'shift'],
                action: function(){
                    location.reload();
                }
            }
        }
    });
    <?php } else { ?>
    $.confirm({
        title: '',
        content: "Please login to book your slots",
        buttons: {
            somethingElse: {
                text: 'Ok',
                btnClass: 'btn-secondary prompt_login',
                keys: ['enter', 'shift'],
                action: function(){
                    location.reload();
                }
            }
        }
    });
    <?php } ?>
    });
    calendar.render();
});

$(document).ready(function() {
    $('.erroraggr').hide();
    <?php $i=1; 
    foreach ($availability as $value) { ?>
    $('#job_overview_sub_<?= $i?>').hide();
    $('#job_overview_main_<?= $i?>').on('click', function() {
        $('#job_overview_sub_<?= $i?>').toggle();
    })
    <?php $i++; } ?> 
})

function removeSlot(id) {
    if($("#pastHours_"+id)[0].checked) {
        return false;
    } else {
        $.confirm({
            title: '',
            content: "Are you sure you want to remove this slot?",
            buttons: {
                confirm: function() {
                    $("#pastHours_"+id).removeAttr('checked');
                    return true;
                },
                cancel: function() {
                    $("#pastHours_"+id).prop("checked", true);
                },
            }
        });
    }
}
</script>