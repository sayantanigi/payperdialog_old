<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1"
        style="background: url('<?= base_url('assets/images/resource/mslider1.jpg')?>') repeat scroll 50% 422.28px transparent;"
        class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
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
                <h2 class="breadcrumb-title">Recommended Job</h2>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('sidebar');?>
<div class="col-md-12 col-md-12 col-sm-12 display-table-cell v-align">
    <!-- <div class="col-sm-12" style="display: inline-block">
        <div class="col-sm-6" style="display: inline-block; float: left;">
            <p style="text-align: right;align-items: center;display: grid; ">Filter By Skill</p>
        </div>
        <div class="col-sm-6" style="display: inline-block; float: left;">
            <select class="form-control" name="remote" id="FilterBySkill">
                <option value="">All Recommended Job</option>
                <?php 
                $skills = $usersSkillsData[0]['skills'];
                $skills = explode(',', $skills);
                for ($i = 0; $i < count($skills); $i++) { ?>
                <option value="<?= trim($skills[$i])?>"><?= trim($skills[$i])?></option>
                <?php } ?>
            </select>
        </div>
    </div> -->
    <div class="user-dashboard">
        <div class="row row-sm">
            <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="container">
                    <div class="row no-gape">
                        <aside class="col-lg-3 column border-right Employees_Search_Panel">
                            <div class="Employees_Search_Panel_Data">
                                <form method="post" id="filter_form">
                                    <div class="widget">
                                        <h3 class="sb-title opened">Skill Sets</h3>
                                        <div class="specialism_widget">
                                            <div class="dropdown-field">
                                                <select class="form-control" name="remote" id="FilterBySkill">
                                                    <option value="">All Recommended Job</option>
                                                    <?php 
                                                    $skills = $usersSkillsData[0]['skills'];
                                                    $skills = explode(',', $skills);
                                                    for ($i = 0; $i < count($skills); $i++) { ?>
                                                    <option value="<?= trim($skills[$i])?>"><?= trim($skills[$i])?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </aside>
                        <div class="col-lg-9 column Employees_Search_Result">
                            <div class="cardak custom-cardak">
                                <div class="table table-modific" id="usersSkillsData">
                                <?php if(!empty($usersSkillsData)) {
                                $skills1 = $usersSkillsData[0]['skills'];
                                $experience = $usersSkillsData[0]['experience'];
                                $skills = explode(',', $skills1);
                                $count =  count($skills);
                                for ($j=0; $j < $count; $j++) {
                                    $recomendedJobList = $this->db->query("SELECT users.companyname, users.profilePic, postjob.* FROM postjob JOIN users ON postjob.user_id = users.userId WHERE postjob.experience_level = '".$experience."' AND `is_delete` = 0")->result_array();
                                    //$recomendedJobList = $this->db->query("SELECT users.companyname, users.profilePic, postjob.* FROM postjob JOIN users ON postjob.user_id = users.userId WHERE (instr(concat(',', required_key_skills, ','), ',$skills[$j],') OR postjob.required_key_skills = '".$skills[$j]."') AND postjob.experience_level = '".$experience."' AND `is_delete` = 0")->result_array();
                                    foreach ($recomendedJobList as $key) { 
                                        if($key['userType'] == 1){
                                            $name = $key['firstname'].' '.$key['lastname'];
                                        } else {
                                            $name = $key['companyname'];
                                        }
                                        if(!empty($key['profilePic']) && file_exists('uploads/users/'.$key['profilePic'])){
                                            $profile_pic= '<img src="'.base_url('uploads/users/'.$key['profilePic']).'" alt="" />';
                                        } else {
                                            $profile_pic= '<img src="'.base_url('uploads/users/user.png').'" alt="" />';
                                        }
                                        $get_category=$this->Crud_model->get_single('category',"id='".$key['category_id']."'");
                                        $get_subcategory=$this->Crud_model->get_single('sub_category',"id='".$key['subcategory_id']."'");
                                        $string = strip_tags($key['description']);
                                        if (strlen($string) > 200) {
                                            $stringCut = substr($string, 0, 200);
                                            $endPoint = strrpos($stringCut, ' ');
                                            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                            $string .= '...';
                                        } 
                                    ?>
                                    <div class="emply-resume-list">
                                        <div class="emply-resume-thumb"><?= $profile_pic ?></div>
                                        <div class="emply-resume-info">
                                            <h3><a href="<?= base_url('postdetail/'.base64_encode($key['id']))?>" title=""><?= $key['post_title']?></a></h3>
                                            <span><?= $get_category->category_name?></span>
                                            <span><?= $get_subcategory->sub_category_name?></span>
                                            <p><i class="la la-map-marker"></i><?= $key["city"].', '.$key["state"].', '.$key["country"]?></p>
                                            <span><b>Posted By:</b> <?= $name?></span>
                                            <div class="Employee-Details">
                                                <div class="MoreDetailsTxt_<?= $key['id']?>"><?= $string?></div>
                                            </div>
                                        </div>
                                    </div> 
                                    <?php } } } else { ?>
                                    <div>
                                        <center>No Data Found</center>
                                    </div>
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
<input type="hidden" id="experience" name="experience" value="<?= $usersSkillsData[0]['experience']?>" >
<div id="add_project" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header login-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Add Project</h4>
            </div>
            <div class="modal-body">
                <input type="text" placeholder="Project Title" name="name" />
                <input type="text" placeholder="Post of Post" name="mail" />
                <input type="text" placeholder="Author" name="passsword" />
                <textarea placeholder="Desicrption"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="cancel" data-dismiss="modal">Close</button>
                <button type="button" class="add-project" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
</section>
<style>
#product-messages{display: none; text-align: center;}
#err-messages{display: none; text-align: center;}
.emply-resume-thumb {display: inline-block !important;}
</style>
<script>
function jobDelete(id) {
    var p_id = id;
    $.confirm({
	    title: 'Confirm!',
	    content: confirmTextDelete,
	    buttons: {
	        confirm: function () {
                var base_url = $('#base_url').val();
                $.ajax({
                    url:base_url+"user/dashboard/delete_job",
                    method:"POST",
                    data:{id: p_id},
                    beforeSend : function(){
                        $("#loader").show();
                    },
                    success:function(data) {
                        if (data == '1'){
                            setTimeout(function () {
                                $("#loader").hide();
                                window.scroll({top: 0, behavior: "smooth"});
                                $('#product-messages').show();
                            }, 7000);
                            setTimeout(function () {
                                $('#product-messages').hide();
                            }, 9000);
                            setTimeout(function () {
                                location.reload(true);
                            }, 10000);
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

function MoreDetailsTxt(id) {
    //$(".MoreTxt_"+id).toggle();
    $(".MoreDetailsTxt_"+id).toggleClass('MoreDetailsTxtShow');
}

$(document).ready(function(){
    $('#FilterBySkill').change(function(){
        var p_id = $(this).val();
        var experience = $('#experience').val();
        $.ajax({
            url: "<?= base_url()?>user/dashboard/filterJobDataBySkillset",
            method:"POST",
            data:{id: p_id, experience: experience},
            beforeSend : function(){
                $("#loader").show();
            },
            success:function(data) {
                console.log(data);
                $("#usersSkillsData").html(data);
            }
        })
    })
})
</script>
