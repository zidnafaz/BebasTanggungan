CREATE DATABASE Bebas_Tanggungan;

use Bebas_Tanggungan

drop database Bebas_Tanggungan

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
	[tahun_lulus_mahasiswa]	   DATE          NULL,
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
    status_pengumpulan_data_alumni NVARCHAR(50) CHECK (status_pengumpulan_data_alumni IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_data_alumni NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_data_alumni] PRIMARY KEY CLUSTERED ([id_data_alumni] ASC)
);
CREATE TABLE [dbo].[skkm] (
    [id_skkm] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_skkm NVARCHAR(50) CHECK (status_pengumpulan_skkm IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_skkm NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_skkm] PRIMARY KEY CLUSTERED ([id_skkm] ASC)
);
CREATE TABLE [dbo].[foto_ijazah] (
    [id_foto_ijazah] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_foto_ijazah NVARCHAR(50) CHECK (status_pengumpulan_foto_ijazah IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_foto_ijazah NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_foto_ijazah] PRIMARY KEY CLUSTERED ([id_foto_ijazah] ASC)
);
CREATE TABLE [dbo].[ukt] (
    [id_ukt] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_ukt NVARCHAR(50) CHECK (status_pengumpulan_ukt IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_ukt NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_ukt] PRIMARY KEY CLUSTERED ([id_ukt] ASC)
);

--PERPUSTAKAAN
CREATE TABLE [dbo].[penyerahan_hardcopy] (
    [id_penyerahan_hardcopy] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_hardcopy NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_hardcopy IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_penyerahan_hardcopy NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
	judul_tugas_akhir NVARCHAR(200),
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_hardcopy] PRIMARY KEY CLUSTERED ([id_penyerahan_hardcopy] ASC)
);
CREATE TABLE [dbo].[tugas_akhir_softcopy] (
    [id_tugas_akhir_softcopy] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_tugas_akhir_softcopy NVARCHAR(50) CHECK (status_pengumpulan_tugas_akhir_softcopy IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_tugas_akhir_softcopy NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_tugas_akhir_softcopy] PRIMARY KEY CLUSTERED ([id_tugas_akhir_softcopy] ASC)
);
CREATE TABLE [dbo].[bebas_pinjam_buku_perpustakaan] (
    [id_bebas_pinjam_buku_perpustakaan] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_bebas_pinjam_buku_perpustakaan NVARCHAR(50) CHECK (status_pengumpulan_bebas_pinjam_buku_perpustakaan IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_bebas_pinjam_buku_perpustakaan NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_bebas_pinjam_buku_perpustakaan] PRIMARY KEY CLUSTERED ([id_bebas_pinjam_buku_perpustakaan] ASC)
);
CREATE TABLE [dbo].[hasil_kuisioner] (
    [id_hasil_kuisioner] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_hasil_kuisioner NVARCHAR(50) CHECK (status_pengumpulan_hasil_kuisioner IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_hasil_kuisioner NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_hasil_kuisioner] PRIMARY KEY CLUSTERED ([id_hasil_kuisioner] ASC)
);

--ADMIN LANTAI 6 PRODI
CREATE TABLE [dbo].[penyerahan_skripsi] (
    [id_penyerahan_skripsi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_skripsi NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_skripsi IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_penyerahan_skripsi NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_skripsi] PRIMARY KEY CLUSTERED ([id_penyerahan_skripsi] ASC)
);
CREATE TABLE [dbo].[penyerahan_pkl] (
    [id_penyerahan_pkl] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_pkl NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_pkl IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_penyerahan_pkl NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_pkl] PRIMARY KEY CLUSTERED ([id_penyerahan_pkl] ASC)
);
CREATE TABLE [dbo].[toeic] (
    [id_toeic] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_toeic NVARCHAR(50) CHECK (status_pengumpulan_toeic IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_toeic NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_toeic] PRIMARY KEY CLUSTERED ([id_toeic] ASC)
);
CREATE TABLE [dbo].[bebas_kompen] (
    [id_bebas_kompen] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_bebas_kompen NVARCHAR(50) CHECK (status_pengumpulan_bebas_kompen IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_bebas_kompen NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_bebas_kompen] PRIMARY KEY CLUSTERED ([id_bebas_kompen] ASC)
);
CREATE TABLE [dbo].[penyerahan_kebenaran_data] (
    [id_penyerahan_kebenaran_data] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_penyerahan_kebenaran_data NVARCHAR(50) CHECK (status_pengumpulan_penyerahan_kebenaran_data IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_penyerahan_kebenaran_data NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_penyerahan_kebenaran_data] PRIMARY KEY CLUSTERED ([id_penyerahan_kebenaran_data] ASC)
);

