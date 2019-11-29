<?php
echo $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
} else {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
}

echo '<br>firstname: ' . $firstname;
echo '<br>lastname: ' . $lastname;

/*
