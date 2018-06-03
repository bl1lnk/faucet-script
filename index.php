<?php 
include 'libs/core.php'; 

$reward = mt_rand(1, 1000)/10000; //0.1~0.0001

if (isset($_GET['r']) && !isset($_COOKIE['ref'])) {
	$reff = $mysqli->real_escape_string($_GET['r']);
	setcookie('ref',  $reff, time()+86400000);
}

if (isset($_POST['address']) and isset($_POST['token'])) { 
	
    # clean user's input
	$address = $mysqli->real_escape_string($_POST['address']);
    # omit it if start with @
    preg_match('/@?(\S+)/', $address, $matches);
    $address = $matches[1];
	if (!isset($_COOKIE['address'])) {
		setcookie('address', $address, time()+1000000);
	} 
    # end 
	if ($_POST['token'] == $_SESSION['token']) {

		# check captcha
		if (isset($_POST['g-recaptcha-response']) && $faucet['captcha'] == 'recaptcha') {
			$secret = get_info(15);
			$CaptchaCheck = json_decode(captcha_check($_POST['g-recaptcha-response'], $secret))->success; 
		} elseif (isset($_POST["adcopy_challenge"]) && isset($_POST["adcopy_response"])&& $faucet['captcha'] == 'solvemedia') {
			$privatekey = get_info(21);
			$hashkey = get_info(22);
			$solvemedia_response = solvemedia_check_answer($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["adcopy_challenge"],$_POST["adcopy_response"],$hashkey);
			$CaptchaCheck = $solvemedia_response->is_valid;
		} elseif (isset($_POST['sqn_captcha']) and $faucet['captcha'] == 'bitcaptcha') {
			$captcha_key = ((strpos($_SERVER['HTTP_HOST'],'ww.')>0)?get_info(19):get_info(17));
			$CaptchaCheck = sqn_validate($_POST['sqn_captcha'], $captcha_key, $id);
		} else {
			$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Invalid Captcha</div></center>"; 
		}
		if ($CaptchaCheck and !isset($alert)) {
			if (check_blocked_ip($ip) == 'blocked') {
				$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Your Ip Is Blocked. Please Contact Admin.</div></center>";
			} elseif (check_blocked_address($address) == 'blocked') {
				$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Your Account Is Blocked. Please Contact Admin.</div></center>";
			} elseif (!empty(get_info(29)) and iphub(get_info(29)) == 'bad') {
				$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Your Ip Is Blocked By IpHub</div></center>";
				$mysqli->query("INSERT INTO ip_blocked (address) VALUES ('$ip')");
			} elseif (checkaddress($address) !== 'ok') {
				$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Your Account is not ready to claim!</div><br><div id='CountDownTimer' data-timer='" . checkaddress($address) . "' style='width: 100%;'></div></center>";
			} elseif (checkip($ip) !== 'ok') {
				$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Your Ip Address is not ready to claim!</div><br><div id='CountDownTimer' data-timer='" . checkip($ip) . "' style='width: 100%;'></div></center>";
			} else {
				
				# check short link
				if (get_info(12) == 'on' or (isset($_POST['link']) and get_info(10) == 'on')) {
					$key = get_token(15); 
					for ($i=1; $i <= count($link) ; $i++) { 
						if (!isset($_COOKIE[$i])) {
							$mysqli->query("INSERT INTO link (bitcoin_address, sec_key, ip) VALUES ('$address', '$key', '$ip')");
							log_user($address, $ip);
							setcookie($i, 'fuck cheater :P', time() + 86400);
							$url = $link[$i];
							$full_url = str_replace("{key}",$key,$url);
							$short_link = file_get_contents($full_url);
							break;
						}
					}
					if (!isset($short_link)) {
						$mysqli->query("INSERT INTO link (bitcoin_address, sec_key, ip) VALUES ('$address', '$key', '$ip')");
						log_user($address, $ip);
						$url = $link_default;
						$full_url = str_replace("{key}",$key,$url);
						$short_link = file_get_contents($full_url);
					} 
					header("Location: ". $short_link);
					echo '<script> window.location.href="' .$short_link. '"; </script>';
					die('Redirecting you to short link, please wait ...');
				} else {

					#normal claim
					$microzeny_api = get_info(6);
					$currency = $faucet['currency'];
					$microzeny = new Microzeny($microzeny_api, $currency);
					$result = $microzeny->send($address, $reward, 'false', $ip);
					if (isset($_COOKIE['ref']) && $address !== $_COOKIE['ref']) {
						$ref = $mysqli->real_escape_string($_COOKIE['ref']);
						$amt = floor($reward / 100 * $faucet['ref']);
						$s = $microzeny->sendReferralEarnings($ref, $amt, $ip);
					}
					if ($result['success'] == true) {
						log_user($address, $ip);
						$new_balance = $result['balance'] / 100000000;
						$mysqli->query("UPDATE settings SET value = '$new_balance' WHERE id = '30'");
						$alert = "<center><img style='max-width: 200px;' src='template/img/trophy.png'><br>{$result['html']}</center>";
					} else {
						$alert = "<center><img style='max-width: 200px;' src='template/img/trophy.png'><br><div class='alert alert-danger'>{$result['html']}</div></center>";
					}
				}
			}
		} else {
			$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Invalid Captcha</div></center>"; 
		}
	} else {
		$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Invalid Token</div></center>"; 
	}
}

