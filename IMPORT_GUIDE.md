# Panduan Import Kode Wilayah Indonesia ke PostgreSQL

## 📋 Ringkasan
File `kodewilayah2023.sql` berisi 83,994 baris data kode pos Indonesia yang perlu diimport ke database PostgreSQL.

---

## 🚀 Metode 1: Import Langsung via psql (TERCEPAT)

### Langkah 1: Konversi File (Opsional tapi Disarankan)
```powershell
# Jalankan script konversi
python convert_to_postgres.py
```

### Langkah 2: Buat Database Baru
```powershell
# Login ke PostgreSQL
psql -U postgres

# Di dalam psql, buat database baru
CREATE DATABASE kodepos_indonesia;

# Keluar dari psql
\q
```

### Langkah 3: Import File SQL
```powershell
# Import file yang sudah dikonversi
psql -U postgres -d kodepos_indonesia -f kodewilayah2023_postgres.sql

# ATAU jika tidak dikonversi, coba langsung (mungkin ada error):
psql -U postgres -d kodepos_indonesia -f kodewilayah2023.sql
```

---

## 🖥️ Metode 2: Import via pgAdmin (GUI)

### Langkah 1: Buka pgAdmin
1. Buka aplikasi **pgAdmin 4**
2. Login dengan password PostgreSQL Anda

### Langkah 2: Buat Database Baru
1. Klik kanan pada **Databases** → **Create** → **Database**
2. Nama database: `kodepos_indonesia`
3. Klik **Save**

### Langkah 3: Buka Query Tool
1. Klik kanan pada database `kodepos_indonesia`
2. Pilih **Query Tool**

### Langkah 4: Load dan Execute File SQL
1. Di Query Tool, klik icon **Open File** (📁)
2. Pilih file `kodewilayah2023_postgres.sql` (atau `kodewilayah2023.sql`)
3. Klik tombol **Execute/Play** (▶️)
4. Tunggu proses selesai (mungkin butuh beberapa menit)

---

## 🔧 Metode 3: Import via Laravel Migration (Untuk Integrasi dengan Laravel)

### Langkah 1: Buat Migration
```powershell
php artisan make:migration create_kodewilayah2023_table
```

### Langkah 2: Edit Migration File
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kodewilayah2023', function (Blueprint $table) {
            $table->string('kodepos', 8)->nullable();
            $table->string('kelurahan', 80)->nullable();
            $table->string('kodewilayah', 15)->primary();
            $table->string('namakecamatan', 80)->nullable();
            $table->string('kodekabkota', 15)->nullable();
            $table->string('namakabkota', 80)->nullable();
            $table->string('namapropinsi', 80)->nullable();
        });

        // Import data dari file SQL
        $sqlFile = database_path('kodewilayah2023_postgres.sql');
        if (file_exists($sqlFile)) {
            DB::unprepared(file_get_contents($sqlFile));
        }
    }

    public function down()
    {
        Schema::dropIfExists('kodewilayah2023');
    }
};
```

### Langkah 3: Copy File SQL
```powershell
# Copy file SQL ke folder database
copy kodewilayah2023_postgres.sql database\kodewilayah2023_postgres.sql
```

### Langkah 4: Jalankan Migration
```powershell
php artisan migrate
```

---

## ✅ Verifikasi Import Berhasil

### Via psql:
```sql
-- Login ke database
psql -U postgres -d kodepos_indonesia

-- Cek jumlah data
SELECT COUNT(*) FROM kodewilayah2023;
-- Harusnya: 83994

-- Lihat sample data
SELECT * FROM kodewilayah2023 LIMIT 10;

-- Cari kode pos tertentu
SELECT * FROM kodewilayah2023 WHERE kodepos = '24442';
```

### Via pgAdmin:
1. Klik kanan pada tabel `kodewilayah2023`
2. Pilih **View/Edit Data** → **All Rows**
3. Cek data yang muncul

---

## 🐛 Troubleshooting

### Error: "syntax error at or near..."
**Solusi**: Gunakan file yang sudah dikonversi (`kodewilayah2023_postgres.sql`)

### Error: "relation already exists"
**Solusi**: Drop table terlebih dahulu
```sql
DROP TABLE IF EXISTS kodewilayah2023 CASCADE;
```

### Error: "permission denied"
**Solusi**: Pastikan user PostgreSQL memiliki hak akses
```sql
GRANT ALL PRIVILEGES ON DATABASE kodepos_indonesia TO postgres;
```

### Import Lambat
**Solusi**: Nonaktifkan index sementara (jika ada)
```sql
-- Sebelum import
ALTER TABLE kodewilayah2023 DISABLE TRIGGER ALL;

-- Setelah import
ALTER TABLE kodewilayah2023 ENABLE TRIGGER ALL;
```

---

## 📊 Struktur Tabel

| Kolom          | Tipe        | Keterangan                    |
|----------------|-------------|-------------------------------|
| kodepos        | VARCHAR(8)  | Kode pos                      |
| kelurahan      | VARCHAR(80) | Nama kelurahan/desa           |
| kodewilayah    | VARCHAR(15) | Kode wilayah (PRIMARY KEY)    |
| namakecamatan  | VARCHAR(80) | Nama kecamatan                |
| kodekabkota    | VARCHAR(15) | Kode kabupaten/kota           |
| namakabkota    | VARCHAR(80) | Nama kabupaten/kota           |
| namapropinsi   | VARCHAR(80) | Nama provinsi                 |

---

## 📝 Catatan Penting

1. **Backup**: Selalu backup database sebelum import data besar
2. **Encoding**: File menggunakan UTF-8 encoding
3. **Size**: File berukuran ~8.4 MB dengan 83,994 baris data
4. **Primary Key**: `kodewilayah` adalah primary key
5. **Koneksi Laravel**: Jangan lupa update `.env` untuk koneksi PostgreSQL

---

## 🔗 Koneksi Laravel ke PostgreSQL

Update file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=kodepos_indonesia
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

---

**Selamat mencoba! 🎉**
