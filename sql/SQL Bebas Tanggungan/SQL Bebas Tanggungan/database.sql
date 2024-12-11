use Bebas_Tanggungan

SELECT * FROM dbo.[login]

SELECT * FROM dbo.[admin]

ALTER TABLE dbo.mahasiswa
ALTER COLUMN jurusan_mahasiswa VARCHAR(50);

update dbo.login
set status = 'adminlt7'
WHERE id_login = 1;

select * from dbo.mahasiswa

-- Insert Dummy Data Mahasiswa

INSERT INTO mahasiswa (nim, nama_mahasiswa, nomor_telfon_mahasiswa, alamat_mahasiswa, jurusan_mahasiswa, prodi_mahasiswa, jenis_kelamin_mahasiswa, tahun_angkatan_mahasiswa, tanggal_lahir_mahasiswa)
VALUES
('20230001', 'Ahmad Maulana', '081234567890', 'Jl. Mawar No. 1', 'Teknologi Informasi', 'Sistem Informasi', 'L', '2023-08-01', '2004-02-15'),
('20230002', 'Budi Santoso', '081345678901', 'Jl. Melati No. 2', 'Teknologi Informasi', 'Teknik Informatika', 'L', '2023-08-01', '2003-09-20'),
('20230003', 'Citra Ayu', '081456789012', 'Jl. Kenanga No. 3', 'Teknik Elektro', 'Teknik Elektronika', 'P', '2023-08-01', '2004-05-30'),
('20230004', 'Dewi Lestari', '081567890123', 'Jl. Anggrek No. 4', 'Teknik Sipil', 'Manajemen Proyek', 'P', '2023-08-01', '2003-12-10'),
('20230005', 'Eko Prasetyo', '081678901234', 'Jl. Tulip No. 5', 'Teknologi Informasi', 'Sistem Informasi', 'L', '2023-08-01', '2004-06-25');

SELECT * from login

INSERT INTO login (username, password, [status])
VALUES
('20230001', 'password123', 'mahasiswa'),
('20230002', 'password123', 'mahasiswa'),
('20230003', 'password123', 'mahasiswa'),
('20230004', 'password123', 'mahasiswa'),
('20230005', 'password123', 'mahasiswa');

