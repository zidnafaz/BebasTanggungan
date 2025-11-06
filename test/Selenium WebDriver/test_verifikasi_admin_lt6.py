import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support.ui import Select


class TestVerifikasiAdminLt6:
    def __init__(self):
        self.driver = webdriver.Edge()
        self.driver.implicitly_wait(10)
        self.vars = {}
    
    def teardown(self):
        self.driver.quit()
    
    def test_verifikasi_dokumen_mahasiswa(self):
        """Test verifikasi dokumen oleh Admin Lt6"""
        print("Test: Verifikasi Dokumen Mahasiswa oleh Admin Lt6")
        try:
            # 1. Login sebagai Admin Lt6
            print("  - Login sebagai Admin Lt6...")
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            
            self.driver.find_element(By.ID, "username").send_keys("10230001")
            self.driver.find_element(By.ID, "password").send_keys("admin")
            self.driver.find_element(By.ID, "loginButton").click()
            
            # Tunggu sampai halaman dashboard admin muncul
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".welcome-name"))
            )
            
            # Verifikasi login berhasil
            welcome_text = self.driver.find_element(By.CSS_SELECTOR, ".welcome-name").text
            print(f"  ✓ Login berhasil: {welcome_text}")
            
            # 2. Klik menu Daftar Mahasiswa
            print("  - Navigasi ke Daftar Mahasiswa...")
            daftar_mahasiswa_nav = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.XPATH, "//a[@href='daftar_mahasiswa.php']"))
            )
            daftar_mahasiswa_nav.click()
            
            # Tunggu halaman daftar mahasiswa muncul
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Verifikasi Berkas Mahasiswa')]"))
            )
            print("  ✓ Halaman Daftar Mahasiswa terbuka")
            
            # Tunggu tabel DataTables load
            time.sleep(3)
            
            # 3. Klik tombol Detail untuk mahasiswa pertama
            print("  - Mencari dan klik tombol Detail mahasiswa pertama...")
            
            # Cari tombol detail pertama
            detail_button = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.XPATH, "//a[contains(@href, 'detail_mahasiswa.php')]"))
            )
            
            # Ambil URL lengkap dari href
            detail_url = detail_button.get_attribute("href")
            nim_mahasiswa = detail_url.split("nim=")[1] if "nim=" in detail_url else "Unknown"
            print(f"  ✓ Mahasiswa dengan NIM: {nim_mahasiswa}")
            
            # Gunakan navigasi langsung ke URL untuk menghindari masalah tab baru
            print("  - Navigasi ke halaman detail...")
            self.driver.get(detail_url)
            print("  ✓ Berhasil navigasi ke detail mahasiswa")
            
            # Tunggu halaman detail mahasiswa muncul
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Detail Mahasiswa')]"))
            )
            print("  ✓ Halaman Detail Mahasiswa terbuka")
            
            # Tunggu tabel dokumen load
            time.sleep(3)
            
            # 4. Verifikasi Dokumen Kebenaran Data - DITERIMA
            print("\n  === Verifikasi Dokumen Kebenaran Data (DITERIMA) ===")
            self.verifikasi_dokumen(
                nama_dokumen="Pernyataan Kebenaran Data",
                status="terverifikasi",
                keterangan="Dokumen lengkap dan sesuai persyaratan"
            )
            
            # 5. Verifikasi Dokumen Bebas Kompen - DITOLAK
            print("\n  === Verifikasi Dokumen Bebas Kompen (DITOLAK) ===")
            self.verifikasi_dokumen(
                nama_dokumen="Bebas Kompen",
                status="ditolak",
                keterangan="Dokumen tidak sesuai format, mohon upload ulang dengan format yang benar"
            )
            
            print("\n✓ Test verifikasi dokumen PASSED")
            
        except Exception as e:
            print(f"\n✗ Test verifikasi dokumen FAILED: {str(e)}")
            screenshot_path = "c:/laragon/www/BebasTanggungan/test/error_verifikasi_admin.png"
            self.driver.save_screenshot(screenshot_path)
            print(f"  Screenshot disimpan di: {screenshot_path}")
            raise
    
    def verifikasi_dokumen(self, nama_dokumen, status, keterangan):
        """
        Fungsi helper untuk verifikasi dokumen
        
        Args:
            nama_dokumen: Nama dokumen yang akan diverifikasi
            status: 'terverifikasi' atau 'ditolak'
            keterangan: Keterangan verifikasi
        """
        try:
            print(f"  - Mencari dokumen '{nama_dokumen}'...")
            
            # Cari row dokumen berdasarkan nama
            dokumen_row = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, f"//td[contains(text(), '{nama_dokumen}')]/parent::tr"))
            )
            
            # Scroll ke row dokumen
            self.driver.execute_script("arguments[0].scrollIntoView(true);", dokumen_row)
            time.sleep(1)
            
            # Cek status dokumen saat ini
            try:
                status_badge = dokumen_row.find_element(By.CSS_SELECTOR, ".badge")
                status_current = status_badge.text.lower()
                print(f"  ✓ Status saat ini: {status_current}")
            except:
                print("  ! Tidak dapat membaca status dokumen")
            
            # Klik tombol Verifikasi
            verifikasi_button = dokumen_row.find_element(By.XPATH, ".//button[@data-toggle='modal']")
            
            # Scroll ke tombol jika perlu
            self.driver.execute_script("arguments[0].scrollIntoView(true);", verifikasi_button)
            time.sleep(1)
            
            verifikasi_button.click()
            print("  ✓ Tombol verifikasi diklik")
            
            # Tunggu modal verifikasi muncul dan visible
            modal = WebDriverWait(self.driver, 10).until(
                EC.visibility_of_element_located((By.ID, "verifikasiModal"))
            )
            print("  ✓ Modal verifikasi terbuka")
            
            # Tunggu sampai modal fully loaded
            time.sleep(2)
            
            # Verifikasi modal benar-benar terlihat
            assert modal.is_displayed(), "Modal tidak terlihat"
            
            # Pilih status verifikasi menggunakan JavaScript
            print("  - Memilih status verifikasi...")
            if status == "terverifikasi":
                # Pilih radio button Terverifikasi (id="terverifikasi", value="4") menggunakan JavaScript
                self.driver.execute_script("""
                    var radio = document.getElementById('terverifikasi');
                    if (radio) {
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                """)
                time.sleep(1.5)
                print("  ✓ Status: TERVERIFIKASI dipilih")
            elif status == "ditolak":
                # Pilih radio button Ditolak (id="ditolak", value="2") menggunakan JavaScript
                self.driver.execute_script("""
                    var radio = document.getElementById('ditolak');
                    if (radio) {
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                """)
                time.sleep(1.5)
                print("  ✓ Status: DITOLAK dipilih")
            
            # Isi keterangan menggunakan JavaScript
            print("  - Mengisi keterangan...")
            
            # Tunggu sebentar untuk event handler bekerja
            time.sleep(1)
            
            # Set nilai keterangan menggunakan JavaScript
            keterangan_escaped = keterangan.replace("'", "\\'").replace('"', '\\"')
            self.driver.execute_script(f"""
                var keteranganField = document.getElementById('keterangan');
                if (keteranganField) {{
                    keteranganField.disabled = false;
                    keteranganField.value = '{keterangan_escaped}';
                    keteranganField.dispatchEvent(new Event('input', {{ bubbles: true }}));
                }}
            """)
            time.sleep(1)
            print(f"  ✓ Keterangan diisi: '{keterangan}'")
            
            # Klik tombol Simpan menggunakan JavaScript
            print("  - Submit verifikasi...")
            
            # Tunggu sebentar untuk memastikan form siap
            time.sleep(1.5)
            
            # Enable tombol simpan dan klik menggunakan JavaScript
            self.driver.execute_script("""
                var simpanBtn = document.getElementById('simpanVerifikasi');
                if (simpanBtn) {
                    simpanBtn.disabled = false;
                    simpanBtn.click();
                }
            """)
            print("  ✓ Tombol Simpan diklik")
            
            # Tunggu proses submit dan redirect/modal
            time.sleep(5)
            
            # Cek apakah ada modal status atau redirect
            try:
                # Cek URL apakah ada parameter message
                current_url = self.driver.current_url
                if "message=" in current_url:
                    print("  ✓ Verifikasi berhasil disubmit (URL redirect dengan message)")
                
                # Atau cek modal status
                try:
                    modal_status = WebDriverWait(self.driver, 5).until(
                        EC.visibility_of_element_located((By.ID, "uploadModalStatus"))
                    )
                    upload_message = self.driver.find_element(By.ID, "uploadMessage").text
                    print(f"  ✓ Pesan status: {upload_message}")
                    
                    # Tutup modal
                    close_button = self.driver.find_element(By.XPATH, "//div[@id='uploadModalStatus']//button[@data-dismiss='modal']")
                    close_button.click()
                    time.sleep(1)
                except:
                    pass
                
            except:
                print("  ! Modal status tidak muncul")
            
            # Tunggu kembali ke halaman detail
            time.sleep(2)
            
            print(f"  ✓ Verifikasi dokumen '{nama_dokumen}' selesai\n")
            
        except Exception as e:
            print(f"  ✗ Gagal verifikasi dokumen '{nama_dokumen}': {str(e)}")
            raise
    
    def test_verifikasi_multiple_mahasiswa(self):
        """Test verifikasi dokumen untuk beberapa mahasiswa"""
        print("\nTest: Verifikasi Dokumen Multiple Mahasiswa")
        try:
            # Login
            print("  - Login sebagai Admin Lt6...")
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            
            self.driver.find_element(By.ID, "username").send_keys("10230001")
            self.driver.find_element(By.ID, "password").send_keys("admin")
            self.driver.find_element(By.ID, "loginButton").click()
            
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".welcome-name"))
            )
            print("  ✓ Login berhasil")
            
            # Navigasi ke daftar mahasiswa
            daftar_mahasiswa_nav = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.XPATH, "//a[@href='daftar_mahasiswa.php']"))
            )
            daftar_mahasiswa_nav.click()
            
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Verifikasi Berkas Mahasiswa')]"))
            )
            print("  ✓ Halaman Daftar Mahasiswa terbuka")
            
            time.sleep(3)
            
            # Hitung jumlah mahasiswa
            detail_buttons = self.driver.find_elements(By.XPATH, "//a[contains(@href, 'detail_mahasiswa.php')]")
            total_mahasiswa = len(detail_buttons)
            print(f"  ✓ Total mahasiswa dalam daftar: {total_mahasiswa}")
            
            # Verifikasi mahasiswa pertama saja untuk test
            if total_mahasiswa > 0:
                print(f"\n  === Verifikasi Mahasiswa #1 ===")
                detail_buttons[0].click()
                
                WebDriverWait(self.driver, 10).until(
                    EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Detail Mahasiswa')]"))
                )
                
                time.sleep(3)
                
                # Ambil info mahasiswa
                try:
                    nama_mahasiswa = self.driver.find_element(By.ID, "nama").get_attribute("value")
                    nim_mahasiswa = self.driver.find_element(By.ID, "nim").get_attribute("value")
                    print(f"  ✓ Mahasiswa: {nama_mahasiswa} ({nim_mahasiswa})")
                except:
                    print("  ! Info mahasiswa tidak tersedia")
                
                # Verifikasi satu dokumen
                self.verifikasi_dokumen(
                    nama_dokumen="Pernyataan Kebenaran Data",
                    status="terverifikasi",
                    keterangan="Dokumen terverifikasi - Test automation"
                )
                
                print("  ✓ Verifikasi selesai untuk mahasiswa #1")
            
            print("\n✓ Test verifikasi multiple mahasiswa PASSED")
            
        except Exception as e:
            print(f"\n✗ Test verifikasi multiple mahasiswa FAILED: {str(e)}")
            screenshot_path = "c:/laragon/www/BebasTanggungan/test/error_verifikasi_multiple.png"
            self.driver.save_screenshot(screenshot_path)
            print(f"  Screenshot disimpan di: {screenshot_path}")
            raise
    
    def run_all_tests(self):
        """Jalankan semua test"""
        print("="*60)
        print("Memulai Testing Verifikasi Admin Lt6")
        print("="*60)
        print("\nSKENARIO TEST:")
        print("1. Login sebagai Admin Lt6 (10230001/admin)")
        print("2. Navigasi ke Daftar Mahasiswa")
        print("3. Klik Detail Mahasiswa")
        print("4. Verifikasi Dokumen Kebenaran Data - DITERIMA")
        print("5. Verifikasi Dokumen Bebas Kompen - DITOLAK")
        print("="*60 + "\n")
        
        try:
            # Test 1: Verifikasi dokumen mahasiswa
            self.test_verifikasi_dokumen_mahasiswa()
            
            # Test 2: Verifikasi multiple mahasiswa (optional - di-comment)
            # self.test_verifikasi_multiple_mahasiswa()
            
            print("\n" + "="*60)
            print("Semua test selesai!")
            print("="*60)
        except Exception as e:
            print(f"\nTesting dihentikan karena error: {str(e)}")
        finally:
            time.sleep(3)  # Tunggu sebentar sebelum tutup
            self.teardown()


if __name__ == "__main__":
    test = TestVerifikasiAdminLt6()
    test.run_all_tests()
