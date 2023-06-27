
function insertDepartment() {
    $(function () {
        $('#department').val('')
        $('#id_edit').val('')
        $('#error').empty()
        $('#ModalDepartment').modal('show')
    })
}

// $(function () {
$('#insertDepartment').click(function () {
    let department = $('#department').val()
    let id_edit = $('#id_edit').val()
    if (!isNaN(department) && $('#department').val() != "") {
        $('#error').text('ไม่สามารถขึ้นต้นด้วยตัวเลขใด้')
    } else if (department == "") {
        $('#error').text('กรุณากรอกข้อมูลด้วย')
    } else {
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: {
                department: department,
                id_edit:id_edit,
                insertDepartment: 1
            },
            error: function (xhr, textStatus) {
                alertError()
            },
            success: function (res) {
                alertsuccess('success', 'บันทึกสำเร็จ', '')
                setTimeout(()=>{location.reload()},900)
            }
        })
    }
})
// })
$('#department').keyup(function () {
    if (!isNaN($('#department').val()) && $('#department').val() != "") {
        $('#error').text('ไม่สามารถขึ้นต้นด้วยตัวเลขใด้')
    } else {
        $('#error').empty()
    }
})


$('button#del-department').click(function () {
    let id = $(this).attr('data-id')
    let name = $(this).attr('data-name')
    Swal.fire({
        title: 'คุณต้องการลบ ' + name + ' ใช่ไหม?',
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
                    delDepartment: 1
                },
                error: function (xhr, textStatus) {
                    alertError()
                },
                success: function (res) {
                    alertsuccess('success', 'ลบข้อมูลสำเร็จ', '')
                    setTimeout(()=>{location.reload()},900)
                }
            })
        }
    })
})

$('button#edit-department').click(function () {
    $('#error').empty()
    let id = $(this).attr('data-id')
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        data: {
            id: id,
            editDepartment:1
        },
        dataType: 'json',
        success: function (res) {
            $('#id_edit').val(res.id)
            $('#department').val(res.Department)
            $('#ModalDepartment').modal('show')
        }
    })
})