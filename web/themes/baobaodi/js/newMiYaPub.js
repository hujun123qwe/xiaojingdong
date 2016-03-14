$.fn.extend({
    //Expansion effect
    Nnav: function(con) {
        var defaults = {
            _CategoryBtnClass: '.topnav',
            _CategoryContentClass: '.zongkuang',
            _Expansion: function() {},
            _Expansion2: function() {}
        };
        var settings = $.extend(defaults, con);
        settings.element = $(this);

        //var i=0;
        $(settings._CategoryBtnClass).hover(function() {
            $(this).addClass('cur');
        },
        function() {
            $(this).removeClass('cur');
        });


    },
    //focusMap
    focusMap: function(con) {
        var defaults = {
            _CarouselRimClass: '.fmRim',
            _CarouselNavClass: '.fmNav',
            _CarouselConClass: '.fmCon',
            arrowStart_opacity: "0.2",
            arrowEnd_opacity: "0.6",
            fmNavLiStart_opacity: "0.9",
            fmNavLiEnd_opacity: "1",
            timing: "3000"
        };
        var settings = $.extend(defaults, con);
        settings.element = $(this);
        if($(this).attr('id') == 'TBBRim') {
            return false;
        }

        var index = 0,
        picTimer, time = 800,
        $focusMap = $(settings.element),
        $fmRim = $focusMap.find(settings._CarouselRimClass),
        $fmNav = $focusMap.find(settings._CarouselNavClass),
        $fmCon = $focusMap.find(settings._CarouselConClass),
        $fmConLi = $fmCon.find('li'),
        $fmNavUl = $fmNav.find('ul'),
        $fmNavLi = $fmNav.find('li'),
        _fmNavLiWidth = $fmNavLi.innerWidth(),
        len = $fmConLi.length,
        btnCon = "<a class='prev'>Prev</a><a class='next'>Next</a>";

        $fmRim.append(btnCon);

        $fmNavUl.css({
            'width': (_fmNavLiWidth + 8) * len,
            'padding-left': '9px'
        });

        var $btnAll = $fmRim.find('.prev,.next'),
        $btnPrev = $fmRim.find('.prev'),
        $btnNext = $fmRim.find('.next');

        var sWidth = $fmRim.width(); //sWidth
		
        $fmNavLi.css({
            "opacity": settings.fmNavLiStart_opacity
        }).click(function() {
            index = $fmNavLi.index(this);
            showPics(index);
        }).eq(0).trigger("click");
		var num = $fmConLi.length;
		if(num==1){$fmNav.hide();}else{}
		$focusMap.hover(function() {
				if(num==1){}else{
					$btnAll.stop(true, false).show().animate({
					"opacity": settings.arrowStart_opacity
					},
					300);
					$btnAll.hover(
						function() {
							$(this).stop(true, false).animate({
								"opacity": settings.arrowEnd_opacity
							},
							300);
						},
						function() {
							$this = $(this);
							$(this).stop(true, false).animate({
								"opacity": settings.arrowStart_opacity
							},
							300);
						}
					);
				}
				},
				function() {
				$btnAll.stop(true, false).hide();
				});
        // Prev
        $btnPrev.click(function() {
            index -= 1;
            if (index == -1) {
                index = len - 1;
            }
            showPics(index);
        });

        // Next
        $btnNext.click(function() {
            index += 1;
            if (index == len) {
                index = 0;
            }
            showPics(index);
        });

        $fmCon.css("width", sWidth * (len)); //sWidth
        // mouse 
        $fmRim.hover(function() {
            clearInterval(picTimer);
        },
        function() {
            picTimer = setInterval(function() {
                showPics(index);
                index++;
                if (index == len) {
                    index = 0;
                }
            },
            settings.timing);
        }).trigger("mouseleave");

        // showPics
        function showPics(index) {
            if (settings._zhuangtai == 1) {
                var nowLeft = -index * sWidth;
                /*if(len-sWidth == index*sWidth-sWidth){
				alert('1');
				}*/
                $fmCon.stop(true, false).animate({
                    "left": nowLeft
                },
                300);
            }
            if (settings._zhuangtai == 2) {
                $fmConLi.stop(true).hide().eq(index).show();
                $focusMap.attr("class", "fmBg" + index);
            }
			if(settings._zhuangtai == 3){
				$fmConLi.stop(true).hide().eq(index).show();
			}
            $fmNavLi.removeClass("current").eq(index).addClass("current").end().stop(true).eq(index).stop(true);

        }
    },
    //hoverBoxShadow
    hoverBoxShadow: function(con) {
        var defaults = {
            _CategoryBtnClass: '.moud',
            //_hoverBoxShadowClass:'.hoverBoxShadow',
            _Expansion: function() {}
        };
        var settings = $.extend(defaults, con);
        settings.element = $(this);

        $(settings._CategoryBtnClass + ' > div').hover(function() {
            $(this).addClass("cur");
        },
        function() {
            $(this).removeClass("cur");
        });
        settings._Expansion();
    },
    //boxMask
    boxMask: function(con) {
        var defaults = {
            _opacity: "0.4",
            timing: "3000"
        };
        var settings = $.extend(defaults, con);
        settings.element = $(this);
        var _warpBox = $(settings.element).children();
        _warpBox.hover(function() {
            var _h = $(this).height();
            var _MaskLayer = $(this).children().last();
            var _mlbg = $(this).children().last().children().first();
            _mlbg.css("opacity", settings._opacity);
            _MaskLayer.stop().slideDown().animate({
                marginTop: "-" + _h,
                height: _h
            },
            settings.timing);
            $(this).addClass("cur");
        },
        function() {
            var _MaskLayer = $(this).children().last();
            $(this).removeClass("cur");
            _MaskLayer.stop().animate({
                'marginTop': '0px',
                'height': '0px'
            },
            settings.timing, 'easeOutBounce',
            function() {
                $(this).hide();
            });
        });
        return this;
    },
    //tabBox
    tabBox: function(con) {
        //alert(arguments[2]._warpBox);
        var _myWarpBox = con._warpBox;
        var _mytabMenu = $(_myWarpBox + ' > ul');
        var _li = $(_mytabMenu).find('li');
        var _myTabContents = $(_myWarpBox + ' > div');
        var _myTabContentsDiv = $(_myWarpBox + '> div > div.parent');

        _li.click(function() {
            //alert('dd');
            if (!$(this).hasClass('selected')) {
                _li.removeClass('selected');
                $(this).addClass('selected');
                $(_myTabContentsDiv).hide();
                //$(_myTabContentsDiv).slideUp('1500');
                var cur = $(_li).index(this); //获取当前点击
                //cur /= 2;
                recommendAutoIndex = cur;
                $(_myTabContentsDiv).eq(cur).show();
                $climg = $(_myTabContentsDiv).eq(cur).find('img[class="clicklazyload"]')
                if($climg.length > 0) {
                    $climg.each(function(){
                        $(this).attr('class','clicklazyloaded').attr('src',$(this).attr('data-src'));
                    })
                }
                //$(_myTabContentsDiv).eq(cur).slideDown('1500');
            }
        }).mouseover(function() {
            $(this).addClass('mouseover');
            $(this).removeClass('mouseout');
        }).mouseout(function() {
            $(this).addClass('mouseout');
            $(this).removeClass('mouseover');
        });
        var _liAnimate = $('.category li');
        _liAnimate.mouseover(function() {
            $(this).css('backgroundColor', '#888');
            // $(this).show();
            //$(this).animate({paddingLeft:"20px"}, {queue:false, duration:300});
        }).mouseout(function() {
            $(this).css('backgroundColor', '#fff');
            //$(this).hide();
            //$(this).animate({paddingLeft:"0px"}, {queue:false, duration:300});
        });
    },
    aaa: function() {
        var $this = $(this),
        $input = $this.find('input'),
        $ul = $this.find("ul"),
        $li = $this.find("li"),
        $select_boxNum = $(".select_box");

        $input.bind('click',
        function() {
            $select_boxNum.each(function(i) {
                $(this).css('zIndex', i);
            });
            $this.css('zIndex', $select_boxNum.length);
            if ($ul.css("display") == "none") {
                if ($ul.height() > 200) {
                    $ul.css({
                        height: "200" + "px",
                        "overflow-y": "scroll"
                    })
                };
                $ul.fadeIn("100");
                $ul.hover(function() {
                    $ul.parent().find("input").addClass("hover_select");
                },
                function() {
                    $ul.fadeOut("100");
                    $ul.parent().find("input").removeClass("hover_select");
                });
            } else {
                $ul.fadeOut("fast");
            }
        }).hover(function() {
            $(this).addClass("hover_select");
        },
        function() {
            $(this).removeClass("hover_select");
        }).parent().mouseleave(function() {
            $ul.fadeOut();
        });
        $li.click(function() {
            var selectData = $(this).attr('code');
            $input.val($(this).text()).attr('code', selectData);
            $ul.fadeOut("100");
            //$input.trigger("onchange");
        }).hover(function() {
            $(this).addClass("hover_li");
        },
        function() {
            $(this).removeClass("hover_li");
        });
    },
    //gotop
    gotop: function() {
        var goTopShowAndHide = function() {
            h = $(window).height();
            t = $(document).scrollTop();
            if (t < 20) {
                $('.rightFunction,.leftExtension').addClass("dn");
            } else {
                $('.rightFunction,.leftExtension').removeClass('dn');
            }
      /*if(t > h){
        $('.gotop').show();
      }else{
        $('.gotop').hide();
      }*/
        };
        goTopShowAndHide();
        $('.Ngotop').click(function() {
            $(document).scrollTop(0);
        });
        $(window).scroll(function() {
            goTopShowAndHide();
        });
    },timer: function(con){
        var defaults = {
        };
        var settings = $.extend(defaults, con);
        settings.element = $(this);

        var myHour,myMinute,mySecond,
            Tday = new Date(settings.endTime),
            sday = new Date(settings.starTime),
            daysms = 24 * 60 * 60 * 1000,
            hoursms = 60 * 60 * 1000,
            Secondms = 60 * 1000,
            microsecond = 1000,
            arr = new Array(":",":",":",".",""),
            numcon='';
        for( var i=-1, n=5; ++i < n;){
            if(i == 4) {
                numcon += '<span class="appw t'+i+'">?</span><span class="cntSeparator">'+arr[i]+'</span>';
            } else {
                numcon += '<span class="appw t'+i+'">??</span><span class="cntSeparator">'+arr[i]+'</span>';
            }
        }
        $(settings.element).append(numcon);
        // $(settings.element).find('.appw').css({'width':settings.digitWidth,'height':settings.digitHeight});
        // $(settings.element).find('.cntSeparator').css({'width':settings.digitItvWidth,'height':settings.digitHeight});
        var starTime = 0;
        function clock(){
            Diffms = Tday.getTime() - (sday.getTime()+starTime);
            // console.log(Diffms);
            starTime = starTime+1000;
            if (Diffms > 0) {
                myHour = Math.floor(Diffms / daysms);
                Diffms -= myHour * daysms;
                myMinute = Math.floor(Diffms / hoursms);
                Diffms -= myMinute * hoursms;
                mySecond = Math.floor(Diffms / Secondms);
                Diffms -= mySecond * Secondms;
                var dSecs = Math.floor(Diffms / microsecond);
                if(myHour < 10){
                    myHour = '0' + myHour;
                }
                if(myMinute < 10){
                    myMinute = '0' + myMinute;
                }
                if(mySecond < 10){
                    mySecond = '0' + mySecond;
                }
                if(dSecs < 10){
                    dSecs = '0' + dSecs;
                }
                var hourDiv = $(settings.element).find('.t0'),
                    minuteDiv = $(settings.element).find('.t1'),
                    secondDiv = $(settings.element).find('.t2'),
                    dSecsDiv = $(settings.element).find('.t3');
                hourDiv.html(myHour);
                minuteDiv.html(myMinute);
                secondDiv.html(mySecond);
                dSecsDiv.html(dSecs);
                if ($(settings.element).css("display") == 'none') {
                    $(settings.element).show();
                }
            }else{
                clearInterval(InterValObj);
                var endcon = '<p>活动已结束</p>';
                $(settings.element).html(endcon);
                settings.timerEnd();
            }
        }
        var InterValObj = 'InterValObj'+settings.id;
        InterValObj= setInterval(function(){clock();}, 1000);
        var t4 = $(settings.element).find('.t4');
        var mms = 9;
        setInterval(function(){
            if (mms <= 0 ) {
                mms = 9
            }else{
                mms -= 1
            }
            $(settings.element).find('.t4').text(mms)
        },100)
    }
});
$(document).ready(function(){
    //公用滑动下展
    $(this).Nnav({
        _CategoryBtnClass: '.PubBtnHover',
        _CategoryContentClass: '.PubConHover',
        _Expansion: function() {}
    });
    //返回顶部
    $(this).gotop();
    //返回顶部内延展
    $('.rightFunction > div').hover(function() {
        $(this).find('.cur').stop(true, true).show().animate({
                left: "0px"
            },
            0);
        $(this).css({
            overflow: "visible"
        });
        $(this).find('.pop').stop(true, true).animate({
                left: "-150px",
                opacity: "toggle"
            },
            400);
    },
    function() {
        $(this).css({
            overflow: "hidden"
        });
        $(this).find('.cur').stop(true, true).show().animate({
                left: "65px"
            },
            100); //变色
        $(this).next().show().stop(true, true).animate({
                left: "0px"
            },
            100); //变色隐藏
        $(this).find('.pop').stop(true, true).animate({
                left: "-187px",
                opacity: "toggle"
            },
            0); //左侧弹层隐藏
    });
    $(this).Nnav({
        _CategoryBtnClass: '.indexCategory',
        _CategoryContentClass: '.sCartCon',
        _Expansion: function() {

        }
    });



    function addCart() {
        ajaxReq();
    }
    //hpop();
    var timeout;
	//分类
	$('.sCB').hover(function(){
			clearTimeout(timeout);
			$(this).addClass('cur');
			var leftHeight = $('.CFCon .left').height(),
				rightHeight = $('.CFCon .right').height();
			
				AdjustmentHeight(leftHeight,rightHeight);
		},function(){
			var o = $(this);
			timeout = setTimeout(function(o){
				$('.sCB').removeClass('cur');	
			}
						
			,300);
		});
	
	var AdjustmentHeight = function(leftHeight,rightHeight){
		if(leftHeight>rightHeight){
			$('.CFCon .right').height(leftHeight);
			//$('.Nnav .CFCon .left').css({border:'1px solid #eee'});
			//$('.Nnav .CFCon .right').css({borderLeft:'0px'});
		}else{
			$('.CFCon .left').css({height:'auto'});
			//$('.Nnav .CFCon .left').css({borderRight:'0px'});
			//$('.Nnav .CFCon .right').css({borderLeft:'1px solid #eee'});
		}
	}

	
	$('.CateTitle li').hover(
		function(){
			var $CateTitleLi = $('.CateTitle li'),
				i = $CateTitleLi.index(this),
				$tcate = $('.CateCon .tcate'),
				$tcate_cur=$('.CateCon .tcate').eq(i),
				$ader = $('.CateCon .tcate').eq(i).find('.ader');

			$CateTitleLi.each(function(index, element) {
				var img = $(this).find('img');img.attr('src',img.attr('img1'));
            });
			$CateTitleLi.removeClass('current');
			$(this).addClass('current');
			var img = $(this).find('img').eq(0);
			if(img.attr('img2') !='') {
				 img.attr('src', img.attr('img2'));
			}
			$tcate.hide();
			$tcate_cur.show();
			if($ader.length > 0){
				$tcate_cur.css({width:'443px;'});
			}else{
				$tcate_cur.css({width:'663px'});
			}
			
			$('.CFCon .left,.CFCon .right').css({height:'auto'});
			
			var leftHeight = $('.CFCon .left').height(),
				rightHeight = $('.CFCon .right').height();
			AdjustmentHeight(leftHeight,rightHeight);
			
			
		}
	);
	//end 分类
	//搜索
	$('#searchButton').click(function(){
		var ele = $('.Nsearch input.text');
		if($.trim(ele.val()) ==''){
			return false;
		}else{
			$(this).nextAll('.lenovoWord').hide();
			var textEle = $(this).parent().find('input.text');
			var url = '/search/s?k='+ encodeURIComponent($.trim(textEle.val()));
			window.location.href = url;
		}
	});
	
        
        var tmp = -1;
	$('.Nsearch input.text').keydown(function(e){
            var alength = $('.Nsearch .lenovoWord a').length;
                if(e.keyCode==13){
                    var searchurl = $('.Nsearch .lenovoWord .stylecolor-id').attr('href');
                    if(searchurl == 'javascript:void(0)' || searchurl == undefined){
                       if($('.Nsearch .lenovoWord .stylecolor-id').length > 0){
                            var word = $('.Nsearch .lenovoWord .stylecolor-id').text();
                            $('.Nsearch input.text').val(word);
                            //$(this).parent().hide();
                            $('.button').trigger('click');
                        }else{
                            if($.trim($('.Nsearch input.text').val()) !='')$('.button').trigger('click');
                        }
                }else{
                    window.location.href = encodeURI(searchurl);
                }
                        
		}else if(e.keyCode==38){
                    if(tmp <= 0){
                        tmp = alength;
                    }
                    tmp= tmp-1;
                    $('.Nsearch .lenovoWord a').removeClass();
                    $('.Nsearch .lenovoWord a').eq(tmp).addClass("stylecolor");
                    $('.Nsearch .lenovoWord a').eq(tmp).addClass("stylecolor-id");
                    var word = $('.Nsearch .lenovoWord .stylecolor-id').text();
                    $('.Nsearch input.text').val(word);
                }else if(e.keyCode==40){
                    if(tmp >= alength-1){
                        tmp = -1;
                    }
                    tmp = tmp+1;
                    $('.Nsearch .lenovoWord a').removeClass();
                    $('.Nsearch .lenovoWord a').eq(tmp).addClass("stylecolor");
                    $('.Nsearch .lenovoWord a').eq(tmp).addClass("stylecolor-id");
                    var word = $('.Nsearch .lenovoWord .stylecolor-id').text();
                    $('.Nsearch input.text').val(word);
                    
                }
                
	});
    
	//搜索
    var isFocus = false;
	$('.Nsearch input.text').on('focus',function(){
		$(this).nextAll('.lenovoWord').show();
        isFocus = true;
	});
    $('.Nsearch input.text').blur(function(event) {
        isFocus = false;
    });
    $(document).on("click", function(e) {
        var target = $(e.target);
        if (target.closest(".lenovoWord").length == 0 && !isFocus) {
            $(".lenovoWord").hide();
        };
        e.stopPropagation();
    });
	$('.button').click(function(){
		$(this).next().hide();
	});
	var lenovoCon = function(){
		var word = $(this).text();
		$('.Nsearch input.text').val(word);
		//$(this).parent().hide();
                $('.button').trigger('click');
	}
	$('.Nsearch .lenovoWord a').bind({click:lenovoCon});

	//END 搜索
        
	var word_timer = null;
	//输入框触发
	$('#productWord').bind('input propertychange', function() {
		var lenovoWord = $('#searchButton').parent().find('input.text').val();
		clearTimeout(word_timer);
		word_timer = setTimeout(function() {
			$(".Nsearch").find(' .lenovoWord').show();
			$.ajax({
				url: '/instant/welcome/ajaxProductWordName',
				type: 'POST',
				dataType: 'json',
				data: {
					lenovoWord: lenovoWord
				},
				success: function(res) {
					if (res.data == 1) {
						var html = '';
						$.each(res.info, function(name, value) {
							var search_url = 'http://' + location.hostname + '/search/s?k=' + value.search_text;
							html += "<a href=" + search_url + " >" + value.search_text + "</a>";
						});
						$('.lenovoWord').html(html);
					}
					if (res.data != 1) {
						if (res.data == null) {
							$('.lenovoWord').html(' ');
						} else {
							var html = '';
							var html1 = '';
							var html2 = '';
							var html3 = '';
							$('.lenovoWord').empty();
							$.each(res.data, function(name, value) {
								if (value.search_type == '' || value.search_type == 0) {

									var lenovoWord = $('#searchButton').parent().find('input.text').val();
									var name = value.name;
									var newStr = "<font color='red'>" + lenovoWord + "</font>";
									var newlenovoWord = name.replace(lenovoWord, newStr);
									html1 += "<a href='/search/s?k=" + $.trim(value.name) + "' >" + newlenovoWord + "</a>";
								}

							});
							html = html1;
							$('.lenovoWord').html(html);
						}
					}
				}
			});
		}, 100)
	});
})

