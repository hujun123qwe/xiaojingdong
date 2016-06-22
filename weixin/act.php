<?php
require(dirname(__FILE__) . '/api.class.php');
if(!$_SESSION['user_id']){
	//$uid = 12;
	exit("您还没有绑定会员，请绑定后再来砸金蛋吧！");
}
$aid = intval($_GET['aid']);
$act = $db->getRow ( "SELECT * FROM `weixin_act` WHERE `aid` = $aid and isopen=1" );
if(!$act) exit("活动已经结束");
$actList = (array)$db->getAll ( "SELECT * FROM `weixin_actlist` where aid=1 and isopen=1" );
if(!$actList) exit("活动为设置奖项");
$sql = "SELECT weixin_actlog.*,weixin_user.nickname FROM `weixin_actlog` 
		left join weixin_user on weixin_actlog.uid=weixin_user.ecuid 
		where code!='' order by lid desc";
$award = $db->getAll ( $sql );

$api = new weixinapi();
$awardNum = intval($api->getAwardNum($aid));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $act['title'];?>-活动抽奖</title>
<link type="text/css" rel="stylesheet" href="assets/css.css" />
<script type="text/javascript" src="assets/jquery.js"></script>
</head>

<body>

	<div class="grid">
		<div id="hammer"><img src="assets/img2.png" height="87" width="74" alt=""></div>
		<div id="f"><img src="assets/img1.png" /></div>
		<div id="banner">
			  <dl>
			    <dt>
			      <a href="javascript:;"><img src="assets/egg.png" ></a>
			      <a href="javascript:;"><img src="assets/egg.png" ></a>
			      <a href="javascript:;"><img src="assets/egg.png" ></a>
			      <a href="javascript:;"><img src="assets/egg.png" ></a>
			      <a href="javascript:;"><img src="assets/egg.png" ></a>
			      <a href="javascript:;"><img src="assets/egg.png" ></a>
			      <a href="javascript:;"><img src="assets/egg.png" ></a>
			    </dt>
			    <dd></dd>
			  </dl>
		</div>
		<div class="block">
         <div class="box">
			<div class="title">剩余次数</div>
			<p>你还可抽奖的次数：<span class="num"><?php echo $awardNum;?></span></p>
		</div>
        </div>
		<div class="block">
        <div class="box">
			<div class="title">活动规则</div>
				<p><?php echo $act['content'];?></p>
		</div>
        </div>
		<div class="block">
         <div class="box">
			<div class="title">奖项设置</div>
				<?php foreach($actList as $v){?>
				<p><?php echo $v['title'];?>---<?php echo $v['awardname'];?> ---奖品数量：<?php echo $v['num'];?></p>
				<?php }?>
			</div>
            </div>
		<div class="block">
         <div class="box">
			<div class="title">中奖记录</div>
				<?php foreach($award as $v){?>
				<p><?php echo $v['nickname'];?>----<?php echo $v['class_name'];?></p>
				<?php }?>
		</div>
        </div>
	</div>
	<div id="mask"></div>
	<div id="dialog" class="yes">
		<div id="content"></div>
		<button id="close">关闭</button>
	</div>

</body>
</html>
<script>
    $(function () {
        var timer, forceStop;
        var wxch_Marquee = function (id) {
            try {
                document.execCommand("BackgroundImageCache", false, true)
            } catch (e) {};
            var container = document.getElementById(id),
                original = container.getElementsByTagName("dt")[0],
                clone = container.getElementsByTagName("dd")[0],
                speed = arguments[1] || 10;
            clone.innerHTML = original.innerHTML;
            var rolling = function () {
                if (container.scrollLeft == clone.offsetLeft) {
                    container.scrollLeft = 0
                } else {
                    container.scrollLeft++
                }
            };
            this.stop = function () {
                clearInterval(timer)
            };
            timer = setInterval(rolling, speed);
            container.onmouseover = function () {
                clearInterval(timer)
            };
            container.onmouseout = function () {
                if (forceStop) return;
                timer = setInterval(rolling, speed)
            }
        };
        var wxch_stop = function () {
            clearInterval(timer);
            forceStop = true
        };
        var wxch_start = function () {
            forceStop = false;
            wxch_Marquee("banner", 20)
        };
        wxch_Marquee("banner", 20);
        var $egg;
        $("#banner a").on('click', function () {
            wxch_stop();
            $egg = $(this);
            var offset = $(this).position(),
                $hammer = $("#hammer");
            $hammer.animate({
                left: (offset.left + 30)
            }, 1000, function () {
                $(this).addClass('hit');
                $("#f").css('left', offset.left).show();
                $egg.find('img').attr('src', 'assets/egg2.png');
                setTimeout(function () {
                    act_result.call(window)
                }, 500)
            })
        });
        $("#mask").on('click', function () {
            $(this).hide();
            $("#dialog").hide();
            $egg.find('img').attr('src', 'assets/egg.png');
            $("#f").hide();
            $("#hammer").css('left', '-74px').removeClass('hit');
            wxch_start()
        });
        $("#close").click(function () {
            $("#mask").trigger('click')
        });
        function act_result() {
            $.getJSON("act_prize.php?aid=<?php echo $aid;?>", function (data) {
                $("#mask").show();
                if (data.msg === 1) {
                    $("#content").html(data.prize);
                    $("#dialog").attr("class", 'yes').show();
                    setTimeout(function () {window.location.href = data.url}, 3000)
                } else if (data.msg === 0) {
                    $("#content").html(data.prize);
                    $("#dialog").attr("class", 'no').show()
                } else if (data.msg == 2) {
                    $("#content").html(data.prize);
                    $("#dialog").attr("class", 'no').show()
                };
                $(".num").text(data.num - 1)
            })
        }
    });
</script>