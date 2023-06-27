function insertlavel() {
    $('#formLavel')[0].reset();
    $('#ModalLavel').modal('show');
}

$('#formLavel').submit(function (e) {
    e.preventDefault();
    $('p').css('color', 'red')
    let fd = new FormData();
    let lavel = $('#lavel').val()
    let id = $('#id').val()

    if (lavel == "") {
        $('#error-lavel').text('กรุณากรอกชื่อระดับชั้น')
    } else {
        fd.append('lavel', lavel)
        fd.append('addLavel', 1)
        fd.append('id',id)
        $('p').empty()
        $.ajax({
            url: 'function/action.php',
            type: 'POST',
            async: false,
            contentType: false,
            processData: false,
            data: fd,
            success: function (res) {
                alertsuccess('success', 'บันทึกสำเร็จ', '')
                setTimeout(() => {
                    location.reload()
                }, 600);
            }
        });
    }
});

$('button#del-lavel').click(function () {
    let id = $(this).attr('data-id')
    Swal.fire({
        title: 'คุณต้องการลบใช่ไหม?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    delLavel: 1
                },
                success: function (res) {
                    alertsuccess('success', 'ลบข้อมูลสำเร็จ', '')
                    setTimeout(function(){location.reload()},700)
                }
            });
        }
    });
});

$('button#edit-lavel').click(function () {
    let lavel = $(this).attr('data-id')
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        dataType:'json',
        data: {
            lavel: lavel,
            showLavel:1
        },
        success: function (res) {
            $('#id').val(res.id)
            $('#lavel').val(res.lavel)
            $('#ModalLavel').modal('show')
        }
    })
})