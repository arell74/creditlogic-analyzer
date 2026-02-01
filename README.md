# 🏦 Sistem Analisis Kredit - Rule-Based Decision System

Sistem analisis kredit berbasis logika proposisional dengan 3-tier decision untuk evaluasi kelayakan pengajuan kredit.

## 📋 Deskripsi

Aplikasi ini dibuat dengan tujuan untuk memenuhi tugas akhir mata kuliah **logika informatika**. mengimplementasikan sistem keputusan berbasis aturan (rule-based) menggunakan logika proposisional untuk menganalisis kelayakan kredit berdasarkan 3 kriteria utama:

1. **Penghasilan Bulanan** (P)
2. **Riwayat Tunggakan** (Q)  
3. **Status Pekerjaan** (R)

## 🎯 Logika Keputusan (3-Tier)

### Tier 1: SANGAT LAYAK (ACC) ✓
```
P ∧ Q ∧ R = TRUE
```
- Penghasilan > Rp 5.000.000 ✓
- Tidak ada tunggakan ✓
- Status kerja tetap ✓

### Tier 2: PERLU PENINJAUAN ⚠
```
P ∧ ¬(Q ∧ R) = TRUE
```
- Penghasilan > Rp 5.000.000 ✓
- TAPI ada tunggakan ATAU status kontrak

### Tier 3: PENGAJUAN DITOLAK ✗
```
¬P = TRUE
```
- Penghasilan ≤ Rp 5.000.000 (langsung ditolak)

## 📊 Tabel Kebenaran

| No | P (>5jt) | Q (No Debt) | R (Tetap) | Logika         | Status              |
|----|----------|-------------|-----------|----------------|---------------------|
| 1  | T        | T           | T         | P ∧ (Q ∧ R)    | SANGAT LAYAK (ACC)  |
| 2  | T        | T           | F         | P ∧ ¬(Q ∧ R)   | PERLU PENINJAUAN    |
| 3  | T        | F           | T         | P ∧ ¬(Q ∧ R)   | PERLU PENINJAUAN    |
| 4  | T        | F           | F         | P ∧ ¬(Q ∧ R)   | PERLU PENINJAUAN    |
| 5  | F        | T           | T         | ¬P             | PENGAJUAN DITOLAK   |
| 6  | F        | T           | F         | ¬P             | PENGAJUAN DITOLAK   |
| 7  | F        | F           | T         | ¬P             | PENGAJUAN DITOLAK   |
| 8  | F        | F           | F         | ¬P             | PENGAJUAN DITOLAK   |

## 🚀 Instalasi

### Prerequisites
- PHP >= 8.1
- Composer
- Laravel >= 10.x
- Node.js & NPM (untuk Vite)

### Langkah-langkah

1. Clone repository atau salin file-file yang diperlukan

2. Install dependencies:
```bash
composer install
npm install
```

3. Setup environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Compile assets:
```bash
npm run dev
# atau untuk production
npm run build
```

5. Jalankan server:
```bash
php artisan serve
```

6. Buka browser: `http://localhost:8000`

## 📁 Struktur File

```
app/
├── Http/
│   └── Controllers/
│       └── CreditController.php       # Controller utama
│
resources/
├── views/
│   └── credit/
│       └── show.blade.php             # View form & hasil
│
routes/
└── index.php                            # Route definitions
```

## 💻 Penggunaan

### 1. Input Data
Masukkan 3 parameter:
- **Penghasilan Bulanan**: Nominal dalam rupiah (contoh: 7500000)
- **Riwayat Tunggakan**: "TIDAK ADA" atau "ADA"
- **Status Kerja**: "TETAP" atau "KONTRAK"

### 2. Proses Analisis
Klik tombol "Jalankan Diagnosa ⚡" untuk memproses

### 3. Lihat Hasil
Sistem akan menampilkan:
- **Status Keputusan**: ACC / PENINJAUAN / DITOLAK
- **Deskripsi**: Penjelasan keputusan
- **Breakdown**: Detail evaluasi setiap kondisi
- **Formula Logika**: Representasi proposisional

### 4. Ulangi
Klik "↺ Ulangi Analisis" untuk input baru

## 🧪 Contoh Test Cases

### Test Case 1: ACC
```
Input:
- Penghasilan: Rp 7.500.000
- Tunggakan: Tidak ada
- Status: Tetap

Output: ✓ SANGAT LAYAK (ACC)
Logic: P ∧ Q ∧ R = TRUE
```

### Test Case 2: Peninjauan (Ada Tunggakan)
```
Input:
- Penghasilan: Rp 6.000.000
- Tunggakan: Ada
- Status: Tetap

Output: ⚠ PERLU PENINJAUAN
Logic: P ∧ ¬(Q ∧ R) = TRUE
```

### Test Case 3: Peninjauan (Status Kontrak)
```
Input:
- Penghasilan: Rp 8.000.000
- Tunggakan: Tidak ada
- Status: Kontrak

Output: ⚠ PERLU PENINJAUAN
Logic: P ∧ ¬(Q ∧ R) = TRUE
```

### Test Case 4: Ditolak
```
Input:
- Penghasilan: Rp 4.000.000
- Tunggakan: Tidak ada
- Status: Tetap

Output: ✗ PENGAJUAN DITOLAK
Logic: ¬P = TRUE
```

## 🔧 Konfigurasi

Untuk mengubah threshold penghasilan, edit file `CreditController.php`:

```php
// Line 34
$highIncome = $income > 5_000_000; // Ubah nilai 5_000_000
```

## 🎨 Fitur UI/UX

- ✅ Responsive design (mobile-friendly)
- ✅ Neobrutalism aesthetic
- ✅ Real-time client-side validation
- ✅ Loading state dengan animasi
- ✅ Breakdown keputusan yang detail
- ✅ Formula logika proposisional
- ✅ Smooth slide-in animation untuk hasil
- ✅ Accessible (screen reader friendly)

## 🧮 Pseudocode

```
ALGORITMA AnalisaKredit(penghasilan, tunggakan, statusKerja)

INPUT:
  penghasilan  : integer
  tunggakan    : boolean
  statusKerja  : boolean (true = tetap)

OUTPUT:
  status       : string

PROSES:
  IF penghasilan > 5000000 THEN
    IF tunggakan = false AND statusKerja = true THEN
      RETURN "SANGAT LAYAK (ACC)"
    ELSE
      RETURN "PERLU PENINJAUAN"
    END IF
  ELSE
    RETURN "PENGAJUAN DITOLAK"
  END IF
```

## 🤝 Kontribusi

Sistem ini dikembangkan sebagai proyek pembelajaran logika proposisional dalam konteks real-world decision system.

## 📄 Lisensi

Educational purpose - Logika Informatika

---

**Catatan**: Sistem ini adalah implementasi edukatif dan belum mencakup semua aspek analisis kredit di dunia nyata seperti credit scoring, analisis risiko lanjutan, dll.