<?php
$get_setting=$this->Crud_model->get_single('setting');
if(!empty($_SESSION['afrebay']['userId'])) {
    $userid=$_SESSION['afrebay']['userId'];
    $get_video=$this->Crud_model->GetData('friends_video','',"subscription_id='".$userid."' and status='0'",'','(video_id)desc','','1');
}
?>
<footer>
    <div class="blocknwe">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 column">
                    <div class="widget">
                        <div class="about_widget">
                            <div class="logo">
                                <a href="<?=base_url(); ?>" title=""><img src="<?=base_url(); ?>uploads/logo/<?= $get_setting->flogo?>" alt="" /></a>
                            </div>
                            <?php if(!empty($get_setting->fabout)) { ?>
                            <span><?= $get_setting->fabout?></span>
                            <?php } else { ?>
                            <span></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 column">
                    <div class="widget">
                        <h3 class="footer-title">Quick Links</h3>
                        <div class="link_widgets">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="<?= base_url('employer-list')?>" title="Businesses">Employer</a>
                                    <a href="<?= base_url('workers-list')?>" title="Freelancers">Job Seeker</a>
                                    <?php if($get_setting->required_subscription == '1') { ?>
                                    <a href="<?= base_url('vendor_pricing')?>" title="">Employer Pricing</a>
                                    <a href="<?= base_url('freelancer_pricing')?>" title="">Job Seeker Pricing</a>
                                    <?php } else { ?>
                                    <a href="<?= base_url('register')?>" title="">Employer Sign up</a>
                                    <a href="<?= base_url('register')?>" title="">Job Seeker Sign up</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 column">
                    <div class="widget">
                        <h3 class="footer-title">Support Link</h3>
                        <div class="link_widgets">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="<?= base_url('about-us')?>" title="About us">About Us</a>
                                    <a href="<?= base_url('contact-us')?>" title="Contact us">Contact Us</a>
                                    <a href="<?= base_url('privacy-policy')?>" title="privacy policy">Privacy Policy</a>
                                    <a href="<?= base_url('term-and-conditions')?>" title="Term & condition">Terms &
                                        Conditions </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 column">
                    <div class="about_widget">
                        <h3 class="footer-title">Contact Us</h3>
                        <div class="link_widgets">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="#"><?= $get_setting->address?></a>
                                    <a href="#"><?= $get_setting->phone ?></a>
                                    <a href="#"><?= $get_setting->email ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="social">
                        <a href="<?php echo $get_setting->fb_link; ?>" title="" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="<?php echo $get_setting->tw_link; ?>" title="" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="<?php echo $get_setting->lnkd_link; ?>" title="" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="<?php echo $get_setting->ptrs_link?>" title="" target="_blank"><i class="fa fa-pinterest"></i></a>
                        <a href="<?php echo $get_setting->baha_link?>" title="" target="_blank"><i class="fa fa-behance"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="bottom-line">
        <div style="color: #fff;text-align: left;width: 48%;display: inline-block;float: left;margin-left: 60px;">Copyright © <?php echo date('Y')?> PayPerLLC. All rights reserved.</div>
        <div style="color: #fff;text-align: right;width: 38%;display: inline-block;">Designed &amp; Developed By <a href="http://www.goigi.com/" class="igi-link" target="_blank" style="color: #08cbfe;">GOIGI.COM</a></div>
        <a href="#scrollup" class="scrollup" title=""><i class="la la-arrow-up"></i></a>
    </div>
</footer>
<input type="hidden" name="base_url" id="base_url" value="<?= base_url()?>">
<!-- <input type="text" name="paymentLocation" id="paymentLocation" value=""> -->
<style>
<?php $seg2 = $this->uri->segment(1);
    if($seg2 == 'register') { ?>
        .scrollup {display: none !important;}
    <?php } elseif ($seg2 != 'login') { ?>
        .scrollup {display: none !important;}
    <?php } ?>
</style>
<?php
if(!empty($_SESSION['afrebay']['userId'])){
    if(!empty($get_video->created_date)){
        $date=date('Y-m-d',strtotime(@$get_video->created_date));
    }
    if(@$_SESSION['afrebay']['userId']==@$get_video->subscription_id && $date==date('Y-m-d') && @$get_video->status=='0'){
?>
<div id="video_modal" class="modal modal-top fade calendar-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Receive video calling </h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"
                    onclick="receiveVideoCallWindow(<?= @$get_video->publisher_id?>);">video call</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php }
} ?>
<div class="modal fade edit-form" id="aggrementmodal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog" role="document" style="display: contents;">
        <div class="modal-content" style="max-height: 600px;overflow: auto;width: 1200px;left: 100px;top: 100px;">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Agreement</h5>
                <button type="button" class="bookBtn-close btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeaggrmnt()" style="background: none; padding: 0; margin: 0;">X</button>
            </div>
            <form id="myForm">
                <div class="modal-body" style="margin: 10px;">
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
                        <div class="form-group date">
                            <input type="checkbox" id="aggrchckkkkk" style="opacity: 1; z-index: 50; margin-top: 8px;">
                            <p style="display: inline-block; margin-left: 25px; margin-top: 0px; margin-bottom: 0px;" class="user_aggrmnt">I have read and agree to PayperLLC aggrement and Policy.</p>
                            <p class="erroraggr" style="margin: 0;width: 100%;text-align: center;color: red;font-size: 12px;">Please check the checkbox.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <!-- <button type="submit" class="btn btn-success" id="submit-button1">Schedule</button> -->
                    <input type="button" class="btn btn-success" id="submit-button" value="Next" onclick="aggrement()">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade edit-form" id="aggrementmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="height: fit-content;" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog" role="document" style="left: 6px;max-width: 1200px;">
        <div class="modal-content" style="width: 1200px;max-height: 650px;overflow: auto;">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="modal-title">Agreement</h5>
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
                    <input type="button" class="btn btn-success" id="submit-button" value="Next" onclick="bookNow()">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/modernizr.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/script.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/wow.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/slick.min.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/parallax.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/select-chosen.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/maps2.js')?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/bootstrap-datepicker.js')?>" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtg6oeRPEkRL9_CE-us3QdvXjupbgG14A&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript" src="<?= base_url('assets/custom_js/validation.js')?>"></script>
<script src="<?= base_url();?>dist/assets/notify/notify.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/multi_select/css/modern/tail.select-dark-feather.min.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/multi_select/css/modern/tail.select-dark.min.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/multi_select/css/modern/tail.select-light-feather.min.css" />
<link rel="stylesheet" href="<?php echo base_url()?>assets/multi_select/css/modern/tail.select-light.min.css" />
<script src="<?php echo base_url()?>assets/multi_select/js/tail.select.min.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-de.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-es.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-fi.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-fr.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-it.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-no.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-pt_BR.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-ru.js"></script>
<script src="<?php echo base_url()?>assets/multi_select/langs/tail.select-tr.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<style>
.modal-backdrop.show {
    opacity: 0.5;
}
#aggrementmodal p {font-size: 10px; line-height: 15px; margin: 2px 0 0 0;}
#aggrementmodal .myForm {margin: 10px}
</style>
<script type="text/javascript">
var confirmTextDelete = 'Are you sure you want to delete this record?';
var confirmationText = 'Are you sure you want to change this status?';
$(document).ready(function () {
    $('.erroraggr').hide();
    // alert(1);
    tail.select('#example',{
        startOpen: true,
        multiple: true,
        stayOpen: true,
        multiPinSelected: true,
        multiShowCount: false,
        multiShowLimit: true,
        multiContainer: true,
        search: true,
        searcgConfig: [
            "text", "value"
        ],
        searchFocus: true,
        searchMarked: true,
        searchMinLength: 1,
    });
    var sessionMessage = '<?php echo $this->session->userdata('
    message ') <> '
    ' ? $this->session->userdata('
    message ') : '
    '; ?>';
    if (sessionMessage == null || sessionMessage == "") {
        return false;
    }
    $.notify(sessionMessage, {
        position: "top right",
        className: 'success'
    }); //session msg

    $('.dropdown-optgroup').click(function() {
        var selected = $(".dropdown-optgroup :selected").map((_,e) => e.value).get();
        alert(selected);
    });
});
setInterval(function () {
    $('#video_modal').modal('show');
}, 5000);

var targetDiv = $('.about_widget img').attr('src');
var targetDiv1 = $('.hidden-logo').val();
$(window).scroll(function () {
    var windowpos = $(window).scrollTop();
    if (windowpos >= 50) {
        $(".Header_Menu_Nav img").attr("src", targetDiv);
        $(".Header_Menu_Nav img").attr("src", targetDiv);
    } else {
        $(".Header_Menu_Nav img").attr("src", targetDiv1);
        $(".Header_Menu_Nav img").attr("src", targetDiv1);
    }

});

function receiveVideoCallWindow(fid) {
    $('#video_modal').css('display', 'none');
    var callPath = "<?php echo base_url('livevideo/video/');?>" + fid;
    window.open(callPath, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=250,left=20,width=600,height=450");
}

<?php if(@$_SESSION['afrebay']['userType'] == '1' || @$_SESSION['afrebay']['userType'] == '3') {
$checkuseraggreed = $this->db->query("SELECT * FROM users WHERE userId = '".$_SESSION['afrebay']['userId']."'")->result_array();
if(empty($checkuseraggreed[0]['isAggreed'])) { ?>
    $(document).ready(function() {
        $("#aggrementmodal1").modal({backdrop:'static', keyboard: false, show: true});
    })
<?php } } ?>

function aggrement() {
    if($("#aggrchckkkkk").is(":checked") == true) {
        var userid = <?php echo $_SESSION['afrebay']['userId'] ?>;
        $.ajax({
            type:"post",
            url:"<?php echo base_url()?>user/Dashboard/checktoaggrement",
            data:{userid: userid},
            success:function(returndata) {
                //alert(returndata);
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

function closeaggrmnt() {
    $('#aggrementmodal1').modal('hide');
}
</script>
</body>
</html>
