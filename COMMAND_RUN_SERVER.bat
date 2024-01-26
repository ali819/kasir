@echo off
setlocal enabledelayedexpansion

:: Dapatkan alamat IP dari mesin saat ini
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| find "IPv4"') do (
    set "ipAddress=%%a"
    set "ipAddress=!ipAddress:~1!"
)

:: Jalankan perintah php artisan serve
php artisan serve --host !ipAddress! --port 8888
