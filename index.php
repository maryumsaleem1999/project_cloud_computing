

<!-- INSERT INTO `note` (`S.NO`, `title`, `description`, `action`) VALUES (NULL, 'breakfast', 'anda parathaa ', 'CURRENT_TIMESTAMP(6).000000'); -->


<?php

$insert = false;
$update = false;
$delete = false;
$servername = "localhost";
$username= "root";
$password = "";
$db ="todoapp";

$con = mysqli_connect($servername,$username,$password,$db);
if(!$con){
die("sorry we failed to connect the connect:" . mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `note` WHERE `S.NO` = $sno";
  $result = mysqli_query($con , $sql);
}
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if(isset($_POST['editsno'])){
    $sno = $_POST['editsno'];
    $title = $_POST["edittitle"];
    $description = $_POST["editdescription"];
     //update querry:
     $sql = "UPDATE `note` SET `title` = '$title' , `description` = '$description' WHERE `note`.`S.NO` = $sno";
     $result = mysqli_query($con , $sql);
     if($result){
       $update = true;
       
     }else{
       echo "not updated";
     }
   }else{
    
    $title = $_POST["title"];
    $description = $_POST["description"];
  
   $sql = "INSERT INTO `note` (`title`, `description`) VALUES ('$title', '$description')";
   $result = mysqli_query($con , $sql);
   if ($result){
     $insert = true;
        ?>
        <script>
         alert("inserted successfully");
        </script>
       <?php
       
   }else{
    echo "The record was not inserted successfully because of this error ---> ". mysqli_error($con);
 }
} 
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    
    <title>note!</title>
</head>
<body >
    <!-- <?php
    if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>MESSAGE!!</strong> Your note has been updated successfuly!!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
      
    ?> -->
    <?php
    if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>MESSAGE!!</strong> Your note has been updated successfuly!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    ?>
    <?php
    if($delete){
        echo "<div class='alert alert-primary alert-dismissible fade show' role='alert'>
        <strong>MESSAGE!!</strong> Your note has been deleted successfuly!!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
    }
    ?>
<!-- Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="edit modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit This Note:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
         </div>
         <div class="modal-body">
          <form class="pl-5" action="/todo_list_app/index.php" method="POST">
          <input type="hidden" class="editsno" id="editsno" name="editsno">
     <div class="form-group">
    <label for="title">TITLES</label>
    <input type="text" class="form-control" name="edittitle" id="edittitle" aria-describedby="emailHelp" >
    </div>
    <div class="form-group">
    <label for="exampleFormControlTextarea1">DISCRIPTION</label>
    <textarea class="form-control" name="editdescription" id="editdescription" rows="3"></textarea>
     </div>
      <button type="submit" class="btn btn-primary mb-5" >UPDATE YOUR NOTE</button>
     </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="container ml-5 mt-5">
<div class="col-sm-12 col-md-12 col-lg-12">
<form class="pl-5" action="/todo_list_app/index.php" method="POST">
<h3 class="mb-5"> ITS MINE TODO LIST APP </h3>
  <div class="form-group">
    <label for="title">TITLES</label><br>
    <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp" >
  </div>
  <div class="form-group">
    <label for="description">DISCRIPTION</label>
    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary mb-5">ADD note</button>
</form>

<div class="container">
    

<table class="table w-75 ml-4 mb-3" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.NO</th>
      <th scope="col">TITLE</th>
      <th scope="col">DESCRIPTION</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>

  <?php
    $sql = "SELECT * FROM `note`";
    $result = mysqli_query($con , $sql);
    $sno= 0;
    while ($row = mysqli_fetch_assoc($result)){
        $sno=$sno + 1;
        echo "<tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['title']."</td>
      <td>".$row['description']."</td>
      <td><button class='edit btn btn-sm btn-primary' id=".$row['S.NO'].">EDIT</button>  <button class='delete btn btn-sm btn-primary' id=d".$row['S.NO'].">DELETE</button></td>
    </tr>";
    }  
    ?>
  </tbody>
</table>
</div>
</div>
</div> 
<hr>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
   edits = document.getElementsByClassName('edit');
   Array.from(edits).forEach((element) => {
     element.addEventListener("click", (e)=>{
     console.log("edit");
     tr= e.target.parentNode.parentNode;
     title = tr.getElementsByTagName("td")[0].innerText;
     description =tr.getElementsByTagName("td")[1].innerText;
     console.log(title , description);
     edittitle.value = title;
     editdescription.value = description;
     editsno.value = e.target.id;
     console.log(e.target.id);
     $('#editmodal').modal('toggle');
     })
   })


   deletes = document.getElementsByClassName('delete');
   Array.from(deletes).forEach((element) => {
     element.addEventListener("click", (e)=>{
     console.log("delete");
     sno = e.target.id.substr(1);
     if(confirm("Are you sure u want to delete this note??")){
      console.log ("yes");
      window.location = `/todo_list_app/index.php?delete=${sno}`;
     }
     else{
      console.log ("no") ;
     }
     
     })
   })

</script>

</body>
</html>