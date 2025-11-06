describe('Test Verification Admin LT6', () => {
  
  // Helper function untuk login sebagai admin
  const loginAsAdmin = () => {
    cy.visit('/index.html')
    cy.get('#username').type('10230001')
    cy.get('#password').type('admin')
    cy.get('#loginButton').click()
    cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
  }
  
  // Helper function untuk navigasi ke daftar mahasiswa
  const navigateToDaftarMahasiswa = () => {
    cy.get('a[href="daftar_mahasiswa.php"]').first().click()
    cy.contains('h1', 'Verifikasi Berkas Mahasiswa', { timeout: 10000 }).should('be.visible')
    cy.wait(3000) // Tunggu tabel DataTables load
  }
  
  // Helper function untuk klik detail mahasiswa pertama
  const goToDetailMahasiswa = () => {
    cy.get('a[href*="detail_mahasiswa.php"]').first()
      .invoke('removeAttr', 'target')
      .click()
    cy.contains('h1', 'Detail Mahasiswa', { timeout: 10000 }).should('be.visible')
    cy.wait(3000) // Tunggu tabel dokumen load
  }
  
  // Helper function untuk verifikasi dokumen
  const verifikasiDokumen = (namaDokumen, status, keterangan) => {
    console.log(`\nSTEP: Mencari dokumen "${namaDokumen}"`)
    
    // Cari row dokumen berdasarkan nama
    cy.contains('td', namaDokumen).parent('tr').within(() => {
      cy.root().scrollIntoView()
      cy.wait(1000)
      cy.get('button[data-toggle="modal"]').first().click()
    })
    console.log('✓ Tombol verifikasi diklik\n')
    
    // Tunggu modal muncul
    console.log('STEP: Modal Verifikasi')
    cy.get('#verifikasiModal', { timeout: 10000 }).should('be.visible')
    cy.wait(2000)
    console.log('✓ Modal verifikasi terbuka\n')
    
    // Pilih status verifikasi
    console.log(`STEP: Pilih Status ${status.toUpperCase()}`)
    if (status === 'terverifikasi') {
      cy.get('#terverifikasi').check({ force: true })
      cy.wait(1000)
      cy.get('#terverifikasi').should('be.checked').then($radio => {
        console.log('✓ Radio TERVERIFIKASI ter-check:', $radio.is(':checked'))
      })
    } else if (status === 'ditolak') {
      cy.get('#ditolak').check({ force: true })
      cy.wait(1000)
      cy.get('#ditolak').should('be.checked').then($radio => {
        console.log('✓ Radio DITOLAK ter-check:', $radio.is(':checked'))
      })
    }
    console.log()
    
    // Isi keterangan
    console.log('STEP: Isi Keterangan')
    cy.get('#keterangan').should('be.enabled')
      .clear({ force: true })
      .type(keterangan, { force: true, delay: 50 })
    
    cy.wait(1000)
    
    cy.get('#keterangan').should('have.value', keterangan).then($textarea => {
      console.log(`✓ Keterangan ter-input: "${$textarea.val()}"`)
    })
    console.log()
    
    // Log nilai form
    console.log('STEP: Nilai Form di Modal')
    
    cy.get('input[type="radio"]:checked').then($checked => {
      console.log(`  ✓ Radio checked: id="${$checked.attr('id')}", value="${$checked.val()}"`)
    })
    
    cy.get('#keterangan').invoke('val').then(val => {
      console.log(`  ✓ Keterangan: "${val}"`)
    })
    
    cy.get('#formNim').invoke('val').then(val => {
      console.log(`  ✓ NIM: "${val}"`)
    })
    
    cy.get('#jenis_berkas').invoke('val').then(val => {
      console.log(`  ✓ Jenis Berkas: "${val}"`)
    })
    console.log()
    
    // Klik Simpan
    console.log('STEP: Klik Tombol Simpan')
    cy.get('#simpanVerifikasi').should('be.enabled').click({ force: true })
    console.log('✓ Tombol Simpan diklik')
    
    // Tunggu proses AJAX/Submit
    cy.wait(4000)
    console.log()
    
    // Modal status
    console.log('STEP: Modal Status')
    cy.get('#uploadModalStatus', { timeout: 10000 }).should('be.visible')
    
    cy.get('#uploadMessage').invoke('text').then(text => {
      console.log(`✓ Pesan Status: "${text}"`)
    })
    
    cy.wait(2000)
    
    // Close modal status
    cy.get('#uploadModalStatus button[data-dismiss="modal"]').first().click({ force: true })
    console.log('✓ Modal status ditutup')
    
    cy.get('#uploadModalStatus').should('not.be.visible')
    cy.wait(2000)
    
    console.log(`✓ Verifikasi dokumen '${namaDokumen}' selesai\n`)
  }
  
  it('Test 1: Verifikasi Dokumen - TERVERIFIKASI (Accepted)', () => {
    console.log('Test 1: Verifikasi Dokumen Kebenaran Data - TERVERIFIKASI')
    
    // 1. Login sebagai Admin LT6
    console.log('  - Login sebagai Admin LT6...')
    loginAsAdmin()
    console.log('  ✓ Login berhasil')
    
    // 2. Navigasi ke Daftar Mahasiswa
    console.log('  - Navigasi ke Daftar Mahasiswa...')
    navigateToDaftarMahasiswa()
    console.log('  ✓ Halaman Daftar Mahasiswa terbuka')
    
    // 3. Klik Detail Mahasiswa
    console.log('  - Navigasi ke Detail Mahasiswa...')
    goToDetailMahasiswa()
    console.log('  ✓ Halaman Detail Mahasiswa terbuka')
    
    // 4. Verifikasi Dokumen Kebenaran Data - DITERIMA
    console.log('\n  === Verifikasi Dokumen Kebenaran Data (TERVERIFIKASI) ===')
    verifikasiDokumen(
      'Pernyataan Kebenaran Data',
      'terverifikasi',
      'Dokumen INI lengkap dan sesuai persyaratan'
    )
    
    console.log('✓ Test verifikasi dokumen TERVERIFIKASI PASSED')
  })
  
  it('Test 2: Verifikasi Dokumen - DITOLAK (Decline)', () => {
    console.log('Test 2: Verifikasi Dokumen Bebas Kompen - DITOLAK')
    
    // 1. Login sebagai Admin LT6
    console.log('  - Login sebagai Admin LT6...')
    loginAsAdmin()
    console.log('  ✓ Login berhasil')
    
    // 2. Navigasi ke Daftar Mahasiswa
    console.log('  - Navigasi ke Daftar Mahasiswa...')
    navigateToDaftarMahasiswa()
    console.log('  ✓ Halaman Daftar Mahasiswa terbuka')
    
    // 3. Klik Detail Mahasiswa
    console.log('  - Navigasi ke Detail Mahasiswa...')
    goToDetailMahasiswa()
    console.log('  ✓ Halaman Detail Mahasiswa terbuka')
    
    // 4. Verifikasi Dokumen Bebas Kompen - DITOLAK
    console.log('\n  === Verifikasi Dokumen Bebas Kompen (DITOLAK) ===')
    verifikasiDokumen(
      'Bebas Kompen',
      'ditolak',
      'Dokumen INI tidak sesuai format'
    )
    
    console.log('✓ Test verifikasi dokumen DITOLAK PASSED')
  })
  
  it('Test 3: Verifikasi Multiple Dokumen', () => {
    console.log('Test 3: Verifikasi Multiple Dokumen - TERVERIFIKASI & DITOLAK')
    
    // 1. Login sebagai Admin LT6
    console.log('  - Login sebagai Admin LT6...')
    loginAsAdmin()
    console.log('  ✓ Login berhasil')
    
    // 2. Navigasi ke Daftar Mahasiswa
    console.log('  - Navigasi ke Daftar Mahasiswa...')
    navigateToDaftarMahasiswa()
    console.log('  ✓ Halaman Daftar Mahasiswa terbuka')
    
    // 3. Klik Detail Mahasiswa
    console.log('  - Navigasi ke Detail Mahasiswa...')
    goToDetailMahasiswa()
    console.log('  ✓ Halaman Detail Mahasiswa terbuka')
    
    // 4. Verifikasi Dokumen Kebenaran Data - TERVERIFIKASI
    console.log('\n  === Verifikasi Dokumen Kebenaran Data (TERVERIFIKASI) ===')
    verifikasiDokumen(
      'Pernyataan Kebenaran Data',
      'terverifikasi',
      'Dokumen lengkap dan sesuai persyaratan'
    )
    
    // 5. Verifikasi Dokumen Bebas Kompen - DITOLAK
    console.log('\n  === Verifikasi Dokumen Bebas Kompen (DITOLAK) ===')
    verifikasiDokumen(
      'Bebas Kompen',
      'ditolak',
      'Dokumen tidak sesuai format'
    )
    
    console.log('✓ Test verifikasi multiple dokumen PASSED')
  })
})
