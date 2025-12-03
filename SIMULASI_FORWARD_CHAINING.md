# Simulasi Logika Forward Chaining: Deteksi Risiko Hipertensi
### (Studi Kasus: Pengelompokan 20 Faktor Risiko)

Dokumen ini menjelaskan bagaimana sistem pakar menggunakan metode **Forward Chaining** (Alur Maju) bekerja. Sistem tidak hanya "menghitung jumlah" jawaban YA, tetapi "mempertimbangkan bobot kategori" dari jawaban tersebut untuk hasil yang lebih akurat.

---

## 1. Basis Pengetahuan (Knowledge Base)
Sistem memiliki daftar 20 faktor risiko yang dikelompokkan menjadi 4 kategori berdasarkan tingkat bahayanya.

### Kategori A: KONDISI MEDIS (Bobot: Berat/Kritis)
*Faktor ini adalah "lampu merah". Jika user memiliki salah satu saja, risikonya otomatis naik.*
1.  **(E01)** Tekanan Darah Pre-Hipertensi (120-139/80-89 mmHg).
2.  **(E02)** Riwayat Keluarga (Genetik).
3.  **(E03)** Obesitas (IMT ≥ 25).
4.  **(E12)** Diabetes / Gula Darah Tinggi.
5.  **(E13)** Kolesterol Tinggi.
6.  **(E14)** Masalah Ginjal (Batu ginjal/Infeksi berulang).
7.  **(E15)** Sleep Apnea (Mendengkur keras/Henti napas saat tidur).

### Kategori B: GAYA HIDUP (Bobot: Akumulatif)
*Kebiasaan buruk yang jika ditumpuk akan menjadi berbahaya.*
8.  **(E04)** Merokok / Vape.
9.  **(E05)** Konsumsi Alkohol.
10. **(E09)** Jarang Olahraga (Sedenter).
11. **(E10)** Sering Begadang / Tidur Buruk.
12. **(E16)** Perokok Pasif (Sering terpapar asap).

### Kategori C: POLA MAKAN (Bobot: Akumulatif)
*Apa yang masuk ke dalam tubuh mempengaruhi pembuluh darah.*
13. **(E06)** Minuman Berenergi (Stimulan Jantung).
14. **(E07)** Kafein Berlebih (Kopi/Teh Kental).
15. **(E08)** Makanan Asin / Tinggi Garam.
16. **(E17)** Jarang Makan Sayur & Buah (Kurang Kalium).
17. **(E18)** Sering Minum Manis (Gula Tinggi).

### Kategori D: PSIKOLOGIS & OBAT (Bobot: Pemicu)
18. **(E11)** Stres / Cemas Berlebih.
19. **(E19)** Mudah Marah / Tempramental.
20. **(E20)** Rutin Obat Nyeri / Steroid / Pil KB.

---

## 2. Mesin Inferensi (Inference Engine) - Aturan Main
Sistem memeriksa fakta yang dimasukkan user dan mencocokkannya dengan aturan berikut secara berurutan (Prioritas 1 dicek duluan).

| Prioritas | Kode Aturan | Logika (IF ... THEN ...) | Hasil Risiko | Penjelasan Logis |
| :--- | :--- | :--- | :--- | :--- |
| **1 (Top)** | **R-HIGH-1** | JIKA punya minimal **1 Faktor MEDIS** (Kat A) **DAN** Total Faktor **≥ 4** | **TINGGI (🔴)** | *User sudah punya penyakit bawaan ditambah gaya hidup buruk. Ini bom waktu.* |
| **2** | **R-HIGH-2** | JIKA Total Faktor **≥ 8** (Tanpa melihat kategori) | **TINGGI (🔴)** | *User mungkin sehat secara medis, tapi gaya hidupnya sangat hancur (banyak faktor menumpuk).* |
| **3** | **R-MED-1** | JIKA punya minimal **1 Faktor MEDIS** (Kat A) | **SEDANG (🟡)** | *User punya penyakit bawaan (misal Diabetes), tapi gaya hidupnya bersih. Tetap harus waspada (tidak bisa Rendah).* |
| **4** | **R-MED-2** | JIKA Total Faktor antara **4 s.d. 7** | **SEDANG (🟡)** | *Tidak ada penyakit bawaan, tapi gaya hidup mulai "kuning" (warning).* |
| **5 (Last)** | **R-LOW** | JIKA Total Faktor **< 4** | **RENDAH (🟢)** | *Gaya hidup relatif sehat dan tidak ada keluhan medis.* |

