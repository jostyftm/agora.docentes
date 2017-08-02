<!DOCTYPE html>
<html lang="es">
   	<head>
      	<meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      	<title></title>

      	<!-- Bootstrap -->
      	<link href="/Public/css/bootstrap.css" rel="stylesheet" type="text/css">
   		  <link href="/Public/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">

        <!-- Font Awesome -->
        <link href="/Public/css/font-awesome.min.css" rel="stylesheet" type="text/css">

   		<!-- Style -->
   		<link href="/Public/css/default2.css" rel="stylesheet" type="text/css">

        <!-- Styles Sweetalert -->
        <link href="/Public/css/sweetalert.css" rel="stylesheet"  type="text/css">
    
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="/Public/js/jquery-1.12.4.js"></script>
    
      <!-- DataTables -->
      <script src="/Public/js/jquery.dataTables.min.js"></script>
      <script src="/Public/js/dataTables.bootstrap.min.js"></script>
      
      <!-- MultiSelect -->
      <script src="/Public/js/multiselect.js"></script>

      <!-- CKEDITOR -->
      <script src="/Public/plugin/ckeditor/ckeditor.js"></script>

      <!-- PDFObject -->
      <script src="/Public/plugin/PDFObject/pdfobject.js"></script>

      <!-- Swealert js -->
      <script src="/Public/js/sweetalert.min.js"> </script>
      
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  	</head>
	<body>
		<div id="wrapper">
        <!-- Sidebar -->
        <?php
            include ('dashboard/sidebar.tpl.php');
         ?>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
        		<!-- SubHeader -->
            <!-- NAV -->
          <?php
            include ('dashboard/header.tpl.php')
          ?>
          <!-- END NAV -->
				<?php
	            include ('dashboard/subheader.tpl.php');
	         ?>
	        <!-- /#subHeader-wrapper -->
            <div class="container-fluid xyz" id="content">
               <?php
                  include ($include);
               ?>
            </div>

            <footer class="contentF">
            <div id="footerAd" class="clearfix">
              <div class="pull-left">
                <b>Derechos Reservados </b>&copy; <?php  echo date('Y') ?>
              </div>
              <div class="pull-right">
                @tenea
              </div> 
            </div> 
          </footer>
        </div>
        <!-- /#page-content-wrapper -->

        <!-- Footer -->
        
        <!-- /#footer-wrapper -->
    </div>
    <!-- /#wrapper -->
	

	<!-- SCRIPTS -->
    <script src="/Public/js/bootstrap.js"></script>
      <!--  -->
      <script src="/Public/js/default.js"></script>
	</body>
</html>