function setcookie(key,value,expire){
    var host = window.location.host;
    host = host.replace('http://','');
    host = host.replace('www','');
    if(!host)host = '.miyabaobei.com';
    document.cookie = key+"="+value +";path=/;domain="+host+";expires="+expire+";";
}
function getcookie(name){
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null){
        return unescape(arr[2]);
    }else{
        return '';
    }
}
var str = location.href;
var re=/from=([\w_\-\.\\\+\%]*)/i;
var rs = str.match(re);
var curUrl = window.location.href;
var from = curUrl.indexOf('from');
var sugs={},sugsArray=[];
var parms = [];
var addons = '';
var origin = curUrl;
var nextUrl = '';
var curTime = Date.parse(new Date())/1000;
var cTime;
var cartCacheTime = 10;
var mouseenterflag = false;

if (curUrl.indexOf('?') > 0) {
    if (curUrl.indexOf('#')>0) {
        sugsArray = curUrl.split('?')[1].split('#')[0].split('&');
        addons =  '#' + curUrl.split('#')[1];
    }else{
        sugsArray = curUrl.split('?')[1].split('&');
    }
    for (var i = 0; i < sugsArray.length; i++) {
        if(sugsArray[i].indexOf("=") != -1){
            var k = sugsArray[i].substr(0,sugsArray[i].indexOf("="));
            var v = sugsArray[i].substr(sugsArray[i].indexOf("=")+1);
            sugs[k] = v;
        }
    };
    origin = curUrl.split('?')[0];
}else if (curUrl.indexOf('#')>0){
    addons =  '#' + curUrl.split('#')[1];
    origin = curUrl.split('#')[0];
}

