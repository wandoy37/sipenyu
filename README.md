## Geojson
- data geojson dari : https://github.com/ArrayAccess/Indonesia-Postal-And-Area/

## Data Kantor dan Pegawai
- data dari : https://app2.pertanian.go.id/simluh2014
- login terlebih dahulu dan copy session `PHPSESSID` dari cookie dan pastekan ke .env PHPSESSID=xxxxx
- alur scraping :
  - scrape data penyuluh dan data kantor dari route `/scrape-penyuluh`
  - kemudian scrape untuk update alamat kantor di route `/scrape-kantor`
  - dan terakhir untuk update koordinate kantor dengan bantuan google api find-place dari route `/update-koordinat-kantor` (wajib mengisi env GOOGLE_MAP_API_KEY)