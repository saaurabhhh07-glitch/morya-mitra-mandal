MORAYA MITRA MANDAL MANEWADI — T-SHIRT BOOKING
================================================

Files:
- index.html  : premium member booking page
- admin.html  : admin login + dashboard + size totals + search + delete + CSV export
- api.php     : PHP + SQLite backend
- .htaccess   : blocks direct database download

DEFAULT ADMIN LOGIN
Username: admin
Password: Morya@2026

IMPORTANT BEFORE GOING LIVE
1. Change the username/password inside api.php.
2. Upload all files to PHP hosting with SQLite/PDO_SQLITE enabled.
3. Ensure the hosting allows PHP to create bookings.sqlite in this folder.
4. Open index.html. Admin Login is at admin.html.
5. The 2-day countdown starts when the site is first opened in a browser. For a true server-controlled deadline, set the deadline in PHP.

This is a real backend version, not a localStorage-only prototype. Bookings are stored in the server-side SQLite database and are visible to the admin dashboard.
