$(document).ready(function(){
    $('#backToMobile').click(function(e){
        setwm('mobile');
        var site = $(this).data('domain');
        if(!site)site = '<?php echo MAIN_DOMAIN;?>';
        window.location.href='http://m.'+site+'?device=m_web';
        e.preventDefault();
    }); 
});


function identifyUA() {
    var userAgent = navigator.userAgent.toLowerCase();
    var platform ='';
    if(userAgent == null || userAgent == ''){
        platform = 'web' ; 
    }else{
        if(userAgent.indexOf("android") != -1 ){ 
            platform = 'mobile';
        }else if(userAgent.indexOf("ios") != -1 || userAgent.indexOf("iphone") != -1){ 
            platform = 'mobile';
        }else if(userAgent.indexOf("ipad") != -1) {
            platform = 'web';
        }else if(userAgent.indexOf("windows phone") != -1 ){ 
            platform = 'web';
        }else{
            platform = 'web' ;
        }
    }
    return platform;
}



//function setcookie(key,value,expire){
//	var host = window.location.host;
//	host = host.replace('http://','');
//	host = host.replace('www','');
//	if(!host)host = '.miyabaobei.com';
//    document.cookie = key+"="+value +";path=/;domain="+host+";expires="+expire+";";
//}

//function setwm(tag){
//	if(tag || tag != ''){
//        var expire = new Date()
//        var expireDays = 30;
//        expire.setTime(expire.setTime(expire.getTime()+expireDays*24*3600*1000));
//        setcookie('wom', tag, expire.toGMTString());
//	}
//	return tag;
//}


//function getcookie(name){
//	var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
//	if(arr != null){
//		return unescape(arr[2]);
//	}else{
//		return '';
//	}
//}
//
//function delcookie(name)
//{
//    var exp = new Date();
//    var val=getcookie(name);
//    if(val!='') {
//        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/;domain=.miyabaobei.com';
//    }
//}