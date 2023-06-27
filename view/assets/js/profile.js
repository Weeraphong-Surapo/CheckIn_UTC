// แก้ไขรหัสผ่าน
$('#editPass').click(() => {
    $('#ModalProfile').modal('show')
})

$('#btn-old-pass').click(() => {
    let old_pass = $('#old_pass').val()
    $('p#error-old-pass').css('color', 'red')
    let option = {
        url: 'function/action.php',
        type: 'post',
        data: {
            old_pass: old_pass,
            check_pass: 1
        },
        success: function (res) {
            if (res == 'yes') {
                $('p#error-old-pass').css('display', 'none')
                $('p#error-old-pass').empty();
                $('div.old_pass').hide()
                $('div.new_pass').show()
                $('#btn-old-pass').hide()
                $('#btn-new-pass').show()
            } else {
                $('p#error-old-pass').text('รหัสผ่านไม่ถูกต้องตรวจสอบอีกครั้ง!!')
            }
        }
    }
    if (old_pass != "") {
        $('p#error-old-pass').text('')
        $.ajax(option)
    } else {
        $('p#error-old-pass').text('กรุณากรอกรหัสผ่าน!!')
    }
})

$('#btn-new-pass').click(() => {
    let new_pass = $('#new_pass').val()
    $('p#error-new-pass').css('color', 'red')
    if (new_pass.length < 9) {
        $('p#error-new-pass').text('กรูณาตั้งรหัสผ่านมากว่า 8 ตัว!!')
    } else {
        $('p#error-new-pass').empty()
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: {
                new_pass: new_pass,
                updatePass: 1
            },
            success: function (res) {
                alertsuccess('success', 'เปลี่ยนรหัสผ่านเรียบร้อย', '');
                setTimeout(() => {
                    location.reload()
                }, 900);
            }
        })
    }
})



function editImage(id) {
    var option = {
        url: 'function/action.php',
        type: 'post',
        dataType: 'json',
        data: {
            id: id,
            editImage: 1
        },
        success: function (res) {
            $('#idOldImage').val(res.id)
            $('#showImage').attr('src', '../assets/' + res.image);
            $('#ModalEditImage').modal('show')
        }
    }
    $.ajax(option)
}

$('#FormUpdateImage').submit(function (e) {
    e.preventDefault();
    var fd = new FormData();
    var file = $('#image_old')[0].files;
    var id = $('#idOldImage').val();


    fd.append('file', file[0]);
    fd.append('updateImage', 1);
    fd.append('id', id);
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        data: fd,
        async: false,
        contentType: false,
        processData: false,
        success: function (data) {
            alertsuccess('success', 'อัพเดตรูปสำเร็จ', '')
            setTimeout(() => { location.reload() }, 900)
        }
    });
});

function editName(id) {
    $('#btnPhone').css('display', 'none')
    $('#btnName').css('display', 'block')
    var option = {
        url: 'function/action.php',
        type: 'post',
        data: { id: id, editName: 1 },
        success: function (res) {
            $('#textName').text('แก้ไขชื่อ')
            $('#resultName').html(res)
            $('#ModalName').modal('show');
        }
    }
    $.ajax(option)
}

function editPhone(id) {
    $('#btnPhone').css('display', 'block')
    $('#btnName').css('display', 'none')
    var option = {
        url: 'function/action.php',
        type: 'post',
        data: { id: id, editPhone: 1 },
        success: function (res) {
            $('#textName').text('แก้ไขเบอร์โทร')
            $('#resultName').html(res)
            $('#ModalName').modal('show');
        }
    }
    $.ajax(option)
}


function submitName() {
    var name = $('#Name').val()
    var id = $('#editName').val()
    var option = {
        url: 'function/action.php',
        type: 'post',
        data: {
            id: id,
            name: name,
            updateName: 1
        },
        success: function (res) {
            alertsuccess('success', 'อัพเดตชื่อสำเร็จ', '')
            setTimeout(() => { location.reload() }, 900)
        }
    }
    $.ajax(option)
}

function submitPhone() {
    var phone = $('#Phone').val()
    var id = $('#editPhone').val()
    if (phone.length > 10) {
        alertsuccess('warning', 'เบอร์เกิน 10 ตัว!', '')
    } else if (isNaN(phone)) {
        alertsuccess('warning', 'ไม่สามารถเป็นตัวอักษรใด้!', '')
    } else {
        var option = {
            url: 'function/action.php',
            type: 'post',
            data: {
                id: id,
                phone: phone,
                updatePhone: 1
            },
            success: function (res) {
                alertsuccess('success', 'อัพเดตเบอร์สำเร็จ', '')
                setTimeout(() => { location.reload() }, 900)
            }
        }
        $.ajax(option)
    }
}

function editProfile(id){
    $('#ModalProfiles').modal('show')
    
}

function updateProfile(){
    let fullname = $('#fullname').val()
    let phone = $('#phones').val()
    let id = $('#idTeacher').val()
    let line = $('#line').val()
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            line:line,
            fullname:fullname,
            phone:phone,
            id:id,
            updateProfile:1
        },
        success:function(res){
            alertsuccess('success', 'อัพเดตข้อมูลสำเร็จ', '')
            setTimeout(() => { location.reload() }, 600)
        }
    }
    $.ajax(option);
}

function updateProfiles(){
    let fullname = $('#fullname').val()
    let phone = $('#phones').val()
    let id = $('#idTeacher').val()
    let line = $('#line').val()
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            line:line,
            fullname:fullname,
            phone:phone,
            id:id,
            updateProfiles:1
        },
        success:function(res){
            alertsuccess('success', 'อัพเดตข้อมูลสำเร็จ', '')
            setTimeout(() => { location.reload() }, 600)
        }
    }
    $.ajax(option)
}

image_old.onchange = evt => {
    const [file] = image_old.files
    if (file) {
        showImage.src = URL.createObjectURL(file)
        $('#updateImage').css('display', 'block')
    }
}

