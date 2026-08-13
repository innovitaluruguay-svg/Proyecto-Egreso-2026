#!/bin/bash

opc=0

function menu(){
    echo "GESTIÓN DE DOCKER"
    echo "1 - Listar contenedores"
    echo "2 - Iniciar contenedor"
    echo "3 - Detener contenedor"
    echo "4 - Eliminar contenedor"
    echo "5 - Listar imágenes"
    echo "6 - Volver"
    echo "Ingrese una opción: "
}

while [ $opc -ne 6 ];
do
    menu
    read opc
    case $opc in
        1)
            sudo docker ps -a ;;
        2)
            read -p "Nombre o ID del contenedor: " cont
            sudo docker start "$cont" ;;
        3)
            read -p "Nombre o ID del contenedor: " cont
            sudo docker stop "$cont" ;;
        4)
            read -p "Nombre o ID del contenedor: " cont
            sudo docker rm "$cont" ;;
        5)
            sudo docker images ;;
        6)
            echo "Volviendo..." ;;
        *)
            echo "Opción inválida" ;;
    esac
done
