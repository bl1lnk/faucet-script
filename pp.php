<?php 
include 'libs/core.php'; 
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
</style>
</head>
<body> 
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php"><?=$faucet['name']?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="about.php"><i class="fa fa-info" aria-hidden="true"></i> About us</a>
                </li>
                <li class="nav-item">
					<a class="nav-link" href="info-ad.php"><i class="fas fa-audio-description"></i> About Ad </a>
                </li>
                <li class="nav-item">
					<a class="nav-link" href="pp.php"><i class="fas fa-audio-description"></i> Privacy Policy </a>
                </li>
                <!--
				<li class="nav-item">
					<a class="nav-link" href="#"><i class="fa fa-envelope-open" aria-hidden="true"></i> Contact</a>
				</li>
                -->
                <li class="nav-item">
					<a class="nav-link" href="https://faucet.microzeny.com/"><i class="fa fa-link" aria-hidden="true"></i>Other Microzeny Faucet</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="https://github.com/microzeny/faucet-script"><i class="fa fa-bolt" aria-hidden="true"></i>Microzeny Faucet Script</a>
				</li>
			</ul>
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
	<h1 class="ttl-bdr">プライバシーポリシー</h1>
	<div class="container-fluid" style="margin-top: 30px;">
		<div class="row">
			<div class="col-sm-3 text-center" style="margin-top: 20px;">
				<?=$ad['left']?>
			</div>
			<div class="formbox">
				<center>
					<?=$ad['above-form']?>
				</center>
					
                <div>
                    <p><strong>広告の配信について</strong></p>
                    <p>当サイトは第三者配信の広告サービス「Google Adsense グーグルアドセンス」を利用しています。</p>
                    <p>広告配信事業者は、ユーザーの興味に応じた広告を表示するためにCookie（クッキー）を使用することがあります。</p>
                    <p>Cookie（クッキー）を無効にする設定およびGoogleアドセンスに関する詳細は「<a href="https://www.google.co.jp/policies/technologies/ads/" target="_blank" rel="noopener">広告 &#8211; ポリシーと規約 &#8211; Google</a>」をご覧ください。</p>
                    <p>第三者がコンテンツおよび宣伝を提供し、訪問者から直接情報を収集し、訪問者のブラウザにCookie（クッキー）を設定したりこれを認識したりする場合があります。</p>
                    <p><strong>アクセス解析ツールについて</strong></p>
                    <p>当サイトでは、Googleによるアクセス解析ツール「Googleアナリティクス」を利用しています。</p>
                    <p>このGoogleアナリティクスはトラフィックデータの収集のためにCookieを使用しています。このトラフィックデータは匿名で収集されており、個人を特定するものではありません。この機能はCookieを無効にすることで収集を拒否することが出来ますので、お使いのブラウザの設定をご確認ください。この規約に関して、詳しくは<a href="https://www.google.com/analytics/terms/jp.html" target="_blank" rel="noopener">ここをクリック</a>してください。</p>
                    <p><strong>免責事項</strong></p>
                    <p>当サイトで掲載している画像の著作権・肖像権等は各権利所有者に帰属致します。権利を侵害する目的ではございません。記事の内容や掲載画像等に問題がございましたら、各権利所有者様本人が直接メールでご連絡下さい。確認後、対応させて頂きます。</p>
                    <p>当サイトからリンクやバナーなどによって他のサイトに移動された場合、移動先サイトで提供される情報、サービス等について一切の責任を負いません。</p>
                    <p>当サイトのコンテンツ・情報につきまして、可能な限り正確な情報を掲載するよう努めておりますが、誤情報が入り込んだり、情報が古くなっていることもございます。</p>
                    <p>当サイトに掲載された内容によって生じた損害等の一切の責任を負いかねますのでご了承ください。</p>
                </div>
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
	<script src="template/js/jquery-3.2.1.min.js"></script>
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