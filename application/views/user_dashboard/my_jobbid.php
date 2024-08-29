<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= base_url('assets/images/resource/mslider1.jpg') ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
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
                <?php if ($_SESSION['afrebay']['userType'] == '1') { ?>
                    <h2 class="breadcrumb-title">My Jobs</h2>
                <?php } else { ?>
                    <h2 class="breadcrumb-title">List of Bids</h2>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('sidebar'); ?>
<div class="<?php if ($_SESSION['afrebay']['userType'] == '1' || @$_SESSION['afrebay']['userType'] == '3') { echo "col-md-7"; } else { echo "col-md-12";} ?> col-sm-12 display-table-cell v-align">
    <div class="text-success-msg f-20" style="text-align: center;">
        <?php if ($this->session->flashdata('message')) {
            echo $this->session->flashdata('message');
            unset($_SESSION['message']);
        } ?>
    </div>
    <div class="user-dashboard" style="text-align: center;">
        <div class="row row-sm">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="cardak custom-cardak my-jobs-mobile">
                    <table class="table table-modific">
                        <tbody>
                            <?php
                            if (!empty ($get_postjob)) {
                                $i = 1;
                                foreach ($get_postjob as $key) { ?>
                                    <tr>
                                        <td class="table-modific-td">
                                            <table class="custom-table">
                                                <tr>
                                                    <td class="heading">
                                                        <?= $key->post_title; ?>
                                                    </td>
                                                    <td class="btn-option" style="width: 205px;">
                                                        <!-- <?php if ($_SESSION['afrebay']['userType'] == '2') { ?>
                                                        <?php if (@$key->bidding_status == 'Pending') { ?>
                                                        <a href="#" onclick="change_biddingstatus('<?= $key->id ?>');"><span class="badge badge-warning" ><?= @$key->bidding_status; ?></span></a>
                                                        <?php } else if (@$key->bidding_status == 'Accept') { ?>
                                                        <span class="badge badge-success"><?= @$key->bidding_status; ?></span>
                                                        <?php } else if (@$key->bidding_status == 'Reject') { ?>
                                                        <span class="badge badge-danger"><?= @$key->bidding_status; ?></span>
                                                        <?php } ?>
                                                        <?php } else {
                                                            echo @$key->bidding_status;
                                                        } ?> -->
                                                        <?php
                                                        if ($_SESSION['afrebay']['userType'] == '2') {
                                                            //if (@$key->bidding_status == 'Under Review' || @$key->bidding_status == 'Short Listed' || @$key->bidding_status == 'Pending' || empty (@$key->bidding_status)) {
                                                            if (@$key->bidding_status == 'Screened In' || @$key->bidding_status == 'Pending' || empty (@$key->bidding_status)) { ?>
                                                                <select class="jobbid_select form-control" name="change_biddingstatus" id="change_biddingstatus_<?php echo @$key->id ?>" style="width: 80% !important;">
                                                                    <option value="">Select Option</option>
                                                                    <!-- <option value="Under Review" <?php if (@$key->bidding_status == 'Under Review') { echo "Selected"; } ?>>Under Review</option>
                                                                    <option value="Short Listed" <?php if (@$key->bidding_status == 'Short Listed') { echo "Selected"; } ?>>Short Listed</option>
                                                                    <option value="Rejected" <?php if (@$key->bidding_status == 'Rejected') { echo "Selected"; } ?>>Rejected</option>
                                                                    <option value="Selected" <?php if (@$key->bidding_status == 'Selected') { echo "Selected"; } ?>>Selected</option> -->
                                                                    <option value="Screened Out" <?php if (@$key->bidding_status == 'Screened Out') { echo "Selected"; } ?>>Screened Out</option>
                                                                    <option value="Screened In" <?php if (@$key->bidding_status == 'Screened In') { echo "Selected"; } ?>>Screened In</option>
                                                                    <option value="Ready for Interview" <?php if (@$key->bidding_status == 'Ready for Interview') { echo "Selected"; } ?>>Ready for Interview</option>
                                                                </select>
                                                                <input type="hidden" name="jodBidid" id="jodBidid_<?php echo @$key->id ?>" value="<?php echo @$key->id ?>" />
                                                                <input type="hidden" name="postJobid" id="postJobid_<?php echo @$key->id ?>" value="<?php echo @$key->postjob_id ?>" />
                                                                <input type="hidden" name="jobbiduserid" id="jobbiduserid_<?php echo @$key->id ?>" value="<?php echo @$key->userid ?>" />
                                                                <input type="hidden" name="jobpostuserid" id="jobpostuserid_<?php echo @$key->id ?>" value="<?php echo @$key->user_id ?>" />
                                                            <?php } else {
                                                                echo "<p> $key->bidding_status</p>";
                                                                if($key->bidding_status == 'Ready for Interview' && !empty(@$key->meeting_link)) {
                                                                    echo  "<a href='". @$key->meeting_link."'>Meeting Link</a>";
                                                                }
                                                            }
                                                        } else {
                                                            echo "<p>$key->bidding_status</p>";
                                                            if($key->bidding_status == 'Ready for Interview' && !empty(@$key->meeting_link)) {
                                                                echo  "<a href='". @$key->meeting_link."'>Meeting Link</a>";
                                                            }
                                                        } ?>
                                                        <a href="javascript:void(0)" id="view_<?php echo $key->id ?>" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        <div class="modal fade" id="exampleModal_<?php echo $key->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog list-job-modal">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Job Bid Details</h5>
                                                                        <button type="button" class="btn-close modalClose_<?php echo $key->id ?>" data-bs-dismiss="modal" aria-label="Close">X</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 list-job-modal-col">
                                                                                <p>Bid Amount : <span>$ <?php echo $key->bid_amount ?> </span></p>
                                                                            </div>
                                                                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 list-job-modal-col">
                                                                                <p>Email : <span><?php echo $key->email ?></span></p>
                                                                            </div> -->
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 list-job-modal-col">
                                                                                <p>Duration : <span><?php echo $key->duration ?></span></p>
                                                                            </div>
                                                                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 list-job-modal-col">
                                                                                <p>Phone Number : <span><?php echo $key->mobile ?></span></p>
                                                                            </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="bid_contact-profile">
                                                        <?php
                                                        //if(empty($key->profilePic))
                                                        if (@$key->profilePic && file_exists('uploads/users/' . @$key->profilePic)) { ?>
                                                            <img src="<?php echo base_url() ?>uploads/users/<?php echo $key->profilePic ?>" alt="" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url() ?>uploads/users/user.png" alt="" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <?php } ?>
                                                        <a href="<?php echo base_url() ?>worker-detail/<?php echo base64_encode($key->userid) ?>" target="_blank">
                                                            <p><?= $key->fullname; ?></p>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="bid-amount">
                                                        <label>Bid Amount:</label>
                                                        <?= "USD" . " " . $key->bid_amount; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="year">
                                                        <label>Date:</label>
                                                        <?= date('d-M-Y', strtotime($key->created_date)); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="desc">
                                                        <?php echo $key->description ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="height"></td>
                                    </tr>
                                    <?php $i++;
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="6">
                                        <center>No Data Found</center>
                                        <?php if ($_SESSION['afrebay']['userType'] == '1') {
                                            $get_setting = $this->Crud_model->get_single('setting');
                                            if ($get_setting->required_subscription == '1') {
                                                $get_sub_data = $this->db->query("SELECT * FROM employer_subscription where employer_id = " . $_SESSION['afrebay']['userId'] . " and payment_status = 'paid'")->result_array();
                                                if (!empty ($get_sub_data)) {
                                                    $profile_check = $this->db->query("SELECT `firstname`, `lastname`, `email`, `gender`, `address`, `rateperhour`, `resume`, `short_bio` FROM `users` WHERE userId = '" . @$_SESSION['afrebay']['userId'] . "'")->result_array();
                                                    if (empty ($profile_check[0]['firstname']) || empty ($profile_check[0]['lastname']) || empty ($profile_check[0]['email']) || empty ($profile_check[0]['gender']) || empty ($profile_check[0]['address']) || empty ($profile_check[0]['rateperhour']) || empty ($profile_check[0]['resume']) || empty ($profile_check[0]['short_bio'])) { ?>
                                                        <button class="post-job-btn pull-right" type="submit" style=" background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 79%) 100%) !important; border: 0 !important; "><a href="javascript:void(0)" onclick="completeSub()">Apply for Jobs</a></button>
                                                    <?php } else { ?>
                                                        <button class="post-job-btn pull-right" type="submit" style=" background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 79%) 100%) !important; border: 0 !important; "><a href="<?= base_url('ourjobs') ?>" title="" target="_blank">Apply for Jobs</a></button>
                                                    <?php }
                                                } else { ?>
                                                    <button class="post-job-btn pull-right" type="submit" style=" background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 79%) 100%) !important; border: 0 !important; "><a href="javascript:void(0)" onclick="completeSub()">Apply for Jobs</a></button>
                                                <?php }
                                            } else {
                                                $profile_check = $this->db->query("SELECT `firstname`, `lastname`, `email`, `gender`, `address`, `rateperhour`, `resume`, `short_bio` FROM `users` WHERE userId = '" . @$_SESSION['afrebay']['userId'] . "'")->result_array();
                                                if (empty ($profile_check[0]['firstname']) || empty ($profile_check[0]['lastname']) || empty ($profile_check[0]['email']) || empty ($profile_check[0]['gender']) || empty ($profile_check[0]['address']) || empty ($profile_check[0]['rateperhour']) || empty ($profile_check[0]['resume']) || empty ($profile_check[0]['short_bio'])) { ?>
                                                    <button class="post-job-btn pull-right" type="submit" style=" background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 79%) 100%) !important; border: 0 !important; "><a href="javascript:void(0)" onclick="completeSub1()">Apply for Jobs</a></button>
                                                <?php } else { ?>
                                                    <button class="post-job-btn pull-right" type="submit" style=" background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 79%) 100%) !important; border: 0 !important; "><a href="<?= base_url('ourjobs') ?>" title="" target="_blank">Apply for Jobs</a></button>
                                                <?php }
                                            } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($_SESSION['afrebay']['userType'] == '1' ||@$_SESSION['afrebay']['userType'] == '3') { ?>
<div class="col-md-3 col-6 v-align CustomDesign" style="display: inline-block; float: left; margin-top: 10px;">
    <p class="CustomPara">Upcoming Booking</p>
    <div class="CustomBlock">
        <?php
        $selectDate = date('Y-m-d');
        $employeeId = $_SESSION['afrebay']['userId'];
        $availableData = $this->db->query("SELECT user_availability.*, user_booking.* FROM user_availability JOIN user_booking ON user_availability.id = user_booking.available_id WHERE start_date > '" . $selectDate . "' AND user_id ='" . @$employeeId . "'")->result_array();
        foreach ($availableData as $value) { ?>
            <p class="ParaHeading"><?= $value['start_date'] ?></p>
            <div style='width: 100%; display: inline-block; padding: 0 10px; margin-bottom: 20px;'>
                <div style='width: 100%; display: inline-block; border-radius: 10px; box-shadow: 0 0 10px #dddddd; padding: 10px 0 10px 0;'>
                    <?php $getBookSlot = explode(',', $value['bookingTime']);
                    $meetingLink = explode(',', $value['meeting_link']);
                    for ($i = 0; $i < count($getBookSlot); $i++) { ?>
                        <?php
                        $booking_id = $value[$i]['id'];
                        $employee_id = $value[$i]['employee_id'];
                        $employer_id = $value[$i]['employer_id'];
                        $available_id = $value[$i]['available_id'];
                        $bookingTime = $value[$i]['bookingTime'];
                        ?>
                        <div style='width: 100%;float: left;display: flex; position: relative; align-items: center; justify-content: space-between; flex-direction: row;'>
                            <p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;'>
                                <?= date('h:i A', strtotime($getBookSlot[$i])) ?> to
                                <?= date('h:i A', strtotime($getBookSlot[$i]) + 60 * 60) ?>
                            </p>
                            <p style="width: 100%;display: inline-block;float: left;margin: 0px;font-size: 12px; padding-left: 20px;"><a href="<?= $meetingLink[$i] ?>">Meeting Link</a></p>
                            <!-- <input type='checkbox' style='position: unset; z-index: 1; opacity: 1; margin: 0px 10px 0px 0px;' id='completecheck' name='completecheck' value='1' onclick='completecheck(<?= $booking_id; ?>)'> -->
                        </div>
                    <?php }
                    $getEmployer = $this->db->query("SELECT * FROM users WHERE userId = '" . @$value['employer_id'] . "'")->row(); ?>
                    <div>
                        <p style='width: 100%;display: inline-block;float: left;margin: 0px;font-size: 14px;'>Booked By:
                            <?= @$getEmployer->companyname ?>
                        </p>
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
<div class="modal fade edit-form" id="aggrementmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document" style="position: relative;top: 0;right: 255px;">
        <div class="modal-content" style="width: 1200px;max-height: 650px;overflow: auto;">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Agreement</h5>
                <button type="button" class="bookBtn-close btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeaggrmnt()" style="background: none;color: #000;padding: 0;margin: 0;">x</button>
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
                        <input type="checkbox" id="aggrchck" name="vehicle2" value="1" style="opacity: 1; z-index: 50; margin-top: 1px;">
                        <p style="display: inline-block; margin-left: 18px; margin-top: 0px; margin-bottom: 0px;" class="user_aggrmnt">I have read and agree to PayperLLC aggrement and Policy.</p>
                        <p class="erroraggr" style="margin: 0;width: 100%;text-align: center;color: red;font-size: 12px;">Please check the checkbox.</p>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <input type="button" class="btn btn-success" id="submit-button" value="Next" onclick="bookNow()">
                    <input type="hidden" name="bidstatus" id="bidstatus" value="">
                    <input type="hidden" name="jodBidid" id="jodBidid"  value="">
                    <input type="hidden" name="postJobid" id="postJobid"  value="">
                    <input type="hidden" name="jobbiduserid" id="jobbiduserid"  value="">
                    <input type="hidden" name="jobpostuserid" id="jobpostuserid"  value="">
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .modal-dialog {max-width: 700px !important; margin-top: 80px;}
    #myForm * {
        font-size: 10px;
        line-height: normal;
        margin: 5px 0 0 0;
    }
</style>
<script type="text/javascript">
/*function change_biddingstatus(jobbid_id) {
    var cnf = confirm('Are you sure to change the status?');
    if(cnf==true) {
        $.ajax({
            type:"POST",
            url:'<?= base_url('user/dashboard/changebiddingstatus') ?>',
            data:{jobbid_id:jobbid_id},
            success:function(returndata) {
                if(returndata==1){
                    location.reload();
                }
            }
        });
    }
}*/
$(document).ready(function () {
    $('.erroraggr').hide();
    <?php if (!empty ($get_postjob)) {
        $i = 1;
        foreach ($get_postjob as $value) { ?>
            $('#view_<?php echo $value->id ?>').click(function () {
                $('#exampleModal_<?php echo $value->id ?>').css("opacity", "1");
                $('#exampleModal_<?php echo $value->id ?>').css("display", "block");
                $('#exampleModal_<?php echo $value->id ?>').css("top", "0");
                $('#exampleModal_<?php echo $value->id ?>').css("background", "#0e0d0d9e");
                $('.modal-content').css("top", "220px");
            })
            $('.modalClose_<?php echo $value->id ?>').click(function () {
                $('#exampleModal_<?php echo $value->id ?>').css("opacity", "0");
                $('#exampleModal_<?php echo $value->id ?>').css("display", "none");
            })

            $('#change_biddingstatus_<?php echo $value->id ?>').change(function () {
                var bidstatus = $('#change_biddingstatus_<?php echo $value->id ?>').val();
                var jodBidid = $('#jodBidid_<?php echo $value->id ?>').val();
                var postJobid = $('#postJobid_<?php echo $value->id ?>').val();
                var jobbiduserid = $('#jobbiduserid_<?php echo $value->id ?>').val();
                var jobpostuserid = $('#jobpostuserid_<?php echo $value->id ?>').val();
                $.confirm({
                    title: 'Confirm!',
                    content: confirmationText,
                    buttons: {
                        confirm: function () {
                            $.ajax({
                                type: "POST",
                                url: '<?= base_url('user/dashboard/changebiddingstatus') ?>',
                                data: { bidstatus: bidstatus, jodBidid: jodBidid, postJobid: postJobid, jobbiduserid: jobbiduserid, jobpostuserid: jobpostuserid },
                                success: function (returndata) {
                                    //console.log(returndata);
                                    const aggrementmodal = new bootstrap.Modal(document.getElementById('aggrementmodal'));
                                    aggrementmodal.show();
                                    $('#bidstatus').val(bidstatus);
                                    $('#jodBidid').val(jodBidid);
                                    $('#postJobid').val(postJobid);
                                    $('#jobbiduserid').val(jobbiduserid);
                                    $('#jobpostuserid').val(jobpostuserid);
                                    // if (returndata == 1) {
                                    //     location.reload();
                                    // }
                                }
                            });
                        },
                        cancel: function () {
                            location.reload();
                        },
                    }
                });
            })
            <?php $i++;
        }
    } ?>
})
function closeaggrmnt() {
    location.reload();
}

function bookNow() {
    if($("#aggrchck").is(":checked")) {
        var bidstatus = $('#bidstatus').val();
        var jodBidid = $('#jodBidid').val();
        var postJobid = $('#postJobid').val();
        var jobbiduserid = $('#jobbiduserid').val();
        var jobpostuserid = $('#jobpostuserid').val();
        $.ajax({
            type:"post",
            url:"<?php echo base_url()?>user/Dashboard/checktoaggrement",
            data:{bidstatus: bidstatus, jodBidid: jodBidid, postJobid: postJobid, jobbiduserid: jobbiduserid, jobpostuserid: jobpostuserid},
            success:function(returndata) {
                console.log(returndata);
                if(returndata == 1) {
                    location.reload();
                } else {
                    $.alert({
                        title: '',
                        content: "Something went wrong. Please try again later.",
                    });
                    return false;
                }
            }
        });
    }  else {
        $('.erroraggr').show();
        setTimeout(() => {
            $('.erroraggr').hide();
        }, 5000);
    }
}
</script>