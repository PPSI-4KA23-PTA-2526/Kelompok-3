# Solusi Pemesanan Toko Plakat - Kelompok 3

## 📌 Latar Belakang
Toko plakat sering menghadapi kendala dalam proses pemesanan. Umumnya pelanggan hanya memesan melalui WhatsApp, sehingga:
- Pelanggan sulit mengetahui status/progress pesanan.
- Pemilik toko kesulitan melakukan tracking pesanan secara rapi.
- Risiko miskomunikasi antara pelanggan dan admin cukup tinggi.

## 🎯 Tujuan Solusi
Memberikan sistem sederhana namun efektif agar:
- Setiap pesanan memiliki **kode unik**.
- Pelanggan bisa melacak status pesanan menggunakan **kode pesanan**.
- Proses tracking dilakukan otomatis melalui **Google Spreadsheet dengan macros**.

## 🛠️ Solusi yang Ditawarkan
1. **Kode Pesanan Otomatis**  
   - Saat pelanggan melakukan pemesanan, sistem menghasilkan kode pesanan unik.
   - Kode ini disimpan di spreadsheet.

2. **Spreadsheet Tracking**  
   - Menggunakan Google Spreadsheet yang sudah dilengkapi macros.  
   - Pemilik toko dapat memperbarui status pesanan (misalnya: *Diterima, Diproses, Selesai, Dikirim*).

3. **Pelanggan Bisa Cek Status**  
   - Pelanggan hanya perlu memasukkan kode pesanan ke form/fitur pencarian.  
   - Spreadsheet akan menampilkan status terbaru.

```
## 📂 Struktur Repo
/kelompok3-branch
│
├── docs/                         # Dokumentasi & panduan penggunaan
├── src/                          # Script macros untuk Google Spreadsheet
├── assets/                       # Gambar ilustrasi / flow chart
└── README-kelompok3.md           # Dokumentasi utama
```


## 🚀 Cara Menggunakan
1. Clone repo ini:
   git clone -b kelompok3-branch <url-repo>
2. Buka file Google Spreadsheet yang sudah terhubung.
3. Import macros dari folder `/src`.
4. Setiap kali ada pesanan baru, input data ke spreadsheet → sistem otomatis membuat kode pesanan.
5. Bagikan kode tersebut ke pelanggan untuk pengecekan status.

## 📊 Alur Sistem

1. Pelanggan melakukan pemesanan.
2. Admin input data ke spreadsheet.
3. Sistem membuat kode pesanan otomatis.
4. Status pesanan diperbarui di spreadsheet.
5. Pelanggan melacak progress dengan kode pesanan.

## 👥 Tim Kelompok 3
| Nama | NPM |
|------|--------------|
| [Desta Aldi Fachri Wibowo](https://github.com/sickpeoples) | 10122355 |
| [Didik Wahyudi](https://github.com/zysyper) | 10122380 |
| [Maulidina Rahmawati](https://github.com/maaulidna) | 10122752 |
| [Ziko Ardilay](https://github.com/zikoard) | 11122512 |


✨ Dengan solusi ini, diharapkan toko plakat dapat meningkatkan transparansi, mengurangi miskomunikasi, dan membuat pelanggan lebih puas.
