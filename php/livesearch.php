<?php

require 'functions.php';

echo "Hello, World!";q

$keyword = $_GET['keyword'];

$query = "SELECT * FROM student WHERE 
    name LIKE '%$keyword%' OR
    NIM LIKE '%$keyword%' OR
    email LIKE '%$keyword%' OR
    major LIKE '%$keyword%'
  ";

$data = query($query);

?>

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