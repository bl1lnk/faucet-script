<?php 
include 'libs/core.php'; 
$_SESSION['token'] = get_token(70);
?>
<!DOCTYPE html>
<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112493597-7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112493597-7');
</script>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Info Ad - <?=$faucet['name']?></title> 
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
	}
	/*img, iframe {
		max-width: 100%;
    }*/
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
</style>
</head>
<body> 
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<a class="navbar-brand" href="index.php"><?=$faucet['name']?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
<div id="nav"></div>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#"><i class="fa fa-balance-scale" aria-hidden="true"></i> Faucetの残高: <?=get_info(30)/100000000?> <?=$currency_name?> <span class="sr-only">(current)</span></a>
				</li>
			</ul>
		</div>
	</nav>
	<center>
		<?=$ad['top']?>
    </center>
    <div class="container-fluid" style="margin-top: 30px;">
		<div class="row">
            <div class="col-sm-3 text-center" style="margin-top: 20px;">
				<?=$ad['left']?>
			</div>
            <div class="col-sm-6 login" align="center">
                <h1 class="title">Info Ad</h1>
                    <h3>このFaucetの広告枠販売について</h3>
                    <p>このFaucetでは、広告枠を販売しています。なお、販売中の広告枠<del>にはそれを知らせる広告が入ります。</del><br>→以下の価格表に記載のある枠のみの販売です。</p>
                    <p>購入したい場合などは、<a href="https://twitter.com/kikiriko200">DAFU</a>へご連絡ください。</p>
                    <h3>価格</h3>
                    <p>ここに記載されている価格は日本円での価格です。<br>当サイトでは広告出稿にあたり等価の仮想通貨での支払いにも対応しております。<br>お気軽にお問い合わせください。</p>
<div class="scroll">
                    <table class="price-ad">
                        <thead>
                            <tr>
                                <th>
                                    枠名
                                </th>
                                <th>
                                    価格
                                </th>
                                <th>
                                    推奨画像サイズ
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Left Ad Slot(PC)
                                </td>
                                <td>
                                    100円/日〜
                                </td>
                                <td>
                                    160*600(縦長)
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Right Ad Slot(PC)
                                </td>
                                <td>
                                    100円/日〜
                                </td>
                                <td>
                                    160*600
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Left Ad Slot(SP)
                                </td>
                                <td>
                                    100円/日〜
                                </td>
                                <td>
                                    500*500(正方形)
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Right Ad Slot(SP)
                                </td>
                                <td>
                                        100円/日〜
                                    </td>
                                    <td>
                                        500*500
                                    </td>
                                </tr>
                        </tbody>
                    </table>
</div>

                    <h3>当サイトについて</h3>
                    <p>このサイトのPV - 約400-500/日</p>
                    <p>価格の根拠 - 3月分Adsense収益見積もりより</p>
                    <p>連絡先 - <a href="https://twitter.com/kikiriko200">kikiriko200</a></p>
                    <h3>広告枠購入状況</h3>
                    <iframe src="https://calendar.google.com/calendar/embed?src=cjtdh0megg544of067q8l24stc%40group.calendar.google.com&ctz=Asia%2FTokyo" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
                    <p>SHARE:<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a></p>
                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    <center>
					<?=$ad['above-form']?>
					<?=$ad['bottom']?> 
				    </center>
            </div>
            <div class="col-sm-3 text-center" style="margin-top: 20px;">
				<?=$ad['right']?>
            </div>
        </div>
    </div>
	<footer class="text-center">
		<!---Please do not remove the link to support us, thanks!-->
		<p>&copy; 2018 <a href='<?=$faucet['url']?>'><?=$faucet['name']?></a>, <strong id='copyright'>Powered by <a href='https://faucet.microzeny.com/' class="cbc">microzeny faucet</a></strong></p>
		<p>Original Script <strong id='copyright'>Powered by <a href='http://coinbox.club' class="cbc">CoinBox Script</a></strong></p>
                <p>Donation:Zx4QgiTBaYC4JjWoDzhs9BNuJeZaBLjVkc (faucet)<br>ZrygyyCfH2ojupuGhNzLyKAuNMUsuaDrhc(Admin)</p>
	</footer> 
	<script src="template/js/popper.min.js"></script>
	<script src="template/js/bootstrap.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
	<script src="template/js/adblock.js"></script>
	<?php if (isset($alert)) { ?>
	<script type='text/javascript'>$('#alert').modal('show');</script>
	<?php  } ?>
	<script type="text/javascript"> var fauceturl = '<?=$faucet['url']?>'; </script>
	<script type="text/javascript" src="template/js/timer.js"></script>
	<script type="text/javascript" src="template/js/faucet.js"></script>
</body>
</html>