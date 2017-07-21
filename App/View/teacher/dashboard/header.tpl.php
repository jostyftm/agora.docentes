<nav class="navbar navbar-default no-margin" id="nav">
			<div class="image">
           <?php 
               if($institution[0]['logo_byte'] != NULL): 
                     $pic = 'data:image/png;base64,'.base64_encode($institution[0]["logo_byte"]);
           ?>
               <img src="<?php echo $pic;?>" alt="" class="img-responsive" width="50">
            <?php endif;?>
        </div>
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header fixed-brand">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
           <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
        </button>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><?php echo $institution[0]['nombre_inst'];?></a>
     </div><!-- navbar-header-->

     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
       <ul class="nav navbar-nav">
        <li class="active" >
          <button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"> 
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
          </button></li>
     </ul>
     <ul class="pull-right menu_option">
        <li>
          <!-- Bienvenid@ -->
            <strong>
                <?php echo $teacher['primer_nombre']." ".$teacher['segundo_nombre']." ".$teacher['primer_apellido']." ".$teacher['segundo_apellido']?>
            </strong>
          </li>
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
						<a href="/auth/logout" class="log-out">
							<span class="fa fa-sign-out" arial-hidden="true"></span>
							Cerra Sesion
						</a>
					</li>
				</ul>
			</div><!-- bs-example-navbar-collapse-1 -->
		</nav>