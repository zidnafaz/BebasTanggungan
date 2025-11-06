describe('Test Login Admin LT6', () => {
  beforeEach(() => {
    // Kunjungi halaman login sebelum setiap test
    cy.visit('/index.html')
  })

  it('Test 1: Login dengan credentials yang valid', () => {
    console.log('Test 1: Login dengan credentials yang valid')
    
    // Input username dan password
    cy.get('#username').type('10230001')
    cy.get('#password').type('admin')
    cy.get('#loginButton').click()
    
    // Verifikasi login berhasil
    cy.get('.welcome-name', { timeout: 10000 })
      .should('be.visible')
      .invoke('text')
      .should('match', /Selamat Datang\s+Ila/)
    
    cy.get('.h3')
      .should('be.visible')
      .invoke('text')
      .should('match', /Dashboard Admin Prodi\s*-\s*Selamat Datang\s+Ila/)
    
    console.log('✓ Test login success PASSED')
  })

  it('Test 2: Login dengan password yang salah', () => {
    console.log('Test 2: Login dengan password yang salah')
    
    // Input username yang benar dan password yang salah
    cy.get('#username').type('10230001')
    cy.get('#password').type('wrongpassword')
    cy.get('#loginButton').click()
    
    cy.wait(2000)
    
    // Verifikasi masih di halaman login
    cy.url().should('match', /(login|index)/)
    
    console.log('✓ Test wrong password PASSED')
  })

  it('Test 3: Login dengan username yang salah', () => {
    console.log('Test 3: Login dengan username yang salah')
    
    // Input username yang salah dan password yang benar
    cy.get('#username').type('99999999')
    cy.get('#password').type('admin')
    cy.get('#loginButton').click()
    
    cy.wait(2000)
    
    // Verifikasi masih di halaman login
    cy.url().should('match', /(login|index)/)
    
    console.log('✓ Test wrong username PASSED')
  })

  it('Test 4: Login dengan field kosong', () => {
    console.log('Test 4: Login dengan field kosong')
    
    // Klik login tanpa mengisi field
    cy.get('#loginButton').click()
    
    cy.wait(1000)
    
    // Verifikasi validasi HTML5
    cy.get('#username').should('have.attr', 'required')
    
    console.log('✓ Test empty fields PASSED')
  })
})
