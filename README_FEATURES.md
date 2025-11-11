# Formula 1 Adatbázis - Laravel + Inertia + React + shadcn/ui

Ez egy teljes körű webalkalmazás a Formula 1 világbajnokság adatainak kezelésére és megjelenítésére.

## Funkciók

### ✅ 1. Autentikáció (3 pont)
- **Regisztráció**: Új felhasználók létrehozása
- **Bejelentkezés**: Email és jelszó alapú hitelesítés
- **Kijelentkezés**: Biztonságos kilépés
- **Szerepkörök**:
  - `visitor` - Látogató (nem bejelentkezett)
  - `registered` - Regisztrált felhasználó (hozzáfér az Üzenetek menühöz)
  - `admin` - Adminisztrátor (hozzáfér az Admin menühöz és CRUD funkciókhoz)

### ✅ 2. Főoldal menü (2 pont)
- Látványos landing page
- A céget/projektet bemutató tartalom
- Reszponzív design
- Gyors hivatkozások a fő funkciókhoz

### ✅ 3. Adatbázis menü (4 pont)
- 3 tábla adatainak megjelenítése:
  - **Pilóták** (drivers): név, nem, születési dátum, ország
  - **Grand Prix-k** (gps): név, dátum, helyszín
  - **Versenyek** (races): pilóta, dátum, helyezés, csapat
- ORM használat (Eloquent)
- Migráció és Seeding implementálva

### ✅ 4. Kapcsolat menü (3 pont)
- Kapcsolatfelvételi űrlap
- **Szerver oldali validáció**:
  - Név: kötelező, maximum 255 karakter
  - Email: kötelező, érvényes email formátum
  - Tárgy: opcionális
  - Üzenet: kötelező, minimum 10 karakter
- Adatok mentése az adatbázisba (contacts tábla)

### ✅ 5. Üzenetek menü (3 pont)
- Csak bejelentkezett felhasználóknak elérhető
- Beérkezett üzenetek megjelenítése táblázatban
- **Fordított időrend** (legfrissebb elől)
- Küldés idejének megjelenítése
- Email cím kattintható (mailto link)

### ✅ 6. Diagram menü (2 pont)
- **Chart.js** használata
- 3 diagram:
  1. **Oszlopdiagram**: Top 10 ország pilótaszám szerint
  2. **Vonaldiagram**: Versenyek számának alakulása évek szerint
  3. **Kördiagram**: Top 10 pilóta versenyeik száma szerint
- Interaktív és reszponzív

### ✅ 7. CRUD menü (4 pont)
- Pilóták (drivers) tábla teljes CRUD műveletei
- Csak **admin** szerepkörrel rendelkezők számára
- Funkciók:
  - **Create**: Új pilóta felvitele
  - **Read**: Pilóták listázása (táblázatos nézet, lapozással)
  - **Update**: Pilóta adatainak módosítása
  - **Delete**: Pilóta törlése (megerősítéssel)

### ✅ 8. Admin menü (bonus)
- Csak **admin** szerepkörrel rendelkezők számára
- Statisztikák megjelenítése:
  - Összes pilóta
  - Összes verseny
  - Grand Prix-k száma
  - Beérkezett üzenetek
- Gyors műveletek linkjei
- Rendszerinformációk

## Technológiai stack

### Backend
- **Laravel 11.x** - PHP framework
- **Inertia.js** - Modern monolith architektúra
- **MySQL** - Adatbázis
- **Eloquent ORM** - Adatbázis műveletekhez

### Frontend
- **React 18.x** - UI könyvtár
- **TypeScript** - Típusbiztos JavaScript
- **shadcn/ui** - UI komponensek
- **Tailwind CSS** - Utility-first CSS
- **Chart.js** - Diagramok készítéséhez
- **Vite** - Build tool

## Telepítés és használat

### 1. Függőségek telepítése

```bash
composer install
npm install
```

