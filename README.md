## Event Booking System

This application allows users to manage event bookings, filter data based on employee name, event name, and event date, and view relevant records.

### Installation Process:
To run the app please follow below steps and commands <br/>
### Step 1: Start the Application
* `docker compose up -d` or `docker-compose up -d`
* `docker exec -it php bash`
* Make sure you're inside `/var/www/html` folder. Otherwise run `cd /var/www/html`
* `php migrations/table_creation.php`

There should be created `employees`, `events` and `participations` table.

### Step 2: Import Data
Access the PHP container again (if not already inside):
* `docker exec -it php bash`
* `php import.php`

Once completed, data should be imported successfully. 

### Step 3: Access the Application
Since the app was already started in Step 1, it should be accessible at
```
http://localhost:8080
```
Use the application to filter data by employee_name, event_name, or event_date.

### Author:

[Md Habibur Rahman](https://habib.im)
habibur.rahman.rawnak@gmail.com


