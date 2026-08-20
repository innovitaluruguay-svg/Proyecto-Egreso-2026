#!/bin/bash

opc=0

function menu(){
    echo "GESTIÓN DE RESPALDOS"
    echo "1 - Crear respaldo"
    echo "2 - Restaurar respaldo"
    echo "3 - Listar respaldos"
    echo "4 - Eliminar respaldo"
    echo "5 - Volver"
    echo "Ingrese una opción: "
}

DIR_RESPALDOS="/respaldos"
sudo mkdir -p "$DIR_RESPALDOS"

while [ $opc -ne 5 ];
do
    menu
    read opc
    case $opc in
        1)
            read -p "Ruta a respaldar: " origen
            nombre="respaldo_$(date +%Y%m%d_%H%M%S).tar.gz"
            sudo tar -czvf "$DIR_RESPALDOS/$nombre" "$origen"
            echo "Respaldo creado: $nombre" ;;
        2)
            read -p "Nombre del respaldo a restaurar: " archivo
            read -p "Ruta destino: " destino
            sudo tar -xzvf "$DIR_RESPALDOS/$archivo" -C "$destino"
            echo "Respaldo restaurado en $destino" ;;
        3)
            ls -lh "$DIR_RESPALDOS" ;;
        4)
            read -p "Nombre del respaldo a eliminar: " archivo
            sudo rm -f "$DIR_RESPALDOS/$archivo"
            echo "Respaldo $archivo eliminado" ;;
        5)
            echo "Volviendo..." ;;
        *)
            echo "Opción inválida" ;;
    esac
done
