function editClose(id) {
    var option = {
        url: 'function/action.php',
        type: 'post',
        data: {
            id: id,
            editclose: 1
        },
        success: function (res) {
            $('#textYear').text('แก้ไขเวลาปิดสแกน')
            $('#result').html(res)
            $('#ModalYear').modal('show')
        }
    }
    $.ajax(option)
}


function editOpen(id) {
    var option = {
        url: 'function/action.php',
        type: 'post',
        data: {
            id: id,
            editopen: 1
        },
        success: function (res) {
            $('#textYear').text('แก้ไขเวลาเปิดสแกน')
            $('#result').html(res)
            $('#ModalYear').modal('show')
        }
    }
    $.ajax(option)
}

$('#submit').click(() => {
    $('p').css('color','red')
    var type = $('#inputType').val()
    var Year = $('#inputTime').val()
    var Term = $('#inputTimeClose').val()
    if(Year == ""){
        $('#errorYear').text('กรุณากรอกปีการศึกษา')
    }else if(Term == ""){
        $('#errorTerm').text('กรุณากรอกเวลา เช่น 08:00 , 06:30')
    }else{
        if (type == 'editTime') {
           
            var option = {
                url: 'function/action.php',
                type: 'post',
                data: {
                    Year: Year,
                    updateTerm: 1
                },
                success: function (res) {
                    alertsuccess('success', 'อัพเดตสำเร็จ', '')
                    setTimeout(() => {location.reload()}, 900);
                }
            }
            $.ajax(option)
        } else {
            var option = {
                url: 'function/action.php',
                type: 'post',
                data: {
                    Term: Term,
                    updateYear: 1
                },
                success: function (res) {
                    alertsuccess('success', 'อัพเดตสำเร็จ', '')
                    // setTimeout(() => {location.reload()}, 900);
                }
            }
            $.ajax(option)
        }
    }
})