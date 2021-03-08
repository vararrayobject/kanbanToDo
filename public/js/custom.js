$(".add-new-button").on('click', function () {
    let statusName = $(this).data('status-name')
    showInput(statusName)
    $(this).hide()
    $("#" + statusName).show()
})
let updateTaskId
let updateColorId
let color_id
let updatedColor
let updateDesc

$("ul").on('click', 'li.list-item', function () {
    console.log('start_id', $(this).data('color-id'))
    $('#myModal').modal('toggle')
    updateTaskId = $(this).data('task-id')
    updateDesc = $(this).data('desc').trim()
    color_id = $(this).data('color-id')
    updatedColor = $(this).data('color')
    $('.update-task').prop({
        'data-task-desc': updateDesc,
        'data-task-color': color_id,
    })
    $("#myModal textarea").val(updateDesc)

    choseColorPalette(color_id)
})

$('.update-task').on('click', function () {
    let updateTaskStatus = $(this).data('status-id')

    $.ajax({
        url: "items/" + updateTaskId,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content'),
        },
        data: {
            task_id: updateTaskId,
            color_id: updateColorId,
            desc: $('#updateDesc').val(),
        },
        success: function (response) {
            $('#task-' + updateTaskId).prop({
                'data-color-id': updateColorId,
                'style': "background: " + updatedColor + " !important;  border-radius: 10px !important;",
            })
            $('#task-' + updateTaskId).html(response.desc.trim() + `<span class="close float-right"><img
            src="/assets/img/Delete.svg" /></span>`)
            $('#task-' + updateTaskId).prop('data-color-id', updateColorId)

            $(this).prev().val($('#updateDesc').val())
            $('#myModal').modal('toggle')
        },
    });
})

$('.color-palette').on('click', function () {
    $('.update-task').prop('data-task-color', $(this).data('color-id'))
    updateColorId = $(this).data('color-id')
    updatedColor = $(this).data('color')
    choseColorPalette($(this).data('color-id'))
})

function choseColorPalette(id) {
    console.log('color-id', id)
    $('.color-palette').html('')
    $("#color-palette-" + id).html(`<span><img src="/assets/img/check.svg" /></span>`)
}

$(".task-add").on('click', function () {
    let addnewTaskStatus = $(this).data('status-id')
    let desc = $(this).prev().val()
    showButton()
    $.ajax({
        url: "items",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
        },
        data: {
            status_id: addnewTaskStatus,
            desc: desc,
        },
        success: function (response) {
            let list = `
                <li class="list-item mb-3 p-2" id="task-` + response.id + `" data-task-id="` + response.id + `"
                    data-color-id="` + response.color.id + `" data-desc="` + response.desc + `"
                    style="background-color:` + response.color.color + ` !important; border-radius: 10px !important;">
                    ` + response.desc + `
                    <span class="close float-right"><img
                            src="/assets/img/Delete.svg" /></span>
                </li>
            `
            $("#sort-" + response.status.name).append(list)
        },
    });
})

$(".cancel").on('click', function () {
    showButton()
})

function showInput(statusName) {
    showButton()
    $("#" + statusName).show()
}

function showButton() {
    $(".task-input").hide()
    $(".add-new-button").show()
}

$(function () {
    var url = 'update-status';
    $('ul[id^="sort"]').sortable({
        forcePlaceholderSize: true,
        dropOnEmpty: true,
        connectWith: ".sortable",
        opacity: 0.5,
        stop: function (e, ui) {
            list = []
            var status_id = $(ui.item).parent(".sortable").data(
                "status-id");
            var task_id = $(ui.item).data("task-id");
            $("#" + $(ui.item).parent(".sortable").prop('id') + " li").each(function (index) {
                list[index] = $(this).data('task-id');
            });
            $.ajax({
                url: "update-status",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
                },
                data: {
                    status_id: status_id,
                    task_id: task_id,
                    list: list,
                },
                success: function (response) {}
            });
        },
    }).disableSelection();
});
