# FileSphere — Local IIS + MySQL + phpMyAdmin Setup

Good news: nothing in this app is Apache-specific (no `.htaccess`, no
`mod_rewrite`). It's plain PHP with relative paths, so it runs on IIS
without rewriting any application logic. What changed in this package:

- **`database.php`** — now points at a local MySQL server instead of
  the old InfinityFree shared-hosting credentials, and a leftover
  query that ran on every page load (using an undefined `$username`
  in some files) was removed.
- **`login.php`** — used to hardcode two different sets of DB
  credentials (one for "localhost", one for the live host) and built
  raw SQL strings from `$_POST` values. It now shares `database.php`'s
  connection and uses prepared statements instead, matching the rest
  of the app and closing a SQL-injection hole. Passwords are now
  hashed with `password_hash()` on registration and checked with
  `password_verify()` on login, instead of being stored and compared
  in plain text.
- **`schema.sql`** — added. The original project didn't ship a SQL
  dump, so this recreates the `user`, `files`, and `shared_files`
  tables from how the code actually queries them.
- **`uploads/`** — emptied out (any files you had are still in the
  original zip; copy them back in after setup if you need them).

One thing worth doing regardless of where you host this: the original
`database.php` had **live credentials for an InfinityFree database
committed in plain text**. If that account is still active, it's
worth rotating that password.

---

## 1. Enable IIS + CGI

1. **Control Panel → Programs → Turn Windows features on or off**
2. Check:
   - `Internet Information Services`
   - Under `IIS → World Wide Web Services → Application Development Features` → check **CGI**
3. Click OK and let Windows install the components.

## 2. Install PHP

1. Download a **Non Thread Safe (NTS)** x64 PHP build from
   [windows.php.net/download](https://windows.php.net/download/) —
   pick a version your extensions support (PHP 8.1+ is fine here).
2. Extract it to e.g. `C:\PHP`.
3. Copy `php.ini-production` to `php.ini` in that folder and edit it:
   - Uncomment `extension_dir = "ext"`
   - Uncomment `extension=mysqli`
   - Uncomment `extension=fileinfo`
   - Set `upload_max_filesize = 25M` and `post_max_size = 25M` (app allows up to 20MB uploads)
   - Set `session.save_path = "C:\Windows\Temp"` (or another writable folder)
4. In **IIS Manager**, select your server → **Handler Mappings → Add Module Mapping**:
   - Request path: `*.php`
   - Module: `FastCgiModule`
   - Executable: `C:\PHP\php-cgi.exe`
   - Name: `PHP via FastCGI`
5. Under **Server → FastCGI Settings**, confirm the `php-cgi.exe` entry exists (IIS usually adds it automatically from step 4).

## 3. Install MySQL

1. Install **MySQL Community Server** via the MySQL Installer for Windows.
2. During setup, either set a `root` password or leave it blank for local dev.
   - If you set a password, update `$password` in `database.php` to match.
3. Make sure the MySQL service is running (`services.msc` → `MySQL80`).

## 4. Install phpMyAdmin

1. Download phpMyAdmin from [phpmyadmin.net](https://www.phpmyadmin.net/).
2. Extract it to `C:\inetpub\wwwroot\phpmyadmin`.
3. Copy `config.sample.inc.php` → `config.inc.php`, and set
   `$cfg['blowfish_secret']` to any random 32-character string.
4. In IIS Manager, either add it as a virtual directory under your
   default site, or create it as its own site bound to a different port.
5. Browse to `http://localhost/phpmyadmin` and log in with your MySQL
   root credentials.

## 5. Import the database

1. In phpMyAdmin, go to **Import**.
2. Choose `schema.sql` from this package and click **Go**.
3. This creates the `filesphere_db` database with the `user`, `files`,
   and `shared_files` tables the app needs.

## 6. Deploy the site

1. Copy this whole folder to `C:\inetpub\wwwroot\filesphere` (or
   wherever you'd like).
2. In **IIS Manager**, right-click **Sites → Add Website**:
   - Site name: `FileSphere`
   - Physical path: `C:\inetpub\wwwroot\filesphere`
   - Binding: e.g. `http://localhost:8080` (or port 80 if free)
3. Under **Default Document**, add `index.php` to the top of the list.
4. Right-click the `uploads` folder → **Properties → Security**, and
   give **IIS_IUSRS** (or your app pool identity) **Modify** rights so
   the app can write uploaded files there.

## 7. Test it

- Visit `http://localhost:8080/auth.html`, register a user, then log
  in and try uploading a file through `filemanager.php`.

If PHP errors appear instead of pages rendering, double-check the
FastCGI handler mapping (step 2.4) and that `php-cgi.exe` runs
correctly from a command prompt on its own.
