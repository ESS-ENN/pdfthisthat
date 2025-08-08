# operations.md – Project: pdfthisthat.com (Laravel PHP)

## Verifying Project Health / If It's Working Correctly

1. **Homepage Accessibility**
   - Visit: https://pdfthisthat.com
   - Expected Result: Homepage loads without error, displaying core functionality (e.g., upload/convert PDF options).

2. **Basic Functionality Test**
   - Upload a sample file.
   - Convert or process it.
   - Download and verify the result.

3. **Laravel Health Check**
   - Run:
     php artisan --version
     php artisan route:list
     php artisan config:cache
   - Check for any errors or warnings.

4. **Server & Queue Monitoring**
   - Ensure background workers are running:
     php artisan queue:work
   - Monitor logs:
     tail -f storage/logs/laravel.log

5. **Database Connection**
   - Run:
     php artisan migrate:status

---

## 🛠️ If It’s Not Working Properly: Common Issues & Debugging

| Issue                  | Possible Cause                        | Debugging Steps                          |
|------------------------|----------------------------------------|------------------------------------------|
| 500 Internal Server Error | Misconfigured .env, code error     | Check storage/logs/laravel.log           |
| Upload fails           | Permissions or file size limits       | Check php.ini and folder permissions     |
| Database errors        | Incorrect DB credentials or DB down   | Validate .env DB config, test mysql conn |
| Blank page             | Fatal PHP error                       | Enable display_errors or check logs      |
| CSRF token mismatch    | Session timeout or malformed form     | Verify CSRF field and session config     |

---

## 🔄 Restoring Normal Operation After Failure

1. **Restart Services**
   - Web Server:
     sudo systemctl restart  or apache2
   - PHP:
     sudo systemctl restart php   # version may vary
   - Queue Worker:
     php artisan queue:restart

2. **Clear Laravel Cache**
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan cache:clear
   php artisan config:cache

3. **Reset File Permissions (if needed)**
   sudo chown -R www-data:www-data /path/to/project
   sudo chmod -R 755 /path/to/project/storage
   sudo chmod -R 755 /path/to/project/bootstrap/cache

4. **Re-run Migrations / Seed (if needed)**
   # Use only if database reset is safe
   php artisan migrate:fresh --seed

5. **Roll Back to Last Working Commit**
   composer install
   php artisan migrate

6. **Re-deploy**
   - Take a backup of the project
   - Deploy the project in new server and check having same issue or not
   - IF having the perform Common Issues Debugging and resolve it
   - Trigger deployment again
   - Or manually redeploy code from last known good state

---

## 📁 Laravel Scheduler & Cron Setup (if used)

Add to crontab:
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
