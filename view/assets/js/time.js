$('#date_open').change(function(e){
    let date = $('#date_open').val();
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            date:date,
            updateOpen:1
        },
        success:function(res){
            location.reload()
        }
    }
    $.ajax(option)
})

$('#date_close').change(function(e){
    let date = $('#date_close').val();
    let option = {
        url:'function/action.php',
        type:'post',
        data:{
            date:date,
            updateClose:1
        },
        success:function(res){
            location.reload()
        }
    }
    $.ajax(option)
})