// ***********************************************
// Custom commands for reusable test actions
// ***********************************************

/**
 * Login command untuk mahasiswa
 * @param {string} nim - NIM mahasiswa
 * @param {string} password - Password mahasiswa
 */
Cypress.Commands.add('loginMahasiswa', (nim, password) => {
  cy.visit('/index.html')
  cy.get('#username').type(nim)
  cy.get('#password').type(password)
  cy.get('#loginButton').click()
  cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
})

/**
 * Login command untuk admin
 * @param {string} username - Username admin
 * @param {string} password - Password admin
 */
Cypress.Commands.add('loginAdmin', (username, password) => {
  cy.visit('/index.html')
  cy.get('#username').type(username)
  cy.get('#password').type(password)
  cy.get('#loginButton').click()
  cy.get('.welcome-name', { timeout: 10000 }).should('be.visible')
})

/**
 * Logout command
 */
Cypress.Commands.add('logout', () => {
  cy.get('#logoutButton').click({ force: true })
})

/**
 * Navigate to specific menu
 * @param {string} menuId - ID dari menu yang akan diklik
 */
Cypress.Commands.add('navigateToMenu', (menuId) => {
  cy.get(`#${menuId}`).click()
  cy.wait(1000)
})

/**
 * Upload file to specific document type
 * @param {string} documentType - Tipe dokumen (contoh: 'penyerahan_kebenaran_data')
 * @param {string} filePath - Path file yang akan diupload
 */
Cypress.Commands.add('uploadDocument', (documentType, filePath) => {
  // Click upload button untuk document type tertentu
  cy.get(`button[onclick*="${documentType}"]`).scrollIntoView().click()
  
  // Tunggu modal muncul
  cy.get('#uploadModal', { timeout: 10000 }).should('be.visible')
  
  // Upload file
  cy.get('#file').selectFile(filePath, { force: true })
  
  // Submit
  cy.get('button[type="submit"]').contains('Upload').click()
})

/**
 * Verify document status
 * @param {string} documentName - Nama dokumen
 * @param {string} expectedStatus - Status yang diharapkan
 */
Cypress.Commands.add('verifyDocumentStatus', (documentName, expectedStatus) => {
  cy.contains('td', documentName)
    .parent('tr')
    .within(() => {
      cy.get('.badge')
        .invoke('text')
        .should('match', new RegExp(expectedStatus, 'i'))
    })
})

/**
 * Get document row by name
 * @param {string} documentName - Nama dokumen
 */
Cypress.Commands.add('getDocumentRow', (documentName) => {
  return cy.contains('td', documentName).parent('tr')
})

/**
 * Verifikasi dokumen oleh admin
 * @param {string} documentName - Nama dokumen yang akan diverifikasi
 * @param {string} status - Status verifikasi: 'terverifikasi' atau 'ditolak'
 * @param {string} keterangan - Keterangan verifikasi
 */
Cypress.Commands.add('verifikasiDokumen', (documentName, status, keterangan) => {
  // Cari row dokumen berdasarkan nama
  cy.contains('td', documentName).parent('tr').within(() => {
    // Scroll ke row dokumen
    cy.root().scrollIntoView()
    cy.wait(1000)
    
    // Klik tombol Verifikasi (gunakan first() untuk memastikan hanya 1 elemen)
    cy.get('button[data-toggle="modal"]').first().click()
  })
  
  // Tunggu modal verifikasi muncul
  cy.get('#verifikasiModal', { timeout: 10000 }).should('be.visible')
  cy.wait(2000) // Tunggu modal fully loaded
  
  // Pilih status verifikasi
  if (status === 'terverifikasi') {
    cy.get('#terverifikasi').check({ force: true })
    cy.wait(1500)
  } else if (status === 'ditolak') {
    cy.get('#ditolak').check({ force: true })
    cy.wait(1500)
  }
  
  // Isi keterangan
  cy.wait(1000)
  cy.get('#keterangan').should('be.enabled').clear().type(keterangan, { force: true })
  
  // PENTING: Tunggu event listener 'input' dari jQuery untuk mengaktifkan tombol Simpan
  // (Khususnya untuk status DITOLAK yang membutuhkan keterangan wajib diisi)
  cy.wait(1500)
  
  // Trigger event 'input' secara manual untuk memastikan validasi berjalan
  cy.get('#keterangan').trigger('input')
  cy.wait(500)
  
  // Klik tombol Simpan - PASTIKAN tombol enabled terlebih dahulu
  cy.wait(1500)
  cy.get('#simpanVerifikasi').should('not.be.disabled').and('be.enabled').click({ force: true })
  
  // Tunggu proses submit
  cy.wait(3000)
  
  // Tunggu modal status muncul
  cy.get('#uploadModalStatus', { timeout: 10000 }).should('be.visible')
  
  // Tunggu sebentar sebelum close modal
  cy.wait(2000)
  
  // Close modal status
  cy.get('#uploadModalStatus button[data-dismiss="modal"]').first().click({ force: true })
  
  // Tunggu modal status tertutup
  cy.get('#uploadModalStatus').should('not.be.visible')
  cy.wait(2000)
})

/**
 * Navigate to Daftar Mahasiswa page (Admin)
 */
Cypress.Commands.add('goToDaftarMahasiswa', () => {
  cy.get('a[href="daftar_mahasiswa.php"]').first().click()
  cy.contains('h1', 'Verifikasi Berkas Mahasiswa', { timeout: 10000 }).should('be.visible')
  cy.wait(3000) // Tunggu tabel DataTables load
})

/**
 * Navigate to Detail Mahasiswa page (Admin)
 * @param {number} index - Index mahasiswa (default: 0 untuk pertama)
 */
Cypress.Commands.add('goToDetailMahasiswa', (index = 0) => {
  cy.get('a[href*="detail_mahasiswa.php"]').eq(index)
    .invoke('removeAttr', 'target')
    .click()
  cy.contains('h1', 'Detail Mahasiswa', { timeout: 10000 }).should('be.visible')
  cy.wait(3000) // Tunggu tabel dokumen load
})

