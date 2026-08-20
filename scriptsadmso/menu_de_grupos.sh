#!/bin/bash

opc=0

function menu(){
    echo "GESTIÓN DE GRUPOS"
    echo "1 - Crear grupo"
    echo "2 - Eliminar grupo"
    echo "3 - Agregar usuario a grupo"
    echo "4 - Quitar usuario de grupo"
    echo "5 - Listar grupos"
    echo "6 - Volver"
    echo "Ingrese una opción: "
}

while [ $opc -ne 6 ];
do
    menu
    read opc
    case $opc in
        1)
            read -p "Nombre del grupo: " grupo
            sudo groupadd "$grupo"
            echo "Grupo $grupo creado" ;;
        2)
            read -p "Nombre del grupo a eliminar: " grupo
            sudo groupdel "$grupo"
            echo "Grupo $grupo eliminado" ;;
        3)
            read -p "Nombre de usuario: " user
            read -p "Nombre del grupo: " grupo
            sudo usermod -aG "$grupo" "$user"
            echo "Usuario $user agregado al grupo $grupo" ;;
        4)
            read -p "Nombre de usuario: " user
            read -p "Nombre del grupo: " grupo
            sudo gpasswd -d "$user" "$grupo"
            echo "Usuario $user quitado del grupo $grupo" ;;
        5)
            cut -d: -f1 /etc/group ;;
        6)
            echo "Volviendo..." ;;
        *)
            echo "Opción inválida" ;;
    esac
done