// check if user has completed a short link
if (isset($_GET['k'])) {
	$key = $mysqli->real_escape_string($_GET['k']);
	$check = $mysqli->query("SELECT * FROM link WHERE sec_key = '$key' and ip = '$ip' LIMIT 1");
	if ($check->num_rows == 1) { 
		$check = $check->fetch_assoc();
		$address = $check['bitcoin_address'];
		$mysqli->query("DELETE FROM link WHERE sec_key = '$key'");
		$microzeny_api = get_info(6);
		$microzeny = new Microzeny($microzeny_api, $faucet['currency']);
		$rew = get_info(11) + $reward;
		$result = $microzeny->send($address, $rew, $ip);
        $new_balance = $result['balance'] / 100000000;
		$mysqli->query("UPDATE settings SET value = '$new_balance' WHERE id = '30'");
		if (isset($_COOKIE['ref']) && $address !== $_COOKIE['ref']) {
			$ref = $mysqli->real_escape_string($_COOKIE['ref']);
			$amt = floor($rew / 100 * $faucet['ref']);
			$s = $microzeny->sendReferralEarnings($ref, $amt, $ip);
		}
		$alert = "<center><img style='max-width: 200px;' src='template/img/trophy.png'><br>{$result['html']}</center>";
	} else {
		$alert = "<center><img style='max-width: 200px;' src='template/img/bots.png'><br><div class='alert alert-warning'>Invalid Key !</div></center>";
	}
}

