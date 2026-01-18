# Script PowerShell untuk Import SQL ke PostgreSQL
# Tanpa perlu input password manual

# Password PostgreSQL
$password = "password"

# Set environment variable untuk password
$env:PGPASSWORD = $password

Write-Host "🚀 Memulai import data ke database mysql_provinces..." -ForegroundColor Green
Write-Host ""

# Jalankan import
psql -U postgres -d mysql_provinces -f "mysql_provinces.sql"

# Cek hasil
if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "✅ Import berhasil!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Verifikasi data:" -ForegroundColor Yellow
    
    # Verifikasi jumlah data
    $env:PGPASSWORD = $password
    psql -U postgres -d mysql_provinces -c "SELECT COUNT(*) as total_provinsi FROM db_province_data;"
    psql -U postgres -d mysql_provinces -c "SELECT COUNT(*) as total_kodepos FROM db_postal_code_data;"
    
    Write-Host ""
    Write-Host "Sample data provinsi:" -ForegroundColor Yellow
    psql -U postgres -d mysql_provinces -c "SELECT * FROM db_province_data LIMIT 5;"
    
} else {
    Write-Host ""
    Write-Host "❌ Import gagal! Cek error di atas." -ForegroundColor Red
}

# Clear password dari environment
Remove-Item Env:\PGPASSWORD
