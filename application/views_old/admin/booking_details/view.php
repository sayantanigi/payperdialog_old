<?php 
$settings = $this->Crud_model->getdata('setting','','','');
//echo "<pre>"; print_r($settings); die;
echo $commission = $settings[0]->commission;
?>
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title"><?= $heading;?></h3>
                </div>
                <div class="col-auto text-right">
                    <!-- <a class="btn btn-white filter-btn" href="javascript:void(0);" id="filter_search">
                    <i class="fas fa-filter"></i>
                </a> -->
                <!-- <a href="#" class="btn btn-primary add-button ml-3" data-toggle="modal" data-target="#createModal">
                <i class="fas fa-plus"></i>
            </a> -->
        </div>
    </div>
</div>

<div class="card filter-card" id="filter_inputs">
    <div class="card-body pb-0">
        <form action="#" method="post">
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control select filter_search_data6" name="">
                            <option value="">Select category</option>
                            <?php
                            if(!empty($get_category)){
                                foreach($get_category as $item){ ?>
                                    <option value="<?= $item->id?>"><?= ucfirst($item->category_name)?></option>
                                <?php   } } ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>From Date</label>
                            <div class="cal-icon">
                                <!--  datetimepicker -->
                                <input class="form-control  filter_search_data5" type="date" name="from_date" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>To Date</label>
                            <div class="cal-icon">
                                <input class="form-control  filter_search_data7" type="date" name="to_date" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <a class="btn btn-primary btn-block" href="<?= admin_url('Category')?>">Refresh</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <table id="table" class="table table-hover table-center mb-0 example_datatable" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Start Date</th>
                                    <th>From Time</th>
                                    <th>End Date</th>
                                    <th>To Time</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            //echo "<pre>"; print_r($get_userdata);
                            if(!empty($get_userdata)) {
                                $i=1;
                                foreach ($get_userdata as $value) { ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $value['start_date']; ?></td>
                                    <td><?= $value['from_time']; ?></td>
                                    <td><?= $value['end_date']?></td>
                                    <td><?= $value['to_time'] ?></td>
                                    <td>
                                        <a href="javascript:void(0)">
                                            <span class="btn btn-sm bg-success-light mr-2" data-toggle="modal" data-target="#editModal" data-placement="right" id="userbookingdetails_<?= $i?>">
                                                <i class="far fa-eye mr-1"></i>View Booking Details
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                <table style="width: 100%">
                                    <tbody>
                                        <tr id="userbookingDetails_<?= $i?>">
                                            <td style="font-size: 14px;">Transaction ID: <br><?= @$value['txn_id']?></td>
                                            <td style="font-size: 14px;">Slot <br> 
                                            <?php 
                                            $bookingTime = explode(',', $value['bookingTime']);
                                            for($j = 0; $j < count($bookingTime); $j++) { 
                                                $getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '".@$value['employer_id']."'")->result_array();
                                            ?>
                                                <p style="margin:0px"><?= date('h:i A', strtotime($bookingTime[$j]))?> to <?= date('h:i A', strtotime($bookingTime[$j]) + 60*60)."<br>"?></p>
                                            <?php } ?>
                                            </td>
                                            <?php $payToemployee = @$value['rate']-(($value['rate']*$commission)/100); ?>
                                            <td style="font-size: 14px;">Booked By <br><?= @$getEmployer[0]['companyname']?></td>
                                            <td style="font-size: 14px;">Total Amount <br> <?= @$value['rate']?></td>
                                            <td style="font-size: 14px;">Pay to Employee <br><?= @$payToemployee?></td>
                                            <td style="font-size: 14px;"><a href="javascript:void(0)">
                                            <span class="btn btn-sm bg-success-light mr-2" data-toggle="modal" data-target="#editModal" data-placement="right" onclick="paytoemployee('<?= $value['employee_id']?>','<?= $value['employer_id']?>','<?= $value['id']?>','<?= $value['rate']?>','<?= $payToemployee?>')">
                                                <i class="far fa-eye mr-1"></i>Pay
                                            </span>
                                        </a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php $i++; } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$(document).ready(function() {
    <?php 
    if(!empty($get_userdata)) {
    $i=1;
    foreach ($get_userdata as $value) { ?>
    $('#userbookingDetails_<?=$i?>').hide();
    $('#userbookingdetails_<?= $i?>').click(function () {
        $('#userbookingDetails_<?= $i?>').toggle();
    })
    <?php $i++; } } ?>
});

function paytoemployee(employee_id, employer_id, bookingtxn_id, rate, payToemployee) {
    alert("employee_id ==> ", employee_id);
    alert("employer_id ==> ", employer_id);
    alert("bookingtxn_id ==> ", bookingtxn_id);
    alert("rate ==> ", rate);
    alert("payToemployee ==> ", payToemployee);
}
</script>
