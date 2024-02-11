<?php
include "connect.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Niramit:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <title>จัดการอุปกรณ์ IT</title>
</head>
<style>
    body {
        font-family: 'Niramit', sans-serif;
    }
</style>

<body>
    <br>
    <center>
        <h1>จัดการครุภัณฑ์ IT</h1>
    </center>
    <br>

    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <div class="row">

                    <a href="index.php">
                        <button type="button" id="menu" class="btn btn-info col-12">หน้าหลัก</button>
                    </a>

                    <a href="equipment.php">
                        <button type="button" id="menu" class="btn btn-info col-12">ครุภัณฑ์</button>
                    </a>

                    <a href="dashbord.php">
                        <button type="button" id="menu" class="btn btn-info col-12">สถิติการยืม</button>
                    </a>


                </div>
            </div>
            <div class="col-md-10">
                <div><button class="btn btn-success" id="btnadditem" onclick="additem()">เพิ่มรายการครุภัณฑ์</button>
                </div>
                <br>
                <form class="row g-3" id="formdataitem" style="display: none">
                    <div class="row">

                        <div class="col-md-6">
                            <label for="inputitem" class="form-label">รายการครุภัณฑ์</label>
                            <input type="category" class="form-control" id="inputitem">
                        </div>
                        <div class="col-md-6">
                            <label for="inputcategory" class="form-label">ประเภทครุภัณฑ์</label>
                            <select id="inputcategory" class="form-select">
                                <option selected>Choose...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputcode" class="form-label">รหัสครุภัณฑ์</label>
                            <input type="text" class="form-control" id="inputcode">
                        </div>
                        <div class="col-md-6">
                            <label for="inputdate" class="form-label">วันที่ลงทะเบียน</label>
                            <br>

                            <input type="datetime-local" id="meeting-time" name="meeting-time" value="2018-06-12T19:30"
                                min="2014-01-01T00:00" max="9999-12-31T00:00" />

                        </div>
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-6">
                            <div><button class="btn btn-success" id="submid">เพิ่มครุภัณฑ์</button></div>
                        </div>

                    </div>
                </form>
                <table id="itemstb" class="table table-bordered table-primary">

                    <thead style="text-align:center ;">
                        <th>ลำดับ</th>
                        <th>รหัส</th>
                        <th>ประเภท</th>
                        <th>รายการอุปกรณ์</th>
                        <th>สถานะ</th>

                    </thead>
                    <tbody>
                        <?php
                        $sql= "SELECT * FROM `items_1`";
                        if($rs=mysqli_query($conn,$sql)){
                        $i=0;
                            while($row=mysqli_fetch_assoc($rs)){
                                $i++;
                                ?>
                        <tr>
                            <td>
                                <?php echo $i ?>
                            </td>
                            <td>
                                <?php echo $row['ag_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['ag_ type']; ?>
                            </td>
                            <td>
                                <?php echo $row['ag_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['ag_ status']; ?>
                            </td>
                            </td>

                        </tr>
                        <?php
                        }
                    }
                        
                        ?>

                        <!---<tr>
                           
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" />
                                    <label class="form-check-label" for="flexSwitchCheckDefault">active</label>
                                </div>
                            </td>
                          

                       </tr> -->



                    </tbody>


                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <!-- MDB -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
</body>

<script>
    let ch = 0;
    function additem() {
        var btn = document.getElementById('btnadditem');
        var form = document.getElementById('formdataitem');
        if (ch == 0) {
            form.style.display = 'block';
            ch = 1;
        } else {
            form.style.display = 'none';
            ch = 0;
        }

    }

</script>
<script>
    $(document).ready(function () {
        $('#itemstb').DataTable();
    });
</script>

</html>