if(from != -1){
    var date = new Date();

    if (rs && sugs.from != '') {

        var from_type = sugs.from.substr(0,2);
        if(from_type == "2c"){
            var expireDays = 14;
        }else{
            var expireDays = 1;
        }
        date.setTime(date.getTime()+expireDays*24*3600*1000);

        setcookie("sitefrom", sugs.from, date.toGMTString());


        //
        var webunion_stfrom = ['duomai', 'yiqifa', 'cn360', 'linktech', 'chanet', 'chanetwap', 'zhituicps', 'weiyicps', '1c00220000034200131054f19455ceb0a', 'shande', '1c0022310003a4001c94551153736ca04', '547bd910145f3', '3c00228000042a003fbb553daa3592fc2', '2c0012400003ce001cbf5523ab1fcacbe'];

        if(sugs.from == '2c0012400003ce001cbf5523ab1fcacbe') {
            sugs.wu_source = 'bdmy';
            sugs.wu_channel = 'cps';
            sugs.wu_cid = '';

            sugs.wu_wi = '';
            if(sugs.baidu_token != '' && typeof(sugs.baidu_token) != 'undefined'){
                sugs.wu_wi = sugs.baidu_token;
            }
        }

        if(sugs.from && webunion_stfrom.indexOf(sugs.from) != -1){
            //广告联盟的 sugs.from 来源, 需要记录跳转信息
            //source 数据来源, channel 推广渠道, cid 活动id, wi 反馈标签
            var date = new Date();
            var expireDays = 1;
            date.setTime(date.setTime(date.getTime()+expireDays*24*3600*1000));

            var myreg = /^[a-zA-Z0-9\_\=\^\-\|]+$/;//console.log(sugs);
            // wu  ==  web_union

            if(sugs.wu_source != '' && typeof(sugs.wu_source) != 'undefined' && myreg.test(sugs.wu_source)){
                setcookie("web_union_source", sugs.wu_source, date.toGMTString());
            }

            if(sugs.wu_channel != '' && typeof(sugs.wu_channel) != 'undefined' && myreg.test(sugs.wu_channel)){
                setcookie("web_union_channel", sugs.wu_channel, date.toGMTString());
            }

            if(sugs.wu_cid != '' && typeof(sugs.wu_cid) != 'undefined' && myreg.test(sugs.wu_cid)){
                setcookie("web_union_cid", sugs.wu_cid, date.toGMTString());
            }

            if(sugs.wu_wi != '' && typeof(sugs.wu_wi) != 'undefined' && myreg.test(sugs.wu_wi)){
                setcookie("web_union_wi", sugs.wu_wi, date.toGMTString());
            }

            if(sugs.union_uid != '' && typeof(sugs.union_uid) != 'undefined' && myreg.test(sugs.union_uid)){
                setcookie("union_uid", sugs.union_uid, date.toGMTString());
            }

            if(sugs.union_planid != '' && typeof(sugs.union_planid) != 'undefined' && myreg.test(sugs.union_planid)){
                setcookie("union_planid", sugs.union_planid, date.toGMTString());
            }
        }



    }
    delete sugs['from'];

    for ( i in sugs ){
        nextUrl += '&' + i + '=' + sugs[i];
    }
    if (nextUrl.length>0) {
        nextUrl = '?' + nextUrl.substr(1) ;
    }else{
        nextUrl = origin;
    }

    if (addons != '') {
        nextUrl = nextUrl + addons;
    }

    // window.location.href = nextUrl;

} else {
    //获取上一个URL.
    var last_url = document.referrer;
    if(last_url !=  ''){
        var urlReg = /[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?/;
        var url = urlReg.exec(last_url);
        var domain = url[0];
        //获取请求url的请求子串.
        var keyval = last_url.substr(last_url.indexOf('?')+1,last_url.length);

        //split将字符串根据指定字符串转换成数组.
        var arr = keyval.split('&');

        var miyauuid = getcookie('miyauuid');
        var sitefrom = getcookie('sitefrom');
        var siteforms = ['2c009307000452003fe3557fb8185917d','2c009309000453003fe4557fbbe1d65f8','2c009310000454003fe5557fbc3331bb2','2c009311000455003fe6557fbc8340b5a','2c009312000456003fe7557fbd2534d53','2c009313000457003fe8557fbd9b32e30'];
        var domain_names = ['www.baidu.com','m.baidu.com','www.haosou.com','m.haosou.com','www.sogou.com','m.sogou.com','wap.sogou.com','cn.bing.com','m.bing.com','www.bing.com','www.google.com','m.sm.cn'];

        var dataInfo = [];

        for(var i=0;i<arr.length;i++){
            var splitInfo = arr[i].split("=");
            var key = splitInfo[0];
            var val = splitInfo[1];k
            dataInfo[key] = val;
        }

        if(domain_names.indexOf(domain) != -1){
            if(siteforms.indexOf(sitefrom) != -1 || sitefrom == '') {
                var searchWord = '';
                var cookieval = '';
                var never = new Date();
                never.setTime(never.getTime()+3600*24*14*1000);
                switch(domain){
                    case 'www.baidu.com':
                        cookieval = '2c009307000452003fe3557fb8185917d';
                        searchWord = dataInfo['wd'];
                        break;
                    case 'm.baidu.com':
                        cookieval = '2c009307000452003fe3557fb8185917d';
                        searchWord = dataInfo['word'];
                        break;
                    case 'www.haosou.com':
                        cookieval = '2c009309000453003fe4557fbbe1d65f8';
                        searchWord = dataInfo['q'];
                        break;
                    case 'm.haosou.com':
                        cookieval = '2c009309000453003fe4557fbbe1d65f8';
                        searchWord = dataInfo['q'];
                        break;
                    case 'www.sogou.com':
                        cookieval = '2c009310000454003fe5557fbc3331bb2';
                        searchWord = dataInfo['query'];
                        break;
                    case 'm.sogou.com':
                        cookieval = '2c009310000454003fe5557fbc3331bb2';
                        searchWord = dataInfo['keyword'];
                        break;
                    case 'wap.sogou.com':
                        cookieval = '2c009310000454003fe5557fbc3331bb2';
                        searchWord = dataInfo['keyword'];
                        break;
                    case 'cn.bing.com':
                        cookieval = '2c009311000455003fe6557fbc8340b5a';
                        searchWord = dataInfo['q'];
                        break;
                    case 'www.google.com':
                        cookieval = '2c009312000456003fe7557fbd2534d53';
                        searchWord = dataInfo['q'];
                        break;
                    case 'sm.cn':
                        cookieval = '2c009313000457003fe8557fbd9b32e30';
                        searchWord = dataInfo['q'];
                        break;
                    default:
                        break;
                }

                setcookie('sitefrom',cookieval ,never.toGMTString());
            }

        }

    }

}

$('#cart_num_box').live({
    mouseenter:function() {
        $(this).addClass('cur');

        cTime = Date.parse(new Date())/1000;
        if(cTime - curTime < cartCacheTime && mouseenterflag) {
            return false;
        }
        mouseenterflag = true;
        ajaxReq();
    },
    mouseleave:function() {
        $(this).removeClass('cur');
    }
});

$('.nblock').live({
    mouseenter:function() {
        $(this).addClass('current');
    },
    mouseleave:function() {
        $(this).removeClass('current');
    }
});

$('.dele').live('click',function() {
    var _this = $(this);
    $.ajax({
        url:'/instant/cart/removeCartItem',
        type:"POST",
        data:'row_id=' + _this.attr('row_id'),
        cache:false,
        dataType: 'json',
        success:function(data){
            $(this).parent().parent('.nblock').remove();
            genHtml(data);
            if (data != null && typeof(data.row_id) != "undefined") {
                $("#cart_num").text(data.total_num);
                $("#rightFunctionCartNum").text(data.total_num);
            }else{
                $("#cart_num").text('0');
                $("#rightFunctionCartNum").text('0');
            };
            //_numCar();
        }
    });

});

function logininfo () {
    $.ajax({
        url: "/login/info?r="+Math.random(),
        type:'POST',
        context: document.body,
        dataType:'json',
        success: function(obj){
            if (obj.cart_num>0){
                $("#cart_num").text(obj.cart_num);
                $("#rightFunctionCartNum").text(obj.cart_num);
            }
            var islogin =  obj.is_login;
            if (islogin==1) {
                var username = obj.username;
                if (username.length>8) {
                    username = username.substr(0,15)+"..";
                }
                $('#logined_username').text(username);
                $("#loginedBox").show()
                $('#unloginBox').hide()
                if(obj.cell_phone) {
                    numphone = obj.cell_phone;
                }
                if(obj.synlogin) {
                    $("#loginedBox").append(obj.synlogin);
                }
            }else{
                $('#unloginBox').show()
                $("#loginedBox").hide()
            }
        }
    });
}

ajaxReq =function(){
    $.ajax({
        url:'/instant/cart/getCartContents',
        type:'POST',
        dataType:'json',
        success:function(data){
            if (typeof(data.row_id) != "undefined") {
                genHtml(data);
            }else{
                $('#shop_cart').empty().append('<div class="empty">购物车还没有商品，快去选购吧！</div>');
                $("#cart_num").text('0');
                $("#rightFunctionCartNum").text('0');
            };
            curTime = Date.parse(new Date())/1000;
        },
        error:function(){
            $('.NoProducts').empty().text('<div class="loading">载入购物车失败，请手动<a href="#" id="reflash">刷新</a></div>').fadeOut(400);
        }
    });
};
//genHtml 创建购物车内容
genHtml=function(data){
    if (typeof(data.row_id) != "undefined") {
        var	$html = '<div class="ntit">最近加入的商品</div>';
        for (var i = 0; i < data.row_id.length; i++) {
            var $url = '/item-'+data.sku[i]+'.html';
            var newSize = "";
            if (data.size[i] != "SINGLE") {
                newSize = data.size[i];
            }
            $html += '<div class="nblock">';
            $html += '<div class="right ver"> <strong class="pink">¥'+data.cost[i]+'</strong>x'+data.num[i]+ '<br/>';
            $html += '<a href="javascript:void(0)" class="dele" row_id="'+data.row_id[i]+'">删除</a> </div>';
            $html += '<div class="left">';
            $html += '<div><a href="'+$url+'" target="_blank"><img src="'+data.img[i]+'" height="50" width="50" alt="'+data.name[i]+'"/></a></div>';
            $html += '<a href="'+$url+'" target="_blank">'+data.name[i]+'</a></div>';
            $html += '</div>';
        };

        $html +='<div class="checkOut">';
        $html +='<div> 共 <span class="pink ver">'+data.total_num+'</span> 件商品　共计<span class="pink ver f16">￥</span><span class="pink ver f20">'+data.total_cost+'</span> </div>';
        $html +='<a href="/cart" class="btn">去购物车结算</a> </div>';
        $('#shop_cart').empty().append($html);
    }else{
        $('#shop_cart').empty().append('<div class="empty">购物车还没有商品，快去选购吧！</div>');
        cartEmptyFlag = setTimeout(function(){
            $('#cart_num_box').trigger('mouseleave');
        },1000);
    };
    $("#cart_num").text(data.total_num);
    $("#rightFunctionCartNum").text(data.total_num);
}


function getHost() {
	var host = window.location.host;
	if(host.indexOf('http://') == -1)host = 'http://' + host;
	return host;
}

function replace_domain(eles) {
	var COM_DOMAIN = getHost();
	var DOMAIN1 = 'http://www.miyabaobei.com';
	var DOMAIN2 = 'http://www.mia.com';
	var REPLACE_DOMAIN = DOMAIN1 == COM_DOMAIN ? DOMAIN2 : DOMAIN1;
	if(COM_DOMAIN != REPLACE_DOMAIN){
		$(eles).find('a[href^="'+REPLACE_DOMAIN+'/"]').each(function(){
			var ts = $(this);
			ts.attr('href', ts.attr('href').replace(REPLACE_DOMAIN,COM_DOMAIN));
		});
	}	
}

