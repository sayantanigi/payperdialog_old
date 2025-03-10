<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url(<?php echo base_url()?>assets/images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header" style="padding-top: 90px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dashboardhak">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Add Education</h2>
                <!-- <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Education</li>
                    </ol>
                </nav> -->
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('sidebar');?>
<div class="col-md-7 col-sm-12 display-table-cell v-align form-design">
    <div class="user-dashboard">
        <form class="form" action="<?= $action; ?>" method="post" id="registrationForm" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="cardak profile-mobile">
                        <div class="container bootstrap snippet">
                            <div class="new-pro">
                                <a href="#" class="pull-right"></a>
                            </div>
                        </div>
                        <div class="profile-dsd">
                            <div class="tab-content">
                                <div class="tab-pane active" style="padding: 0px;">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="first_name"><h4>Degree <span style="color: red">*</span></h4></label>
                                                <!-- <input type="text" class="form-control" name="education" placeholder="Enter Degree" value="<?= @$education; ?>" required list="education" autocomplete="off"/> -->
                                                <select class="form-control" name="education" required>
                                                    <option value="">Select Degree</option>
                                                    <option value="Professional Certificate" <?php if($education == "Professional Certificate") { echo "selected"; }?>>Professional Certificate</option>
                                                    <option value="Undergraduate Degrees" <?php if($education == "Undergraduate Degrees") { echo "selected"; }?>>Undergraduate Degrees</option>
                                                    <option value="Transfer Degree" <?php if($education == "Transfer Degree") { echo "selected"; }?>>Transfer Degree</option>
                                                    <option value="Associate Degree" <?php if($education == "Associate Degree") { echo "selected"; }?>>Associate Degree</option>
                                                    <option value="Bachelor Degree" <?php if($education == "Bachelor Degree") { echo "selected"; }?>>Bachelor Degree</option>
                                                    <option value="Graduate Degrees" <?php if($education == "Graduate Degrees") { echo "selected"; }?>>Graduate Degrees</option>
                                                    <option value="Master Degree" <?php if($education == "Master Degree") { echo "selected"; }?>>Master Degree</option>
                                                    <option value="Doctoral Degrees" <?php if($education == "Doctoral Degrees") { echo "selected"; }?>>Doctoral Degrees</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name"><h4>Year of Graduation <span style="color: red">*</span></h4></label>
                                                <input type="text" class="form-control" name="passing_of_year" id="passing_of_year" placeholder="Enter the Year of Graduation"  value="<?= @$passing_of_year; ?>" required list="passing_of_year" autocomplete="off" onkeypress="only_number(event)" maxlength = '4'/>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name"><h4>College/School/University Name <span style="color: red">*</span></h4></label>
                                                <input type="text" class="form-control" name="college_name" placeholder="Enter College/School/University Name"  value="<?= $college_name; ?>" required list="college_name" autocomplete="off"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name"><h4>Department <span style="color: red">*</span></h4></label>
                                                <input type="text" class="form-control" name="department" placeholder="Enter Department"  value="<?= @$department; ?>" required list="department" autocomplete="off"/>
                                                </div>
                                                <div class="col-lg-12"><br>
                                                    <label for="first_name"><h4>Description </h4></label>
                                                    <textarea type="text" class="form-control" name="description" maxlength="500" id="description" value="<?= $description; ?>" ><?= @$description; ?></textarea>
                                                    <div id="the-count">
                                                    <span id="current">0</span>
                                                    <span id="maximum">/ 500</span>
                                                </div>
                                                </div>
                                                <input type="hidden" name="id" value="<?= @$id; ?>">
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-xs-12 aksek">
                                            <button class="post-job-btn pull-right" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if(@$_SESSION['afrebay']['userType']=='1' || @$_SESSION['afrebay']['userType']=='3') { ?>
<div class="col-md-3 col-6 v-align CustomDesign" style="display: inline-block; float: left; margin-top: 10px;">
    <p class="CustomPara">Upcoming Booking</p>
    <div class="CustomBlock">
        <?php
        $selectDate = date('Y-m-d');
		$employeeId = $_SESSION['afrebay']['userId'];
        $availableData = $this->db->query("SELECT user_availability.*, user_booking.* FROM user_availability JOIN user_booking ON user_availability.id = user_booking.available_id WHERE start_date > '".$selectDate."' AND user_id ='".@$employeeId."'")->result_array();
        foreach ($availableData as $value) { ?>
        <p class="ParaHeading"><?= $value['start_date']?></p>
        <div style='width: 100%; display: inline-block; padding: 0 10px; margin-bottom: 20px;'>
            <div style='width: 100%; display: inline-block; border-radius: 10px; box-shadow: 0 0 10px #dddddd; padding: 10px 0 10px 0;'>
            <?php $getBookSlot = explode(',', $value['bookingTime']);
            $meetingLink = explode(',', $value['meeting_link']);
            for($i = 0; $i < count($getBookSlot); $i++) { ?>
                <?php
                $booking_id = $value[$i]['id'];
                $employee_id = $value[$i]['employee_id'];
                $employer_id = $value[$i]['employer_id'];
                $available_id = $value[$i]['available_id'];
                $bookingTime = $value[$i]['bookingTime'];
                ?>
                <div style='width: 100%;float: left;display: flex; position: relative; align-items: center; justify-content: space-between; flex-direction: row;'>
                    <p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'><?= date('h:i A', strtotime($getBookSlot[$i]))?> to <?= date('h:i A', strtotime($getBookSlot[$i]) + 60*60)?></p>
                    <p style="width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;"><a href="<?= $meetingLink[$i] ?>">Meeting Link</a></p>
                    <!-- <input type='checkbox' style='position: unset; z-index: 1; opacity: 1; margin: 0px 10px 0px 0px;' id='completecheck' name='completecheck' value='1' onclick='completecheck(<?= $booking_id; ?>)'> -->
                </div>
            <?php }
            $getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '".@$value['employer_id']."'")->row();
            ?>
                <div>
                    <p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Booked By: <?= @$getEmployer->companyname?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
</div>
</div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
//CKEDITOR.replace('description');
function only_number(event) {
    var x = event.which || event.keyCode;
    console.log(x);
    if((x >= 48 ) && (x <= 57 ) || x == 8 | x == 9 || x == 13 || x == 46) {
        return;
    } else {
        event.preventDefault();
    }
}
$('#description').keyup(function() {
    var characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        theCount = $('#the-count');
    current.text(characterCount);

    /*This isn't entirely necessary, just playin around*/
    if (characterCount < 70) {
        current.css('color', '#666');
    }
    if (characterCount > 70 && characterCount < 90) {
        current.css('color', '#6d5555');
    }
    if (characterCount > 90 && characterCount < 100) {
        current.css('color', '#793535');
    }
    if (characterCount > 100 && characterCount < 120) {
        current.css('color', '#841c1c');
    }
    if (characterCount > 120 && characterCount < 139) {
        current.css('color', '#8f0001');
    }

    if (characterCount >= 140) {
        maximum.css('color', '#8f0001');
        current.css('color', '#8f0001');
        theCount.css('font-weight','bold');
    } else {
        maximum.css('color','#666');
        theCount.css('font-weight','normal');
    }
});
</script>
