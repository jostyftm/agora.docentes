$(function() {


    const numMinimo = parseInt($('#minimo').val());
    const numMaximo = parseInt($('#maximo').val());

    //Datos del controlador
    var databaseDB = $('#databaseDB').val();
    var grupoDB = $('#grupoDB').val();
    var gradoDB = $('#gradoDB').val();
    var asignaturaDB = $('#asignaturaDB').val();
    var groupType = $("#groupType").val();

    //Porcentajes de desempeños
    var porcentajeCog = (parseInt($('#porcentaje_grupo1').val()) / 100).toFixed(2);
    var porcentajePer = (parseInt($('#porcentaje_grupo2').val()) / 100).toFixed(2);
    var porcentajeSol = (parseInt($('#porcentaje_grupo3').val()) / 100).toFixed(2);
    var porcentajeAe = (parseInt($('#porcentaje_autoeva').val()) / 100).toFixed(2);
    var porcentajePro = (parseInt($('#porcentaje_proyect').val()) / 100).toFixed(2);

    //Porcentajes para la rondón
    var porcentaje_ep = (parseInt($('#porcentaje_ep').val()) / 100).toFixed(2);
    var porcentaje_ex = (parseInt($('#porcentaje_ex').val()) / 100).toFixed(2);
    var porcentaje_tt = (parseInt($('#porcentaje_tt').val()) / 100).toFixed(2);
    var porcentaje_par = (parseInt($('#porcentaje_par').val()) / 100).toFixed(2);
    var porcentaje_ad = (parseInt($('#porcentaje_ad').val()) / 100).toFixed(2);


    var cantidadDC = (parseInt($('#cantidadDC').val()));
    var numPeriodo = (parseInt($('#periodoDB').val()));

    //***************

    $('#content-formulario-registro').hide();
    $('#content-div-dc').hide();

    //Crear desempeño
	
    $('#text-desempeno').on('paste keyup click mousemove mouseout mouseleave',function () {

        var tAlto = $('#t-alto').val();
        var tBasico = $('#t-basico').val();
        var tBajo = $('#t-bajo').val();

        var textoSuperior = $('#text-desempeno').val().toUpperCase();

        if (textoSuperior == '') {
            tAlto = '';
            tBasico = '';
            tBajo = '';
        }
		autoCopy = $('#idCheckCopy').is(':checked');		
		if(!autoCopy){
			$('#text-alto').val((tAlto + textoSuperior));
			$('#text-basico').val((tBasico + textoSuperior));
			$('#text-bajo').val((tBajo + textoSuperior));		
			
		}
        $('#text-desempeno').empty().val(textoSuperior.toUpperCase());

    });
	
	$('#idCheckCopy').click(function(){
		 $('#text-desempeno').focus();
	});
    //**********************

	

    //Guardar desempeño
    $('#btn-guardar-desemp').click(function (ev) {

        ev.preventDefault();
        var gradoInsertar = $('#gradoInsertar').val();
        var areaInsertar = $('#AreaInsertar').val();
        var asignaturaInsertar = $('#AsigInsertar').val();
        var periodoInsertar = $('#periodoInsertar').val();
        var categoriaInsertar = $('#categoriaInsertar').val();
        var textSuperior = $('#text-desempeno').val();

        var textRefuerzo = $('#text-refuerzo').val();

        var textAlto = $('#text-alto').val();
        var textBajo = $('#text-bajo').val();
        var textBasico = $('#text-basico').val();
        var textRecomendacion = $('#text-recomendacion').val();



        if (areaInsertar == '0')
            $('#AreaInsertar').addClass('error');
        else
            $('#AreaInsertar').removeClass('error');

        if (asignaturaInsertar == '0')
            $('#AsigInsertar').addClass('error');
        else
            $('#AsigInsertar').removeClass('error');

        if (textSuperior == '')
            $('#text-desempeno').addClass('error');
        else
            $('#text-desempeno').removeClass('error');

        if (textAlto == '')
            $('#text-alto').addClass('error');
        else
            $('#text-alto').removeClass('error');

        if (textBasico == '')
            $('#text-basico').addClass('error');
        else
            $('#text-basico').removeClass('error');

        if (textBajo == '')
            $('#text-bajo').addClass('error');
        else
            $('#text-bajo').removeClass('error');

        if (areaInsertar != '0' && asignaturaInsertar != '0' && textSuperior != '' && textAlto != '' && textBasico != ''
            && textBajo != '') {
            var dataString = 'area=' + areaInsertar + '&grado=' + gradoInsertar + '&asignatura=' + asignaturaInsertar + '&periodo=' + periodoInsertar + '&categoria=' + categoriaInsertar + '&superior=' + textSuperior + '&alto=' + textAlto + '&basico=' + textBasico + '&refuerzo=' + textRefuerzo + '&bajo=' + textBajo + '&recomendacion=' + textRecomendacion;

            $.ajax({
                method: "POST",
                url: "/Performance/store/",
                data: dataString
            })
                .done(function (datos) {
					if(datos == 'false'){
                        swal({
                            title: "Error. Duplicación de Desempeño!",
                            text: "Desempeño ya existe.",
                            type: "error",
                            timer: 3500,
                            showConfirmButton: true
                        });
                    }else{
                        swal({
                            title: "Guardado!",
                            text: "Exitosamente.",
                            type: "success",
                            timer: 2500,
                            showConfirmButton: false
                        });
                    }
                });

            //$('#form-select').show(170);
            //$('#content-formulario-registro').hide(100);


            $('#text-desempeno').val('');
            $('#text-refuerzo').val('');
            $('#text-alto').val('');
            $('#text-basico').val('');
            $('#text-bajo').val('');
            $('#text-recomendacion').val('');

            var periodoSeleccionado = $('#periodoInsertar').val();
			var categoriaSeleccionado = $('#categoriaInsertar').val();
            var gradoSeleccionado = $("#gradoInsertar").val();
            var asignaturaSeleccionado = $('#AsigInsertar').val();

            $('#gradoDesempeno option').filter(function(){
                return $(this).val() == gradoSeleccionado;
            }).prop('selected', true);

            $('#asignaturaDesempeno option').filter(function(){
                return $(this).val() == asignaturaSeleccionado;
            }).prop('selected', true);

            $('#categoriaDesempeno option').filter(function(){
                return $(this).val() == categoriaSeleccionado;
            }).prop('selected', true);

            $('#periodosDesempeno option').filter(function(){
                return $(this).val() == periodoSeleccionado;
            }).prop('selected', true);

			//Trae la tabla con los desempeños exitentes
				$.ajax({
					method: "POST",
					url: "/Performance/getIndicators/" + gradoSeleccionado + "/" + asignaturaSeleccionado + "/" + categoriaSeleccionado + "/" + periodoSeleccionado,
					data: ''
				})
					.done(function (datos) {

                       

						$('#tabla-contentt').empty().append(datos);

						$('#table_id').DataTable({
							paging: false,
							"autoWidth": false,
							"bFilter": true,
							language: {
								url: '/Public/json/Spanish.json'
							}
						});

						$('#item-posicion').find('th[data-estado="false"]').each(function (i, element) {

										codDesemp = $(element)[0].innerText;							
										if(codDesemp != '')
											$('#table_id').find('button[data-id='+codDesemp+']').attr('disabled', true);								

						});

						$('#table_id').find('a.ntf').hide();
						setSeleccionarDesemp(gradoDB, grupoDB, asignaturaDB, numPeriodo, databaseDB);

						$('#form-select').find('select').change(function (event) {

                            var asignaturaIndicadores = $('#asignaturaDesempeno').val();
                            var gradosIndicadores = $('#gradoDesempeno').val();
                            var periodoIndicadores = $('#periodosDesempeno').val();
                            var categoriaIndicadores = $('#categoriaDesempeno').val();



                            console.log("si");

							$.ajax({
								method: "POST",
								url: "/Performance/getIndicators/" + gradosIndicadores + "/" + asignaturaIndicadores + "/" + categoriaIndicadores + "/" + periodoIndicadores,
								data: ''
							})
								.done(function (datos) {

									$('#tabla-contentt').empty().append(datos);
									$('#table_id').DataTable({

										paging: false,
										"autoWidth": false,
										"bFilter": true,

                                        language: {
                                            url: '/Public/json/Spanish.json'
                                        }
									});

									$('#item-posicion').find('th[data-estado="false"]').each(function (i, element) {

										codDesemp = $(element)[0].innerText;							
										if(codDesemp != '')
											$('#table_id').find('button[data-id='+codDesemp+']').attr('disabled', true);								

									});
									setSeleccionarDesemp(gradoDB, grupoDB, asignaturaDB, numPeriodo, databaseDB);


                                    asignaturaIndicadores = asignaturaIndicadores=="-1"?asignaturaDB:asignaturaIndicadores;
                                    gradosIndicadores = gradosIndicadores=="-1"?gradoDB:gradosIndicadores;
                                    periodoIndicadores = periodoIndicadores=="-1"?$('#periodos').val():periodoIndicadores;

                                    $('#gradoInsertar option').filter(function(){

                                        return $(this).val() == gradosIndicadores;
                                    }).prop('selected', true);

                                    $.ajax({
                                        method: "POST",
                                        url: "/Area/getByGrade/" + gradosIndicadores,
                                        data: ''
                                    })
                                        .done(function (datos) {
                                            $('#AreaInsertar').empty().append(datos);




                                            //Obtenemos el id area deacuerdo a la asignatura y grado
                                            $.ajax({
                                                method: "POST",
                                                url: "/Performance/getIdAreaByIdAsignatura/" + asignaturaIndicadores+"/"+gradosIndicadores,
                                                data: ''
                                            })
                                                .done(function (datos) {
                                                    console.log(datos);
                                                    var areaSeleccionado = datos;
                                                    //Selecionamos  el area actual en el select
                                                    $('#AreaInsertar option').filter(function(){
                                                        //console.log( $(this).val());
                                                        return $(this).val() == areaSeleccionado;

                                                    }).prop('selected', true);

                                                    //Traemos las asignaturas correspondiente al area
                                                    $.ajax({
                                                        method: "POST",
                                                        url: "/Asignature/getByAreaAndGrade/" + areaSeleccionado + "/" + gradosIndicadores,
                                                        data: ''
                                                    })
                                                        .done(function (datos) {
                                                            $('#AsigInsertar').empty().append(datos);
                                                            //Selecionamos  la asignatura actual en el select
                                                            $('#AsigInsertar option').filter(function(){

                                                                //console.log( $(this).val());
                                                                return $(this).val() == asignaturaIndicadores;

                                                            }).prop('selected', true);
                                                        });
                                                });


                                        });

                                    var categoriaSeleccionado = $('#categoriaDesempeno').val();

                                    //Selecionamos  la categoría actual en el select
                                    $('#categoriaInsertar option').filter(function(){
                                        //console.log( $(this).val());
                                        return $(this).val() == categoriaSeleccionado;
                                    }).prop('selected', true);

                                    var periodoSeleccionado = $('#periodosDesempeno').val();
                                    $('#periodoInsertar option').filter(function(){
                                        //console.log( $(this).val());
                                        return $(this).val() == periodoSeleccionado;
                                    }).prop('selected', true);
//***************************************************************************************

								});





                        });
					}); //**************

        }


    });
    //***************

    //Boton cancelar del Modal
    $('#btn-cancelar').click(function () {
        $('#form-select').show(170);
        $('#content-formulario-registro').hide(100);
        $('#tabla-contentt').show();

        $('#text-desempeno').val('');
        $('#text-refuerzo').val('');
        $('#text-alto').val('');
        $('#text-basico').val('');
        $('#text-bajo').val('');
        $('#text-recomendacion').val('');
    });
    //********************

    //Precarga los datos seleccionado para guardar los desempeños ***************************************
    var desempenoGrado = $('#gradoDesempeno').val();


    $('#gradoInsertar option').filter(function(){
        //console.log( $(this).val());
        return $(this).val() == desempenoGrado;
    }).prop('selected', true);

    $.ajax({
        method: "POST",
        url: "/Area/getByGrade/" + desempenoGrado,
        data: ''
    })
        .done(function (datos) {
            $('#AreaInsertar').empty().append(datos);


            var asignaturaSeleccionado = $('#asignaturaDesempeno').val();


            //Obtenemos el id area deacuerdo a la asignatura y grado
            $.ajax({
                method: "POST",
                url: "/Performance/getIdAreaByIdAsignatura/" + asignaturaSeleccionado+"/"+desempenoGrado,
                data: ''
            })
                .done(function (datos) {
                    console.log(datos);
                    var areaSeleccionado = datos;
                    //Selecionamos  el area actual en el select
                    $('#AreaInsertar option').filter(function(){
                        //console.log( $(this).val());
                        return $(this).val() == areaSeleccionado;

                    }).prop('selected', true);

                    //Traemos las asignaturas correspondiente al area
                    $.ajax({
                        method: "POST",
                        url: "/Asignature/getByAreaAndGrade/" + areaSeleccionado + "/" + desempenoGrado,
                        data: ''
                    })
                        .done(function (datos) {
                            $('#AsigInsertar').empty().append(datos);
                            //Selecionamos  la asignatura actual en el select
                            $('#AsigInsertar option').filter(function(){

                               // console.log( $(this).val());
                                return $(this).val() == asignaturaSeleccionado;

                            }).prop('selected', true);
                        });
                });


        });

    var categoriaSeleccionado = $('#categoriaDesempeno').val();

    //Selecionamos  la categoría actual en el select
    $('#categoriaInsertar option').filter(function(){
        //console.log( $(this).val());
        return $(this).val() == categoriaSeleccionado;
    }).prop('selected', true);

    var periodoSeleccionado = $('#periodosDesempeno').val();
    $('#periodoInsertar option').filter(function(){
        //console.log( $(this).val());
        return $(this).val() == periodoSeleccionado;
    }).prop('selected', true);
//***************************************************************************************




    //Busqueda de desempeño -Configuración de desempeño
    $('#gradoInsertar').change(function () {
        var gradoIns = $(this).val();
        $.ajax({
            method: "POST",
            url: "/Area/getByGrade/" + gradoIns,
            data: ''
        })
            .done(function (datos) {
                $('#AreaInsertar').empty().append(datos);
            });


    });


    $('#AreaInsertar').change(function () {
        var AreaIns = $('#AreaInsertar').val();
        var gradoIns = $('#gradoInsertar').val();

        $.ajax({
            method: "POST",
            url: "/Asignature/getByAreaAndGrade/" + AreaIns + "/" + gradoIns,
            data: ''
        })
            .done(function (datos) {
                $('#AsigInsertar').empty().append(datos);

            });

        $('#AsigInsertar').change(function(){
            var asignaturaSelec = $(this).val();
            $('#asignaturaDesempeno option').filter(function(){
                //console.log( $(this).val());
                return $(this).val() == asignaturaSelec;
            }).prop('selected', true);

        });

    });
    //***/

    //Mostrar formulario para crear un desempeño
    $('#btn-crear-desemp').click(function () {
        $('#tabla-contentt').hide();
        $('#form-select').hide(100);
        $('#content-formulario-registro').show(200);

        $('#text-desempeno').val('');
        $('#text-refuerzo').val();
        $('#text-alto').val('');
        $('#text-basico').val('');
        $('#text-bajo').val('');
        $('#text-recomendacion').val('');

    });

    //
    $('#btn-finalizar').click(function () {
        $('#form-select').show(170);
        $('#content-formulario-registro').hide(100);

        $('#text-desempeno').val('');
        $('#text-refuerzo').val();
        $('#text-alto').val('');
        $('#text-basico').val('');
        $('#text-bajo').val('');
        $('#text-recomendacion').val('');
    });


    $('[data-toggle="tooltip"]').tooltip()
    $('#button-desempeno').attr('disabled', true);

    var periodoSeleccionado = $('#periodos').val();


    //Trae la tabla con los desempeños exitentes
    $.ajax({
        method: "POST",
        url: "/Performance/getIndicators/" + gradoDB + "/" + asignaturaDB + "/" + 1 + "/" + periodoSeleccionado,
        data: ''
    })
        .done(function (datos) {

            $('#tabla-contentt').empty().append(datos);

            $('#table_id').DataTable({

                paging: false,
                "autoWidth": false,
                "bFilter": true,
                language: {
	        		url: '/Public/json/Spanish.json'
	        	}
            });

			$('#item-posicion').find('th[data-estado="false"]').each(function (i, element) {
							
							codDesemp = $(element)[0].innerText;							
							if(codDesemp != '')
								$('#table_id').find('button[data-id='+codDesemp+']').attr('disabled', true);								
								
			});

            $('#table_id').find('a.ntf').hide();
            setSeleccionarDesemp(gradoDB, grupoDB, asignaturaDB, numPeriodo, databaseDB);

            $('#form-select').find('select').change(function (event) {



                $('#gradoDesempeno').change(function () {

                    $.ajax({
                        method: "POST",
                        url: "/Asignature/getAsignaturesByGrade/" + $(this).val(),
                        data: ''
                    })
                        .done(function (datos) {
                            $('#asignaturaDesempeno').empty().append(datos);
                        });

                });

                var asignaturaIndicadores = $('#asignaturaDesempeno').val();
                var gradosIndicadores = $('#gradoDesempeno').val();
                var periodoIndicadores = $('#periodosDesempeno').val();
                var categoriaIndicadores = $('#categoriaDesempeno').val();

                $.ajax({
                    method: "POST",
                    url: "/Performance/getIndicators/" + gradosIndicadores + "/" + asignaturaIndicadores + "/" + categoriaIndicadores + "/" + periodoIndicadores,
                    data: ''
                })
                    .done(function (datos) {

                        $('#tabla-contentt').empty().append(datos);
                        $('#table_id').DataTable({

                            paging: false,
                            "autoWidth": false,
                            "bFilter": true,

                            language: {
                                url: '/Public/json/Spanish.json'
                            }
                        });
						$('#item-posicion').find('th[data-estado="false"]').each(function (i, element) {
							
							codDesemp = $(element)[0].innerText;							
							if(codDesemp != '')
								$('#table_id').find('button[data-id='+codDesemp+']').attr('disabled', true);								
								
						});
                        setSeleccionarDesemp(gradoDB, grupoDB, asignaturaDB, numPeriodo, databaseDB);


                        //**************************************************************************
                        var desempenoGrado = $('#gradoDesempeno').val();

                        asignaturaIndicadores = asignaturaIndicadores=="-1"?asignaturaDB:asignaturaIndicadores;
                        gradosIndicadores = gradosIndicadores=="-1"?gradoDB:gradosIndicadores;
                        periodoIndicadores = periodoIndicadores=="-1"?$('#periodos').val():periodoIndicadores;


                        $('#gradoInsertar option').filter(function(){
                            //console.log( $(this).val());
                            return $(this).val() == gradosIndicadores;
                        }).prop('selected', true);

                        $.ajax({
                            method: "POST",
                            url: "/Area/getByGrade/" + gradosIndicadores,
                            data: ''
                        })
                            .done(function (datos) {
                                $('#AreaInsertar').empty().append(datos);


                                var asignaturaSeleccionado = $('#asignaturaDesempeno').val();

                                //Obtenemos el id area deacuerdo a la asignatura y grado
                                $.ajax({
                                    method: "POST",
                                    url: "/Performance/getIdAreaByIdAsignatura/" + asignaturaIndicadores+"/"+gradosIndicadores,
                                    data: ''
                                })
                                    .done(function (datos) {
                                        console.log(datos);
                                        var areaSeleccionado = datos;
                                        //Selecionamos  el area actual en el select
                                        $('#AreaInsertar option').filter(function(){
                                            //console.log( $(this).val());
                                            return $(this).val() == areaSeleccionado;

                                        }).prop('selected', true);

                                        //Traemos las asignaturas correspondiente al area
                                        $.ajax({
                                            method: "POST",
                                            url: "/Asignature/getByAreaAndGrade/" + areaSeleccionado + "/" + gradosIndicadores,
                                            data: ''
                                        })
                                            .done(function (datos) {
                                                $('#AsigInsertar').empty().append(datos);
                                                //Selecionamos  la asignatura actual en el select
                                                $('#AsigInsertar option').filter(function(){

                                                    //console.log( $(this).val());
                                                    return $(this).val() == asignaturaIndicadores;

                                                }).prop('selected', true);
                                            });
                                    });


                            });

                        var categoriaSeleccionado = $('#categoriaDesempeno').val();

                        //Selecionamos  la categoría actual en el select
                        $('#categoriaInsertar option').filter(function(){
                            //console.log( $(this).val());
                            return $(this).val() == categoriaSeleccionado;
                        }).prop('selected', true);

                        $('#periodoInsertar option').filter(function(){
                            //console.log( $(this).val());
                            return $(this).val() == periodoIndicadores;
                        }).prop('selected', true);
//***************************************************************************************

                    });

            });
        });


    //******************************************************

    var url = $('#url').val();
    var id_asignature = $('#asignaturaDB').val();
    var id_group = $('#grupoDB').val();




    //Selecciona un periodo
    $('#periodos').change(function () {

        if (this.value == 0) {

        }
        else {
            var periodoSeleccionado = this.value;
            $('#periodosDesempeno option').filter(function(){
                return $(this).val() == periodoSeleccionado;
            }).prop('selected', true);

            $('#periodoInsertar option').filter(function () {
                return $(this).val() == periodoSeleccionado;
            }).prop('selected', true);

            $('#gradoDesempeno').change(function () {
                $.ajax({
                    method: "POST",
                    url: "/Asignature/getAsignaturesByGrade/" + $(this).val(),
                    data: ''
                })
                    .done(function (datos) {
                        $('#asignaturaDesempeno').empty().append(datos);
                    });

            });

            //Carga los desempeños de acuerdo al periodo seleccionado
            var asignaturaIndicadores = $('#form-select').find('select[name=asignaturaSelect]').val();
            var gradosIndicadores = $('#form-select').find('select[name=gradoSelect]').val();
            var periodoIndicadores = $('#form-select').find('select[name=periodoSelect]').val();
            var categoriaIndicadores = $('#form-select').find('select[name=categoriaSelect]').val();

            $.ajax({
                method: "POST",
                url: "/Performance/getIndicators/" + gradosIndicadores + "/" + asignaturaIndicadores + "/" + categoriaIndicadores + "/" + periodoIndicadores,
                data: ''
            })
                .done(function (datos) {

                    $('#tabla-contentt').empty().append(datos);
                    $('#table_id').DataTable({

                        paging: false,
                        "autoWidth": false,
                        "bFilter": true,

                        language: {
                            url: '/Public/json/Spanish.json'
                        }
                    });
                    $('#item-posicion').find('th[data-estado="false"]').each(function (i, element) {

                        codDesemp = $(element)[0].innerText;
                        if(codDesemp != '')
                            $('#table_id').find('button[data-id='+codDesemp+']').attr('disabled', true);

                    });
                    setSeleccionarDesemp(gradoDB, grupoDB, asignaturaDB, numPeriodo, databaseDB);


                });


            //Fin carga desempeños periodo seleccionado


            /** Muestra fecha de apertura y cierre del periodo seleccionado*/
			$('#divFechasPeriodos div:not(.hidden)').addClass('hidden');
            $('#divFechasPeriodos #inputPeriodo_'+this.value).removeClass('hidden');
            $.ajax({
                type: "GET",
                url: '/Evaluation/evaluateGroupRender/' + this.value + '/' + id_asignature + '/' + id_group,

                //Success
                success: function (data) {
                    $('#contenedorTabla').empty().append(data);
                    $('#button-desempeno').attr('disabled', false);
                    $('#item-posicion').find('th[data-estado="false"]').each(function (i, element) {


                        //Se optienen todos los th con data-update que contiene las posiciones
                        //se envia una petición ajax con canda una de las posiciones, si existe
                        //se muestr en un th respectivo

                        //Carga la tabla
                        var pos = $(element).data('update');
                        var per = $('#periodos').val();
                        var grado = $('#gradoDB').val();

                        $.ajax({
                            method: "POST",
                            url: "/Performance/getCodesById/" + pos + "/" + id_group + '/' + id_asignature + '/' + per + '/' + grado,
                            data: ''
                        })
                            .done(function (datos) {

                                if(datos!=''){
                                    var obj_desemp = JSON.parse(datos);
                                    $(element).attr('data-toggle', 'tooltip');
                                    $(element).attr('title', obj_desemp.descripcion);
                                    $(element).append(obj_desemp.cod_desemp);
                                    $(element).append('<span class="delete-pos" data-toggle="tooltip" title="'+obj_desemp.descripcion+'" data-pos="' + pos + '" data-desemp="' + obj_desemp.cod_desemp + '" data-grup="' + id_group + '" data-asign="' +id_asignature+ '"> <i class="fa fa-trash" aria-hidden="true"></i></span>');
                                    $(element).addClass('pos-hover');
                                    $(element).find('.delete-pos')[0].addEventListener("click", posicionesClick);
                                }else{
                                    $(element).addClass('posiciones');
                                }
								

                            });

                    });	//Fin each

                    //Ya la tabla de calificaciones esta renderizadas, ahora se le va añadir diferentes eventos a los inputs
                    $('tr.editable').find('input').blur(function (ev) {

                        var idEstudiante = ev.currentTarget.dataset.id;
                        var desempeno = ev.currentTarget.dataset.desemp;
                        var inputsDesem = getInputsDesempeno(idEstudiante, desempeno);
                    })//Fin Blur
                        .focus(function () {
                            $('#content-control').removeClass('control-desp');
                            $('#content-control').addClass('aparecer');
                        })//Fin Focus
                        .focusout(function () {
                            $('#content-control').removeClass('aparecer');
                            $('#content-control').addClass('control-desp');
                        })
                        .keyup(function (ev) {

                            var idEstudiante = ev.currentTarget.dataset.id;
                            var desempeno = ev.currentTarget.dataset.desemp;
                            var idInput = ev.currentTarget.dataset.cont;
                            var inputDisabled = $("[data-cont="+idInput+"]");
                            var inputsDesem = getInputsDesempeno(idEstudiante, desempeno);
                            // console.log(ev.keyCode+" "+ev.which);

                            if (desempeno == 'dc' || desempeno == 'dt') {
                                ////console.log(desempeno);
                                if (desempeno == 'dt') {
                                    var promDT = promedio(inputsDesem, numMinimo, numMaximo);
                                    var efp = 0;
                                    efp = (porcentajePro * promDT).toFixed(2);
                                    var inputPorcentajeDC = getInputsDesempeno(idEstudiante, 'grupodc')[0];
                                    var inputdc = getInputsDesempeno(idEstudiante, 'dc');
                                    var prom = promedio(inputdc, numMinimo, numMaximo);
                                    var promDC = 0;
                                    var promDC = (porcentajeCog * prom).toFixed(2);
                                    var suma = parseFloat(efp) + parseFloat(promDC);
                                    ////console.log(suma);
                                    $('tr#' + idEstudiante).find('.epfInput').val(efp);
                                    inputPorcentajeDC.value = suma;


                                } else {
                                    var efp = 0;

                                    if ($('tr#' + idEstudiante).find('.epfInput').val() == undefined) {
                                        efp = 0;
                                    } else {
                                        efp = $('tr#' + idEstudiante).find('.epfInput').val();
                                    }


                                    var desempenoGrupo = 'grupodc';
                                    var inputPorcentajeDC = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                    var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                    ////console.log(efp); //parseFloat(efp)
                                    prom = (porcentajeCog * prom).toFixed(2);
                                    var suma = parseFloat(efp) + parseFloat(prom);
                                    inputPorcentajeDC.value = suma;
                                    $(inputPorcentajeDC).attr('data-m', 'true');
                                }

                            }

                            if (desempeno == 'dp') {
                                var desempenoGrupo = 'grupodp';
                                var inputPorcentajeDP = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                var prom = promedio(inputsDesem, numMinimo, numMaximo);


                                inputPorcentajeDP.value = (porcentajePer * prom).toFixed(2);
                                $(inputPorcentajeDP).attr('data-m', 'true');

                            }

                            if (desempeno == 'ds') {
                                var desempenoGrupo = 'grupods';
                                var inputPorcentajeDS = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];

                                var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                inputPorcentajeDS.value = (porcentajeSol * prom).toFixed(2);
                                $(inputPorcentajeDS).attr('data-m', 'true');
                            }

                            if (desempeno == 'da') {
                                var desempenoGrupo = 'grupoda';
                                var inputPorcentajeDA = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                inputPorcentajeDA.value = (porcentajeAe * prom).toFixed(2);
                                $(inputPorcentajeDA).attr('data-m', 'true');

                            }

                            if (desempeno == 'ep') {
                                var desempenoGrupo = 'grupoep';
                                var inputPorcentajeDA = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                inputPorcentajeDA.value = (porcentaje_ep * prom).toFixed(2);
                                $(inputPorcentajeDA).attr('data-m', 'true');
                            }

                            if (desempeno == 'ex') {
                                var desempenoGrupo = 'grupoex';
                                var inputPorcentajeDA = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                inputPorcentajeDA.value = (porcentaje_ex * prom).toFixed(2);
                                $(inputPorcentajeDA).attr('data-m', 'true');
                            }

                            if (desempeno == 'tt') {
                                var desempenoGrupo = 'grupott';
                                var inputPorcentajeDA = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                inputPorcentajeDA.value = (porcentaje_tt * prom).toFixed(2);
                                $(inputPorcentajeDA).attr('data-m', 'true');
                            }

                            if (desempeno == 'pz') {
                                var desempenoGrupo = 'grupopz';
                                var inputPorcentajeDA = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                inputPorcentajeDA.value = (porcentaje_par * prom).toFixed(2);
                                $(inputPorcentajeDA).attr('data-m', 'true');
                            }
                            if (desempeno == 'ad') {
                                var desempenoGrupo = 'grupoad';
                                var inputPorcentajeDA = getInputsDesempeno(idEstudiante, desempenoGrupo)[0];
                                var prom = promedio(inputsDesem, numMinimo, numMaximo);
                                inputPorcentajeDA.value = (porcentaje_ad * prom).toFixed(2);
                                $(inputPorcentajeDA).attr('data-m', 'true');
                            }

                            var inputListas = getInputsLista(idEstudiante, 'lista')
                            var sumaValores = 0;

                            inputListas.each(function (i, element) {
                                if (element.value != '') {
                                    sumaValores += parseFloat(element.value);
                                }
                            });


                            var periodo = sumaValores.toFixed(2);
                            var desempenoPeriodo = 'periodo';

                            var inputPeriodo = getInputsDesempeno(idEstudiante, desempenoPeriodo)[0];

                            if (inputPeriodo) {
                                inputPeriodo.value = periodo;
                            }

                            var inputsAModificar = $('tr[id=' + idEstudiante + ']').find('input');

                            var stringCadena = '';

                            inputsAModificar.each(function (i, element) {

                              //console.log(element.value.length);
								if(element.value.length != 0 && element.value != null && element.value != "0" && element.value != "0.00" ){
													stringCadena += element.name + ":'" + element.value + "',";
								 }
                            });

                            stringCadena = "{" + stringCadena + "}";
                            var periodoSelect = $('#periodos').val();



                            //Si el periodo seleccionado esta áctivo guarda por ajax cada una de las modificaciones en los inputs
                            if (numPeriodo) {

                                if (periodoSelect == numPeriodo) {
                                    var json = JSON.stringify(eval("(" + stringCadena + ")"));
                                    var obj = JSON.parse(json);
                                    

									if(stringCadena != ''){
                                    if(ev.keyCode != 8 || ev.keyCode != 46 || ev.keyCode != 110){
		                                $.ajax({
		                                    method: "POST",
		                                    url: "/Evaluation/updateAll",
		                                    data: {
		                                    	obj,
		                                    	idEstudiante,
		                                    	asignaturaDB,
                                                grupoDB,
                                                groupType
		                                    	
		                                    },
		                                    beforeSend: function(xhr){
		                                    	//inputDisabled.prop('disabled', true);
		                                    }
		                                })
		                                    .done(function (data) {
		                                    	//inputDisabled.prop('disabled', false);
		                                    	// console.log(data);
		                                    });
		                            }
								}
                                }
                                else {

                                    swal({
                                        title: "Periodo seleccionado inactivo!",
                                        text: "No se puede modificar..!",
                                        timer: 4000,
                                        showConfirmButton: false
                                    });
                                }

                            }
                            else {
                                
                                swal({
                                    title: "Periodo seleccionado inactivo!",
                                    text: "No se puede modificar..!",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }

                        })//Fin Keyup*************
                        .keydown(function (ev) {
                            var numRegistro = parseInt($('#numRegistro').val());
                            var numInputs = parseInt($('#numInputs').val());
                            var posicionInput = parseInt(numInputs / numRegistro) + 1;

                            var aba = 40;
                            var arri = 38;
                            var izq = 37;
                            var der = 39;

                            if ((ev.keyCode == aba || ev.which == aba)) {

                                var cont = ev.currentTarget.dataset.cont;

                                cont = parseInt(cont);

                                var de = $('input[data-cont=' + (cont + posicionInput) + ']');
                                console.log(posicionInput);
                                if (de) {
                                    de.focus();
                                }
                                ev.preventDefault();
                            }

                            if ((ev.keyCode == arri || ev.which == arri)) {
                                var cont = ev.currentTarget.dataset.cont;
                                cont = parseInt(cont)
                                var de = $('input[data-cont=' + (cont - posicionInput) + ']');
                                if (de) {
                                    de.focus();
                                }
                                ev.preventDefault();
                            }

                            if ((ev.keyCode == izq || ev.which == izq)) {
                                var cont = ev.currentTarget.dataset.cont;
                                cont = parseInt(cont)
                                var de = $('input[data-cont=' + (cont - 1) + ']');
                                if (de) {
                                    de.focus();
                                }
                                ev.preventDefault();
                            }

                            if ((ev.keyCode == der || ev.which == der)) {
                                var cont = ev.currentTarget.dataset.cont;
                                cont = parseInt(cont)
                                var de = $('input[data-cont=' + (cont + 1) + ']');
                                if (de) {
                                    de.focus();
                                }
                                ev.preventDefault();
                            }


                        });//Fin de Keydown

					// FUNCIONALIDAD PARA AGREGAR OBSERVACIONES A LAS ASIGNATURAS
                    // OBSERVACIONES DE ASIGNATURA
                    var modalAddObs = $("#modalAggObs"),
                        period = $("#periodos").val(),
                        backModal   =   $("#backModal"),
                        inputTargetView = $("#targerView"),
                        input_id_student = $("#id_student");
                        // id_asignature = $("#id_asignature").val();
                    // CARGAR LA VISTA QUE CONTIEN LA TABLA
                    var loadTable = function(){

                        backModal.attr(
                            'data-id',
                            input_id_student.val()
                        );

                        var url = "/Asignature/indexObservations/"+input_id_student.val()+"/"+id_asignature+"/"+period;

                        $.get(url, function(data){
                            modalAddObs.find('.modal-body').empty().append(data)
                        });
                    }

                    // MOSTRAR EL MODAL Y CARGAR LA TABLA
                    $('[data-click="aggObsAsig"]').click(function(e){

                        e.preventDefault();

                        var that = $(this),
                            request = that.data('request');

                        input_id_student.val( that.data('id') );

                        modalAddObs.find("#myModalLabel").text(that.attr('data-student'));

                        if(request == 'openModal'){

                            modalAddObs.modal({
                                show: true,
                                backdrop: 'static',
                                keyboard: false
                            })

                        }

                        if(!backModal.hasClass('hide'))
                            backModal.addClass('hide');

                        loadTable();
                    })

                    // Eliminar Observacion
                    $("#deleteObservationAsig").submit(function(e){
                        e.preventDefault();

                        var form = $(this),
                            btnSubmit = form.find("button[type=submit]"),
                            btnCancel = $("#subModalCance");

                        $.ajax({
                            type: form.attr('method'),
                            url: form.attr('action'),
                            dataType: 'html',
                            data: form.serialize(),
                            beforeSend: function(){

                                btnSubmit.text('');
                                btnSubmit.append(
                                    $('<i>', {class: 'fa fa-spinner fa-spin fa-fw'}),
                                    $('<span>Eliminando...</span>')
                                );
                                form.find("button").prop('disabled', true);
                            },
                            success: function(data){
                                
                                btnSubmit.empty().text("Eliminar");
                                form.find("button").prop('disabled', false);
                                
                                // 
                                btnCancel.click();
                                
                                // 
                                loadTable();
                            },
                            error(xhr, estado){
                                console.log(xhr);
                                console.log(estado);
                            }
                        });
                    });

                    // FIN FUNCIONALIDAD PARA LAS OBSERVACIONES
                }//**Fin Success

            })//Fin ajax #periodo else

        }//Fin else

    });//Fin select change periodo




});




function posicionesClick(ev){
	var position = this.dataset.pos;
	var id_group = this.dataset.grup;
	var id_asignature = this.dataset.asign;
	var id_performance = this.dataset.desemp;
	var period = $('#periodos').val();
	var databaseDB = $('#databaseDB').val();

	$.ajax({
		method: "POST",
		url: "/Performance/deleteRelation/",
		data: {
			position,
			id_group,
			id_asignature,
			id_performance,
			period
		}
	})
	.done(function(datos) {
		$('#item-posicion').find('th[data-update='+position+']').empty()
		.addClass('posiciones');
		$('#table_id').find('button[data-id='+id_performance+']').attr('disabled', false);

	});
}

function setSeleccionarDesemp(idGrado, idGrupo, idAsig, periodo, database){

	$('#table_id').find('button[data-fun=seleccionar]').each(function(i,element){
		element.addEventListener('click', function(ev){

			$(this).attr('disabled', true);
			var per = $('#periodos').val();
			var categoriaIndicadores = $('#form-select').find('select[name=categoriaSelect]').val();

			var array = Array();
			let elth;
			$('#item-posicion').find('.posiciones[data-tipo='+categoriaIndicadores+'] ').each(function(i,element){
				array[i] = $(element).data('update');
				if(i==0){elth = element;}
			});

			if(array.length > 0)
			{
				var pos = array[0];
				var desem = ev.currentTarget.dataset.id;

				var dataString = 'grado='+ idGrado + '&grupo='+ idGrupo + '&asignatura='+ idAsig + '&periodo='+ per + '&posicion='+ pos+ '&cod_desemp='+ desem;
				$.ajax({
					method: "POST",
					url: "/Performance/storeRelation/",
					data: dataString
				})
				.done(function(datos) {

					if(datos!='') {
                        var obj_desemp = JSON.parse(datos);
                        $(elth).attr('data-toggle', 'tooltip');
                        $(elth).attr('title', obj_desemp.descripcion);
                        $(elth).append(obj_desemp.cod_desemp);
                        $(elth).removeClass('posiciones');
                        $(elth).append('<span class="delete-pos" data-toggle="tooltip" title="' + obj_desemp.descripcion + '" data-pos="'+pos+'" data-desemp="'+desem+'" data-grup="'+idGrupo+'" data-asign="'+idAsig+'"> <i class="fa fa-trash" aria-hidden="true"></i></span>');
                        $(elth).addClass('pos-hover');
                        $(elth).find('.delete-pos')[0].addEventListener("click", posicionesClick);
                    }



				});

			}
		});
	});

	$("body").on( "click", function() {
		$("body").css('padding-right','10px');
	});
}


function getInputsDesempeno(idEstudiante, desempeno){
	var inputsDesem = $('tr[id='+idEstudiante+']').find('input[data-desemp='+desempeno+']');	 
	return inputsDesem;
}

function getInputsLista(idEstudiante, lista){
	var inputsDesem = $('tr[id='+idEstudiante+']').find('input[data-grupo='+lista+']');	 	
	return inputsDesem;
}



function promedio(objetosInputs, valorMinimo, valorMaximo){
    var contador = 0;
    var suma = 0;
    objetosInputs.each(function(i,element){
        if(element.value.length > 0){

            if(parseFloat(element.value)>= valorMinimo && element.value <= valorMaximo){
                contador++;
                suma += parseFloat(element.value.replace(',','.').replace(' ',''));
                $(element).attr('data-m', 'true');
                $(element).removeClass('error');
            }else{
                $(element).attr('data-m', 'false');
                $(element).addClass('error');
                $(element).val('');
            }
        }
        if(element.value.length == 0){
            $(element).removeClass('error');
            $(element).val('');
        }
    });
    return contador>0?(suma/contador).toFixed(2):0;
}