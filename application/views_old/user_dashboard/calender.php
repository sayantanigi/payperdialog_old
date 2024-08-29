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
                                        <div class="col-md-6 col-6" style="display: inline-block; float: left;">
                                            <?php 
                                            $availability = $this->db->query("SELECT * FROM user_availability WHERE user_id = '".$_SESSION['afrebay']['userId']."'")->result_array();
                                            if(!empty($availability)) { ?>
                                            <div class="job-overview" style="height: 382px; overflow: auto; margin-top: 0px;">
                                                <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">Start Date</p>
                                                <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">From Time</p>
                                                <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">To Time</p>
                                                <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">End Date</p>
                                                <p style="width: 20%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;">Action</p>
                                                <?php $i=1; 
                                                foreach ($availability as $value) { ?>
                                                <div style="width:80%; background: #c7c7c7; margin: 5px 0 0 0 !important; padding: 0; border-radius: 10px; box-shadow: 0 0 10px #dddddd; cursor: pointer;" class="job-overview job_overview_main">
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('d-m-Y', strtotime($value['start_date']));?></p>
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('h:i A', strtotime($value['from_time']))?></p>
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('h:i A', strtotime($value['to_time']));?></p>
                                                    <p style="width: 25%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;"><?= date('d-m-Y', strtotime($value['end_date']))?></p>
                                                </div>
                                                <div>
                                                    <p style="width: 10%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;cursor: pointer;" onclick="editAvailability('<?= $value['id']?>')"><i class="fa fa-edit"></i></p>
                                                    <p style="width: 10%; display: inline-block; float: left; text-align: center; color: #000; font-size: 15px; font-weight: 600; font-family: Open Sans; margin: 0px !important;cursor: pointer;" onclick="deleteAvailability('<?= $value['id']?>')"><i class="fa fa-trash"></i></p>
                                                </div>
                                                <?php $i++; } ?>
                                            </div>
                                            <?php } else { ?>
                                            <div class="job-overview" style="text-align: center;">No data added for availability</div>
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
</section>

<div class="modal fade edit-form" id="booking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document" style="max-width: 800px !important;">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Add Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeAvail()"></button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class="alert alert-danger " role="alert" id="danger-alert" style="display: none;">
                        End date should be greater than start date.
                    </div>
                    <div class='form-group date'>
                        <table class="table jobsites" id="purchaseTableclone1">
                            <tr class="color" style="text-align: center;">
                                <th>From Date<span style="color:red;">*</span></th>
                                <th>From Time <span style="color:red;">*</span></th>
                                <th>To Date<span style="color:red;">*</span></th>
                                <th>To Time <span style="color:red;">*</span></th>
                                <th><button type="button" class="btn btn-info addMoreBtn" onclick="add_row()">Add</button></th>
                            </tr>
                            <tbody id="clonetable_feedback1">
                                <tr>
                                    <td><input type="date" class="form-control" name="startdate" id="start-date" required></td>
                                    <td><input type="time" class="form-control" name="fromtime" id="time1" required></td>
                                    <td><input type="date" class="form-control" name="enddate" id="end-date" required></td>
                                    <td><input type="time" class="form-control" name="totime" id="time1" required></td>
                                    <td><input type="hidden" name="user_id" id="user_id" value="<?php echo @$_SESSION['afrebay']['userId']?>"></td>
                                    <td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(this)">X</a></td>
                                </tr>
                            </tbody>
                        </table>
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
            var y = document.getElementById('clonetable_feedback1');
            var new_row = y.rows[0].cloneNode(true);
            var len = y.rows.length;
            new_number=Math.round(Math.exp(Math.random()*Math.log(10000000-0+1)))+0;
            var inp0 = new_row.cells[0].getElementsByTagName('input')[0];
            inp0.value = '';
            inp0.id = 'service'+(len+1);
            var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
            inp1.value = '';
            inp1.id = 'service'+(len+1);
            var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
            inp2.value = '';
            inp2.id = 'service'+(len+1);
            var inp3 = new_row.cells[3].getElementsByTagName('input')[0];
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

<div class="modal fade edit-form" id="editbooking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document" style="max-width: 800px !important;">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Edit Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeAvail()"></button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div class="alert alert-danger " role="alert" id="danger-alert" style="display: none;">
                        End date should be greater than start date.
                    </div>
                    <div class='form-group date'>
                        <table class="table jobsites" id="purchaseTableclone1">
                            <tr class="color" style="text-align: center;">
                                <th>From Date<span style="color:red;">*</span></th>
                                <th>From Time <span style="color:red;">*</span></th>
                                <th>To Date<span style="color:red;">*</span></th>
                                <th>To Time <span style="color:red;">*</span></th>
                            </tr>
                            <tbody id="clonetable_feedback1">
                                <tr>
                                    <td><input type="date" class="form-control" name="start_date" id="start_date" required></td>
                                    <td><input type="time" class="form-control" name="from_time" id="from_time" required></td>
                                    <td><input type="date" class="form-control" name="end_date" id="end_date" required></td>
                                    <td><input type="time" class="form-control" name="to_time" id="to_time" required></td>
                                    <td><input type="hidden" name="user_id" id="user_id" value=""></td>
                                    <td><input type="hidden" name="avail_id" id="avail_id" value=""></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <!-- <button type="submit" class="btn btn-success" id="submit-button1">Schedule</button> -->
                    <input type="button" class="btn btn-success" id="update_button" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.dashboard-gig a:focus, a:hover, a {text-decoration: none !important;}#calendar {width: 100%;margin: 0;box-shadow: 0 0 10px #dddddd;display: inline-block;padding: 20px;border-radius: 10px;margin-bottom: 20px;}.fc-event {border: 1px solid #eee !important;}.fc-content {padding: 3px !important;}.fc-content .fc-title {display: block !important;overflow: hidden;text-align: center;font-size: 12px;font-weight: 500;text-align: center;}.fc-customButton-button {font-size: 13px !important;position: absolute;top: 60px;left: 50%;transform: translateY(-50%);}.form-group {margin-bottom: 1rem;}.form-group>label {margin-bottom: 10px;}#delete-modal .modal-footer>.btn {border-radius: 3px !important;padding: 0px 8px !important;font-size: 15px;}.fc-scroller {overflow-y: hidden !important;}.context-menu {position: absolute;z-index: 1000;background-color: #fff;border: 1px solid #ccc;border-radius: 4px;box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);padding: 5px;}.context-menu ul {list-style-type: none;margin: 0;padding: 0;}.context-menu ul>li {display: block;padding: 5px 15px;list-style-type: none;color: #333;display: block;cursor: pointer;margin: 0 auto;transition: 0.10s;font-size: 13px;}.context-menu ul>li:hover {color: #fff;background-color: #007bff;border-radius: 2px;}.fa, .fas {font-size: 13px;margin-right: 4px;}button:focus {box-shadow: none !important;}.Calender_Pick .fc-header-toolbar {display: flex;flex-direction: column;}.Calender_Pick .fc-header-toolbar {display: flex;flex-direction: column;margin-bottom: 0px !important;}.Calender_Pick .fc-left {width: 100%;height: 35px;display: flex;justify-content: flex-start;align-items: flex-start;}.Calender_Pick .fc-left h2 {font-weight: 600;font-size: 18px;}.Calender_Pick .fc-center {position: relative;height: 45px;width: 100%;}.Calender_Pick .fc-center button {transform: translateY(0);position: absolute;top: 0;height: 35px;left: 0;width: 100px;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;font-size: 13px !important;}.Calender_Pick .fc-right {width: 100%;height: 45px;display: flex;align-items: flex-start;justify-content: space-between;}.Calender_Pick .fc-right button {border: 0;height: 35px;width: 100px;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;opacity: 1;font-size: 13px !important;}.Calender_Pick .fc-button-group {height: 35px;border-radius: 50px;}.Calender_Pick .fc-button-group button {background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;display: flex;align-items: center;justify-content: center;width: 60px !important;}.Calender_Pick .fc-button-group button span {font-size: 13px;}.Calender_Pick .fc-day-grid-container {height: auto !important;border-bottom: 1px solid #ddd;}.Calender_Pick .fc-view-container .fc-head-container {color: #ED1C24 !important;}div.modal.edit-form.Modal_Show {display: flex !important;align-items: center;justify-content: center;}.edit-form .modal-content {width: 800px;}.edit-form .modal-content .modal-body {border-radius: 0;}.edit-form .modal-content #myForm .form-group label {padding: 0;font-size: 16px;}.edit-form .modal-content #myForm .form-group #event-title {padding: 10px !important;font-size: 15px;}.edit-form .modal-content .modal-footer button {height: 35px;display: flex;align-items: center;justify-content: center;border-radius: 50px;background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;border: 0;letter-spacing: 1px;}
#err-messages{display: none; text-align: center;}
#submit-button {
    /*height: 35px !important;*/
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 50px !important;
    background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important;
    border: 0 !important;
    letter-spacing: 1px !important;
}
.jconfirm-content-pane {text-align: center !important;}
.jconfirm-buttons {margin-right: 40% !important;}
.fc .fc-row .fc-content-skeleton table, .fc .fc-row .fc-content-skeleton td, .fc .fc-row .fc-helper-skeleton td {padding: 0px !important;}
.Calender_Pick .fc-center {display: none;}
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
$('#submit-button').on('click', function() {
    var user_id = $('#user_id').val();
    var sdateArray = new Array();
    $("input[name=startdate]").each(function() {
        sdateArray.push($(this).val());
    });
    var ftimeArray = new Array();
    $("input[name=fromtime]").each(function() {
        ftimeArray.push($(this).val());
    });
    var edateArray = new Array();
    $("input[name=enddate]").each(function() {
        edateArray.push($(this).val());
    });
    var totimeArray = new Array();
    $("input[name=totime]").each(function() {
        totimeArray.push($(this).val());
    });
    var form_data = new FormData();
    form_data.append('user_id',user_id);
    form_data.append('start_date',sdateArray);
    form_data.append('from_time',ftimeArray);
    form_data.append('end_date',edateArray);
    form_data.append('to_time',totimeArray);
    //alert(form_data);
    $.ajax({
        type:"post",
        url:"<?php echo base_url()?>user/Dashboard/create_availability",
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        data:form_data,
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
    //return false;
})

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const myModal = new bootstrap.Modal(document.getElementById('form'));
    const dangerAlert = document.getElementById('danger-alert');
    const close = document.querySelector('.btn-close');
    const myEvents = JSON.parse(localStorage.getItem('events')) || [
        <?php 
        $availability = $this->db->query("SELECT * FROM user_availability WHERE user_id = '".$_SESSION['afrebay']['userId']."'")->result_array();
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
        <?php } } } ?>
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

    calendar.on('select', function(info) {
        const bookingModal = new bootstrap.Modal(document.getElementById('booking'));
        bookingModal.show();
    });
    calendar.render();
});

