$(".add-new-button").on('click', function () {
    let statusName = $(this).data('status-name')
    showInput(statusName)
    $(this).hide()
    $("#" + statusName).show()
})

$(".list-item").on('click', function () {
    $('#myModal').modal('toggle')
    let updateTaskId = $(this).data('task-id')
    let updateDesc = $(this).html().trim()
    let color_id = $(this).data('color-id')
    $('.update-task').attr(
    {
        'data-task-id': updateTaskId,
        'data-task-desc': updateDesc,
        'data-task-color': color_id,
    })
    $('.update-task').attr('data-task-id', updateTaskId)
    console.log(updateTaskId, updateDesc, 'updateDesc')
    $("#myModal textarea").val(updateDesc)
    choseColorPalette(color_id)
    // $(".color-palette").html(`<span><img src="/assets/img/check.svg" /></span>`)
})

$('.update-task').on('click', function () {
    let addnewTaskStatus = $(this).data('status-id')
    let desc = $(this).prev().val()
    $.ajax({
        url: "items/" + $(this).data('task-id'),
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'method': 'put',
        },
        data: {
            task_id: $(this).data('task-id'),
            color_id: $(this).data('task-color'),
            desc: $(this).data('task-desc'),
        },
        success: function (response) {
            let list = `
                <li class="card mb-3 p-2" data-task-id="` + response.id + `"
                    style="background-color:` + response.color.color + ` !important">
                    ` + response.desc + `
                </li>
            `
            $("#sort-" + response.status.name).append(list)
        },
    });
})

function choseColorPalette(id) {
    $('.color-palette').html('')
    $("#color-palette-" + id).html(`<span><img src="/assets/img/check.svg" /></span>`)
}

$(".task-add").on('click', function () {
    let addnewTaskStatus = $(this).data('status-id')
    let desc = $(this).prev().val()
    showButton()
    console.log(desc, addnewTaskStatus)
    $.ajax({
        url: "items",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            status_id: addnewTaskStatus,
            desc: desc,
        },
        success: function (response) {
            let list = `
                <li class="card mb-3 p-2" data-task-id="` + response.id + `"
                    style="background-color:` + response.color.color + ` !important">
                    ` + response.desc + `
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
            console.log('e, ui', ui)
            var status_id = $(ui.item).parent(".sortable").data(
                "status-id");
            var task_id = $(ui.item).data("task-id");
            $("#" + $(ui.item).parent(".sortable").attr('id') + " li").each(function (index) {
                list[index] = $(this).data('task-id');
            });
            $.ajax({
                url: "update-status",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
