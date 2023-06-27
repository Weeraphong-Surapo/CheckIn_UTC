function insertRoom(){
    $('#id').val('')
    $('#room').val('')
    $('#ModalRoom').modal('show')
}

function addRoom(){
    let id = $('#id').val();
    let room = $('#room').val()
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            id:id,
            room:room,
            addRoom:1
        },
        success:function(res){
            if(res == 'insert'){
                alertsuccess('success', 'เพิ่มข้อมูลสำเร็จ', '');
            }else{
                alertsuccess('success', 'อัพเดตข้อมูลสำเร็จ', '');
            }
            setTimeout(() => {
                location.reload()
            }, 600);
        }
    }
    $.ajax(option)
}

function delRoom(id){
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            id:id,
            delRoom:1
        },
        success:function(res){
            alertsuccess('success', 'ลบข้อมูลสำเร็จ', '');
            setTimeout(() => {
                location.reload()
            }, 600);
        }
    }
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
            $.ajax(option)
        }
    });
    
}

function editRoom(id){
    let option = {
        url:'function/action.php',
        type:'post',
        dataType:'json',
        data:{
            id:id,
            editRoom:1
        },
        success:function(res){
            $('#id').val(res.Room_ID)
            $('#room').val(res.room)
            $('#ModalRoom').modal('show')
        }
    }
    $.ajax(option)
}