function closeAvail() {
    location.reload();
}

function editAvailability(id) {
    var form_data = new FormData();
    form_data.append('avail_id',id);
    $.ajax({
        type:"post",
        url:"<?php echo base_url()?>user/Dashboard/edit_availability",
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        data:form_data,
        success:function(returndata) {
            console.log(returndata);
            var json = $.parseJSON(returndata);
            if(returndata == 1) {
                $.confirm({
                    title: '',
                    content: "Cannot edit availability. You already have booking for this time period!",
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
                const bookingModal = new bootstrap.Modal(document.getElementById('editbooking'));
                bookingModal.show();
                $('#user_id').val(json[0].user_id);
                $('#start_date').val(json[0].start_date);
                $('#from_time').val(json[0].from_time);
                $('#end_date').val(json[0].end_date);
                $('#to_time').val(json[0].to_time);
                $('#avail_id').val(json[0].id);
            }
        }
    });
}

function deleteAvailability(id) {
    //alert(id);
    var form_data = new FormData();
    form_data.append('avail_id',id);
    $.ajax({
        type:"post",
        url:"<?php echo base_url()?>user/Dashboard/delete_availability",
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        data:form_data,
        success:function(returndata) {
            if(returndata == 1) {
                $.confirm({
                    title: '',
                    content: "Cannot delete availability. You already have booking for this time period!",
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
            } else if(returndata == 2) {
                $.confirm({
                    title: '',
                    content: "Data deleted successfuly",
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

$('#update_button').on('click', function() {
    var user_id = $('#user_id').val();
    var avail_id = $('#avail_id').val();
    var start_date = $('#start_date').val();
    var from_time = $('#from_time').val();
    var end_date = $('#end_date').val();
    var to_time = $('#to_time').val();

    var form_data = new FormData();
    form_data.append('user_id',user_id);
    form_data.append('start_date',start_date);
    form_data.append('from_time',from_time);
    form_data.append('end_date',end_date);
    form_data.append('to_time',to_time);
    form_data.append('avail_id',avail_id);
    //alert(form_data);
    $.ajax({
        type:"post",
        url:"<?php echo base_url()?>user/Dashboard/update_availability",
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        data:form_data,
        success:function(returndata) {
            if(returndata == 1) {
                $.confirm({
                    title: '',
                    content: "Data updated successfuly",
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
    //return false;
})
</script>