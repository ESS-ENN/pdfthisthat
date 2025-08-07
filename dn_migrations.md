##  1. Exporting the Database from the Old Server

###  Using phpMyAdmin:
1. Login to phpMyAdmin on your current (old) server, avaible in your .env file.
2. Select the database you want to move (e.g., `pdfthisthat_db`).
3. Click the Export tab at the top.
4. Choose Quick export method and select **SQL** as the format.
5. Click Go — this will download a `.sql` file containing your full database (structure + data).

###  Using Command Line:
If you have terminal or SSH access, you can export the database using this command:

```bash
mysqldump -u your_db_user -p your_database_name > pdfthisthat_backup.sql

##  1. Importing the Database into the New Server

1. Login to phpMyAdmin on your new server, avaible in your .env file.
2. Click the Import tab at the top adn import the previoulsy downloaded sql db file.
DB_DATABASE=
DB_USERNAME=new_user
DB_PASSWORD=new_password
DB_HOST=  # Or use the IP/domain of your new database host
