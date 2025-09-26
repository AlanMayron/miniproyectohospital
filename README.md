# Miniproyectohospital — CRUD Salas de Atención (Laravel + PostgreSQL)

## Requisitos
- PHP ≥ 8.1 con `pdo_pgsql` y `pgsql`
- Composer
- PostgreSQL
- (Opcional) NodeJS si usas Breeze/Tailwind

## Instalación
```bash
cp .env.example .env
php artisan key:generate
# Configura tu .env con DB pgsql
php artisan migrate --seed
php artisan serve
