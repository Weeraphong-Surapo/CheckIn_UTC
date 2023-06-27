function editTerm(){
    let option = {
        url:'function/action.php',
        type:'post',
        dataType:'json',
        data:{
            editTerms:1
        },
        success:function(res){
            $('#term').val(res.term)
            $('#ModalEditTerm').modal('show')
        }
    }
    $.ajax(option)
}

function saveTerm(){
    let term = $('#term').val()
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            term:term,
            saveTerm:1
        },
        success:function(res){
            if(res == 'success'){
                alertsuccess('success','อัพเดตสำเร็จ','');
                setTimeout(()=>{location.reload()},600)
            }else{
                alertsuccess('error','เกิดข้อผิดพลาด!!','');
                setTimeout(()=>{location.reload()},600)
            }
        }
    }
    $.ajax(option);
}

function editYear(){
    let option = {
        url:'function/action.php',
        type:'post',
        dataType:'json',
        data:{
            editYears:1
        },
        success:function(res){
            $('#year').val(res.school_year);
            $('#ModalEditYear').modal('show');
        }
    }
    $.ajax(option)
}

function saveYear(){
    let year = $('#year').val()
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            year:year,
            saveYear:1
        },
        success:function(res){
            if(res == 'success'){
                alertsuccess('success','อัพเดตสำเร็จ','');
                setTimeout(()=>{location.reload()},600)
            }else{
                alertsuccess('error','เกิดข้อผิดพลาด!!','');
                setTimeout(()=>{location.reload()},600)
            }
        }
    }
    $.ajax(option);
}