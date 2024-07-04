<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUsername() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : '';
}
?>