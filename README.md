# Morya Mitra Mandal — Submit-only booking + Admin

## Files to upload to GitHub
- index.html
- admin.html
- api/bookings.js
- package.json
- supabase.sql
- tshirt-poster.png (your existing poster)

## Important
This version does NOT open WhatsApp when a customer submits.
The booking is saved to Supabase and appears in `/admin.html`.

## One-time Supabase setup
1. Create a Supabase project.
2. Open SQL Editor and run `supabase.sql`.
3. Create an Admin user in Authentication > Users.
4. Put these Vercel environment variables:
   SUPABASE_URL = your project URL
   SUPABASE_ANON_KEY = your anon/public key
   SUPABASE_SERVICE_ROLE_KEY = your service role key
5. In admin.html replace:
   PASTE_SUPABASE_URL
   PASTE_SUPABASE_ANON_KEY
   with the same project URL and anon key.
6. Redeploy on Vercel.
7. Admin page: /admin.html

Never put SUPABASE_SERVICE_ROLE_KEY in index.html or admin.html.
