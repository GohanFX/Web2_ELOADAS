# 🚀 Gyors kezdési útmutató

## Előfeltételek
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL/MariaDB

## 1. Projekt beállítása (5 perc)

```bash
# 1. Függőségek telepítése
composer install
npm install

# 2. Környezeti változók
cp .env.example .env
php artisan key:generate

# 3. Adatbázis beállítása (.env fájlban)
DB_DATABASE=formulaone
DB_USERNAME=root
DB_PASSWORD=your_password
```

## 2. Adatbázis inicializálás

```bash
# Táblák létrehozása
php artisan migrate

# Adatok betöltése (CSV fájlokból)
php artisan db:seed --class=DriverSeeder
php artisan db:seed --class=GPSeeder
php artisan db:seed --class=RaceSeeder

# Admin felhasználó létrehozása
php artisan db:seed --class=AdminUserSeeder
```

## 3. Alkalmazás indítása

Két terminál ablakban:

**Terminal 1** - Backend:
```bash
php artisan serve
```

**Terminal 2** - Frontend (fejlesztés):
```bash
npm run dev
```

Vagy produkciós build:
```bash
npm run build
php artisan serve
```

## 4. Bejelentkezés

Nyisd meg a böngészőben: **http://localhost:8000**

### Admin hozzáférés:
- Email: `admin@formula1.hu`
- Jelszó: `password`
- Elérhető funkciók: MINDEN

### Regisztrált felhasználó:
- Email: `user@formula1.hu`
- Jelszó: `password`
- Elérhető funkciók: Üzenetek megtekintése

### Látogató (nem bejelentkezett):
- Főoldal, Adatbázis, Diagram, Kapcsolat megtekintése

## 5. Főbb URL-ek

| Funkció | URL | Jogosultság |
|---------|-----|-------------|
| Főoldal | `/` | Mindenki |
| Adatbázis | `/database` | Mindenki |
| Kapcsolat | `/contact` | Mindenki |
| Diagram | `/chart` | Mindenki |
| Üzenetek | `/messages` | Registered |
| CRUD | `/drivers` | Admin |
| Admin | `/admin` | Admin |
| Bejelentkezés | `/auth/login` | Látogató |
| Regisztráció | `/auth/register` | Látogató |

## Hibaelhárítás

### Adatbázis hiba
```bash
# Ellenőrizd a kapcsolatot
php artisan migrate:status

# Friss kezdés
php artisan migrate:fresh
php artisan db:seed
```

### Frontend nem töltődik
```bash
# Töröld a cache-t
npm run build
php artisan optimize:clear
```

### Bejelentkezési hiba
```bash
# Ellenőrizd, hogy az AdminUserSeeder lefutott-e
php artisan tinker
>>> \App\Models\User::where('email', 'admin@formula1.hu')->first()
```

## Tesztelési checklist

- [ ] Főoldal betöltődik
- [ ] Regisztráció működik
- [ ] Bejelentkezés működik
- [ ] Adatbázis menü mutat adatokat
- [ ] Kapcsolat űrlap működik és validál
- [ ] Üzenetek menü csak bejelentkezve látható
- [ ] Diagram megjelenik Chart.js-sel
- [ ] Admin menü csak adminnak látható
- [ ] CRUD műveletek működnek (admin)
- [ ] Kijelentkezés működik

## Produkciós deployment

```bash
# 1. Optimalizálás
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Jogosultságok
chmod -R 755 storage bootstrap/cache
```

Sikerült! Most már minden funkció implementálva van! 🎉

