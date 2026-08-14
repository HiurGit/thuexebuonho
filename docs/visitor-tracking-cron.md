# Visitor Tracking Cron

Khi dua website len aaPanel, co 2 cach chay tu dong viec don dep `visitor_logs`.

## Cach 1: Dung Laravel scheduler

Code da co lich:

- `visitor-logs:prune`
- Chay vao `02:30` ngay `1` hang thang

Cron can them trong aaPanel:

```bash
cd /www/wwwroot/thuexebuonho && php artisan schedule:run >> /dev/null 2>&1
```

Tan suat cron trong aaPanel:

- Moi phut 1 lan

Day la cach nen dung neu sau nay website co them cac tac vu tu dong khac.

## Cach 2: Chay truc tiep lenh don log

Neu chi muon don log truy cap, co the tao cron command truc tiep.

Mac dinh hien tai he thong giu log trong `30 ngay`.

```bash
cd /www/wwwroot/thuexebuonho && php artisan visitor-logs:prune >> /dev/null 2>&1
```

Lich cron:

- Phut: `30`
- Gio: `2`
- Ngay: `1`
- Thang: `*`
- Thu: `*`

Tuong duong bieu thuc:

```text
30 2 1 * *
```

## Khuyen nghi

Nen dung `Cach 1` de sau nay mo rong de hon.
