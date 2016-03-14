function topslide(a){
    this.target=a.target;
    this.cell=$(this.target+" .cell");
    this.alli=$(this.target+" .slideNum i");
    this.delay=a.delay||300;
    this.slideDelay=a.slideDelay||3000;
    this.slideTrans=a.slideTrans||3000;
    this.controller=a.controller||false;
    this.controllerFix=a.controllerFix||false;
    this.effect=a.effect||"blink";
    this.timeCycle=null;
    this.timeMsi=null
}
topslide.prototype.init=function(){
    var a=this;
    if(this.controller){
        $('<div class="arNav"><div class="w1004"></div></div>').appendTo(this.target);
        $('<a href="#" class="leftAr" ></a><a href="#" class="rightAr" ></a>').appendTo($(this.target+" .arNav .w1004"));
        $(this.target).hover(function(){
            $(a.target+" .leftAr").fadeIn();
            $(a.target+" .rightAr").fadeIn()
        },function(){
            $(a.target+" .leftAr").fadeOut();
            $(a.target+" .rightAr").fadeOut()});
        $(this.target+" .leftAr").click(function(b){
            b.preventDefault();
            clearInterval(a.timeCycle);
            a.showCell(a.curIndex()<1?a.curIndex()+$(".slideNum i").length-1:
            a.curIndex()-1);
            a.cycleSlide()});
        $(this.target+" .rightAr").click(function(b){
            b.preventDefault();
            clearInterval(a.timeCycle);
            a.showCell(a.curIndex()>$(".slideNum i").length-2?0:a.curIndex()+1);
            a.cycleSlide()});
        $(window).resize(function(){
            a.showcontroll()
        })
    }
    this.alli.hover(function(){clearInterval(a.timeCycle);
        var c=$(this);
        var b=c.prevAll("i").length;
        if(!c.hasClass("cur")){
            a.timeMsi=setTimeout(function(){
                a.showCell(b)},a.delay)}},
        function(){
            a.cycleSlide();
            clearTimeout(a.timeMsi)
        });
    this.cell.hover(function(){
        a.cell.stop(true,true);
        clearInterval(a.timeCycle);
        var c=$(this);
        var b=c.prevAll(".cell").length;
        if(!c.hasClass("cur")){
            a.timeMsi=setTimeout(function(){
                a.showCell(b)},a.delay)}},function(){
        a.cycleSlide();
        clearTimeout(a.timeMsi)});
    a.showcontroll();a.cycleSlide()};
topslide.prototype.showCell=function(c){
    var f=this;
    var g=f.alli.eq(c);var h=f.cell.eq(c);
    if(f.cell.filter(".easing").length>0){
        var d=f.cell.filter(".easing")}
    else{var d=f.cell.filter(".cur")}h.find("img").each(function(){if($(this).attr("original")){
        $(this).attr("src",$(this).attr("original"));
        $(this).removeAttr("original")}});
    if(h.find(".prom").length>0){h.find(".prom").each(function(){
        if($(this).attr("original")){
            $(this).css({"background-image":"url("+$(this).attr("original")+")"});
            $(this).removeAttr("original")}})}
    f.cell.removeClass("cur").stop().clearQueue().removeClass("easing").removeAttr("style");
    f.alli.removeClass("cur");
    f.alli.each(function(){if($(this).hasClass("new")){$(this).removeClass("newcur")}});
    g.addClass("cur");if(g.hasClass("new")){g.addClass("newcur")}
    switch(f.effect){case"blink":f.cell.removeClass("cur").removeAttr("style");
        d.hide();h.show();break;case"fade":d.css({display:"block"}).animate({opacity:0},f.slideTrans,function(){
        f.cell.removeClass("easing").removeAttr("style")});
        h.addClass("easing");
        h.css({display:"block",opacity:0}).animate({opacity:1},f.slideTrans,function(){
            h.addClass("cur").removeClass("easing").removeAttr("style")});
        break;case"slide":var b=f.cell.parent();
        var e=f.cell.width();
        var a=f.cell.length()*e;b.css({width:a});b.animate({left:e*c});
        break;default:d.hide();
        h.show()}
    return this};
topslide.prototype.curIndex=function(){
    return $(this.target+" .slideNum .cur").prevAll("i").length
};
topslide.prototype.cycleSlide=function(){
    var b=this;
    setCycle=true;
    var a;
    b.timeCycle=setInterval(function(){
        if(b.curIndex()<(b.alli.length-1)){
            a=b.curIndex()+1}else{a=0}b.showCell(a)},b.slideDelay);
    return this
};
topslide.prototype.showcontroll=function(){
    if(!this.controllerFix){if($(window).width()>1680){
        $(this.target+" .leftAr").show();
        $(this.target+" .rightAr").show()}
    else{$(this.target+" .leftAr").hide();
        $(this.target+" .rightAr").hide()}}
    return this
};

$(function(){
    var t=new topslide({
        target:"#mainSlide",slideDelay:4000,slideTrans:1000,controller:true,controllerFix:true,effect:"fade"
    });
    t.init();
});