---

## 3. Simulasi Kasus (Contoh Nyata)

Berikut adalah simulasi bagaimana sistem menilai 3 mahasiswa berbeda.

### Kasus A: "Si Anak Kost Hobi Begadang" (Budi, 21 Th)
**Fakta (Jawaban User):**
1.  Suka Begadang (E10) - YA
2.  Merokok (E04) - YA
3.  Suka Kopi Kental (E07) - YA
4.  Jarang Olahraga (E09) - YA
5.  Suka Makan Mie Instan/Asin (E08) - YA

**Analisa Sistem:**
*   **Total Faktor:** 5
*   **Faktor Medis (Kategori A):** TIDAK ADA.
*   **Proses Pengecekan Aturan:**
    *   Cek R-HIGH-1 (Ada Medis + Total ≥4?): ❌ Gagal (Tidak ada medis).
    *   Cek R-HIGH-2 (Total ≥ 8?): ❌ Gagal (Total cuma 5).
    *   Cek R-MED-1 (Ada Medis?): ❌ Gagal.
    *   Cek R-MED-2 (Total 4-7?): ✅ **COCOK!**

👉 **HASIL AKHIR: RISIKO SEDANG (🟡)**
*Saran: Budi belum sakit, tapi kebiasaannya harus dikurangi sebelum jadi penyakit.*

---

### Kasus B: "Si Sehat Tapi Punya Keturunan" (Siti, 20 Th)
**Fakta (Jawaban User):**
1.  Ayah punya Hipertensi (E02 - *Medis*) - YA
2.  Jarang Makan Sayur (E17) - YA
3.  Stres Skripsi (E11) - YA

**Analisa Sistem:**
*   **Total Faktor:** 3
*   **Faktor Medis (Kategori A):** ADA (E02 - Keturunan).
*   **Proses Pengecekan Aturan:**
    *   Cek R-HIGH-1 (Ada Medis + Total ≥4?): ❌ Gagal (Total cuma 3).
    *   Cek R-HIGH-2 (Total ≥ 8?): ❌ Gagal.
    *   Cek R-MED-1 (Ada Medis?): ✅ **COCOK!**

👉 **HASIL AKHIR: RISIKO SEDANG (🟡)**
*Saran: Meskipun total poin cuma 3 (sedikit), Siti masuk Risiko Sedang karena faktor Genetik (Medis) tidak bisa diabaikan. Dia harus lebih waspada dibanding orang tanpa genetik.*

---

### Kasus C: "Si Kelihatan Biasa Saja Padahal Bahaya" (Doni, 23 Th)
**Fakta (Jawaban User):**
1.  Gula Darah Agak Tinggi (E12 - *Medis*) - YA
2.  Perokok (E04) - YA
3.  Suka Makanan Asin (E08) - YA
4.  Jarang Olahraga (E09) - YA

**Analisa Sistem:**
*   **Total Faktor:** 4
*   **Faktor Medis (Kategori A):** ADA (E12 - Diabetes).
*   **Proses Pengecekan Aturan:**
    *   Cek R-HIGH-1 (Ada Medis + Total ≥4?): ✅ **COCOK!**
        *   Syarat 1: Ada Medis? YA (Diabetes).
        *   Syarat 2: Total ≥ 4? YA (Pas 4).

👉 **HASIL AKHIR: RISIKO TINGGI (🔴)**
*Saran: Doni sangat bahaya. Kombinasi Gula Darah Tinggi + Rokok + Garam adalah resep cepat menuju stroke/jantung, meskipun dia masih muda. Sistem langsung memberi peringatan keras.*

