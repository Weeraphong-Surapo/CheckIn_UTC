<!-- Modal -->
<div class="modal fade" id="ModalTeacher" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">อาจารย์</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="formTeacher">
                    <input type="hidden" name="id_edit" id="id_edit">
                    <div class="mb-2">
                        <select name="department" id="department" class="form-control">
                            <option value="" selected disabled>เลือกสาขางาน</option>
                            <?php
                            $sql = "SELECT * FROM tb_department";
                            $query_title = $DB->conn->query($sql);
                            while ($row = $query_title->fetch_array()) :
                            ?>
                                <option value="<?= $row['id']; ?>"><?= $row['Department']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <p id="department-error"></p>
                    </div>
                    <div class="mb-2">
                        <select name="lavel" id="lavel" class="form-control">
                            <option value="" selected disabled>เลือกระดับชั้น</option>
                            <?php
                            $sql = "SELECT * FROM tb_lavel";
                            $query_title = $DB->conn->query($sql);
                            while ($row = $query_title->fetch_array()) :
                            ?>
                                <option value="<?= $row['id']; ?>"><?= $row['lavel']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <p id="lavel-error"></p>
                    </div>

                    <div class="mb-2">
                        <select name="room1" id="room1" class="form-control">
                            <option value="" selected disabled>เลือกห้องที่ดูแล</option>
                            <?php 
                            $sql = "SELECT * FROM tb_room";
                            $query = $DB->conn->query($sql);
                            foreach($query as $row):
                            ?>
                            <option value="<?php echo $row['Room_ID']?>"><?php echo $row['room'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <select name="room2" id="room2" class="form-control" disabled>
                        <option value="" selected disabled>เลือกห้องที่ดูแล</option>
                        <?php 
                        $sql2 = "SELECT * FROM tb_room";
                        $query2 = $DB->conn->query($sql2);
                        foreach($query2 as $row):
                        ?>
                         <option value="<?php echo $row['Room_ID']?>"><?php echo $row['room'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <select name="title" id="title" class="form-control">
                            <option value="" selected disabled>เลือกคำนำหน้า</option>
                            <?php
                            $sql = "SELECT * FROM tb_title";
                            $query = $DB->conn->query($sql);
                            while ($row = $query->fetch_array()) :
                            ?>
                                <option value="<?= $row['title']; ?>" ><?= $row['title']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <p id="title-error"></p>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="teacher" id="teacher" class="form-control" placeholder="ชื่ออาจารย์">
                        <p id="teacher-error"></p>
                    </div>
                    <div class="mb-2">
                        <div class="mb-2">
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="เบอร์โทรติดต่อ">
                            <p id="phone-error"></p>
                        </div>
                        <input type="text" name="username" id="username" class="form-control" placeholder="ชื่อผู้ใช้">
                        <p id="username-error"></p>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="password" id="password" class="form-control" placeholder="รหัสผ่าน">
                        <p id="password-error"></p>
                    </div>
                    <p style="color:red;" id="error"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary" id="insertTeacher">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="viewTeacher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">รายละเอียดอาจารย์</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="detailTeacher">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>