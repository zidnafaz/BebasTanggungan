describe('DEBUG: Test Verification DITOLAK Issue', () => {
  
  it('Debug - Verifikasi Dokumen DITOLAK dengan Logging Detail', () => {
    console.log('=== DEBUG: Verifikasi Dokumen DITOLAK ===\n')
    
    // 1. Login sebagai Admin LT6
    console.log('STEP 1: Login sebagai Admin LT6')
    cy.visit('/index.html')
    cy.get('#username').type('10230001')
    cy.get('#password').type('admin')
    cy.get('#loginButton').click()
    cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
    console.log('✓ Login berhasil\n')
    
    // 2. Navigasi ke Daftar Mahasiswa
    console.log('STEP 2: Navigasi ke Daftar Mahasiswa')
    cy.get('a[href="daftar_mahasiswa.php"]').first().click()
    cy.contains('h1', 'Verifikasi Berkas Mahasiswa', { timeout: 10000 }).should('be.visible')
    cy.wait(3000)
    console.log('✓ Halaman Daftar Mahasiswa terbuka\n')
    
    // 3. Klik Detail Mahasiswa
    console.log('STEP 3: Navigasi ke Detail Mahasiswa')
    cy.get('a[href*="detail_mahasiswa.php"]').first()
      .invoke('removeAttr', 'target')
      .click()
    cy.contains('h1', 'Detail Mahasiswa', { timeout: 10000 }).should('be.visible')
    cy.wait(3000)
    console.log('✓ Halaman Detail Mahasiswa terbuka\n')
    
    // 4. Cari dokumen dan buka modal verifikasi
    console.log('STEP 4: Mencari dokumen "Bebas Kompen"')
    const namaDokumen = 'Bebas Kompen'
    
    cy.contains('td', namaDokumen).parent('tr').within(() => {
      cy.root().scrollIntoView()
      cy.wait(1000)
      
      // Screenshot row dokumen
      cy.screenshot('01-dokumen-row')
      
      cy.get('button[data-toggle="modal"]').first().click()
    })
    console.log('✓ Tombol verifikasi diklik\n')
    
    // 5. Tunggu modal muncul
    console.log('STEP 5: Modal Verifikasi')
    cy.get('#verifikasiModal', { timeout: 10000 }).should('be.visible')
    cy.wait(2000)
    cy.screenshot('02-modal-opened')
    console.log('✓ Modal verifikasi terbuka\n')
    
    // 6. CHECK radio button DITOLAK dengan berbagai cara
    console.log('STEP 6: Pilih Status DITOLAK')
    
    // Cara 1: Check langsung
    cy.get('#ditolak').check({ force: true })
    cy.wait(1000)
    cy.screenshot('03-radio-ditolak-checked')
    
    // Verifikasi apakah ter-check
    cy.get('#ditolak').should('be.checked').then($radio => {
      console.log('✓ Radio DITOLAK ter-check:', $radio.is(':checked'))
    })
    
    // Verifikasi radio terverifikasi TIDAK ter-check
    cy.get('#terverifikasi').should('not.be.checked').then($radio => {
      console.log('✓ Radio TERVERIFIKASI tidak ter-check:', !$radio.is(':checked'))
    })
    
    // Log semua radio button
    cy.get('input[type="radio"][name*="status"]').each(($el, index) => {
      const id = $el.attr('id')
      const checked = $el.is(':checked')
      const value = $el.val()
      console.log(`  Radio ${index}: id="${id}", value="${value}", checked=${checked}`)
    })
    
    console.log()
    
    // 7. Isi keterangan
    console.log('STEP 7: Isi Keterangan')
    const keterangan = 'Dokumen DITOLAK - Format tidak sesuai'
    
    cy.get('#keterangan').should('be.enabled')
      .clear({ force: true })
      .type(keterangan, { force: true, delay: 50 })
    
    cy.wait(1000)
    cy.screenshot('04-keterangan-filled')
    
    // Verifikasi keterangan ter-input
    cy.get('#keterangan').should('have.value', keterangan).then($textarea => {
      console.log(`✓ Keterangan ter-input: "${$textarea.val()}"`)
    })
    
    console.log()
    
    // 8. Screenshot sebelum submit
    console.log('STEP 8: Sebelum Submit')
    cy.screenshot('05-before-submit')
    
    // Log semua nilai form
    console.log('Nilai Form di Modal:')
    
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
    
    // 9. Klik Simpan
    console.log('STEP 9: Klik Tombol Simpan')
    cy.get('#simpanVerifikasi').should('be.enabled').click({ force: true })
    console.log('✓ Tombol Simpan diklik')
    
    // Tunggu proses AJAX
    cy.wait(4000)
    cy.screenshot('06-after-submit')
    
    console.log()
    
    // 10. Tunggu dan cek modal status
    console.log('STEP 10: Modal Status')
    cy.get('#uploadModalStatus', { timeout: 10000 }).should('be.visible')
    cy.screenshot('07-modal-status')
    
    // Baca pesan status
    cy.get('#uploadMessage').invoke('text').then(text => {
      console.log(`✓ Pesan Status: "${text}"`)
    })
    
    // Tunggu sebelum close
    cy.wait(2000)
    
    // Close modal status
    cy.get('#uploadModalStatus button[data-dismiss="modal"]').first().click({ force: true })
    console.log('✓ Modal status ditutup')
    
    // Tunggu modal tertutup
    cy.get('#uploadModalStatus').should('not.be.visible')
    cy.wait(2000)
    
    cy.screenshot('08-modal-closed')
    
    console.log()
    console.log('=== DEBUG SELESAI ===')
    console.log('Silakan cek screenshots di: test/cypress/screenshots/')
  })
  
  it('Debug - Bandingkan dengan Verifikasi TERVERIFIKASI', () => {
    console.log('=== DEBUG: Verifikasi Dokumen TERVERIFIKASI (untuk perbandingan) ===\n')
    
    // 1. Login
    cy.visit('/index.html')
    cy.get('#username').type('10230001')
    cy.get('#password').type('admin')
    cy.get('#loginButton').click()
    cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
    
    // 2. Navigasi
    cy.get('a[href="daftar_mahasiswa.php"]').first().click()
    cy.contains('h1', 'Verifikasi Berkas Mahasiswa', { timeout: 10000 }).should('be.visible')
    cy.wait(3000)
    
    // 3. Detail Mahasiswa
    cy.get('a[href*="detail_mahasiswa.php"]').first()
      .invoke('removeAttr', 'target')
      .click()
    cy.contains('h1', 'Detail Mahasiswa', { timeout: 10000 }).should('be.visible')
    cy.wait(3000)
    
    // 4. Verifikasi dokumen TERVERIFIKASI
    const namaDokumen = 'Pernyataan Kebenaran Data'
    const keterangan = 'Dokumen TERVERIFIKASI - Lengkap dan sesuai'
    
    cy.contains('td', namaDokumen).parent('tr').within(() => {
      cy.root().scrollIntoView()
      cy.wait(1000)
      cy.screenshot('compare-01-dokumen-row')
      cy.get('button[data-toggle="modal"]').first().click()
    })
    
    // 5. Modal
    cy.get('#verifikasiModal', { timeout: 10000 }).should('be.visible')
    cy.wait(2000)
    cy.screenshot('compare-02-modal-opened')
    
    // 6. Pilih TERVERIFIKASI
    cy.get('#terverifikasi').check({ force: true })
    cy.wait(1000)
    cy.screenshot('compare-03-radio-terverifikasi-checked')
    
    cy.get('#terverifikasi').should('be.checked')
    
    // 7. Isi keterangan
    cy.get('#keterangan').should('be.enabled')
      .clear({ force: true })
      .type(keterangan, { force: true, delay: 50 })
    cy.wait(1000)
    cy.screenshot('compare-04-keterangan-filled')
    
    cy.get('#keterangan').should('have.value', keterangan)
    
    // 8. Submit
    cy.screenshot('compare-05-before-submit')
    cy.get('#simpanVerifikasi').should('be.enabled').click({ force: true })
    
    cy.wait(4000)
    cy.screenshot('compare-06-after-submit')
    
    // 9. Modal status
    cy.get('#uploadModalStatus', { timeout: 10000 }).should('be.visible')
    cy.screenshot('compare-07-modal-status')
    
    cy.get('#uploadMessage').invoke('text').then(text => {
      console.log(`Pesan TERVERIFIKASI: "${text}"`)
    })
    
    cy.wait(2000)
    cy.get('#uploadModalStatus button[data-dismiss="modal"]').first().click({ force: true })
    cy.get('#uploadModalStatus').should('not.be.visible')
    cy.wait(2000)
    
    cy.screenshot('compare-08-modal-closed')
    
    console.log('=== PERBANDINGAN SELESAI ===')
  })
})