$_SESSION['token'] = get_token(70);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
<?php
	if ( is_null($ua) ) {
  $ua = $_SERVER['HTTP_USER_AGENT'];
}
if ( preg_match('/iPad/', $ua) ) {
  echo '<meta name="viewport" content="width=640">';
} else {
  echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
}
?>
	<title><?=$faucet['name']?> - <?=$faucet['description']?></title> 
	<link rel="shortcut icon" href="template//img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="template/img/favicon.ico" type="template/image/x-icon">
	<!--<link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed" rel="stylesheet">-->
	<link rel="stylesheet" type="text/css" href="template/css/<?=$faucet['theme']?>.css"> 
	<link rel="stylesheet" href="template/css/countdown.css"> 
	<link rel="stylesheet" href="template/css/ad.css">
        <link rel="stylesheet" href="template/css/table.css">
        <script src="template/js/jquery-3.2.1.min.js"></script>
        <script src="template/js/temp.js"></script>  
	<style type="text/css"> 
	body {  
		;font-family: 'Saira Extra Condensed', sans-serif;
		font-weight:400;
		font-size:0.875em;
		letter-spacing:0.043em;
		background: slategray;
	}
	img, iframe {
		max-width: 100%;
	}
	.login {
		background-color: rgba(226, 212, 296, 0.3);
		padding-top: 20px;
		padding-bottom: 20px;
		border-radius: 20px 20px 20px 20px;
	}
	.login:hover {
		background-color: rgba(226, 212, 296, 0.5);
	}
	.alert {
		margin-bottom: 20px;
	}  
	footer, .cbc {
		color: #F67F7F;
	}	
	.ribbon {
		font-weight:900;
		font-size:1.8em;
		margin-bottom:30px;
		text-shadow:2px 3px 0px #898999;
		line-height:1.2;
		color: #E4DEED;
		width: 50%;
		position: relative;
		background: #ba89b6;
		text-align: center;
		padding: 1em 2em;  
		margin: 1em auto 1.5em;   
	}
	.ribbon:hover {
		background-color: #D5A2D1;
	}
	.ribbon:before, .ribbon:after {
		content: "";
		position: absolute;
		display: block;
		bottom: -1em;
		border: 1.5em solid #986794;
		z-index: -1;
	}
	.ribbon:before {
		left: -2em;
		border-right-width: 1.5em;
		border-left-color: transparent;
	}
	.ribbon:after {
		right: -2em;
		border-left-width: 1.5em;
		border-right-color: transparent;
	}
	.ribbon .ribbon-content:before, .ribbon .ribbon-content:after {
		content: "";
		position: absolute;
		display: block;
		border-style: solid;
		border-color: #804f7c transparent transparent transparent;
		bottom: -1em;
	}
	.ribbon .ribbon-content:before {
		left: 0;
		border-width: 1em 0 0 1em;
	}
	.ribbon .ribbon-content:after {
		right: 0;
		border-width: 1em 1em 0 0;
	}
	h1.ttl-bdr {
        background: #444;
        box-shadow: 0px 0px 0px 5px #444;
        border: dashed 2px white;
        padding: 0.2em 0.5em;
        color: white;
        width:fit-content;
        margin: 0 auto;
        margin-top: 20px;
    }
    .noticebox{    
        margin: 2em 0;
        background: #999;
    }
    .noticebox .box-title {
        font-size: 1.2em;
        background: #444;
        padding: 4px;
        text-align: center;
        color: #FFF;
        font-weight: bold;
        letter-spacing: 0.05em;
    }
    .noticebox p {
        padding: 15px 20px;
        margin: 0;
        color: white;
    }
    
    .formbox {
        padding: 0.5em 1em;
        margin: 2em 0;
        color: #5d627b;
        background: white;
        border-top: solid 5px #5d627b;
		box-shadow: 0 3px 5px rgba(0, 0, 0, 0.22);
		margin: 0 auto;
    }
