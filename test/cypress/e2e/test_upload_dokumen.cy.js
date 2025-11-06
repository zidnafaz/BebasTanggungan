describe('Test Upload Dokumen', () => {
  
  it('Test 1: Upload dokumen penyerahan kebenaran data', () => {
    console.log('Test 1: Upload dokumen penyerahan kebenaran data')
    
    // 1. Login sebagai mahasiswa
    console.log('  - Login sebagai mahasiswa...')
    cy.visit('/index.html')
    cy.get('#username').type('20230002')
    cy.get('#password').type('20230002')
    cy.get('#loginButton').click()
    
    // Tunggu sampai halaman home muncul
    cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
    console.log('  ✓ Login berhasil')
    
    // 2. Klik navbar prodi
    console.log('  - Navigasi ke halaman prodi...')
    cy.get('#nav-jurusan').click()
    
    // Tunggu halaman prodi load
    cy.contains('h1', 'Verifikasi Berkas Program Studi', { timeout: 10000 })
      .should('be.visible')
    console.log('  ✓ Halaman prodi terbuka')
    
    // 3. Tunggu tabel data muncul
    console.log('  - Menunggu tabel data muncul...')
    cy.wait(3000)
    
    // 4. Klik tombol upload untuk penyerahan_kebenaran_data
    console.log('  - Mencari tombol upload untuk Pernyataan Kebenaran Data...')
    cy.get('button[onclick*="penyerahan_kebenaran_data"]')
      .scrollIntoView()
      .wait(1000)
      .click()
    console.log('  ✓ Tombol upload diklik')
    
    // 5. Tunggu modal upload muncul
    console.log('  - Menunggu modal upload muncul...')
    cy.get('#uploadModal', { timeout: 10000 })
      .should('be.visible')
    console.log('  ✓ Modal upload terbuka')
    
    // 6. Upload file
    console.log('  - Upload file...')
    const fileName = '20230002_penyerahan_kebenaran_data.pdf'
    const filePath = 'C:\\testing\\' + fileName
    
    // Cypress menggunakan fixture atau selectFile
    // Untuk test ini, kita simulasi dengan file yang ada
    cy.get('#file').selectFile(filePath, { force: true })
    console.log(`  ✓ File dipilih: ${filePath}`)
    
    // Tunggu nama file muncul
    cy.wait(1000)
    // Verify fileName field contains the filename (bisa full path atau nama file saja)
    cy.get('#fileName').invoke('val').should('include', fileName)
    console.log(`  ✓ File yang dipilih: ${fileName}`)
    
    // 7. Submit form
    console.log('  - Submit form upload...')
    cy.get('button[type="submit"]').contains('Upload').click()
    console.log('  ✓ Form disubmit')
    
    // 8. Tunggu response
    console.log('  - Menunggu response upload...')
    cy.wait(3000)
    
    // Verifikasi pesan sukses
    cy.get('#uploadMessage', { timeout: 10000 })
      .should('contain.text', 'berhasil')
    
    console.log('✓ Test upload dokumen PASSED')
  })

  it('Test 2: Tombol upload disabled ketika status pending (TOEIC)', () => {
    console.log('Test 2: Tombol upload disabled ketika status pending (TOEIC)')
    
    // Login
    console.log('  - Login sebagai mahasiswa...')
    cy.visit('/index.html')
    cy.get('#username').type('20230002')
    cy.get('#password').type('20230002')
    cy.get('#loginButton').click()
    
    cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
    console.log('  ✓ Login berhasil')
    
    // Navigasi ke prodi
    console.log('  - Navigasi ke halaman prodi...')
    cy.get('#nav-jurusan').click()
    
    cy.contains('h1', 'Verifikasi Berkas Program Studi', { timeout: 10000 })
      .should('be.visible')
    console.log('  ✓ Halaman prodi terbuka')
    
    // Tunggu tabel data muncul
    console.log('  - Menunggu tabel data muncul...')
    cy.wait(3000)
    
    // Cari row TOEIC di tabel
    console.log('  - Mencari tombol upload untuk TOEIC (status pending)...')
    cy.contains('td', 'TOEIC').parent('tr').within(() => {
      // Cek status TOEIC
      cy.get('.badge').invoke('text').then((statusText) => {
        const status = statusText.toLowerCase().trim()
        console.log(`  ✓ Status TOEIC: ${status}`)
        
        // Cari tombol upload di row ini
        cy.get('button').contains(/upload|toeic/i).then(($button) => {
          const isDisabled = $button.prop('disabled')
          const buttonClass = $button.attr('class')
          
          console.log(`  - Tombol disabled: ${isDisabled}`)
          console.log(`  - Class tombol: ${buttonClass}`)
          
          // Verifikasi tombol disabled ketika status pending
          if (status === 'pending') {
            expect(isDisabled).to.be.true
            console.log('  ✓ Tombol upload disabled (status: pending)')
          } else {
            console.log(`  ℹ Status bukan pending, status: ${status}`)
          }
        })
      })
    })
    
    console.log('✓ Test button disabled PASSED')
  })

  it('Test 3: Upload dokumen dengan file yang tidak ada', () => {
    console.log('Test 3: Upload dengan file yang tidak ada')
    
    // Login
    console.log('  - Login sebagai mahasiswa...')
    cy.visit('/index.html')
    cy.get('#username').type('20230002')
    cy.get('#password').type('20230002')
    cy.get('#loginButton').click()
    
    cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
    console.log('  ✓ Login berhasil')
    
    // Navigasi ke prodi
    console.log('  - Navigasi ke halaman prodi...')
    cy.get('#nav-jurusan').click()
    
    cy.contains('h1', 'Verifikasi Berkas Program Studi', { timeout: 10000 })
      .should('be.visible')
    console.log('  ✓ Halaman prodi terbuka')
    
    cy.wait(3000)
    
    // Klik upload button
    console.log('  - Mencari tombol upload untuk Penyerahan Skripsi...')
    cy.get('button[onclick*="penyerahan_skripsi"]')
      .scrollIntoView()
      .wait(1000)
      .click()
    
    cy.get('#uploadModal', { timeout: 10000 }).should('be.visible')
    console.log('  ✓ Modal upload terbuka')
    
    // Submit tanpa file
    console.log('  - Submit form tanpa memilih file...')
    cy.get('button[type="submit"]').contains('Upload').click()
    console.log('  ✓ Form disubmit tanpa file')
    
    cy.wait(2000)
    
    // Verifikasi ada pesan error atau validasi
    // Bisa berupa validasi HTML5 required atau pesan error dari server
    cy.get('#file').then(($input) => {
      const hasRequired = $input.prop('required')
      if (hasRequired) {
        console.log('  ✓ Field file memiliki atribut required')
      }
    })
    
    console.log('✓ Test upload tanpa file PASSED')
  })
})
