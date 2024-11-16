use Bebas_Tanggungan

SELECT * FROM dbo.[login]

SELECT * FROM dbo.[admin]

INSERT into dbo.mahasiswa (nim, nama_mahasiswa, nomor_telfon_mahasiswa,
    alamat_mahasiswa, jurusan_mahasiswa, prodi_mahasiswa, jenis_kelamin_mahasiswa,
    tahun_angkatan_mahasiswa, tanggal_lahir_mahasiswa) values (
        '2341760121', 'Muhammad Rosyid', '084325134651', 'Jl. Jalan Arjosari No. 1', 'Teknologi Informasi',
        'Sistem Informasi Bisnis', 'L', '2023', '2004-06-12'
    )

ALTER TABLE dbo.mahasiswa
ALTER COLUMN jurusan_mahasiswa VARCHAR(50);

update dbo.login
set status = 'adminlt7'
WHERE id_login = 1;

select * from dbo.mahasiswa

insert into dbo.[login](username, [password], [status]) VALUES(
    '2341760121', '111', 'mahasiswa'
)

INSERT INTO dbo.[login] (username, password, [status]) VALUES ('2', 'admin', 'adminlt6')