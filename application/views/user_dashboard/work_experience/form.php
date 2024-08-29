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
                <h2 class="breadcrumb-title">Add Work Experience</h2>
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
                                <a href="#" class="pull-right">
                                </a>
                            </div>
                        </div>
                        <div class="profile-dsd">
                            <div class="tab-content">
                                <div class="tab-pane active" style="padding: 0px;">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>Job Title <span style="color: red">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="designation" placeholder="Enter Job Title"  value="<?= @$designation; ?>" required list="designation" autocomplete="off"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name"><h4>Company Name <span style="color: red">*</span></h4></label>
                                                <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name"  value="<?= @$company_name; ?>" required list="company_name" autocomplete="off"/>
                                            </div>
                                            <!-- <div class="col-lg-6">
                                                <label for="first_name"><h4>Duration<span style="color: red">*</span></h4></label>
                                                <input type="text" class="form-control" name="duration" placeholder="Enter Duration"  value="<?= $duration; ?>" required list="duration" autocomplete="off"/>
                                            </div> -->
                                            <div class="col-lg-6">
                                                <label for="first_name"><h4>From Date <span style="color: red">*</span></h4></label>
                                                <!-- <input type="date" class="form-control" name="from_date" id="from_date" placeholder="From Date"  value="<?= $from_date; ?>" required onkeydown="return false" /> -->
                                                <input type="date" class="form-control" name="from_date" id="from_date" placeholder="From Date"  value="<?= $from_date; ?>"/>
                                                <div id="errFromdate">Please enter a valid date</div>
                                                <div id="errGFromdate">'From Date' cannot be greater than 'To Date'</div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name"><h4>To Date <span style="color: red">*</span></h4></label>
                                                <!-- <input type="date" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?= $to_date; ?>" required onkeydown="return false" /> -->
                                                <input type="date" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?= $to_date; ?>"/>
                                                <div id="errTodate">Please enter a valid date</div>
                                            </div>
                                            <div class="col-lg-12"><br>
                                                <label for="first_name"><h4>Description </h4></label>
                                                <textarea type="text" class="form-control" name="description" id="description" maxlength="500" value="<?= $description; ?>" ><?= @$description; ?></textarea>
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
                                            <button class="post-job-btn pull-right" type="submit" id="work_submit"><i class="glyphicon glyphicon-ok-sign"></i> Submit</button>
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<style>
#errFromdate {display: none; color: red;}
#errTodate {display: none; color: red;}
#errGFromdate {display: none; color: red;}
</style>
<script>
//CKEDITOR.replace('description');
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

$(document).ready(function(){
    $('#work_submit').click(function(){
        if($('#from_date').val() > $('#to_date').val()) {
            $('#errGFromdate').show();
            setTimeout(function(){
                $('#errGFromdate').hide();
            }, 2000);
            return false;
        } else {
            var fromdate = $('#from_date').val().split("-");
            fromday = fromdate[2];
            frommonth = fromdate[1];
            fromyear = fromdate[0];
            testfromDate = (frommonth+'/'+fromday+'/'+fromyear);
            validateFromDate(testfromDate);
            if(validateFromDate(testfromDate) == false) {
                $('#errFromdate').show();
                setTimeout(function(){
                    $('#errFromdate').hide();
                }, 2000);
                return false;
            }

            var todate = $('#to_date').val().split("-");
            today = todate[2];
            tomonth = todate[1];
            toyear = todate[0];
            testtoDate = (tomonth1+'/'+today1+'/'+toyear1);
            validateToDate(testtoDate);
            if(validateToDate(testtoDate) == false) {
                $('#errTodate').show();
                setTimeout(function(){
                    $('#errTodate').hide();
                }, 2000);
                return false;
            }
        }
    })
})

function validateFromDate(testfromDate) {
    var date_regex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/ ;
    return date_regex.test(testfromDate);
}

function validateToDate(testtoDate) {
    var date_regex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/ ;
    return date_regex.test(testtoDate);
}

</script>
