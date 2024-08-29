<?php $settings = $this->Crud_model->get_single('setting');
//print_r($settings); die();
?>
<!DOCTYPE html>
<html>
<head>
	<title>New Product Query</title>
	<meta charset="utf-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
	<div style="width:600px;margin: 0 auto;background: #fff;font-family: 'Poppins', sans-serif; border: 1px solid #e6e6e6;">
		<div style="padding: 30px 30px 15px 30px;box-sizing: border-box;">
		 	<img src="<?= base_url('uploads/logo/'.@$settings->logo)?>" style="width:100px;float: right;margin-top: 0 auto;">
			<h3 style="padding-top: 40px;line-height: 20px;font-weight: 100;font-size: 15px;">Greetings from<span style="font-weight: 900;font-size: 23px;color: #F44C0D;display: block;">Afrebay</span></h3>
			<p style="font-size: 15px;">Hello Admin,</p>
			<p style="font-size: 15px;">Please find the below details for product related queries.</p>
            <p style="font-size: 15px; padding: 0; margin: 0;">Product Name: <?php echo $this->input->post('p_name')?></p>
            <p style="font-size: 15px; padding: 0; margin: 0;">Customer Name: <?php echo $this->input->post('name')?></p>
            <p style="font-size: 15px; padding: 0; margin: 0;">Customer Email: <?php echo $this->input->post('email')?></p>
            <p style="font-size: 15px; padding: 0; margin: 0;">Message: <?php echo $this->input->post('details')?></p>
			<p style="font-size: 15px; padding: 0; margin: 18px 0 0 0;">Thank you!</p>
    		<p style="font-size: 15px; padding: 0; margin: 0; list-style: none;">Sincerly,</p>
    		<p style="font-size: 15px; list-style: none; padding: 0; margin: 0;"><b>Afrebay</b></p>
	    	<p style="font-size: 15px; list-style: none; padding: 0; margin: 18px 0 0 0;">Visit us: <span><?= @$settings->address?></span></p>
	    	<p style="font-size: 15px; list-style: none; padding: 0; margin: 0;">Email us: <span><?= @$settings->email?></span></p>
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
