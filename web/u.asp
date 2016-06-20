<%@LANGUAGE="VBSCRIPT" CODEPAGE="65001"%>
<%
Response.Buffer = true
Response.Expires = -1
Dim OtT(3,15,1)
dim isobj,VerObj,TestObj
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ASP探针-UPUPW环境集成包KANGLE专用版</title>
<meta name="keywords" content="ASP探针,ASP组件,UPUPW,kangle,AspJpeg,AspUpload,jmail" />
<meta name="description" content="UPUPW环境集成包KANGLE专用版ASP探针ASP组件检测." />
<meta name="author" content="UPUPW" />
<meta name="reply-to" content="webmaster@upupw.net" />
<meta name="copyright" content="UPUPW Team" />
<style type="text/css">
<!--
*{ margin:0px; padding:0px;}
body {background-color:#ffffff;color:#000000;margin:0px;font-family:"微软雅黑", Tahoma, sans-serif;}
input {text-align:center;}
a:link {color: #ff0000; text-decoration: none;}
a:visited {color: #ff0000; text-decoration: none;}
a:active {color: #aa0000; text-decoration: none;}
a:hover {color: #aa0000; text-decoration: none;}
table {border-collapse:collapse; margin-bottom:10px; clear:both;}
.tablex1{display:inline;float:left; width:500px;}
.tablex2{display:inline;float:right; width:500px; clear:right;}
.info tr td {padding:2px 5px 2px 5px;vertical-align:center;height:30px; border:1px #FFFFFF solid;}
.info th {font-weight:bold;border:1px #FFFFFF solid;height:24px;padding:3px 10px 3px 10px;background-color:#96ce6a;}
.inp tr td {padding:3px 0px 3px 0px;vertical-align:center;text-align:center;height:30px; border:3px #FFFFFF solid;}
.head1 {background-color:#3f8805;width:100%;font-size:36px;color:#ffffff;padding-top:20px; text-align:center; font-family: Georgia, "Times New Roman", Times, serif; font-weight:bold;}
.head2 {background-color:#96ce6a; width: 100%; font-size: 18px; height:18px;color: #ffffff;border-top: #ffffff 2px solid;}
.el {text-align:left;background-color:#dbeec6;}
.er {text-align:right;background-color:#dbeec6;}
.ec {text-align:center;background-color:#dbeec6; font-weight:bold;}
.fl {text-align:left;background-color:#efefef;color:#505050;}
.fr {text-align:right;background-color:#efefef;color:#505050;}
.fc {text-align:center;background-color:#efefef;color:#505050;}
a.arrow {font-family:webdings,sans-serif;font-size:10px;}
a.arrow:hover {color:#ff0000;text-decoration:none;}
-->
</style>
</head>
<body>
<div class="head1">UPUPW ASP 探针</div>
<div class="head2"></div>
<div style="margin:0 auto;width:1001px;overflow:hidden;">
<br />

<table class="info tablex1">
  <tr>
    <th colspan="2">服务器信息</th>
  </tr>
  <tr>
    <td width="120" class="er">服务器域名</td>
    <td width="380" class="fl"><%=Request.ServerVariables("SERVER_NAME")%></td>
  </tr>
  <tr>
    <td class="er">服务器端口</td>
    <td class="fl"><%=Request.ServerVariables("LOCAL_ADDR")%>:<%=Request.ServerVariables("SERVER_PORT")%></td>
  </tr>
  <tr>
    <td class="er">ASP运行环境</td>
    <td class="fl"><%=Request.ServerVariables("SERVER_SOFTWARE")%></td>
  </tr>
  <tr>
    <td class="er" style="color: #ff0000;">ASP脚本引擎</td>
    <td class="fl"><%=ScriptEngine & "/"& ScriptEngineMajorVersion &"."&ScriptEngineMinorVersion&"."& ScriptEngineBuildVersion %> , <%="JScript/" & getjver()%></td>
  </tr>
  <tr>
    <td class="er">脚本超时时间</td>
    <td class="fl"><%=Server.ScriptTimeout%> 秒</td>
  </tr>
  <tr>
    <td class="er">当前网站目录</td>
    <td class="fl"><%=Request.ServerVariables("PATH_TRANSLATED")%></td>
  </tr>
<%
tnow = now():oknow = cstr(tnow)
if oknow <> year(tnow) & "-" & month(tnow) & "-" & day(tnow) & " " & hour(tnow) & ":" & right(FormatNumber(minute(tnow)/100,2),2) & ":" & right(FormatNumber(second(tnow)/100,2),2) then oknow = oknow 
%>
  <tr>
    <td class="er">服务器标准时</td>
    <td class="fl"><%=oknow%></td>
  </tr>
</table>
<SCRIPT language="JScript" runat="server">
function getJVer(){
  return ScriptEngineMajorVersion() +"."+ScriptEngineMinorVersion()+"."+ ScriptEngineBuildVersion();
}
</SCRIPT>
<%
  on error resume next
  OtT(0,0,0) = "JMail.SmtpMail"
  OtT(0,0,1) = "(Dimac JMail邮件收发)"
  OtT(0,1,0) = "CDONTS.NewMail"
  OtT(0,1,1) = "(CDONTS)"
  OtT(0,2,0) = "CDO.Message"
  OtT(0,2,1) = "(CDOSYS)"
  OtT(0,3,0) = "Persits.MailSender"
  OtT(0,3,1) = "(ASPemail发信)"
  OtT(0,4,0) = "SMTPsvg.Mailer"
  OtT(0,4,1) = "(ASPmail发信)"
  OtT(0,5,0) = "DkQmail.Qmail"
  OtT(0,5,1) = "(dkQmail发信)"
  OtT(0,6,0) = "SmtpMail.SmtpMail.1"
  OtT(0,6,1) = "(SmtpMail发信)"
  
  OtT(1,0,0) = "MSWC.AdRotator"
  OtT(1,1,0) = "MSWC.BrowserType"
  OtT(1,2,0) = "MSWC.NextLink"
  OtT(1,3,0) = "MSWC.Tools"
  OtT(1,4,0) = "MSWC.Status"
  OtT(1,5,0) = "MSWC.Counters"
  OtT(1,6,0) = "IISSample.ContentRotator"
  OtT(1,7,0) = "IISSample.PageCounter"
  OtT(1,8,0) = "MSWC.PermissionChecker"
  OtT(1,9,0) = "Microsoft.XMLHTTP"
  OtT(1,9,1) = "(Http系统组件)"
  OtT(1,10,0) = "WScript.Shell"
  OtT(1,10,1) = "(Shell组件)"
  OtT(1,11,0) = "Scripting.FileSystemObject"
  OtT(1,11,1) = "(FSO)"
  OtT(1,12,0) = "Adodb.Connection"
  OtT(1,12,1) = "(ADO数据对象)"
  OtT(1,13,0) = "Adodb.Stream"
  OtT(1,13,1) = "(ADO数据流无组件上传)"
	
  OtT(2,0,0) = "SoftArtisans.FileUp"
  OtT(2,0,1) = "(文件上传)"
  OtT(2,1,0) = "SoftArtisans.FileManager"
  OtT(2,1,1) = "(文件管理)"
  OtT(2,2,0) = "Ironsoft.UpLoad"
  OtT(2,2,1) = "(文件上传)"
  OtT(2,3,0) = "LyfUpload.UploadFile"
  OtT(2,3,1) = "(文件上传)"
  OtT(2,4,0) = "Persits.Upload.1"
  OtT(2,4,1) = "(文件上传)"
  OtT(2,5,0) = "w3.upload"
  OtT(2,5,1) = "(文件上传)"
	
  OtT(3,0,0) = "SoftArtisans.ImageGen"
  OtT(3,0,1) = "(图像读写)"
  'OtT(3,1,0) = "W3Image.Image"
  'OtT(3,1,1) = "(图像读写)"
  OtT(3,1,0) = "Persits.Jpeg"
  OtT(3,1,1) = "(ASPJpeg)"
  OtT(3,2,0) = "XY.Graphics"
  OtT(3,2,1) = "(图像/图表处理)"
  OtT(3,3,0) = "Ironsoft.DrawPic"
  OtT(3,3,1) = "(图像/图形处理)"
  OtT(3,4,0) = "Ironsoft.FlashCapture"
  OtT(3,4,1) = "(FLASH截图)"
  OtT(3,5,0) = "dyy.zipsvr"
  OtT(3,5,1) = "(文件压缩解压组件)"
  'OtT(3,7,0) = "hin2.com_iis"
  'OtT(3,7,1) = "(服务管理组件)"
  OtT(3,6,0) = "Socket.TCP"
  OtT(3,6,1) = "(Socket组件)"	
%>
<%
function DetectcIsReady(trd)
  Select Case trd
    case true: DetectcIsReady="<font color='green'><b>Yes</b></font>"
    case false: DetectcIsReady="<font color='red'><b>No</b></font>"
  End Select
end function
%>
<%
sub Detect(strObj)
  on error resume next
  IsObj=false
  VerObj=""
  set TestObj=server.CreateObject (strObj)
  If -2147221005 <> Err then
    IsObj = True
    VerObj = TestObj.version
    if VerObj="" or isnull(VerObj) then VerObj=TestObj.about
  end if
  set TestObj=nothing
End sub
%>
<table class="info tablex2">
  <tr>
    <th colspan="2">ASP邮件处理组件</th>
  </tr>
  <%
  k=0
  for i=0 to 6
    call Detect(OtT(k,i,0))
  %>
  <tr>
  <td width="310" class="er"><%=OtT(k,i,0) & OtT(k,i,1)%></td>
  <td width="190" class="fl"><%=DetectcIsReady(isobj) & " " & left(VerObj,10)%></td>
  </tr>
  <%next%>
</table>
<table class="info tablex1">
  <tr>
    <th colspan="2">服务器系统自带组件</th>
  </tr>
  <%
  k=1
  for i=0 to 13
    call Detect(OtT(k,i,0))
  %>
  <tr>
  <td width="310" class="er"><%=OtT(k,i,0) & OtT(k,i,1)%></td>
  <td width="190" class="fl"><%=DetectcIsReady(isobj) & " " & left(VerObj,10)%></td>
  </tr>
  <%next%>
</table>
<table class="info tablex2">
  <tr>
    <th colspan="2">ASP上传管理组件</th>
  </tr>
  <%
  k=2
  for i=0 to 5
    call Detect(OtT(k,i,0))
  %>
  <tr>
  <td width="310" class="er"><%=OtT(k,i,0) & OtT(k,i,1)%></td>
  <td width="190" class="fl"><%=DetectcIsReady(isobj) & " " & left(VerObj,10)%></td>
  </tr>
  <%next%>
    <tr>
    <th colspan="2" height="30px">ASP扩展组件</th>
  </tr>
  <%
  k=3
  for i=0 to 6
    call Detect(OtT(k,i,0))
  %>
  <tr>
  <td width="310" class="er"><%=OtT(k,i,0) & OtT(k,i,1)%></td>
  <td width="190" class="fl"><%=DetectcIsReady(isobj) & " " & left(VerObj,10)%></td>
  </tr>
  <%next%>
</table>
 <hr style="width:100%;color:#cdcdcd;clear:both;" noshade="noshade" size="1" />
 <p style="color:#505050;font-size:14px;text-align:center;clear:both; margin-bottom:20px;">&copy;2014 <a href="http://www.upupw.net">WWW.UPUPW.NET</a> 版权所有</p>
</div>
</body>
</html>
