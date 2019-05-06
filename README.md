# Curl It! - [https://curlit.tk/](https://curlit.tk/)

## Setup

1. Clone this repository into `/var/www/html`

2. Create your database in MySql with no tables and then configure `config/web.php`.

3. Run the database provisioner located in `provisioning/database_create.sh`.

```
./provisioning/database_create.sh <host> <database> <username> [optional password]
```

4. Set your apache/nginx site root to `/var/www/html/public`

5. Install composer dependencies.

```
composer install
```

6. You're ready to go!

