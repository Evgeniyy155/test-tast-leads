<?php
if (isset($_SESSION['success'])) {
    echo "<p style='color: green;'>" . htmlspecialchars($_SESSION['success']) . "</p>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<p style='color: red;'>" . htmlspecialchars($error) . "</p>";
    }
    unset($_SESSION['errors']);
}