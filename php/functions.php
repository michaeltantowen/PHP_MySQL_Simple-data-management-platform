<?php

$conn = mysqli_connect('localhost', 'root', '', 'student-database');

$result = mysqli_query($conn, "SELECT * FROM student");

$rows = [];
while($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}

function query($query) {
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function postData($data) {
  global $conn;
  $name = htmlspecialchars($data['name']);
  $NIM = htmlspecialchars($data['NIM']);
  $email = htmlspecialchars($data['email']);
  $major = htmlspecialchars($data['major']);

  $query = "INSERT INTO student VALUES('', '$name', '$NIM', '$email', '$major')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);

}

function search($keyword) {
  $query = "SELECT * FROM student WHERE 
    name LIKE '%$keyword%' OR
    NIM LIKE '%$keyword%' OR
    email LIKE '%$keyword%' OR
    major LIKE '%$keyword%'
  ";
  return query($query);
}

function updateData($data) {
  global $conn;
  $id = $data['id'];
  $name = htmlspecialchars($data['name']);
  $NIM = htmlspecialchars($data['NIM']);
  $email = htmlspecialchars($data['email']);
  $major = htmlspecialchars($data['major']);

  $query = "UPDATE student SET
    name = '$name',
    nim = '$NIM',
    email = '$email',
    major = '$major'
    WHERE id = $id
  ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// function delete Data
function deleteData($data) {
  global $conn;
  mysqli_query($conn, "DELETE FROM student WHERE id = $data");
  header("Location: dashboard.php");
}


if(isset($_GET['id']) && isset($_GET['task'])) {
  if($_GET['task'] == "delete-data") {
    $data = $_GET['id'];
    deleteData($data);
  }
}

function register($data) {
  global $conn;

  $username = strtolower(stripslashes($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  $checkSameUsername = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

  if($password1 !== $password2) {
    echo "<script>
      alert('Please input your password properly!');
    </script>";
    return false;
  }

  if(mysqli_fetch_assoc($checkSameUsername)) {
    echo "<script>
      alert('Username is already used, Please use another username!');
    </script>";
    return false;
  }

  $password1 = password_hash($password1, PASSWORD_DEFAULT);

  mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password1')");

  return mysqli_affected_rows($conn);
}

?>