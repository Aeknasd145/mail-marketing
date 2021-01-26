<?php
/*
Plugin Name: Mail Marketing
Plugin URI: abbaserenkilic.com
Description: Follow your users search data on your website
Version: 1.0.0
Author: AEK
Author URI: abbaserenkilic.com
License: GNU
*/
defined( 'WPINC' ) || exit;

add_action('admin_menu', 'mail_marketing_menu');

function mail_marketing_menu(){
 	add_menu_page('Mail Marketing','Mail Marketing', 'manage_options', 'mail-marketing', 'mail_marketing_admin', 'dashicons-email');
}

function mail_marketing_admin(){
	global $wpdb;
	$status = $_GET['status'];
	$donen_email = $_GET['email'];
	if($status){
		if(is_numeric($status)){
			if($status==1){
				$status_cikti = '<span style="color: #4be159">'.$donen_email.' maili için işlem başarılı!</span>';
			}
			else if($status==0){
				$status_cikti = '<span style="color: red">Kayıt işlemi sırasında hata oldu!!</span>';
			}
			else if($status==2){
				$status_cikti = '<span style="color: red">'.$donen_email.' Maili zaten kayıtlı!</span>';
			}
			else {
				$status_cikti = '<span style="color: red">HATA!</span>';
			}
		}
		else {
			$status_cikti = '<span style="color: red">HATA!</span>';
		}
	}
	echo '
	<div class="row" style="margin: 0">
		<div class="col-md-6 col-12">
			<h1>E-Mail Listesi</h1>
			<div class="col-12">
				<div class="inside">
					<form method="post">
						<table  class="form-table">
							<tr>
								<th scope="row" valign="top">
									<b>Commenters emails</b>
								</th>
								<td>
									<textarea readonly="readonly" rows="10" cols="40" onfocus="javascript:this.select();">';

											$email = $wpdb->get_col("SELECT comment_author_email FROM $wpdb->comments WHERE comment_approved<>'spam' GROUP BY comment_author_email");

											foreach($email as $email_out) {

												echo $email_out . "\r\n";

											}

									echo '</textarea>

								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<div class="col-12">
				<div class="inside">
					<form method="post">
						<table class="form-table">
							<tr>
								<th scope="row" valign="top">
									<b>Users emails</b>
								</th>
								<td>
									<textarea readonly="readonly" rows="10" cols="40" onfocus="javascript:this.select();">';
										$email = $wpdb->get_col("SELECT user_email FROM $wpdb->users GROUP BY user_email");

												foreach($email as $email_out) {

													echo $email_out . "\r\n";

												}

									echo '</textarea>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-5 col-12">
			<h1 class="text-center">Mail Giriş Sistemi</h1>
			<div id="titlediv">
				<form method="POST" action="'.plugins_url("/mail-marketing/mail_kayit.php").'" class="text-right">
					<div class="text-center" style="font-size: 19px; margin-bottom: 2%">
						'.$status_cikti.'
					</div>
					<div id="titlewrap" class="group">
						<input type="email" name="email" size="30" id="title" spellcheck="true" autocomplete="off" class="input" placeholder="Email Adresi">
					</div>
					<div class="group">
						<input type="submit" style="padding: 2% 4%; font-size: 18px; font-weight: 500; border-radius: 1rem; border: solid 1px lightblue; background-color: lightblue; margin-top: 1%;" value="Maili Ekle">
					</div>
				</form>
			</div>
		</div>
	</div>
	';
	echo '
	<style>
		.col-md-6 {
			flex: 0 0 50% !important;
    		max-width: 50% !important;
		}
		.col-md-5 {
			-ms-flex: 0 0 41.666667% !important;
		    flex: 0 0 41.666667% !important;
		    max-width: 41.666667% !important;
		}
		.col-12 {
			flex: 0 0 100%;
    		max-width: 100%;
    		float: left;
		}
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
	</style>
	';
}
?>