<?php
if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)) {
    $banner_img=base_url("uploads/banner/".$get_banner->image);
} else {
    $banner_img=base_url("assets/images/resource/mslider1.jpg");
} ?>
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img; ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
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
                <h2 class="breadcrumb-title">Profile Settings</h2>
            </div>
        </div>
    </div>
</section>

<?php
if($data_request=='user'){
    $this->load->view('sidebar');
    $container='';
} else {
    $container='container';
}
?>
<div class="col-md-12 col-sm-12 display-table-cell v-align">
    <div class="user-dashboard Admin_Profile form-design <?php echo $container;  ?> ">
        <form class="form" action="<?php echo base_url('user/Dashboard/update_profile')?>" method="post" id="registrationForm" enctype="multipart/form-data">
        <input type="hidden" name="from_data_request" value="<?=$data_request;?>">
            <div class="row row-sm">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="cardak profile-mobile">
                        <span class="text-success-msg f-20" style="text-align: center;">
                        <?php if($this->session->flashdata('message')) {
                            echo $this->session->flashdata('message');
                            unset($_SESSION['message']);
                        } ?>
                        </span>
                        <div class="bootstrap snippet">
                            <div class="new-pro">
                                <?php
                                if(!empty($userinfo->profilePic)) {
                                    if(!file_exists('uploads/users/'.$userinfo->profilePic)) {
                                ?>
                                <img class="img-circle img-responsive" src="<?php echo base_url('uploads/no_image.png')?>" style="width:60px; height: 60px; object-fit: cover;" />
                                <?php } else { ?>
                                <img class="img-circle img-responsive" src="<?php echo base_url('uploads/users/'.$userinfo->profilePic); ?>" style="width:60px; height: 60px; object-fit: cover;" />
                                <?php } } else { ?>
                                <img class="img-circle img-responsive" src="<?php echo base_url('uploads/no_image.png')?>" style="width:60px; height: 60px; object-fit: cover;" />
                                <?php } ?>
                                <input type="hidden" name="old_image" value="<?=$userinfo->profilePic ?>">
                                <input type="hidden" name="id" value="<?=$userinfo->userId  ?>">
                                <div class="profile-ak">
                                    <?php if(!empty($userinfo->profilePic)) { ?>
                                    <h6>Upload a different photo</h6>
                                    <input type="file" name="profilePic" class="text-center center-block file-upload"/>
                                    <?php } else { ?>
                                    <h6>Upload a photo</h6>
                                    <input type="file" name="profilePic" class="text-center center-block file-upload"/>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="profile-dsd">
                            <div class="tab-content">
                                <div class="tab-pane active" style="padding: 0px;">
                                    <hr />
                                    <div class="form-group">
                                        <div class="row">
                                            <?php //if(@$_SESSION['afrebay']['userType']=='2') { ?>
                                            <?php if(@$userinfo->userType=='2') { ?>
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>Company Name <span style="color:red;">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="companyname" id="companyname" placeholder="Company Name" value="<?php echo $userinfo->companyname;?>" />
                                                <div id="vld_companyname" style="color:red; margin-top: 10px;">Please enter Company Name.</div>
                                            </div>
                                            <?php } else { ?>
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>First Name <span style="color:red;">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" value="<?php echo $userinfo->firstname;?>"  onkeypress="only_alphabets(event)" />
                                                <div id="vld_firstname" style="color:red; margin-top: 10px;">Please enter First Name.</div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>Last Name <span style="color:red;">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" value="<?php echo $userinfo->lastname;?>"  onkeypress="only_alphabets(event)" />
                                                <div id="vld_lastname" style="color:red; margin-top: 10px;">Please enter Last Name.</div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>Email Address <span style="color:red;">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="xyz@example.com" readonly value="<?php echo $userinfo->email;?>" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>Phone Number </h4>
                                                </label>
                                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Phone Number" value="<?php echo $userinfo->mobile;?>" onkeypress="only_number(event)" maxlength="10" />
                                            </div>

                                            <?php //if(@$_SESSION['afrebay']['userType']=='1') { ?>
                                            <?php if(@$userinfo->userType=='1' || @$userinfo->userType=='3') { ?>
                                            <div class="col-lg-6 gender">
                                                <label for="first_name">
                                                    <h4>Gender<span style="color:red;">*</span></h4>
                                                </label>
                                                <select name="gender" id="gender" class="form-control"  style="height: 32px;">
                                                    <option value="">Gender</option>
                                                    <option value="Male" <?php if(@$userinfo->gender=='Male'){ echo "selected";}?>>Male</option>
                                                    <option value="Female" <?php if(@$userinfo->gender=='Female'){ echo "selected";}?>>Female</option>
                                                </select>
                                                <div id="vld_gender" style="color:red; margin-top: 10px;">Please Select Gender.</div>
                                            </div>
                                            <?php } ?>
                                            <div class="col-lg-6 location">
                                                <label for="last_name">
                                                    <h4>Legal Address <span style="color:red;">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="address" id="location" placeholder="Legal Address" value="<?= $userinfo->address ?>" style="height: 49px !important;" autocomplete="off" />
                                                <div id="vld_location" style="color:red; margin-top: 10px;">Please enter Legal Address.</div>
                                                <input type="hidden" name="latitude" id="search_lat" value="<?= $userinfo->latitude ?>">
                                                <input type="hidden" name="longitude" id="search_lon" value="<?= $userinfo->longitude ?> ">
                                            </div>
                                            <?php //if(@$_SESSION['afrebay']['userType']=='1') { ?>
                                            <?php if(@$userinfo->userType=='1' || @$userinfo->userType=='3') { ?>
                                            <div class="col-lg-6 key-skill">
                                                <span class="pf-title1">Skill Set</span>
                                                <div class="pf-field">
                                                    <select class="form-control key_skills" multiple="multiple" name="key_skills[]" id="key_skills" style="width: 100%;">
                                                    <?php
                                                    $key_skills = $this->Crud_model->GetData('specialist',"","status = 'Active'");
                                                    foreach($key_skills as $val) {?>
                                                        <option value="<?php echo $val->specialist_name; ?>"
                                                        <?php if(!empty($userinfo->skills)){
                                                            $skills = explode(",", $userinfo->skills);
                                                            for($i=0; $i<count($skills); $i++) {
                                                                if($skills[$i] == $val->specialist_name){
                                                                    echo "selected";
                                                                }
                                                            }
                                                        } ?>><?php echo $val->specialist_name;?></option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 key-skill">
                                                <span class="pf-title1">Total Experience</span>
                                                <div class="pf-field">
                                                    <select data-placeholder="Please Select Experience Level" class="form-control" name="experience" id="experience">
                                                        <option value="">Select Option</option>
                                                        <option value="1" <?php if(@$userinfo->experience == 1) {echo "selected";}?>>0 to 02 Years</option>
                                                        <option value="2" <?php if(@$userinfo->experience == 2) {echo "selected";}?>>03 to 05 Years</option>
                                                        <option value="3" <?php if(@$userinfo->experience == 3) {echo "selected";}?>>06 to 08 Years</option>
                                                        <option value="4" <?php if(@$userinfo->experience == 4) {echo "selected";}?>>08 to 10 Years</option>
                                                        <option value="5" <?php if(@$userinfo->experience == 5) {echo "selected";}?>>< 10 Years</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php //if(@$_SESSION['afrebay']['userType']=='1') { ?>
                                            <?php if(@$userinfo->userType=='1' || @$userinfo->userType=='3') { ?>
                                            <div class="col-lg-4">
                                                <label for="last_name">
                                                    <h4>Zip Code</h4>
                                                </label>
                                                <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" value="<?php echo @$userinfo->zip;?>" onkeypress="only_number(event)" maxlength="6" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="last_name">
                                                    <h4>Rate per Hour <span style="color:red;">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="rateperhour" id="rateperhour" placeholder="Rate per Hour" value="<?php echo @$userinfo->rateperhour;?>" required=""/>
                                            </div>
                                            <div class="col-lg-4">
                                                <?php if(!empty($userinfo->resume)) { ?>
                                                <label for="last_name"><h4>Update Resume</h4></label>
                                                <input type="file" class="form-control" name="resume" id="resume"/>
                                                <a href="<?php echo base_url('uploads/users/resume/'.$userinfo->resume); ?>" >
                                                    <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:40px; color:red;"></i>
                                                    <span><?php if(strlen($userinfo->resume) > 30){ echo substr($userinfo->resume, 0,30);}else{ echo $userinfo->resume; }?></span>
                                                </a>
                                                <input type="hidden" name="old_resume" value="<?= @$userinfo->resume ?>">
                                                <br>
                                                <?php } else { ?>
                                                <label for="last_name"><h4>Resume upload <span style="color:red;">*</span></h4></label>
                                                <input type="file" class="form-control" name="resume" id="resume" required/>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-12">
                                                <label>Portfolio</label>
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <table class="table jobsites" id="purchaseTableclone1">
                                                            <tr class="color">
                                                                <th>Contents</th>
                                                                <th><button type="button" class="btn btn-info addMoreBtn" onclick="add_row()" >Add Portfolio</button></th>
                                                            </tr>
                                                            <tbody id="clonetable_feedback1">
                                                                <?php if(!empty($portfolio_content)) {
                                                                $rows=1;
                                                                foreach ($portfolio_content as $key) { ?>
                                                                <tr>
                                                                    <td style="width: 72%;"><input type="text" name="content_title[]" id="content_title<?= $rows; ?>" class="form-control" placeholder="Content Title" value="<?= $key->content_title; ?>"></td>
                                                                    <td><input type="file" name="portfolio_file[]" id="portfolio_file<?= $rows; ?>" class="form-control" value="<?= $key->portfolio_file; ?>"></td>
                                                                    <td>
                                                                        <a href="<?php echo base_url('uploads/users/portfolio_file/'.$key->portfolio_file); ?>" target="_blank">
                                                                        <input type="text" name="old_portfolio_file" value="<?= $key->portfolio_file;?>">    
                                                                    </td>
                                                                    <td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(this)">X</a></td>
                                                                </tr>
                                                                <?php } } else { ?>
                                                                <tr>
                                                                    <td style="width: 72%;"><input type="text" name="content_title[]" id="content_title1" class="form-control" placeholder="Content Title"></td>
                                                                    <td><input type="file" name="portfolio_file[]" id="portfolio_file1" class="form-control" required></td>
                                                                    <td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return remove(this)">X</a></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <?php //if(@$_SESSION['afrebay']['userType']=='2') { ?>
                                            <?php if(@$userinfo->userType=='2') { ?>
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>Founded Year</h4>
                                                </label>
                                                <input type="text" class="form-control" name="foundedyear" id="foundedyear" placeholder="Founded Year" value="<?php echo $userinfo->foundedyear;?>"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="first_name">
                                                    <h4>TAX ID <span style="color:red;">*</span></h4>
                                                </label>
                                                <input type="text" class="form-control" name="teamsize" id="teamsize" placeholder="TAX ID" value="<?php echo $userinfo->teamsize;?>" />
                                                <div id="vld_teamsize" style="color:red; margin-top: 10px;">Please enter TAX ID.</div>
                                            </div>
                                            <?php } ?>

                                            <div class="col-lg-12">
                                                <label for="last_name">
                                                    <h4>Short Bio <span style="color:red;">*</span></h4>
                                                </label>
                                                <textarea class="form-control" name="short_bio" id="short_bio" placeholder="Short Bio" maxlength="500"><?= @$userinfo->short_bio ?></textarea>
                                                <div id="the-count">
                                                    <span id="current">0</span>
                                                    <span id="maximum">/ 500</span>
                                                </div>
                                                <div id="vld_shrtBio" style="color:red; margin-top: 10px;">Please enter short bio.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12 aksek">
                                            <button class="post-job-btn pull-right" type="submit">Save Changes</button>
                                            <!-- <input type="hidden" name="utype" id="utype" value="<?= @$_SESSION['afrebay']['userType']?>"> -->
                                            <input type="hidden" name="utype" id="utype" value="<?= @$userinfo->userType?>">
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
</div>
</div>
</section>
<style>
.Admin_Profile .cardak .gender select {margin-bottom: 0px !important;}
.form-design form .cardak .profile-dsd input  {margin-bottom: 0px !important;}
.col-lg-6 {margin-bottom: 20px !important;}
#vld_shrtBio {display: none;}
#vld_firstname {display: none;}
#vld_lastname {display: none;}
#vld_gender {display: none;}
#vld_location {display: none;}
#vld_companyname {display: none;}
#vld_teamsize {display: none;}
.container:before,
.container:after { display: none !important; }
@media (min-width: 1250px) {
    .container.Header_Menu_Nav {width: 1250px !important;}
}
.addMoreBtn {background: linear-gradient(180deg, rgba(252, 119, 33, 1) 0%, rgba(249, 80, 30, 1) 100%) !important; border: 0 !important; font-family: Open Sans; font-size: 15px !important; color: #ffffff !important; padding: 10px 27px !important; border-radius: 40px !important;}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script type="text/javascript">
//CKEDITOR.replace('short_bio');
$('#skills').tagsinput({
    confirmKeys: [13, 44],
    maxTags: 20,
});
$('.key_skills').select2({
    tags: true,
    //maximumSelectionLength: 10,
    tokenSeparators: [','],
    placeholder: "Select or Type Skills"
});

function add_row() {
    var y=document.getElementById('clonetable_feedback1');
    var new_row = y.rows[0].cloneNode(true);
    var len = y.rows.length;
    new_number=Math.round(Math.exp(Math.random()*Math.log(10000000-0+1)))+0;
    var inp0 = new_row.cells[0].getElementsByTagName('input')[0];
    inp0.value = '';
    inp0.defaultValue = '';
    inp0.id = 'service'+(len+1);
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.value = '';
    inp1.defaultValue = '';
    inp1.id = 'service'+(len+1);
    if(new_row.cells.length > 3) {
        new_row.cells[2].remove();
    }
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

$('#short_bio').keyup(function() {
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
$("form").submit( function(e) {
    if($('#utype').val() == 1 || $('#utype').val() == 3) {
        if($('#firstname').val() == ''){
            $('#firstname').focus().attr('placeholder', 'This field is required');
            $('#vld_firstname').show();
            $('#firstname').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_firstname").hide();},5000)
            e.preventDefault();
        }
        if($('#lastname').val() == ''){
            $('#lastname').focus().attr('placeholder', 'This field is required');
            $('#vld_lastname').show();
            $('#lastname').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_lastname").hide();},5000)
            e.preventDefault();
        }
        if($('#gender').val() == ''){
            $('#gender').focus().attr('placeholder', 'This field is required');
            $('#vld_gender').show();
            $('#gender').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_gender").hide();},5000)
            e.preventDefault();
        }
        if($('#location').val() == ''){
            $('#location').focus().attr('placeholder', 'This field is required');
            $('#vld_location').show();
            $('#location').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_location").hide();},5000)
            e.preventDefault();
        }
        if($('#short_bio').val() == ''){
            $('#short_bio').focus().attr('placeholder', 'This field is required');
            $('#vld_shrtBio').show();
            $('#short_bio').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_shrtBio").hide();},5000)
            e.preventDefault();
        }
    } else {
        if($('#companyname').val() == ''){
            $('#companyname').focus().attr('placeholder', 'This field is required');
            $('#vld_companyname').show();
            $('#companyname').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_companyname").hide();},5000)
            e.preventDefault();
        }
        if($('#location').val() == ''){
            $('#location').focus().attr('placeholder', 'This field is required');
            $('#vld_location').show();
            $('#location').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_location").hide();},5000)
            e.preventDefault();
        }
        if($('#teamsize').val() == ''){
            $('#teamsize').focus().attr('placeholder', 'This field is required');
            $('#vld_teamsize').show();
            $('#teamsize').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_teamsize").hide();},5000)
            e.preventDefault();
        }
        if($('#short_bio').val() == ''){
            $('#short_bio').focus().attr('placeholder', 'This field is required');
            $('#vld_shrtBio').show();
            $('#short_bio').focus().css('border', '1px solid red');
            setTimeout(function(){$("#vld_shrtBio").hide();},5000)
            e.preventDefault();
        }
    }
});
</script>
