<?php
	require_once ('../../../wp-config.php');
	if(current_user_can('administrator')){
		$email = $_POST["email"];

		if(empty($email)){
			$url = 'https://'.$_SERVER['SERVER_NAME'];
			header("Location: ".$url);
			die;
		}

		$email_kontrol = $wpdb->get_col("SELECT comment_author_email FROM $wpdb->comments WHERE comment_author_email='$email' ");
		
		if($email_kontrol){
			$ref = $_SERVER['HTTP_REFERER']."&status=2&email".$email;
			header("Location: ".$ref);
	 		die;
		}

		$email_kayit = $wpdb->query("INSERT INTO {$wpdb->prefix}comments(comment_post_ID,comment_author,comment_author_email,comment_author_url,comment_author_IP,comment_date,comment_date_gmt,comment_content,comment_karma,comment_approved,comment_agent,comment_type,comment_parent,user_id) VALUES ('0','mail_kayit','$email','','','0000-00-00 00:00:00.000000','0000-00-00 00:00:00.000000','...','0','1','0','comment','0','0')"  );

	 	if($email_kayit){
			$ref = $_SERVER['HTTP_REFERER']."&status=1&email=".$email;
			header("Location: ".$ref);
	 	}
	 	else {
	 		$ref = $_SERVER['HTTP_REFERER']."&status=0";
			header("Location: ".$ref);
	 	}
	 	die;
	}
	else {
		$site = "https://".$_SERVER['SERVER_NAME'];
		header("Location: ".$site);
		die();
	}
?>
