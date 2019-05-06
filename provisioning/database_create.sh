#!/bin/bash

main()
{
    if [[ "$1" == "--help" ]] ; then
        print_usage
        exit
    fi  

    host=$1
    db=$2
    user=$3
    pass=$4

    if [ -z "$host" ]; then 
        echo -n "MySql Host: "
        read host
    fi

    if [ -z "$db" ]; then 
        echo -n "MySql Database: "
        read db
    fi

    if [ -z "$user" ]; then 
        echo -n "MySql Username: "
        read user
    fi

    if [ -z "$pass" ]; then 
        echo -n "MySql Password: "
        read -s pass
    fi

    rm .mysql_crd_tmp >/dev/null 2>&1
    echo "[client]" >> .mysql_crd_tmp
    echo "user=$user" >> .mysql_crd_tmp
    echo "password=$pass" >> .mysql_crd_tmp

    mysql --defaults-extra-file=.mysql_crd_tmp -h $host $db -e "
        CREATE TABLE IF NOT EXISTS curls (
            id BIGINT NOT NULL AUTO_INCREMENT,
            address VARCHAR(255) NOT NULL,
            method VARCHAR(5) NOT NULL,
            payload TEXT DEFAULT NULL,
            http_user VARCHAR(255) DEFAULT NULL,
            http_password VARCHAR(255) DEFAULT NULL,
            insecure INT(1) DEFAULT 0,
            parameters TEXT DEFAULT NULL,
            headers TEXT DEFAULT NULL,
            KEY id_index (id) USING BTREE,
            PRIMARY KEY (id)
        );
    "
    
    rm .mysql_crd_tmp >/dev/null 2>&1

    echo "Done."
}

print_usage()
{
    echo 'Usage: ./database_create.sh <host> <database> <user> <password>'
}

main $@;