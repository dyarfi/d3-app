<!doctype html>
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title></title>
  <style type="text/css">
 	body {
		width: 100%;
		margin: 0;
		padding: 0;
		-webkit-font-smoothing: antialiased;
	}
	@media only screen and (max-width: 600px) {
		table[class="table-row"] {
			float: none !important;
			width: 98% !important;
			padding-left: 20px !important;
			padding-right: 20px !important;
		}
		table[class="table-row-fixed"] {
			float: none !important;
			width: 98% !important;
		}
		table[class="table-col"], table[class="table-col-border"] {
			float: none !important;
			width: 100% !important;
			padding-left: 0 !important;
			padding-right: 0 !important;
			table-layout: fixed;
		}
		td[class="table-col-td"] {
			width: 100% !important;
		}
		table[class="table-col-border"] + table[class="table-col-border"] {
			padding-top: 12px;
			margin-top: 12px;
			border-top: 1px solid #E8E8E8;
		}
		table[class="table-col"] + table[class="table-col"] {
			margin-top: 15px;
		}
		td[class="table-row-td"] {
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		table[class="navbar-row"] , td[class="navbar-row-td"] {
			width: 100% !important;
		}
		img {
			max-width: 100% !important;
			display: inline !important;
		}
		img[class="pull-right"] {
			float: right;
			margin-left: 11px;
            max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		img[class="pull-left"] {
			float: left;
			margin-right: 11px;
			max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		table[class="table-space"], table[class="header-row"] {
			float: none !important;
			width: 98% !important;
		}
		td[class="header-row-td"] {
			width: 100% !important;
		}
	}
	@media only screen and (max-width: 480px) {
		table[class="table-row"] {
			padding-left: 16px !important;
			padding-right: 16px !important;
		}
	}
	@media only screen and (max-width: 320px) {
		table[class="table-row"] {
			padding-left: 12px !important;
			padding-right: 12px !important;
		}
	}
	@media only screen and (max-width: 458px) {
		td[class="table-td-wrap"] {
			width: 100% !important;
		}
	}
  </style>
 </head>
 <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#E4E6E9" height="100%">
      <tbody><tr><td style="background-color:#E4E6E9; min-height: 200px;" width="100%" valign="top" bgcolor="#E4E6E9" align="center">
     <table><tbody><tr><td class="table-td-wrap" width="458" align="center"><table class="table-space" style="height: 18px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#E4E6E9" height="18"><tbody><tr><td class="table-space-td" style="height: 18px; width: 450px; background-color: #e4e6e9;" width="450" valign="middle" bgcolor="#E4E6E9" align="left" height="18">&nbsp;</td></tr></tbody></table>
     <table class="table-space" style="height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" height="8"><tbody><tr><td class="table-space-td" style="height: 8px; width: 450px; background-color: #ffffff;" width="450" valign="middle" bgcolor="#FFFFFF" align="left" height="8">&nbsp;</td></tr></tbody></table>
     <table class="table-row" style="table-layout: fixed; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
       <table class="table-col" style="table-layout: fixed;" width="378" cellspacing="0" cellpadding="0" border="0" align="left"><tbody><tr><td class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" width="378" valign="top" align="left"><a href="{{ route('home') }}"><img src="{{ asset('images/d3.png') }}" width="100%"/></a>
         <table class="header-row" style="table-layout: fixed;" width="378" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="header-row-td" style="font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;" width="378" valign="top" align="left">Thank you for applying application to us</td></tr></tbody></table>
         <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
       <b style="color: #777777;">Your application : </b>
       <br><br>
       Name : {{ $name }}<br>
       Email : {{ $email }}<br>
       Phone : {{ $phone }}<br>
       Subject : {{ $subject }}<br>
       Service : {{ $about }}<br>
       Message : {{ $description }}<br><br>
       <b style="color: #777777;">We will respond your application as soon as possible.</b>
     </div>
       </td></tr></tbody></table>
     </td></tr></tbody></table>
     <table class="table-space" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" height="12"><tbody><tr><td class="table-space-td" style="height: 12px; width: 450px; background-color: #ffffff;" width="450" valign="middle" bgcolor="#FFFFFF" align="left" height="12">&nbsp;</td></tr></tbody></table>
     <table class="table-space" style="height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" height="12"><tbody><tr><td class="table-space-td" style="height: 12px; width: 450px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;" width="450" valign="middle" bgcolor="#FFFFFF" align="center" height="12">&nbsp;<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#E8E8E8" height="0"><tbody><tr><td style="height: 1px; font-size:0;" width="100%" valign="top" bgcolor="#E8E8E8" align="left" height="1">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
     <table class="table-space" style="height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" height="16"><tbody><tr><td class="table-space-td" style="height: 16px; width: 450px; background-color: #ffffff;" width="450" valign="middle" bgcolor="#FFFFFF" align="left" height="16">&nbsp;</td></tr></tbody></table>
     <table class="table-row" style="table-layout: fixed; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
       <table class="table-col" style="table-layout: fixed;" width="378" cellspacing="0" cellpadding="0" border="0" align="left"><tbody><tr><td class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;" width="378" valign="top" align="left">
         <div style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;">
           <!--a href="#" style="color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;">&nbsp; Confirm &nbsp;</a-->
         </div>
         <table class="table-space" style="height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;" width="378" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" height="16"><tbody><tr><td class="table-space-td" style="height: 16px; width: 378px; background-color: #ffffff;" width="378" valign="middle" bgcolor="#FFFFFF" align="left" height="16">&nbsp;</td></tr></tbody></table>
       </td></tr></tbody></table>
     </td></tr></tbody></table>
     <table class="table-space" style="height: 6px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" height="6"><tbody><tr><td class="table-space-td" style="height: 6px; width: 450px; background-color: #ffffff;" width="450" valign="middle" bgcolor="#FFFFFF" align="left" height="6">&nbsp;</td></tr></tbody></table>
     <table class="table-row-fixed" style="table-layout: fixed; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF"><tbody><tr><td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;" valign="top" align="left">
       <table class="table-col" style="table-layout: fixed;" width="448" cellspacing="0" cellpadding="0" border="0" align="left"><tbody><tr><td class="table-col-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" width="448" valign="top" align="left">
         <table style="table-layout: fixed;" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;" width="100%" valign="top" bgcolor="#f5f5f5" align="center">
           <a href="#" style="color: #428bca; text-decoration: none; background-color: transparent;">{{ trans('label.copyright') }} 2017</a>
           <br>
           <!--a href="#" style="color: #478fca; text-decoration: none; background-color: transparent;">twitter</a>
           .
           <a href="#" style="color: #5b7a91; text-decoration: none; background-color: transparent;">facebook</a>
           .
           <a href="#" style="color: #dd5a43; text-decoration: none; background-color: transparent;">google+</a-->
         </td></tr></tbody></table>
       </td></tr></tbody></table>
     </td></tr></tbody></table>
     <table class="table-space" style="height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" height="1"><tbody><tr><td class="table-space-td" style="height: 1px; width: 450px; background-color: #ffffff;" width="450" valign="middle" bgcolor="#FFFFFF" align="left" height="1">&nbsp;</td></tr></tbody></table>
     <table class="table-space" style="height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;" width="450" cellspacing="0" cellpadding="0" border="0" bgcolor="#E4E6E9" height="36"><tbody><tr><td class="table-space-td" style="height: 36px; width: 450px; background-color: #e4e6e9;" width="450" valign="middle" bgcolor="#E4E6E9" align="left" height="36">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>
     </td></tr>
      </tbody></table>
 </body>
 </html>
