<?php
if (!empty($get_banner->image) && file_exists('uploads/banner/' . $get_banner->image)) {
    $banner_img = base_url("uploads/banner/" . $get_banner->image);
} else {
    $banner_img = base_url("assets/images/resource/mslider1.jpg");
} ?>
<style media="screen">
.postdetail {
    padding: 7px 33px;
    border-radius: 10px;
    background: red;
    color: #fff;
    margin: 10px;
    font-size: 20px;
}
.cstm_viewbid_btn {
    background: linear-gradient(180deg, rgb(237 28 36) 0%, rgb(237 28 36 / 75%) 100%) !important;
    border: 0;
    border-radius: 35px;
    letter-spacing: 0;
    font-weight: 600;
    width: 100%;
    display: block;
    color: #fff;
    padding: 10px;
    text-align: center;}
</style>
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header text-center">
                        <h3 style="text-transform: uppercase;">
                            <?php if (!empty($post_data->post_title)) {
                                echo $post_data->post_title;
                            } ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dashboard-gig Bid-page">
    <div class="text-success-msg f-20" style="text-align: center; margin-bottom: 20px;">
        <?php if ($this->session->flashdata('message')) {
            echo $this->session->flashdata('message');
            unset($_SESSION['message']);
        } ?>
    </div>
    <div class="container display-table">
        <div class="row display-table-row">
            <div class="col-md-12 col-sm-12 display-table-cell v-align">
                <div class="user-dashboard">
                    <div class="row row-sm">
                        <?php if (@$_SESSION['afrebay']['userType'] == '1') { ?>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 col-12">
                        <?php } else if(@$_SESSION['afrebay']['userType'] == '2'){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                        <?php } else { ?>
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 col-12">
                        <?php } ?>
                            <div class="bid-dis">
                                <ul>
                                    <li>
                                        <span>Job Title </span>
                                        <a href="<?= base_url('postdetail/' . base64_encode($post_data->id)) ?>" style="text-transform: uppercase;">
                                        <?php if (!empty($post_data->post_title)) {
                                            echo $post_data->post_title;
                                        } ?>
                                        </a>
                                    </li>
                                    <?php if (!empty($post_data->description)) { ?>
                                    <li class="cstm_desc"><span>Description</span><?php echo $post_data->description; ?>
                                    <?php } ?>
                                    </li>
                                    <div class="Bid-Data">
                                        <?php if (!empty($post_data->required_key_skills)) { ?>
                                            <li><span>Required key skills </span><?php echo ucfirst($post_data->required_key_skills); ?></li>
                                        <?php } ?>
                                        <?php if (!empty($post_data->appli_deadeline)) { ?>
                                            <li><span>Application Deadline Date </span><?php echo $post_data->appli_deadeline; ?></li>
                                        <?php } ?>
                                    </div>
                                    <div class="Bid-Data">
                                        <?php if (!empty($post_data->category_id)) { ?>
                                        <li><span>Categories </span>
                                            <?php
                                            $cname = $this->db->query("SELECT * FROM category WHERE id = '" . $post_data->category_id . "'")->result_array();
                                            echo $cname[0]['category_name'];
                                            ?>
                                        </li>
                                        <?php } ?>
                                        <?php if (!empty($post_data->subcategory_id)) { ?>
                                        <li><span>Sub Categories </span>
                                            <?php
                                            $scname = $this->db->query("SELECT * FROM sub_category WHERE id = '" . $post_data->subcategory_id . "'")->result_array();
                                            echo $scname[0]['sub_category_name'];
                                            ?>
                                        </li>
                                        <?php } ?>
                                    </div>
                                    <div class="Bid-Data">
                                        <?php if (!empty($post_data->charges)) { ?>
                                        <li><span>Charges </span><?php echo $post_data->charges." ".$post_data->currency ?></li>
                                        <?php } ?>
                                        <?php if (!empty($post_data->duration)) { ?>
                                        <li><span>Duration </span><?php echo $post_data->duration; ?></li>
                                        <?php } ?>
                                    </div>
                                    <div class="Bid-Data">
                                        <?php if (!empty($post_data->remote)) { ?>
                                        <li><span>Remote Job </span>
                                            <?php 
                                            if($post_data->charges == '1') {
                                                echo "Yes";
                                            } else {
                                                echo "No";
                                            } ?>
                                        </li>
                                        <?php } ?>
                                        <?php if (!empty($post_data->job_type)) { ?>
                                        <li><span>Job Type </span>
                                            <?php 
                                            if($post_data->job_type == '1') {
                                                echo "Full-time";
                                            } else {
                                                echo "Part-time";
                                            } ?>
                                        </li>
                                        <?php } ?>
                                    </div>
                                    <div class="Bid-Data">
                                        <?php if (!empty($post_data->experience_level)) { ?>
                                        <li><span>Experience Level </span>
                                            <?php 
                                            if($post_data->experience_level == '1') {
                                                echo "0 to 02 Years";
                                            } else if($post_data->experience_level == '2') {
                                                echo "03 to 05 Years";
                                            } else if($post_data->experience_level == '3') {
                                                echo "06 to 08 Years";
                                            } else if($post_data->experience_level == '4') {
                                                echo "08 to 10 Years";
                                            } else if($post_data->experience_level == '5') {
                                                echo "> 10 Years";
                                            } else {
                                                echo "";
                                            } ?>
                                        </li>
                                        <?php } ?>
                                        <?php if (!empty($post_data->education)) { ?>
                                        <li><span>Education Type </span>
                                            <?php 
                                            if($post_data->education == '1') {
                                                echo "Professional Certificate";
                                            } else if($post_data->education == '2') {
                                                echo "Undergraduate Degrees";
                                            } else if($post_data->education == '3') {
                                                echo "Transfer Degree";
                                            } else if($post_data->education == '4') {
                                                echo "Associate Degree";
                                            } else if($post_data->education == '5') {
                                                echo "Bachelor Degree";
                                            } else if($post_data->education == '6') {
                                                echo "Graduate Degrees";
                                            } else if($post_data->education == '7') {
                                                echo "Master Degree";
                                            } else if($post_data->education == '8') {
                                                echo "Doctoral Degrees";
                                            } else {
                                                echo "";
                                            } ?>
                                        </li>
                                        <?php } ?>
                                    </div>
                                    <?php if (!empty($post_data->country)) { ?>
                                    <li><span>Complete Address </span><?php echo $post_data->city . ', ' . $post_data->state . ', ' . $post_data->country; ?></li>
                                    <?php } ?>
                                </ul>
                                <?php $postedBy = $this->db->query("SELECT * FROM users WHERE userId = '" . $post_data->user_id . "'")->result_array(); ?>
                                <a class="btn btn-info" href="<?= base_url('employerdetail/' . base64_encode($post_data->user_id)) ?>">
                                    <?php
                                    if ($postedBy[0]['userType'] == 1) {
                                        echo $postedBy[0]['firstname'] . ' ' . $postedBy[0]['lastname'];
                                    } else if ($postedBy[0]['userType'] == 2) {
                                        echo $postedBy[0]['companyname'];
                                    } ?>
                                </a>
                            </div>
                            <div class="employe-about d-none">
                                <ul>
                                    <li>
                                        <span class="rat-b">0.0</span>
                                        <span class="fa fa-star checked1"></span>
                                        <span class="fa fa-star checked1"></span>
                                        <span class="fa fa-star checked1"></span>
                                        <span class="fa fa-star checked1"></span>
                                        <span class="fa fa-star checked1"></span>
                                        <span>( 0 reviews )</span>
                                    </li>
                                    <li>
                                        <div class="hope-aus">
                                            <span>
                                            <?php if (!empty($post_data->user_address)) {
                                                echo $post_data->user_address;
                                            } ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="hope-aus1">
                                            <ul>
                                                <!-- <li><a href="javascript:void(0)"><i class="fa fa-shield"></i></a></li> -->
                                                <li><a href="javascript:void(0)"><i class="fa fa-envelope"></i></a></li>
                                                <!-- <li><a href="javascript:void(0)"><i class="fa fa-user"></i></a></li> -->
                                                <li><a href="javascript:void(0)"><i class="fa fa-phone"></i></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php if (@$_SESSION['afrebay']['userType'] == '1' || empty(@$_SESSION['afrebay']['userType'])) { 
                        $profile_check = $this->db->query("SELECT * FROM `users` WHERE userId = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                        if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio']) || empty($profile_check[0]['rateperhour']) || empty($profile_check[0]['resume'])) { ?>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 col-12" style="position: relative;">
                        <p style=" font-size: 24px; margin-top: 50%; text-align: center; line-height: 30px; color: red;">Please complete your profile tab to place your bid</p>
                        <?php } else { ?>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 col-12">
                        <?php } ?>
                            <?php $userBidData = $this->db->query("SELECT * FROM `job_bid` WHERE postjob_id = '".$post_data->id."' and user_id = '".@$_SESSION['afrebay']['userId']."'")->result_array();
                            if(!empty($userBidData)) { ?>
                            <div class="bd-form"><a href="<?= base_url()?>jobbid" class="cstm_viewbid_btn"> View Bid</a></div>
                            <?php } else { ?>
                            <?php if(empty($profile_check[0]['firstname']) || empty($profile_check[0]['lastname']) || empty($profile_check[0]['email']) || empty($profile_check[0]['gender']) || empty($profile_check[0]['address']) || empty($profile_check[0]['short_bio']) || empty($profile_check[0]['rateperhour']) || empty($profile_check[0]['resume'])) { ?>
                            <form class="bd-form" action="<?= base_url('user/dashboard/save_postbid') ?>" method="post" style="position: absolute; top: 0; left: 0; opacity: 0.2; z-index: -999999;">
                            <?php } else { ?>
                                <form class="bd-form" action="<?= base_url('user/dashboard/save_postbid') ?>" method="post">
                            <?php } ?>
                                <h3 class="job-bid">Job Bidding</h3>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="" class="form-label">Bid Amount</label>
                                        <div style="width: 50px;">
                                        <?php if($countryName == 'Nigeria') { ?>
                                            <input type="text" class="form-control f1" name="currency" id="currency" value="NGN (₦)" readonly>
                                        <?php } else { ?>
                                            <input type="text" class="form-control f1" name="currency" id="currency" value="USD ($)" readonly>
                                        <?php } ?>
                                        </div>
                                        <div style="display: inline-block;width: 82%; margin-left: 10px;">
                                            <input type="text" class="form-control f1" placeholder="Your bid Amount" name="bid_amount" id="bid_amount" required>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" class="form-control f1" placeholder="Contact Email" name="email" required>
                                    </div> -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="" class="form-label">Duration</label>
                                        <input type="text" class="form-control f1" placeholder="Duration" name="duration" required>
                                    </div>
                                    <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control f1" placeholder="Phone" name="phone" onkeypress="only_number(event)" required maxlength="10">
                                    </div> -->
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="" class="form-label">Details</label>
                                        <textarea class="form-control" name="description" placeholder="Description"></textarea>
                                    </div>
                                    <input type="hidden" name="postjob_id" value="<?php if (!empty($post_data->id)) { echo $post_data->id; } ?>">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="bid-btn">
                                            <?php if (!empty(@$_SESSION['afrebay']['userType'])) {
                                                if (@$_SESSION['afrebay']['userType'] == '1') {
                                                    //$userBidData = $this->db->query("SELECT * FROM `job_bid` WHERE postjob_id = '".$post_data->id."' and user_id = '".$_SESSION['afrebay']['userId']."'")->result_array();
                                                    //if(!empty($userBidData)) { ?>
                                                        <!-- <a href="<?= base_url()?>jobbid" class="cstm_viewbid_btn"> View Bid</a> -->
                                                    <?php //} else { ?>
                                                        <input type="submit" name="">
                                                    <?php //} ?>
                                            <?php } else { ?>
                                            <h2 class="job-bid" style="font-size:16px;">Verdors are not eligible to Bid for jobs</h2>
                                            <?php }
                                            } else { ?>
                                                <br />
                                                <a href="<?= base_url('login') ?>" class="btn btn-info postdetail">Submit Query</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php } }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<?php if(@$_SESSION['afrebay']['userType'] == '2') { ?>
<section class="max_height">
    <!-- <div class="block no-padding Our_Jobs Employees_Search_List"> -->
    <div class="block no-padding Employees_Search_List">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row no-gape">
                        <h3>Recomended Employee</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12 column Employees_Search_Result">
                    <div class="padding-left">
                        <div class="emply-resume-sec">
                            <div id="post_list">
                            <?php
                            $key_skills = explode(',', $post_data->required_key_skills);
                            $experience = $post_data->experience_level;
                            for ($i=0; $i < count($key_skills); $i++) {
                                $recomendedEmployeeList = $this->db->query("SELECT * FROM users WHERE (skills = '".trim($key_skills[$i])."' OR skills LIkE '%".trim($key_skills[$i])."%') AND experience = '".$experience."'")->result_array();
                                foreach ($recomendedEmployeeList as $value) {
                                    $profile_pic= '<img src="'.base_url('uploads/users/'.$value['profilePic']).'" alt="" />';
                                    if(strlen($value['short_bio'])>100) {
                                        $desc= substr(strip_tags($value['short_bio']), 0,100).'...';
                                    } else {
                                        $desc= strip_tags($value['short_bio']);
                                    }
                                ?>
                                <div class="emply-resume-list"> <div class="emply-resume-thumb"><?= $profile_pic ?></div> <div class="emply-resume-info"> <h3><a href="#" title=""><?= $value['firstname]']." ".$value['lastname']?></a></h3><p><i class="la la-map-marker"></i><?= $value['address']?></p> <p><?= $value['address']?><?= $desc?></p> <p></p> </div> <div class="shortlists" style="width:50px;"><a href="<?= base_url('employerdetail/'.base64_encode($value['userId']))?>" title="">View Profile<i class="la la-plus"></i></a> </div> </div>
                                <?php }
                            } ?>
                            </div>
                            <div align="center" id="pagination_link"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<script>
$(document).ready(function(){
    $("#bid_amount").on("keypress keyup blur", function (event) {
        var patt = new RegExp(/(?<=\.\d\d).+/i);
        $(this).val($(this).val().replace(patt, ''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
})

</script>
