# Penjualan Kendaraan Restfull API


# Prasyarat
Sebelum menjalankan proyek ini, pastikan Anda telah menginstal beberapa komponen berikut:

- PHP 8
- Composer
- MongoDB 4.2 or lebih tinggi

## Instalasi
1. Clone repository ini:
    ```sh
    git clone https://github.com/rizqiaditia27/penjualan-kendaraanAPI.git
    ```
2. Buka direktori proyek:
    ```sh
    cd folder-proyek
    ```
3. Instal dependensi menggunakan Composer:
    ```sh
    composer install
    ```
4. Perbarui detail koneksi MongoDB di file .env:
     ```sh
    DB_CONNECTION=mongodb
    DB_HOST=127.0.0.1
    DB_PORT=27017
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
5. Generate kunci aplikasi:
    ```sh
    php artisan key:generate
    ```
6. Generate JWT Secret key:
     ```sh
    php artisan jwt:secret
    ```
7. Jalankan server:
     ```sh
    php artisan serve
    ```
## Fitur-Fitur

1. Login
     ```sh
    [POST] /api/v1/login/
    ```
    Body: email, password
    Response : data user, token JWT (berlaku 2 jam)
2. Register (tambah admin)
     ```sh
    [POST] /api/v1/register/
    ```
    Body: nama, email, password
3. LogOut 
     ```sh
    [POST] /api/v1/logout/
    ```
4. Tambah Kendaraan
     ```sh
    [POST] /api/v1/kendaraan/
    ```
    Body: tahun,warna,harga ,tipe ,mesin, suspensi (optional) , transmisi (optional), kapasitas_penumpang (optional, tipe_mobil(optional).
5. Lihat stok semua kendaraan
     ```sh
    [GET] /api/v1/kendaraan/
    ```
    Response : jumlah kendaraan, data kendaraan
6. Lihat stok sesuai tipe kendaraan (Motor, Mobil)
     ```sh
    [GET] /api/v1/kendaraan?tipe={tipe_kendaraan}
    ```
    contoh
     ```sh
    [GET] /api/v1/kendaraan?tipe=Motor
    ```
    Response : jumlah kendaraan, data kendaraan
7. Update data kendaraan
     ```sh
    [PUT] /api/v1/kendaraan/{id_kendaraan}
    ```
    Body: tahun,warna,harga ,tipe ,mesin, suspensi (optional) , transmisi (optional), kapasitas_penumpang (optional, tipe_mobil(optional).
8. Hapus data kendaraan
     ```sh
    [DELETE] /api/v1/kendaraan/{id_kendaraan}
    ```
9. Tambah penjualan
     ```sh
    [POST] /api/v1/penjualan/
    ```
    Body: kendaraan_id, total_transaksi, catatan
10. Laporan Penjualan seluruh kendaraan
     ```sh
    [GET] /api/v1/penjualan/
    ```
    Response : jumlah penjualan, data penjualan
11. Laporan Penjualan per kendaraan
     ```sh
    [GET] /api/v1/penjualan?id=id_kendaraan
    ```
    Response : jumlah penjualan, data penjualan
12. Update data penjualan
     ```sh
    [PUT] /api/v1/penjualan/{id_penjualan}
    ```
    Body: kendaraan_id, total_transaksi, catatan
13. Hapus data penjualan
     ```sh
    [DELETE] /api/v1/penjualan/{id_penjualan}
    ```