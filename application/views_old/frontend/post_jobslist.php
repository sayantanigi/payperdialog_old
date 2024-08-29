<?php
 if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){
     $banner_img=base_url("uploads/banner/".$get_banner->image);
            } else{
       $banner_img=base_url("assets/images/resource/mslider1.jpg");
        } ?>

<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;"
            class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Jobs</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max_height">
    <!-- <div class="block no-padding Our_Jobs Employees_Search_List"> -->
    <div class="block no-padding Employees_Search_List">
        <div class="container">
            <div class="row no-gape">
                <aside class="col-lg-3 column border-right Employees_Search_Panel">
                    <div class="Employees_Search_Panel_Data">
                        <form method="post" id="filter_form">
                            <div class="widget">
                                <div class="search_widget_job">
                                    <div class="field_w_search">
                                        <input type="text" id="title_keyword" name="title_keyword" placeholder="Search Keywords"/>
                                        <i class="la la-search"></i>
                                    </div>
                                    <div class="field_w_search">
                                        <input type="text" name="search_location" id="location" placeholder="All Locations" oninput="getsourceaddress()" value="" />
                                        <i class="la la-map-marker"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="widget">
                                <h3 class="sb-title closed">Industry</h3>
                                <div class="specialism_widget">
                                    <select class="chosen" name="category_id" id="category_id" onchange="getsubcategory(this.value);">
                                        <option value="">Select Industry</option>
                                        <?php if(!empty($getcategory)){ foreach($getcategory as $item){?>
                                        <option value="<?= $item->id ?>"><?= ucfirst($item->category_name)?></option>
                                        <?php } }?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="widget sub_cat">
                                <h3 class="sb-title open">Subcategory</h3>
                                <div class="specialism_widget" >
                                    <div class="simple-checkbox scrollbar" >
                                        <div id="subcategory_list"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="widget sub_cat">
                                <h3 class="sb-title closed">Subindustry</h3>
                                <div class="specialism_widget">
                                    <select class="chosen_state" name="subcategory_id" id="subcategory_id">
                                    </select>
                                </div>
                            </div>
                            <div class="widget">
                                <h3 class="sb-title closed">Country</h3>
                                <div class="specialism_widget">
                                    <select class="chosen_country" name="country" id="country" onchange="getState(this.value);" style="color: #888; font-size: 13px;">
                                        <option value="">Select Country</option>
                                        <?php if(!empty($getcountry)){ foreach($getcountry as $item){?>
                                        <option value="<?= $item->name ?>"><?= ucfirst($item->name)?></option>
                                        <?php } }?>
                                    </select>
                                </div>
                            </div>
                            <div class="widget state_field">
                                <h3 class="sb-title closed">State</h3>
                                <div class="specialism_widget">
                                    <select class="chosen_state" name="state" id="state" onchange="getCity(this.value);">
                                    </select>
                                </div>
                            </div>
                            <div class="widget city_field">
                                <h3 class="sb-title closed">City</h3>
                                <div class="specialism_widget">
                                    <select class="chosen_city" name="city" id="city">
                                    </select>
                                </div>
                            </div>
                            <div class="widget date_field">
                                <h3 class="sb-title closed">Date Posted</h3>
                                <div class="specialism_widget">
                                    <!-- <input type="text" class="datepicker" name="date_posted" id="date_posted"> -->
                                    <div id="datepicker"></div>
                                    <input type="hidden" name="date_posted" id="date_posted">
                                </div>
                            </div>
                            <div class="widget date_field">
                                <h3 class="sb-title closed">Remote</h3>
                                <div class="specialism_widget">
                                    <select data-placeholder="Please Select Category" class="form-control" name="remote_job" id="remote_job" required>
                                        <option value="">Select Option</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                            <?php $min_price = $this->db->query("SELECT MIN(charges) as min_price FROM postjob WHERE is_delete = 0")->result_array(); ?>
                            <?php $max_price = $this->db->query("SELECT MAX(charges) as max_price FROM postjob WHERE is_delete = 0")->result_array(); ?>
                            <div class="widget date_field">
                                <h3 class="sb-title closed">Salary Estimate</h3>
                                <div class="specialism_widget">
                                    <div class="filter level-filter level-req">
                                        <div id="rangeSlider" class="range-slider">
                                            <div class="number-group">
                                                <input class="number-input" type="number" value="<?= $min_price[0]['min_price']?>" min="0" max="<?= $max_price[0]['max_price']?>" />
                                                <input class="number-input" type="number" value="<?= $max_price[0]['max_price']?>" min="0" max="<?= $max_price[0]['max_price']?>" />
                                            </div>

                                            <div class="range-group">
                                                <input class="range-input" value="<?= $min_price[0]['min_price']?>" min="<?= $min_price[0]['min_price']?>" max="<?= $max_price[0]['max_price']?>" step="1" type="range" />
                                                <input class="range-input" value="<?= $max_price[0]['max_price']?>" min="1" max="<?= $max_price[0]['max_price']?>" step="1" type="range" />
                                            </div>
                                            <input type="hidden" name="from_price" id="from_price" value="">
                                            <input type="hidden" name="to_price" id="to_price" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget date_field">
                                <h3 class="sb-title closed">Job Type</h3>
                                <div class="specialism_widget">
                                    <select data-placeholder="Please Select Category" class="form-control" name="job_type" id="job_type" required>
                                        <option value="">Select Option</option>
                                        <option value="1">Full-time</option>
                                        <option value="2">Part-time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="widget date_field">
                                <h3 class="sb-title closed">Posted By</h3>
                                <div class="specialism_widget">
                                    <select data-placeholder="Please Select Company" class="form-control" name="posted_by" id="posted_by" required>
                                        <option value="">Select Company</option>
                                        <?php
                                        $getcompany = $this->Crud_model->GetData('users',"","userType = '2' AND status = '1' AND email_verified = '1'");
                                        foreach($getcompany as $key) {?>
                                            <option value="<?= $key->id; ?>"><?php echo $key->companyname;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="widget date_field">
                                <h3 class="sb-title closed">Experience Level</h3>
                                <div class="specialism_widget">
                                    <select data-placeholder="Please Select Experience Level" class="form-control" name="experience_level" id="experience_level" required>
                                        <option value="">Select Option</option>
                                        <option value="1">0 to 02 Years</option>
                                        <option value="2">03 to 05 Years</option>
                                        <option value="3">06 to 08 Years</option>
                                        <option value="4">08 to 10 Years</option>
                                        <option value="5">> 10 Years</option>
                                    </select>
                                </div>
                            </div>
                            <div class="widget date_field">
                                <h3 class="sb-title closed">Education</h3>
                                <div class="specialism_widget">
                                    <select class="form-control" name="education" id="education" required>
                                        <option value="">Select Degree</option>
                                        <option value="1">Professional Certificate</option>
                                        <option value="2">Undergraduate Degrees</option>
                                        <option value="3">Transfer Degree</option>
                                        <option value="4">Associate Degree</option>
                                        <option value="5">Bachelor Degree</option>
                                        <option value="6">Graduate Degrees</option>
                                        <option value="7">Master Degree</option>
                                        <option value="8">Doctoral Degrees</option>
                                    </select>
                                </div>
                            </div>
                            <div class="widget">
                                <h3 class="sb-title closed">Last Activity</h3>
                                <div class="specialism_widget">
                                    <div class="simple-checkbox">
                                        <p><input type="radio" name="days" id="22" value="one"/><label for="22">Last Hour</label></p>
                                        <p><input type="radio" name="days" id="23" value="1"/><label for="23">Last 24 hours</label></p>
                                        <p><input type="radio" name="days" id="24" value="7"/><label for="24">Last 7 days</label></p>
                                        <p><input type="radio" name="days" id="25" value="14"/><label for="25">Last 14 days</label></p>
                                        <p><input type="radio" name="days" id="26" value="30"/><label for="26">Last 30 days</label></p>
                                        <p><input type="radio" name="days" id="27" value="All"/><label for="27">All</label></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>
                <div class="col-lg-9 column Employees_Search_Result">
                    <div class="padding-left">
                        <div class="emply-resume-sec">
                            <div id="post_list">
                            </div>
                            <div align="center" id="pagination_link"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style type="text/css">

</style>

<!-- price range slider -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
<script type="text/javascript" src="<?= base_url('assets/custom_js/postjob_list.js')?>"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<!-- price range slider -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

<style type="text/css">
    .datepicker-inline {border: 1px solid #c5c5c5 !important; width: 252px !important;}
    .table-condensed { width: 242px !important;}
    .datepicker table thead tr:nth-child(2) {border: 1px solid #dddddd; background: #e9e9e9; color: #333333; font-weight: bold;}
    .datepicker table tr td {border: 1px solid #c5c5c5 !important; background: #f6f6f6; font-weight: normal; color: #454545; padding: 0.2em; text-align: right !important; text-decoration: none;}
    .level-filter .range-slider {
        display: flex;
        flex-flow: row wrap;
        align-items: center;
    }
    .level-filter .range-slider .number-group {
        height: 30px;
        font-weight: 300;
        font-size: 13px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    .level-filter .range-slider .number-group .number-input {
        width: 36px;
        height: 30px;
        text-align: center;
        color: #ffffff;
        background-color: #ed1c24;
        border: 0;
        border-radius: 5px;
    }
    .level-filter .range-slider .number-group .number-input:first-of-type {
        margin-right: 7px;
    }
    .level-filter .range-slider .number-group .number-input:last-of-type {
        margin-left: 7px;
    }
    .level-filter .range-slider .number-group .number-input::-webkit-outer-spin-button, .range-slider .number-group .number-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }
    .level-filter .range-slider .number-group .number-input:invalid, .range-slider .number-group .number-input:out-of-range {
        border: 2px solid red;
    }
    .level-filter .range-slider .range-group {
        position: relative;
        flex: 0 0 100%;
        height: 30px;
    }
    .level-filter .range-slider .range-group .range-input {
        position: absolute;
        left: 0;
        bottom: 0;
        margin-bottom: 0;
        -webkit-appearance: none;
        width: 100%;
        border-bottom: 0;
    }
    .level-filter .range-slider .range-group .range-input:focus {
        outline: 0;
    }
    .level-filter .range-slider .range-group .range-input::-webkit-slider-runnable-track {
        width: 100%;
        height: 2px;
        cursor: pointer;
        -webkit-animation: 0.2s;
        animation: 0.2s;
        background: #ed1c24;
        border-radius: 1px;
        box-shadow: none;
        border: 0;
    }
    .level-filter .range-slider .range-group .range-input::-webkit-slider-thumb {
        z-index: 2;
        position: relative;
        height: 18px;
        width: 18px;
        border-radius: 50%;
        background: #ed1c24;
        cursor: pointer;
        -webkit-appearance: none;
        margin-top: -7px;
    }
    .level-filter .range-slider .range-group .range-input::-moz-range-track {
        width: 100%;
        height: 2px;
        cursor: pointer;
        animation: 0.2s;
        background: #ed1c24;
        border-radius: 1px;
        box-shadow: none;
        border: 0;
    }
    .level-filter .range-slider .range-group .range-input::-moz-range-thumb {
        z-index: 2;
        position: relative;
        box-shadow: 0px 0px 0px #000;
        border: 1px solid #2497e3;
        height: 18px;
        width: 18px;
        border-radius: 50%;
        background: #ed1c24;
        cursor: pointer;
    }
    .level-filter .range-slider .range-group .range-input::-ms-track {
        width: 100%;
        height: 5px;
        cursor: pointer;
        animation: 0.2s;
        background: transparent;
        border-color: transparent;
        color: transparent;
    }
    .level-filter .range-slider .range-group .range-input::-ms-fill-lower, .range-slider .range-group .range-input::-ms-fill-upper {
        background: #ed1c24;
        border-radius: 1px;
        box-shadow: none;
        border: 0;
    }
    .level-filter .range-slider .range-group .range-input::-ms-thumb {
        z-index: 2;
        position: relative;
        height: 18px;
        width: 18px;
        border-radius: 50%;
        background: #ed1c24;
        cursor: pointer;
    }
    .level-filter .range-slider, .level-filter .filter {
        margin: 0 auto 10px;
        max-width: 100%;
    }
</style>
<script>
$(function() {
    $("#datepicker").datepicker();
});
</script>
<script>
$(document).ready(function () {
    filter_data(1);

    function filter_data(page) {
        var base_url = $("#base_url").val();
        var displayProduct = 5;
        $('#post_list').html(createSkeleton(displayProduct));
        function createSkeleton(limit) {
            var skeletonHTML = '';
            for (var i = 0; i < limit; i++) {
                skeletonHTML += '<div class="ph-item">';
                skeletonHTML += '<div class="ph-col-4">';
                skeletonHTML += '<div class="ph-picture"></div>';
                skeletonHTML += '</div>';
                skeletonHTML += '<div>';
                skeletonHTML += '<div class="ph-row">';
                skeletonHTML += '<div class="ph-col-12 big"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '<div class="ph-col-12"></div>';
                skeletonHTML += '</div>';
                skeletonHTML += '</div>';
                skeletonHTML += '</div>';
            }
            return skeletonHTML;
        }
        var action = 'fetch_data';
        var title_keyword = $('#title_keyword').val();
        var category_id = $('#category_id').val();
        //var subcategory_id = get_filter('storage');
        var subcategory_id = $('#subcategory_id').val();
        var days = $('input:radio[name=days]:checked').val();
        var post_id = $('#post_id').val();
        var location = $('#location').val();
        var country = $('#country').val();
        var state = $('#state').val();
        var city = $('#city').val();
        var search_title = $('#search_title').val();
        var search_location = $('#search_location').val();
        var date_posted = $('#date_posted').val();
        var remote_job = $('#remote_job').val();
        var from_price = $('#from_price').val();
        var to_price = $('#to_price').val();
        var job_type = $('#job_type').val();
        var posted_by = $('#posted_by').val();
        var experience_level = $('#experience_level').val();
        var education = $('#education').val();
        $.ajax({
            url: base_url + "welcome/fetch_data/" + page,
            method: "POST",
            dataType: "JSON",
            data: {
                action: action,
                title_keyword: title_keyword,
                category_id: category_id,
                post_id: post_id,
                subcategory_id: subcategory_id,
                days: days,
                location: location,
                country: country,
                state: state,
                city: city,
                search_title: search_title,
                search_location: search_location,
                date_posted: date_posted,
                remote_job: remote_job,
                from_price: from_price,
                to_price: to_price,
                job_type: job_type,
                posted_by: posted_by,
                experience_level: experience_level,
                education: education
            },
            success: function (data) {
                //$('#title_keyword').val(data.keyword);
                $('#location').val(data.keyword_location);
                $('#post_list').html(data.postlist);
                $('#pagination_link').html(data.pagination_link);
            }
        })
    }

    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function () {
            filter.push($(this).val());
        });
        return filter;
    }

    $(document).on('click', '.pagination li a', function (event) {
        event.preventDefault();
        var page = $(this).data('ci-pagination-page');
        filter_data(page);
    });

    $('.common_selector').click(function () {
        filter_data(1);
    });

    $('#title_keyword').keyup(function () {
        filter_data(1);
    });

    $('#location').on('change', function () {
        filter_data(1);
    });

    $('input:radio').click(function () {
        filter_data(1);
    });

    $('#category_id').on('change', function () {
        filter_data(1);
    });

    $('#subcategory_id').on('change', function () {
        filter_data(1);
    });

    $('#country').on('change', function () {
        filter_data(1);
    });

    $('#state').on('change', function () {
        filter_data(1);
    });

    $('#city').on('change', function () {
        filter_data(1);
    });

    /*$('#date_posted').on('change', function () {
        filter_data(1);
    });*/

    $('#datepicker').on('changeDate', function(event) {
        selectDate = event.date.toLocaleDateString("en-us");
        $('#date_posted').val(selectDate);
        filter_data(1);
    });

    $('#remote_job').on('change', function () {
        filter_data(1);
    });

    // $('').on('change', function () {
    //     filter_data(1);
    // });

    $('#job_type').on('change', function () {
        filter_data(1);
    });

    $('#posted_by').on('change', function () {
        filter_data(1);
    });

    $('#experience_level').on('change', function () {
        filter_data(1);
    });

    $('#education').on('change', function () {
        filter_data(1);
    });

    var parent = document.querySelector("#rangeSlider");
    if(!parent) return;
    var rangeS = parent.querySelectorAll("input[type=range]");
    var numberS = parent.querySelectorAll("input[type=number]");

    rangeS.forEach(function(el) {
        el.oninput = function() {
            var slide1 = parseFloat(rangeS[0].value);
            var slide2 = parseFloat(rangeS[1].value);

            if (slide1 > slide2) {
                [slide1, slide2] = [slide2, slide1];
            }

            numberS[0].value = slide1;
            numberS[1].value = slide2;
            $('#from_price').val(numberS[0].value);
            $('#to_price').val(numberS[1].value);
            filter_data(1);
        }
    });

    numberS.forEach(function(el) {
        el.oninput = function() {
            var number1 = parseFloat(numberS[0].value);
            var number2 = parseFloat(numberS[1].value);

            if (number1 > number2) {
                var tmp = number1;
                numberS[0].value = number2;
                numberS[1].value = tmp;
            }

            rangeS[0].value = number1;
            rangeS[1].value = number2;
        }
    });
});

(function() {
    

})();
</script>

<script>
    function MoreDetailsTxt(id) {
    //$(".MoreTxt_"+id).toggle();
    $(".MoreDetailsTxt_"+id).toggleClass('MoreDetailsTxtShow');
}
</script>
