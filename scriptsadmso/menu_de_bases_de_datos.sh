#!/bin/bash

opc=0

function menu(){
    echo "GESTIÓN DE BASES DE DATOS"
    echo "1 - Crear base de datos"
    echo "2 - Eliminar base de datos"
    echo "3 - Listar bases de datos"
    echo "4 - Respaldar base de datos"
    echo "5 - Restaurar base de datos"
    echo "6 - Volver"
    echo "Ingrese una opción: "
}

while [ $opc -ne 6 ];
do
    menu
    read opc
    case $opc in
        1)
            read -p "Nombre de la base de datos: " bd
            sudo mysql -e "CREATE DATABASE $bd;"
            echo "Base de datos $bd creada" ;;
        2)
            read -p "Nombre de la base de datos a eliminar: " bd
            sudo mysql -e "DROP DATABASE $bd;"
            echo "Base de datos $bd eliminada" ;;
        3)
            sudo mysql -e "SHOW DATABASES;" ;;
        4)
            read -p "Nombre de la base de datos: " bd
            nombre="${bd}_$(date +%Y%m%d_%H%M%S).sql"
            sudo mysqldump "$bd" > "/respaldos/$nombre"
            echo "Respaldo creado: $nombre" ;;
        5)
            read -p "Nombre de la base de datos: " bd
            read -p "Nombre del archivo .sql en /respaldos: " archivo
            sudo mysql "$bd" < "/respaldos/$archivo"
            echo "Base de datos $bd restaurada" ;;
        6)
            echo "Volviendo..." ;;
        *)
            echo "Opción inválida" ;;
    esac
done
