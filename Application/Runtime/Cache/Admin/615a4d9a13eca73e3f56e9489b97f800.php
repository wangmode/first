<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>管理中心</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- bootstrap -->
    <link href="/first/Public/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/first/Public/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="/first/Public/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="/first/Public/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="/first/Public/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="/first/Public/css/icons.css" />



    <!-- libraries -->
    <link href="/first/Public/css/lib/select2.css" type="text/css" rel="stylesheet" />
    <link href="/first/Public/css/lib/bootstrap-wysihtml5.css" type="text/css" rel="stylesheet" />
    <link href="/first/Public/css/lib/uniform.default.css" type="text/css" rel="stylesheet" />

    <link href="/first/Public/css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
    <link href="/first/Public/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />




     <link href="/first/Public/css/more.css" type="text/css" rel="stylesheet" />



    <!-- this page specific styles -->
    <link rel="stylesheet" href="/first/Public/css/compiled/user-list.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/first/Public/css/compiled/form-showcase.css" type="text/css" media="screen" />

		<!-- scripts -->
    <script src="/first/Public/js/wysihtml5-0.3.0.js"></script>
    <script src="/first/Public/js/jquery-latest.js"></script>
    <script src="/first/Public/js/bootstrap.min.js"></script>
    <script src="/first/Public/js/bootstrap-wysihtml5-0.0.2.js"></script>
    <script src="/first/Public/js/bootstrap.datepicker.js"></script>
    <script src="/first/Public/js/jquery.uniform.min.js"></script>
    <script src="/first/Public/js/select2.min.js"></script>
    <script src="/first/Public/js/theme.js"></script>


    <!-- open sans font -->

    <script type="text/javascript">
        $(function () {

            // add uniform plugin styles to html elements
            $("input:checkbox, input:radio").uniform();

            // select2 plugin for select elements
            $(".select2").select2({
                placeholder: "Select a State"
            });

            // datepicker plugin
            $('.datepicker').datepicker().on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });

            // wysihtml5 plugin on textarea
            $(".wysihtml5").wysihtml5({
                "font-styles": false
            });
        });
    </script>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>

    <!-- navbar -->
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <button type="button" class="btn btn-navbar visible-phone" id="menu-toggler">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="brand" href="index.html"><img src="/first/Application/Admin/View/img/logo.png" /></a>

            <ul class="nav pull-right">
                <li class="hidden-phone">
                    <input class="search" type="text" />
                </li>
                <li class="notification-dropdown hidden-phone">
                    <a href="#" class="trigger">
                        <i class="icon-warning-sign"></i>
                        <span class="count">8</span>
                    </a>
                    <div class="pop-dialog">
                        <div class="pointer right">
                            <div class="arrow"></div>
                            <div class="arrow_border"></div>
                        </div>
                        <div class="body">
                            <a href="#" class="close-icon"><i class="icon-remove-sign"></i></a>
                            <div class="notifications">
                                <h3>You have 6 new notifications</h3>
                                <a href="#" class="item">
                                    <i class="icon-signin"></i> New user registration
                                    <span class="time"><i class="icon-time"></i> 13 min.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-signin"></i> New user registration
                                    <span class="time"><i class="icon-time"></i> 18 min.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-envelope-alt"></i> New message from Alejandra
                                    <span class="time"><i class="icon-time"></i> 28 min.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-signin"></i> New user registration
                                    <span class="time"><i class="icon-time"></i> 49 min.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-download-alt"></i> New order placed
                                    <span class="time"><i class="icon-time"></i> 1 day.</span>
                                </a>
                                <div class="footer">
                                    <a href="#" class="logout">View all notifications</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="notification-dropdown hidden-phone">
                    <a href="#" class="trigger">
                        <i class="icon-envelope-alt"></i>
                    </a>
                    <div class="pop-dialog">
                        <div class="pointer right">
                            <div class="arrow"></div>
                            <div class="arrow_border"></div>
                        </div>
                        <div class="body">
                            <a href="#" class="close-icon"><i class="icon-remove-sign"></i></a>
                            <div class="messages">
                                <a href="#" class="item">
                                    <img src="/first/Application/Admin/View/img/contact-img.png" class="display" />
                                    <div class="name">Alejandra Galván</div>
                                    <div class="msg">
                                        There are many variations of available, but the majority have suffered alterations.
                                    </div>
                                    <span class="time"><i class="icon-time"></i> 13 min.</span>
                                </a>
                                <a href="#" class="item">
                                    <img src="/first/Application/Admin/View/img/contact-img2.png" class="display" />
                                    <div class="name">Alejandra Galván</div>
                                    <div class="msg">
                                        There are many variations of available, have suffered alterations.
                                    </div>
                                    <span class="time"><i class="icon-time"></i> 26 min.</span>
                                </a>
                                <a href="#" class="item last">
                                    <img src="/first/Application/Admin/View/img/contact-img.png" class="display" />
                                    <div class="name">Alejandra Galván</div>
                                    <div class="msg">
                                        There are many variations of available, but the majority have suffered alterations.
                                    </div>
                                    <span class="time"><i class="icon-time"></i> 48 min.</span>
                                </a>
                                <div class="footer">
                                    <a href="#" class="logout">View all messages</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle hidden-phone" data-toggle="dropdown">
                        <?php echo ($username); ?>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="personal-info.html">Personal info</a></li>
                        <li><a href="#">Account settings</a></li>
                        <li><a href="#">Billing</a></li>
                        <li><a href="#">Export your data</a></li>
                        <li><a href="#">Send feedback</a></li>
                    </ul>
                </li>
                <li class="settings hidden-phone">
                    <a href="personal-info.html" role="button">
                        <i class="icon-cog"></i>
                    </a>
                </li>
                <li class="settings hidden-phone">
                    <a href="<?php echo U('Login/logout');?>" role="button">
                        <i class="icon-share-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li>
                <a href="<?php echo U('Index/index');?>">
                    <i class="icon-home"></i>
                    <span>主页</span>
                </a>
            </li>
            <li>
                <a href="chart-showcase.html">
                    <i class="icon-signal"></i>
                    <span>Charts</span>
                </a>
            </li>
            <li>
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-group"></i>
                    <span>会员</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo U('Member/index');?>" class="active">会员列表</a></li>
                    <li><a href="<?php echo U('Member/edit');?>">添加会员</a></li>
                    <li><a href="user-profile.html">会员概况</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-edit"></i>
                    <span>房源管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="form-showcase.html">房源列表</a></li>
                    <li><a href="form-wizard.html">Form wizard</a></li>
                </ul>
            </li>
            <li>
                <a href="gallery.html">
                    <i class="icon-picture"></i>
                    <span>Gallery</span>
                </a>
            </li>
            <li>
                <a href="calendar.html">
                    <i class="icon-calendar-empty"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li>
                <a href="tables.html">
                    <i class="icon-th-large"></i>
                    <span>Tables</span>
                </a>
            </li>
            <li>
                <a class="dropdown-toggle ui-elements" href="#">
                    <i class="icon-code-fork"></i>
                    <span>UI Elements</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="ui-elements.html">UI Elements</a></li>
                    <li><a href="icons.html">Icons</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-cog"></i>
                    <span>系统设置</span>
					<i class="icon-chevron-down"></i>
					<ul class="submenu">
	                    <li><a href="<?php echo U('Config/index');?>" class="active">网站设置</a></li>
	                    <li><a href="<?php echo U('Config/config');?>">配置管理</a></li>
	                    <li><a href="user-profile.html">会员概况</a></li>
	                </ul>
                </a>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-share-alt"></i>
                    <span>Extras</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="code-editor.html">Code editor</a></li>
                    <li><a href="grids.html">Grids</a></li>
                    <li><a href="signin.html">Sign in</a></li>
                    <li><a href="signup.html">Sign up</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- end sidebar -->