---

## 4. Struktur Database (Representasi Data)
Untuk menyimpan faktor risiko dan aturan, sistem menggunakan dua tabel utama: `risk_factors` dan `rules`.

### Tabel `risk_factors`
Tabel ini menyimpan detail setiap faktor risiko yang akan ditanyakan kepada pengguna.

| Kolom                 | Tipe Data      | Deskripsi                                                                 |
| :-------------------- | :------------- | :------------------------------------------------------------------------ |
| `id`                  | `BIGINT` (PK)  | ID unik untuk setiap faktor risiko.                                     |
| `code`                | `VARCHAR`      | Kode singkat faktor risiko (misal: E01, E02). Digunakan untuk identifikasi unik. |
| `name`                | `VARCHAR`      | Nama lengkap faktor risiko.                                               |
| `question_text`       | `TEXT`         | Teks pertanyaan yang ditampilkan ke pengguna.                              |
| `medical_explanation` | `TEXT`         | Penjelasan medis singkat tentang faktor risiko ini.                        |
| `category`            | `VARCHAR`      | **Kategori faktor risiko (misal: MEDIS, GAYA_HIDUP, POLA_MAKAN, PSIKOLOGIS).** |
| `created_at`          | `TIMESTAMP`    | Waktu pembuatan data.                                                     |
| `updated_at`          | `TIMESTAMP`    | Waktu terakhir data diperbarui.                                           |

### Tabel `rules`
Tabel ini mendefinisikan aturan-aturan inferensi yang digunakan sistem untuk menentukan tingkat risiko.

| Kolom                  | Tipe Data      | Deskripsi                                                                 |
| :--------------------- | :------------- | :------------------------------------------------------------------------ |
| `id`                   | `BIGINT` (PK)  | ID unik untuk setiap aturan.                                              |
| `code`                 | `VARCHAR`      | Kode singkat aturan (misal: R-HIGH-1, R-MED-1).                            |
| `risk_level_id`        | `BIGINT` (FK)  | Mengacu ke ID tingkat risiko (`risk_levels` tabel: Rendah, Sedang, Tinggi). |
| `required_factor_id`   | `BIGINT` (FK)  | ID faktor risiko yang **wajib** ada agar aturan ini berlaku (nullable).     |
| `min_other_factors`    | `INTEGER`      | Jumlah minimum faktor risiko lain yang harus ada.                         |
| `max_other_factors`    | `INTEGER`      | Jumlah maksimum faktor risiko lain yang harus ada.                        |
| `priority`             | `INTEGER`      | Urutan prioritas aturan. Semakin kecil angka, semakin tinggi prioritasnya. |
| `created_at`           | `TIMESTAMP`    | Waktu pembuatan data.                                                     |
| `updated_at`           | `TIMESTAMP`    | Waktu terakhir data diperbarui.                                           |

---

## 5. Visualisasi Pohon Keputusan (Detailed Decision Tree)

Diagram ini menggambarkan alur logika spesifik yang dijalankan sistem dari Input (Faktor Risiko) sampai Output (Hasil Diagnosa).

