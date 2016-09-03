# This test app for Elastic Search and PostgreSQL

How to install:
1.Clone this repo.
2.Run composer install if no laravel module installed yet.
2.Run elastic search, I'm using version: 2.3.5.
3.Adjust settings for database on .env file (root directory of the project).

```bash
DB_HOST={your postgreSQL database host} --example: localhost
DB_DATABASE={your database name} --example: elastic
DB_USERNAME={your database username} --example: postgres
DB_PASSWORD={your database password} --example: password

ELASTIC_URL={your elastic search URL} --example: http://localhost:9200
```

4.Adjust 'database.php' on folder 'config' with your necessary value.
5.Run 'php artisan migrate'. This will migrate all necessary tables on this project to your postgreSQL.
6.Done!

After installation done:
1.Open 'http://{your-host}/elastic/public/elastic' if you place on the folder 'elastic' on folder 'htdocs' on xampp for example.
2.If you open correct url, you will see the search test page.
3.Follow the description below each of input field and button to see what it use for.
4.Thanks, if you have any questions, contact me on: eric.gamer84@gmail.com
