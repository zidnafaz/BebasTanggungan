CREATE DATABASE SQL_Bebas_Tanggungan;
use SQL_Bebas_Tanggungan;

CREATE TABLE Data_Mahasiswa (
nim CHAR(12) PRIMARY KEY NOT NULL,
nama VARCHAR(50) NOT NULL,
tahun_angkatan CHAR(4),
alamat VARCHAR(50),
email VARCHAR(50),
no_telf VARCHAR(15)
);

CREATE TABLE Data_Dosen (
nidn CHAR(12) PRIMARY KEY NOT NULL,
nama VARCHAR(50) NOT NULL,
jabatan VARCHAR(50),
alamat VARCHAR(50),
email VARCHAR(50),
no_telf VARCHAR(15),
tanda_tangan VARCHAR(30)
);

CREATE TABLE Data_Konfirmasi(
	nim CHAR (12),
	nidn CHAR (12),
	pdf_skripsi_lt7 CHAR(1) CHECK (pdf_skripsi_lt7 IN ('Y', 'N')) DEFAULT 'N',
	upload_program_lt7 CHAR(1) CHECK (upload_program_lt7 IN ('Y', 'N')) DEFAULT 'N',
	upload_publikasi_jurnal_lt7 CHAR(1) CHECK(upload_publikasi_jurnal_lt7 IN ('Y','N')) DEFAULT 'N',
	tanda_terima_penyerahan_skripsi_lt6 CHAR(1) CHECK(tanda_terima_penyerahan_skripsi_lt6 IN ('Y','N')) DEFAULT 'N',
	tanda_terima_laporan_pkl_lt6 CHAR(1) CHECK(tanda_terima_laporan_pkl_lt6 IN ('Y','N')) DEFAULT 'N',
	upload_scan_toeic_lt6 CHAR(1) CHECK(upload_scan_toeic_lt6 IN ('Y','N')) DEFAULT 'N',
	surat_bebas_kompen_lt6 CHAR(1) CHECK(surat_bebas_kompen_lt6 IN ('Y','N')) DEFAULT 'N',
	surat_kebenaran_data_diri CHAR(1) CHECK(surat_kebenaran_data_diri IN ('Y','N')) DEFAULT 'N',
	data_pendamping_ijazah CHAR(1) CHECK(data_pendamping_ijazah IN ('Y','N')) DEFAULT 'N',
	kuisioner_peminjaman_mutu CHAR(1) CHECK(kuisioner_peminjaman_mutu IN ('Y','N')) DEFAULT 'N',
	surat_bebas_tanggungan_jurusan CHAR(1) CHECK(surat_bebas_tanggungan_jurusan IN ('Y','N')) DEFAULT 'N',
	surat_bebas_tanggungan_perpustakaan CHAR(1) CHECK(surat_bebas_tanggungan_perpustakaan IN ('Y','N')) DEFAULT 'N',
	surat_bebas_tanggungan_akademik_pusat CHAR(1) CHECK (surat_bebas_tanggungan_akademik_pusat IN ('Y','N')) DEFAULT 'N',
	surat_rekomendasi_pengambilan_ijazah CHAR(1) CHECK(surat_rekomendasi_pengambilan_ijazah IN ('Y','N')) DEFAULT 'N'

	FOREIGN KEY (nim) REFERENCES Data_Mahasiswa(nim),
	FOREIGN KEY (nidn) REFERENCES Data_Dosen(NIDN)
)
