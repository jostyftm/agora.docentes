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
      
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  	</head>
	<body>
		<!-- NAV -->
		<nav class="navbar navbar-default no-margin" id="nav">
			<div class="image">
           <?php 
               if($institution[0]['logo_byte'] != NULL): 
                     $pic = 'data:image/png;base64,'.base64_encode($institution[0]["logo_byte"]);
           ?>
               <img src="<?php echo $pic;?>" alt="" class="img-responsive" width="60">
            <?php endif;?>
        </div>
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header fixed-brand">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
           <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
        </button>
        <a class="navbar-brand" href="#"><?php echo $institution[0]['nombre_inst'];?></a>
     </div><!-- navbar-header-->

     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
       <ul class="nav navbar-nav">
        <li class="active" ><button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button></li>
     </ul>
     <ul class="pull-right menu_option">
        <li>Bienvenido Pepito perez</li>
					<!-- <li class="fixed-with">
						<a href="#">
							<span class="fa fa-bell" arial-hidden="true"></span>
							<span class="label label-warning">3</span>
						</a>
					</li>
					<li class="fixed-with">
						<a href="#">
							<span class="fa fa-envelope" arial-hidden="true"></span>
							<span class="label label-message">3</span>
						</a>
					</li> -->
					<li>
						<a href="#" class="log-out">
							<span class="fa fa-sign-out" arial-hidden="true"></span>
							Cerra Sesion
						</a>
					</li>
				</ul>
			</div><!-- bs-example-navbar-collapse-1 -->
		</nav>
		<!-- END NAV -->

		<div id="wrapper">
        <!-- Sidebar -->
        <?php
            include ('dashboard/sidebar2.tpl.php');
         ?>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
        		<!-- SubHeader -->
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