function insertTitle() {
    $('p').empty()
    $('#formTitle')[0].reset()
    $('#ModalTitle').modal('show')
}



$('#formTitle').submit(function (e) {
    e.preventDefault();
    $('#error-title').css('color', 'red')
    let fd = new FormData();
    let title = $('#title').val();
    let id = $('#id_title').val();
    if (title == "") {
        $('#error-title').text('กรุณากรอกคำนำหน้า')
    } else if (!isNaN(title)) {
        $('#error-title').text('กรุณากรอกข้อมูลเป็นตัวอักษร')
    } else {
        $('#error-title').empty()
        fd.append('title', title)
        fd.append('id',id)
        fd.append('addTitle',1)
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: fd,
            async: false,
            contentType: false,
            processData: false,
            error: function (xhr, textStatus) {
                alert(textStatus)
            },
            success: function (res) {
                $('#formTitle')[0].reset()
                alertsuccess('success','บันทึกสำเร็จ','')
                setTimeout(() => {
                    location.reload()
                }, 1000);
            }
        })
    }
})

$('button#del-title').click(function () {
    let id = $(this).attr('data-id')
    let title = $(this).attr('data-name')
    Swal.fire({
        title: 'คุณต้องการลบ ' + title + ' ใช่ไหม?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText:'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    deltitle: 1
                },
                error: function (xhr, textStatus) {
                    alertError()
                },
                success: function (res) {
                    alertsuccess('success', 'ลบข้อมูลสำเร็จ', '')
                    setTimeout(function () { location.reload() }, 1000)
                }
            })
        }
    })
})

$('button#edit-title').click(function () {
    let id = $(this).attr('data-id')
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        dataType:'json',
        data: {
            id: id,
            editTitle:1
        },
        error: function (xhr, textStatus) { alert(textStatus) },
        success: function (res) {
            $('#id_title').val(res.id)
            $('#title').val(res.title)
            $('#ModalTitle').modal('show')
        }
    })
})