<script src="/first/Public/js/jquery.ld.js"></script>
	<!-- main container -->
    <div class="content">

        <!-- settings changer -->
        <div class="skins-nav">
            <a href="#" class="skin first_nav selected">
                <span class="icon"></span><span class="text">Default</span>
            </a>
            <a href="#" class="skin second_nav" data-file="css/skins/dark.css">
                <span class="icon"></span><span class="text">Dark skin</span>
            </a>
        </div>

        <div class="container-fluid">
            <div id="pad-wrapper" class="form-page">
                <div class="row-fluid header">
                    <h3>会员信息</h3>
                </div>

                <div class="row-fluid form-wrapper">
                    <!-- left column -->
                    <div class="span9 with-sidebar">
                        <div class="container">
                          <?php if(empty($id)): ?><form action="<?php echo U('add');?>" method="post" name="myform" class="new_user_form inline-input">
                            <?php else: ?>
                            <form action="<?php echo U('edit');?>" method="post" name="myform" class="new_user_form inline-input"><?php endif; ?>
                                <div class="span7 field-box">
                                    <label>姓名:</label>
                                    <input class="span9" type="text" name="username" value="<?php echo ($username); ?>"/>
                                </div>
								<div class="span7 field-box">
                                    <label>地区:</label>
                                    <div class="ui-select span4">
                                    <script type="text/javascript">$(function(){$(".area_area").ld({ajaxOptions: {"url":"/first/m.php/Home/Ajax/linkarea.html"},"defaultParentId" : 1,texts : [<?php echo ($area_sheng); ?>,<?php echo ($area_shi); ?>,<?php echo ($area_xian); ?>],style:{"width" : 75}});})</script><select class="area_area ui-select" name="area_sheng" id="area_sheng"><option value="">请选择省</option></select><select class="area_area ui-select" name="area_shi" id="area_shi"><option value="">请选择市</option></select><select class="area_area ui-select" name="area_xian" id="area_xian"><option value="">请选择县</option></select>
                                    </div>
                                </div>
                                 <?php if(empty($id)): ?><div class="span12 field-box">
                                    <label>密码:</label>
                                    <input class="span7" type="password" name="password" />
                                </div>
                                <div class="span12 field-box">
                                    <label>确认密码:</label>
                                    <input class="span7" type="password" name="repassword"/>
                                </div><?php endif; ?>
                                <div class="span7 field-box" style="margin-top:10px">
                                    <label>Email:</label>
                                    <input class="span9" type="text" value="<?php echo ($email); ?>" name="email"/>
                                </div>
                                <div class="span7 field-box">
                                    <label>手机:</label>
                                    <input class="span9" type="text" value="<?php echo ($mobile); ?>" name='mobile'/>
                                </div>
                                <div class="span12 field-box">
                                    <label>地址:</label>
                                    <div class="address-fields">
                                        <input class="span9" type="text" value="<?php echo ($address); ?>" name="address"/>
                                    </div>
                                </div>
                                <div class="span12 field-box">
                                    <label>状态:</label>
                                    <div class="span8">
                                        <label class="radio" style="width:60px;">
                                            <input type="radio" name="status" id="optionsRadios1" value="1" checked="" />
                                            启用
                                        </label>
                                        <label class="radio" style="width:60px;">
                                            <input type="radio" name="status" id="optionsRadios2" value="0" />
                                            禁用
                                        </label>
                                    </div>
                                </div>
                                <div class="span11 field-box actions">
                                	<input type="hidden" value="<?php echo ($id); ?>" name='id'/>
                                    <input type="submit" class="btn-glow primary span1_2" value="确认" />
                                    <input type="button" value="取消" class="btn-flat info span1_2" onclick="javascript:history.back(-1);return false;"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end main container -->


</body>
</html>