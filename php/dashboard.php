<?php

session_start();

if(!isset($_SESSION['login'])) {
  header('Location: ../index.php');
  exit;
}

require 'functions.php';

$data = query("SELECT * FROM student ORDER BY name");
$ascending = true;
$descending = false;

if(isset($_POST['descending'])) {
  $data = query("SELECT * FROM student ORDER BY name DESC");
  $ascending = false;
  $descending = true;
}

if(isset($_GET['id']) && isset($_GET['task'])) {
  if($_GET['task'] === "edit-data") {
    $id = $_GET['id'];
    $editData = query("SELECT * FROM student WHERE id = $id")[0];
  }
}

if(isset($_POST['add-student-data'])) {
  if(postData($_POST) > 0) {
    $data = query("SELECT * FROM student");
  } else {
    echo "<script> alert('Data not uploaded<br>Please Check your input!') </script>";
  }
}

if(isset($_POST['edit-student-data'])) {
  if(updateData($_POST) > 0) {
    header("Location: dashboard.php");
  } else {
    echo "<script> alert('Data not edited. Please Check your input!') </script>";
    header("Location: dashboard.php");

  }
}

if(isset($_POST['logout'])) {
  $_SESSION = [];
  session_unset();
  session_destroy();
  header("Location: ../index.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/all.css">

    <?php if(isset($editData)) : ?>
      <script>
        $(document).ready(function(){
            $("#editDataModal").modal('show');
        });
      </script> 
    <?php endif ?>

    <title>Dashboard</title>
  </head>
  <body class="container">
    
    <div class="display-4 text-info text-center mt-3 mb-3">Student Data Management Platform</div>

    <div class="feature d-flex justify-content-around mt-5 mb-3">
      <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#addDataModal">
        Add New Student Data
      </button>
      <form action="" method="POST">
        <div class="input-group">
          <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search Student" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text"><i class="fas fa-search"></i></div>
          </div>
        </div>
      </form>
      <form action="" method="POST">
        <?php if($ascending == false) : ?>
          <button type="submit" id="ascending" name="ascending" class="btn btn-info">Order By Ascending Order ^</button>
        <?php elseif($descending == false) : ?>
          <button type="submit" id="descending" name="descending" class="btn btn-info">Order By Descending Order v</button>
        <?php endif; ?>
      </form>
      <form action="" method="POST">
        <button type="submit" name="logout" class="btn btn-danger pl-3 pr-3">Logout</button>
      </form>
    </div>

    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Add Student Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="NIM">NIM</label>
                <input type="text" class="form-control" name="NIM" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="major">Major</label>
                <input type="text" class="form-control" name="major" autocomplete="off">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="add-student-data" class="btn btn-info">Add Student Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="live-search">
      <table class="table table-striped mb-5">
        <thead>
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Name</th>
            <th scope="col">NIM</th>
            <th scope="col">Email</th>
            <th scope="col">Major</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach($data as $info) : ?>
            <tr>
              <th scope="row"><?= $no ?></th>
              <td><?= $info['name'] ?></td>
              <td><?= $info['NIM'] ?></td>
              <td><?= $info['email'] ?></td>
              <td><?= $info['major'] ?></td>
              <td class="text-center">
                <a href="functions.php?id= <?= $info['id']; ?>&task=delete-data" onclick="return confirm('Delete Student Data?')"><i class="fa-lg fas fa-trash-alt ml-1 mr-1 text-info"></i></a>
                <a href="dashboard.php?id= <?= $info['id']; ?>&task=edit-data"><i class="fa-lg fas fa-user-edit ml-1 mr-1 text-info"></i></a>
              </td>
            </tr>
            <?php $no++; ?>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
   
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Edit Student Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <input type="hidden" name="id" value="<?= $editData['id'] ?>">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="<?= $editData['name'] ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="NIM">NIM</label>
                <input type="text" class="form-control" name="NIM" value="<?= $editData['NIM'] ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" value="<?= $editData['email'] ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="major">Major</label>
                <input type="text" class="form-control" name="major" value="<?= $editData['major'] ?>" autocomplete="off">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="edit-student-data" class="btn btn-info">Edit Student Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/all.js"></script>
    <script src="../js/script.js"></script>
  </body>
</html>