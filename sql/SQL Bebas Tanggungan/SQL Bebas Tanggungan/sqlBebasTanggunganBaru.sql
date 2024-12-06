CREATE DATABASE Bebas_Tanggungan;

use Bebas_Tanggungan

--MAHASISWA&ADMIN
CREATE TABLE [dbo].[mahasiswa] (
    [nim]                      NVARCHAR (10) NOT NULL,
    [nama_mahasiswa]           NVARCHAR (50) NOT NULL,
    [nomor_telfon_mahasiswa]   NVARCHAR (20) NULL,
    [alamat_mahasiswa]         NVARCHAR (50) NULL,
    [jurusan_mahasiswa]        NVARCHAR (20) NULL,
    [prodi_mahasiswa]          NVARCHAR (20) NULL,
    [jenis_kelamin_mahasiswa]  CHAR(1) CHECK (jenis_kelamin_mahasiswa IN ('L', 'P')),
    [tahun_angkatan_mahasiswa] DATE          NULL,
    [tanggal_lahir_mahasiswa]  DATE          NULL,
    CONSTRAINT [PK_mahasiswa] PRIMARY KEY CLUSTERED ([nim] ASC)
);

CREATE TABLE [dbo].[admin] (
    [id_karyawan]             NVARCHAR (10) NOT NULL,
    [nama_karyawan]           NVARCHAR (50) NOT NULL,
    [nomor_telfon_karyawan]   NVARCHAR (20) NULL,
    [alamat_karyawan]         NVARCHAR (50) NULL,
    [tanggal_lahir_karyawan]  DATE          NULL,
    [jenis_kelamin_karyawan] CHAR(1) CHECK (jenis_kelamin_karyawan IN ('L', 'P')),
    CONSTRAINT [PK_karyawan] PRIMARY KEY CLUSTERED ([id_karyawan] ASC)
);
ALTER TABLE dbo.admin ALTER COLUMN tanda_tangan_karyawan VARCHAR(MAX);
--INSERT DATA ADMIN
INSERT INTO admin (id_karyawan, nama_karyawan, nomor_telfon_karyawan, 
    alamat_karyawan, tanggal_lahir_karyawan, jenis_kelamin_karyawan, tanda_tangan_karyawan)
VALUES ('1', 'Kemal', '08123456789', 'Jl. Papa Biru No. 1', '2003-11-01', 'L', 'https://drive.google.com/file/d/1MX3ZGiTu66E4G4tbStnOqwp_zh4cfoSH/view?usp=drive_link');
SELECT * FROM dbo.admin

--BEBAS TANGGUNGAN AKADEMIK PUSAT
CREATE TABLE [dbo].[data_alumni] (
    [id_data_alumni] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_data_alumni NVARCHAR(50) CHECK (status_pengumpulan_data_alumni IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_data_alumni NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_data_alumni] PRIMARY KEY CLUSTERED ([id_data_alumni] ASC)
);
CREATE TABLE [dbo].[skkm] (
    [id_skkm] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_skkm NVARCHAR(50) CHECK (status_pengumpulan_skkm IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_skkm NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_skkm] PRIMARY KEY CLUSTERED ([id_skkm] ASC)
);
CREATE TABLE [dbo].[foto_ijazah] (
    [id_foto_ijazah] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_foto_ijazah NVARCHAR(50) CHECK (status_pengumpulan_foto_ijazah IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_foto_ijazah NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_foto_ijazah] PRIMARY KEY CLUSTERED ([id_foto_ijazah] ASC)
);
CREATE TABLE [dbo].[ukt] (
    [id_ukt] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_ukt NVARCHAR(50) CHECK (status_pengumpulan_ukt IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_ukt NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_ukt] PRIMARY KEY CLUSTERED ([id_ukt] ASC)
);


