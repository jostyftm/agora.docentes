<div id="sidebar-wrapper" >
	<ul class="sidebar-nav nav-pills nav-stacked" id="menu">
		<!-- <li class="">
			<a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span> Dashboard</a>
			<ul class="nav-pills nav-stacked" style="list-style-type:none;">
				<li><a href="#">link1</a></li>
				<li><a href="#">link2</a></li>
			</ul>
		</li> -->

		<!-- Inicio -->
		<li>
            <a href="/teacher"> 
            	<span class="fa-stack fa-lg pull-left">
            		<i class="fa fa-dashboard fa-stack-1x "></i>
            	</span>
            	Inicio
            </a>
        </li>
		
		<!-- Evaluación -->
        <li>
            <a href="/teacher/Evaluation"> 
            	<span class="fa-stack fa-lg pull-left">
            		<i class="fa fa-check fa-stack-1x "></i>
            	</span>
            	Evaluación
            </a>
        </li>
		
		<!-- Planilla -->
        <li>
            <a href="/teacher/sheets"> 
            	<span class="fa-stack fa-lg pull-left">
            		<i class="fa fa-file-text-o fa-stack-1x "></i>
            	</span>
            	Planillas
            </a>
        </li>


		<!-- Estadisticas -->
        <!-- <li>
            <a href="/teacher/statistics"> 
            	<span class="fa-stack fa-lg pull-left">
            		<i class="fa fa-line-chart fa-stack-1x "></i>
            	</span>
            	Estadistica
            </a>
        </li> -->
        <li class="">
            <a data-toggle="collapse" data-parent="#menu" href="#collapse-statictics" aria-expanded="true" aria-controls="collapse-statictics">
                <span class="fa-stack fa-lg pull-left"><i class="fa fa-line-chart fa-stack-1x "></i>
                </span> 
                Estadistica
            </a>
            <ul id="collapse-statictics" class="nav-pills nav-stacked collapse collapseable" style="list-style-type:none;">
                <li><a href="/teacher/statistics/consolidate">Consolidado</a></li>
                <li><a href="/teacher/statistics/student">Estudiante</a></li>
                <li><a href="/teacher/statistics/disapproved">Reprobados</a></li>
                <li><a href="/teacher/statistics/performanceByTeacher">Desempeño por Docente</a></li>
            </ul>
        </li>

        <!-- Estadisticas -->
        <li>
            <a href="/teacher/settings"> 
            	<span class="fa-stack fa-lg pull-left">
            		<i class="fa fa-cog fa-stack-1x "></i>
            	</span>
            	Configuración
            </a>
        </li>
	</ul>
</div>