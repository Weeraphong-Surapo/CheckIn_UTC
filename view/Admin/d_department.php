<?php
// เรียกใช้งาน DB และ Controller
require_once('../../Controller/AdminController.php');
require_once('function/head.php');
require_once('function/nav.php');
$DB = new DB_Admin;
$sql = "SELECT * FROM tb_teacher WHERE type != 999";
$query = $DB->conn->query($sql);
$data = $query->fetch_array();
?>

<div class="container">
    <div class="card p-3 shadow-sm">
        <div class="card-body">
            <h4 class="card-title">รายละเอียดสาขา</h4>
            <hr>
            <div class="table-responsive">
                <table class="table text-center" id="example">
                    <thead>
                        <tr>
                            <th>สาขางาน</th>
                            <th>ระดับชั้น</th>
                            <th>อาจารย์</th>
                            <th>นักเรียนในสาขา</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($query as $row) :
                            $count_student = "SELECT * FROM tb_student WHERE Teacher_id = '$row[id]'";
                            $result = $DB->conn->query($count_student);
                            $count = $result->num_rows;

                            $department = $DB->conn->query("SELECT * FROM tb_department WHERE id = '$row[Department]'");
                            $department_name = $department->fetch_array();

                            $lavel = $DB->conn->query("SELECT * FROM tb_lavel WHERE id = '$row[lavel]'");
                            $lavel_name = $lavel->fetch_array();
                        ?>
                                <tr>
                                    <td><?= $department_name['Department']; ?></td>
                                    <td><?= $lavel_name['lavel']; ?></td>
                                    <td><?= $row['title'] . $row['Teacher_name']; ?></td>
                                    <td><?= $count . ' คน'; ?></td>
                            <?php
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once('function/footer.php'); ?>