```mermaid
flowchart TD
    %% Nodes Definition
    START((Mulai Diagnosa))
    
    %% Input Phase
    INPUT[<b>Input User:</b><br/>Menjawab 20 Pertanyaan (YA / TIDAK)]
    
    %% Decision 1: Critical Factors Check
    DEC_CRITICAL{<b>Pengecekan 1: FAKTOR KRITIS (Medis)</b><br/>Apakah User menjawab <b>YA</b> pada <u>salah satu</u> faktor ini?<br/>-------------<br/><b>E01</b>: Tensi Pre-Hipertensi<br/><b>E02</b>: Ada Keturunan<br/><b>E03</b>: Obesitas (IMT > 25)<br/><b>E12</b>: Diabetes / Gula Tinggi<br/><b>E13</b>: Kolesterol Tinggi<br/><b>E14</b>: Masalah Ginjal<br/><b>E15</b>: Sleep Apnea}
    
    %% Decision 2: Total Count Check (Path A - Medis)
    DEC_TOTAL_A{<b>Pengecekan 2A: TOTAL SKOR</b><br/>Hitung Total Semua Jawaban YA<br/>(Termasuk Faktor Gaya Hidup)}
    
    %% Decision 3: Total Count Check (Path B - Lifestyle)
    DEC_TOTAL_B{<b>Pengecekan 2B: AKUMULASI GAYA HIDUP</b><br/>Hitung Total Semua Jawaban YA<br/>(Rokok, Garam, Malas, Stres, dll)}
    
    %% Outcomes / Terminals
    RES_HIGH_1[🔴 <b>RISIKO TINGGI</b><br/>(Komplikasi Medis + Gaya Hidup Buruk)<br/><i>Rule: R-HIGH-1</i>]
    RES_MED_1[🟡 <b>RISIKO SEDANG</b><br/>(Kondisi Medis Terpantau)<br/><i>Rule: R-MED-1</i>]
    
    RES_HIGH_2[🔴 <b>RISIKO TINGGI</b><br/>(Gaya Hidup Sangat Berbahaya)<br/><i>Rule: R-HIGH-2</i>]
    RES_MED_2[🟡 <b>RISIKO SEDANG</b><br/>(Warning Sign / Peringatan)<br/><i>Rule: R-MED-2</i>]
    RES_LOW[🟢 <b>RISIKO RENDAH</b><br/>(Aman / Sehat)<br/><i>Rule: R-LOW</i>]

    %% Flow Connections
    START --> INPUT
    INPUT --> DEC_CRITICAL
    
    %% JALUR A: Jika Ada Faktor Medis (BAHAYA)
    DEC_CRITICAL -- "<b>YA</b> (Ada salah satu E01,02,03,12,13,14,15)" --> DEC_TOTAL_A
    DEC_TOTAL_A -- "Total Jawaban YA <b>>= 4</b>" --> RES_HIGH_1
    DEC_TOTAL_A -- "Total Jawaban YA <b>< 4</b>" --> RES_MED_1
    
    %% JALUR B: Jika Tidak Ada Faktor Medis (Murni Gaya Hidup)
    DEC_CRITICAL -- "<b>TIDAK</b> (Semua Faktor Kritis = TIDAK)" --> DEC_TOTAL_B
    DEC_TOTAL_B -- "Total Jawaban YA <b>>= 8</b>" --> RES_HIGH_2
    DEC_TOTAL_B -- "Total Jawaban YA <b>4 s.d 7</b>" --> RES_MED_2
    DEC_TOTAL_B -- "Total Jawaban YA <b>0 s.d 3</b>" --> RES_LOW
```

### Tabel Kebenaran (Truth Table)
Untuk keperluan akademis, berikut adalah matriks logika yang merepresentasikan pohon keputusan di atas:

| Skenario | Ada Faktor Medis? (E01,02,03,12,13,14,15) | Total Skor (Jumlah YA) | Hasil Diagnosa | Kode Rule |
| :--- | :---: | :---: | :---: | :---: |
| **1** | **YA** | **≥ 4** | 🔴 **TINGGI** | R-HIGH-1 |
| **2** | **YA** | < 4 | 🟡 **SEDANG** | R-MED-1 |
| **3** | TIDAK | **≥ 8** | 🔴 **TINGGI** | R-HIGH-2 |
| **4** | TIDAK | 4 - 7 | 🟡 **SEDANG** | R-MED-2 |
| **5** | TIDAK | 0 - 3 | 🟢 **RENDAH** | R-LOW |

---

## Kesimpulan
Dengan metode ini, sistem menjadi **LEBIH CERDAS**.
*   Sistem lama hanya menghitung: Kasus B (Poin 3) mungkin dianggap Rendah, padahal dia punya bakat keturunan.
*   Sistem baru mengenali **"Kualitas"** jawaban, bukan hanya **"Kuantitas"**.
