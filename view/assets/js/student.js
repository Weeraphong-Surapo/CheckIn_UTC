$('button.btn-edit').click(function () {
    let id = $(this).attr('data-id')
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        dataType: 'json',
        data: {
            id: id,
            editstudent: 1
        },
        error: function (xhr, textStatus) {
            alert(textStatus)
        },
        success: function (res) {
            $('#txt-modal').text('แก้ไขนักศึกษา')
            $('#id-student').val(res.id)
            $('#student_id').val(res.Student_id)
            $('#room').val(res.Room_ID)
            $('#student_name').val(res.Student_name)
            $('#email').val(res.Email)
            $('#ModalStudent').modal('show')
        }
    })
})


$('button.btn-del').click(function () {
    let id = $(this).attr('data-id')
    let name = $(this).attr('data-name')
    let student_id = $(this).attr('data-student-id')

    Swal.fire({
        title: 'คุณต้องการลบ ' + name + ' ใช่ไหม?',
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
                    student_id:student_id,
                    delStudent: 1
                },
                error: function (xhr, textStatus) {
                    alert(textStatus)
                },
                success: function (res) {
                    alertsuccess('success', 'ลบเรียบร้อย', '')
                    setTimeout(function () { location.reload() }, 800)
                }
            })
        }
    })
})

function insertStudent() {
    $('#formStudent')[0].reset()
    $('#txt-modal').text('เพิ่มนักศึกษา')
    $('input#id-student').val('')
    $('#ModalStudent').modal('show')
}


$('#formStudent').submit(function (e) {
    e.preventDefault();
    $('p').css('color', 'red')
    let fd = new FormData()
    let id = $('#id-student').val()
    let student_id = $('#student_id').val()
    let student_name = $('#student_name').val()
    let room = $('#room').val()
    let email = $('#email').val()
    if (student_id == "" && student_name == "" && email == "") {
        $('#error-student_id').text('กรุณากรอกรหัสนักศึกษา')
        $('#error-student_name').text('กรุณากรอกชื่อนักศึกษา')
        $('#error-email').text('กรุณากรอกอีเมลล์ศึกษา')
    } else if (student_id == "") {
        $('#error-student_id').text('กรุณากรอกรหัสนักศึกษา')
    } else if (student_name == "") {
        $('#error-student_id').empty()
        $('#error-student_name').text('กรุณากรอกชื่อนักศึกษา')
    } else if (email == "") {
        $('p').empty()
        $('#error-student_name').empty()
        $('#error-email').text('กรุณากรอกอีเมลล์ศึกษา')
    } else {
        $('p').empty()
        fd.append('student_id', student_id)
        fd.append('student_name', student_name)
        fd.append('email', email)
        fd.append('id', id)
        fd.append('room', room)
        fd.append('insertStudent', 1)
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
                if (res == 'no') {
                    alertsuccess('error', 'เพิ่มไม่สำเร็จเนื่อจากรหัสซ้ำนักศึกษา', '')
                } else {
                    alertsuccess('success', 'บันทึกสำเร็จ', '');
                    setTimeout(function () { location.reload() }, 800)
                }
            }
        })
    }
})

$('button#warn').click(function () {
    let id = $(this).attr('data-id')
    let name = $(this).attr('data-name')
    Swal.fire({
        title: 'ตักเตือน ' + name + ' ใช่ไหม?',
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
                beforeSend: function () {
                    $.blockUI({
                        message: $('#indicator'),
                        css: { background: '#ffc', color: '#be94eb', border: 'none' },
                        overlayCSS: { background: '#ceacf2', opacity: false }
                    })
                },
                data: {
                    id: id,
                    warn: 1
                },
                success: function (res) {
                    $.unblockUI()
                    alertsuccess('success', 'ส่งอีเมล์เตือนสำเร็จ', '');
                }
            })
        }
    })
})



$('button.del_check_student').click(function () {
    Swal.fire({
        title: 'ต้องการลบข้อมูลการเข้าแถวใช่ไหม?',
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
                    del_cehck_student: 1
                },
                success: function (res) {
                    alertsuccess('success', 'ลบข้อมูลสำเร็จ', '')
                    setTimeout(() => { location.reload() }, 800)
                }
            })
        }
    })
})

