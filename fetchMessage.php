<?php
session_start();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
unset($_SESSION['message']); // Hapus pesan setelah diambil

echo json_encode(['message' => $message]);
