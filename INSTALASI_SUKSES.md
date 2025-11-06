# 🎉 INSTALASI CYPRESS BERHASIL!

## ✅ Masalah yang Diperbaiki

### Error Sebelumnya:
1. ❌ **node-sass tidak kompatibel** dengan Node.js v24
2. ❌ **Python 3.13 terlalu baru** untuk node-gyp versi lama
3. ❌ **Cypress belum terinstall**

### Solusi yang Diterapkan:
1. ✅ Mengganti `gulp-sass` dari v4.1.0 ke v5.1.0
2. ✅ Mengganti `node-sass` dengan `sass` v1.69.0 (Dart Sass)
3. ✅ Menginstall Cypress v13.17.0
4. ✅ Membersihkan node_modules dan reinstall semua dependencies

---

## 📦 Apa yang Sudah Diinstall?

### Software:
- **Cypress**: v13.17.0 ✅
- **Node.js**: v24.11.0 ✅
- **npm**: v11.6.1 ✅

### File & Folder yang Dibuat:

```
BebasTanggungan/
├── cypress.config.js              ⚙️ Konfigurasi Cypress
├── CYPRESS_GUIDE.md               📖 Panduan lengkap
├── cypress/
│   ├── e2e/                       
│   │   ├── login.cy.js           🧪 Test login
│   │   ├── homepage.cy.js        🧪 Test homepage
│   │   ├── mahasiswa.cy.js       🧪 Test fitur mahasiswa
│   │   └── admin.cy.js           🧪 Test fitur admin
│   ├── support/
│   │   ├── commands.js           🔧 Custom commands
│   │   └── e2e.js                🔧 Setup global
│   ├── fixtures/
│   │   └── testdata.json         📊 Data testing
│   └── README.md                 📖 Dokumentasi
└── package.json                   📦 Updated
```

---

## 🚀 CARA MENJALANKAN

### 1. Pastikan Laragon Running
```
Start Apache & MySQL di Laragon
```

### 2. Buka Cypress Test Runner (Interaktif)
```bash
npm run cypress:open
```

### 3. Atau Run Test Headless
```bash
npm run cypress:run
```

### 4. Run Specific Test
```bash
npx cypress run --spec "cypress/e2e/login.cy.js"
```

---

## 🎯 Test yang Sudah Dibuat

### 1. **login.cy.js** - Test Login
- ✅ Halaman login tampil
- ✅ Validasi form kosong
- ✅ Login dengan kredensial valid

### 2. **homepage.cy.js** - Test Homepage
- ✅ Homepage bisa diakses
- ✅ Title tidak kosong

### 3. **mahasiswa.cy.js** - Test Fitur Mahasiswa
- ✅ Dashboard mahasiswa
- ✅ Upload dokumen
- ✅ View data akademik/jurusan/prodi
- ✅ Cek persentase

### 4. **admin.cy.js** - Test Fitur Admin
- ✅ Admin Pusat
- ✅ Admin Perpustakaan
- ✅ Admin Lantai 6
- ✅ Admin Lantai 7

---

## 🛠️ Custom Commands

Gunakan di test Anda:

```javascript
// Login otomatis
cy.login('username', 'password')

// Logout
cy.logout()

// Upload file
cy.uploadFile('input[type="file"]', 'path/to/file')
```

---

## 📝 Contoh Menjalankan Test

### Cara 1: Menggunakan Test Runner (Recommended)
```bash
npm run cypress:open
```
Kemudian:
1. Pilih **E2E Testing**
2. Pilih browser (Chrome/Edge/Firefox)
3. Klik test yang ingin dijalankan

### Cara 2: Run All Tests Headless
```bash
npm run cypress:run
```

### Cara 3: Run Specific Test
```bash
npx cypress run --spec "cypress/e2e/mahasiswa.cy.js"
```

### Cara 4: Run dengan Browser Tertentu
```bash
npx cypress run --browser chrome
npx cypress run --browser edge
```

---

## ⚙️ Konfigurasi

File: `cypress.config.js`

```javascript
{
  baseUrl: 'http://localhost/BebasTanggungan',
  viewport: 1280x720,
  video: false,
  screenshots: true (saat test gagal)
}
```

**Untuk mengubah baseURL**, edit file `cypress.config.js`:
```javascript
baseUrl: 'http://localhost:8080/BebasTanggungan', // contoh
```

---

## 💡 Tips Penting

### 1. Sebelum Testing
- ✅ Start Laragon
- ✅ Pastikan database aktif
- ✅ Buka http://localhost/BebasTanggungan di browser untuk cek

### 2. Membuat Test Baru
```javascript
// File: cypress/e2e/namatest.cy.js
describe('Test Suite Name', () => {
  it('should do something', () => {
    cy.visit('/page.php')
    cy.get('#element').should('be.visible')
  })
})
```

### 3. Debugging
- Gunakan `cy.pause()` untuk pause test
- Gunakan `cy.debug()` untuk debug
- Gunakan `.only` untuk run satu test saja:
  ```javascript
  it.only('should test this only', () => { ... })
  ```

### 4. Best Practices
- ❌ Jangan hardcode `cy.wait(5000)`
- ✅ Gunakan `cy.get('#el').should('be.visible')`
- ✅ Setiap test harus independent
- ✅ Gunakan `beforeEach()` untuk setup

---

## 🔧 Troubleshooting

### Error: "Cypress cannot find baseURL"
**Solusi**: 
- Pastikan Laragon running
- Cek baseURL di `cypress.config.js`

### Test Gagal karena Element tidak ditemukan
**Solusi**:
```javascript
// Tambahkan timeout
cy.get('#element', { timeout: 10000 })

// Atau wait untuk element
cy.get('#element').should('exist')
```

### Error EBUSY atau EPERM
**Solusi**:
- Tutup Cypress window
- Tutup VS Code
- Hapus folder `node_modules`
- Run `npm install` lagi

---

## 📚 Resources

- [Cypress Docs](https://docs.cypress.io)
- [Best Practices](https://docs.cypress.io/guides/references/best-practices)
- [API Reference](https://docs.cypress.io/api/table-of-contents)
- [Examples](https://github.com/cypress-io/cypress-example-recipes)

---

## ✨ Next Steps

1. **Customize Test Data**
   - Edit `cypress/fixtures/testdata.json`
   - Tambahkan kredensial test yang valid

2. **Sesuaikan Test dengan Aplikasi**
   - Update selector di file test
   - Tambahkan assertions sesuai requirement

3. **Tambah Test Baru**
   - Buat file di `cypress/e2e/`
   - Ikuti pattern yang sudah ada

4. **Setup CI/CD** (Optional)
   - Integrasikan dengan GitHub Actions
   - Automated testing di setiap commit

---

## 🎊 Selamat!

Cypress sudah siap digunakan untuk testing aplikasi Bebas Tanggungan Anda!

**Jalankan sekarang:**
```bash
npm run cypress:open
```

Happy Testing! 🚀
