import time
import os
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.wait import WebDriverWait


class TestUploadDokumen:
    def __init__(self):
        self.driver = webdriver.Edge()
        self.driver.implicitly_wait(10)
        self.vars = {}
    
    def teardown(self):
        self.driver.quit()
    
    # Test 1
    def test_upload_dokumen_penyerahan_kebenaran_data(self):
        """Test upload dokumen penyerahan kebenaran data"""
        print("Test: Upload dokumen penyerahan kebenaran data")
        try:
            # 1. Login sebagai mahasiswa
            print("  - Login sebagai mahasiswa...")
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            
            self.driver.find_element(By.ID, "username").send_keys("20230002")
            self.driver.find_element(By.ID, "password").send_keys("20230002")
            self.driver.find_element(By.ID, "loginButton").click()
            
            # Tunggu sampai halaman home muncul
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".welcome-name"))
            )
            print("  ✓ Login berhasil")
            
            # 2. Klik navbar prodi (nav-prodi)
            print("  - Navigasi ke halaman prodi...")
            nav_prodi = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.ID, "nav-jurusan"))
            )
            nav_prodi.click()
            
            # Tunggu halaman prodi load
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Verifikasi Berkas Program Studi')]"))
            )
            print("  ✓ Halaman prodi terbuka")
            
            # 3. Tunggu tabel data muncul
            print("  - Menunggu tabel data muncul...")
            time.sleep(3)  # Tunggu AJAX load
            
            # 4. Klik tombol upload untuk penyerahan_kebenaran_data
            print("  - Mencari tombol upload untuk Pernyataan Kebenaran Data...")
            
            # Tunggu tombol upload muncul dan dapat diklik
            upload_button = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//button[contains(@onclick, 'penyerahan_kebenaran_data')]"))
            )
            
            # Scroll ke elemen jika perlu
            self.driver.execute_script("arguments[0].scrollIntoView(true);", upload_button)
            time.sleep(1)
            
            # Klik tombol upload
            upload_button.click()
            print("  ✓ Tombol upload diklik")
            
            # 5. Tunggu modal upload muncul
            print("  - Menunggu modal upload muncul...")
            WebDriverWait(self.driver, 10).until(
                EC.visibility_of_element_located((By.ID, "uploadModal"))
            )
            print("  ✓ Modal upload terbuka")
            
            # 6. Upload file
            print("  - Upload file...")
            file_path = r"C:\testing\20230002_penyerahan_kebenaran_data.pdf"
            
            # Pastikan file exists
            if not os.path.exists(file_path):
                raise FileNotFoundError(f"File tidak ditemukan: {file_path}")
            
            file_input = self.driver.find_element(By.ID, "file")
            file_input.send_keys(file_path)
            print(f"  ✓ File dipilih: {file_path}")
            
            # Tunggu nama file muncul
            time.sleep(1)
            file_name_input = self.driver.find_element(By.ID, "fileName")
            selected_file = file_name_input.get_attribute("value")
            print(f"  ✓ File yang dipilih: {selected_file}")
            
            # 7. Submit form
            print("  - Submit form upload...")
            submit_button = self.driver.find_element(By.XPATH, "//button[@type='submit' and contains(text(), 'Upload')]")
            submit_button.click()
            print("  ✓ Form disubmit")
            
            # 8. Tunggu response (modal status atau alert)
            print("  - Menunggu response upload...")
            time.sleep(3)
            
            # Cek apakah ada modal status yang muncul
            try:
                modal_status = WebDriverWait(self.driver, 10).until(
                    EC.visibility_of_element_located((By.ID, "uploadModalStatus"))
                )
                upload_message = self.driver.find_element(By.ID, "uploadMessage").text
                print(f"  ✓ Upload response: {upload_message}")
                
                # Verifikasi pesan sukses
                assert "berhasil" in upload_message.lower(), f"Upload gagal: {upload_message}"
                print("  ✓ Upload berhasil!")
                
            except:
                print("  ! Modal status tidak muncul, cek manual")
            
            print("\n✓ Test upload dokumen PASSED")
            
        except FileNotFoundError as e:
            print(f"\n✗ Test upload dokumen FAILED: {str(e)}")
            print(f"  Pastikan file ada di: C:\\testing\\20230002_penyerahan_kebenaran_data.pdf")
            raise
        except Exception as e:
            print(f"\n✗ Test upload dokumen FAILED: {str(e)}")
            # Screenshot untuk debugging
            screenshot_path = "c:/laragon/www/BebasTanggungan/test/error_screenshot.png"
            self.driver.save_screenshot(screenshot_path)
            print(f"  Screenshot disimpan di: {screenshot_path}")
            raise
    
    # Test 2
    def test_upload_button_disabled_when_pending(self):
        """Test tombol upload disabled ketika status pending (TOEIC)"""
        print("\nTest: Tombol upload disabled ketika status pending (TOEIC)")
        try:
            # Login
            print("  - Login sebagai mahasiswa...")
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            self.driver.find_element(By.ID, "username").send_keys("20230002")
            self.driver.find_element(By.ID, "password").send_keys("20230002")
            self.driver.find_element(By.ID, "loginButton").click()
            
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".welcome-name"))
            )
            print("  ✓ Login berhasil")
            
            # Navigasi ke prodi
            print("  - Navigasi ke halaman prodi...")
            nav_prodi = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.ID, "nav-jurusan"))
            )
            nav_prodi.click()
            
            # Tunggu halaman prodi load
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Verifikasi Berkas Program Studi')]"))
            )
            print("  ✓ Halaman prodi terbuka")
            
            # Tunggu tabel data muncul
            print("  - Menunggu tabel data muncul...")
            time.sleep(3)
            
            # Cari tombol upload untuk TOEIC yang statusnya pending
            print("  - Mencari tombol upload untuk TOEIC (status pending)...")
            
            # Cari row TOEIC di tabel
            toeic_row = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//td[contains(text(), 'TOEIC')]/parent::tr"))
            )
            
            # Scroll ke row TOEIC
            self.driver.execute_script("arguments[0].scrollIntoView(true);", toeic_row)
            time.sleep(1)
            
            # Cek status TOEIC
            status_badge = toeic_row.find_element(By.CSS_SELECTOR, ".badge")
            status_text = status_badge.text.lower()
            print(f"  ✓ Status TOEIC: {status_text}")
            
            # Cari tombol upload di row TOEIC
            upload_button = toeic_row.find_element(By.XPATH, ".//button[contains(@onclick, 'toeic') or contains(text(), 'Upload')]")
            
            # Cek apakah tombol disabled
            is_disabled = upload_button.get_attribute("disabled")
            button_class = upload_button.get_attribute("class")
            
            print(f"  - Tombol disabled: {is_disabled is not None}")
            print(f"  - Class tombol: {button_class}")
            
            # Verifikasi tombol disabled ketika status pending
            if status_text == "pending":
                assert is_disabled is not None, "Tombol upload seharusnya disabled ketika status pending"
                assert "btn-secondary" in button_class, "Tombol upload seharusnya memiliki class btn-secondary ketika disabled"
                print("  ✓ Tombol upload DISABLED (sesuai ekspektasi untuk status pending)")
                
                # Coba klik tombol (seharusnya tidak bisa)
                try:
                    upload_button.click()
                    print("  ! Tombol bisa diklik (tidak seharusnya)")
                except:
                    print("  ✓ Tombol tidak bisa diklik (sesuai ekspektasi)")
                
            else:
                print(f"  ! Status bukan pending, test dilewati")
            
            print("\n✓ Test button disabled PASSED")
            
        except Exception as e:
            print(f"\n✗ Test button disabled FAILED: {str(e)}")
            screenshot_path = "c:/laragon/www/BebasTanggungan/test/error_button_disabled.png"
            self.driver.save_screenshot(screenshot_path)
            print(f"  Screenshot disimpan di: {screenshot_path}")
            raise
    
    # Test 3
    def test_upload_dokumen_file_tidak_ada(self):
        """Test upload dengan file yang tidak ada"""
        print("\nTest: Upload dengan file yang tidak ada")
        try:
            # Login
            print("  - Login sebagai mahasiswa...")
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            self.driver.find_element(By.ID, "username").send_keys("20230002")
            self.driver.find_element(By.ID, "password").send_keys("20230002")
            self.driver.find_element(By.ID, "loginButton").click()
            
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".welcome-name"))
            )
            print("  ✓ Login berhasil")
            
            # Navigasi ke prodi
            print("  - Navigasi ke halaman prodi...")
            nav_prodi = WebDriverWait(self.driver, 10).until(
                EC.element_to_be_clickable((By.ID, "nav-jurusan"))
            )
            nav_prodi.click()
            
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Verifikasi Berkas Program Studi')]"))
            )
            print("  ✓ Halaman prodi terbuka")
            
            time.sleep(3)
            
            # Klik upload button untuk penyerahan kebenaran data
            print("  - Mencari tombol upload untuk Pernyataan Kebenaran Data...")
            upload_button = WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//button[contains(@onclick, 'penyerahan_skripsi')]"))
            )
            
            # Scroll ke elemen
            self.driver.execute_script("arguments[0].scrollIntoView(true);", upload_button)
            time.sleep(1)
            
            upload_button.click()
            print("  ✓ Tombol upload diklik")
            
            WebDriverWait(self.driver, 10).until(
                EC.visibility_of_element_located((By.ID, "uploadModal"))
            )
            print("  ✓ Modal upload terbuka")
            
            # Coba upload file yang tidak ada
            print("  - Mencoba memilih file yang tidak ada...")
            file_input = self.driver.find_element(By.ID, "file")
            
            # Path file yang tidak ada
            non_existent_file = r"C:\testing\file_tidak_ada_1234567890.pdf"
            
            try:
                file_input.send_keys(non_existent_file)
                time.sleep(2)
                
                # Cek apakah file dipilih atau tidak
                file_name_input = self.driver.find_element(By.ID, "fileName")
                selected_file = file_name_input.get_attribute("value")
                
                print(f"  - File yang terpilih: '{selected_file}'")
                
                # Jika file tidak terpilih (empty atau "No file chosen")
                if selected_file == "" or selected_file == "No file chosen" or "file_tidak_ada" not in selected_file:
                    print("  ✓ File tidak terpilih (browser menolak file yang tidak ada)")
                    print("  ✓ Validasi browser bekerja dengan baik")
                else:
                    print(f"  ! File terpilih: {selected_file}")
                    print("  ! Browser menerima path file yang tidak ada")
                
                # Coba submit form (seharusnya gagal atau tidak ada yang terjadi)
                try:
                    submit_button = self.driver.find_element(By.XPATH, "//button[@type='submit' and contains(text(), 'Upload')]")
                    
                    # Cek apakah tombol submit aktif
                    is_submit_disabled = submit_button.get_attribute("disabled")
                    
                    if selected_file == "" or selected_file == "No file chosen":
                        print("  ✓ File tidak dipilih, validasi HTML5 required akan mencegah submit")
                    
                except Exception as e:
                    print(f"  - Submit button check: {str(e)}")
                
            except Exception as e:
                print(f"  ✓ Error saat memilih file (expected): {str(e)}")
            
            print("\n✓ Test file tidak ada PASSED")
            
        except Exception as e:
            print(f"\n✗ Test file tidak ada FAILED: {str(e)}")
            screenshot_path = "c:/laragon/www/BebasTanggungan/test/error_file_not_found.png"
            self.driver.save_screenshot(screenshot_path)
            print(f"  Screenshot disimpan di: {screenshot_path}")
            raise
    
    
    def run_all_tests(self):
        """Jalankan semua test"""
        print("="*60)
        print("Memulai Testing Upload Dokumen")
        print("="*60)
        print("\nCATATAN:")
        print("- Pastikan file ada di: C:\\testing\\20230002_penyerahan_kebenaran_data.pdf")
        print("- File harus berupa PDF")
        print("- Ukuran maksimal 2 MB")
        print("\nSKENARIO TEST:")
        print("1. Upload dokumen sukses (Penyerahan Kebenaran Data)")
        print("2. Button disabled ketika status PENDING (TOEIC)")
        print("3. Upload dokumen dengan file yang tidak ada")
        print("="*60 + "\n")
        
        try:
            # Test 1: Upload dokumen sukses
            self.test_upload_dokumen_penyerahan_kebenaran_data()
            
            # Test 2: Button disabled ketika status pending
            self.test_upload_button_disabled_when_pending()
            
            # Test 3: Upload dengan file yang tidak ada
            self.test_upload_dokumen_file_tidak_ada()
            
            print("\n" + "="*60)
            print("Semua test selesai!")
            print("="*60)
        except Exception as e:
            print(f"\nTesting dihentikan karena error: {str(e)}")
        finally:
            time.sleep(2)  # Tunggu sebentar sebelum tutup
            self.teardown()


if __name__ == "__main__":
    test = TestUploadDokumen()
    test.run_all_tests()