#wrap{width:100%;}
</style>
</head>
<body id="wrap"> 
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php"><?=$faucet['name']?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<div id="nav"></div>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#"><i class="fa fa-balance-scale" aria-hidden="true"></i> Faucet Balance: <?=get_info(30)?> <?=$currency_name?> <span class="sr-only">(current)</span></a>
				</li>
			</ul>
		</div>
	</nav>
	<center>
		<?=$ad['top']?>
	</center>
	<h1 class="ttl-bdr"><?=$faucet['name']?></h1>
	<div class="container-fluid" style="margin-top: 30px;">
		<div class="row">
			<div class="col-sm-3 text-center" style="margin-top: 20px;">
				<?=$ad['left']?>
			</div>
			<div class="formbox">
				<div class="noticebox" style="margin-top: 10px;">
					<div class="box-title">報酬情報</div>
					<p><i class="fa fa-trophy" aria-hidden="true"></i> 0.0001-0.1 <?=$currency_name?> が <?=floor($faucet['timer']/3600)?> 時間ごとに受け取れます</p>
				</div>
				<center>
					<?=$ad['above-form']?>
				</center>
				<?php if (isset($alert)) { ?>
				<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content"> 
							<div class="modal-body">
								<?=$alert?>  
							</div>
						</div>
					</div>
				</div>
				<?php } if (checkip($ip) == 'ok') { ?>
				<form action="" method="post">
					<input type="hidden" name="token" value="<?=$_SESSION['token']?>">
					<div class="form-group">
						<span class="badge badge-warning control-label">microzeny アカウントID</span>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><img src="template/img/wallet.png" width="40px"></div>
								<input type="text" class="form-control" name="address" <?php if(isset($_COOKIE['address'])) {echo "value='" . $_COOKIE['address'] . "'";} else {echo 'placeholder="Must be create an account at microzeny first"'; } ?> style="border-radius: 0px 20px 20px 0px;">
							</div>
						</div>
					</div> 
                    <ul>
                        <li>microzenyのアカウントをまだ持っていない場合は<a href="https://microzeny.com/login">こちら</a>から登録できます</li>
                    </ul>
					<center>
						<?=$ad['bottom']?> 
					</center>
					<div class="form-group">
						<span class="badge badge-danger control-label">Captcha</span>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon"><img src="template/img/captcha.png" width="40px"></div>
								<?=$captcha_display?>
							</div>
						</div>
					</div>
					<?php if (get_info(10) == 'on' and get_info(12) !== 'on') { for ($i=1; $i <= count($link) ; $i++) { if (!isset($_COOKIE[$i])) { ?>
					<label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
						<input type="checkbox" name="link" value="yes" class="custom-control-input" checked>
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description"><i class="fa fa-gift" aria-hidden="true"></i> <strong>I want to click <font color="#F67F7F">SHORT LINK</font> and receive<font color="#F67F7F"> + <?=get_info(8)?> satoshi bounus</font></strong></span>
					</label> 
					<?php break; } }} ?>
					<button type="button" class="btn btn-dark btn-lg btn-block" style="margin-bottom: 20px;" data-toggle="modal" data-target="#next"><i class="fa fa-paper-plane" aria-hidden="true"></i> <strong>BitZenyをもらう</strong></button>
					<div class="modal fade bd-example-modal-lg" id="next" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">最終ステップ</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<?=$ad['modal']?>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
									<button type="submit" class="btn btn-dark" id="claim">BitZenyをもらう</button>
								</div>
							</div>
						</div>
					</div>
					<script type="text/javascript" async src="//platform.twitter.com/widgets.js"></script>
                                        <a href="https://twitter.com/share" class="twitter-share-button" data-via="kikiriko200">Tweet</a>
				</form>
				<?php } else { $wait= 1; echo "<div class='alert alert-info'>しばらくお待ちください</div><br><div id='CountDownTimer' data-timer='" . checkip($ip) . "' style='width: 100%;'></div>"; } ?> 
			</div>
			<div class="col-sm-3 text-center" style="margin-top: 20px;">
				<?=$ad['right']?>
			</div>
		</div>
	</div>
	<br>
	<footer class="text-center">
		<!---Please do not remove the link to support us, thanks!-->
		<p>&copy; 2018 <a href='<?=$faucet['url']?>'><?=$faucet['name']?></a>, <strong id='copyright'>Powered by <a href='https://faucet.microzeny.com/' class="cbc">microzeny faucet</a></strong></p>
		<p>Original Script <strong id='copyright'>Powered by <a href='http://coinbox.club' class="cbc">CoinBox Script</a></strong></p>
	</footer> 
	<script src="template/js/popper.min.js"></script>
	<script src="template/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/7002d3875b.js"></script>
	<script src="template/js/adblock.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<?php if (isset($alert)) { ?>
	<script type='text/javascript'>$('#alert').modal('show');</script>
	<?php  } ?>
	<script type="text/javascript"> var fauceturl = '<?=$faucet['url']?>'; </script>
	<script type="text/javascript" src="template/js/timer.js"></script>
	<script type="text/javascript" src="template/js/faucet.js"></script>
</body>
</html>
<?php
$mysqli->close();
?>
	