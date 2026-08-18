<div align="center">

# Golf Indonesia - Golf Course Booking and Golfer Community Portal

### *Digital Tee-Time Reservations, Handicap Calculation, and Tournament Scoring*

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)

---

</div>

## Overview

Golf Indonesia is a comprehensive sports management and reservation platform designed for golfers, golf clubs, and tournament organizers in Indonesia. It digitizes tee-time bookings across registered golf courses, tracks official player handicaps, and manages live tournament scoreboards.

---

## Key Features

### 1. Tee-Time Reservation System
- Real-time slot availability checking across Indonesian golf courses.
- Online booking for player groups (1 to 4 golfers per flight).
- Instant booking confirmation with QR code check-in at clubhouses.

### 2. Handicap Index Tracking (WHS Compliant)
- Automatic Handicap Index calculation based on World Handicap System formulas.
- Digital Scorecard entry with Course Rating and Slope Rating adjustments.
- Historical scoring differential charts and performance analytics.

### 3. Tournament Management and Live Scoring
- Tournament creation, flight pairings, and registration management.
- Live leaderboard updates during tournament rounds.
- Gross score, Net score, and Stableford points classification.

---

## Technology Stack

| Layer | Technologies |
| :--- | :--- |
| **Backend** | PHP 8.2+ / Laravel 10.x |
| **Frontend** | Blade Templating, Tailwind CSS, Alpine.js |
| **Database** | MySQL / MariaDB |
| **Build System** | Vite 5.0 |

---

## Installation and Setup

`ash
git clone https://github.com/raphlv/golf-indonesia.git
cd golf-indonesia

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate

# Set DB_DATABASE=golf_indonesia in .env
php artisan migrate --seed
php artisan serve
`

---

## License and Author

Distributed under the MIT License.

Author: Pangeran Ryan Pahlevi (https://github.com/raphlv)  
Email: pangeranryan080504@gmail.com  

---
<div align="center">
  <sub>Automated Sync Enabled for Contribution Tracking | Last Updated: 2026-08-18 14:40:47</sub>
</div>