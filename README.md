# MyFarm - Sistem Manajemen Peternakan

<p align="center">
    <img src="public/icon-512.svg" width="200" alt="MyFarm Logo">
</p>

Aplikasi web modern untuk manajemen peternakan terintegrasi dengan monitoring real-time untuk ayam, entok, dan ikan. Dibangun menggunakan Laravel 12 dan Filament v4.

## 🚀 Fitur Utama

### 📊 Dashboard & Analytics
- **Dashboard Interaktif** dengan widget statistik real-time
- **Total Hewan per Jenis** (Ayam, Entok, Ikan)
- **Grafik Produksi Telur** per minggu (Line Chart)
- **Grafik Konsumsi Pakan** per bulan (Bar Chart)
- **Jumlah Hewan Sakit** dalam 30 hari terakhir

### 🐔 Manajemen Data
- **Data Peternak**: Profil lengkap dengan kontak dan alamat
- **Data Hewan Ternak**: Type, jumlah, status kesehatan, dan cage assignment
- **Produksi Telur**: Tracking harian dengan catatan
- **Konsumsi Pakan**: Monitoring jenis, jumlah, dan satuan pakan
- **Catatan Kesehatan**: Vaksinasi, penyakit, dan pengobatan
- **Manajemen Kandang**: Kapasitas dan alokasi

### 📱 Mobile-Friendly & PWA
- **Responsive Design**: Optimized untuk desktop, tablet, dan mobile
- **Progressive Web App**: Install sebagai aplikasi standalone
- **Offline Support**: Basic caching untuk mode offline
- **Touch-Optimized**: Scrolling dan navigation yang smooth di mobile
- **Collapsible Sidebar**: Auto-collapse untuk screen kecil

### 📄 Laporan & Export
- **Laporan Produksi Telur**
  - Filter berdasarkan tanggal
  - Export ke PDF dan Excel
  - Ringkasan total produksi

- **Laporan Pakan**
  - Filter berdasarkan hewan dan tanggal
  - Export ke Excel
  - Analisis konsumsi per hewan

- **Laporan Kesehatan**
  - Filter berdasarkan tanggal
  - Export ke PDF
  - Tracking vaksinasi dan treatment

### 🔔 Sistem Notifikasi
- **Notifikasi Database** terintegrasi dengan Filament UI
- **Pengingat Vaksinasi H-1**: Otomatis mengirim notifikasi sehari sebelum jadwal vaksinasi
- **Peringatan Stok Pakan**: Alert otomatis jika konsumsi melebihi threshold (100kg/7 hari)
- **Real-time Polling**: Update notifikasi setiap 30 detik
- **Bell Icon**: Menampilkan badge unread notifications

### 👥 Role-Based Access Control
Menggunakan **Spatie Laravel Permission** dengan 3 role:
- **Admin**: Full access ke semua fitur
- **Peternak**: Akses terbatas ke data milik sendiri
- **Petugas**: Monitoring dan input data lapangan

### 🌙 Dark Mode
- Full dark mode support
- Auto-sync dengan system preferences
- Toggle manual available

## 🛠️ Tech Stack

- **Laravel 12.31.1** - PHP Framework
- **PHP 8.3.24**
- **Filament v4** - Admin Panel Framework
- **Tailwind CSS v4** - Styling
- **Chart.js** - Data Visualization
- **SQLite/MySQL** - Database (compatible dengan keduanya)
- **Pest v4** - Testing Framework
- **Laravel Pint** - Code Formatting

### Packages
- `filament/filament` - Admin panel builder
- `bezhansalleh/filament-shield` - Role & permission management
- `maatwebsite/excel` - Excel export functionality
- `barryvdh/laravel-dompdf` - PDF generation
- `spatie/laravel-permission` - Role-based access control

## 📦 Installation

### Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/SQLite

### Setup

1. Clone repository
```bash
git clone <repository-url>
cd myfarm
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database di `.env`
```env
DB_CONNECTION=sqlite
# atau untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=myfarm
# DB_USERNAME=root
# DB_PASSWORD=
```

5. Run migrations & seeders
```bash
php artisan migrate --seed
```

6. Install Filament Shield
```bash
php artisan shield:install
```

7. Build assets
```bash
npm run build
# atau untuk development:
npm run dev
```

8. Start server
```bash
php artisan serve
```

9. Setup scheduler (untuk notifikasi vaksinasi)
```bash
# Tambahkan ke crontab:
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## 👤 Default Login

```
Email: admin@example.com
Password: password
```

## 📱 PWA Installation

### Desktop (Chrome/Edge)
1. Buka aplikasi di browser
2. Klik icon install di address bar (sebelah bookmark)
3. Klik "Install"

### Mobile (Android/iOS)
1. Buka aplikasi di browser
2. Tap menu (3 dots)
3. Pilih "Add to Home Screen" atau "Install App"
4. Launch dari home screen untuk experience seperti native app

## 🔧 Development

### Run tests
```bash
php artisan test
```

### Format code
```bash
vendor/bin/pint
```

### Clear cache
```bash
php artisan optimize:clear
```

### Rebuild cache
```bash
php artisan optimize
```

## 📈 Scheduled Commands

### Vaccine Reminders
Command yang berjalan setiap hari jam 08:00 untuk mengirim notifikasi vaksinasi H-1:
```bash
php artisan reminders:vaccine
```

## 🎨 Customization

### Theme Colors
Edit `app/Providers/Filament/AdminPanelProvider.php`:
```php
->colors([
    'primary' => Color::Amber, // Ganti sesuai keinginan
])
```

### Mobile Optimization
Edit `resources/css/filament/admin/theme.css` untuk custom mobile styles.

### PWA Configuration
Edit `public/manifest.json` untuk custom app name, colors, dan icons.

## 📊 Database Schema

### Main Tables
- `users` - User accounts
- `farmers` - Data peternak
- `animals` - Data hewan ternak
- `cages` - Data kandang
- `egg_productions` - Produksi telur harian
- `feed_records` - Catatan pemberian pakan
- `health_records` - Catatan kesehatan & vaksinasi
- `notifications` - Database notifications

## 🔒 Security

- CSRF Protection
- Authentication & Authorization
- Role-based access control
- Input validation
- SQL Injection prevention (Eloquent ORM)
- XSS Protection

## 🌐 Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

This project is built on top of Laravel and follows the same license.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📧 Support

For support, email admin@myfarm.com or open an issue on GitHub.

---

**Built with ❤️ using Laravel & Filament**