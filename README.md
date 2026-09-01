<div align="center">

# Golf Indonesia - Tournament Management and Live Scoring Platform

### *Dynamic Leaderboard, Par Matrix Calculations, and Yardage Book E-Commerce*

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

---

</div>

## About The Project

National golf tournament management software featuring real-time hole-by-hole scoring, automatic gross and net calculations, player handicap tracking, and an online yardage book store.

---

## Key Features

- Hole-by-Hole Live Scoring: 18-hole score entry with automatic handicap stroke indexing.
- Dynamic Leaderboard: Real-time tournament ranking sorted by Gross Score, Net Score, and Thru hole count.
- Yardage Book Store: E-commerce catalog for purchasing official course topography guides.
- Player Handicap Ledger: Tracks historic rounds to calculate official handicap indexes.

---

## Technology Stack

- Backend: Laravel 10 (PHP 8.2)
- Database: MySQL 8.0 (Player, EventScore, EventPar models)
- Frontend: Bootstrap 5.3

---

## Getting Started

`ash
git clone https://github.com/raphlv/golf-indonesia.git
cd golf-indonesia
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
`

---

## Developer and Maintainer
Pangeran Ryan Pahlevi - https://pangeranryan.vercel.app