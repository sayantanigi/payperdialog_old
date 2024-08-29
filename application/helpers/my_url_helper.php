<?php

defined('BASEPATH') OR exit('No direct script access allowed');



if ( ! function_exists('admin_url'))

{

	function admin_url($uri = '', $protocol = NULL)

	{

		return get_instance()->config->admin_url($uri, $protocol);

	}

}

if(!function_exists("send_onesignal_push")) {
	function send_onesignal_push($subscription_ids, $title, $content) {
		$headers =  [
    		'Authorization: Basic OTI4YzNkMGUtNjQ5OC00NzIzLWFhNzYtZmMxOGQ5ODA2YWJl',
    		'accept : application/json',
    		'content-type : application/json',
  		];

  		$body = [
  			'include_subscription_ids' => $subscription_ids,
  			'name' => $title,
  			'contents' => [
  				'en' => $content
  			]


  		];

  		$options = [
  			'http' => [
  				'method'  => 'POST',
        		'header'  => $headers,
        		'content' => json_encode($body)
  			]
  		];


  		$context  = stream_context_create($options);

		$result = file_get_contents('https://onesignal.com/api/v1/notifications', false, $context);

		return json_decode($result);
	}
}


// if ( ! function_exists('seller_url'))

// {

// 	function seller_url($uri = '', $protocol = NULL)

// 	{

// 		return get_instance()->config->seller_url($uri, $protocol);

// 	}

// }