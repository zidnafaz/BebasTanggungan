<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File ke Direktori Dinamis</title>
    <script>
        // Fungsi untuk mengubah direktori tujuan
        function setUploadDirectory(directory) {
            document.getElementById("uploadDir").value = directory; // Mengatur nilai input hidden
        }
    </script>
</head>
<body>
    <h1>Upload File ke Direktori yang Dipilih</h1>
    <!-- Pilihan direktori -->
    <button onclick="setUploadDirectory('uploads/documents')">Documents</button>
    <button onclick="setUploadDirectory('uploads/images')">Images</button>
    <button onclick="setUploadDirectory('uploads/others')">Others</button>

    <!-- Form upload file -->
    <form action="ubahnamaotomatis.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="uploadDir" name="uploadDir" value="uploads/documents"> <!-- Default directory -->
        
        <label for="file">Pilih file:</label>
        <input type="file" name="file" id="file" required><br><br>
        
        <button type="submit">Upload</button>
    </form>
</body>
</html>
