<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo base_url() ?>" />
<title>Monitoring Log</title>
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.10.0.custom.min.css" />
<link rel="stylesheet" type="text/css" href="css/theme.css" />
<link rel="stylesheet" type="text/css" href="css/theme1.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
 
<script type="text/javascript" src="js/jquery-1.9.0.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.10.0.custom.js"></script>  
<script type="text/javascript" src="js/common.js"></script>  
 
 
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->

<!--[if IE 7]>
<style>
#topmenu{
	margin-top:26px;
}
</style>
<![endif]-->

<!--[if IE 8]>
<style>
#topmenu{
	margin-top:34px;
}
</style>
<![endif]-->

<!--[if IE 9]>
<style>
#topmenu{
	margin-top:35px;
}
</style>
<![endif]-->
</head>

<body>
	<div id="container">
    	<div id="header">
        	<h2>Monitoring Log <?php echo @(' <em style="font-size:11px;"> - '.$this->user_fullname).'</em>'; ?></h2>
			
				<?php if($this->session->userdata('islogin')): ?>
				<div id="topmenu">
					<?php $current = $this->uri->segment(1); ?>
					
					<ul>
						<li class="<?php echo ($current == 'overview' OR $current == 'recommendationslist')?'current':''; ?>"><a href="overview">Overview</a></li>
						<li class="<?php echo ($current == 'calllog' OR $current == 'calllogedit')?'current':''; ?>"><a href="calllog">Call Log</a></li>
						<li class="<?php echo ($current == 'meeting' OR $current == 'meetingedit')?'current':''; ?>"><a href="meeting">Meeting</a></li> 
						<li class="<?php echo ($current == 'recommendations' OR $current == 'recommendationsedit')?'current':''; ?>"><a href="recommendations">Recommendations</a></li> 
						
						<?php if( $this->user_id == 34 OR $this->user_id == 14 ): ?>
						<li class="<?php echo ($current == 'accounts' OR $current == 'accounts')?'current':''; ?>"><a href="accounts">Accounts</a></li> 
						<?php endif; ?>						
						
						<li class="<?php echo ($current == 'reports')?'current':''; ?>"><a href="logout">Logout</a></li> 
					</ul>
				</div>
				<?php else: ?>
				<div id="topmenu">
					<ul><li>&nbsp;</li></ul>
				</div>
				<?php endif; ?>
      </div>
		<!--<div id="top-panel">
			<div id="panel">
				<ul>
					<li><a href="#" class="report">Sales Report</a></li>
					<li><a href="#" class="report_seo">SEO Report</a></li>
					<li><a href="#" class="search">Search</a></li>
					<li><a href="#" class="feed">RSS Feed</a></li>
				</ul>
			</div>
		</div>-->
        <div id="wrapper">