--PERPUSTAKAAN
CREATE TABLE [dbo].[penyerahan_hardcopy] (
    [id_penyerahan_hardcopy] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_hardcopy NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_hardcopy IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_hardcopy NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_hardcopy] PRIMARY KEY CLUSTERED ([id_penyerahan_hardcopy] ASC)
);
CREATE TABLE [dbo].[tugas_akhir_softcopy] (
    [id_tugas_akhir_softcopy] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_tugas_akhir_softcopy NVARCHAR(50) CHECK (status_pengumpulan_tugas_akhir_softcopy IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_tugas_akhir_softcopy NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_tugas_akhir_softcopy] PRIMARY KEY CLUSTERED ([id_tugas_akhir_softcopy] ASC)
);
CREATE TABLE [dbo].[bebas_pinjam_buku_perpustakaan] (
    [id_bebas_pinjam_buku_perpustakaan] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_bebas_pinjam_buku_perpustakaan NVARCHAR(50) CHECK (status_pengumpulan_bebas_pinjam_buku_perpustakaan IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_bebas_pinjam_buku_perpustakaan] PRIMARY KEY CLUSTERED ([id_bebas_pinjam_buku_perpustakaan] ASC)
);
CREATE TABLE [dbo].[hasil_kuisioner] (
    [id_hasil_kuisioner] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_hasil_kuisioner NVARCHAR(50) CHECK (status_pengumpulan_hasil_kuisioner IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_hasil_kuisioner NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_hasil_kuisioner] PRIMARY KEY CLUSTERED ([id_hasil_kuisioner] ASC)
);

--ADMIN LANTAI 6 PRODI
CREATE TABLE [dbo].[penyerahan_skripsi] (
    [id_penyerahan_skripsi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_skripsi NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_skripsi IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_skripsi NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_skripsi] PRIMARY KEY CLUSTERED ([id_penyerahan_skripsi] ASC)
);
CREATE TABLE [dbo].[penyerahan_pkl] (
    [id_penyerahan_pkl] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_pkl NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_pkl IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_pkl NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_pkl] PRIMARY KEY CLUSTERED ([id_penyerahan_pkl] ASC)
);
CREATE TABLE [dbo].[toeic] (
    [id_toeic] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_toeic NVARCHAR(50) CHECK (status_pengumpulan_toeic IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_toeic NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_toeic] PRIMARY KEY CLUSTERED ([id_toeic] ASC)
);
CREATE TABLE [dbo].[bebas_kompen] (
    [id_bebas_kompen] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_bebas_kompen NVARCHAR(50) CHECK (status_pengumpulan_bebas_kompen IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_bebas_kompen NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_bebas_kompen] PRIMARY KEY CLUSTERED ([id_bebas_kompen] ASC)
);
CREATE TABLE [dbo].[penyerahan_kebenaran_data] (
    [id_penyerahan_kebenaran_data] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_kebenaran_data NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_kebenaran_data IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_kebenaran_data NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_kebenaran_data] PRIMARY KEY CLUSTERED ([id_penyerahan_kebenaran_data] ASC)
);

