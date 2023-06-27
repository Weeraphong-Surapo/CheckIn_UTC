$('#find_report').change((e) => {
    $('#formFind').submit()
})

$('.checkin').click(function() {
    let id = $(this).attr('data-id')
    let date_id = $(this).attr('date-id')
    let attr_ = $(this).is(':checked')
    if (attr_) {
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: {
                id: id,
                date_id:date_id,
                updateCheck: 1
            },
            success: function(res) {
            }
        })
    } else {
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: {
                id: id,
                date_id:date_id,
                updateCheck: 1,
                update: 1
            },
            success: function(res) {
            }
        })
    }
})


