<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'messages.php'; ?>

<h1>Add Lead</h1>
<form method="POST" action="handler.php?action=addLead">
    <div>
        <label for="firstName">Firstname:</label>
        <input type="text" required name="firstName" id="firstName">
    </div>
    <div>
        <label for="lastName">Lastname:</label>
        <input type="text" name="lastName" id="lastName">
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone">
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
    </div>
    <button type="submit">Submit</button>
</form>
</body>
</html>