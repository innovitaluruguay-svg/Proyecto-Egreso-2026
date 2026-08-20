#!/bin/bash

function menu(){
    echo "=================================="
    echo "      GESTIÓN DE USUARIOS"
    echo "=================================="
    echo "1 - Crear usuario"
    echo "2 - Eliminar usuario"
    echo "3 - Modificar usuario"
    echo "4 - Cambiar contraseña"
    echo "5 - Listar usuarios"
    echo "6 - Salir"
    echo -n "Ingrese una opción: "
}

function crear_usuario(){
    read -p "Nombre de usuario: " user
    read -p "Nombre completo (comentario): " nombre_completo
    read -p "Grupo primario: " grupo_primario
    read -p "Grupos secundarios (separados por coma): " grupos_secundarios
    read -p "Shell (ej: /bin/bash): " shell

    sudo useradd -m -c "$nombre_completo" -g "$grupo_primario" -G "$grupos_secundarios" -s "$shell" "$user"
    echo "Usuario $user creado"
}

function eliminar_usuario(){
    read -p "Nombre de usuario a eliminar: " user
    sudo userdel -r "$user"
    echo "Usuario $user eliminado"
}

function modificar_usuario(){
    read -p "Nombre de usuario a modificar: " user
    read -p "Nuevo shell (ej: /bin/bash): " shell
    sudo usermod -s "$shell" "$user"
    echo "Usuario $user modificado"
}

function cambiar_contrasena(){
    read -p "Nombre de usuario: " user
    sudo passwd "$user"
}

function listar_usuarios(){
    cut -d: -f1 /etc/passwd
}

opc=0
while [ "$opc" -ne 6 ]; do
    menu
    read opc

    case $opc in
        1) crear_usuario ;;
        2) eliminar_usuario ;;
        3) modificar_usuario ;;
        4) cambiar_contrasena ;;
        5) listar_usuarios ;;
        6) echo "Saliendo..." ;;
        *) echo "Opción inválida" ;;
    esac
done