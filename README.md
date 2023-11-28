# FastPrint Test
Kedua backend (codeigniter 3 & django) berjalan dengan metode REST yang sama (POST, PUT, GET, DELETE)

Frontend dengan Vue dapat menggunakan yang manapun dan termasuk pada root kedua backend (Django masih memiliki masalah pada aset gambar public, tapi berfungsi)

## Run
```
cd codeigniter
php -S 127.0.0.1:8000

cd pythondjango
python manage.py runserver

cd vue
npm run dev
```

## Database Design (fastprint_ci3.sql)
Data di download dan disimpan pada file json untuk diproses melalui script datamigrate.py, digunakan untuk reset database dan seeding

### Produk
| Field         | DataType                       |
| ------------- | ------------------------------ |
| id            | INT - primary - autoincrement  |
| nama          | TEXT                           |
| harga         | INT                            |
| kategori_id   | INT - foreign key              |
| status_id     | INT - foreign key              |


### Kategori
perubahan dilakukan untuk mempermudah dan menyederhanakan operasi data
| Field         | DataType                       |
| ------------- | ------------------------------ |
| id            | INT - primary - autoincrement  |
| nama          | VARCHAR(128)                   |

### Kategori
perubahan dilakukan untuk mempermudah dan menyederhanakan operasi data
| Field         | DataType                       |
| ------------- | ------------------------------ |
| id            | INT - primary - autoincrement  |
| nama          | VARCHAR(32)                    |

## Preview

Semua fungsi sudah sesuai dengan spesifikasi (create, read, update, dan delete)

### Produk
Pengaplikasian opsi untuk memilih diantara barang dijual, tidak dijual, dan semuanya
![Product page preview.](/report/product.png)

### Kategori
![Category page preview.](/report/category.png)

### Status
![Status page preview.](/report/status.png)
