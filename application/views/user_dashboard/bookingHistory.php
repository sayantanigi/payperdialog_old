<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1"
            style="background: url('<?= base_url('assets/images/resource/mslider1.jpg') ?>') repeat scroll 50% 422.28px transparent;"
            class="parallax scrolly-invisible no-parallax"></div>
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
                <h2 class="breadcrumb-title">Booking History</h2>
            </div>
        </div>
    </div>
</section>
<section class="dashboard-gig Chat_User">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
            <?php $this->load->view('sidebar'); ?>
            <div class="col-md-12 col-sm-12 display-table-cell v-align">
                <div class="user-dashboard">
                    <div class="row row-sm">
                        <div class="col-xl-12 col-lg-12 col-md-12 chat-box">
                            <div class="cardak">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="col-md-6 col-6" style="display: inline-block; float: left;">
                                            <div class="Calender_Pick" id="calendar"></div>
                                        </div>
                                        <input type="hidden" id="employee_id" name="employee_id"
                                            value="<?= @$_SESSION['afrebay']['userId'] ?>">
                                        <div class="col-md-6 col-6 getBookingDetails"
                                            style="display: inline-block; float: left;">
                                            <?php
                                            $timezone = date_default_timezone_get();
                                            date_default_timezone_set($timezone);
                                            $date = date('Y-m-d', time());
                                            $availableData = $this->db->query("SELECT * FROM user_availability WHERE start_date ='" . $date . "' AND end_date ='" . $date . "' AND user_id ='" . @$_SESSION['afrebay']['userId'] . "'")->result_array();
                                            //echo "<pre>"; print_r($availableData);
                                            $avail_id = $availableData[0]['id'];
                                            ?>
                                            <div style="width: 100%;display: inline-block;text-align: center;border-radius: 10px;box-shadow: 0 0 10px #dddddd;height: 400px;overflow-y: scroll;overflow-x: hidden;">
                                                <p style="padding: 20px 0 0 0;font-size: 18px;font-weight: 600;color: #212529;">
                                                    <?= $date; ?>
                                                </p>
                                                <?php
                                                $getBookSlot = $this->db->query("SELECT * FROM user_booking WHERE available_id ='" . @$avail_id . "' AND employee_id ='" . @$_SESSION['afrebay']['userId'] . "'")->result_array();
                                                if (!empty($getBookSlot)) {
                                                    for ($i = 0; $i < count($getBookSlot); $i++) { ?>
                                                        <div style="width: 100%; display: inline-block; padding: 0 40px; margin-bottom: 20px;">
                                                            <div style="width: 100%;display: inline-block;border-radius: 10px;box-shadow: 0 0 10px #dddddd;padding: 20px 0 20px 0;">
                                                                <?php
                                                                $booking_id = $getBookSlot[$i]['id'];
                                                                $employee_id = $getBookSlot[$i]['employee_id'];
                                                                $employer_id = $getBookSlot[$i]['employer_id'];
                                                                $available_id = $getBookSlot[$i]['available_id'];
                                                                $bookingTime = $getBookSlot[$i]['bookingTime'];
                                                                $bookingTime = explode(',', $bookingTime);
                                                                $meetingLink = explode(',', $getBookSlot[0]['meeting_link']);
                                                                $meetingPass = explode(',', $getBookSlot[0]['meeting_pass']);
                                                                for ($j = 0; $j < count($bookingTime); $j++) {
                                                                    $getEmployee = $this->db->query("SELECT * FROM users WHERE userId = '" . @$_SESSION['afrebay']['userId'] . "'")->result_array();
                                                                    $getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '" . @$employer_id . "'")->result_array();
                                                                    ?>
                                                                    <div style="width: 33.33%;float: left;display: flex; position: relative; align-items: center; justify-content: space-between; flex-direction: row;">
                                                                        <p style="width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;"><?= date('h:i A', strtotime($bookingTime[$j])) ?> to <?= date('h:i A', strtotime($bookingTime[$j]) + 60 * 60) ?></p>
                                                                        <p style="width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;"><a href="<?= $meetingLink[$j]?>">Meeting Link</a> Pass: <?= $meetingPass[$j]?></p>
                                                                        <input type="checkbox" style="position: unset; z-index: 1; opacity: 1; margin: 0px 10px 0px 0px;" id="completecheck" name="completecheck" value="1">
                                                                    </div>
                                                                <?php } ?>
                                                                <div>
                                                                    <p style="width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;">Total Rate: <?= count($bookingTime) * @$getEmployee[0]['rateperhour'] ?></p>
                                                                    <p style="width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;">Booked By: <?= @$getEmployer[0]['companyname'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div>
                                                        <div style='color: #212529;'>No slot booked for this selected date
                                                        </div>
                                                    </div>
                                                <?php } ?>
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
<style>
    .dashboard-gig a:focus,a,a:hover{text-decoration:none!important}#calendar{width:100%;margin:0 0 20px;box-shadow:0 0 10px #ddd;display:inline-block;padding:20px;border-radius:10px}.fc-event{border:1px solid #eee!important}.fc-content{padding:3px!important}.fc-content .fc-title{display:block!important;overflow:hidden;font-size:12px;font-weight:500;text-align:center}.fc-customButton-button{font-size:13px!important;position:absolute;top:60px;left:50%;transform:translateY(-50%)}.Calender_Pick .fc-button-group button span,.fa,.fas{font-size:13px}.form-group{margin-bottom:1rem}.form-group>label{margin-bottom:10px}#delete-modal .modal-footer>.btn{border-radius:3px!important;padding:0 8px!important;font-size:15px}.fc-scroller{overflow-y:hidden!important}.context-menu{position:absolute;z-index:1000;background-color:#fff;border:1px solid #ccc;border-radius:4px;box-shadow:2px 2px 6px rgba(0,0,0,.3);padding:5px}.context-menu ul{list-style-type:none;margin:0;padding:0}.context-menu ul>li{padding:5px 15px;list-style-type:none;color:#333;display:block;cursor:pointer;margin:0 auto;transition:.1s;font-size:13px}.context-menu ul>li:hover{color:#fff;background-color:#007bff;border-radius:2px}.fa,.fas{margin-right:4px}button:focus{box-shadow:none!important}.Calender_Pick .fc-header-toolbar{display:flex;flex-direction:column;display:flex;flex-direction:column;margin-bottom:0!important}.Calender_Pick .fc-left{width:100%;height:35px;display:flex;justify-content:flex-start;align-items:flex-start}.Calender_Pick .fc-left h2{font-weight:600;font-size:18px}.Calender_Pick .fc-center button,.Calender_Pick .fc-right button{width:100px;font-size:13px!important;background:linear-gradient(180deg,rgb(237 28 36) 0,rgb(237 28 36 / 79%) 100%)!important}.Calender_Pick .fc-center{position:relative;height:45px;width:100%}.Calender_Pick .fc-center button{transform:translateY(0);position:absolute;top:0;height:35px;left:0;border-radius:50px;border:0}.Calender_Pick .fc-right{width:100%;height:45px;display:flex;align-items:flex-start;justify-content:space-between}.Calender_Pick .fc-right button{border:0;height:35px;border-radius:50px;opacity:1}.Calender_Pick .fc-button-group{height:35px;border-radius:50px}.Calender_Pick .fc-button-group button{background:linear-gradient(180deg,rgb(237 28 36) 0,rgb(237 28 36 / 79%) 100%)!important;border:0;display:flex;align-items:center;justify-content:center;width:60px!important}.Calender_Pick .fc-day-grid-container{height:auto!important;border-bottom:1px solid #ddd}.Calender_Pick .fc-view-container .fc-head-container{color:#ed1c24!important}div.modal.edit-form.Modal_Show{display:flex!important;align-items:center;justify-content:center}.edit-form .modal-content{width:800px}.edit-form .modal-content .modal-body{border-radius:0}.edit-form .modal-content #myForm .form-group label{padding:0;font-size:16px}.edit-form .modal-content #myForm .form-group #event-title{padding:10px!important;font-size:15px}.edit-form .modal-content .modal-footer button{height:35px;display:flex;align-items:center;justify-content:center;border-radius:50px;background:linear-gradient(180deg,rgb(237 28 36) 0,rgb(237 28 36 / 79%) 100%)!important;border:0;letter-spacing:1px}#err-messages{display:none;text-align:center}#submit-button{display:flex!important;align-items:center!important;justify-content:center!important;border-radius:50px!important;background:linear-gradient(180deg,rgb(237 28 36) 0,rgb(237 28 36 / 79%) 100%)!important;border:0!important;letter-spacing:1px!important}.jconfirm-content-pane{text-align:center!important}.jconfirm-buttons{margin-right:40%!important}.fc .fc-row .fc-content-skeleton table,.fc .fc-row .fc-content-skeleton td,.fc .fc-row .fc-helper-skeleton td{padding:0!important}.Calender_Pick .fc-center{display:none}
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
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const myModal = new bootstrap.Modal(document.getElementById('form'));
        const dangerAlert = document.getElementById('danger-alert');
        const close = document.querySelector('.btn-close');
        const myEvents = JSON.parse(localStorage.getItem('events')) || [
            <?php
            $bookingSlot = $this->db->query("SELECT * FROM user_booking WHERE employer_id = '".$_SESSION['afrebay']['userId']."' AND meeting_link IS NOT NULL")->result_array();
            //$availability = $this->db->query("SELECT * FROM user_availability WHERE id = '".$bookingSlot->available_id."'")->result_array();
            if (!empty($bookingSlot)) {
                foreach ($bookingSlot as $value) {
                    $checkBookSlot = $this->db->query("SELECT * FROM user_availability WHERE id = '".$value['available_id']."'")->result_array();
                    foreach ($checkBookSlot as $value1) {
                        if (!empty($checkBookSlot)) { ?>
                            {
                                title: 'Booked',
                                start: '<?= date('Y-m-d', strtotime($value1['start_date'])) ?>',
                                end: '<?= date('Y-m-d', strtotime($value1['end_date'])) ?>',
                                backgroundColor: 'red'
                            },
                        <?php } else { ?>
                            {
                                title: 'Available',
                                start: '<?= date('Y-m-d', strtotime($value1['start_date'])) ?>',
                                end: '<?= date('Y-m-d', strtotime($value1['end_date'])) ?>',
                                backgroundColor: 'green'
                            },
                        <?php }
                    }
                }
            } ?>
        ];
        const calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'local',
            customButtons: {
                customButton: {
                    text: 'Availability',
                    click: function () {
                        <?php if (!empty($_SESSION['afrebay']['userId'])) { ?>
                            myModal.show();
                        <?php } else { ?>
                            window.location.href = "<?php echo base_url('login') ?>";
                        <?php } ?>
                        const modalTitle = document.getElementById('modal-title');
                        const submitButton = document.getElementById('submit-button');
                        modalTitle.innerHTML = 'Availability'
                        submitButton.innerHTML = 'Availability'
                        submitButton.classList.remove('btn-primary');
                        submitButton.classList.add('btn-success');
                        close.addEventListener('click', () => {
                            myModal.hide()
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

        calendar.on('select', function (info) {
            var selectDate = info.startStr;
            var employeeId = $('#employee_id').val();
            $.ajax({
                type: "post",
                url: "<?php echo base_url() ?>user/Dashboard/getBookingDetailsforEmployee",
                data: { selectDate: selectDate, employeeId: employeeId },
                success: function (returndata) {
                    //console.log(returndata);
                    $('.getBookingDetails').html(returndata);
                }
            });
        });
        calendar.render();
        //var date = calendar.getDate();
        //alert(date.toISOString());
    });
    $(document).ready(function () {
        <?php $i = 1;
        foreach ($availability as $value) { ?>
            $('#job_overview_sub_<?= $i ?>').hide();
            $('#job_overview_main_<?= $i ?>').on('click', function () {
                $('#job_overview_sub_<?= $i ?>').toggle();
            })
            <?php $i++;
        } ?>
    })
    function closeAvail() {
        location.reload();
    }
</script>