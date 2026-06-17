# Implementation of Long Short Term Memory Model for Multi-Step Oil Sales Forecasting

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Python](https://img.shields.io/badge/Python-3.8+-3776ab?logo=python&logoColor=white)](https://www.python.org)

Sistem peramalan penjualan multi-step berbasis **LSTM (Long Short-Term Memory)** untuk memprediksi penjualan minyak **6 bulan ke depan**. Aplikasi ini menggabungkan backend Django Flask untuk model machine learning dan frontend Laravel dengan Blade templating untuk visualisasi hasil prediksi secara interaktif.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Sistem Requirements](#-sistem-requirements)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Struktur Proyek](#-struktur-proyek)
- [API Endpoints](#-api-endpoints)
- [Model Machine Learning](#-model-machine-learning)
- [Database](#-database)
- [Troubleshooting](#-troubleshooting)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

## 🎯 Fitur Utama

### 1. **Data Management**
- Upload data penjualan dalam format CSV/Excel
- Validasi dan parsing otomatis data historis
- Manajemen data penjualan dengan CRUD operations
- Import data menggunakan Maatwebsite Excel

### 2. **Preprocessing Data**
- **Min-Max Scaling**: Normalisasi data ke range [0, 1] untuk persiapan training
- **Data Cleaning**: Penanganan missing values dan outliers
- **Time Series Windowing**: Konversi sequential data menjadi supervised learning format
- **Train-Test Split**: Pemisahan otomatis data untuk training dan testing

### 3. **Model LSTM**
- Arsitektur multi-layer LSTM untuk time series forecasting
- Multi-step prediction (6 bulan ke depan)
- Hyperparameter optimization
- Model persistence dan loading
- Training dengan early stopping

### 4. **Evaluasi Model**
- Metrik akurasi: **MAE (Mean Absolute Error)**
- Metrik akurasi: **RMSE (Root Mean Squared Error)**
- Metrik akurasi: **MAPE (Mean Absolute Percentage Error)**
- Visualisasi perbandingan actual vs predicted values
- Report evaluasi detail dengan confidence intervals

### 5. **Visualisasi Web**
- Dashboard interaktif dengan Blade templates
- Grafik prediksi 6 bulan menggunakan Chart.js
- Grafik actual vs predicted untuk evaluasi model
- Tabel hasil prediksi dengan detail
- Export hasil prediksi ke format CSV
- Responsive design untuk mobile & desktop

### 6. **User Management**
- Sistem authentication dengan Breeze
- User registration dan login
- Profile management
- Password reset functionality

## 🔧 Teknologi yang Digunakan

### Backend - Laravel
- **Framework**: Laravel 12.0
- **Authentication**: Laravel Breeze
- **Database**: SQLite / MySQL (configurable)
- **ORM**: Eloquent
- **Excel**: Maatwebsite Excel 3.1
- **Testing**: Pest PHP

### Machine Learning - Python
- **Deep Learning**: TensorFlow/Keras
- **Data Processing**: Pandas, NumPy
- **Preprocessing**: Scikit-learn (MinMaxScaler)
- **API**: Flask
- **Visualization**: Matplotlib, Seaborn

### Frontend
- **Templating**: Laravel Blade
- **Styling**: Tailwind CSS
- **Charts**: Chart.js
- **JavaScript**: Alpine.js

## 💻 Sistem Requirements

### Minimum Requirements
- **OS**: Windows 10/11, macOS, Linux
- **PHP**: 8.2 atau lebih tinggi
- **Python**: 3.8 atau lebih tinggi
- **Node.js**: 18.x atau lebih tinggi
- **Composer**: 2.0 atau lebih tinggi
- **Disk Space**: Minimal 2GB

### Software yang Harus Diinstall
- Git
- PHP CLI dengan extensions: curl, json, mbstring, openssl, pdo_sqlite
- Python pip
- Node.js + npm

### Recommended
- PostgreSQL atau MySQL (untuk production)
- Docker (untuk development yang konsisten)
- Visual Studio Code

## 📦 Instalasi

### Langkah 1: Clone Repository

```bash
git clone https://github.com/zurimentaram/Implementation-of-Long-Short-Term-Memory-Model-for-Multi-Step-Oil-Sales-Forecasting.git
cd Implementation-of-Long-Short-Term-Memory-Model-for-Multi-Step-Oil-Sales-Forecasting
```

### Langkah 2: Setup Laravel Backend

#### 2.1 Masuk ke direktori Laravel
```bash
cd forecasting-sells
```

#### 2.2 Copy environment file
```bash
copy .env.example .env
```

#### 2.3 Install dependencies PHP
```bash
composer install
```

#### 2.4 Generate application key
```bash
php artisan key:generate
```

#### 2.5 Setup database
```bash
# Untuk SQLite (default)
touch database/database.sqlite

# Atau untuk MySQL, update .env terlebih dahulu:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=forecasting_db
# DB_USERNAME=root
# DB_PASSWORD=
```

#### 2.6 Run migrations
```bash
php artisan migrate
```

#### 2.7 Install Node dependencies
```bash
npm install
```

#### 2.8 Build frontend assets
```bash
npm run build
```

#### 2.9 (Opsional) Seed database dengan data dummy
```bash
php artisan db:seed
```

### Langkah 3: Setup Python Machine Learning

#### 3.1 Masuk ke direktori Python
```bash
cd ../python-ml
```

#### 3.2 Buat virtual environment (recommended)
```bash
# Windows
python -m venv venv
venv\Scripts\activate

# macOS / Linux
python3 -m venv venv
source venv/bin/activate
```

#### 3.3 Install Python dependencies
```bash
pip install -r requirements.txt
pip install tensorflow matplotlib seaborn
```

#### 3.4 Setup pre-trained models
```bash
# Model LSTM harus sudah ada di direktori models/
# Jika belum ada, jalankan training:
python train.py
```

### Langkah 4: Verifikasi Instalasi

```bash
# Terminal 1: Jalankan Laravel server
cd forecasting-sells
php artisan serve

# Terminal 2: Jalankan Python Flask API (di dalam python-ml)
cd python-ml
python app.py

# Terminal 3 (Optional): Jalankan Vite dev server untuk frontend updates
cd forecasting-sells
npm run dev
```

Akses aplikasi di: **http://localhost:8000**

## ⚙️ Konfigurasi

### Konfigurasi Laravel (.env)

```env
APP_NAME="Oil Sales Forecasting"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=sqlite
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=forecasting_db
# DB_USERNAME=root
# DB_PASSWORD=

# Mail Configuration (untuk email verification)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@forecasting.local

# Python ML API
PYTHON_API_URL=http://localhost:5000
```

### Konfigurasi Python Flask (python-ml/app.py)

```python
# Model hyperparameters
WINDOW_SIZE = 3              # Ukuran sliding window
N_STEPS = 6                  # Prediksi 6 bulan ke depan
MODEL_PATH = "models/model_lstm.h5"
PRED_PATH = "hasil_prediksi_multistep.csv"
```

### Konfigurasi Database

#### SQLite (Default - Development)
```bash
# Sudah dikonfigurasi, hanya perlu:
touch database/database.sqlite
php artisan migrate
```

#### MySQL (Production)

1. Buat database MySQL
```sql
CREATE DATABASE forecasting_db;
```

2. Update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forecasting_db
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

3. Run migrations
```bash
php artisan migrate
```

## 🚀 Penggunaan

### 1. Akses Aplikasi

Buka browser dan kunjungi:
```
http://localhost:8000
```

### 2. Register & Login

- Klik **Register** untuk membuat akun baru
- Isi email dan password
- Login dengan akun yang sudah dibuat

### 3. Upload Data Penjualan

1. Navigasi ke menu **Data Penjualan**
2. Klik **Upload Data**
3. Pilih file CSV/Excel dengan format:
   ```
   periode,jumlah_penjualan
   2020-01-31,1500000
   2020-02-29,1650000
   ...
   ```
4. Klik **Upload** untuk import data

### 4. Preprocessing Data

1. Masuk ke menu **Preprocessing**
2. Sistem otomatis akan:
   - Membaca data dari database
   - Melakukan normalisasi Min-Max Scaling
   - Menyiapkan data untuk training
3. Lihat preview data yang sudah dinormalisasi

### 5. Training Model LSTM

1. Navigasi ke **Dashboard** > **Train Model**
2. Klik **Mulai Training**
3. Sistem akan:
   - Load data yang sudah dipreprocess
   - Train model LSTM dengan data training
   - Simpan model terlatih
4. Tunggu hingga proses selesai (2-5 menit tergantung data)

### 6. Generate Prediksi 6 Bulan

1. Pergi ke menu **Prediksi**
2. Klik **Generate Forecast**
3. Sistem akan:
   - Load model LSTM terlatih
   - Melakukan multi-step prediction untuk 6 bulan ke depan
   - Denormalisasi hasil prediksi
   - Simpan hasil prediksi ke database
4. Lihat hasil prediksi dalam bentuk tabel dan grafik

### 7. Evaluasi Model

1. Navigasi ke menu **Evaluasi**
2. Sistem akan menampilkan:
   - **MAE**: Mean Absolute Error
   - **RMSE**: Root Mean Squared Error
   - **MAPE**: Mean Absolute Percentage Error
   - Grafik perbandingan **Actual vs Predicted**
   - Akurasi model dalam persentase
3. Export hasil evaluasi ke CSV

### 8. Visualisasi Dashboard

Dashboard menampilkan:
- Grafik trend penjualan historis
- Grafik prediksi 6 bulan ke depan
- Grafik actual vs predicted values
- Statistik model (MAE, RMSE, MAPE)
- Export data prediksi ke CSV

### Command Line Usage

#### Training Model
```bash
cd python-ml
python train.py
```

#### Generate Prediksi
```bash
python predict.py
```

#### Evaluasi Model
```bash
python evaluate.py
```

#### Visualisasi Grafik
```bash
python plot_forecast.py
python plot_actual_vs_predict.py
```

## 📁 Struktur Proyek

```
implementation-lstm-forecasting/
├── forecasting-sells/              # Laravel Backend
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── PenjualanController.php
│   │   │   │   ├── PrediksiController.php
│   │   │   │   ├── EvaluasiController.php
│   │   │   │   └── ProfileController.php
│   │   │   └── Requests/
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   └── Penjualan.php
│   │   ├── Imports/
│   │   │   └── PenjualanImport.php
│   │   └── Providers/
│   ├── resources/
│   │   ├── views/
│   │   │   ├── layouts/
│   │   │   │   ├── app.blade.php
│   │   │   │   ├── dashboard.blade.php
│   │   │   │   └── guest.blade.php
│   │   │   ├── profile/
│   │   │   │   ├── dashboard.blade.php
│   │   │   │   ├── prediksi.blade.php
│   │   │   │   ├── evaluasi.blade.php
│   │   │   │   └── partials/
│   │   │   ├── penjualan/
│   │   │   │   ├── index.blade.php
│   │   │   │   ├── create.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   ├── auth/
│   │   │   └── components/
│   │   └── css/
│   │       └── app.css
│   ├── database/
│   │   ├── migrations/
│   │   │   └── 2026_04_16_200638_create_penjualan_table.php
│   │   ├── seeders/
│   │   └── database.sqlite
│   ├── routes/
│   │   ├── web.php
│   │   ├── api.php
│   │   └── auth.php
│   ├── config/
│   ├── .env.example
│   ├── composer.json
│   ├── package.json
│   └── artisan
│
├── python-ml/                      # Python ML Backend
│   ├── app.py                      # Flask API Server
│   ├── train.py                    # Training LSTM Model
│   ├── predict.py                  # Generate Predictions
│   ├── evaluate.py                 # Model Evaluation
│   ├── preprocessing.py            # Data Preprocessing
│   ├── plot_forecast.py            # Visualization: Forecast
│   ├── plot_actual_vs_predict.py   # Visualization: Actual vs Predict
│   ├── models/
│   │   └── model_lstm.h5           # Pre-trained LSTM Model
│   ├── data/
│   │   ├── penjualan_data.csv      # Raw data
│   │   ├── normalized_data.csv     # Preprocessed data
│   │   └── hasil_prediksi_multistep.csv
│   ├── requirements.txt
│   ├── venv/                       # Virtual Environment
│   └── results/
│       ├── evaluation_report.txt
│       ├── forecast_plot.png
│       └── actual_vs_predict.png
│
└── README.md
```

## 🔌 API Endpoints

### Python Flask API (http://localhost:5000)

#### 1. Generate Multi-Step Forecast
```http
POST /api/forecast
Content-Type: application/json

{
  "data": "CSV string dengan kolom periode dan jumlah_penjualan"
}

Response:
{
  "forecast": [1700000, 1750000, 1800000, 1850000, 1900000, 1950000],
  "success": true
}
```

#### 2. Evaluate Model
```http
POST /api/evaluate
Content-Type: application/json

{
  "data": "CSV string dengan actual values"
}

Response:
{
  "mae": 45000,
  "rmse": 52000,
  "mape": 3.2,
  "accuracy": 96.8,
  "success": true
}
```

#### 3. Get Forecast Results
```http
GET /api/forecast-results

Response:
{
  "results": [
    {
      "periode": "2026-07-31",
      "prediksi": 1700000,
      "confidence": 95.2
    },
    ...
  ],
  "success": true
}
```

### Laravel API Endpoints

#### Penjualan Data
- `GET /api/penjualan` - List semua data penjualan
- `POST /api/penjualan` - Tambah data penjualan
- `GET /api/penjualan/{id}` - Detail data penjualan
- `PUT /api/penjualan/{id}` - Update data penjualan
- `DELETE /api/penjualan/{id}` - Hapus data penjualan

#### Dashboard
- `GET /dashboard` - Dashboard utama
- `GET /prediksi` - Halaman prediksi
- `GET /evaluasi` - Halaman evaluasi

## 🧠 Model Machine Learning

### Arsitektur LSTM

```
Input (window_size=3)
    ↓
LSTM Layer 1 (128 units, return_sequences=True)
    ↓
Dropout (0.2)
    ↓
LSTM Layer 2 (64 units, return_sequences=False)
    ↓
Dropout (0.2)
    ↓
Dense Layer (32 units, activation='relu')
    ↓
Output Layer (n_steps=6 units, activation='linear')
```

### Hyperparameters

```python
# Training Configuration
BATCH_SIZE = 32
EPOCHS = 100
VALIDATION_SPLIT = 0.2
WINDOW_SIZE = 3              # Sliding window size
N_STEPS = 6                  # Forecast 6 months ahead
LEARNING_RATE = 0.001

# Scaling
MIN_MAX_RANGE = (0, 1)       # Min-Max Normalization range

# Early Stopping
EARLY_STOPPING_PATIENCE = 10
EARLY_STOPPING_MIN_DELTA = 0.001
```

### Preprocessing Pipeline

```
Raw Data (CSV)
    ↓
Data Cleaning (remove NaN, duplicates)
    ↓
Sorting by Date
    ↓
Min-Max Normalization (sklearn)
    ↓
Time Series Windowing (create_sequences)
    ↓
Train-Test Split (80:20)
    ↓
Ready for Training
```

### Training Script (python-ml/train.py)

```bash
python train.py
```

Output:
- Model terlatih disimpan di `models/model_lstm.h5`
- Training history disimpan di `results/training_history.json`
- Model summary di console

### Prediction Script (python-ml/predict.py)

```bash
python predict.py --data penjualan_data.csv --output hasil_prediksi.csv
```

Output:
- Hasil prediksi 6 bulan ke depan
- File CSV dengan kolom: periode, prediksi, confidence_interval

### Evaluation Script (python-ml/evaluate.py)

```bash
python evaluate.py
```

Metrics:
- **MAE**: Rata-rata error absolut
- **RMSE**: Root mean squared error (lebih sensitif terhadap outlier)
- **MAPE**: Mean absolute percentage error (dalam %)

## 🗄️ Database

### Schema

#### Table: users
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### Table: penjualan
```sql
CREATE TABLE penjualan (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    periode DATE NOT NULL,
    jumlah_penjualan BIGINT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_periode_user (periode, user_id)
);
```

#### Table: prediksi
```sql
CREATE TABLE prediksi (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    periode DATE NOT NULL,
    nilai_prediksi DECIMAL(15, 2) NOT NULL,
    confidence_level DECIMAL(5, 2),
    training_date TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### Table: evaluasi_model
```sql
CREATE TABLE evaluasi_model (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    mae DECIMAL(15, 2) NOT NULL,
    rmse DECIMAL(15, 2) NOT NULL,
    mape DECIMAL(5, 2) NOT NULL,
    accuracy DECIMAL(5, 2) NOT NULL,
    evaluated_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Migrasi Database

```bash
# Membuat migration baru
php artisan make:migration create_penjualan_table

# Menjalankan semua pending migrations
php artisan migrate

# Rollback migration terakhir
php artisan migrate:rollback

# Reset semua migrations
php artisan migrate:reset

# Refresh (rollback + migrate)
php artisan migrate:refresh

# Refresh + seed
php artisan migrate:refresh --seed
```

## 🔍 Troubleshooting

### Issue 1: PHP Version Mismatch
**Error**: `Your requirements could not be resolved to an installable set of packages.`

**Solusi**:
```bash
php --version  # Pastikan PHP 8.2+
composer install --ignore-platform-reqs
```

### Issue 2: Database Connection Error
**Error**: `SQLSTATE[HY000]: General error: unable to open database file`

**Solusi**:
```bash
# Pastikan database.sqlite ada
touch database/database.sqlite

# Set permission (Linux/macOS)
chmod 666 database/database.sqlite
chmod 755 database

# Run migration
php artisan migrate
```

### Issue 3: Python Dependency Error
**Error**: `ModuleNotFoundError: No module named 'tensorflow'`

**Solusi**:
```bash
# Aktifkan virtual environment
cd python-ml
source venv/bin/activate  # Linux/macOS
venv\Scripts\activate     # Windows

# Install requirements
pip install -r requirements.txt
pip install tensorflow --upgrade
```

### Issue 4: Port Already in Use
**Error**: `The port 8000 is already in use.`

**Solusi**:
```bash
# Laravel - Gunakan port berbeda
php artisan serve --port=8001

# Python - Gunakan port berbeda
# Edit python-ml/app.py:
# app.run(host='0.0.0.0', port=5001, debug=True)
```

### Issue 5: CORS Error
**Error**: `Access to XMLHttpRequest blocked by CORS policy`

**Solusi**: Update `config/cors.php` di Laravel atau tambahkan middleware CORS.

### Issue 6: Model LSTM Not Found
**Error**: `FileNotFoundError: models/model_lstm.h5 not found`

**Solusi**:
```bash
cd python-ml
python train.py  # Train model baru

# Atau copy dari backup jika ada
cp models/model_lstm_backup.h5 models/model_lstm.h5
```

### Issue 7: Import Excel File Error
**Error**: `InvalidArgumentException: File must be an instance of `SplFileInfo`.`

**Solusi**:
```bash
# Pastikan format file benar (CSV atau Excel)
# Update import controller untuk validasi file type
```

### Issue 8: Memory Limit Exceeded
**Error**: `Fatal error: Allowed memory size exhausted`

**Solusi**:
```bash
# Update php.ini
# memory_limit = 256M

# Atau jalankan dengan custom memory limit
php -d memory_limit=-1 artisan migrate

# Untuk Python
# python -c "import sys; sys.setrecursionlimit(10000)"
```

### Issue 9: Node Modules Installation Failed
**Error**: `npm ERR! code ERESOLVE`

**Solusi**:
```bash
npm install --legacy-peer-deps
# atau
npm install --force
```

### Issue 10: Flask API Connection Failed
**Error**: `ConnectionError: Failed to establish connection to Flask API`

**Solusi**:
```bash
# Pastikan Flask API berjalan
cd python-ml
python app.py

# Verifikasi URL di .env Laravel
# PYTHON_API_URL=http://localhost:5000

# Test connection
curl http://localhost:5000/health
```

## 📚 Dokumentasi Tambahan

### Menggunakan Docker (Optional)

```dockerfile
# Dockerfile untuk Laravel
FROM php:8.2-fpm
RUN apt-get update && apt-get install -y sqlite3
WORKDIR /app
COPY . .
RUN composer install
EXPOSE 8000
```

```dockerfile
# Dockerfile untuk Python ML
FROM python:3.9
WORKDIR /ml
COPY . .
RUN pip install -r requirements.txt
EXPOSE 5000
CMD ["python", "app.py"]
```

```bash
# Build dan run dengan Docker Compose
docker-compose up --build
```

### Environment Variables Reference

```env
# Application
APP_NAME=Oil Sales Forecasting
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_KEY=base64:xxxxx

# Database
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forecasting_db
DB_USERNAME=root
DB_PASSWORD=

# Mail
MAIL_MAILER=log
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=noreply@forecasting.local

# Python ML API
PYTHON_API_URL=http://localhost:5000

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=file

# Queue
QUEUE_CONNECTION=database
```

### Useful Artisan Commands

```bash
# Development
php artisan serve                    # Start local server
php artisan tinker                   # Interactive shell
php artisan test                     # Run tests with Pest

# Database
php artisan migrate                  # Run migrations
php artisan migrate:reset            # Reset database
php artisan db:seed                  # Run seeders
php artisan db:seed --class=PenjualanSeeder

# Cache & Config
php artisan cache:clear              # Clear cache
php artisan config:cache             # Cache config
php artisan route:list               # List routes

# IDE Helper (optional)
php artisan ide-helper:generate
```

## 🤝 Kontribusi

Kami menyambut kontribusi dari siapa saja! Berikut langkah-langkahnya:

1. Fork repository ini
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

### Development Guidelines

- Ikuti PSR-12 coding standards untuk PHP
- Gunakan PEP 8 untuk Python
- Tambahkan tests untuk fitur baru
- Update dokumentasi jika ada perubahan API
- Commit messages harus deskriptif dan dalam bahasa Inggris/Indonesia

## 📄 Lisensi

Project ini dilisensikan di bawah MIT License - lihat file [LICENSE](LICENSE) untuk detail.

## 👨‍💼 Author

**Implementasi Model LSTM untuk Peramalan Penjualan Minyak Multi-Step**

- Author: [Zurimen Taram]
- GitHub: [@zurimentaram](https://github.com/zurimentaram)
- Contact: [email@example.com]

## 📞 Support & Feedback

Untuk pertanyaan, bug reports, atau saran:

- 📧 Email: [support@forecasting.local]
- 🐛 Issues: [GitHub Issues](https://github.com/zurimentaram/Implementation-of-Long-Short-Term-Memory-Model-for-Multi-Step-Oil-Sales-Forecasting/issues)
- 💬 Discussions: [GitHub Discussions](https://github.com/zurimentaram/Implementation-of-Long-Short-Term-Memory-Model-for-Multi-Step-Oil-Sales-Forecasting/discussions)

---

**Last Updated**: 2026-06-17  
**Laravel Version**: 12.0  
**Python Version**: 3.8+  
**Status**: Active Development ✨
