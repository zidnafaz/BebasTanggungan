<?php
// Fungsi untuk mencari file berdasarkan nama di direktori tertentu
function findFile($directory, $fileName) {
    $result = [];
    
    // Scan direktori
    $files = scandir($directory);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        // Cek apakah file yang ditemukan adalah file atau direktori
        $filePath = $directory . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filePath)) {
            // Cari di dalam subdirektori
            $result = array_merge($result, findFile($filePath, $fileName));
        } else {
            // Cocokkan nama file
            if ($file === $fileName) {
                $result[] = $filePath;
            }
        }
    }
    return $result;
}

// Proses input pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileName = trim($_POST['file_name']);
    $suffix = trim($_POST['suffix']);
    $fullFileName = $fileName . $suffix;
    $selectedDir = $_POST['directory'];

    if (!empty($fileName) && !empty($selectedDir)) {
        if (is_dir($selectedDir)) {
            $foundFiles = findFile($selectedDir, $fullFileName);
            if (!empty($foundFiles)) {
                echo "<h3>File ditemukan:</h3><ul>";
                foreach ($foundFiles as $file) {
                    echo "<li>" . htmlspecialchars($file) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>File tidak ditemukan di direktori $selectedDir.</p>";
            }
        } else {
            echo "<p>Direktori yang dipilih tidak valid.</p>";
        }
    } else {
        echo "<p>Masukkan nama file dan pilih direktori yang valid.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari File</title>
</head>
<body>
    <h1>Cari File di Direktori</h1>
    <form method="post">
        <label for="file_name">Nama File:</label>
        <input type="text" id="file_name" name="file_name" placeholder="Masukkan nama file" required>
        <span id="file_suffix"></span>
        <br><br>
        
        <label>Pilih Direktori:</label>
        <button type="button" onclick="selectDirectory('dir1')">ijazah</button>
        <button type="button" onclick="selectDirectory('dir2')">Direktori 2</button>
        <button type="button" onclick="selectDirectory('dir3')">Direktori 3</button>
        
        <input type="hidden" id="directory" name="directory" value="">
        <input type="hidden" id="suffix" name="suffix" value="">
        <br><br>
        
        <button type="submit">Cari</button>
    </form>

    <script>
        let currentSuffix = ""; // Menyimpan suffix yang saat ini digunakan

        function selectDirectory(dir) {
            const directories = {
                'dir1': 'uploads/ijazah',
                'dir2': '/path/to/directory2',
                'dir3': '/path/to/directory3',
            };

            const suffixes = {
                'dir1': '_ijazah.jpg',
                'dir2': '_direktori2',
                'dir3': '_direktori3',
            };

            // Set nilai direktori terpilih ke input hidden
            document.getElementById('directory').value = directories[dir];
            
            // Atur suffix berdasarkan direktori
            currentSuffix = suffixes[dir];
            document.getElementById('suffix').value = currentSuffix;

            // Tampilkan suffix di sebelah input
            document.getElementById('file_suffix').textContent = currentSuffix;

            alert('Direktori terpilih: ' + directories[dir]);
        }
    </script>
</body>
</html>
