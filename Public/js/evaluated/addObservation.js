$(function(){

    var modal = $("#modalAggObs"),
    period = <?= $p ?>,
    backModal   =   $("#backModal"),
    inputTargetView = $("#targerView"),
    input_id_student = $("#id_student");

    var pathView,
    id_asignature = $("#id_asignature").val();

    // CARGAR LA VISTA QUE CONTIEN LA TABLA
    var loadTable = function(){

        backModal.attr(
            'data-id',
            input_id_student.val()
            );

        var url = "/Asignature/indexObservations/"+input_id_student.val()+"/"+id_asignature+"/"+period;

        $.get(url, function(data){
            modal.find('.modal-body').empty().append(data)
        });
    }

    // MOSTRAR EL MODAL Y CARGAR LA TABLA
    $('[data-click="aggObsAsig"]').click(function(e){

        e.preventDefault();

        var that = $(this),
        request = that.data('request');

        input_id_student.val( that.data('id') );

        modal.find("#myModalLabel").text(that.attr('data-student'));

        if(request == 'openModal'){

            modal.modal({
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
});