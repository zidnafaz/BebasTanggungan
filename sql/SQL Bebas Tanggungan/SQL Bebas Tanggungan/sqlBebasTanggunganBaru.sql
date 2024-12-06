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

--BEBAS TANGGUNGAN AKADEMIK PUSAT
CREATE TABLE [dbo].[data_alumni] (
    [id_data_alumni] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_data_alumni NVARCHAR(50) CHECK (status_pengumpulan_data_alumni IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_data_alumni NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_data_alumni] PRIMARY KEY CLUSTERED ([id_data_alumni] ASC)
);
CREATE TABLE [dbo].[skkm] (
    [id_skkm] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_skkm NVARCHAR(50) CHECK (status_pengumpulan_skkm IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_skkm NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_skkm] PRIMARY KEY CLUSTERED ([id_skkm] ASC)
);
CREATE TABLE [dbo].[foto_ijazah] (
    [id_foto_ijazah] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_foto_ijazah NVARCHAR(50) CHECK (status_pengumpulan_foto_ijazah IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_foto_ijazah NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_foto_ijazah] PRIMARY KEY CLUSTERED ([id_foto_ijazah] ASC)
);
CREATE TABLE [dbo].[ukt] (
    [id_ukt] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_ukt NVARCHAR(50) CHECK (status_pengumpulan_ukt IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_ukt NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_ukt] PRIMARY KEY CLUSTERED ([id_ukt] ASC)
);


--PERPUSTAKAAN
CREATE TABLE [dbo].[penyerahan_hardcopy] (
    [id_penyerahan_hardcopy] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_hardcopy NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_hardcopy IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_hardcopy NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
	judul_tugas_akhir NVARCHAR(100),
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_hardcopy] PRIMARY KEY CLUSTERED ([id_penyerahan_hardcopy] ASC)
);
CREATE TABLE [dbo].[tugas_akhir_softcopy] (
    [id_tugas_akhir_softcopy] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_tugas_akhir_softcopy NVARCHAR(50) CHECK (status_pengumpulan_tugas_akhir_softcopy IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_tugas_akhir_softcopy NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_tugas_akhir_softcopy] PRIMARY KEY CLUSTERED ([id_tugas_akhir_softcopy] ASC)
);
CREATE TABLE [dbo].[bebas_pinjam_buku_perpustakaan] (
    [id_bebas_pinjam_buku_perpustakaan] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_bebas_pinjam_buku_perpustakaan NVARCHAR(50) CHECK (status_pengumpulan_bebas_pinjam_buku_perpustakaan IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_bebas_pinjam_buku_perpustakaan] PRIMARY KEY CLUSTERED ([id_bebas_pinjam_buku_perpustakaan] ASC)
);
CREATE TABLE [dbo].[hasil_kuisioner] (
    [id_hasil_kuisioner] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_hasil_kuisioner NVARCHAR(50) CHECK (status_pengumpulan_hasil_kuisioner IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_hasil_kuisioner NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_hasil_kuisioner] PRIMARY KEY CLUSTERED ([id_hasil_kuisioner] ASC)
);

--ADMIN LANTAI 6 PRODI
CREATE TABLE [dbo].[penyerahan_skripsi] (
    [id_penyerahan_skripsi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_skripsi NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_skripsi IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_skripsi NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_skripsi] PRIMARY KEY CLUSTERED ([id_penyerahan_skripsi] ASC)
);
CREATE TABLE [dbo].[penyerahan_pkl] (
    [id_penyerahan_pkl] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_pkl NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_pkl IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_pkl NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_pkl] PRIMARY KEY CLUSTERED ([id_penyerahan_pkl] ASC)
);
CREATE TABLE [dbo].[toeic] (
    [id_toeic] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_toeic NVARCHAR(50) CHECK (status_pengumpulan_toeic IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_toeic NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_toeic] PRIMARY KEY CLUSTERED ([id_toeic] ASC)
);
CREATE TABLE [dbo].[bebas_kompen] (
    [id_bebas_kompen] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_bebas_kompen NVARCHAR(50) CHECK (status_pengumpulan_bebas_kompen IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_bebas_kompen NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_bebas_kompen] PRIMARY KEY CLUSTERED ([id_bebas_kompen] ASC)
);
CREATE TABLE [dbo].[penyerahan_kebenaran_data] (
    [id_penyerahan_kebenaran_data] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_kebenaran_data NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_kebenaran_data IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_penyerahan_kebenaran_data NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_kebenaran_data] PRIMARY KEY CLUSTERED ([id_penyerahan_kebenaran_data] ASC)
);

