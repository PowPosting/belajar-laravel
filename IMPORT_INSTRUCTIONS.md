# Import Data Kode Pos ke PostgreSQL

## Status Import
Proses import sedang menunggu password PostgreSQL Anda.

---

## 🚀 Cara Import (Pilih Salah Satu)

### **Opsi 1: Lanjutkan di Terminal (Tercepat)**
1. Lihat terminal yang sedang running
2. Ketik password PostgreSQL Anda
3. Tekan Enter
4. Tunggu proses selesai (~1-2 menit)

---

### **Opsi 2: Import via pgAdmin (Paling Mudah)**

#### Langkah-langkah:
1. **Buka pgAdmin 4**
2. **Login** dengan password PostgreSQL
3. **Pilih database `mysql_provinces`** di sidebar kiri
4. **Klik kanan** pada database → pilih **Query Tool**
5. **Klik icon Open File** (📁) di toolbar
6. **Pilih file**: `mysql_provinces.sql`
7. **Klik Execute** (▶️)
8. **Tunggu sampai selesai** - akan muncul pesan sukses

---

### **Opsi 3: Gunakan Script PowerShell**

Jalankan perintah ini di PowerShell (ganti `your_password` dengan password Anda):

```powershell
$env:PGPASSWORD="your_password"
psql -U postgres -d mysql_provinces -f "mysql_provinces.sql"
```

---

## 📊 Isi File SQL

File `mysql_provinces.sql` berisi:

### 1. Tabel `db_province_data`
- **Jumlah**: 34 provinsi
- **Kolom**: 
  - `province_name` - Nama provinsi (Indonesia)
  - `province_name_en` - Nama provinsi (English)
  - `province_code` - Kode provinsi (2 digit)

### 2. Tabel `db_postal_code_data`
- **Jumlah**: 81,328 data kode pos
- **Kolom**:
  - `id` - ID auto increment
  - `urban` - Kelurahan/Desa
  - `sub_district` - Kecamatan
  - `city` - Kabupaten/Kota
  - `province_code` - Kode provinsi
  - `postal_code` - Kode pos (5 digit)

---

## ✅ Verifikasi Setelah Import

Setelah import selesai, verifikasi dengan query ini:

```sql
-- Cek jumlah provinsi
SELECT COUNT(*) FROM db_province_data;
-- Harusnya: 34

-- Cek jumlah kode pos
SELECT COUNT(*) FROM db_postal_code_data;
-- Harusnya: 81328

-- Lihat sample data provinsi
SELECT * FROM db_province_data LIMIT 5;

-- Lihat sample data kode pos
SELECT * FROM db_postal_code_data LIMIT 10;

-- Cari kode pos Banda Aceh
SELECT * FROM db_postal_code_data 
WHERE city = 'BANDA ACEH' 
LIMIT 10;
```

---

## 🔧 Troubleshooting

### Error: "relation already exists"
```sql
-- Drop tabel terlebih dahulu
DROP TABLE IF EXISTS db_postal_code_data CASCADE;
DROP TABLE IF EXISTS db_province_data CASCADE;
```

### Error: "permission denied"
```sql
-- Grant privileges
GRANT ALL PRIVILEGES ON DATABASE mysql_provinces TO postgres;
```

---

## 📝 Catatan
- File size: ~6.2 MB
- Total records: 81,362 (34 provinsi + 81,328 kode pos)
- Encoding: UTF-8
- Database: PostgreSQL

Silakan pilih opsi yang paling nyaman untuk Anda!
