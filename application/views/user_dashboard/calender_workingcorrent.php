<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= base_url('assets/images/resource/mslider1.jpg')?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
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
                <h2 class="breadcrumb-title">Availability</h2>
            </div>
        </div>
    </div>
</section>

<section class="dashboard-gig Chat_User">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <?php $this->load->view('sidebar'); ?>
            <div class="col-md-10 col-sm-12 display-table-cell v-align">
                <div class="user-dashboard">
                    <div class="row row-sm">
                        <div class="col-xl-12 col-lg-12 col-md-12 chat-box">
                            <div class="cardak">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="col-md-7 col-7" style="display: inline-block; float: left; background: #ffddde; padding: 30px; border-radius: 10px;">
                                            <p style="color:red;" class="" id="validateerrschedule"></p>
                                            <p style="color:red;" class="" id="validateerrschedulefromtime"></p>
                                            <p style="color:red;" class="" id="validateerrscheduletotime"></p>
                                            <p style="color:red;" class="" id="errstartingdate"></p>
                                            <form id="myForm">
                                                <div class="form-group">
                                                    <h5 class="control-label" style="margin-bottom: 35px;">Weekly Schedule</h5>
                                                    <?php
                                                    $getavailability = $this->db->query("SELECT * FROM user_availability WHERE user_id = '".@$_SESSION['afrebay']['userId']."'")->row();
                                                    //echo "<pre>"; print_r($getavailability); die();
                                                    $calenderday = $this->db->query("SELECT calender FROM setting WHERE id = '1'")->row();
                                                    $data = explode(',', $calenderday->calender);
                                                    //echo count($day); die();
                                                    for($i = 0; $i < count($data); $i++) {
                                                        $value = explode('.', $data[$i]); ?>
                                                    <div for="<?= $value[1]?>" class="col-12" style="width: 100%; display:inline-block;">
                                                        <div class="icheck-primary col-3" style="display: inline-block; float: left">
                                                            <input type="checkbox" id="checkboxPrimary<?= $value[0]?>" class="chooseday" name="weekDay<?= $value[0]?>" value='<?= $value[1]?>' <?php if ($getavailability->weekDay1 == $value[1] || $getavailability->weekDay2 == $value[1] || $getavailability->weekDay3 == $value[1] || $getavailability->weekDay4 == $value[1] || $getavailability->weekDay5 == $value[1] || $getavailability->weekDay6 == $value[1] || $getavailability->weekDay7 == $value[1]) { echo "checked"; } else { echo ""; }?>>
                                                            <label for="checkboxPrimary<?= $value[0]?>"> <?= $value[1]?></label>
                                                        </div>
                                                        <?php if(!empty($getavailability)) { ?>
                                                        <div class="form-group date col-9" id="calenderDays<?= $value[0]?>" <?php if ($getavailability->weekDay1 == $value[1] || $getavailability->weekDay2 == $value[1] || $getavailability->weekDay3 == $value[1] || $getavailability->weekDay4 == $value[1] || $getavailability->weekDay5 == $value[1] || $getavailability->weekDay6 == $value[1] || $getavailability->weekDay7 == $value[1]) { echo 'style="display: inline-block;background: #fcddde; border: 1px solid;border-radius: 12px;"'; } else { echo 'style="display: none; background: #fcddde; border: 1px solid;border-radius: 12px;"'; }?>>
                                                            <button type="button" class="btn btn-info addMoreBtn1" id="add_row_<?= $value[0]?>"><i class="fa fa-plus"></i></button>
                                                            <table class="table jobsites" id="purchaseTableclone<?= $value[0]?>">
                                                                <tbody id="clonetable_feedback<?= $value[0]?>">
                                                                    <?php
                                                                    if($getavailability->weekDay1 == $value[1]) {
                                                                        $fromTime = explode(',', $getavailability->weekDay1_fromtime);
                                                                        $toTime = explode(',', $getavailability->weekDay1_totime);
                                                                    }
                                                                    if($getavailability->weekDay2 == $value[1]) {
                                                                        $fromTime = explode(',', $getavailability->weekDay2_fromtime);
                                                                        $toTime = explode(',', $getavailability->weekDay2_totime);
                                                                    }
                                                                    if($getavailability->weekDay3 == $value[1]) {
                                                                        $fromTime = explode(',', $getavailability->weekDay3_fromtime);
                                                                        $toTime = explode(',', $getavailability->weekDay3_totime);
                                                                    }
                                                                    if($getavailability->weekDay4 == $value[1]) {
                                                                        $fromTime = explode(',', $getavailability->weekDay4_fromtime);
                                                                        $toTime = explode(',', $getavailability->weekDay4_totime);
                                                                    }
                                                                    if($getavailability->weekDay5 == $value[1]) {
                                                                        $fromTime = explode(',', $getavailability->weekDay5_fromtime);
                                                                        $toTime = explode(',', $getavailability->weekDay5_totime);
                                                                    }
                                                                    if($getavailability->weekDay6 == $value[1]) {
                                                                        $fromTime = explode(',', $getavailability->weekDay6_fromtime);
                                                                        $toTime = explode(',', $getavailability->weekDay6_totime);
                                                                    }
                                                                    if($getavailability->weekDay7 == $value[1]) {
                                                                        $fromTime = explode(',', $getavailability->weekDay7_fromtime);
                                                                        $toTime = explode(',', $getavailability->weekDay7_totime);
                                                                    }
                                                                    foreach ($fromTime as $key => $from_time) { ?>
                                                                        <tr>
                                                                            <td><input type="time" class="form-control getfromtime" name="fromtime<?= $value[0]?>[]" id="fromtime" required value="<?= $from_time?>"></td>
                                                                            <td><input type="time" class="form-control gettotime" name="totime<?= $value[0]?>[]" id="totime" required value="<?= $toTime[$key]?>"></td>
                                                                            <td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(<?= $value[0]?>)">X</a></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="form-group date col-9" id="calenderDays<?= $value[0]?>" style="display: none;background: #fcddde; border: 1px solid;border-radius: 12px;">
                                                            <button type="button" class="btn btn-info addMoreBtn1" id="add_row_<?= $value[0]?>"><i class="fa fa-plus"></i></button>
                                                            <table class="table jobsites" id="purchaseTableclone<?= $value[0]?>">
                                                                <tbody id="clonetable_feedback<?= $value[0]?>">
                                                                    <tr>
                                                                        <td><input type="time" class="form-control getfromtime" name="fromtime<?= $value[0]?>[]" id="fromtime" required></td>
                                                                        <td><input type="time" class="form-control gettotime" name="totime<?= $value[0]?>[]" id="totime" required></td>
                                                                        <td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(<?= $value[0]?>)">X</a></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="form-group" style="display: flex;">
                                                    <div class="col-12" style=" display: flex; align-items: center; justify-content: space-evenly; ">
                                                        <div class="col-6">
                                                            <h5 class="control-label">Start Date</h5>
                                                            <input type="text" id="starting_date" class="form-control" name="starting_date" style="background: #fff; padding: 15px; border-radius: 15px;" value="<?= date('m/d/Y', strtotime($getavailability->start_date))?>"/>
                                                        </div>
                                                        <div class="icheck-primary col-6" style="text-align: end;">
                                                            <input type="checkbox" id="repeat_month" name="repeat_month" <?php if($getavailability->repeat_month == '1') {echo "checked value='1'"; } else {echo "value='0'"; }?>>
                                                            <label for="repeat_month">Repeat Every Month </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                                                        <input type="button" class="btn btn-success" id="submit-button" value="Submit">
                                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo @$_SESSION['afrebay']['userId']?>">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-4 col-4" style="display: inline-block; float: left; background: #ffddde; padding: 30px; border-radius: 10px; margin-left: 45px;">
                                            <h5> Date-Specific Hours</h5>
                                            <p>Override your availability for specific dates when your hours differ from your regular weekly hours.</p>
                                            <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button" style="background: #ed1c24; border: 1px solid #ed1c24;">Add Date-Specific Hours</a>
                                            <?php
                                            $getdatespecificdata = $this->db->query("SELECT * FROM user_availability WHERE user_id = '".@$_SESSION['afrebay']['userId']."' AND repeat_month = '2'")->result_array();
                                            if(!empty($getdatespecificdata)) { ?>
                                            <div class="form-group" style="margin-top: 45px;">
                                            <?php foreach ($getdatespecificdata as $value) { ?>
                                                <div class="getdatespecificdata">
                                                    <div class="getdatespecificdate" style="width: 100%; margin-bottom: 5px; font-size: 16px; font-weight: 700;"><?= date('F j, Y' , strtotime($value['start_date'])) ?></div>
                                                    <?php
                                                    $weekDay1_fromtime = $value['weekDay1_fromtime'];
                                                    $weekDay1Fromtime = explode(',' , $weekDay1_fromtime);

                                                    $weekDay1_totime = $value['weekDay1_totime'];
                                                    $weekDay1Totime = explode(',' , $weekDay1_totime);
                                                    foreach ($weekDay1Fromtime as $key => $time) { ?>
                                                        <div class="getdatespecificdatetime"><?= date('h:i A', strtotime($time))." to ".date('h:i A', strtotime($weekDay1Totime[$key])); ?></div>
                                                    <?php } ?>
                                                </div>
                                            <?php } }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Date-Specific Hours</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myDateform">
                    <p style="color:red;" class="" id="errspecificdate"></p>
                    <p style="color:red;" class="" id="errfromtimedate"></p>
                    <p style="color:red;" class="" id="errtotimedate"></p>
                    <div class="col-12" style="display: inline-block;">
                        <div class="col-6" style="display: inline-block; float: left;">
                            <p style="margin-bottom: 25px;">Select date(s) you want to assign specific hours.</p>
                            <input type="text" class="form-control" name="specific_date[]" id="specific_date">
                        </div>
                        <div class="col-6" style="display: inline-block; float: left;">
                            <p style="display: inline-block; float: left;">What hours are you available?</p>
                            <table class="table jobsites" id="purchaseTableclonedate1">
                                <button type="button" class="btn btn-info addMoreBtn1" id="add_rowdate1"><i class="fa fa-plus"></i></button>
                                <tbody id="clonetable_feedbackdate1">
                                    <tr>
                                        <td style="border: none;"><input type="time" class="form-control getfromtimedate" name="fromtimedate[]" id="fromtimedate" required></td>
                                        <td style="border: none;"><input type="time" class="form-control gettotimedate" name="totimedate[]" id="totimedate" required></td>
                                        <td style="border: none;"><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return removesdate1()">X</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <input type="button" class="btn btn-success" id="submit_buttonDate" value="Submit">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo @$_SESSION['afrebay']['userId']?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.dashboard-gig a:focus, a:hover, a {text-decoration: none !important;}#calendar {width: 100%;margin: 0;box-shadow: 0 0 10px #dddddd;display: inline-block;padding: 20px;border-radius: 10px;margin-bottom: 20px;}.fc-event {border: 1px solid #eee !important;}.fc-content {padding: 3px !important;}.fc-content .fc-title {display: block !important;overflow: hidden;text-align: center;font-size: 12px;font-weight: 500;text-align: center;}.fc-customButton-button {font-size: 13px !important;position: absolute;top: 60px;left: 50%;transform: translateY(-50%);}.form-group {margin-bottom: 1rem;}.form-group>label {margin-bottom: 10px;}#delete-modal .modal-footer>.btn {border-radius: 3px !important;padding: 0px 8px !important;font-size: 15px;}.fc-scroller {overflow-y: hidden !important;}.context-menu {position: absolute;z-index: 1000;background-color: #fff;border: 1px solid #ccc;border-radius: 4px;box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);padding: 5px;}.context-menu ul {list-style-type: none;margin: 0;padding: 0;}.context-menu ul>li {display: block;padding: 5px 15px;list-style-type: none;color: #333;display: block;cursor: pointer;margin: 0 auto;transition: 0.10s;font-size: 13px;}.context-menu ul>li:hover {color: #fff;background-color: #007bff;border-radius: 2px;}.fa, .fas {font-size: 13px;margin-right: 4px;}button:focus {box-shadow: none !important;}.Calender_Pick .fc-header-toolbar {display: flex;flex-direction: column;}.Calender_Pick .fc-header-toolbar {display: flex;flex-direction: column;margin-bottom: 0px !important;}.Calender_Pick .fc-left {width: 100%;height: 35px;display: flex;justify-content: flex-start;align-items: flex-start;}.Calender_Pick .fc-left h2 {font-weight: 600;font-size: 18px;}.Calender_Pick .fc-center {position: relative;height: 45px;width: 100%;}.Calender_Pick .fc-center button {transform: translateY(0);position: absolute;top: 0;height: 35px;left: 0;width: 100px;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;font-size: 13px !important;}.Calender_Pick .fc-right {width: 100%;height: 45px;display: flex;align-items: flex-start;justify-content: space-between;}.Calender_Pick .fc-right button {border: 0; height: 35px; width: 100px; border-radius: 50px;background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 79%) 100%) !important; opacity: 1; font-size: 13px !important;}.Calender_Pick .fc-button-group {height: 35px;border-radius: 50px;}.Calender_Pick .fc-button-group button {background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 79%) 100%) !important; border: 0;display: flex;align-items: center;justify-content: center;width: 60px !important;}.Calender_Pick .fc-button-group button span {font-size: 13px;}.Calender_Pick .fc-day-grid-container {height: auto !important;border-bottom: 1px solid #ddd;}.Calender_Pick .fc-view-container .fc-head-container {color: #ED1C24 !important;}div.modal.edit-form.Modal_Show {display: flex !important;align-items: center;justify-content: center;}.edit-form .modal-content {width: 800px;}.edit-form .modal-content .modal-body {border-radius: 0;}.edit-form .modal-content #myForm .form-group label {padding: 0;font-size: 16px;}.edit-form .modal-content #myForm .form-group #event-title {padding: 10px !important;font-size: 15px;}.edit-form .modal-content .modal-footer button {height: 35px;display: flex;align-items: center;justify-content: center;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;letter-spacing: 1px;}
#err-messages{display: none; text-align: center;}
#submit-button {
    /*height: 35px !important;*/
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50px !important;
    background: #ed1c24 !important;
    border: 0 !important;
    letter-spacing: 1px !important;
}
.addMoreBtn1 {padding: 4px !important; width: 60px; letter-spacing: 0px; font-size: 15px !important; position: relative; top: 11px; background: #ed1c24 !important; border: 1px solid #ed1c24 !important; color: #fff !important;}
.jconfirm-content-pane {text-align: center !important;}
.jconfirm-buttons {margin-right: 40% !important;}
.fc .fc-row .fc-content-skeleton table, .fc .fc-row .fc-content-skeleton td, .fc .fc-row .fc-helper-skeleton td {padding: 0px !important;}
.Calender_Pick .fc-center {display: none;}
.icheck-primary > input:first-child:checked + label::before, .icheck-primary > input:first-child:checked + input[type="hidden"] + label::before {
    background-color: #ed1c24;
    border-color: #ed1c24;
}
[class*=icheck-]>input:first-child+input[type=hidden]+label::before, [class*=icheck-]>input:first-child+label::before {
    content: "";
    display: inline-block;
    position: absolute;
    width: 22px;
    height: 22px;
    border: 1px solid #ed1c24;
    border-radius: 0;
    margin-left: 2px;
}
.profile-dsd label::before, label::after {
    position: absolute;
    top: -2px;
    left: 1px;
    display: block;
    width: 0px !important;
    height: 0px !important;
}
.form-group label {
    font-weight: 600;
    letter-spacing: 0.010em;
    font-size: 15px;
    margin-bottom: 5px;
}
.cardak .table {
    width: 65%;
    max-width: 65%;
    margin-bottom: 0rem !important;
}
.getdatespecificdatetime {
    background: green;
    border-radius: 10px;
    width: 150px;
    padding: 10px;
    display: inline-block;
    text-align: center;
    font-size: 12px;
    color: #fff;
    font-weight: 600;
    margin-bottom: 5px;
}
.getdatespecificdata {
    display: inline-block;
    margin-bottom: 10px;
    background: #efaf41;
    padding: 10px;
    border-radius: 15px;
}
</style>
<link rel='stylesheet'href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css'>
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
<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    $(function() {
        $("#starting_date").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            immediateUpdates: true,
            todayHighlight: true,
            startDate:'+0d'
        }).datepicker("setDate", "0");

        $("#specific_date").datepicker({
            multidate: true,
            format: "yyyy-mm-dd",
            immediateUpdates: true,
            todayHighlight: true,
            startDate:'+0d'
        }).datepicker("setDate", "0");
    });
});

