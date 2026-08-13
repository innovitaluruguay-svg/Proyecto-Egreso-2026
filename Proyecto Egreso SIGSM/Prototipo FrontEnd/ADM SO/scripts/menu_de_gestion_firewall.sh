#!/bin/bash

opc=0

function menu(){
    echo "GESTIÓN DE FIREWALL"
    echo "1 - Activar firewall"
    echo "2 - Desactivar firewall"
    echo "3 - Ver estado"
    echo "4 - Permitir puerto"
    echo "5 - Denegar puerto"
    echo "6 - Volver"
    echo "Ingrese una opción: "
}

while [ $opc -ne 6 ];
do
    menu
    read opc
    case $opc in
        1)
            sudo ufw enable ;;
        2)
            sudo ufw disable ;;
        3)
            sudo ufw status verbose ;;
        4)
            read -p "Puerto a permitir: " puerto
            sudo ufw allow "$puerto"
            echo "Puerto $puerto permitido" ;;
        5)
            read -p "Puerto a denegar: " puerto
            sudo ufw deny "$puerto"
            echo "Puerto $puerto denegado" ;;
        6)
            echo "Volviendo..." ;;
        *)
            echo "Opción inválida" ;;
    esac
done
