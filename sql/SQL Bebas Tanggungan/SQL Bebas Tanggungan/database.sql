use Bebas_Tanggungan

-- Insert Dummy Data Mahasiswa
INSERT INTO mahasiswa (nim, nama_mahasiswa, nomor_telfon_mahasiswa, alamat_mahasiswa, jurusan_mahasiswa, prodi_mahasiswa, jenis_kelamin_mahasiswa, tahun_angkatan_mahasiswa, tahun_lulus_mahasiswa, tanggal_lahir_mahasiswa)
VALUES
('20230001', 'Ahmad Maulana', '081234567890', 'Jl. Mawar No. 1', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2004-02-15'),
('20230002', 'Budi Santoso', '081345678901', 'Jl. Melati No. 2', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2003-09-20'),
('20230003', 'Citra Ayu', '081456789012', 'Jl. Kenanga No. 3', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2019-08-01', '2023-08-01', '2004-05-30'),
('20230004', 'Dewi Lestari', '081567890123', 'Jl. Anggrek No. 4', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2021-08-01', '2024-08-01', '2003-12-10'),
('20230005', 'Eko Prasetyo', '081678901234', 'Jl. Tulip No. 5', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2019-08-01', '2023-08-01', '2004-06-25'),
('20230006', 'Faisal Rahman', '081789012345', 'Jl. Durian No. 6', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2004-03-14'),
('20230007', 'Gina Wulandari', '081890123456', 'Jl. Mawar No. 7', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2021-08-01', '2025-08-01', '2004-07-21'),
('20230008', 'Hendra Kurniawan', '081901234567', 'Jl. Melati No. 8', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2019-08-01', '2023-08-01', '2003-10-12'),
('20230009', 'Indra Satria', '081012345678', 'Jl. Kenanga No. 9', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2004-01-25'),
('20230010', 'Juliya Rahayu', '081123456789', 'Jl. Anggrek No. 10', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2021-08-01', '2025-08-01', '2003-11-05'),
('20230011', 'Krisna Prabowo', '081234567890', 'Jl. Tulip No. 11', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2004-04-18'),
('20230012', 'Lina Ramadhani', '081345678901', 'Jl. Mawar No. 12', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2019-08-01', '2023-08-01', '2004-06-01'),
('20230013', 'Marta Oktaviana', '081456789012', 'Jl. Melati No. 13', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2021-08-01', '2025-08-01', '2003-05-25'),
('20230014', 'Nico Dwi Putra', '081567890123', 'Jl. Kenanga No. 14', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2004-07-09'),
('20230015', 'Oka Prabawa', '081678901234', 'Jl. Anggrek No. 15', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2003-03-15'),
('20230016', 'Panca Budi', '081789012345', 'Jl. Tulip No. 16', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2021-08-01', '2025-08-01', '2004-10-02'),
('20230017', 'Qistina Amalia', '081890123456', 'Jl. Durian No. 17', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2021-08-01', '2025-08-01', '2003-12-25'),
('20230018', 'Rizky Aditya', '081901234567', 'Jl. Melati No. 18', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2019-08-01', '2023-08-01', '2004-04-09'),
('20230019', 'Siska Anggraini', '081012345678', 'Jl. Kenanga No. 19', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2020-08-01', '2024-08-01', '2004-11-17'),
('20230020', 'Teguh Setiawan', '081123456789', 'Jl. Anggrek No. 20', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2003-08-28'),
('20230021', 'Uliya Mutiara', '081234567890', 'Jl. Mawar No. 21', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2021-08-01', '2025-08-01', '2004-01-11'),
('20230022', 'Vina Arini', '081345678901', 'Jl. Tulip No. 22', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2019-08-01', '2023-08-01', '2003-05-16'),
('20230023', 'Wira Pramudya', '081456789012', 'Jl. Durian No. 23', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2004-02-20'),
('20230024', 'Xenia Shofia', '081567890123', 'Jl. Kenanga No. 24', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2021-08-01', '2025-08-01', '2003-06-12'),
('20230025', 'Yusuf Purnama', '081678901234', 'Jl. Anggrek No. 25', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2021-08-01', '2025-08-01', '2004-05-03'),
('20230026', 'Zara Fitriani', '081789012345', 'Jl. Tulip No. 26', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2019-08-01', '2023-08-01', '2004-09-27'),
('20230027', 'Amirul Hakim', '081890123456', 'Jl. Durian No. 27', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2020-08-01', '2024-08-01', '2003-07-14'),
('20230028', 'Bintang Rahardja', '081901234567', 'Jl. Mawar No. 28', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2021-08-01', '2025-08-01', '2003-04-01'),
('20230029', 'Cecilia Lestari', '081012345678', 'Jl. Melati No. 29', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'P', '2019-08-01', '2023-08-01', '2004-02-28'),
('20230030', 'David Kurniawan', '081123456789', 'Jl. Kenanga No. 30', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'L', '2021-08-01', '2025-08-01', '2004-12-05');

-- Dummy data for the [dbo].[admin] table
INSERT INTO [dbo].[admin] (
    [id_karyawan],
    [nama_karyawan],
    [nomor_telfon_karyawan],
    [alamat_karyawan],
    [tanggal_lahir_karyawan],
    [jenis_kelamin_karyawan]
) VALUES
('10230004', 'Safrilia', '081333213023', 'Jl. Merdeka No. 1, Jakarta', '1990-05-15', 'P'),
('10230003', 'Merry', '082247723596', 'Jl. Pahlawan No. 22, Bandung', '1988-12-20', 'P'),
('10230001', 'Ila', '081232245969', 'Jl. Mawar No. 10, Surabaya', '1992-08-11', 'P'),
('10230002', 'Widya Novy', '082232867789', 'Jl. Kenangan No. 5, Yogyakarta', '1995-03-25', 'P');

-- TAMBAH ADMIN PERPUS DAN ADMIN PUSAT
use Bebas_Tanggungan;
INSERT into dbo.[login] (username, password, status) VALUES(
    '10230004', 'admin', 'adminPerpus'
)
INSERT into dbo.[login] (username, password, status) VALUES(
    '10230003', 'admin', 'adminPusat'
)
INSERT into dbo.[login] (username, password, status) VALUES(
    '10230001', 'admin', 'adminLt6'
)
INSERT into dbo.[login] (username, password, status) VALUES(
    '10230002', 'admin', 'adminLt7'
)
