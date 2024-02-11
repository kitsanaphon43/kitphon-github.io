<?php
    include 'connect.php';
    if(isset($_GET['sql'])){
        $type =$_GET['sql'];
        $sql = "SELECT `ag_id`,`ag_name` FROM `items_1` WHERE `ag_type` = ".$type."' AND `ag_status` !='ยืม';";
        if($rs = mysqli_query($conn,$sql)){
            while($row = mysqli_fetch_array($rs)){
                echo "<option value ='".$row['ag_id']."'>".$row['ag_id']."-".$row['ag_name']."</option>";
            }
        }
    }
    if(isset($_POST['submit'])){
        $borname = $_POST['borname'];
        $office = $_POST['office'];
        $bordate = $_POST['bordate'];
        $item_type = $_POST['item_type'];
        $itemselect = $_POST['itemselect'];
        $date=date_create($bordate);
        $date = date_format($date,"d-m-Y H:i:s");
        $view_id = "SELECT count(b_id) as count FROM borrowing ";
   
        if($view = mysqli_fetch_assoc(mysqli_query($conn,$view_id))){
            $makeid = "B00".($view['count']+1);
        }
      
        $insert = "INSERT INTO `borrowing`(`b_id`, `b_name`, `b_date`,
         `b_borower`, `b_agency`, `b_status`)
         VALUES ('".$makeid."','".$itemselect."','".$date."'
         ,'".$borname."','".$office."','ยืม')";
         $upitem = "UPDATE `items_1` SET `ag_status` = 'ยืม' WHERE `ag_id` ='".$itemselect."';";
         echo $upitem;
         if(mysqli_query($conn,$upitem)){
            if(mysqli_query($conn,$insert)){
            header("location:index.php");
            }
         }
    }
    if(isset($_POST['r_submit'])){
        $itemid = $_POST['itemid'];
        $r_id = $_POST['rid'];
        $return_p = $_POST['return_p'];
        $return_f = $_POST['office_r'];
       $r_sql = "UPDATE `borrowing` SET 
       b_return_p = '".$return_p."',b_status ='คืนแล้ว' WHERE `b_id` = '".$r_id."'";
       $item_sql =  $upitem = "UPDATE `items_1` SET `ag_status` = 'พร้อมใช้งาน' WHERE `ag_id` ='".$itemid."';";
      // echo $item_sql;
       if(mysqli_query($conn,$item_sql)){
       if(mysqli_query($conn,$r_sql)){
        header("location:index.php");
       }
    }
    }
?>