@echo off
title TensiTrack Update Utility
color 0b

echo ========================================================
echo      TENSITRACK AUTO UPDATE & RESET TOOL
echo ========================================================
echo.

echo [1/3] Menarik update terbaru dari Git...
git pull
if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal melakukan git pull. Cek koneksi internet atau konflik file.
    pause
    exit /b
)

echo.
echo [2/3] Reset Database dan Seeding...
call php artisan migrate:fresh --seed
if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal melakukan migrasi database.
    pause
    exit /b
)

echo.
echo [3/3] Build Frontend Assets...
call npm run build
if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Gagal build frontend.
    pause
    exit /b
)

echo.
echo ========================================================
echo      UPDATE SELESAI! APLIKASI SIAP DIGUNAKAN.
echo ========================================================
echo.
pause
