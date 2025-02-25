## Event Booking System

This application is an Event Booking System that allows users to easily manage bookings, filter event 
data based on employee name, event name, and event date, and view relevant records. The system is built 
using plain PHP, adhering to OOP best practices, SOLID and relies on MySQL for database management. 
The application has been successfully deployed on Kubernetes, ensuring scalability and high availability.

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

### Run Tests
```
vendor/bin/phpunit --testdox
```

### Kubernetes Deployment
``` 
kubectl apply -f k8s/mysql-pvc.yaml
kubectl apply -f k8s/mysql-deployment.yaml
kubectl apply -f k8s/php-pvc.yaml
kubectl apply -f k8s/php-deployment.yaml
kubectl apply -f php-service.yaml
```

### Check the status of k8s pods
``
kubectl get pods
``

### Get the external IP
``
kubectl get service php-service
``
or
``
kubectl get svc php-service
``

### Author:

[Md Habibur Rahman](https://habib.im)
habibur.rahman.rawnak@gmail.com