function resetStudent() {
    Swal.fire({
        title: 'บันทึกข้อมูลของเทอมนี้ใช่ไหม?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#ModalConfirm').modal('show')
            $('#submitReport').click(function () {
                var pass = $('#cPass').val()
                $.ajax({
                    url: 'function/action.php',
                    type: 'post',
                    data: {
                        pass: pass,
                        confirmReport: 1
                    },
                    success: function (res) {
                        if (res == 'no') {
                            alertsuccess('error', 'รหัสผ่านไม่ถูกต้อง', '')
                            $('#cPass').val('')
                        } else {
                            $.ajax({
                                url: 'function/action.php',
                                type: 'post',
                                data: {
                                    resetStudent: 1
                                },
                                success: function (res) {
                                    if(res == 'no'){
                                        alertsuccess('error', 'บันทึกข้อมูลเทอมนี้ไม่สำเร็จเนื่องจากมีประวัติการบันทึกนี้แล้ว!!', '')
                                    }else{
                                        alertsuccess('success', 'บันทึกข้อมูลเทอมนี้สำเร็จ', '')
                                        setTimeout(() => { location.reload() }, 800)
                                    }
                                }
                            })
                        }
                    }
                })
            })
        }
    })
}


function toggleStatus(id) {
    var option = {
        url: 'function/action.php',
        type: 'post',
        data: {
            id: id,
            updateAnnounce: 1,
        },
        success: function (res) {
            if (res == 'no') {
                alertsuccess('warning', 'ใช้งานใด้เพียง 1 เรื่อง', '')
            } else {
                location.reload()
            }
        }
    }
    $.ajax(option)
}

function delAnnounce(id) {
    var option = {
        url: 'function/action.php',
        type: 'post',
        data: {
            id: id,
            delAnnounce: 1
        },
        success: function () {
            alertsuccess('success', 'ลบสำเร็จ', '')
            setTimeout(() => { location.reload() }, 800)
        }
    }
    Swal.fire({
        title: 'คุณต้องการลบข้อมูล ?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax(option)
        }
    })

}


function editAnnounce(id) {
    var option = {
        url: 'function/action.php',
        type: 'post',
        dataType: 'json',
        data: {
            id: id,
            editAnnounce: 1
        },
        success: function (res) {
            $('#text-Announce').text('แก้ไขประกาศ')
            $('#idAnnounce').val(res.id)
            $('#head').val(res.head)
            $('#description').val(res.description)
            $('#ModalAnnounce').modal('show')
        }
    }
    $.ajax(option)
}

$('#formAnnounce').submit((e) => {
    e.preventDefault()
    $('p').css('color', 'red')
    var fd = new FormData()
    var head = $('#head').val()
    var description = $('#description').val()
    var id = $('#idAnnounce').val()
    if (head == "") {
        $('#errorHead').text('กรุณากรอกหัวข้อเรื่อง!!')
    } else if (description == "") {
        $('#errorHead').empty()
        $('#errorDes').text('กรุณากรอกรายละเอียด!!')
    } else {
        $('p').empty()
        fd.append('head', head)
        fd.append('description', description)
        fd.append('id', id)
        fd.append('submitAnnounce', 1)
        var option = {
            url: 'function/action.php',
            type: 'post',
            data: fd,
            async: false,
            contentType: false,
            processData: false,
            success: function (res) {
                alertsuccess('success', 'บันทึกสำเร็จ', '')
                setTimeout(() => { location.reload() }, 800)
            }
        }
        $.ajax(option)
    }
})

function insertAnnounce() {
    $('#formAnnounce')[0].reset()
    $('#text-Announce').text('เพิ่มประกาศ')
    $('#ModalAnnounce').modal('show')
}


function delHistory(id, year, term) {
    Swal.fire({
        title: 'ต้องการลบภาคเรียน ' + year + ' เทอม ' + term + ' ?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var option = {
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    year: year,
                    term: term,
                    delHistory: 1
                },
                success: function () {

                }
            }
            $.ajax(option)
        }
    })
}

function delHistory(id, year, term) {
    Swal.fire({
        title: 'ต้องการลบภาคเรียน ' + year + ' เทอม ' + term + ' ?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#ModalConfirm').modal('show')
            $('#submitReport').click(function () {
                var pass = $('#cPass').val()
                $.ajax({
                    url: 'function/action.php',
                    type: 'post',
                    data: {
                        pass: pass,
                        confirmReport: 1
                    },
                    success: function (res) {
                        if (res == 'no') {
                            alertsuccess('error', 'รหัสผ่านไม่ถูกต้อง', '')
                            $('#cPass').val('')
                        } else {
                            var option = {
                                url: 'function/action.php',
                                type: 'post',
                                data: {
                                    id: id,
                                    year: year,
                                    term: term,
                                    delHistory: 1
                                },
                                success: function () {
                                    alertsuccess('success','ลบประวัติเช็คชื่อสำเร็จ','')
                                    setTimeout(()=>{location.reload()},800)
                                }
                            }
                            $.ajax(option)
                        }
                    }
                })
            })
        }
    })
}

function selectStudent(){
    $('#modalSelectStudent').modal('show')
}

function reportSelect(){
    let room = $('#room').val()
    window.open(
        'function/MyReport.php?room='+room,
        '_blank'
      );
}

$('#findroom').change(()=>{
    let room = $('#findroom').val()
    location.href='student?room='+room;
})