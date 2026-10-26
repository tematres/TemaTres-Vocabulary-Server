# TemaTres with Docker

```sh
cp docker/.env.example docker/.env            # then set TEMATRES_DB_PASSWORD in docker/.env (letters and digits)
docker compose -f docker/docker-compose.yml --env-file docker/.env up -d --build
```

Open <http://localhost:8080/vocab/install.php>, create the vocabulary and the administrator (the e-mail and password become your login), then use <http://localhost:8080/vocab/>.

* The image contains the code of the checked out version of this repository, so there is nothing to edit when a new version is released: back up the database (see below), check out the new version and run the `docker compose` command above again. The database volume (`tematres_tematres_db`) is kept. Then follow step 3 of *Update from a previous version* in `readme.md`. To run a second copy, add `-p <name>` to the commands and set another `TEMATRES_PORT`.
* Stop with `docker compose -f docker/docker-compose.yml down` and start again with `docker compose -f docker/docker-compose.yml up -d`; the database is kept. `down -v` deletes it.
* The port is published on localhost only. Set `TEMATRES_BIND=0.0.0.0` in `docker/.env` to publish it on the network (the installer is open until the vocabulary has been created).
* The database settings are environment variables (`docker/db.tematres.php` replaces `vocab/db.tematres.php` in the image). The password in `docker/.env` is used when the database is created; changing it later also requires changing it in the database.
* PHP version: set `PHP_VERSION=8.4` in `docker/.env` (default 8.3) and run `up -d --build`. PHP errors are written to the log: `docker compose -f docker/docker-compose.yml logs app`.
* Behind a reverse proxy that terminates TLS, TemaTres detects https from `X-Forwarded-Proto` (see `getURLbase()`). `install.php` checks only `HTTPS` for the address of its stylesheets and scripts, so through such a proxy the browser may block them as mixed content; the form itself still posts to the proxy.
* Back up the database, to a file outside the repository (everything in the repository is copied into the image): `docker compose -f docker/docker-compose.yml exec -T db sh -c 'mariadb-dump -utematres -p"$MARIADB_PASSWORD" --single-transaction tematres' > ~/tematres.sql`
* Restore it: `docker compose -f docker/docker-compose.yml exec -T db sh -c 'mariadb -utematres -p"$MARIADB_PASSWORD" tematres' < ~/tematres.sql`
