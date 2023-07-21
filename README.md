## Geojson
- data geojson dari : https://github.com/ArrayAccess/Indonesia-Postal-And-Area/

## Instalasi
- clone repo
- `composer install`
- copy `.env.example` ke `.env`
- isi detail database di `.env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`


## Data Kantor dan Pegawai
> **Warning**
> Jika ingin melakukan scraping manual
- data dari : https://app2.pertanian.go.id/simluh2014
- login terlebih dahulu dan copy session `PHPSESSID` dari cookie dan pastekan ke .env PHPSESSID=xxxxx
- alur scraping :
  - scrape data penyuluh dan data kantor dari route `/scrape-penyuluh`
  - kemudian scrape untuk update alamat kantor di route `/scrape-kantor`
  - dan terakhir untuk update koordinate kantor dengan bantuan google api find-place dari route `/update-koordinat-kantor` (wajib mengisi env GOOGLE_MAP_API_KEY)

## Dokumentasi API

https://documenter.getpostman.com/view/7785980/2s946k5qhy

- api menggunakan token auth, untuk menggunakannya harus login terlebih dahulu dan mendapatkan token
- gunakan token pada header `Authorization` dengan value `Bearer {token}`