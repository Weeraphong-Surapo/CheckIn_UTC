function ajaxlogin(url, type, data) {
    $.ajax({
        url: url,
        type: type,
        data: data,
        beforeSend: function() {
            $.blockUI({
                message: $('#indicator'),
                css: {
                    background: '#f2edf3',
                    color: '#da8cff',
                    border: 'none'
                },
                overlayCSS: {
                    background: '#ceacf2',
                    opacity: false
                }
            })
        },
        error: function(xhr, textStatus) {
            alert(textStatus)
        },
        success: function(res) {
            console.log(res);
            if (res == 'no') {
                $('#error').css('color', 'red')
                $('#error').html('ไม่มีรหัสประจำตัวนี้ในระบบ!!')
            } else {
                $('#error').empty()
                $('#check_otp').hide()
                $('#login').show()
                $('#enter_student').hide()
                $('#enter_otp').show()
            }
            $.unblockUI()
        }
    })
}


$(function() {
    $('#check_otp').click(function(e) {
        e.preventDefault();
        let otp = $('#otp').val()
        let student = $('#Student_id').val()
        if (student != "") {
            ajaxlogin('function/action.php', 'post', {
                student: student,
                otp:otp,
                login: 1
            })
        } else {
            $('#error-studentId').css('color', 'red')
            $('#error-studentId').text('กรุณากรอกรหัสประจำตัว')
        }
    })

    $('button#login').click((e) => {
        e.preventDefault()
        let otp = $('#otp').val()
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: {
                login_success: 1,
                otp: otp
            },
            success: function(res) {
                if (res == "login") {
                    alertsuccess('success', 'เข้าสู่ระบบสำเร็จ', '')
                    setTimeout(() => {
                        window.location = 'index.php'
                    }, 1000)
                } else {
                    alertsuccess('error', 'OTP ไม่ถูกต้อง', 'กรุณาเช็คในอีเมลล์อีกครั้ง')
                }
            }
        })
    })

})