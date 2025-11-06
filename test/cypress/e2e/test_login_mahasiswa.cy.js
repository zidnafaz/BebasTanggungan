describe('Test Login Mahasiswa', () => {
  beforeEach(() => {
    // Kunjungi halaman login sebelum setiap test
    cy.visit('/index.html')
  })

  it('Test 1: Login mahasiswa dengan credentials yang valid', () => {
    console.log('Test 1: Login mahasiswa dengan credentials yang valid')
    
    // Input username dan password
    cy.get('#username').type('20230002')
    cy.get('#password').type('20230002')
    cy.get('#loginButton').click()
    
    // Verifikasi login berhasil
    cy.get('.welcome-name', { timeout: 10000 })
      .should('be.visible')
      .invoke('text')
      .should('match', /Selamat Datang\s+Budi Santoso/)
    
    cy.get('.h3')
      .should('be.visible')
      .invoke('text')
      .should('match', /Dashboard Mahasiswa\s*-\s*Selamat Datang\s+Budi Santoso/)
    
    console.log('✓ Test login success PASSED')
  })

  it('Test 2: Login mahasiswa dengan password yang salah', () => {
    console.log('Test 2: Login mahasiswa dengan password yang salah')
    
    // Input username yang benar dan password yang salah
    cy.get('#username').type('20230002')
    cy.get('#password').type('wrongpassword')
    cy.get('#loginButton').click()
    
    cy.wait(2000)
    
    // Verifikasi masih di halaman login
    cy.url().should('match', /(login|index)/)
    
    console.log('✓ Test wrong password PASSED')
  })

  it('Test 3: Login mahasiswa dengan username yang salah', () => {
    console.log('Test 3: Login mahasiswa dengan username yang salah')
    
    // Input username yang salah dan password yang benar
    cy.get('#username').type('99999999')
    cy.get('#password').type('20230002')
    cy.get('#loginButton').click()
    
    cy.wait(2000)
    
    // Verifikasi masih di halaman login
    cy.url().should('match', /(login|index)/)
    
    console.log('✓ Test wrong username PASSED')
  })

  it('Test 4: Login mahasiswa dengan field kosong', () => {
    console.log('Test 4: Login mahasiswa dengan field kosong')
    
    // Klik login tanpa mengisi field
    cy.get('#loginButton').click()
    
    cy.wait(1000)
    
    // Verifikasi validasi HTML5 untuk field username
    cy.get('#username').should('have.attr', 'required')
    
    console.log('✓ Test empty fields PASSED')
  })

  it('Test 5: Login mahasiswa dengan password kosong', () => {
    console.log('Test 5: Login mahasiswa dengan password kosong')
    
    // Input hanya username tanpa password
    cy.get('#username').type('20230002')
    cy.get('#loginButton').click()
    
    cy.wait(1000)
    
    // Verifikasi validasi HTML5 untuk field password
    cy.get('#password').should('have.attr', 'required')
    
    console.log('✓ Test empty password PASSED')
  })
})
