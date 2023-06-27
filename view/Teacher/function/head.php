<?php
if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION['type'] != "Teacher"){
    header('Location: ../Teacher/login');
}
?>
<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com-->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ระบบเช็คชื่อเข้าแถว Qrcode</title>


    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/nav.css" />
    <link rel="stylesheet" href="../assets/css/chart.css" />

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csv',
                        text: 'CSV',
                        charset: 'utf-8',
                        extension: '.csv',
                        fieldSeparator: ';',
                        fieldBoundary: '',
                        filename: 'รายงานนักศึกษา CSV',
                        bom: true
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        charset: 'utf-8',
                        fieldSeparator: ';',
                        fieldBoundary: '',
                        filename: 'export',
                        bom: true
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        charset: 'utf-8',
                        fieldSeparator: ';',
                        fieldBoundary: '',
                        bom: true
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        charset: 'utf-8',
                        extension: '.xlsx',
                        fieldSeparator: ';',
                        fieldBoundary: '',
                        filename: 'รายงานนักศึกษา',
                        bom: true
                    },

                ],
                responsive: true,
                "language": {
                    "decimal": "",
                    "emptyTable": "ไม่เจอข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                    "infoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                    "infoFiltered": "",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Show _MENU_ entries",
                    "loadingRecords": "Loading...",
                    "processing": "",
                    "search": "ค้นหา :",
                    "zeroRecords": "ไม่เจอข้อมูล",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    },
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
            });
        });
    </script>
</head>

<body>