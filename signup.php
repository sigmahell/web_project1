<?php 

$status = $_GET['status'] ?? null;
$status = $_GET['message'] ?? null;
?>

<!DOCTYPE html> 
<html lang ="end">
<head> 

    <meta charset="UTF-8">
    <title> NightLock - Sign Up </title>

</head>
</html>

    <div class = "signup-container">
        <h1>NightLock</h1>
        <p> Create an account to access features</p>

        <php if ($status === 'error'): ?>
            <p class="error ">Account created successfully! Please log in.</p>
    </div>