$(function(){
    $('[data-toggle="popover"]').popover();
})

function addToFavorite(){
    var a=domainURL, b="???"+bbdMallName;
    document.all?window.external.AddFavorite(a,b):window.sidebar&&window.sidebar.addPanel?window.sidebar.addPanel(b,a,""):alert("\u5bf9\u4e0d\u8d77\uff0c\u60a8\u7684\u6d4f\u89c8\u5668\u4e0d\u652f\u6301\u6b64\u64cd\u4f5c!\n\u8bf7\u60a8\u4f7f\u7528\u83dc\u5355\u680f\u6216Ctrl+D\u6536\u85cf\u672c\u7ad9\u3002"),createCookie("_fv","1",30,"/;domain="+domainURL)
}

/*************************************用户注册*****************************************/
//刷新验证码
function getVerify() {
    $('.verifyImg').attr('src',Think.U('Users/getVerify','rnd='+Math.random()));
}

var time = 0;
var isSend = false;
var isUse = false;
function getVerifyCode(){

    if($.trim($("#loginName").val())==''){
        WST.msg('请输入手机号码!', {icon: 5});
        return;
    }
    if(isSend )return;
    isSend = true;

    var params = {};
    params.userPhone = $.trim($("#loginName").val());
    $.post(Think.U('Users/getPhoneVerifyCode'),params,function(data,textStatus){
        var json = WST.toJson(data);
        if(json.status==-4){
            WST.msg('手机号码格式错误!', {icon: 5});
            time = 0;
            isSend = false;
        }else if(json.status==-3){
            WST.msg('该手机号码已注册!', {icon: 5});
            time = 0;
            isSend = false;
        }else if(json.status==-2){
            WST.msg('您的手机已超过每日最大短信验证数!', {icon: 5});
            time = 0;
            isSend = false;
        }else if(json.status==-1){
            WST.msg('短信發送失敗!', {icon: 5});
            time = 0;
            isSend = false;
        }else if(json.status==1){
            time = 120;
            $('#timeTips').css('width','100px');
            $('#timeTips').html('获取验证码(120)');
            var task = setInterval(function(){
                time--;
                $('#timeTips').html('获取验证码('+time+")");
                if(time==0){
                    isSend = false;
                    clearInterval(task);
                    $('#timeTips').html("重新获取验证码");
                }
            },1000);
        }
    });
}

function regist(){

    if($("#nameType").val()==3){
        if($.trim($("#mobileCode").val())==""){
            WST.msg('请输入验证码!', {icon: 5});
            $("#mobileCode").focus();
            return;
        }
    }else{

        if($.trim($("#authcode").val())==""){
            WST.msg('请输入验证码!', {icon: 5});
            $("#mobileCode").focus();
            return;
        }
    }

    if(!document.getElementById("protocol").checked){
        WST.msg('必须同意使用协议才允许注册!', {icon: 5});
        return;
    }
    var params = {};
    params.loginName = $.trim($('#loginName').val());
    params.loginPwd = $.trim($('#loginPwd').val());
    params.reUserPwd = $.trim($('#reUserPwd').val());
    params.userEmail = $.trim($('#userEmail').val());

    params.userTaste = $('#userTaste').val();
    //params.userQQ = $.trim($('#userQQ').val());
    params.userPhone = $.trim($('#userPhone').val());
    params.mobileCode = $.trim($('#mobileCode').val());

    params.verify = $.trim($('#authcode').val());
    params.nameType = $("#nameType").val();
    params.protocol = document.getElementById("protocol").checked?1:0;

    $.post(Think.U('Home/Users/toRegist'),params,function(data,textStatus){
        var json = WST.toJson(data);
        if(json.status>0){
            WST.msg('注册成功，正在跳转登录!', {icon: 6}, function(){
                location.href=domainURL +'/index.php';
            });
        }else if(json.status==-2){
            WST.msg('用户名已存在!', {icon: 5});
        }else if(json.status==-3){
            WST.msg('两次输入密码不一致!', {icon: 5});
        }else if(json.status==-4){
            WST.msg('验证码错误!', {icon: 5});
        }else if(json.status==-6){
            WST.msg('必须同意使用协议才允许注册!', {icon: 5});
        }else if(json.status==-5){
            WST.msg('验证码已超过有效期!', {icon: 5});
        }else if(json.status==-7){
            WST.msg('注册信息不完整!', {icon: 5});
        }else{
            WST.msg('注册失败!', {icon: 5});
        }
        getVerify();
    });
}

function changeName(){
    var params = {};
    params.loginName = $.trim($('#loginName').val());

    if(params.loginName!="" && params.loginName!="邮箱/用户名/手机号"){
        jQuery.post(Think.U('Users/checkLoginName') ,params,function(rsp) {
            var json = WST.toJson(rsp);
            if( json.status == "1" ) {
                jQuery("#loginNameTip").removeClass();
                jQuery("#loginNameTip").addClass("onCorrect");
                jQuery("#loginNameTip").html("输入正确");
                return true;
            } else {
                jQuery("#loginNameTip").removeClass();
                jQuery("#loginNameTip").addClass("onError");
                jQuery("#loginNameTip").html("账号已存在");
                return false;
            }
        });
    }
}

/*************************************用户注册END*****************************************/