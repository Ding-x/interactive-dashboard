<?php
session_start(); 


if (!(isset($_SESSION['username']))) 
header("location: index.php "); 
else echo '

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>CMDB DASHBOARD - CUSTOM</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="viewport" content="width=device-width" />

    <script src="assets/js/jquery-3.3.1.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
    <script src="assets/js/bootstrap-select.min.js"></script>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <script src="assets/js/echarts.js"></script>
    <script type="text/javascript" src="assets/js/jquery.table2excel.min.js"></script>

    <script src="assets/js/load_report_data.js"></script>
    <script src="assets/js/load_basic_data.js"></script>


</head>
<body>

<!-- Left hand navigation bar -->
<div class="wrapper">
    <div class="sidebar" >
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                    CMDB DASHBOARD
                </a>
            </div>

            <ul class="nav">
                <li >
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="active">
                    <a href="custom.php">
                        <i class="pe-7s-user"></i>
                        <p>Custom reports</p>
                    </a>
                </li>
                <li>
                    <a href="#systemSetting" class="nav-header collapsed" data-toggle="collapse">
                        <i class="pe-7s-angle-down-circle"></i><p>Summary</p>
                    </a>
                    <ul id="systemSetting" class="nav nav-list collapse secondmenu" style="height: 0px;">
                        <li>
                            <a href="server.php">
                                <i class="pe-7s-monitor"></i>
                                <p>Server</p>
                            </a>
                        </li>
                        <li>
                            <a href="build.php">
                                <i class="pe-7s-note2"></i>
                                <p>Build</p>
                            </a>
                        </li>
                        <li>
                            <a href="retire.php">
                                <i class="pe-7s-note"></i>
                                <p>Retire</p>
                            </a>
                        </li>
                        <li>
                            <a href="backup.php">
                                <i class="pe-7s-news-paper"></i>
                                <p>Backup</p>
                            </a>
                        </li>
                        <li>
                            <a href="application.php">
                                <i class="pe-7s-science"></i>
                                <p>Application</p>
                            </a>
                        </li>
                        <li>
                            <a href="reboot.php">
                                <i class="pe-7s-loop"></i>
                                <p>Reboot</p>
                            </a>
                        </li>
                        <li>
                            <a href="networking.php">
                                <i class="pe-7s-network"></i>
                                <p>Networking</p>
                            </a>
                        </li>
                    </ul>
                </li>
 

            </ul>
    	</div>
    </div>

    <!-- Right hand center panel -->
    <div class="main-panel">
        <div class="row basic-info-bar">
            <div class="col-md-3"></div>
            <div class="col-md-6 basic-info">
                <h3 class="text-center page-title">Custom reports
                </h3>
            </div>
            <div class="col-md-3">
                <button id="issue_manage_open" class="btn btn-primary btn-lg btn-cus">Manage Reports</button>
            </div>
        </div>

        <div class="content">
                <div id="issue_data_content" class="row content">
                    <div id="issue_frame" class=" col-sm-12">
                        <div id="issue_display" class="row" >
                                <div class="issue-header">
                                    <span class="issue-name-title">NAME</span>
                                    <span class="issue-priority">
                                        <select class="selectpicker" id="issue_prio_select" title="PRIORITY" multiple >
                                                <option>HIGH</option>
                                                <option>MEDIUM</option>
                                                <option>LOW</option>
                                        </select>
                                    </span>
                                    <span class="issue-category">
                                        <select class="selectpicker" id="issue_cate_select" title="CATEGORY" multiple></select>
                                    </span>
                                    <span class="issue-count-title">COUNT</span>
                                </div>

                            <div id="issue_display_list" class="col-sm-12"></div>
                        </div>
                        <div id="issue_edit" class="row" style="display:none">
                            <div id="issue_edit_list" class="col-sm-9">
                            </div>
                            <div class="col-sm-3">
                                <div class="issue-stat-container">
                                    <div class="row"><button id="issue_manage_add" class="btn btn-danger btn-lg btn-manage">Add</button></div>
                                    <div class="row"><button id="issue_manage_edit" class="btn btn-warning btn-lg btn-manage">Edit</button></div>
                                    <div class="row"><button id="issue_manage_close" class="btn btn-default btn-lg btn-manage" >Exit</button></div>
                                </div>
        
                            </div>
                        </div>
                        <div id="issue_detail" class="row" style="display:none" >
                            <div id="issue_detail_info" class="col-sm-9">
                                    <div class="input-group"> <span class="input-group-addon">Name:</span><input id="issue_name" type="text" class="form-control" required="required" maxlength="80" placeholder="Max 80 characters allowed. "></div>
                                    <div class="input-group">
                                        <span class="input-group-addon">Priority:</span>
                                        <select class="form-control" id="prio_edit">
                                            <option>HIGH</option>
                                            <option>MEDIUM</option>
                                            <option>LOW</option>
                                        </select>
                                        <span class="input-group-addon">Category:</span>
                                        <select class="form-control" id="cate_edit">
                                        </select>
                                        <span class="input-group-addon">Show in Dashboard?:</span>
                                        <select class="form-control" id="dashboard_edit">
                                            <option>YES</option>
                                            <option>NO</option>
                                        </select>
                                    </div>
                                    <div class="input-group"><span class="input-group-addon"> SQL :</span><textarea id="issue_sql" rows="13" maxlength="5550" class="form-control" required="required" placeholder="Notice: When more the one column names you selected are the same, you MUST assign them with unique name respectively without any blank space."></textarea></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="issue-stat-container">
                                    <div class="row"><button id="issue_edit_submit" class="btn btn-danger btn-lg btn-manage">Submit</button></div>
                                    <div class="row"><button id="issue_edit_delete" class="btn btn-warning btn-lg btn-manage">Delete</button></div>
                                    <div class="row"><button id="issue_edit_cancel" class="btn btn-default btn-lg btn-manage" >Cancel</button></div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
             
              
            <div id="table-frame">
                <div id="table_info" class="container-fluid" >
                    <div class="row">
                        <div class="col-md-9"><h4 id="table_title" class="text-center"></h4></div>
                        <div class="col-md-1"><button id="export_btn" class="btn btn-primary ">Export</button></div>
                        <div class="col-md-1"><button id="print_btn" class="btn btn-primary ">Print</button></div>
                        <div class="col-md-1"><button id="table_close" class="btn btn-danger">Close</button></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input class="form-control" id="search_table" type="text" placeholder="Search anything..">
                        </div>
                    </div>
                    <div id="table_content" class="row">
                        <div class="col-md-12">            
                            <table border="1" id="myTable" class="table table-striped table-bordered table-hover table-condensed"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright text-center">
                    &copy; <script>document.write(new Date().getFullYear())</script> CMDB DASHBOARD
                </p>
            </div>
        </footer>

    </div>
</div>


</body>
</html>

';
?>