use Bebas_Tanggungan

SELECT * FROM dbo.[login]

SELECT * FROM dbo.[admin]

INSERT INTO dbo.[mahasiswa] (nim, nama_mahasiswa, nomor_telfon_mahasiswa,
    alamat_mahasiswa, jurusan_mahasiswa, prodi_mahasiswa, jenis_kelamin_mahasiswa,
    tahun_angkatan_mahasiswa, tanggal_lahir_mahasiswa) values (
        '234176012', 'Muhammad Rosyid', '084325134651', 'Jl. Jalan Arjosari No. 1', 'Teknologi Informasi',
        'Sistem Informasi Bisnis', 'L', '2023', '2004-06-12'
    );

ALTER TABLE dbo.mahasiswa
ALTER COLUMN prodi_mahasiswa VARCHAR(50);

update dbo.login
set status = 'adminlt7'
WHERE id_login = 1;

select * from dbo.mahasiswa

insert into dbo.[login](username, [password], [status]) VALUES(
    '2341760121', '111', 'mahasiswa'
)

INSERT INTO dbo.[login] (username, password, [status]) VALUES ('2', 'admin', 'adminlt6')

-- LANTAI 6
SELECT m.nim, m.nama_mahasiswa, ps.status_pengumpulan_penyerahan_skripsi, pk.status_pengumpulan_penyerahan_pkl,
    toeic.status_pengumpulan_toeic, bk.status_pengumpulan_bebas_kompen, pd.status_pengumpulan_penyerahan_kebenaran_data
from dbo.mahasiswa m
JOIN dbo.penyerahan_skripsi ps ON m.nim = ps.nim
JOIN dbo.penyerahan_pkl pk ON m.nim = pk.nim
JOIN dbo.toeic ON m.nim = toeic.nim
JOIN dbo.bebas_kompen bk ON m.nim = bk.nim
JOIN dbo.penyerahan_kebenaran_data pd ON m.nim = pd.nim;

-- LANTAI 7
select m.nim, m.nama_mahasiswa, skripsi.status_pengumpulan_skripsi, a.status_pengumpulan_aplikasi, pj.status_pengumpulan_publikasi_jurnal
from mahasiswa m
JOIN dbo.skripsi ON m.nim = skripsi.nim
JOIN dbo.aplikasi a ON m.nim = a.nim
JOIN dbo.publikasi_jurnal pj ON m.nim = pj.nim;

-- ADMIN PERPUSTAKAAN
select m.nim, m.nama_mahasiswa, ta.status_pengumpulan_tugas_akhir_softcopy, hk.status_pengumpulan_hasil_kuisioner
    , bpb.status_pengumpulan_bebas_pinjam_buku_perpustakaan, ph.status_pengumpulan_penyerahan_hardcopy
from dbo.mahasiswa m
JOIN dbo.tugas_akhir_softcopy ta ON m.nim = ta.nim
JOIN dbo.hasil_kuisioner hk ON m.nim = hk.nim
JOIN dbo.bebas_pinjam_buku_perpustakaan bpb ON m.nim = bpb.nim
JOIN dbo.penyerahan_hardcopy ph ON m.nim = ph.nim;

-- ADMIN PUSAT
SELECT m.nim, m.nama_mahasiswa, da.status_pengumpulan_data_alumni, fi.status_pengumpulan_foto_ijazah, 
    skkm.status_pengumpulan_skkm, ukt.status_pengumpulan_ukt
FROM dbo.mahasiswa m
JOIN dbo.data_alumni da ON m.nim = da.nim
JOIN dbo.foto_ijazah fi ON m.nim = fi.nim
JOIN dbo.skkm ON m.nim = skkm.nim
JOIN dbo.ukt ON m.nim = ukt.nim;