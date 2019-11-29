<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <title>Page-1</title>
</head>
<body>
<div class="container">
    <ul>
        <li><a href="/test/index.php">home</a></li>
        <li><a href="/test/subfolder/page-1.php">page</a></li>
        <li><a href="/test/subfolder/form.php">form</a></li>
    </ul>
    <h2>Form GET</h2>
    <form action="../process/action.php" method="GET">
        First name:<br>
        <input type="text" name="firstname" value="Mickey">
        <br>
        Last name:<br>
        <input type="text" name="lastname" value="Mouse">
        <br><br>
        <input type="submit" value="Submit">
    </form> 
    <h2>Form POST</h2>
    <form action="../process/action.php" method="POST">
        First name:<br>
        <input type="text" name="firstname" value="Mickey">
        <br>
        Last name:<br>
        <input type="text" name="lastname" value="Mouse">
        <br><br>
        <input type="submit" value="Submit">
    </form> 
</div>
<script src="../js/script.js"></script>
</body>
</html>