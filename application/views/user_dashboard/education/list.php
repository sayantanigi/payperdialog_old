<section class="overlape">
	<div class="block no-padding">
		<div data-velocity="-.1" style="background: url(assets/images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
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
				<h2 class="breadcrumb-title">Educations</h2>
				<!-- <nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">My Education</li>
					</ol>
				</nav> -->
			</div>
		</div>
	</div>
</section>
<?php $this->load->view('sidebar');?>
<div class="col-md-7 col-sm-12 display-table-cell v-align">
	<div class="user-dashboard">
		<div class="row row-sm">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="cardak custom-cardak">
					<span class="text-success-msg f-20" style="text-align: center;">
					<?php if($this->session->flashdata('message')) {
					   echo $this->session->flashdata('message');
					   unset($_SESSION['message']);
					} ?>
					</span>
					<table class="table table-modific">
						<tbody>
						<?php  if(!empty($education_list)) {
						$i=1;
						foreach ($education_list as $row) {
						?>
						<tr>
							<td class="table-modific-td">
						 		<table class="custom-table">
								  	<tr>
								  		<td class="heading"><?= ucfirst($row->education); ?> <div>in</div> <?= $row->department; ?></td>
								  		<td class="heading"><?= $row->college_name; ?></td>
									  	<td class="btn-option">
									   		<a href="<?= base_url('update-education/'.base64_encode($row->id));?>"><i class="fa fa-edit" aria-hidden="true"></i></a>
									   		<!-- <a href="<?= base_url('user/Dashboard/delete_education/'.$row->id);?>" onclick="if(confirm('Are you sure you want to Delete?')) commentDelete(1); return false"><i class="fa fa-trash-o" aria-hidden="true"></i></a> -->
											<a href="javascript:void(0)" onclick="deleteEducation(<?= $row->id?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								  		</td>
								  	</tr>
								  	<tr>
								  		<td colspan="2" class="year"><?= $row->passing_of_year; ?></td>
								  	</tr>
									<tr>
										<td colspan="2" class="desc"><?= strip_tags($row->description); ?></td>
									</tr>
							 	</table>
						 	</td>
						</tr>
					  	<tr>
					  		<td colspan="2" class="height"></td>
					  	</tr>
					  	<?php $i++;} } else { ?>
					  	<tr>
					  		<td colspan="6"><center>No Data Found</center></td>
					  	</tr>
					  	<?php } ?>
						</tbody>
			   		</table>
		   		</div>
	   		</div>
			<div class="col-xl-12 col-lg-12 col-md-12" style="text-align: right;">
				<a href="<?php echo base_url('add-education')?>" class="btn btn-primary Education_Btn" style="border-radius: 40px; letter-spacing: 0;">Add Education</a>
			</div>
   		</div>
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
<script>
function deleteEducation(id) {
	var e_id = id;
    $.confirm({
	    title: 'Confirm!',
	    content: confirmTextDelete,
	    buttons: {
	        confirm: function () {
                var base_url = $('#base_url').val();
                $.ajax({
                    url:base_url+"user/dashboard/delete_education",
                    method:"POST",
                    data:{id: e_id},
                    beforeSend : function(){
                        $("#loader").show();
                    },
                    success:function(data) {
                        if (data == '1'){
                            setTimeout(function () {
                                location.reload(true);
                            }, 3000);
                        } else {
                            $('#err-messages').show();
                            setTimeout(function () {
                                window.scroll({top: 0, behavior: "smooth"})
                            }, 7000);
                            setTimeout(function () {
                                $('#err-messages').hide();
                            }, 9000);
                            setTimeout(function () {
                                location.reload(true);
                            }, 10000);
                        }
                    }

                })
	        },
	        cancel: function () {
	            location.reload();
	        },
	    }
	});
}
</script>
