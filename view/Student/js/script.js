    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
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
                right: 'dayGridMonth,dayGridWeek',
                center: 'title',
            },
            timezone:'Asia/Bangkok',
            locale:'th',
            selectable: true,
            themeSystem: 'bootstrap',
            
            //Random default events
            events: events,
            eventClick: function(info) {
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
            eventDidMount: function(info) {
                // Do Something after events mounted
            },
            editable: false
        });

        calendar.render();

        // Form reset listener
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('')
            $(this).find('input:visible').first().focus()
        })



        

    // $('#calendar').fullCalendar({
    //   lang: 'th'
    // });

    })
        // var status = 0;
        // if(status == 1){
        //     $('.fc .fc-daygrid-day.fc-day-today').css('background','rgba(255, 220, 40, .15)')
        // }else{
        //     $('.fc .fc-daygrid-day.fc-day-today').css('background','rgba(39, 245, 108, 0.8)')
        // }
     