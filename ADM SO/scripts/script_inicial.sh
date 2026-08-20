#!/bin/bash

opc=0

function menu(){
    echo "MENÚ PRINCIPAL"
    echo "1 - Gestión de usuarios"
    echo "2 - Gestión de grupos"
    echo "3 - Gestión de respaldos"
    echo "4 - Gestión de redes"
    echo "5 - Gestión de Bases de datos"
    echo "6 - Gestión de Firewall"
    echo "7 - Gestión de Logs del Sistema"
    echo "8 - Gestión de Docker"
    echo "9 - Salir"
    echo "Ingrese una opción: "
}

while [ $opc -ne 9 ];
do
    menu
    read opc
    case $opc in
        1)
            ./menu_de_usuarios.sh ;;
        2)
            ./menu_de_grupos.sh ;;
        3)
            ./menu_de_respaldos.sh ;;
        4)
            ./menu_de_redes.sh ;;
        5)
            ./menu_de_bases_de_datos.sh ;;
        6)
            ./menu_de_gestion_firewall.sh ;;
        7)
            ./menu_de_logs.sh ;;
        8)
            ./menu_de_docker.sh ;;
        9)
            echo "Saliendo..." ;;
        *)
            echo "Opción inválida" ;;
    esac
done
