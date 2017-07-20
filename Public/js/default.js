$(document).ready(function(){
	
	// Colapsar el menu
	$("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
     $("#menu-toggle-2").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled-2");
        // $('#menu ul').hide();
    });

	// Peticiones para los subHeaders
	$('[data-toggle="tab"]').each(function(){
		// Creamos la peticion ajax y renderizamos la vista
		$(this).click(function(){
			var that = $(this);

			if(!that.parent().hasClass('active'))
			{
				$.ajax({
					type: 	  'GET',
					url: 	  that.attr('data-link'),
					dataType: 'html',
					beforeSend: function(xhr){
						$("#content").empty().append(
							$('<div>', {class: 'col-md-12 content'}).append(
								$('<div>', {class: 'panel panel-default panel-loading text-center'}).append(
									$('<div>', {class: 'panel-body'}).append(
										$('<div>', {class: 'fa fa-spinner fa-spin fa-3x fa-fw'}),
										$('<span>Cargando...</span>')
									)
								)
							)
						);
					},
					success: function(data){
						$("#content").empty().append(data);
					},
					error(xhr, estado){
	                	console.log(xhr);
	                  	console.log(estado);
	               	}
				});
			}
		});
	});

	// initMenu();
});

function initMenu() {
	    $('#menu ul').hide();
	    $('#menu ul').children('.current').parent().show();
	    //$('#menu ul:first').show();
	    $('#menu li a').click(
	        function() {
	          	var checkElement = $(this).next();
	          	if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
	            	return false;
	            }
	          	if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
	            	$('#menu ul:visible').slideUp('normal');
	            	checkElement.slideDown('normal');
	            	return false;
	            }
	         }
	    );
    }