--ADMIN LANTAI 7 JURUSAN
CREATE TABLE [dbo].[publikasi_jurnal] (
    [id_publikasi_jurnal] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_publikasi_jurnal NVARCHAR(50) CHECK (status_pengumpulan_publikasi_jurnal IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_publikasi_jurnal NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_publikasi_jurnal] PRIMARY KEY CLUSTERED ([id_publikasi_jurnal] ASC)
);
CREATE TABLE [dbo].[aplikasi] (
    [id_aplikasi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_aplikasi NVARCHAR(50) CHECK (status_pengumpulan_aplikasi IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_aplikasi NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_aplikasi] PRIMARY KEY CLUSTERED ([id_aplikasi] ASC)
);
CREATE TABLE [dbo].[skripsi] (
    [id_skripsi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_skripsi NVARCHAR(50) CHECK (status_pengumpulan_skripsi IN ('terkonfirmasi', 'belum upload', 'pending', 'tidak terkonfirmasi')) DEFAULT 'belum upload',
    keterangan_pengumpulan_skripsi NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_skripsi] PRIMARY KEY CLUSTERED ([id_skripsi] ASC)
);

--LOGIN
CREATE TABLE [dbo].[login] (
    [id_login] INT IDENTITY (1, 1) NOT NULL,
    username NVARCHAR(50) NOT NULL,
    password NVARCHAR(50) NOT NULL,
    [status] NVARCHAR (20) NULL,
    CONSTRAINT [PK_login] PRIMARY KEY CLUSTERED ([id_login] ASC)
);

--MEMBUAT DATABASE UNTUK TANGGAL KONFIRMASI DAN TRIGGER
CREATE TABLE [dbo].[adminlt6_konfirmasi] (
    [id_adminlt6_konfirmasi] INT IDENTITY (1, 1) NOT NULL,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    [tanggal_adminlt6_konfirmasi] DATE NULL,
    CONSTRAINT [PK_adminlt6_konfirmasi] PRIMARY KEY CLUSTERED ([id_adminlt6_konfirmasi] ASC)
);
CREATE TABLE [dbo].[adminlt7_konfirmasi] (
    [id_adminlt7_konfirmasi] INT IDENTITY (1, 1) NOT NULL,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    [tanggal_adminlt7_konfirmasi] DATE NULL,
    CONSTRAINT [PK_adminlt7_konfirmasi] PRIMARY KEY CLUSTERED ([id_adminlt7_konfirmasi] ASC)
);
CREATE TABLE [dbo].[adminPusat_konfirmasi] (
    [id_adminPusat_konfirmasi] INT IDENTITY (1, 1) NOT NULL,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    [tanggal_adminPusat_konfirmasi] DATE NULL,
    CONSTRAINT [PK_adminPusat_konfirmasi] PRIMARY KEY CLUSTERED ([id_adminPusat_konfirmasi] ASC)
);
CREATE TABLE [dbo].[adminPerpus_konfirmasi] (
    [id_adminPerpus_konfirmasi] INT IDENTITY (1, 1) NOT NULL,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    [tanggal_adminPerpus_konfirmasi] DATE NULL,
    CONSTRAINT [PK_adminPerpus_konfirmasi] PRIMARY KEY CLUSTERED ([id_adminPerpus_konfirmasi] ASC)
);

-- TRIGGER

IF OBJECT_ID('dbo.autoAddKonfirmasiMahasiswa') IS NOT NULL 
DROP TRIGGER dbo.autoAddKonfirmasiMahasiswa;

use Bebas_Tanggungan;

CREATE TRIGGER autoAddKonfirmasi ON dbo.mahasiswa
AFTER INSERT
AS
    PRINT 'Trigger autoAddKonfirmasiMahasiswa dipanggil!';
    DECLARE @nim VARCHAR = (SELECT nim FROM inserted);
    DECLARE @tanggal DATETIME = GETDATE();
    INSERT INTO dbo.adminlt6_konfirmasi(nim, tanggal_adminlt6_konfirmasi)
    VALUES (@nim, @tanggal);
    INSERT INTO dbo.adminlt7_konfirmasi(nim, tanggal_adminlt7_konfirmasi)
    VALUES (@nim, @tanggal);
    INSERT INTO dbo.adminPusat_konfirmasi(nim, tanggal_adminPusat_konfirmasi)
    VALUES (@nim, @tanggal);
    INSERT INTO dbo.adminPerpus_konfirmasi(nim, tanggal_adminPerpus_konfirmasi)
    VALUES (@nim, @tanggal);

IF OBJECT_ID('dbo.autoAddLogin') IS NOT NULL 
DROP TRIGGER dbo.autoAddLogin;
GO;
CREATE TRIGGER autoAddLogin ON dbo.mahasiswa
AFTER INSERT
AS
    PRINT 'Trigger autoAddLoginMahasiswa dipanggil!';
    DECLARE @username VARCHAR = (SELECT nim FROM inserted);
    DECLARE @password varchar = (SELECT nim FROM inserted);
    DECLARE @status varchar = 'mahasiswa';
    INSERT INTO dbo.login(username, [password], [status])
    VALUES (@username, @password, @status);

IF OBJECT_ID('dbo.autoAddStatus') IS NOT NULL 
DROP TRIGGER dbo.autoAddStatus;

CREATE TRIGGER autoAddStatus ON dbo.mahasiswa
AFTER INSERT
AS
    PRINT 'Trigger autoAddStatus dipanggil!';
    DECLARE @nim VARCHAR = (SELECT nim FROM inserted);
    DECLARE @keterangan VARCHAR = '';
    INSERT INTO dbo.aplikasi(nim, keterangan_pengumpulan_aplikasi)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.bebas_kompen(nim, keterangan_pengumpulan_bebas_kompen)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.bebas_pinjam_buku_perpustakaan(nim, keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.data_alumni(nim, keterangan_pengumpulan_data_alumni)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.foto_ijazah(nim, keterangan_pengumpulan_foto_ijazah)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.hasil_kuisioner(nim, keterangan_pengumpulan_hasil_kuisioner)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.penyerahan_hardcopy(nim, keterangan_pengumpulan_penyerahan_hardcopy)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.penyerahan_kebenaran_data(nim, keterangan_pengumpulan_penyerahan_kebenaran_data)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.penyerahan_pkl(nim, keterangan_pengumpulan_penyerahan_pkl)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.penyerahan_skripsi(nim, keterangan_pengumpulan_penyerahan_skripsi)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.publikasi_jurnal(nim, keterangan_pengumpulan_publikasi_jurnal)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.skkm(nim, keterangan_pengumpulan_skkm)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.skripsi(nim, keterangan_pengumpulan_skripsi)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.toeic(nim, keterangan_pengumpulan_toeic)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.tugas_akhir_softcopy(nim, keterangan_pengumpulan_tugas_akhir_softcopy)
    VALUES (@nim, @keterangan);
    INSERT INTO dbo.ukt(nim, keterangan_pengumpulan_ukt)
    VALUES (@nim, @keterangan);


SELECT * FROM data_alumni;
SELECT * FROM skkm;
SELECT * FROM foto_ijazah;
SELECT * FROM ukt;
SELECT * FROM penyerahan_hardcopy;
SELECT * FROM tugas_akhir_softcopy;
SELECT * FROM bebas_pinjam_buku_perpustakaan;
SELECT * FROM hasil_kuisioner;
SELECT * FROM penyerahan_skripsi;
SELECT * FROM penyerahan_pkl;
SELECT * FROM toeic;
SELECT * FROM bebas_kompen;
SELECT * FROM penyerahan_kebenaran_data;
SELECT * FROM publikasi_jurnal;
SELECT * FROM aplikasi;
SELECT * FROM skripsi;

SELECT * FROM dbo.admin
delete from dbo.admin
SELECT * FROM dbo.mahasiswa
delete from dbo.mahasiswa
SELECT * FROM dbo.login
delete from dbo.login

SELECT status_pengumpulan_penyerahan_skripsi, keterangan_pengumpulan_penyerahan_skripsi FROM penyerahan_skripsi WHERE nim = ?
SELECT status_pengumpulan_penyerahan_pkl, keterangan_pengumpulan_penyerahan_pkl FROM penyerahan_pkl WHERE nim = ?
SELECT status_pengumpulan_toeic, keterangan_pengumpulan_toeic FROM toeic WHERE nim = ?
SELECT status_pengumpulan_bebas_kompen, keterangan_pengumpulan_bebas_kompen FROM bebas_kompen WHERE nim = ?
SELECT status_pengumpulan_penyerahan_kebenaran_data, keterangan_pengumpulan_penyerahan_kebenaran_data FROM penyerahan_kebenaran_data WHERE nim = ?