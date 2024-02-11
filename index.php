<?php
include "connect.php";
$data = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Niramit:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    

    <title>ระบบยืมคืนครุภัณฑ์ IT</title>

</head>
<style>
    body {
        font-family: 'Niramit', sans-serif;
    }
</style>

<body>
    <br>
    <center>
        <h1>ระบบยืมคืนครุภัณฑ์ IT</h1>
    </center>
    <br>

    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <div class="row">
                    <!-- เพิ่มคำอธิบายในปุ่ม -->
                    <a href="index.php">
                        <button type="buttonhome" id="menu" class="btn btn-info col-12">หน้าหลัก</button>
                    </a>

                    <a href="equipment.php">
                        <button type="buttonequipment" id="menu" class="btn btn-info col-12">ครุภัณฑ์</button>
                    </a>

                    <a href="#">
                        <button type="buttondashbord" id="menu" class="btn btn-info col-12">สถิติการยืม</button>
                    </a>
                </div>
            </div>
            <div class="col-md-10">
                <button type="button" class="btn btn-success" onclick="addborrow()" style="margin-bottom: 2%;">เพิ่มรายการยืมครุภัณฑ์</button>
                <br>
                <!-- เพิ่มคำอธิบายในฟอร์ม -->
                <form action="getSql.php" method="POST" class="row g-3" id="formdata" style="display: none">
                    <div class="row">
                        <label id="headline">ข้อมูลผู้ยืม</label>
                        <hr>
                        <div class="col-md-4">
                            <label for="inputname" class="form-label">ชื่อผู้ยืม</label>
                            <input type="code" class="form-control" onkeyup="submit_btn()" name="borname" id="inputname">
                        </div>

                        <div class="col-md-4" id="office_b">
                            <label for="inputtel" class="form-label">เบอร์หน่วยงาน </label>
                            <select name="office" class="selectpicker w-100" id="s_select" onchange="submit_btn()" data-live-search="true">
                                <option value="">----</option>
                                <?php
                                $office = "SELECT  * FROM `office`  ";
                                if ($rs = mysqli_query($conn, $office)) {
                                    while ($row = mysqli_fetch_assoc($rs)) {
                                ?>
                                        <option value="<?php echo  $row['number'] ?>"><?php echo $row['number'] . " " . $row['Agency'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="bordate" class="form-label" style="margin-top: 1%;">วันที่ยืม</label>
                            <br>
                            <input type="datetime-local" class="form-control w-100" id="bordate" name="bordate">
                        </div>
                        <label id="headline">ข้อมูลครุภัณฑ์</label>
                        <hr>
                        <div class="col-md-6">
                            <label for="inputcategory" class="form-label">ประเภทครุภัณฑ์</label>
                            <select id="inputcategory" name="item_type" onchange="xml_item('itemselect',this.value),submit_btn()" class="selectpicker s_select w-100" data-live-search="true">
                                <option value="">----</option>
                                <?php
                                $sql = "SELECT DISTINCT `ag_type` as type FROM items_1; ";
                                if ($result = mysqli_query($conn, $sql)) {
                                    while ($r = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?php echo $r['type'] ?>"><?php echo $r['type'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="inputcode" class="form-label">รหัสครุภัณฑ์</label>
                            <select id="itemselect" name="itemselect" onchange="submit_btn()" class="selectpicker s_select w-100" data-live-search="true">
                            </select>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                    <input type="submit" class="btn btn-light" name="submit" value="บันทึกการยืม" id="submid" disabled>
                </form>
                <table id="itemstb" class="table table-bordered table-primary">
                    <thead style="text-align:center ;">
                        <th>ลำดับ</th>
                        <th>รหัส</th>
                        <th>รายการอุปกรณ์</th>
                        <th>วันที่ยืม-คืน</th>
                        <th>ชื่อผู้ยืม</th>
                        <th>หน่วยงาน</th>
                        <th>สถานะ</th>
                        <th>การคืน</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `borrowing` ORDER BY `borrowing`.`b_id` ASC";
                        if ($rs = mysqli_query($conn, $sql)) {
                            $i = 0;
                            while ($row = mysqli_fetch_assoc($rs)) {
                        ?>
                                <tr>
                                    <td>
                                        <?php echo ($i + 1) ?>
                                    </td>
                                    <td>
                                        <?php echo $row['b_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['b_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['b_date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['b_borower']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['b_agency']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['b_status']; ?>
                                    </td>
                                    <td>
                                        <center>
                                        <?php if ($row['b_status'] == 'ยืม') { ?>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal<?php echo $i + 1; ?>">
                                                คืน
                                            </button>
                                        <?php } else {
                                            echo $row['b_return_p'] . "<br>" . $row['b_return'];
                                        } ?>
                                        </center>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?php echo $i + 1; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="getSql.php" method="POST">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">ยืนยันการคืน</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" id="modal_body<?php echo $i + 1 ?>">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="checkbox" name="rid" value="<?php echo $row['b_id'] ?>" id="check<?php echo ($i + 1); ?>" onclick="setdata(this.id,'<?php echo $i + 1 ?>')">
                                                                    <label for="">ใช้ข้อมูลจากผู้ยืม</label>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for="input/text">ชื่อผู้คืน</label>
                                                                    <input onkeyup="checkinput(this,'confirm<?php echo $i + 1; ?>')" type="text" name="return_p" class="form-control">
                                                                </div>
                                                                <div class="col-md-12" id="office_div<?php $i + 1 ?>">
                                                                    <label for="input/text">แผนก</label><br>
                                                                    <select name="office_r" class="selectpicker w-100" id="s_select" data-live-search="true">
                                                                        <?php
                                                                        $office = "SELECT  * FROM `office`  ";
                                                                        if ($result = mysqli_query($conn, $office)) {
                                                                            while ($rr = mysqli_fetch_assoc($result)) {
                                                                        ?>
                                                                                <option value="<?php echo  $rr['number'] ?>"><?php echo $rr['number'] . " " . $rr['Agency'] ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <input type="text" value="<?php echo $row['b_name'] ?>" name="itemid" style="display: none;" >
                                                                <div id="getdata<?php echo $i + 1 ?>" style="display:none;">
                                                                    <label for=""><?php echo $row['b_borower'] ?></label>
                                                                    <label for=""><?php echo $row['b_agency'] ?></label>
                                                                    <label for=""><?php echo $row['b_id'] ?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="submit" class="btn btn-primary" name="r_submit" id="confirm<?php echo $i + 1; ?>" value="ยืนยัน" disabled>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
</body>

<script>
    let ch = 0;
    $(document).ready(function() {
        $('.s_select').selectpicker();
        $('#itemstb').dataTable();
    });

    function submit_btn() {
        var check_input = [];
        check_input[0] = document.getElementById('inputname').value;
        check_input[1] = document.getElementById('inputcategory').value;
        check_input[2] = document.getElementById('bordate').value;
        check_input[3] = document.getElementById('s_select').value;
        check_input[4] = document.getElementById('itemselect').value;
        var btn = document.getElementById('submid');
        for (var i = 0; i < check_input.length; i++) {
            if (check_input[i] == "") {
                btn.setAttribute('class', 'btn btn-light');
                btn.disabled = true;
                break;
            } else {
                btn.setAttribute('class', 'btn btn-success');
                btn.disabled = false;
            }
        }
    }

    function setdata(checkbox, count) {
        var cb = document.getElementById(checkbox);
        var m_input = document.querySelectorAll('#modal_body' + count + ' input[type="text"]')[0];
        var getdata = document.querySelectorAll('#getdata' + count + ' label');
        var select_r = document.querySelectorAll('#modal_body' + count + ' select')[0];
        var btn = document.querySelectorAll('#exampleModal' + count + ' input[type="submit"]')[0];
        var op = select_r.getElementsByTagName('option');
        if (cb.checked == true) {
            m_input.value = getdata[0].innerHTML;
            btn.disabled = false;
            for (var i = 0; i < op.length; i++) {
                if (op[i].value == getdata[1].innerHTML) {
                    op[i].selected = true;
                    $('#modal_body' + count + ' .selectpicker').selectpicker('val', getdata[1].innerHTML);
                }
            }
            console.log(select_r.value);

            $('.s_select').selectpicker('refresh');
        } else {
            m_input.value = "";
            btn.disabled = true
        }
    }



    function addborrow() {
        var btn = document.getElementById('btnaddbor');
        var form = document.getElementById('formdata');
        if (ch == 0) {
            form.style.display = 'block';
            ch = 1;
        } else {
            form.style.display = 'none';
            ch = 0;
        }
    }

    function checkinput(input, btn) {
        var btn = document.getElementById(btn);
        if (input.value != '') {
            btn.disabled = false
        } else {
            btn.disabled = true
        }
    }

    function adddata() {
        var formdata = document.getElementById('formdata');
        var data = formdata.getElementsByTagName('Input');
    }

    function xml_item(selectid, ref) {
        var select = document.getElementById(selectid);
        var xml = new XMLHttpRequest();
        select.innerHTML = "";
        xml.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                select.innerHTML = "";
                select.innerHTML += this.responseText;
                $('.s_select').selectpicker('refresh');
            }
        }
        xml.open("GET", "getSql.php?sql='" + ref);
        xml.send();
    }
</script>

</html>