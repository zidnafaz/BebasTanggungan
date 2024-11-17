<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Status Pengumpulan</th>
            <th>Keterangan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../koneksi.php'; // Hubungkan ke database

        // Query untuk mendapatkan data dari tabel data_alumni
        $query = "SELECT status_pengumpulan_data_alumni, keterangan_pengumpulan_data_alumni FROM data_alumni";
        $result = mysqli_query($koneksi, $query);

        // Periksa apakah ada data
        if (mysqli_num_rows($result) > 0) {
            // Looping untuk setiap baris data
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['status_pengumpulan_data_alumni']}</td>
                        <td>{$row['keterangan_pengumpulan_data_alumni']}</td>
                        <td>
                            <button class='btn btn-success btn-sm edit-data' data-pdf='document.pdf' data-toggle='modal' data-target='#uploadModal'>
                                <i class='fa fa-solid fa-cloud-arrow-up'></i> Upload
                            </button>
                        </td>
                    </tr>";
            }
        } else {
            // Jika tidak ada data
            echo "<tr><td colspan='4'>Tidak ada data ditemukan</td></tr>";
        }
        ?>
    </tbody>
</table>
