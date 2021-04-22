<?php
require('layout/head.php');

echo '

<body class="header-fix fix-sidebar">

<!-- Main wrapper  -->
<div id="main-wrapper">
    <!-- header header  --> ';
	
require('layout/header.php');

  //  <!-- End header header -->
 //   <!-- Left Sidebar  -->
 
if (file_exists("/email.auth")) {
	require('layout/sidebar.php'); 
	
	echo '
		<!-- End Left Sidebar  -->
		<!-- Page wrapper  -->
		<div class="page-wrapper">
			<!-- Container fluid  -->
			<div class="container-fluid">
				<!-- Start Page Content -->
	';
}

