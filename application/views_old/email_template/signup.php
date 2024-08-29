<?php $settings = $this->Crud_model->get_single('setting');
//print_r($settings); die();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
	<div style="width:600px;margin: 0 auto;background: #fff;font-family: 'Poppins', sans-serif; border: 1px solid #e6e6e6;">
		<div style="padding: 30px 30px 15px 30px;box-sizing: border-box;">
		 	<img src="<?= base_url('uploads/logo/'.@$settings->logo)?>" style="width:100px;float: right;margin-top: 0 auto;">
			<h3 style="padding-top:40px; line-height: 30px;">Greetings from<span style="font-weight: 900;font-size: 35px;color: #F44C0D; display: block;">Afrebay</span></h3>
			<p style="font-size:24px;">Hello <?php echo $fullname?>,</p>
			<p style="font-size:24px;">Thank you for registration on Afrebay.</p>
			<p style="font-size:24px;">Please click the button below to verify your email address.</p>
			<p style="text-align: center;">
				<a href="<?= $activationURL?>" style="height: 50px; width: 300px; background: rgb(253,179,2); background: linear-gradient(0deg, rgba(253,179,2,1) 0%, rgba(244,77,9,1) 100%); text-align: center; font-size: 18px; color: #fff; border-radius: 12px; display: inline-block; line-height: 50px; text-decoration: none; text-transform: uppercase; font-weight: 600;">ACTIVATE</a>
			</p>
    		<p style="font-size:20px;">Thank you!</p>
    		<p style="font-size:20px;list-style: none;">Sincerly</p>
    		<p style="list-style: none;"><b>Afrebay</b></p>
	    	<p style="list-style:none;"><b>Visit us:</b> <span><?= @$settings->address?></span></p>
	    	<p style="list-style:none"><b>Email us:</b> <span><?= @$settings->email?></span></p>
        </div>
        <table style="width: 100%;">
        	<tr>
        		<td style="height:30px;width:100%; background: red;padding: 10px 0px; font-size:13px; color: #fff; text-align: center;">
        			Copyright &copy; <?=date('Y')?> Afrebay. All rights reserved.
        		</td>
        	</tr>
        </table>
	</div>
</body>
</html>