INSERT INTO data_alumni (status_pengumpulan_data_alumni, keterangan_pengumpulan_data_alumni, nim)
VALUES
('terverifikasi', 'Data lengkap', '20230001'),
('belum upload', 'Menunggu upload', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Data salah', '20230004'),
('terverifikasi', 'Data lengkap', '20230005');

INSERT INTO skkm (status_pengumpulan_skkm, keterangan_pengumpulan_skkm, nim)
VALUES
('terverifikasi', 'Dokumen valid', '20230001'),
('belum upload', 'Dokumen belum ada', '20230002'),
('pending', 'Dalam proses', '20230003'),
('ditolak', 'Dokumen tidak valid', '20230004'),
('terverifikasi', 'Dokumen lengkap', '20230005');

INSERT INTO foto_ijazah (status_pengumpulan_foto_ijazah, keterangan_pengumpulan_foto_ijazah, nim)
VALUES
('terverifikasi', 'Foto jelas', '20230001'),
('belum upload', 'Foto belum ada', '20230002'),
('pending', 'Foto dalam proses', '20230003'),
('ditolak', 'Foto buram', '20230004'),
('terverifikasi', 'Foto lengkap', '20230005');

INSERT INTO ukt (status_pengumpulan_ukt, keterangan_pengumpulan_ukt, nim)
VALUES
('terverifikasi', 'Bukti pembayaran lengkap', '20230001'),
('belum upload', 'Bukti belum ada', '20230002'),
('pending', 'Bukti dalam proses', '20230003'),
('ditolak', 'Bukti salah', '20230004'),
('terverifikasi', 'Bukti lengkap', '20230005');
--
INSERT INTO penyerahan_hardcopy (status_pengumpulan_penyerahan_hardcopy, keterangan_pengumpulan_penyerahan_hardcopy, nim)
VALUES
('terverifikasi', 'Dokumen lengkap', '20230001'),
('belum upload', 'Dokumen belum diserahkan', '20230002'),
('pending', 'Dalam proses', '20230003'),
('ditolak', 'Dokumen rusak', '20230004'),
('terverifikasi', 'Dokumen valid', '20230005');

INSERT INTO tugas_akhir_softcopy (status_pengumpulan_tugas_akhir_softcopy, keterangan_pengumpulan_tugas_akhir_softcopy, nim)
VALUES
('terverifikasi', 'Softcopy lengkap', '20230001'),
('belum upload', 'Softcopy belum ada', '20230002'),
('pending', 'Dalam proses', '20230003'),
('ditolak', 'Format salah', '20230004'),
('terverifikasi', 'Softcopy valid', '20230005');

INSERT INTO bebas_pinjam_buku_perpustakaan (status_pengumpulan_bebas_pinjam_buku_perpustakaan, keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan, nim)
VALUES
('terverifikasi', 'Bebas pinjam', '20230001'),
('belum upload', 'Belum ada bukti', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Masih ada pinjaman', '20230004'),
('terverifikasi', 'Bebas pinjam', '20230005');

INSERT INTO hasil_kuisioner (status_pengumpulan_hasil_kuisioner, keterangan_pengumpulan_hasil_kuisioner, nim)
VALUES
('terverifikasi', 'Hasil lengkap', '20230001'),
('belum upload', 'Hasil belum ada', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Hasil invalid', '20230004'),
('terverifikasi', 'Hasil valid', '20230005');

INSERT INTO penyerahan_skripsi (status_pengumpulan_penyerahan_skripsi, keterangan_pengumpulan_penyerahan_skripsi, nim)
VALUES
('terverifikasi', 'Skripsi lengkap', '20230001'),
('belum upload', 'Skripsi belum ada', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Format salah', '20230004'),
('terverifikasi', 'Skripsi valid', '20230005');

INSERT INTO penyerahan_pkl (status_pengumpulan_penyerahan_pkl, keterangan_pengumpulan_penyerahan_pkl, nim)
VALUES
('terverifikasi', 'Laporan lengkap', '20230001'),
('belum upload', 'Laporan belum ada', '20230002'),
('pending', 'Dalam proses', '20230003'),
('ditolak', 'Format salah', '20230004'),
('terverifikasi', 'Laporan valid', '20230005');

INSERT INTO toeic (status_pengumpulan_toeic, keterangan_pengumpulan_toeic, nim)
VALUES
('terverifikasi', 'Skor valid', '20230001'),
('belum upload', 'Dokumen belum ada', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Dokumen salah', '20230004'),
('terverifikasi', 'Skor lengkap', '20230005');

INSERT INTO bebas_kompen (status_pengumpulan_bebas_kompen, keterangan_pengumpulan_bebas_kompen, nim)
VALUES
('terverifikasi', 'Bebas kompen', '20230001'),
('belum upload', 'Dokumen belum ada', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Masih ada kompen', '20230004'),
('terverifikasi', 'Bebas kompen', '20230005');

INSERT INTO penyerahan_kebenaran_data (status_pengumpulan_penyerahan_kebenaran_data, keterangan_pengumpulan_penyerahan_kebenaran_data, nim)
VALUES
('terverifikasi', 'Data valid', '20230001'),
('belum upload', 'Data belum diserahkan', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Data tidak sesuai', '20230004'),
('terverifikasi', 'Data valid', '20230005');

INSERT INTO publikasi_jurnal (status_pengumpulan_publikasi_jurnal, keterangan_pengumpulan_publikasi_jurnal, nim)
VALUES
('terverifikasi', 'Jurnal lengkap', '20230001'),
('belum upload', 'Jurnal belum ada', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Format salah', '20230004'),
('terverifikasi', 'Jurnal valid', '20230005');

INSERT INTO aplikasi (status_pengumpulan_aplikasi, keterangan_pengumpulan_aplikasi, nim)
VALUES
('terverifikasi', 'Aplikasi diterima', '20230001'),
('belum upload', 'Aplikasi belum ada', '20230002'),
('pending', 'Proses evaluasi', '20230003'),
('ditolak', 'Aplikasi ditolak', '20230004'),
('terverifikasi', 'Aplikasi valid', '20230005');

INSERT INTO skripsi (status_pengumpulan_skripsi, keterangan_pengumpulan_skripsi, nim)
VALUES
('terverifikasi', 'Skripsi lengkap', '20230001'),
('belum upload', 'Skripsi belum ada', '20230002'),
('pending', 'Proses verifikasi', '20230003'),
('ditolak', 'Format salah', '20230004'),
('terverifikasi', 'Skripsi valid', '20230005');

-- Dummy data for the [dbo].[admin] table
INSERT INTO [dbo].[admin] (
    [id_karyawan],
    [nama_karyawan],
    [nomor_telfon_karyawan],
    [alamat_karyawan],
    [tanggal_lahir_karyawan],
    [jenis_kelamin_karyawan]
) VALUES
('20230006', 'Safrilia', '081333213023', 'Jl. Merdeka No. 1, Jakarta', '1990-05-15', 'P'),
('20230007', 'Merry', '082247723596', 'Jl. Pahlawan No. 22, Bandung', '1988-12-20', 'P'),
('20230008', 'Ila', '081232245969', 'Jl. Mawar No. 10, Surabaya', '1992-08-11', 'P'),
('20230009', 'Widya Novy', '082232867789', 'Jl. Kenangan No. 5, Yogyakarta', '1995-03-25', 'P');

-- TAMBAH ADMIN PERPUS DAN ADMIN PUSAT
use Bebas_Tanggungan;
INSERT into dbo.[login] (username, password, status) VALUES(
    '20230006', 'admin', 'adminPerpus'
)
INSERT into dbo.[login] (username, password, status) VALUES(
    '20230007', 'admin', 'adminPusat'
)
INSERT into dbo.[login] (username, password, status) VALUES(
    '20230008', 'admin', 'adminLt6'
)
INSERT into dbo.[login] (username, password, status) VALUES(
    '20230009', 'admin', 'adminLt7'
)

SELECT * FROM dbo.mahasiswa

-- Insert data ke tabel adminlt6_konfirmasi
INSERT INTO [dbo].[adminlt6_konfirmasi] (nim, tanggal_adminlt6_konfirmasi)
VALUES 
('20230001', '2024-12-01'),
('20230002', '2024-12-01'), 
('20230003', '2024-12-01'), 
('20230004', '2024-12-01'), 
('20230005', '2024-12-02');

-- Insert data ke tabel adminlt7_konfirmasi
INSERT INTO [dbo].[adminlt7_konfirmasi] (nim, tanggal_adminlt7_konfirmasi)
VALUES 
('20230001', '2024-12-01'),
('20230002', '2024-12-01'), 
('20230003', '2024-12-01'), 
('20230004', '2024-12-01'), 
('20230005', '2024-12-02');

-- Insert data ke tabel adminPusat_konfirmasi
INSERT INTO [dbo].[adminPusat_konfirmasi] (nim, tanggal_adminPusat_konfirmasi)
VALUES 
('20230001', '2024-12-01'),
('20230002', '2024-12-01'), 
('20230003', '2024-12-01'), 
('20230004', '2024-12-01'), 
('20230005', '2024-12-02');

-- Insert data ke tabel adminPerpus_konfirmasi
INSERT INTO [dbo].[adminPerpus_konfirmasi] (nim, tanggal_adminPerpus_konfirmasi)
VALUES 
('20230001', '2024-12-01'),
('20230002', '2024-12-01'), 
('20230003', '2024-12-01'), 
('20230004', '2024-12-01'), 
('20230005', '2024-12-02');

SELECT * FROM adminPerpus_konfirmasi
-- Query Konfirmasi Admin Tiap User

SELECT 
    m.nim,
    m.nama_mahasiswa AS nama,
    skr.status_pengumpulan_skripsi AS status_pengumpulan_skripsi,
    apl.status_pengumpulan_aplikasi AS status_pengumpulan_aplikasi,
    pj.status_pengumpulan_publikasi_jurnal AS status_pengumpulan_publikasi_jurnal
FROM 
    mahasiswa m
LEFT JOIN 
    skripsi skr ON m.nim = skr.nim
LEFT JOIN 
    aplikasi apl ON m.nim = apl.nim
LEFT JOIN 
    publikasi_jurnal pj ON m.nim = pj.nim
WHERE 
    skr.status_pengumpulan_skripsi = 'pending' 
    OR apl.status_pengumpulan_aplikasi = 'pending' 
    OR pj.status_pengumpulan_publikasi_jurnal = 'pending';

-- Union UNTUK SURAT REKOMENDASI -- Query untuk menampilkan data mahasiswa yang sudah terverifikasi pada semua tabel atau berkas

SELECT nim, nama_mahasiswa, nomor_telfon_mahasiswa
FROM mahasiswa
WHERE nim IN (
    SELECT nim FROM data_alumni WHERE status_pengumpulan_data_alumni = 'terverifikasi'
    UNION
    SELECT nim FROM skkm WHERE status_pengumpulan_skkm = 'terverifikasi'
    UNION
    SELECT nim FROM foto_ijazah WHERE status_pengumpulan_foto_ijazah = 'terverifikasi'
    UNION
    SELECT nim FROM ukt WHERE status_pengumpulan_ukt = 'terverifikasi'
    UNION
    SELECT nim FROM penyerahan_hardcopy WHERE status_pengumpulan_penyerahan_hardcopy = 'terverifikasi'
    UNION
    SELECT nim FROM tugas_akhir_softcopy WHERE status_pengumpulan_tugas_akhir_softcopy = 'terverifikasi'
    UNION
    SELECT nim FROM bebas_pinjam_buku_perpustakaan WHERE status_pengumpulan_bebas_pinjam_buku_perpustakaan = 'terverifikasi'
    UNION
    SELECT nim FROM hasil_kuisioner WHERE status_pengumpulan_hasil_kuisioner = 'terverifikasi'
    UNION
    SELECT nim FROM penyerahan_skripsi WHERE status_pengumpulan_penyerahan_skripsi = 'terverifikasi'
    UNION
    SELECT nim FROM penyerahan_pkl WHERE status_pengumpulan_penyerahan_pkl = 'terverifikasi'
    UNION
    SELECT nim FROM toeic WHERE status_pengumpulan_toeic = 'terverifikasi'
    UNION
    SELECT nim FROM bebas_kompen WHERE status_pengumpulan_bebas_kompen = 'terverifikasi'
    UNION
    SELECT nim FROM penyerahan_kebenaran_data WHERE status_pengumpulan_penyerahan_kebenaran_data = 'terverifikasi'
    UNION
    SELECT nim FROM publikasi_jurnal WHERE status_pengumpulan_publikasi_jurnal = 'terverifikasi'
    UNION
    SELECT nim FROM aplikasi WHERE status_pengumpulan_aplikasi = 'terverifikasi'
    UNION
    SELECT nim FROM skripsi WHERE status_pengumpulan_skripsi = 'terverifikasi'
) 

-- UNION ALL

SELECT 
    m.nim,
    m.nama_mahasiswa AS nama,
    'skripsi' AS jenis_status,
    skr.status_pengumpulan_skripsi AS status_pengumpulan
FROM 
    mahasiswa m
JOIN 
    skripsi skr ON m.nim = skr.nim
WHERE 
    skr.status_pengumpulan_skripsi = 'pending'

UNION

SELECT 
    m.nim,
    m.nama_mahasiswa AS nama,
    'aplikasi' AS jenis_status,
    apl.status_pengumpulan_aplikasi AS status_pengumpulan
FROM 
    mahasiswa m
JOIN 
    aplikasi apl ON m.nim = apl.nim
WHERE 
    apl.status_pengumpulan_aplikasi = 'pending'

UNION

SELECT 
    m.nim,
    m.nama_mahasiswa AS nama,
    'publikasi_jurnal' AS jenis_status,
    pj.status_pengumpulan_publikasi_jurnal AS status_pengumpulan
FROM 
    mahasiswa m
JOIN 
    publikasi_jurnal pj ON m.nim = pj.nim
WHERE 
    pj.status_pengumpulan_publikasi_jurnal = 'pending';

UPDATE [dbo].[adminlt6_konfirmasi] set tanggal_adminlt6_konfirmasi = '2024-11-23' where nim = '20230005';

Select * from dbo.nomor_surat_tracker;
Select * from dbo.nomor_surat;

