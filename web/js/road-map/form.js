$(document).ready(function() {

    $('#projectsteps-docs1').change(function (e) {
        $('#docsDiv1New').html('');
        idsrt = '';
        var files = $('#projectsteps-docs1').prop("files");
        var t = 0;
        $.map(files, function (val) {
            idsrt = idsrt + ' <span class="create-step-form-file" id="pdl1_' + t + '">' + val.name + '<i class="fas fa-trash-alt" aria-hidden="true" onclick="deletefiletemp1(' + t + ')"></i></span><br>';
            t++;
        });
        $('#docsDiv1New').html(idsrt);
    });

    $('#projectsteps-docs2').change(function (e) {
        $('#docsDiv2New').html('');
        idsrt = '';
        var files = $('#projectsteps-docs2').prop("files");
        var t = 0;
        $.map(files, function (val) {
            idsrt = idsrt + ' <span class="create-step-form-file" id="pdl2_' + t + '">' + val.name + '<i class="fas fa-trash-alt" aria-hidden="true" onclick="deletefiletemp2(' + t + ')"></i></span><br>';
            t++;
        });
        $('#docsDiv2New').html(idsrt);
    });
});


function deletefiletemp1(id) {
    files = $('#projectsteps-docs1').prop("files");

    for(var i = 0; i < files.length; i++) {
        if(i == id) {
            newList = i  +', ';
        }
    }
    $('#pdl1_'+id).toggle();
    $('#deldocs1').val($('#deldocs1').val() + newList);
}

function deletefiletemp2(id) {
    files = $('#projectsteps-docs2').prop("files");

    for(var i = 0; i < files.length; i++) {
        if(i == id) {
            newList = i  +', ';
        }
    }
    $('#pdl2_'+id).toggle();
    $('#deldocs2').val($('#deldocs2').val() + newList);
}

$('#iflose').click(function () {
    if ($(this).prop('checked')) {
        $('#projectsteps-lose_id').removeAttr('disabled');
    }
    else {
        $('#projectsteps-lose_id').attr('disabled', true);
    }
});


$('#ifwin').click(function () {
    if ($(this).prop('checked')) {
        $('#projectsteps-win_id').removeAttr('disabled');
    }
    else {
        $('#projectsteps-win_id').attr('disabled', true);
    }
});

function deleteIssetFile(id) {
    $.ajax({
        type: 'GET',
        url: "/project-step/delete-doc",
        data: {id: id},
        async: false,
        success: function () {
            $("#isset-doc-"+id).toggle();
        }
    });
}

function deleteTemplateFile(id) {
    console.log('this');
    $('#template-doc-wrapper-'+id).remove();
}

function applyTemplate(ui) {
    $.ajax({
        type: "GET",
        url: "/project-step/get-template-docs",
        data: {id: ui.item.id},
        async: false,
        success: function (data) {
            console.log(data);
            var docs1 = "";
            $.each(data.docs1, function (index, value) {
                console.log("index: " + index + " value: " + value.name);
                docs1 = docs1 + '<div id="template-doc-wrapper-'+value.id+'"> <input type="hidden" name="ProjectSteps[template_docs1]['+value.id+']" value="'+value.id+'"> <span id="template-doc-'+value.id+'" class="create-step-form-file">'+value.name +'.'+value.extension+'<i class="fas fa-trash-alt" aria-hidden="true" onclick="deleteTemplateFile('+value.id+')"></i></span></div>';
            });
            $('#docsTemplateDiv1New').html(docs1);

            var docs2 = "";
            $.each(data.docs2, function (index, value) {
                console.log("index: " + index + " value: " + value.name);
                docs2 = docs2 + '<div id="template-doc-wrapper-'+value.id+'"> <input type="hidden" name="ProjectSteps[template_docs2]['+value.id+']" value="'+value.id+'"> <span id="template-doc-'+value.id+'" class="create-step-form-file">'+value.name +'.'+value.extension+'<i class="fas fa-trash-alt" aria-hidden="true" onclick="deleteTemplateFile('+value.id+')"></i></span></div>';
            });
            $('#docsTemplateDiv2New').html(docs2);
        }
    });
}