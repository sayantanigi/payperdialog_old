<?php
error_reporting(0);
if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){
    $banner_img=base_url("uploads/banner/".$get_banner->image);
} else {
    $banner_img=base_url("assets/images/resource/mslider1.jpg");
} ?>

<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Post Jobs</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block no-padding">
        <div class="container">
            <div class="row no-gape">
                <div class="col-lg-12 column">
                    <div class="padding-left">
                        <div class="profile-title" style="text-align: center;">
                            <?php if(empty(@$id)) { ?>
                            <h3>Post a New Job</h3>
                            <?php } else { ?>
                            <h3>Update Posted Job</h3>
                            <?php } ?>
                            <span class="text-success-msg f-20" style="text-align: center;">
                            <?php if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                                unset($_SESSION['message']);
                            } ?>
                            </span>
                        </div>
                        <div class="profile-form-edit post-job-page">
                            <?php $seg1=$this->uri->segment(1);
                            if($seg1 == 'update-postjob') { ?>
                            <form method="post" action="<?php echo base_url('Welcome/edit_post_job')?>" enctype="multipart/form-data" style="padding: 0 !important;" >
                            <?php } else { ?>
                                <form method="post" action="<?php echo base_url('Welcome/save_postjob')?>" enctype="multipart/form-data"  style="padding: 0 !important;">
                            <?php } ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <span class="pf-title">Job Title <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <input type="text" placeholder="Enter Job Title" name="post_title" id="post_title" class="form-control " value="<?= @$post_title; ?>" data-role="tagsinput" required/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <span class="pf-title">Description</span>
                                        <div class="pf-field">
                                            <textarea name="description" id="description" placeholder="Enter Description"><?= @$description; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <span class="pf-title">Required Skill Set <span style="color:red;">*</span></span>
                                        <div class="pf-field custom-select">
                                            <select class="form-control key_skills" multiple="multiple" name="key_skills[]" id="key_skills" style="width: 100%;">
                                            <!-- <?php foreach($getkey_skills as $val) {?>
                                                <option value="<?php echo $val->specialist_name; ?>"><?php echo $val->specialist_name;?></option>
                                            <?php } ?> -->
                                            <?php
                                            $skills = $this->Crud_model->GetData('specialist',"","status = 'Active'");
                                            foreach($skills as $val) {?>
                                                <option value="<?php echo $val->specialist_name; ?>"
                                                <?php if(!empty($key_skills)) {
                                                    if(!empty($skills)){
                                                        $vskills = explode(", ", $key_skills);
                                                        for($i=0; $i<count($vskills); $i++) {
                                                            if($vskills[$i] == $val->specialist_name){
                                                                echo "selected";
                                                            }
                                                        }
                                                    }
                                                } ?>><?php echo $val->specialist_name;?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="pf-title">Approximate Duration</span>
                                        <div class="pf-field">
                                            <!-- <input type="text" placeholder="Enter Duration" name="duration" class="form-control " value="<?= @$duration; ?>"/> -->
                                            <select data-placeholder="Please Select Category" class="form-control" name="duration">
                                                <option value="">Select Category</option>
                                                <option value="Less than a Week" <?php if(@$duration == 'Less than a Week') {echo "selected"; }?>>Less than a Week</option>
                                                <option value="1-2 Weeks" <?php if(@$duration == '1-2 Weeks') {echo "selected"; }?>>1-2 Weeks</option>
                                                <option value="2-4 Weeks" <?php if(@$duration == '2-4 Weeks') {echo "selected"; }?>>2-4 Weeks</option>
                                                <option value="1-2 Months" <?php if(@$duration == '1-2 Months') {echo "selected"; }?>>1-2 Months</option>
                                                <option value="More than 2 Months" <?php if(@$duration == 'More than 2 Months') {echo "selected"; }?>>More than 2 Months</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="pf-title">Hourly Remuneration ($)</span>
                                        <div style="width: 75px;">
                                        <?php if($countryName == 'Nigeria') { ?>
                                            <input type="text" class="form-control f1" name="currency" id="currency" value="NGN (₦)" readonly style=" padding: 15px; ">
                                        <?php } else { ?>
                                            <input type="text" class="form-control f1" name="currency" id="currency" value="USD ($)" readonly style=" padding: 15px; ">
                                        <?php } ?>
                                        </div>
                                        <div class="pf-field" style=" float: left; width: 85%; margin-left: 10px; ">
                                            <input type="text" placeholder="Enter Charges" name="charges" class="form-control " value="<?= @$charges; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="pf-title">Industry <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select data-placeholder="Please Select Category" class="form-control" name="category_id" onchange="get_subcategory(this.value)" required>
                                                <option value="">Select Category</option>
                                                <?php
                                                $getcategory = $this->Crud_model->GetData('category', 'id, category_name', "");
                                                foreach($getcategory as $key) {?>
                                                    <option value="<?= $key->id; ?>" <?php if($key->id == $category) {echo "selected"; }?>><?php echo $key->category_name;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="pf-title">Sub Categories </span>
                                        <div class="pf-field">
                                            <select data-placeholder="Please Select " class="form-control" name="subcategory_id" value="" id="subcategory_id">
                                                <?php if(empty($id)) { ?>
                                                <option>Select Subcategory</option>
                                                <?php } else { ?>
                                                <option>Select Subcategory</option>
                                                    <?php
                                                    $getsubcategory = $this->Crud_model->GetData('sub_category', 'id, sub_category_name', "");
                                                    foreach($getsubcategory as $key) {?>
                                                        <option value="<?= $key->id; ?>" <?php if($key->id == $subcategory) {echo "selected"; }?>><?php echo $key->sub_category_name;?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <span class="pf-title">Remote Only <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select data-placeholder="Please Select an Option" class="form-control" name="remote" required>
                                                <option value="">Select Option</option>
                                                <option value="2" <?php if(@$remote == 2) {echo 'selected';}?>>a&#41; No</option>
                                                <option value="1" <?php if(@$remote == 1) {echo 'selected';}?>>b&#41; Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <span class="pf-title">Job Type <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select data-placeholder="Please Select Job Type" class="form-control" name="job_type" required>
                                                <option value="">Select Option</option>
                                                <option value="1" <?php if(@$job_type == 1) {echo 'selected';}?>>Full-time</option>
                                                <option value="2" <?php if(@$job_type == 2) {echo 'selected';}?>>Part-time</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <span class="pf-title">Experience Level <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select data-placeholder="Please Select Experience Level" class="form-control" name="experience_level" required>
                                                <option value="">Select Option</option>
                                                <option value="1" <?php if(@$experience_level == 1) {echo 'selected';}?>>0 to 02 Years</option>
                                                <option value="2" <?php if(@$experience_level == 2) {echo 'selected';}?>>03 to 05 Years</option>
                                                <option value="3" <?php if(@$experience_level == 3) {echo 'selected';}?>>06 to 08 Years</option>
                                                <option value="4" <?php if(@$experience_level == 4) {echo 'selected';}?>>08 to 10 Years</option>
                                                <option value="5" <?php if(@$experience_level == 5) {echo 'selected';}?>>> 10 Years</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <span class="pf-title">Education <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select class="form-control" name="education" required>
                                                <option value="">Select Degree</option>
                                                <option value="1" <?php if(@$education == 1) {echo 'selected';}?>>Professional Certificate</option>
                                                <option value="2" <?php if(@$education == 2) {echo 'selected';}?>>Undergraduate Degrees</option>
                                                <option value="3" <?php if(@$education == 3) {echo 'selected';}?>>Transfer Degree</option>
                                                <option value="4" <?php if(@$education == 4) {echo 'selected';}?>>Associate Degree</option>
                                                <option value="5" <?php if(@$education == 5) {echo 'selected';}?>>Bachelor Degree</option>
                                                <option value="6" <?php if(@$education == 6) {echo 'selected';}?>>Graduate Degrees</option>
                                                <option value="7" <?php if(@$education == 7) {echo 'selected';}?>>Master Degree</option>
                                                <option value="8" <?php if(@$education == 8) {echo 'selected';}?>>Doctoral Degrees</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <span class="pf-title">Application Deadline Date <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <input type="date" placeholder="Enter Complete Address" name="appli_deadeline" class="form-control datepicker" value="<?= @$appli_deadeline; ?>" required/>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-12">
                                        <span class="pf-title">Complete Address</span>
                                        <div class="pf-field">
                                            <textarea id="complete_address"  name="complete_address" placeholder="Enter Address"></textarea>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <span class="pf-title">Country <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select class="form-control" name="country-dropdown" id="country-dropdown" style="width: 100%;">
                                                <option value="">Select Country</option>
                                            <?php
                                            $get_country = $this->Crud_model->GetData('countries', 'id, name', "");
                                            foreach($get_country as $val) {?>
                                                <option value="<?php echo $val->name; ?>" <?php if($val->name == @$countries) {echo "selected"; }?>><?php echo $val->name;?></option>
                                            <?php } ?>
                                            </select>
                                            <input type="hidden" id="select_country_dropdown" value="<?php echo @$countries; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="pf-title">State <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select class="form-control" name="state-dropdown" id="state-dropdown">
                                            <?php if(empty($id)) { ?>
                                                <option value="">Select State</option>
                                                <?php } else { ?>
                                                <option>Select State</option>
                                                <!-- <option value="<?= $state; ?>" selected><?php echo $state;?></option> -->
                                                <?php
                                                //$get_state = $this->Crud_model->GetData('states', 'id, name', "");
                                                //foreach($get_state as $key) {?>
                                                    <!-- <option value="<?= $key->name; ?>" <?php if($key->name == @$state) {echo "selected"; }?>><?php echo $key->name;?></option> -->
                                                <?php //} ?>
                                            <?php } ?>
                                            </select>
                                            <input type="hidden" id="select_state_dropdown" value="<?php echo @$state; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="pf-title">City <span style="color:red;">*</span></span>
                                        <div class="pf-field">
                                            <select class="form-control" name="city-dropdown" id="city-dropdown">
                                                <?php if(empty($id)) { ?>
                                                    <option value="">Select City</option>
                                                    <?php } else { ?>
                                                    <option>Select City</option>
                                                    <!-- <option value="<?= $cities; ?>" selected><?php echo $cities;?></option> -->
                                                    <?php
                                                    //$get_cities = $this->Crud_model->GetData('cities', 'id, name', "");
                                                    //foreach($get_cities as $key) {?>
                                                        <!-- <option value="<?= $key->name; ?>" <?php if($key->name == @$cities) {echo "selected"; }?>><?php echo $key->name;?></option> -->
                                                    <?php //} ?>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" id="select_city_dropdown" value="<?php echo @$cities; ?>">
                                        </div>
                                    </div>
                                </div>
                                    <div class="contact-edit">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <span class="pf-title">Find On Map <span style="color:red;">*</span></span>
                                                <div class="pf-field">
                                                    <input type="text" placeholder="Collins Street West, Victoria 8007, Australia." name="location" value="<?= @$location; ?>" id="location"  required autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <span class="pf-title">Latitude</span>
                                                <div class="pf-field">
                                                    <input type="text" id="search_lat" name="latitude"  placeholder="41.1589654" value="<?= @$latitude; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <span class="pf-title">Longitude</span>
                                                <div class="pf-field">
                                                    <input type="text" id="search_lon" placeholder="21.1589654" name="longitude" value="<?= @$longitude; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button type="button" class="srch-lctn" onclick="return show_location();">Search Location</button>
                                            </div>
                                            <div class="col-lg-12">
                                                <span class="pf-title">Maps</span>
                                                <div class="pf-map" id="map">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button type="submit">Submit</button>
                                                <input type="hidden" name="id" value="<?php echo @$id?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/taginput.css')?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script> -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script>
CKEDITOR.replace('description');
</script>
<script>
$('.key_skills').select2({
    tags: true,
    //maximumSelectionLength: 10,
    tokenSeparators: [','],
    placeholder: "Select or Type Skills"
});
function show_location() {
    var location=$('#location').val();
    $('#map').html('<iframe src="https://maps.google.it/maps?q='+location+'&output=embed"></iframe>');
    $('#complete_address').val(location);
}
$(document).ready(function() {
    $('#country-dropdown').on('change', function() {
        var country_name = this.value;
        $.ajax({
            url: "<?php echo base_url()?>Welcome/states_by_country",
            type: "POST",
            data: {
                country_name: country_name
            },
            cache: false,
            success: function(result){
                //console.log(result);
                $("#state-dropdown").html(result);
                $('#city-dropdown').html('<option value="">Select State First</option>');
            }
        });
    });

    $('#state-dropdown').on('change', function() {
        var state_name = this.value;
        $.ajax({
            url: "<?php echo base_url()?>Welcome/cities_by_state",
            type: "POST",
            data: {
                state_name: state_name
            },
            cache: false,
            success: function(result){
                $("#city-dropdown").html(result);
            }
        });
    });

    if($('#select_country_dropdown').val() != '') {
        var country_name = $('#select_country_dropdown').val();
        $.ajax({
            url: "<?php echo base_url()?>Welcome/states_by_country",
            type: "POST",
            data: {
                country_name: country_name
            },
            cache: false,
            success: function(result){
                //console.log(result);
                $("#state-dropdown").html(result);
                $("#state-dropdown").val(state_name);
            }
        });
    }

    if($('#select_state_dropdown').val() != '') {
        var state_name = $('#select_state_dropdown').val();
        $.ajax({
            url: "<?php echo base_url()?>Welcome/cities_by_state",
            type: "POST",
            data: {
                state_name: state_name
            },
            cache: false,
            success: function(result){
                $("#city-dropdown").html(result);
                $("#city-dropdown").val($('#select_city_dropdown').val());
            }
        });
    }
});
</script>
