var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];
$(function () {
    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k]
            events.push({ id: row.id, title: row.title, start: row.start_datetime, end: row.end_datetime });
        })
    }
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

    calendar = new Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next today',
            right: 'dayGridMonth,dayGridWeek,list',
            center: 'title',
        },
        timezone: 'Asia/Bangkok',
        locale: 'th',
        selectable: true,
        themeSystem: 'bootstrap',

        //Random default events
        events: events,
        eventClick: function (info) {
            var _details = $('#event-details-modal')
            var id = info.event.id
            if (!!scheds[id]) {
                _details.find('#title').text(scheds[id].title)
                _details.find('#description').text(scheds[id].description)
                _details.find('#start').text(scheds[id].sdate)
                _details.find('#end').text(scheds[id].edate)
                _details.find('#edit,#delete').attr('data-id', id)
                _details.modal('show')
            } else {
                alert("Event is undefined");
            }
        },
        eventDidMount: function (info) {
            // Do Something after events mounted
        },
        editable: false
    });

    calendar.render();

    // Form reset listener
    $('#schedule-form').on('reset', function () {
        $(this).find('input:hidden').val('')
        $(this).find('input:visible').first().focus()
    })

    $('#schedule-form').submit(function(e){
        e.preventDefault()
        let fd = new FormData();
        let id = $('#id').val()
        let tile = $('#title').val()
        let des = $('#description').val()
        let start_date = $('#start_datetime').val()
        let end_date = $('#end_datetime').val()
        fd.append('title',tile)
        fd.append('des',des)
        fd.append('id',id)
        fd.append('start_datetime',start_date)
        fd.append('end_datetime',end_date)
        fd.append('insert',1)
        let option = {
            url:'function/action.php',
            type:'post',
            data:fd,
            async:false,
            contentType: false,
            processData:false,
            success:function(res){
                if (res == 'success') {
                    Swal.fire(
                        'บันทึกเรียบร้อย!',
                        '',
                        'success'
                    )
                    setTimeout(() => { location.reload() }, 600)
                } else {
                    Swal.fire(
                        'เกิดข้อผิดพลาด!',
                        '',
                        'error'
                    )
                }
            }
        }
        $.ajax(option)
    })

    // Edit Button
    $('#edit').click(function () {
        var id = $(this).attr('data-id')
        if (!!scheds[id]) {
            var _form = $('#schedule-form')
            console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"))
            _form.find('[name="id"]').val(id)
            _form.find('[name="title"]').val(scheds[id].title)
            _form.find('[name="description"]').val(scheds[id].description)
            _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"))
            _form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime).replace(" ", "T"))
            $('#event-details-modal').modal('hide')
            _form.find('[name="title"]').focus()
        } else {
            alert("Event is undefined");
        }
    })

    // Delete Button / Deleting an Event
    $('#delete').click(function () {
        var id = $(this).attr('data-id')
        if (!!scheds[id]) {
            Swal.fire({
                title: 'ต้องการลบวันหยุดใช่ไหม?',
                text: "คุณจะไม่สามาถกู้คืนใด้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {
                    let option = {
                        url: 'function/action.php',
                        type: 'post',
                        data: {
                            id: id,
                            delCalendar: 1
                        },
                        success: function (res) {
                            if (res == 'success') {
                                Swal.fire(
                                    'ลบเรียบร้อย!',
                                    '',
                                    'success'
                                )
                                setTimeout(() => { location.reload() }, 600)
                            } else {
                                Swal.fire(
                                    'เกิดข้อผิดพลาด!',
                                    '',
                                    'error'
                                )
                            }
                        }
                    }
                    $.ajax(option)
                }
            })
        } else {
            alert("Event is undefined");
        }
    })
})
