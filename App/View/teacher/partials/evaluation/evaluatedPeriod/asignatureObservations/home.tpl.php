<div class="row" id="contentNewObs">
	<div class="col-md-12 text-center">
		<a href="/Asignature/createObservation" class="btn btn-primary" data-method="create" data-request="crud" data-rol="teacher">Crear Observacion</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table" id="table">
				<thead>
					<tr>
						<th>
							Observación
						</th>
						<th>
							&nbsp;
						</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){

		var table = $("#table").DataTable({
			"lengthChange": false,
	       	"pageLength": 6,
	       	retrieve: true,
	        language: {
	        	url: '/Public/json/Spanish.json'
	        },
            "ajax": {
              	"method": "GET",
               	"url":"/Asignature/getObservationByStudentJSON/"+<?= $id_student?>+"/"+<?= $id_asignature ?>+"/"+<?= $period ?>
            },
            "columns":
            [
              	{
                    "render": function(data, type, full, meta){

                        var content = full.observacion.replace(/<[^>]*>?/g, '');
                        // return '<span>'+full.observacion+'</span';
                        return type === 'display' && full.observacion.length > 160 ?
                        '<span title="'+content+'">'+content.substr( 0, 160 )+'...</span>' : content;
                    }
               		
                },
                {
                	"render": function(data, type, full, meta){
                			

               			return '<a href="/Asignature/editObservation/'+full.id+'" class="btn btn-primary" data-method="edit" data-request="crud" data-rol="teacher"><i class="fa fa-edit"></i></a>&nbsp;<a href="/Asignature/deleteObservation/'+full.id+'" data-id="'+full.id+'" class="btn btn-danger" data-method="delete" data-request="crud" data-rol="teacher"><i class="fa fa-trash"></i></a>';
           			}
               	}
            ]
        });

        // 
        $('#table tbody, #contentNewObs').on( 'click', 'a', function (e) {

            e.preventDefault();

            var that = $(this),
                modal = $("#modalAggObs"),
                backBtn = modal.find(".modal-footer a"),
                id_student = <?= $id_student?>,
                id_asignature = <?= $id_asignature?>,
                period  =   <?= $period?>;

            if(that.attr('data-method') == 'delete')
            {   
                    
                $("#id_observation").val(that.attr('data-id'));
                $('#modalDelete').modal({
                    show: true,
                    backdrop: 'static',
                    keyboard: false
                });
            }
            else
            {   

                $.ajax({
                    type: 'GET',
                    url: that.attr('href'),
                    dataType: 'html',
                    data: {
                        id_student,
                        id_asignature,
                        period,
                        request: that.attr('data-request'),
                        rol: that.attr('data-rol')
                    },
                    beforeSend: function(xhr){
                           
                    },
                    success: function(data){
                        modal.find(".modal-body").empty().append(data);
                            
                        if(backBtn.hasClass('hide'))
                            backBtn.removeClass('hide');
                    },
                    error(xhr, estado){
                        console.log(xhr);
                        console.log(estado);
                    }
                });
            }
        });
	});
</script>