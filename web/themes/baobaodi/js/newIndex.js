$(function() {
	$('.tabMenu li.line:last').hide();
	$('.tabMenu li span.left:first').hide();
	$('.noneline a.NRblock:last').addClass('bbm0');
	$('.noneline a.NRblock:first').css({padding:'0px'});
    //焦点图
   /* $('#focusMap1').focusMap({
        _zhuangtai: '2',
        _CarouselRimClass: '.fmRim',
        _CarouselNavClass: '.fmNav',
        _CarouselConClass: '.fmCon',
        arrowStart_opacity: "1",
        arrowEnd_opacity: "1",
        fmNavLiStart_opacity: "1",
        fmNavLiEnd_opacity: "1",
        timing: "4000"
    });*/
    //今日精品
    $('#TBBRim').focusMap({
        _zhuangtai: '3',
        _CarouselRimClass: '.fmRim',
        _CarouselNavClass: '.fmNav',
        _CarouselConClass: '.fmCon',
        arrowStart_opacity: "1",
        arrowEnd_opacity: "1",
        fmNavLiStart_opacity: "1",
        fmNavLiEnd_opacity: "1",
        timing: "30000"
    });
    //热门活动
    $('#RBmod').focusMap({
        _zhuangtai: '1',
        _CarouselRimClass: '.fmRim',
        _CarouselNavClass: '.fmNav',
        _CarouselConClass: '.fmCon',
        arrowStart_opacity: "1",
        arrowEnd_opacity: "1",
        fmNavLiStart_opacity: "1",
        fmNavLiEnd_opacity: "1",
        timing: "3000"
    });
    //底部即将开始
    $(this).hoverBoxShadow({
        _CategoryBtnClass: '.HBSBlock',
        _Expansion: function() {
            $('.Nbutton').click(function() {
                $('.SubscribeAlerts').hide();
            });
        }
    });
    //热门排行
    $(this).tabBox({
        _warpBox: '.topRanking'
    });
    //右侧即将开始
    $('.idmod li').click(function() {
        var $this = $(this),
        $brandCon = $('.brandCon'),
        num = $this.index();
        $('.idmod li').removeClass('current pink btnbak');
        $this.addClass('current pink');
        $brandCon.hide().eq(num).show();
        $curBrandCon = $brandCon.eq(num);
        $climg = $curBrandCon.find('img[class="clicklazyload"]');
        if($climg.length > 0) {
            $climg.each(function(){
                $(this).attr('class','clicklazyloaded').attr('src',$(this).attr('data-src'));
            })
        }
        if (num == 2) {
            $this.addClass('current pink btnbak');
        }
    });
    //右侧即将开始品牌详情展示
    $('.bc').hover(function() {
        $(this).addClass("hover").css('zIndex', '999');
        var img = $(this).find('img[class="mouselazyload"]');
        if(img.length > 0) {
            img.attr('src',img.attr('data-src')).attr('class','mouselazyloaded');
        }
    },
    function() {
        $(this).removeClass("hover").css('zIndex', '0');
    });

    $.ajax({
        url: '/instant/welcome/ajaxGetTimerInfo/',
        type: 'get',
        dataType: 'json',
        success:function(res) {
            $.each(res, function(index, item) {
                var showDingyue = $("#outlets_box_"+item.id).find('.sale');
                if (showDingyue && showDingyue.length > 0 ) {
                    $.each(showDingyue, function(index, val) {
                        $(val).remove();
                    });
                }
                $('#counter_'+item.id).empty();
                $('#counter_'+item.id).timer({
                    starTime: item.start,
                    endTime: item.end,
                    digitItvWidth: 25,
                    digitWidth: 45,
                    digitHeight: 46,
                    id:index,
                    timerEnd:function(){

                    }
                });
            });
        }
    });
    $.ajax({
        url: '/instant/welcome/ajaxGetOutletStatus/',
        type: 'POST',
        dataType: 'json',
        success:function(res) {
            $.each(res, function(index, item) {
                var showDingyue = $("#outlets_box_"+item.oid).find('.SoldOut');
                if (showDingyue && showDingyue.length > 0 ) {
                    showDingyue.removeClass('dn');
                }
                var djs = $("#outlets_box_"+item.oid).find('.djs');
                if (djs && djs.length > 0 ) {
                    djs.hide();
                }
            });
        }
    });
    /* 4单品倒计时 */
    $('.Commodity .djs .time').each(function(index, el) {
        var _this = $(this);
        if (_this.data('starttime')) {
            _this.timer({
                starTime: _this.data('starttime'),
                endTime: _this.data('endtime'),
                id:index,
                timerEnd:function(){

                }
            });
        }
    });

    $('.myDY').hover(
        function(){
            var $_this = $(this),
                $_StartTime = $_this.find('.StartTime');//开售时间
            $_Subscribed = $_this.find('.Subscribed'),//订阅成功
                $_Mask = $_this.find('.Mask'),//蒙版
                $_MobilePhone = $_this.find('.MobilePhone'),//输入层
                $_noticeinp = $_this.find('.noticeinp'),//输入手机号
                $_erroPhone = $_this.find('.erroPhone');//错误提示
            $_sendNotice = $_this.find('.sendNotice');//提示我button
            if(!$_Subscribed.is(":visible")){
                $_Mask.hide();
                $_StartTime.hide();
                $_MobilePhone.show();
                var Mval = $_this.find('.noticeinp').val();
                if(!Mval == ''){
                    if (!Mval.match(/^(?:13\d|15\d|18\d)\d{5}(\d{3}|\*{3})$/)) {
                        $_erroPhone.show().css({top:'25px'});
                        return false;
                    }
                }else{
                    $_noticeinp.val(numphone);//默认手机号
                }
                function Verification(){
                    var outletsId = $(this).attr("param");
                    if (!outletsId) {
                        $(this).parent().prev('.erroPhone').html('<div>特卖ID有误！<span></span></div>').stop(true).animate({top:'25px',opacity: "show"},500);//错误提示
                        $(this).prev('.noticeinp').focus();
                        return false;
                    }
                    var Email = $('input[name="email_'+outletsId+'"]').val();
                    var myreg = /^1[3578][0-9]{9}$/;
                    if(!myreg.test(Email)) {
                        $(this).parent().prev('.erroPhone').html('<div>请输入正确的手机号码<span></span></div>').stop(true).animate({top:'25px',opacity: "show"},500);//错误提示
                        $(this).prev('.noticeinp').focus();
                        return false;
                    }
                    obj = $(this);
                    $.ajax({
                        url: '/instant/welcome/ajaxAddSubscriptionMobile/',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            outlets_id: outletsId,
                            email: Email
                        },
                        success:function(res) {
                            if (res.res == false) {
                                if (res.data == 'outlets_id') {
                                    obj.parent().prev('.erroPhone').html('<div>特卖ID有误！<span></span></div>').stop(true).animate({top:'25px',opacity: "show"},500);//错误提示
                                    obj.prev('.noticeinp').focus();
                                    return false;
                                }
                                if (res.data == 'email') {
                                    obj.parent().prev('.erroPhone').html('<div>请输入正确的手机号码<span></span></div>').stop(true).animate({top:'25px',opacity: "show"},500);//错误提示
                                    obj.prev('.noticeinp').focus();
                                    return false;
                                }
                                if (res.data == 'insert') {
                                    obj.parent().prev('.erroPhone').html('<div>订阅失败！<span></span></div>').stop(true).animate({top:'25px',opacity: "show"},500);//错误提示
                                    obj.prev('.noticeinp').focus();
                                    return false;
                                }
                            }
                            var curMoileMsg = obj.prev('.noticeinp').val();
                            numphone = curMoileMsg;
                            var cell_phone_date = new Date();
                            cell_phone_date.setTime(cell_phone_date.getTime()+1*24*3600*1000);
                            setcookie('cell_phone',numphone,cell_phone_date.toGMTString());
                            obj.parent().prev('.erroPhone').hide();
                            obj.parent('.MobilePhone').hide();
                            obj.parent().next('.SuccessHint').show().delay(4000).fadeOut(800,function(){
                                obj.parent().parent().find('.StartTime').show();
                                obj.parent().parent().find('.Subscribed').show();
                                obj.parent().parent().find('.Mask').show();
                            });
                            return ;
                        }
                    });

                }
                $_sendNotice.unbind('click').bind("click", Verification);

            }
        },
        function(){
            $(this).find('.Mask').show();
            $(this).find('.MobilePhone').hide();
            $(this).find('.erroPhone').hide();
            $(this).find('.StartTime').show();
        }
    );
	
	$('.popclose02').click(function(){
        var date = new Date();
        date.setHours(23);
        date.setMinutes(59);
        date.setSeconds(59);
        setcookie('display', 1, date.toUTCString());
        $('.indexpopbg,.indexpop').hide();
	});
        
	
       
        
});
var numphone = '';//订阅电话号码
cell_phone = getcookie('cell_phone');
var myreg = /^1[3578][0-9]{9}$/;
if(cell_phone && myreg.test(cell_phone)) {
    numphone = cell_phone;
}
$(document).ready(function(){
    hpop();
    recommendAutoByTime();
})
var recommendAuto = '';
var recommendAutoIndex = 0;
function recommendAutoByTime() {
    recommendAuto = setInterval(function(){
        recommendAutoIndex++;
        if(recommendAutoIndex > ($('.tabMenu li').length - 1)) {
            recommendAutoIndex = 0;
        }
        $('.tabMenu li').eq(recommendAutoIndex).trigger('click');
    },10000);
}

