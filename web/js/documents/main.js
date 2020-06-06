/* jslint node: true */

"use strict";

//Свернуть/развернуть папку
$('.js-documents-page-wrapper').on('click', '.js-documents-folder', function () {
    $('.documents-wrapper-folder[data-id-folder='+$(this).getIdFolder()+']').toggle();
});

//Показать/скрыть контролы создания папки
$('.js-documents-page-wrapper').on('click', '.js-documents-add-folder', function () {
    $('.js-documents-create-folder[data-id-folder='+ $(this).getIdFolder() +']').toggle();
});

//Показать/скрыть контролы редактирования папки
$('.js-documents-page-wrapper').on('click', '.js-documents-update-folder', function () {
    $('.js-documents-edit-folder[data-id-folder='+ $(this).getIdFolder() +']').toggle();
});

//Показать/скрыть контролы добавления файла
$('.js-documents-page-wrapper').on('click', '.js-documents-add-file', function () {
    $('.js-documents-form-file-wrapper[data-id-folder='+ $(this).getIdFolder() +']').toggle();
});

//Показать/скрыть контролы редактирования файла
$('.js-documents-page-wrapper').on('click', '.js-documents-edit-file', function () {
    $('.js-documents-edit-file-input[data-id-file='+ $(this).getIdFile() +']').toggle();
});

//Загрузка файла
$('.js-documents-page-wrapper').on('submit', 'form.js-documents-form-file', function () {
    var idFolder = $(this).getIdFolder();
    var fd = new FormData();
    var files = $('.js-documents-input-add-file[data-id-folder='+ idFolder +']')[0].files[0];
    fd.append('Documents[file]', files);
    fd.append('Documents[folder_id]', idFolder);

    $.ajax({
        method: 'post',
        url: '/documents/document-upload',
        data: fd,
        processData: false,
        contentType: false,
        success: function() {
            $.pjax.reload({container: '#documents', timeout: 3000});
        },
        error: function (data) {
            if (data.status !== 400) alert('Произошла ошибка при загрузке файла');
            else {
                $('.js-documents-form-file[data-id-folder='+ idFolder +']').addClass('has-error');
                $('.js-documents-form-file[data-id-folder='+ idFolder +']').find('.help-block').html('<ul></ul>');
                $('.js-documents-form-file[data-id-folder='+ idFolder +']').find('.help-block').html('<ul>');
                for (var attribute in data.responseJSON.message) {
                    for (var index in data.responseJSON.message[attribute]) {
                        $('.js-documents-form-file[data-id-folder='+ idFolder +']').find('.help-block > ul').append('<li>' + data.responseJSON.message[attribute][index] + '</li>');
                    }
                }
            }
        }
    });

    return false;
});

//Редактировать имя файла
$('.js-documents-page-wrapper').on('click', '.js-documents-btn-edit-file', function () {
    var idFile = $(this).getIdFile();
    var nameFile = $('.js-documents-name-file[data-id-file='+idFile+']').val();
    $.ajax({
        method: 'post',
        url: '/documents/edit?object=Documents',
        data: {'Documents': {'id': idFile, 'name': nameFile}},
        success: function() {
            $.pjax.reload({container: '#documents', timeout: 3000});
        },
        error: function () {
            alert('Произошла ошибка при редактировании файла');
        }
    });
});


//Создать папку
$('.js-documents-page-wrapper').on('click', '.js-documents-btn-create-folder', function () {
    var idFolder = $(this).getIdFolder();
    var projectId = $('#documents-by-project').data('project-id');
    var nameFolder = $('.js-documents-name-new-folder[data-id-folder='+idFolder+']').val();
    $.ajax({
        method: 'post',
        url: '/documents/create-folder',
        data: {'DocumentsFolders': {'parent_folder_id': idFolder, 'project_id': projectId, 'name': nameFolder}},
        success: function() {
            $.pjax.reload({container: '#documents', timeout: 3000});
        },
        error: function () {
            alert('Произошла ошибка при создании папки');
        }
    });
});

//Редактировать папку
$('.js-documents-page-wrapper').on('click', '.js-documents-btn-edit-folder', function () {
    var idFolder = $(this).getIdFolder();
    var nameFolder = $('.js-documents-name-folder[data-id-folder='+idFolder+']').val();
    $.ajax({
        method: 'post',
        url: '/documents/edit?object=DocumentsFolders',
        data: {'DocumentsFolders': {'id': idFolder, 'name': nameFolder}},
        success: function() {
            $.pjax.reload({container: '#documents', timeout: 3000});
        },
        error: function () {
            alert('Произошла ошибка при редактировании папки');
        }
    });
});

//Удалить папку
$('.js-documents-page-wrapper').on('click', '.js-documents-delete-folder', function () {
    if (confirm('Удалить папку и все ее содержимое?')) {
        var idFolder = $(this).getIdFolder();
        $.ajax({
            method: 'post',
            url: '/documents/delete?object=DocumentsFolders',
            data: {'DocumentsFolders': {'id': idFolder}},
            success: function () {
                $.pjax.reload({container: '#documents', timeout: 3000});
            },
            error: function () {
                alert('Произошла ошибка при удалении папки');
            }
        });
    }
});

//Удалить файл
$('.js-documents-page-wrapper').on('click', '.js-documents-delete-file', function () {
    if (confirm('Удалить документ?')) {
        var idFile = $(this).getIdFile();
        $.ajax({
            method: 'post',
            url: '/documents/delete?object=Documents',
            data: {'Documents': {'id': idFile}},
            success: function () {
                $.pjax.reload({container: '#documents', timeout: 3000});
            },
            error: function () {
                alert('Произошла ошибка при удалении документа');
            }
        });
    }
});

//Предпросмотр файла
$('.js-documents-page-wrapper').on('click', '.js-documents-preview', function () {
    console.log('this');
    var pathToFile = $(this).data('href');
    $('#js-documents-modal-preview').modal('show');
    $('#js-documents-modal-preview').find('.modal-dialog').css('height', '830px');
    $('#js-documents-modal-preview').find('.modal-dialog').css('width', '830px');
    $('#js-documents-modal-preview').find('.modal-body').html('<embed style="width: 800px; height: 800px" src="'+$(this).data('href')+'">');
});

//Вспомогающий метод для получения id папки
$.fn.getIdFolder = function () {
    return this.data('id-folder');
}

//Вспомогающий метод для получения id файла
$.fn.getIdFile = function () {
    return this.data('id-file');
}

//Всплывающие подсказки по файлу
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})