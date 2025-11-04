<?php

class UsuarioDAO {

    /**
    *
    * @var PDO
    */
    private $cnn;

    public function __construct( &$cnn ) {
        $this->cnn = $cnn;
    }

    public function empresa() {
        $sql = "SELECT * FROM empresa where id_empresa=:id";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id'=>1] );
        $resultado = $sentencia->fetch( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function lista_equipos( $id, $id2 ) {
        $sql = "SELECT e.*, c.nombre_empresa, c.nit_empresa, c.telefono_encargado, c.direccion_empresa, c.nombre, c.correo_electronico FROM inventario_equipos e LEFT JOIN clientes c ON e.id_cliente = c.id_cliente WHERE e.id_cliente=:id";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id'=>$id] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function equipo_id( $id_equipo ) {
        $sql = "SELECT e.*, c.nombre_empresa, c.nit_empresa, c.telefono_encargado, c.direccion_empresa, c.nombre, c.correo_electronico FROM inventario_equipos e LEFT JOIN clientes c ON e.id_cliente = c.id_cliente WHERE e.id_equipo=:id_equipo";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id_equipo' => $id_equipo] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_clientes($sucursal) {
        $params = [];
        $dataEmpr = $this->empresa();
        $sql = "SELECT id_cliente, nit_empresa, nombre_empresa, cedula_encargado, nombre, telefono_encargado, direccion_empresa 
                FROM clientes";
        if ($dataEmpr->sucursales) {
            $sql .= " WHERE sucursales LIKE :sucursal";
            $params['sucursal'] = "%|$sucursal|%";
        }
        $sentencia = $this->cnn->prepare($sql);
        $sentencia->execute($params);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public function buscar_clientes( $palabras, $sucursal ) {
        $sql = "SELECT id_cliente as id_principal, nit_empresa, nombre_empresa, cedula_encargado, concat(nit_empresa, ' - ', nombre_empresa) as data_empr FROM clientes WHERE (nit_empresa like :palabras OR nombre_empresa like :palabras) AND sucursales like :sucursal";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'palabras' => '%'.$palabras.'%',
            'sucursal' => '%|'.$sucursal.'|%'
        ] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_proveedores() {
        $sql = "SELECT * FROM proveedor";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute();
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_ubicaciones( $sucursal ) {
        $sql = "SELECT * FROM ubicacion WHERE id_sucursal =:sucursal";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['sucursal' => $sucursal] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_empleados() {
        $sql = "SELECT * FROM empleados";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute();
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function cliente( $id_cliente ) {
        $sql = "SELECT id_cliente, nit_empresa, nombre_empresa, cedula_encargado, nombre, telefono_encargado, direccion_empresa FROM clientes where id_cliente=:id_cliente";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id_cliente' => $id_cliente] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function cliente_nit( $nit_empresa ) {
        $sql = "SELECT id_cliente FROM clientes where nit_empresa=:nit_empresa";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['nit_empresa' => $nit_empresa] );
        $resultado = $sentencia->fetch( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_clientes_general() {
        $sql = "SELECT * FROM clientes ORDER BY id_cliente DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute();
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_productos_generales( $sucursal ) {
        $sql = "SELECT p.*, p.id_productos as 'id_equipo', p.imagen_producto as 'imagen', CONCAT_WS(' - ', u.tipo_ubicacion, u.numeracion) as ubicacion, CONCAT_WS(' - ', pr.nit, pr.nombre_proveedor) as proveedor, pr.nit as 'nit_proveedor' FROM productos p LEFT JOIN ubicacion u ON p.id_ubicacion = u.id_ubicacion LEFT JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor WHERE p.id_sucursal=:sucursal ORDER BY p.id_productos DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['sucursal' => $sucursal] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_productos( $id_productos ) {
        $sql = "SELECT p.id_productos, p.codigo_producto, p.stock_existente, CONCAT( p.codigo_producto, ' - ', p.nombre_producto, '. Prov: ', pr.nit, ' - ', pr.nombre_proveedor ) AS data_prod FROM productos p LEFT JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor WHERE p.id_productos=:id_productos";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id_productos' => $id_productos] );
        $resultado = $sentencia->fetch( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function buscar_productos( $palabras, $sucursal ) {
        $sql = "SELECT p.*, CONCAT( p.codigo_producto, ' - ', p.nombre_producto, '. Prov: ', pr.nit, ' - ', pr.nombre_proveedor ) AS data_prod, concat(pr.nit, ' - ', pr.nombre_proveedor) as proveedor, tipo_ubicacion FROM productos p LEFT JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor LEFT JOIN ubicacion u ON p.id_ubicacion = u.id_ubicacion WHERE p.codigo_producto like :palabras OR p.nombre_producto like :palabras AND p.id_sucursal=:sucursal";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'palabras' => '%'.$palabras.'%',
            'sucursal' => $sucursal
        ] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }
    
    public function existe_productos( $cod, $proveedor, $sucursal ) {
        $sql = "SELECT p.id_productos, CONCAT( p.codigo_producto, ' - ', p.nombre_producto, '. Prov: ', pr.nit, ' - ', pr.nombre_proveedor ) AS tproducto FROM productos p LEFT JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor WHERE p.codigo_producto =:cod AND pr.nit=:proveedor AND p.id_sucursal=:sucursal";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'cod' => $cod,
            'proveedor' => $proveedor,
            'sucursal' => $sucursal
        ] );
        $resultado = $sentencia->fetch( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function buscar_marcas( $palabras, $sucursal ) {
        $sql = "SELECT * FROM marcas WHERE nombre like :palabras OR palabras like :palabras";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'palabras' => '%'.$palabras.'%'
        ] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }
    
    public function buscar_mensajeros( $palabras, $sucursal ) {
        $sql = "SELECT *, id_mensajero as id_principal FROM mensajeros WHERE nombre like :palabras";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'palabras' => '%'.$palabras.'%'
        ] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_entradas_generales( $sucursal ) {
        $sql = "SELECT e.*, e.precio_compra as 'precio_entrada', p.*, em.nombre as usuario, concat(pr.nit, ' - ', pr.nombre_proveedor) as proveedor, pr.nit as nit_proveedor, u.tipo_ubicacion FROM entradas_productos e LEFT JOIN productos p ON e.id_productos = p.id_productos LEFT JOIN empleados em ON e.id_usuario = em.id_usuario LEFT JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor LEFT JOIN ubicacion u ON p.id_ubicacion = u.id_ubicacion WHERE e.id_sucursal=:sucursal ORDER BY e.id_entrada DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['sucursal' => $sucursal] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_salidas_generales( $sucursal ) {
        $sql = "SELECT s.*, p.marca, p.modelo, p.precio_compra, p.stock_min, p.stock_existente, p.codigo_producto, p.nombre_producto, o.cod_orden, em.nombre as usuario, concat(pr.nit, ' - ', pr.nombre_proveedor) as proveedor, u.tipo_ubicacion FROM salida_productos s LEFT JOIN productos p ON s.id_productos = p.id_productos LEFT JOIN empleados em ON s.id_usuario = em.id_usuario LEFT JOIN ordenes_servicio o on s.id_orden = o.id_orden LEFT JOIN proveedor pr ON p.id_proveedor = pr.id_proveedor LEFT JOIN ubicacion u ON p.id_ubicacion = u.id_ubicacion WHERE s.id_sucursal=:sucursal ORDER BY s.id_salida DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['sucursal' => $sucursal] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_ubicaciones_generales() {
        $sql = "SELECT u.*, s.nombre, s.estado FROM ubicacion u LEFT JOIN sucursales s ON u.id_sucursal = s.id_sucursal ORDER BY u.id_sucursal";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute();
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_equipos($sucursal) {
        $params = [];
        $dataEmpr = $this->empresa();
        $sql = "SELECT i.*, c.id_cliente, c.cedula_encargado, c.nombre_empresa 
                FROM inventario_equipos i 
                LEFT JOIN clientes c ON i.id_cliente = c.id_cliente";
        if ($dataEmpr->sucursales > 0) {
            $sql .= " WHERE c.sucursales LIKE :sucursal";
            $params['sucursal'] = "%|$sucursal|%";
        }
        $sql .= " ORDER BY i.id_equipo DESC"; // Siempre incluir el ORDER BY
        $sentencia = $this->cnn->prepare($sql);
        $sentencia->execute($params);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public function listado_equipos_clientes( $id ) {
        $sql = "SELECT i.*, c.id_cliente, c.cedula_encargado , c.nombre FROM inventario_equipos i LEFT JOIN clientes c ON i.id_cliente = c.id_cliente where i.id_cliente=:id_cliente ORDER BY i.id_equipo DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id_cliente'=>$id] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function encuesta_orden( $id_orden ) {
        $sql = "SELECT cod_orden, encuesta, estado FROM ordenes_servicio WHERE id_orden=:id_orden AND estado=:estado";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_orden' => $id_orden,
            'estado' => 'finalizado'
        ] );
        $resultado = $sentencia->fetch( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function grabar_encuesta( $id_orden, $encuesta ) {
        $sql = "UPDATE ordenes_servicio SET encuesta=:encuesta WHERE id_orden=:id_orden";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_orden' => $id_orden,
            'encuesta' => $encuesta
        ] );
        return $this->cnn->lastInsertId();
    }
    
    public function grabar_mensajeros( $id_orden, $mensajero ) {
        $sql = "UPDATE ordenes_servicio SET id_mensajero=:id_mensajero, fecha_mensajero=NOW() WHERE id_orden=:id_orden";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_orden' => $id_orden,
            'id_mensajero' => $mensajero
        ] );
        return $this->cnn->lastInsertId();
    }

    public function orden( $id_orden ) {
        $sql = "SELECT o.*, DATE_SUB(o.fecha, INTERVAL 5 HOUR) as fecha, e.nombre as 'empleado', c.id_cliente, c.nit_empresa , c.nombre_empresa, c.cedula_encargado, concat(c.nit_empresa, ' - ', c.nombre_empresa) as data_empr, c.nombre, i.tipo_equipo, i.modelo2, i.marca, m.nombre AS nombre_mensajero, m.celular AS celular_mensajero, DATE_SUB(o.fecha_mensajero, INTERVAL 5 HOUR) AS fecha_mensajero FROM ordenes_servicio o LEFT JOIN clientes c ON o.id_cliente = c.id_cliente LEFT JOIN inventario_equipos i ON o.id_equipo = i.id_equipo LEFT JOIN empleados e ON o.id_usuario = e.id_usuario LEFT JOIN mensajeros m ON o.id_mensajero = m.id_mensajero WHERE o.id_orden=:id_orden";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id_orden' => $id_orden] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_ordenes( $sucursal ) {
        $sql = "SELECT o.*, DATE_SUB(o.fecha, INTERVAL 5 HOUR) as fecha, e.nombre as 'empleado', c.id_cliente, c.nit_empresa , c.nombre_empresa, concat(c.nit_empresa, ' - ', c.nombre_empresa) as data_empr,  c.cedula_encargado , c.nombre, i.tipo_equipo, i.modelo2, i.marca, m.nombre AS nombre_mensajero, m.celular AS celular_mensajero, DATE_SUB(o.fecha_mensajero, INTERVAL 5 HOUR) AS fecha_mensajero FROM ordenes_servicio o LEFT JOIN clientes c ON o.id_cliente = c.id_cliente LEFT JOIN inventario_equipos i ON o.id_equipo = i.id_equipo LEFT JOIN empleados e ON o.id_usuario = e.id_usuario LEFT JOIN mensajeros m ON o.id_mensajero = m.id_mensajero WHERE o.id_sucursal=:sucursal AND o.estado!=:estado ORDER BY o.id_orden DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'sucursal' => $sucursal,
            'estado' => "eliminado"
        ] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }
    
    public function existen_salidas_orden( $id_orden ) {
        $sql = "SELECT COUNT(*) as total FROM salida_productos WHERE id_orden = ?";
        $stmt = $this->cnn->prepare($sql);
        $stmt->execute([$id_orden]);
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        return $resultado->total > 0;
    }
    
    public function lista_reingreso( $id, $id2 ) {
        $sql = "SELECT o.*, DATE_SUB(o.fecha, INTERVAL 5 HOUR) as fecha, e.nombre as 'empleado', c.id_cliente, c.nit_empresa , c.nombre_empresa, concat(c.nit_empresa, ' - ', c.nombre_empresa) as data_empr,  c.cedula_encargado , c.nombre, i.tipo_equipo, i.modelo2, i.marca FROM ordenes_servicio o LEFT JOIN clientes c ON o.id_cliente = c.id_cliente LEFT JOIN inventario_equipos i ON o.id_equipo = i.id_equipo LEFT JOIN empleados e ON o.id_usuario = e.id_usuario WHERE i.id_equipo=:id_equipo AND o.id_orden!=:id_orden AND o.posicion>=:posicion";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_equipo'=> $id,
            'id_orden' => $id2,
            'posicion' => "5"
        ] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_sucursales() {
        $sql = "SELECT * FROM sucursales";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute();
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function listado_caja_generales( $sucursal ) {
        $sql = "SELECT c.*, CONCAT_WS(' ', em.nombre , em.apellido ) as 'usuario', cl.nombre FROM caja c LEFT JOIN empleados em ON c.id_usuario = em.id_usuario LEFT JOIN clientes cl ON c.id_cliente = cl.id_cliente WHERE c.id_sucursal=:sucursal ORDER BY c.id_caja DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['sucursal' => $sucursal] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function agregar_equipo( Equipo $equipo ) {
        $sql = "iNSERT INTO inventario_equipos (id_cliente,codigo_interno,tipo_equipo,modelo,modelo2,marca,serie,imagen,descripcion,estado) 
                VALUES (:id_cliente,:codigo_interno,:tipo_equipo,:modelo,:modelo2,:marca,:serie,:imagen,:descripcion,:estado)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_cliente' => $equipo->getId_cliente(),
            'codigo_interno' => $equipo->getCodigo_interno(),
            'tipo_equipo' => $equipo->getTipo_equipo(),
            'modelo' => $equipo->getModelo(),
            'modelo2' => $equipo->getModelo2(),
            'marca' => $equipo->getMarca(),
            'serie' => $equipo->getSerie(),
            'imagen' => $equipo->getImagen(),
            'descripcion' => $equipo->getDescripcion(),
            'estado' => $equipo->getEstado(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_equipo( Equipo $equipo ) {
        $sql = "UPDATE inventario_equipos SET id_cliente=:id_cliente, codigo_interno=:codigo_interno, tipo_equipo=:tipo_equipo, modelo=:modelo, modelo2=:modelo2, marca=:marca, serie=:serie, imagen=:imagen, descripcion=:descripcion, estado=:estado WHERE id_equipo=:id_equipo";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_cliente' => $equipo->getId_cliente(),
            'codigo_interno' => $equipo->getCodigo_interno(),
            'tipo_equipo' => $equipo->getTipo_equipo(),
            'modelo' => $equipo->getModelo(),
            'modelo2' => $equipo->getModelo2(),
            'marca' => $equipo->getMarca(),
            'serie' => $equipo->getSerie(),
            'imagen' => $equipo->getImagen(),
            'descripcion' => $equipo->getDescripcion(),
            'estado' => $equipo->getEstado(),
            'id_equipo' => $equipo->getId_equipo()
        ] );
        return $this->cnn->lastInsertId();
    }

    public function agregar_cliente( Cliente $cliente ) {
        $sql = "INSERT INTO clientes (nombre_empresa,nit_empresa,direccion_empresa,correo_electronico,clave,nombre,telefono_encargado,telefono2_encargado,cedula_encargado,nombre_representante,telefono_representante,correo_representante,servicios_aprobados, estado, sucursales) 
                VALUES (:nombre_empresa,:nit_empresa,:direccion_empresa,:correo_electronico,:clave,:nombre,:telefono_encargado,:telefono2_encargado,:cedula_encargado,:nombre_representante,:telefono_representante,:correo_representante,:servicios_aprobados,:estado,:sucursales)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre_empresa' => $cliente->getNombre_empresa(),
            'nit_empresa' => $cliente->getNit_empresa(),
            'direccion_empresa' => $cliente->getDireccion_empresa(),
            'correo_electronico' => $cliente->getCorreo_electronico(),
            'clave' => $cliente->getClave(),
            'nombre' => $cliente->getNombre_encargado(),
            'telefono_encargado' => $cliente->getTelefono_encargado(),
            'telefono2_encargado' => $cliente->getTelefono2_encargado(),
            'cedula_encargado' => $cliente->getCedula_encargado(),
            'nombre_representante' => $cliente->getNombre_representante(),
            'telefono_representante' => $cliente->getTelefono_representante(),
            'correo_representante' => $cliente->getCorreo_representante(),
            'servicios_aprobados' => $cliente->getServicios_aprobados(),
            'estado' => "Activo",
            'sucursales' => $cliente->getSucursales(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_cliente( Cliente $cliente ) {
        $sql = "UPDATE clientes SET nombre_empresa=:nombre_empresa, nit_empresa=:nit_empresa, direccion_empresa=:direccion_empresa, correo_electronico=:correo_electronico, clave=:clave, nombre=:nombre, telefono_encargado=:telefono_encargado, telefono2_encargado=:telefono2_encargado, cedula_encargado=:cedula_encargado, nombre_representante=:nombre_representante, telefono_representante=:telefono_representante, correo_representante=:correo_representante, servicios_aprobados=:servicios_aprobados, estado=:estado, sucursales=:sucursales WHERE id_cliente=:id_cliente";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre_empresa' => $cliente->getNombre_empresa(),
            'nit_empresa' => $cliente->getNit_empresa(),
            'direccion_empresa' => $cliente->getDireccion_empresa(),
            'correo_electronico' => $cliente->getCorreo_electronico(),
            'clave' => $cliente->getClave(),
            'nombre' => $cliente->getNombre_encargado(),
            'telefono_encargado' => $cliente->getTelefono_encargado(),
            'telefono2_encargado' => $cliente->getTelefono2_encargado(),
            'cedula_encargado' => $cliente->getCedula_encargado(),
            'nombre_representante' => $cliente->getNombre_representante(),
            'telefono_representante' => $cliente->getTelefono_representante(),
            'correo_representante' => $cliente->getCorreo_representante(),
            'servicios_aprobados' => $cliente->getServicios_aprobados(),
            'estado' => $cliente->getEstado(),
            'sucursales' => $cliente->getSucursales(),
            'id_cliente' => $cliente->getId_cliente(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function agregar_empleado( Usuario $usuario ) {
        $sql = "iNSERT INTO empleados (cedula,nombre,apellido,clave,estado,correo_electronico,privilegio,servicios_aprobados,sucursales) 
                VALUES (:cedula,:nombre,:apellido,:clave,:estado,:correo_electronico,:privilegio,:servicios_aprobados,:sucursales)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'cedula' => $usuario->getCedula(),
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'clave' => $usuario->getClave(),
            'estado' => $usuario->getEstado(),
            'correo_electronico' => $usuario->getCorreo_electronico(),
            'privilegio' => $usuario->getPrivilegio(),
            'servicios_aprobados' => $usuario->getServicios_aprobados(),
            'sucursales' => $usuario->getSucursales(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_empleado( Usuario $usuario ) {
        $sql = "UPDATE empleados SET cedula=:cedula, nombre=:nombre, apellido=:apellido, clave=:clave, estado=:estado, correo_electronico=:correo_electronico, privilegio=:privilegio, servicios_aprobados=:servicios_aprobados, sucursales=:sucursales WHERE id_usuario=:id_usuario";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'cedula' => $usuario->getCedula(),
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'clave' => $usuario->getClave(),
            'estado' => $usuario->getEstado(),
            'correo_electronico' => $usuario->getCorreo_electronico(),
            'privilegio' => $usuario->getPrivilegio(),
            'servicios_aprobados' => $usuario->getServicios_aprobados(),
            'sucursales' => $usuario->getSucursales(),
            'id_usuario' => $usuario->getId_usuario(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function agregar_entrada( Entradas $entrada ) {
        $sql = "iNSERT INTO entradas_productos (cant_entrada,precio_compra, stock, id_productos,id_usuario,id_sucursal) 
                VALUES (:cant_entrada,:precio_compra, :stock, :id_productos,:id_usuario,:id_sucursal)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'cant_entrada' => $entrada->getCant_entrada(),
            'precio_compra' => $entrada->getPrecio_compra(),
            'stock' => $entrada->getStock(),
            'id_productos' => $entrada->getId_productos(),
            'id_usuario' => $entrada->getId_usuario(),
            'id_sucursal' => $entrada->getId_sucursal(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function actualizar_stock_producto( $stock_nuevo, $id_productos ) {
        $sql = "UPDATE productos SET stock_existente=:cant_entrada WHERE id_productos=:id_productos";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'cant_entrada' => $stock_nuevo,
            'id_productos' => $id_productos,
        ] );
        return $this->cnn->lastInsertId();
    }

    public function obtener_stock_producto($id_productos) {
        $sql = "SELECT stock_existente FROM productos WHERE id_productos =:id_productos LIMIT 1";
        $sentencia = $this->cnn->prepare($sql);
        $sentencia->execute(['id_productos' => $id_productos]);
        $resultado = $sentencia->fetch( PDO::FETCH_OBJ );
        return $resultado ? (float)$resultado->stock_existente : 0;
    }

    public function agregar_ubicacion( Ubicacion $ubicacion ) {
        $sql = "iNSERT INTO ubicacion (tipo_ubicacion,numeracion,descripcion,id_sucursal) 
                VALUES (:tipo_ubicacion,:numeracion,:descripcion,:id_sucursal)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'tipo_ubicacion' => $ubicacion->getTipo_ubicacion(),
            'numeracion' => $ubicacion->getNumeracion(),
            'descripcion' => $ubicacion->getDescripcion(),
            'id_sucursal' => $ubicacion->getId_sucursal(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_ubicacion( Ubicacion $ubicacion ) {
        $sql = "UPDATE ubicacion SET tipo_ubicacion=:tipo_ubicacion, numeracion=:numeracion, descripcion=:descripcion, id_sucursal=:id_sucursal WHERE id_ubicacion=:id_ubicacion";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'tipo_ubicacion' => $ubicacion->getTipo_ubicacion(),
            'numeracion' => $ubicacion->getNumeracion(),
            'descripcion' => $ubicacion->getDescripcion(),
            'id_sucursal' => $ubicacion->getId_sucursal(),
            'id_ubicacion' => $ubicacion->getId_ubicacion(),
        ] );
        return $this->cnn->lastInsertId();
    }

    //Proveedor

    public function agregar_proveedor( Proveedores $proveedor ) {
        $sql = "iNSERT INTO proveedor (nombre_proveedor,nombre_contacto,telefono_contacto,correo_electronico,nit) 
                VALUES (:nombre_proveedor,:nombre_contacto,:telefono_contacto,:correo_electronico,:nit)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre_proveedor' => $proveedor->getNombre_proveedor(),
            'nombre_contacto' => $proveedor->getNombre_contacto(),
            'telefono_contacto' => $proveedor->getTelefono_contacto(),
            'correo_electronico' => $proveedor->getCorreo_electronico(),
            'nit' => $proveedor->getNit(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_proveedor( Proveedores $proveedor ) {
        $sql = "UPDATE proveedor SET nombre_proveedor=:nombre_proveedor, nombre_contacto=:nombre_contacto, telefono_contacto=:telefono_contacto, correo_electronico=:correo_electronico, nit=:nit WHERE id_proveedor=:id_proveedor";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre_proveedor' => $proveedor->getNombre_proveedor(),
            'nombre_contacto' => $proveedor->getNombre_contacto(),
            'telefono_contacto' => $proveedor->getTelefono_contacto(),
            'correo_electronico' => $proveedor->getCorreo_electronico(),
            'nit' => $proveedor->getNit(),
            'id_proveedor' => $proveedor->getId_proveedor(),
        ] );
        return $this->cnn->lastInsertId();
    }

    //Productos

    public function agregar_producto( Productos $productos ) {
        $sql = "iNSERT INTO productos (codigo_producto,nombre_producto,marca,precio_compra,precio_venta,modelo,stock_existente,stock_min,imagen_producto,id_proveedor,id_ubicacion,id_usuario,id_sucursal,tipo,iva) 
                VALUES (:codigo_producto,:nombre_producto,:marca,:precio_compra,:precio_venta,:modelo,:stock_existente,:stock_min,:imagen_producto,:id_proveedor,:id_ubicacion,:id_usuario,:id_sucursal,:tipo,:iva)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'codigo_producto' => $productos->getCodigo_producto(),
            'nombre_producto' => $productos->getNombre_producto(),
            'marca' => $productos->getMarca(),
            'precio_compra' => $productos->getPrecio_compra(),
            'precio_venta' => $productos->getPrecio_venta(),
            'modelo' => $productos->getModelo(),
            'stock_existente' => $productos->getStock_existente(),
            'stock_min' => $productos->getStock_min(),
            'imagen_producto' => $productos->getImagen_producto(),
            'id_proveedor' => $productos->getId_proveedor(),
            'id_ubicacion' => $productos->getId_ubicacion(),
            'id_usuario' => $productos->getId_usuario(),
            'id_sucursal' => $productos->getId_sucursal(),
            'tipo' => $productos->getTipo(),
            'iva' => $productos->getIva(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_producto( Productos $productos ) {
        $sql = "UPDATE productos SET codigo_producto=:codigo_producto, nombre_producto=:nombre_producto, marca=:marca, precio_compra=:precio_compra, precio_venta=:precio_venta, modelo=:modelo, stock_existente=:stock_existente, stock_min=:stock_min, id_proveedor=:id_proveedor, id_ubicacion=:id_ubicacion, tipo=:tipo, iva=:iva, imagen_producto=:imagen_producto WHERE id_productos=:id_productos";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'codigo_producto' => $productos->getCodigo_producto(),
            'nombre_producto' => $productos->getNombre_producto(),
            'marca' => $productos->getMarca(),
            'precio_compra' => $productos->getPrecio_compra(),
            'precio_venta' => $productos->getPrecio_venta(),
            'modelo' => $productos->getModelo(),
            'stock_existente' => $productos->getStock_existente(),
            'stock_min' => $productos->getStock_min(),
            'id_proveedor' => $productos->getId_proveedor(),
            'id_ubicacion' => $productos->getId_ubicacion(),
            'tipo' => $productos->getTipo(),
            'iva' => $productos->getIva(),
            'imagen_producto' => $productos->getImagen_producto(),
            'id_productos' => $productos->getId_producto()
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_precios( Productos $productos ) {
        $sql = "UPDATE productos SET  precio_compra=:precio_compra, precio_venta=:precio_venta WHERE id_productos=:id_productos";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'precio_compra' => $productos->getPrecio_compra(),
            'precio_venta' => $productos->getPrecio_venta(),
            'id_productos' => $productos->getId_producto()
        ] );
        return $this->cnn->lastInsertId();
    }

    //Sucursales

    public function agregar_sucursal( Sucursales $sucursal ) {
        $sql = "iNSERT INTO sucursales (nombre,direccion,descripcion,estado,id_usuario) 
                VALUES (:nombre,:direccion,:descripcion,:estado,:id_usuario)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre' => $sucursal->getNombre(),
            'direccion' => $sucursal->getDireccion(),
            'descripcion' => $sucursal->getDescripcion(),
            'estado' => $sucursal->getEstado(),
            'id_usuario' => $sucursal->getId_usuario(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_sucursal( Sucursales $sucursal ) {
        $sql = "UPDATE sucursales SET nombre=:nombre, direccion=:direccion, descripcion=:descripcion, estado=:estado, id_usuario=:id_usuario WHERE id_sucursal=:id_sucursal";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre' => $sucursal->getNombre(),
            'direccion' => $sucursal->getDireccion(),
            'descripcion' => $sucursal->getDescripcion(),
            'estado' => $sucursal->getEstado(),
            'id_usuario' => $sucursal->getId_usuario(),
            'id_sucursal' => $sucursal->getId_sucursal(),
        ] );
        return $this->cnn->lastInsertId();
    }

    //Salidas

    public function consultar_salidas_orden( Salidas $salidas ) {
        $sql = "SELECT id_salida FROM salida_productos WHERE id_orden =:id_orden AND id_productos =:id_productos";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_orden' => $salidas->getId_orden(),
            'id_productos' => $salidas->getId_productos(),
        ] );
        $resultado = $sentencia->fetch( PDO::FETCH_OBJ );
        return $resultado;
    }

    public function agregar_salidas( Salidas $salidas ) {
        $sql = "iNSERT INTO salida_productos (cant_salida,precio_venta,iva,descuento,salida,stock,id_productos,id_usuario,id_orden,id_caja,id_sucursal) 
                VALUES (:cant_salida,:precio_venta,:iva,:descuento,:salida,:stock,:id_productos,:id_usuario,:id_orden,:id_caja,:id_sucursal)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'cant_salida' => $salidas->getCant_salida(),
            'precio_venta' => $salidas->getPrecio_venta(),
            'iva' => $salidas->getIva(),
            'descuento' => $salidas->getDescuento(),
            'salida' => $salidas->getSalida(),
            'stock' => $salidas->getStock(),
            'id_productos' => $salidas->getId_productos(),
            'id_usuario' => $salidas->getId_usuario(),
            'id_orden' => $salidas->getId_orden(),
            'id_caja' => $salidas->getId_caja(),
            'id_sucursal' => $salidas->getId_sucursal(),
        ] );
        return $this->cnn->lastInsertId();
    }

    //Caja

    public function agregar_caja( Caja $caja ) {
        $sql = "iNSERT INTO caja (cod_caja,id_cliente,id_usuario,id_sucursal,tabla_productos,pago) 
                VALUES (:cod_caja,:id_cliente,:id_usuario,:id_sucursal,:tabla_productos,:pago)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'cod_caja' => $caja->getCod_caja(),
            'id_cliente' => $caja->getId_cliente(),
            'id_usuario' => $caja->getId_usuario(),
            'id_sucursal' => $caja->getId_sucursal(),
            'tabla_productos' => $caja->getTabla_productos(),
            'pago' => $caja->getPago(),
        ] );
        return $this->cnn->lastInsertId();
    }

    //Ordenes de servicio

    public function agregar_orden( Ordenes $ordenes ) {
        $sql = "INSERT INTO ordenes_servicio (id_cliente,id_equipo,id_usuario,id_sucursal,cod_orden,tipo_atencion,atencion_texto,observacion,diagnostico,notas,tabla_cotizacion,fecha_final,imagenes,imagen_diagnostico,imagenes_final,nota_final,posicion,estado,tiempos,notita,reparado,estado_cotizacion,abonos) VALUES (:id_cliente,:id_equipo,:id_usuario,:id_sucursal,(SELECT COALESCE(MAX( a.cod_orden ), 0) + 1 FROM ordenes_servicio a WHERE a.id_sucursal=:id_sucursal),:tipo_atencion,:atencion_texto,:observacion,:diagnostico,:notas,:tabla_cotizacion,:fecha_final,:imagenes,:imagen_diagnostico,:imagenes_final,:nota_final,:posicion,:estado,:tiempos,:notita,:reparado,:estado_cotizacion,:abonos)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_cliente' => $ordenes->getId_cliente(),
            'id_equipo' => $ordenes->getId_equipo(),
            'id_usuario' => $ordenes->getId_usuario(),
            'id_sucursal' => $ordenes->getId_sucursal(),
            'tipo_atencion' => $ordenes->getTipo_atencion(),
            'atencion_texto' => $ordenes->getAtencion_texto(),
            'observacion' => $ordenes->getObservacion(),
            'diagnostico' => $ordenes->getDiagnostico(),
            'notas' => $ordenes->getNotas(),
            'tabla_cotizacion' => $ordenes->getTabla_cotizacion(),
            'fecha_final' => $ordenes->getFecha_final(),
            'imagenes' => $ordenes->getImagenes(),
            'imagen_diagnostico' => $ordenes->getImagen_diagnostico(),
            'imagenes_final' => $ordenes->getImagenes_final(),
            'nota_final' => $ordenes->getNota_final(),
            'posicion' => $ordenes->getPosicion(),
            'estado' => $ordenes->getEstado(),
            'tiempos' => $ordenes->getTiempos(),
            'notita' => $ordenes->getNotita(),
            'reparado' => $ordenes->getReparado(),
            'estado_cotizacion' => $ordenes->getEstado_cotizacion(),
            'abonos' => $ordenes->getAbonos(),
        ] );
        return $this->cnn->lastInsertId();
    }

    public function editar_orden( Ordenes $ordenes ) {
        $sql = "UPDATE ordenes_servicio SET id_cliente=:id_cliente, id_equipo=:id_equipo, id_mensajero=:id_mensajero, tipo_atencion=:tipo_atencion, atencion_texto=:atencion_texto, observacion=:observacion, diagnostico=:diagnostico, notas=:notas, tabla_cotizacion=:tabla_cotizacion, fecha_final=:fecha_final, imagenes=:imagenes, imagen_diagnostico=:imagen_diagnostico, imagenes_final=:imagenes_final, nota_final=:nota_final, posicion=:posicion, estado=:estado, tiempos=:tiempos, notita=:notita, reparado=:reparado, estado_cotizacion=:estado_cotizacion, abonos=:abonos, historial=:historial, fecha_mensajero = CASE WHEN :id_mensajero IS NOT NULL AND :id_mensajero <> '' THEN NOW() ELSE NULL END WHERE id_orden=:id_orden";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_cliente' => $ordenes->getId_cliente(),
            'id_equipo' => $ordenes->getId_equipo(),
            'id_mensajero' => $ordenes->getId_mensajero(),
            'tipo_atencion' => $ordenes->getTipo_atencion(),
            'atencion_texto' => $ordenes->getAtencion_texto(),
            'observacion' => $ordenes->getObservacion(),
            'diagnostico' => $ordenes->getDiagnostico(),
            'notas' => $ordenes->getNotas(),
            'tabla_cotizacion' => $ordenes->getTabla_cotizacion(),
            'fecha_final' => $ordenes->getFecha_final(),
            'imagenes' => $ordenes->getImagenes(),
            'imagen_diagnostico' => $ordenes->getImagen_diagnostico(),
            'imagenes_final' => $ordenes->getImagenes_final(),
            'nota_final' => $ordenes->getNota_final(),
            'posicion' => $ordenes->getPosicion(),
            'estado' => $ordenes->getEstado(),
            'tiempos' => $ordenes->getTiempos(),
            'notita' => $ordenes->getNotita(),
            'reparado' => $ordenes->getReparado(),
            'estado_cotizacion' => $ordenes->getEstado_cotizacion(),
            'abonos' => $ordenes->getAbonos(),
            'historial' => $ordenes->getHistorial(),
            'id_orden' => $ordenes->getId_orden()
        ] );
        return $ordenes->getId_orden();
    }

    public function agregar_marcas( $Datos ) {
        $sql = "iNSERT INTO marcas (nombre, palabras, estado) 
                VALUES (:nombre, :palabras, :estado)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre' => $Datos["nombre"],
            'palabras' => $Datos["extra"],
            'estado' => $Datos["estado"],
        ] );
        return $this->cnn->lastInsertId();
    }
    
    public function agregar_mensajeros( $Datos ) {
        $sql = "iNSERT INTO mensajeros (nombre, celular) 
                VALUES (:nombre, :celular)";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'nombre' => $Datos["nombre"],
            'celular' => $Datos["extra"],
        ] );
        return $this->cnn->lastInsertId();
    }

    public function iniciarSesion( $usuario, $clave, $tipo ) {
        $sql = "SELECT * FROM {$tipo} WHERE correo_electronico=:usuario AND clave=:clave";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['usuario'=>$usuario, 'clave'=>$clave] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        if ( empty( $resultado ) ) {
            throw new ValidacionExcepcion( 'ERROR: Usuario/Contraseña no es valido', -1 );
        }
        return $resultado[0];
    }

    public function sesion( $id_usuario, $tipo ) {
        $tablasPermitidas = ['clientes', 'empleados'];
        // Validar que $tipo esté en la lista
        if (!in_array($tipo, $tablasPermitidas)) {
            throw new Exception("Error!");
        }
        $sql = "SELECT * FROM {$tipo} WHERE id_usuario=:id_usuario";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['id_usuario'=>$id_usuario] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado[0];
    }

    public function validar_correo( $tabla, $correo ) {
        $sql = "SELECT estado FROM {$tabla} WHERE correo_electronico=:correo";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( ['correo'=>$correo] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        if ( $resultado ) {
            throw new ValidacionExcepcion( 'ERROR: Correo ya registrado, por favor comuníquese con el administrador', -1 );
        }
        return $resultado;
    }

    //Clientes

    public function clientes_ordenes( $id_cliente ) {
        $sql = "SELECT o.*, DATE_SUB(o.fecha, INTERVAL 5 HOUR) as fecha, e.nombre as 'empleado', c.id_cliente, c.nit_empresa , c.nombre_empresa, concat(c.nit_empresa, ' - ', c.nombre_empresa) as data_empr,  c.cedula_encargado , c.nombre, i.tipo_equipo, i.modelo, i.marca FROM ordenes_servicio o LEFT JOIN clientes c ON o.id_cliente = c.id_cliente LEFT JOIN inventario_equipos i ON o.id_equipo = i.id_equipo LEFT JOIN empleados e ON o.id_usuario = e.id_usuario WHERE o.id_cliente=:id_cliente AND o.estado!=:estado ORDER BY o.id_orden DESC";
        $sentencia = $this->cnn->prepare( $sql );
        $sentencia->execute( [
            'id_cliente' => $id_cliente,
            'estado' => "eliminado"
        ] );
        $resultado = $sentencia->fetchAll( PDO::FETCH_OBJ );
        return $resultado;
    }
    
    //correo

    public function mensaje( $datos, $email, $ehtml ) {
        try {
           $mail = $email;
            $mail->isSMTP();
            $mail->Host = $datos["host"];
            $mail->Port = $datos["port"];
            $mail->SMTPSecure = $datos["secure"];
            $mail->SMTPAuth = $datos["SMTPAuth"];
            $mail->Username = $datos["username"];
            $mail->Password = $datos["password"];
            $mail->setFrom( $datos["setfrom"], $datos["titulo"] );
            $mail->addAddress( $datos["address"] );
            $mail->Subject = $datos["titulo"];
            $mail->msgHTML( $datos["msgHTML"], __DIR__ ) . $datos["address"];
            $mail->AltBody = 'Mensaje alterno';
            $mail->SMTPOptions = array(
                'ssl' => [
                    'verify_peer' => false,
                    'verify_depth' => false,
                    'allow_self_signed' => true,
                ],
            );
            //Verificar y adjuntar si hay base64 de PDF
            if (!empty($ehtml)) {
                $contenido = base64_decode($ehtml);
                $nombre = "orden_servicio.pdf";
                $mail->addStringAttachment($contenido, $nombre, 'base64', 'application/pdf');
            }
            if ( !$mail->send() ) {
                throw new ValidacionExcepcion( 'Error: No se pudo enviar, intentalo mas tarde', -1 );
            }
        } catch (Exception $e) {
            throw new ValidacionExcepcion('Excepción al enviar correo: ' . $e->getMessage(), -1);
        }
        
    }

}
