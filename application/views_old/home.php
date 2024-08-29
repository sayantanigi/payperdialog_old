<section class="topak">
    <div class="block no-padding">
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-featured-sec">
                        <ul class="main-slider-sec text-arrows">
                            <li class="slideHome">
                                <?php if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){?>
                                <img src="<?=base_url('uploads/banner/'.$get_banner->image); ?>" alt="" />
                                <?php } else{?>
                                <img src="<?=base_url(); ?>assets/images/resource/mslider1.jpg" alt="" />
                                <?php } ?>
                            </li>
                        </ul>
                        <div class="job-search-sec">
                            <div class="job-search">
                                <h3>Finding the best jobs quickly and easily</h3>
                                <span>Find Jobs, Employment & Career Opportunities</span>
                                <form method="post" action="<?= base_url('search-job')?>">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="job-field">
                                                <input type="text" name="search_title" placeholder="Job title, keywords or company name" value="" />
                                                <i class="la la-search"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                            <div class="job-field">
                                                <select class="chosen_country" name="country" id="country" onchange="getState(this.value)">
                                                    <option value="0">Select Country</option>
                                                    <?php if(!empty($countries)){ foreach($countries as $item){?>
                                                    <option value="<?= $item->name ?>"><?= ucfirst($item->name)?></option>
                                                    <?php } }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                            <div class="job-field">
                                                <div class="custom-select">
                                                    <select class="chosen_state" name="state" id="state" onchange="getCity(this.value);filter_job();">
                                                        <option value="">Select State</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                            <div class="job-field">
                                                <div class="custom-select">
                                                    <select class="chosen_city" name="city" id="city" onchange="filter_job();">
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                            <div class="job-field">
                                                <input type="text" placeholder="Country" name="search_location"
                                                    id="location" required autocomplete="off" />
                                                <input type="hidden" name="search_lat" id="search_lat">
                                                <input type="hidden" name="search_lon" id="search_lon">
                                                <i class="la la-close" onclick="return reset_location()"></i>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 search-btn">
                                            <button type="submit"><i class="la la-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <!-- <div class="or-browser">
                                    <span>Browse job posts by</span>
                                    <a href="<?php echo base_url('ourjobs')?>" title="">
                                        <span>All Categories</span>
                                    </a>
                                </div> -->
                            </div>
                        </div>
                        <div class="scroll-to">
                            <a href="#scroll-here" title=""><i class="la la-arrow-down"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block Opp_Block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading">
                        <h2>Latest Jobs</h2>
                        <span>Look for the latest jobs and projects posted on the portal.</span>
                    </div>
                    <div class="blog-sec">
                        <div class="row">
                            <?php if(!empty($get_post)) {
                            foreach($get_post as $row){
                            if(strlen($row->description)>200) {
                                $desc=substr($row->description,0,200).'...';
                            } else {
                                $desc=$row->description;
                            } ?>
                            <?php $get_user = $this->db-> query("SELECT * FROM users WHERE userId = '$row->user_id'")->result_array(); ?>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="my-blog"
                                    onclick="location.href='<?= base_url('postdetail/'.base64_encode($row->id))?>';">
                                    <div class="blog-details">
                                        <div class="Blog-Emp-Details">
                                            <div class="Blog-Emp-Img">
                                                <?php if (!empty($get_user[0]['profilePic'])) { ?>
                                                <img src="<?php echo base_url('uploads/users/'.$get_user[0]['profilePic']);?>">
                                                <?php } else {?>
                                                <img src="<?php echo base_url('uploads/users/user.png');?>">
                                                <?php } ?>
                                            </div>
                                            <div class="Blog-Emp-Data">
                                                <?php if(!empty($row->post_title)) {
                                                    if(strlen($row->post_title)>30) {
                                                        $title = substr($row->post_title,0,30).'...';
                                                    } else {
                                                        $title = $row->post_title;
                                                    }
                                                } else {
                                                    $title = '';
                                                } ?>
                                                <p><?= ucfirst($title)?></p>
                                                <?php $get_user = $this->db-> query("SELECT * FROM users WHERE userId = '$row->user_id'")->result_array();?>
                                                <p>By <?php echo $get_user[0]['companyname']?></p>
                                            </div>
                                        </div>
                                        <h3 class="nkash"><a href="javascript:void(0)" title="">Description</a></h3>
                                        <p><?= ucfirst(strip_tags($desc))?></p>
                                    </div>
                                </div>
                            </div>
                            <?php } } ?>
                        </div>
                    </div>
                </div>
                <?php if(count($get_post) > 6) { ?>
                <div class="col-lg-12">
                    <div class="browse-all-cat">
                        <a href="<?= base_url('ourjobs')?>" title="">View More</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block Worker-Block">
        <!-- <div data-velocity="-.1" style="background: url('<?=base_url(); ?>assets/images/resource/parallax3.jpg') 50% -62.7px repeat scroll transparent;" class="parallax scrolly-invisible no-parallax"></div> -->
        <div data-velocity="-.1" style="background: #F9FAFC" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading">
                        <h2>Available Pay Per Dialog Employees</h2>
                        <span>Find the most eligible employees within the portal.</span>
                    </div>
                    <div class="blog-sec">
                        <div class="row">
                            <?php
                            if(!empty($get_users)){
                                foreach($get_users as $user){
                                if(strlen($user->short_bio)>200) {
                                    $shortbio=substr($user->short_bio,0,200).'...';
                                } else {
                                    $shortbio=$user->short_bio;
                                }
                            if(!empty($user->firstname) && !empty($user->lastname) && !empty($user->email) && !empty($user->gender) && !empty($user->address) && !empty($user->short_bio)) {
                            ?>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="my-blog">
                                    <div class="blog-thumbak">
                                        <a href="<?= base_url('worker-detail/'.base64_encode(@$user->userId))?>" title="">
                                            <?php if(!empty($user->profilePic)&& file_exists('uploads/users/'.$user->profilePic)){?>
                                            <img src="<?=base_url('uploads/users/'.$user->profilePic); ?>" alt="" style="height: 300px;" />
                                            <?php } else{?>
                                            <img src="<?=base_url('uploads/no_image.png'); ?>" alt="" style="height: 300px;" />
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <div class="blog-details">
                                        <div class="blog-head">
                                            <!-- <h3 class="resk">
                                                <a href="<?= base_url('worker-detail/'.base64_encode(@$user->userId))?>" title=""><?= $user->category_name?></a>
                                            </h3> -->
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <ul class="gigasjh">
                                                        <li>Member Since</li>
                                                        <li><?php echo date('m/d/Y', strtotime(@$user->created));?></li>
                                                    </ul>
                                                </div>
                                                <!-- <div class="col-sm-6">
                                                    <ul class="gigasjh">
                                                        <li>Work Experience</li>
                                                        <li><?php echo @$user->experience;?></li>
                                                    </ul>
                                                </div> -->
                                            </div>
                                            <!-- <p><?= ucfirst(strip_tags($shortbio))?></p> -->
                                            <!-- <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate.</p> -->
                                        </div>
                                        <?php 
                                        $user_rating = $this->db->query("SELECT AVG(rt.rating) as rate FROM employer_rating rt WHERE rt.worker_id = '".@$user->userId."'")->result();
                                        ?>
                                        <div class="staak">
                                            <?php 
                                            if($user_rating[0]->rate > 0) {
                                                for ($i = 0; $i < $user_rating[0]->rate; $i++) {
                                            ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php }
                                            } else { ?>
                                            <span class="">Not Rated Yet</span>
                                            <?php } ?>
                                        </div>
                                        <h3 class="nkash">
                                            <a type="button" class="btn" href="<?= base_url('worker-detail/'.base64_encode(@$user->userId))?>" title="">
                                                <?php if(!empty($user->firstname)){ echo $user->firstname.' '.$user->lastname; } else{ echo ucfirst($user->username);}?>
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <?php }}} ?>
                        </div>
                    </div>
                </div>
                <?php if(count($get_users) > 8) { ?>
                <div class="col-lg-12">
                    <div class="browse-all-cat">
                        <a href="<?= base_url('workers-list')?>" title="">View More</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>



<section id="scroll-here">

    <div class="block">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="heading">

                        <h2>Our Services</h2>

                        <span>The marketplace for the most eligible employers and employee. <br> Find the latest jobs in the industry globally.</span>

                    </div>

                    <!-- Heading -->

                    <div class="cat-sec">

                        <div class="row no-gape">

                            <?php if(!empty($get_ourservice)){

                                foreach($get_ourservice as $item){

                                    $get_category=$this->Crud_model->get_single('category',"id='".$item->category_id."'");

                                    if(strlen($item->description)>100) {

                                        $description=substr($item->description,0,100).'...';

                                    } else {

                                        $description=$item->description;

                                    }

                                ?>

                            <div class="col-lg-3 col-md-6 col-sm-12">

                                <div class="p-category">

                                    <a href="javascript:void(0)" title="">

                                        <!-- <i class="<?= $item->icon?>"></i> -->
                                        <img src="<?php echo base_url()?>/uploads/services/<?php echo $item->icon?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">

                                        <?php if(!empty($get_category->category_name)) { ?>

                                        <span><?= ucfirst($get_category->category_name)?></span>

                                        <?php } else { ?>

                                        <span></span>

                                        <?php } ?>

                                        <?php if(!empty($description)) { ?>

                                        <p><?= ucfirst(strip_tags($description));?></p>

                                        <?php } else { ?>

                                        <p></p>

                                        <?php } ?>

                                    </a>

                                </div>

                            </div>

                            <?php } } ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<section>

    <div class="block double-gap-top double-gap-bottom">

        <!-- <div data-velocity="-.1" style="background: url(<?=base_url(); ?>assets/images/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible layer color"></div> -->

        <?php if(!empty($get_banner_middle->image) && file_exists('uploads/banner/'.$get_banner_middle->image)){?>
        <!-- <img src="<?=base_url('uploads/banner/'.$get_banner_middle->image); ?>" alt="" /> -->
        <div data-velocity="-.1" style="background: url(<?=base_url('uploads/banner/'.$get_banner_middle->image); ?>) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible layer color"></div>
        <?php } else{?>
        <!-- <img src="<?=base_url(); ?>assets/images/resource/mslider1.jpg" alt="" /> -->
        <div data-velocity="-.1" style="background: url(<?=base_url(); ?>assets/images/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible layer color"></div>
        <?php } ?>

        <!-- PARALLAX BACKGROUND IMAGE -->

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="simple-text-block">

                        <h3>Make a Difference with Your Online Resume!</h3>

                        <span>Get access to the latest jobs and projects globally!!</span>

                        <?php if(empty($_SESSION['afrebay']['userId'])){?>

                        <a href="<?= base_url('register')?>" title="">Create an Account</a>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<section>

    <div class="block">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="heading">

                        <h2>Companies We've Helped</h2>

                        <span>Some of the companies we've helped recruit excellent applicants over the years.</span>

                    </div>

                    <!-- Heading -->

                    <div class="comp-sec">

                        <?php if(!empty($get_company)) {

                        foreach($get_company as $item) { ?>

                        <div class="company-img">

                            <a href="javascript:void(0)" title="">

                                <?php if(!empty($item->logo)&& file_exists('uploads/company_logo/'.$item->logo)){?>

                                <img src="<?=base_url('uploads/company_logo/'.$item->logo); ?>" alt="" />

                                <?php } else { ?>

                                <img src="<?=base_url(); ?>assets/images/resource/b1.jpg" alt="" />

                                <?php } ?>

                            </a>

                        </div>

                        <?php } }?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<section>

    <div class="block Career">

        <!-- <div data-velocity="-.1"

            style="background: url(<?=base_url(); ?>assets/images/resource/parallax3.jpg) repeat scroll 50% 422.28px transparent;"

            class="parallax scrolly-invisible no-parallax"></div> -->

        <div data-velocity="-.1" style="background: #F9FAFC" class="parallax scrolly-invisible no-parallax"></div>

        <!-- PARALLAX BACKGROUND IMAGE -->

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="heading">

                        <h2>Quick Career Tips</h2>

                        <span>Review the latest updates and informations in the industry.</span>

                    </div>

                    <!-- Heading -->

                    <div class="blog-sec">

                        <div class="row">

                            <?php if(!empty($get_career)){ foreach($get_career as $career){

                            if(strlen($career->description)>100) {

                                $desc=substr($career->description,0,100).'...';

                            } else {

                                $desc=$career->description;

                            }

                            ?>

                            <div class="col-lg-4 col-md-6 col-sm-12">

                                <div class="my-blog">

                                    <div class="blog-thumb">

                                        <a href="<?= base_url('career-tip/'.base64_encode($career->id))?>" title="">

                                            <?php if(!empty($career->image)&& file_exists('uploads/career/'.$career->image)){?>

                                            <img src="<?=base_url('uploads/career/'.$career->image); ?>" alt="" />

                                            <?php } else{?>

                                            <img src="<?=base_url(); ?>assets/images/resource/b1.jpg" alt="" />

                                            <?php } ?>

                                        </a>

                                        <div class="blog-metas">

                                            <a href="javascript:void(0)"

                                                title=""><?= date('M d,Y',strtotime($career->update_date))?></a>

                                            <a href="javascript:void(0)" title="">0 Comments</a>

                                        </div>

                                    </div>

                                    <div class="blog-details">

                                        <h3><a href="<?= base_url('career-tip/'.base64_encode($career->id))?>"

                                                title=""><?= ucfirst($career->title)?></a></h3>

                                        <div><?= ucfirst($desc)?></div>

                                        <a href="<?= base_url('career-tip/'.base64_encode($career->id))?>"

                                            title=""><span>Read More</span></a>

                                    </div>

                                </div>

                            </div>

                            <?php } }?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<style>
.chosen_country {color: #888888; height: 60px; border-radius: 50px; padding: 17px !important;}
#state {display: block;color: #888888; height: 60px; border-radius: 50px; padding: 17px !important;}
#city {display: block;color: #888888; height: 60px; border-radius: 50px; padding: 17px !important;}
</style>
<script>
$(window).load(function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation);
    } else {
        $('#location').html('Geolocation is not supported by this browser.');
    }
});

// function showLocation(position) {
//     var latitude = position.coords.latitude;
//     var longitude = position.coords.longitude;
//     displayLocation(latitude, longitude);
// }

// function displayLocation(latitude, longitude) {
//     var geocoder;
//     geocoder = new google.maps.Geocoder();
//     var latlng = new google.maps.LatLng(latitude, longitude);
//     geocoder.geocode({'latLng': latlng},
//         function (results, status) {
//             if (status == google.maps.GeocoderStatus.OK) {
//                 if (results[0]) {
//                     var add = results[0].formatted_address;
//                     var value = add.split(",");
//                     count = value.length;
//                     country = value[count - 1];
//                     state = value[count - 2];
//                     city = value[count - 3];
//                     $("#paymentLocation").val(city);
//                 }
//             }
//         }
//     );
// }

</script>
<script>
    function getState(val) {
        var base_url = $("#base_url").val();
        var id = val;
        $.ajax({
            type:"post",
            cache:false,
            url:base_url+"Welcome/states_by_country",
            data:{
                country_name:id
            },
            beforeSend:function(){},
            success:function(returndata) {
                //console.log(returndata); return false;
                $('.state_field').show();
                $('#state').html(returndata);
                //$('#state_id_chosen .chosen-results').html(returndata);
                $('#city').html('<option value="">Select State First</option>');
            }
        });
    }

    function getCity(val) {
        var base_url = $("#base_url").val();
        var id = val;
        $.ajax({
            type:"post",
            cache:false,
            url:base_url+"Welcome/cities_by_state",
            data:{
                state_name:id
            },
            beforeSend:function(){},
            success:function(returndata) {
                //console.log(returndata); return false;
                $('.city_field').show();
                $('#city').html(returndata);
                //$('#city_id_chosen .chosen-results').html(returndata);
            }
        });
    }
</script>