--ADMIN LANTAI 7 JURUSAN
CREATE TABLE [dbo].[publikasi_jurnal] (
    [id_publikasi_jurnal] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_publikasi_jurnal NVARCHAR(50) CHECK (status_pengumpulan_publikasi_jurnal IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_publikasi_jurnal NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_publikasi_jurnal] PRIMARY KEY CLUSTERED ([id_publikasi_jurnal] ASC)
);
CREATE TABLE [dbo].[aplikasi] (
    [id_aplikasi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_aplikasi NVARCHAR(50) CHECK (status_pengumpulan_aplikasi IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
    keterangan_pengumpulan_aplikasi NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_aplikasi] PRIMARY KEY CLUSTERED ([id_aplikasi] ASC)
);
CREATE TABLE [dbo].[skripsi] (
    [id_skripsi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_skripsi NVARCHAR(50) CHECK (status_pengumpulan_skripsi IN ('terverifikasi', 'belum upload', 'pending', 'ditolak')) DEFAULT 'belum upload',
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

--MEMBUAT DATABASE UNTUK NOMOR SURAT
CREATE TABLE dbo.nomor_surat (
    id INT IDENTITY(1,1) PRIMARY KEY,
    [nim]        NVARCHAR (10) NOT NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    nomor_surat INT NOT NULL,
    nama_surat VARCHAR(50) NOT NULL
);
-- TABEL melacak nilai terakhir untuk setiap jenis surat.
CREATE TABLE dbo.nomor_surat_tracker (
    nama_surat VARCHAR(50) PRIMARY KEY,
    last_number INT NOT NULL
);
-- Insert nilai awal untuk setiap jenis surat
INSERT INTO nomor_surat_tracker (nama_surat, last_number)
VALUES 
('bebas tanggungan perpus', 1000),
('bebas tanggungan akademik', 2000),
('rekomendasi', 3000);

GO;
--Prosedur ini akan secara otomatis meningkatkan nomor_surat berdasarkan jenis nama_surat.
CREATE PROCEDURE InsertSurat
    @nama_surat VARCHAR(50),
    @nim NVARCHAR(10)
AS
BEGIN
    DECLARE @last_number INT;
    DECLARE @new_number INT;

    -- Ambil nomor terakhir dari tracker
    SELECT @last_number = last_number
    FROM nomor_surat_tracker
    WHERE nama_surat = @nama_surat;

    -- Tingkatkan nomor
    SET @new_number = @last_number + 1;

    -- Insert ke tabel surat
    INSERT INTO dbo.nomor_surat (nim, nomor_surat, nama_surat)
    VALUES (@nim, @new_number, @nama_surat);

    -- Update tracker dengan nomor terakhir yang baru
    UPDATE nomor_surat_tracker
    SET last_number = @new_number
    WHERE nama_surat = @nama_surat;
END;
--QUERY UNTUK INSERT TABLE SURAT
EXEC InsertSurat @nama_surat = 'bebas tanggungan_perpus',
    @nim = '20230001';
SELECT * FROM dbo.nomor_surat;

-- TRIGGER

IF OBJECT_ID('dbo.autoAddKonfirmasi') IS NOT NULL 
DROP TRIGGER dbo.autoAddKonfirmasi;

CREATE TRIGGER autoAddKonfirmasi 
ON dbo.mahasiswa
AFTER INSERT
AS
BEGIN
    PRINT 'Trigger autoAddKonfirmasiMahasiswa dipanggil!';

    -- Insert ke adminlt6_konfirmasi
    INSERT INTO dbo.adminlt6_konfirmasi(nim, tanggal_adminlt6_konfirmasi)
    SELECT nim, GETDATE()
    FROM inserted;

    -- Insert ke adminlt7_konfirmasi
    INSERT INTO dbo.adminlt7_konfirmasi(nim, tanggal_adminlt7_konfirmasi)
    SELECT nim, GETDATE()
    FROM inserted;

    -- Insert ke adminPusat_konfirmasi
    INSERT INTO dbo.adminPusat_konfirmasi(nim, tanggal_adminPusat_konfirmasi)
    SELECT nim, GETDATE()
    FROM inserted;

    -- Insert ke adminPerpus_konfirmasi
    INSERT INTO dbo.adminPerpus_konfirmasi(nim, tanggal_adminPerpus_konfirmasi)
    SELECT nim, GETDATE()
    FROM inserted;
END;

IF OBJECT_ID('dbo.autoAddLoginMahasiswa') IS NOT NULL 
DROP TRIGGER dbo.autoAddLoginMahasiswa;

CREATE TRIGGER autoAddLoginMahasiswa ON dbo.mahasiswa
AFTER INSERT
AS
BEGIN
    PRINT 'Trigger autoAddLoginMahasiswa dipanggil!';

    -- Insert data ke tabel login berdasarkan data yang ada di inserted
    INSERT INTO dbo.login(username, [password], [status])
    SELECT nim, nim, 'mahasiswa'
    FROM inserted;
END;

CREATE TRIGGER trg_InsertMahasiswa
ON [dbo].[mahasiswa]
AFTER INSERT
AS
BEGIN
    -- Deklarasi variabel untuk menyimpan data dari tabel inserted
    DECLARE @nim NVARCHAR(10);

    -- Ambil nilai nim dari tabel inserted
    SELECT @nim = nim FROM inserted;

    INSERT INTO [dbo].[data_alumni] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[skkm] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[foto_ijazah] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[ukt] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[penyerahan_hardcopy] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[tugas_akhir_softcopy] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[bebas_pinjam_buku_perpustakaan] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[hasil_kuisioner] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[penyerahan_skripsi] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[penyerahan_pkl] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[toeic] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[bebas_kompen] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[penyerahan_kebenaran_data] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[publikasi_jurnal] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[aplikasi] (nim) SELECT nim FROM inserted;
    INSERT INTO [dbo].[skripsi] (nim) SELECT nim FROM inserted;
END;


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
SELECT * FROM adminlt6_konfirmasi;

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