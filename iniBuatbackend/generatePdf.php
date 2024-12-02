<?php
include 'koneksi.php';
try {
    // Query untuk mengambil data skripsi
    $sql = "SELECT m.nim, m.nama_mahasiswa, m.jurusan_mahasiswa, m.prodi_mahasiswa
            FROM dbo.mahasiswa m
            WHERE m.nim = ?";
    if (isset($_COOKIE['id'])) {
        $username = $_COOKIE['id'];
    } else {
        $username = ''; // Atur default jika tidak ada sesi
    }

    $params = array($username);
    $result = sqlsrv_query($conn, $sql, $params);

    if ($result === false) {
        die("Kesalahan saat menjalankan query: " . print_r(sqlsrv_errors(), true));
    }

    $nama_mahasiswa = "";

    // Ambil data dan cek apakah ada
    if ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $nama_mahasiswa = $row['nama_mahasiswa'];
        $nim = $row['nim'];
    }

    sqlsrv_free_stmt($result);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PDF dengan Font Custom</title>
    <script type="module">
        import {
            PDFDocument,
            rgb
        } from 'https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/+esm';

        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('editPdf');

            button.addEventListener('click', async () => {
                try {
                    // Akses cookie menggunakan JavaScript
                    const allCookies = document.cookie; // Mendapatkan semua cookie
                    console.log("Semua cookie:", allCookies);

                    // Fungsi untuk mendapatkan nilai cookie tertentu
                    function getCookie(name) {
                        const nameEQ = name + "=";
                        const cookies = document.cookie.split("; ");
                        for (let i = 0; i < cookies.length; i++) {
                            const c = cookies[i];
                            if (c.indexOf(nameEQ) === 0) {
                                return c.substring(nameEQ.length, c.length);
                            }
                        }
                        return null;
                    }

                    // Contoh: Mendapatkan cookie "user"
                    const username = getCookie('id');
                    console.log("Nilai cookie 'id':", username);
                    // Path ke file PDF dan font
                    const pdfPath = './kemm.pdf';
                    const fontPath = './TimesNewRoman/TimesNewRoman.ttf';

                    // Muat PDF
                    const pdfResponse = await fetch(pdfPath);
                    if (!pdfResponse.ok) throw new Error(`Could not load PDF: ${pdfResponse.statusText}`);
                    const pdfArrayBuffer = await pdfResponse.arrayBuffer();
                    const pdfDoc = await PDFDocument.load(pdfArrayBuffer);

                    // Registrasikan fontkit
                    pdfDoc.registerFontkit(window.fontkit);

                    // Muat font kustom
                    const fontResponse = await fetch(fontPath);
                    if (!fontResponse.ok) throw new Error(`Could not load font: ${fontResponse.statusText}`);
                    const fontArrayBuffer = await fontResponse.arrayBuffer();
                    const timesFont = await pdfDoc.embedFont(fontArrayBuffer);

                    // Tambahkan teks ke halaman pertama
                    const pages = pdfDoc.getPages();
                    const firstPage = pages[0];
                    const nama = "<?php echo htmlspecialchars($nama_mahasiswa, ENT_QUOTES, 'UTF-8'); ?>";
                    const nim = "<?php echo htmlspecialchars($nim, ENT_QUOTES, 'UTF-8'); ?>";

                    firstPage.drawText(`${nama}`, {
                        x: 0,
                        y: 0,
                        size: 40,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });

                    firstPage.drawText(`${nim}`, {
                        x: 0,
                        y: 50,
                        size: 40,
                        font: timesFont,
                        color: rgb(0, 0, 0),
                    });


                    // Simpan PDF baru
                    const modifiedPdf = await pdfDoc.save();
                    const blob = new Blob([modifiedPdf], {
                        type: 'application/pdf'
                    });

                    // Unduh PDF yang sudah diedit
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'edited_sample_with_custom_font.pdf';
                    link.click();
                } catch (error) {
                    console.error('Terjadi error:', error);
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@pdf-lib/fontkit@0.0.4/dist/fontkit.umd.min.js"></script>
</head>

<body>
    <button id="editPdf">Edit PDF</button>
</body>

</html>