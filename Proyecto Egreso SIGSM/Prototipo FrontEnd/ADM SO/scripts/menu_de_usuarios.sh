#!/bin/bash

opc=0

function menu(){
    echo "GESTIÓN DE USUARIOS"
    echo "1 - Crear usuario"
    echo "2 - Eliminar usuario"
    echo "3 - Modificar usuario"
    echo "4 - Cambiar contraseña"
    echo "5 - Listar usuarios"
    echo "6 - Volver"
    echo "Ingrese una opción: "
}

while [ $opc -ne 6 ];
do
    menu
    read opc
    case $opc in
        1)
            read -p "Nombre de usuario: " user
            sudo useradd -m "$user"
            echo "Usuario $user creado" ;;
        2)
            read -p "Nombre de usuario a eliminar: " user
            sudo userdel -r "$user"
            echo "Usuario $user eliminado" ;;
        3)
            read -p "Nombre de usuario a modificar: " user
            read -p "Nuevo shell (ej: /bin/bash): " shell
            sudo usermod -s "$shell" "$user"
            echo "Usuario $user modificado" ;;
        4)
            read -p "Nombre de usuario: " user
            sudo passwd "$user" ;;
        5)
            cut -d: -f1 /etc/passwd ;;
        6)
            echo "Volviendo..." ;;
        *)
            echo "Opción inválida" ;;
    esac
done
