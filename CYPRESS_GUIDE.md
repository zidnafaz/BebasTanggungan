# ✅ Cypress Testing - Instalasi Berhasil!

## 📦 Yang Sudah Diinstall

- **Cypress**: v13.17.0
- **Node.js**: v24.11.0
- **npm**: v11.6.1

## 🚀 Cara Menjalankan Test

### 1️⃣ Buka Cypress (Mode Interaktif)
```bash
npm run cypress:open
```
Atau gunakan:
```bash
npx cypress open
```

**Catatan**: Pastikan server Laragon sudah running sebelum menjalankan test!

### 2️⃣ Run Test Headless (Tanpa UI)
```bash
npm run cypress:run
```
Atau:
```bash
npm test
```

## 📁 Struktur File Cypress

```
BebasTanggungan/
├── cypress/
│   ├── e2e/                    # 📝 File test Anda
│   │   ├── login.cy.js        # Test login
│   │   └── homepage.cy.js     # Test homepage
│   ├── support/
│   │   ├── commands.js        # Custom commands
│   │   └── e2e.js             # Setup global
│   ├── fixtures/              # Data testing
│   └── README.md              # Dokumentasi
├── cypress.config.js          # ⚙️ Konfigurasi Cypress
└── package.json
```

## 🎯 Test yang Sudah Dibuat

### 1. Login Test (`login.cy.js`)
- ✅ Cek halaman login tampil
- ✅ Validasi form kosong
- ✅ Test login dengan kredensial valid

### 2. Homepage Test (`homepage.cy.js`)
- ✅ Cek homepage bisa diakses
- ✅ Cek title tidak kosong

## 🛠️ Custom Commands

Anda bisa gunakan custom commands ini di test:

```javascript
// Login otomatis
cy.login('username', 'password')

// Logout
cy.logout()

// Upload file
cy.uploadFile('input[type="file"]', 'path/to/file')
```

## ⚙️ Konfigurasi

File: `cypress.config.js`

```javascript
baseUrl: 'http://localhost/BebasTanggungan'
viewport: 1280x720
video: false (untuk performa)
screenshots: true (saat test gagal)
```

## 📝 Contoh Membuat Test Baru

Buat file baru di `cypress/e2e/namatest.cy.js`:

```javascript
describe('Nama Test Suite', () => {
  beforeEach(() => {
    // Setup sebelum setiap test
    cy.visit('/halaman.php')
  })

  it('should do something', () => {
    // Test Anda
    cy.get('#element-id').should('be.visible')
    cy.get('button').click()
    cy.url().should('include', '/success')
  })
})
```

## 🔧 Troubleshooting

### ❌ Error: "Cypress cannot find baseURL"
**Solusi**: 
- Pastikan Laragon sudah running
- Cek baseURL di `cypress.config.js` sudah benar

### ❌ Test timeout
**Solusi**:
```javascript
cy.get('#element', { timeout: 10000 }).should('exist')
```

### ❌ Element tidak ditemukan
**Solusi**:
- Gunakan Cypress Test Runner untuk inspect element
- Gunakan selector yang lebih spesifik (ID, data-cy, dll)

## 📚 Resources Berguna

- [Dokumentasi Cypress](https://docs.cypress.io)
- [Best Practices](https://docs.cypress.io/guides/references/best-practices)
- [Assertions Reference](https://docs.cypress.io/guides/references/assertions)
- [API Commands](https://docs.cypress.io/api/table-of-contents)

## 💡 Tips

1. **Gunakan data-cy attribute** untuk selector yang lebih stabil
   ```html
   <button data-cy="submit-btn">Submit</button>
   ```
   ```javascript
   cy.get('[data-cy="submit-btn"]').click()
   ```

2. **Gunakan beforeEach** untuk setup yang berulang

3. **Hindari hardcode wait**
   ```javascript
   // ❌ Jangan
   cy.wait(5000)
   
   // ✅ Gunakan
   cy.get('#element').should('be.visible')
   ```

4. **Test harus independent** - setiap test tidak bergantung satu sama lain

## 🎉 Selamat Testing!

Cypress sudah siap digunakan. Silakan jalankan `npm run cypress:open` untuk memulai!