### 2. Környezeti változók beállítása

```bash
cp .env.example .env
php artisan key:generate
```

Állítsd be az adatbázis kapcsolatot a `.env` fájlban:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=formulaone
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Adatbázis migrálása és feltöltése

```bash
# Táblák létrehozása
php artisan migrate

# Adatok betöltése CSV-ből
php artisan db:seed --class=DriverSeeder
php artisan db:seed --class=GPSeeder
php artisan db:seed --class=RaceSeeder

# Admin és teszt felhasználó létrehozása
php artisan db:seed --class=AdminUserSeeder
```

### 4. Frontend build

```bash
# Fejlesztési mód (hot reload)
npm run dev

# Produkciós build
npm run build
```

### 5. Szerver indítása

```bash
php artisan serve
```

Az alkalmazás elérhető: http://localhost:8000

## Bejelentkezési adatok

### Admin felhasználó
- **Email**: admin@formula1.hu
- **Jelszó**: password
- **Szerepkör**: admin (teljes hozzáférés)

### Regisztrált felhasználó
- **Email**: user@formula1.hu
- **Jelszó**: password
- **Szerepkör**: registered (Üzenetek menü elérhető)

## Mappaszerkezet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth.php              # Autentikáció
│   │   ├── ContactController.php # Kapcsolat/Üzenetek
│   │   ├── DashboardController.php # Főoldal, Adatbázis, Diagram
│   │   └── DriverController.php  # CRUD műveletek
│   └── Middleware/
│       └── AdminMiddleware.php   # Admin jogosultság ellenőrzés
├── Models/
│   ├── Contact.php               # Üzenetek
│   ├── Driver.php                # Pilóták
│   ├── GP.php                    # Grand Prix-k
│   ├── Race.php                  # Versenyek
│   └── User.php                  # Felhasználók

resources/js/
├── components/
│   ├── Layout.tsx                # Fő layout (navigáció, footer)
│   └── ui/                       # shadcn/ui komponensek
├── pages/
│   ├── Admin/Index.tsx           # Admin dashboard
│   ├── Auth/
│   │   ├── Login.tsx             # Bejelentkezés
│   │   └── Register.tsx          # Regisztráció
│   ├── Chart/Index.tsx           # Diagramok
│   ├── Contact/Create.tsx        # Kapcsolat űrlap
│   ├── Database/Index.tsx        # Adatbázis böngészése
│   ├── Drivers/                  # CRUD
│   │   ├── Index.tsx             # Lista
│   │   ├── Create.tsx            # Új pilóta
│   │   └── Edit.tsx              # Szerkesztés
│   ├── Messages/Index.tsx        # Üzenetek lista
│   └── Welcome.tsx               # Főoldal
```

## Adatbázis táblák

1. **users** - Felhasználók (autentikáció, szerepkörök)
2. **contacts** - Kapcsolatfelvételi üzenetek
3. **drivers** - Formula 1 pilóták
4. **gps** - Grand Prix versenyek
5. **races** - Versenyeredmények

## Biztonsági funkciók

- CSRF védelem minden űrlapnál
- Jelszavak hash-elése (bcrypt)
- Middleware alapú jogosultság kezelés
- Szerver oldali validáció
- SQL injection védelem (Eloquent ORM)
- XSS védelem (React automatic escaping)

## Pontszámok összegzése

| Funkció | Pontszám | Státusz |
|---------|----------|---------|
| Autentikáció | 3 | ✅ |
| Főoldal | 2 | ✅ |
| Adatbázis | 4 | ✅ |
| Kapcsolat | 3 | ✅ |
| Üzenetek | 3 | ✅ |
| Diagram | 2 | ✅ |
| CRUD | 4 | ✅ |
| **Összesen** | **21** | **✅** |

## Képernyőképek

(Itt helyezd el a képernyőképeket a különböző funkciókról)

## Licenc

MIT License