$('.tabContent').live({'mouseenter':function(){
    clearInterval(recommendAuto);
},'mouseleave':function(){
    recommendAutoByTime();
}})

function hpop(){
    var mpop = $('#hpop .sp');
    var _w = $('body').width();
    if (mpop.length>0) {
       // $('#hpop').css({height:'50px',width:_w});
       // mpop.css({width:_w,height:'50px'});
	   $('.topbar').hide();
        jQuery(document).ready(function($) {
            if ($('.HolidayBackgroundBottom').hasClass('pull')) {
                var bigpop = new Image();
                if (mpop.attr('data-bimg')) {
                    bigpop.src = mpop.attr('data-bimg');
                    $(bigpop).load(function(){
                        if (bigpop.src) {
                            var _this = $('<span style="background-image:url('+bigpop.src+');background-repeat:no-repeat;background-position:center top;position:relative;background-color:#ff5521;z-index:999999;"></span>');
                            /* 平时 */
                            var _this2 = $('<span id="closehpop"></span>');
                            _this2.appendTo(_this).css({position:'absolute',bottom:3+'px',left:(_w-1000)/2 +1000-80 ,color:'#000',display:'block',height:'40px',width:'60px',padding:'0 6px','line-height':'20px'})
                            /* 大促 */
                            // var _this2 = $('<span id="closehpop"></span>');
                            // _this2.appendTo(_this).css({position:'absolute',top:10,left:(_w-1000)/2 +1000-40 ,background:'#fff',color:'#000','background-color':'transparent',display:'block',height:'40px',width:'40px',padding:'0 6px','line-height':'20px'});
                            /* 大促 */
                            $('body').delegate('#closehpop', 'click', function(event) {
                                event.preventDefault()
                                _this.hide();
                            });
                            _this.css({width:_w}).appendTo('#hpop .sp').eq(0).css({display:'block',height:'50px',position:'relative'}).animate({height:"578px"},400,'linear',function(){
                                setTimeout(function(){
                                    _this.slideUp(400,function(){$('.topbar').show();});
									$()
                                },6000);
                            })
                        };
                    })
                };

            }
        });
    }
    

}


