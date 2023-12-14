<?php
$insert = false; //for alert after navbar
//connestion to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";


//creating a connection to the database
$conn = mysqli_connect($servername, $username, $password, $database);


//error handaling
/*
if(!$conn){
  die("sorry connection faild". mysqli_connect_error());
}
else{
  echo "connection successful";
}
*/

//inserting the dat into the database



if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($POST['snoEdit'])) {
    echo "yes";
  }
  $title = $_POST["title"];
  $description = $_POST["description"];

  $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $insert = true;
  } else {
    echo " result not inserted";
  }
}



?>


<?php
/* 
testing method
echo $_SERVER['REQUEST_METHOD'];*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>iNotes - Notes Taking app</title>

</head>



<body>



  <!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit this node</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form action="/iNotes/index.php" method="POST">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
                <label for="title" class="form-label">Notes Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Notes Description</label>
                <div class="form-floating">
                  <textarea class="form-control" placeholder="" id="descriptionEdit" name="descriptionEdit" style="height: 100px"></textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>






  
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crud/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>










  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">About <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">Contact <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
    </div>
  </nav>

  <?php
  if ($insert) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your note has been added successfully.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
  }
  ?>

  <div class="container p-5">
    <form action="/iNotes/index.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Notes Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Notes Description</label>
        <div class="form-floating">
          <textarea class="form-control" placeholder="" id="description" name="description" style="height: 100px"></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Add Notes</button>
    </form>
  </div>


  <div class="container p-5">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.no</th>
          <th scope="col">Note Title</th>
          <th scope="col">Note Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $sno = $sno + 1;
          echo "<tr>
         <th scope='row'>$sno</th>
                     <td>" . $row['title'] . "</td>
                     <td>" . $row['description'] . "</td>
                      <td> <button type='button' class='edit btn btn-primary' id=" . $row['sno'] . ">
                      Edit
                    </button></td>
          </tr>";
        }
        ?>


      </tbody>
    </table>
    <hr>
  </div>


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>

  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        descriptionEdit.value = description;
        titleEdit.value = title;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editmodal').modal('toggle');



      })
    })
  </script>
</body>

</html>