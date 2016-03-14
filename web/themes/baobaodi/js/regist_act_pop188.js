//默认弹出层注册送188，用户点击关闭或已经登录不弹出,默认15天有效期过
(function(){
    var pupop = function($btn){
        this.$btn = $btn;
        this.pop = $('<div style="display:none;width:690px; height:430px; left:50%; top:50%; margin:-230px 0 0 -345px; background:url(http://img.miyabaobei.com/d1/p2/2015/11/11/92/42/92429a7feefc2530d9c2907cebba1010.png) no-repeat;position:fixed;z-index:100;"><a style="display:block;width:200px;height:65px;position:absolute;left:352px;bottom:140px;background:url(about:blank)" href="javascript:;" id="regist_ldy_tc"></a><a href="javascript:;" style="display:block;width:52px;height:42px;position:absolute;right:23px;top:0px;background:url(about:blank)" id="close_ldy_tc"></a></div>').appendTo(document.body);
        this.mask = $('<div class="mask" style="display:none;width:100%;height:100%;top:0px;left:0px; position:fixed; filter: Alpha(opacity=40);-moz-opacity: 0.4;opacity:0.4;background:#000000;z-index:99;"></div>').appendTo(document.body);
        this.init();
    }
    pupop.prototype={
        init:function(){
            var that = this;
            var isNewUser = getcookie('username');
            var display = getcookie('display');
            if (!isNewUser && !display) {
                that.show();
            }
            $('#close_ldy_tc').on('click',function(){
                var date = new Date();
                date.setTime(date.getTime()+15*24*3600*1000);
                setcookie("display",'1',date.toGMTString());
                that.hide();
            });
            $('#regist_ldy_tc').on('click',function(){
                var prevhref = window.location.href;
                window.location.href='http://www.mia.com/register?url='+encodeURIComponent(prevhref);
            })
        },
        show:function(){
            this.pop.show();
            this.mask.show();
        },
        hide:function(){
            this.pop.hide();
            this.mask.hide();
        }
    }
    //window.ldy_pupop = pupop;
    new pupop();
})();