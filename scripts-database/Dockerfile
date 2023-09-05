FROM mysql:latest

ENV MYSQL_ROOT_PASSWORD=secret
ENV MYSQL_DATABASE=dbpostech

COPY data/criacao_tabelas.sql /docker-entrypoint-initdb.d

CMD ["mysqld", "--datadir=/var/lib/mysql", "--user=mysql", "--socket=/var/run/mysqld/mysqld.sock", "--port=3306", "--bind-address=0.0.0.0", "--skip-networking=0", "--init-file=/docker-entrypoint-initdb.d/criacao_tabelas.sql"]


EXPOSE 3306