$("#repeat_month").click(function(){
    if($("#repeat_month").is(':checked')) {
        $("#repeat_month").val("1");
    } else {
        $("#repeat_month").val("0");
    }
})

$('#submit-button').on('click', function() {
    var schedule = $(".chooseday:checked").val();
    var from_time = $('.getfromtime').val().length;
    var to_time = $('.gettotime').val().length;
    var starting_date = $('#starting_date').val().length;

    if (schedule === undefined || schedule.trim() === '') {
        $('#validateerrschedule').text('Please enter schedule');
        setInterval(function () {
            $('#validateerrschedule').empty();
        }, 5000);
    } else if(from_time === 0){
        $('#validateerrschedule').text('Please enter from time');
        setInterval(function () {
            $('#validateerrschedule').empty();
        }, 5000);
    } else if(to_time === 0){
        $('#validateerrschedule').text('Please enter to time');
        setInterval(function () {
            $('#validateerrschedule').empty();
        }, 5000);
    } else if(starting_date === 0){
        $('#validateerrschedule').text('Please enter starting date');
        setInterval(function () {
            $('#validateerrschedule').empty();
        }, 5000);
    } else {
        var form_data = $('#myForm').serialize();
        $.ajax({
            type:"post",
            url:"<?php echo base_url()?>user/Dashboard/create_availability",
            data: form_data,
            success:function(returndata) {
                if(returndata == 1) {
                    $.confirm({
                        title: '',
                        content: "Data added successfuly",
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
        return false;
    }
})

function closeAvail() {
    location.reload();
}

<?php
for($i = 0; $i < count($data); $i++) {
    $value = explode('.', $data[$i]); ?>
    //$("#calenderDays<?= $value[0]?>").css("display", "none");
    $("#checkboxPrimary<?= $value[0]?>").click(function(){
        //alert($("#checkboxPrimary<?= $value[0]?>").val());
        if($("#checkboxPrimary<?= $value[0]?>").is(':checked')) {
            $("#calenderDays<?= $value[0]?>").css("display", "inline-block");
        } else {
            $("#calenderDays<?= $value[0]?>").css("display", "none");
        }
    })

    $("#add_row_<?= $value[0]?>").click(function() {
        var y = document.getElementById('clonetable_feedback<?= $value[0]?>');
        var new_row = y.rows[0].cloneNode(true);
        var len = y.rows.length;
        new_number=Math.round(Math.exp(Math.random()*Math.log(10000000-0+1)))+0;
        var inp0 = new_row.cells[0].getElementsByTagName('input')[0];
        inp0.value = '';
        inp0.id = 'service'+(len+1);
        var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
        inp1.value = '';
        inp1.id = 'service'+(len+1);
        var submit_btn =$('#submit').val();
        y.appendChild(new_row);
    })
<?php } ?>

function remove(row) {
    var y=document.getElementById('purchaseTableclone'+row);
    var len = y.rows.length;
    console.log(len);
    if(len>1) {
        var i= (len-1);
        document.getElementById('purchaseTableclone'+row).deleteRow(i);
    }
}

$("#add_rowdate1").click(function() {
    var y = document.getElementById('clonetable_feedbackdate1');
    var new_row = y.rows[0].cloneNode(true);
    var len = y.rows.length;
    new_number=Math.round(Math.exp(Math.random()*Math.log(10000000-0+1)))+0;
    var inp0 = new_row.cells[0].getElementsByTagName('input')[0];
    inp0.value = '';
    inp0.id = 'service'+(len+1);
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.value = '';
    inp1.id = 'service'+(len+1);
    var submit_btn =$('#submit').val();
    y.appendChild(new_row);
})

function removesdate1(row) {
    var y=document.getElementById('purchaseTableclonedate1');
    var len = y.rows.length;
    console.log(len);
    if(len>1) {
        var i= (len-1);
        document.getElementById('purchaseTableclonedate1').deleteRow(i);
    }
}

$('#submit_buttonDate').on('click', function() {
    var specificdate = $('#specific_date').val().length;
    var fromtimedate = $('.getfromtimedate').val().length;
    var totimedate = $('.gettotimedate').val().length;

    if(specificdate === 0) {
        $('#errspecificdate').text('Please enter starting date');
        setInterval(function () {
            $('#errspecificdate').empty();
        }, 5000);
    } else if(fromtimedate === 0){
        $('#errfromtimedate').text('Please enter from time');
        setInterval(function () {
            $('#errfromtimedate').empty();
        }, 5000);
    } else if(totimedate === 0){
        $('#errtotimedate').text('Please enter to time');
        setInterval(function () {
            $('#errtotimedate').empty();
        }, 5000);
    } else {
        /*var specificdate = $('#specific_date').val();
        var ftimeArray = new Array();
        $("input[name=fromtimedate]").each(function() {
            ftimeArray.push($(this).val());
        });
        var todateArray = new Array();
        $("input[name=totimedate]").each(function() {
            todateArray.push($(this).val());
        });

        var form_datadate = new FormData();
        form_datadate.append('user_id',user_id);
        form_datadate.append('specificdate',specificdate);
        form_datadate.append('from_time',ftimeArray);
        form_datadate.append('to_time',todateArray);*/

        var form_datadate = $('#myDateform').serialize();
        $.ajax({
            type:"post",
            url:"<?php echo base_url()?>user/Dashboard/createdatewiseavailability",
            data: form_datadate,
            success:function(returndata) {
                if(returndata == 1) {
                    $.confirm({
                        title: '',
                        content: "Data added successfuly",
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
        return false;
    }
})
</script>