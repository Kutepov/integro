$(document).ready(function() {
    $("#lightgallery").lightGallery({
        selector: '.lightbox',
        thumbnail:true,
    });
});

$("document").ready(function(){
    $("#form-pjax").on("pjax:end", function() {
        $.pjax.reload({container:"#gallery"});
    });
});

$('body').on('click', '.js-edit-item', function () {
    $(this).closest('.information-block').addClass('hidden');
    $(this).closest('.item').find('.update-block').removeClass('hidden');
});

$('body').on('click', '.js-confirm-edit-item', function () {
    var id = $(this).attr('data-id');
    var title = $(this).prev('.form-control').val();
    if (!title) {
        alert('Заполните имя');
        return false;
    }

    $.ajax({
        method: 'post',
        url: "/gallery/edit",
        data: {'Gallery': {'id': id, 'title': title}},
        success: function() {
            $.pjax.reload({container:"#gallery", timeout: 3000});
        },
        error: function () {
            alert('Ошибка редактирования');
        }
    });
});

$('body').on('click', '.js-delete-item', function () {

    var isConfirm = confirm("Удалить этот элемент?");
    var id = $(this).attr('data-id');

    if (isConfirm) {
        $.ajax({
            method: 'post',
            data: {'Gallery': {'id': id}},
            url: "/gallery/delete",
            success: function () {
                $.pjax.reload({container: "#gallery", timeout: 3000});
            },
            error: function () {
                alert('Ошибка удаления');
            }
        });
    }
});
