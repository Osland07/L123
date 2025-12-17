@echo off
echo ==========================================
echo      MENJALANKAN TENSITRACK
echo ==========================================

echo.
echo [1/2] Membangun aset frontend terbaru (npm run build)...
echo Mohon tunggu sebentar, sedang memproses aset...
call npm run build

echo.
echo [2/2] Menjalankan Laravel Server...
echo Akses aplikasi di: http://127.0.0.1:8000
echo Tekan Ctrl+C untuk mematikan server.
echo.
php artisan serve