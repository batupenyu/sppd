@echo off
REM Start Laravel development server from workspace root
cd /d "%~dp0"
echo Starting Laravel development server...
php artisan serve
pause