--ADMIN LANTAI 7 JURUSAN
CREATE TABLE [dbo].[publikasi_jurnal] (
    [id_publikasi_jurnal] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_publikasi_jurnal NVARCHAR(50) CHECK (status_pengumpulan_publikasi_jurnal IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_publikasi_jurnal NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_publikasi_jurnal] PRIMARY KEY CLUSTERED ([id_publikasi_jurnal] ASC)
);
CREATE TABLE [dbo].[aplikasi] (
    [id_aplikasi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_aplikasi NVARCHAR(50) CHECK (status_pengumpulan_aplikasi IN ('4', '3', '1', '2')) DEFAULT '3',
    keterangan_pengumpulan_aplikasi NVARCHAR(50) ,
    [nim]        NVARCHAR (10) NULL,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    CONSTRAINT [PK_aplikasi] PRIMARY KEY CLUSTERED ([id_aplikasi] ASC)
);
CREATE TABLE [dbo].[skripsi] (
    [id_skripsi] INT IDENTITY (1, 1) NOT NULL,
    status_pengumpulan_skripsi NVARCHAR(50) CHECK (status_pengumpulan_skripsi IN ('4', '3', '1', '2')) DEFAULT '3',
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

--MEMBUAT TABEL UNTUK NOMOR SURAT

CREATE TABLE [dbo].[nomor_surat_perpustakaan] (
    [id_surat] INT IDENTITY (1, 1) NOT NULL,
    [nim] NVARCHAR(10) NOT NULL,
    [nomor_surat] NVARCHAR(50) NOT NULL,
    CONSTRAINT [PK_nomor_surat_perpustakaan] PRIMARY KEY CLUSTERED ([id_surat] ASC),
    CONSTRAINT [FK_nomor_surat_perpustakaan_mahasiswa] FOREIGN KEY ([nim]) REFERENCES [dbo].[mahasiswa]([nim])
);

CREATE TABLE [dbo].[nomor_surat_akademik_pusat] (
    [id_surat] INT IDENTITY (1, 1) NOT NULL,
    [nim] NVARCHAR(10) NOT NULL,
    [nomor_surat] NVARCHAR(50) NOT NULL,
    CONSTRAINT [PK_nomor_surat_akademik_pusat] PRIMARY KEY CLUSTERED ([id_surat] ASC),
    CONSTRAINT [FK_nomor_surat_akademik_pusat_mahasiswa] FOREIGN KEY ([nim]) REFERENCES [dbo].[mahasiswa]([nim])
);

CREATE TABLE [dbo].[nomor_surat_rekomendasi] (
    [id_surat] INT IDENTITY (1, 1) NOT NULL,
    [nim] NVARCHAR(10) NOT NULL,
    [nomor_surat] NVARCHAR(50) NOT NULL,
    CONSTRAINT [PK_nomor_surat_rekomendasi] PRIMARY KEY CLUSTERED ([id_surat] ASC),
    CONSTRAINT [FK_nomor_surat_rekomendasi_mahasiswa] FOREIGN KEY ([nim]) REFERENCES [dbo].[mahasiswa]([nim])
);

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
SELECT * FROM dbo.nomor_surat_perpustakaan;
SELECT * FROM dbo.nomor_surat_akademik_pusat;
SELECT * FROM [dbo].[adminPusat_konfirmasi];
SELECT * FROM [dbo].[adminPerpus_konfirmasi];
SELECT * FROM [dbo].[adminlt6_konfirmasi];
SELECT * FROM [dbo].[nomor_surat_rekomendasi];

use Bebas_Tanggungan;

SELECT * FROM dbo.admin
delete from dbo.admin
SELECT * FROM dbo.mahasiswa
delete from dbo.mahasiswa
SELECT * FROM dbo.login
delete from dbo.login where username = '20230009'

SELECT status_pengumpulan_penyerahan_skripsi, keterangan_pengumpulan_penyerahan_skripsi FROM penyerahan_skripsi WHERE nim = ?
SELECT status_pengumpulan_penyerahan_pkl, keterangan_pengumpulan_penyerahan_pkl FROM penyerahan_pkl WHERE nim = ?
SELECT status_pengumpulan_toeic, keterangan_pengumpulan_toeic FROM toeic WHERE nim = ?
SELECT status_pengumpulan_bebas_kompen, keterangan_pengumpulan_bebas_kompen FROM bebas_kompen WHERE nim = ?
SELECT status_pengumpulan_penyerahan_kebenaran_data, keterangan_pengumpulan_penyerahan_kebenaran_data FROM penyerahan_kebenaran_data WHERE nim = ?