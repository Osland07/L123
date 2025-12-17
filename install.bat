@echo off
echo ==========================================
echo      MEMULAI INSTALASI TENSITRACK
echo ==========================================

echo.
echo [1/6] Menginstall dependency PHP (Composer)...
call composer install

echo.
echo [2/6] Menginstall dependency JavaScript (NPM)...
call npm install

echo.
if not exist .env (
    echo [3/6] File .env tidak ditemukan. Menyalin dari .env.example...
    copy .env.example .env
    echo Membuat Application Key...
    call php artisan key:generate
) else (
    echo [3/6] File .env sudah ada. Melewati proses copy dan generate key.
)

echo.
echo [4/6] Menjalankan migrasi database...
call php artisan migrate --force

echo.
echo [5/6] Membuat symbolic link storage...
call php artisan storage:link

echo.
echo [6/6] Build aset frontend (Initial Build)...
call npm run build

echo.
echo ==========================================
echo           INSTALASI SELESAI!
echo ==========================================
echo Anda sekarang dapat menjalankan 'run.bat'.
pause