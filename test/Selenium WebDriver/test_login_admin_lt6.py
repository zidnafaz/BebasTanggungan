import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.wait import WebDriverWait


class TestLoginAdmin:
    def __init__(self):
        self.driver = webdriver.Chrome()
        self.driver.implicitly_wait(10)
        self.vars = {}
    
    def teardown(self):
        self.driver.quit()
    
    # Test 1
    def test_login_admin_success(self):
        """Test login admin dengan credentials yang valid"""
        print("Test 1: Login dengan credentials yang valid")
        try:
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            
            self.driver.find_element(By.ID, "username").send_keys("10230001")
            self.driver.find_element(By.ID, "password").send_keys("admin")
            self.driver.find_element(By.ID, "loginButton").click()
            
            WebDriverWait(self.driver, 10).until(
                EC.presence_of_element_located((By.CSS_SELECTOR, ".welcome-name"))
            )
            
            welcome_text = self.driver.find_element(By.CSS_SELECTOR, ".welcome-name").text
            dashboard_text = self.driver.find_element(By.CSS_SELECTOR, ".h3").text
            
            assert welcome_text == "Selamat Datang Ila", f"Expected 'Selamat Datang Ila', got '{welcome_text}'"
            assert dashboard_text == "Dashboard Admin Prodi - Selamat Datang Ila", f"Expected 'Dashboard Admin Prodi - Selamat Datang Ila', got '{dashboard_text}'"
            
            print("✓ Test login success PASSED")
        except Exception as e:
            print(f"✗ Test login success FAILED: {str(e)}")
            raise
    
    # Test 2
    def test_login_admin_wrong_password(self):
        """Test login admin dengan password yang salah"""
        print("\nTest 2: Login dengan password yang salah")
        try:
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            
            self.driver.find_element(By.ID, "username").send_keys("10230001")
            self.driver.find_element(By.ID, "password").send_keys("wrongpassword")
            self.driver.find_element(By.ID, "loginButton").click()
            
            time.sleep(2)
            
            # Cek apakah masih di halaman login atau ada error message
            current_url = self.driver.current_url
            assert "login" in current_url.lower() or "index" in current_url.lower(), "Should stay on login page"
            
            print("✓ Test wrong password PASSED")
        except Exception as e:
            print(f"✗ Test wrong password FAILED: {str(e)}")
            raise
    
    # Test 3
    def test_login_admin_wrong_username(self):
        """Test login admin dengan username yang salah"""
        print("\nTest 3: Login dengan username yang salah")
        try:
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            
            self.driver.find_element(By.ID, "username").send_keys("99999999")
            self.driver.find_element(By.ID, "password").send_keys("admin")
            self.driver.find_element(By.ID, "loginButton").click()
            
            time.sleep(2)
            
            current_url = self.driver.current_url
            assert "login" in current_url.lower() or "index" in current_url.lower(), "Should stay on login page"
            
            print("✓ Test wrong username PASSED")
        except Exception as e:
            print(f"✗ Test wrong username FAILED: {str(e)}")
            raise
    
    # Test 4
    def test_login_admin_empty_fields(self):
        """Test login admin dengan field kosong"""
        print("\nTest 4: Login dengan field kosong")
        try:
            self.driver.get("http://localhost/BebasTanggungan/index.html")
            
            self.driver.find_element(By.ID, "loginButton").click()
            
            time.sleep(1)
            
            # Cek validasi HTML5 atau masih di halaman login
            username_field = self.driver.find_element(By.ID, "username")
            assert username_field.get_attribute("required") or username_field.get_attribute("validationMessage")
            
            print("✓ Test empty fields PASSED")
        except Exception as e:
            print(f"✗ Test empty fields FAILED: {str(e)}")
            raise
    
    def run_all_tests(self):
        """Jalankan semua test"""
        print("="*50)
        print("Memulai Testing Login Admin")
        print("="*50)
        
        try:
            self.test_login_admin_success()
            self.test_login_admin_wrong_password()
            self.test_login_admin_wrong_username()
            self.test_login_admin_empty_fields()
            
            print("\n" + "="*50)
            print("Semua test selesai!")
            print("="*50)
        except Exception as e:
            print(f"\nTesting dihentikan karena error: {str(e)}")
        finally:
            self.teardown()


if __name__ == "__main__":
    test = TestLoginAdmin()
    test.run_all_tests()
