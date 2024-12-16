<?php
session_start();         // Mulai session
session_unset();         // Hapus semua data session
session_destroy();       // Hancurkan session
header("Location: index.html"); // Arahkan pengguna ke halaman login
exit();
?>
