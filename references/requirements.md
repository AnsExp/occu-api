## Checklist de Cumplimiento del Sistema

### 1. **Gestión de Información**
- [ ] Clasificar la información en: pública, interna, confidencial, crítica de salud.  
- [ ] Definir responsables de cada tipo de información.  
- [x] Garantizar trazabilidad y registro de accesos.  
    - Si el acceso falla, se marca la hora del intento en la tabla de metadatos con la clave `last_failed_login`. En caso de ser un inteno exitoso, marca en la misma tabla con la clave `last_succesful_login`.
- [ ] Implementar cifrado en datos sensibles.  
- [ ] Establecer políticas de eliminación segura de datos y equipos.

### 2. **Accesos y Roles**
- [x] Asignar credenciales únicas a cada usuario.  
    - Los usuarios se identifican con su correo, un dato que garantiza unicidad.
- [ ] Aplicar principio de mínimo privilegio.  
- [ ] Configurar autenticación multifactor.  
- [ ] Registrar altas y bajas de personal en coordinación con Talento Humano.  
- [ ] Mantener bitácora de accesos y cambios.

### 3. **Uso de Dispositivos y Correo**
- [-] Controlar uso de memorias USB (solo autorizadas).  
    - Implementar un proxy en las maquinas para evitar el acceso a cualquier otra red que no sea la api de la empresa. Implementar control de memoria USB.
- [ ] Restringir envío de información sensible por correo electrónico.  
- [ ] Implementar filtros de seguridad en correo institucional.  

### 4. **Respaldos y Recuperación**
- [ ] Realizar respaldos diarios de información crítica.  
- [ ] Almacenar respaldos en ubicación segura (física y/o nube).  
- [ ] Probar restauración de respaldos al menos cada trimestre.  
- [ ] Mantener bitácora de respaldos y restauraciones.  

### 5. **Mantenimiento de Infraestructura**
- [ ] Ejecutar mantenimiento preventivo de hardware según cronograma.  
- [ ] Realizar mantenimiento correctivo ante fallos.  
- [ ] Usar software con licencias vigentes y actualizaciones periódicas.  
- [ ] Documentar inventario de activos tecnológicos.  

### 6. **Seguridad Informática**
- [x] Configurar listas blancas de IP para accesos críticos.  
    - Lista blancas de IP en la base de datos.
- [ ] Instalar y actualizar antivirus en todos los equipos.  
- [x] Monitorear intentos de acceso no autorizado.  
    - Permitir 5 intentos de inicia de sesión. despues de eso, se marca la columna `blocked_at` en la base de datos. Además, los intentos fallidos se registrarán en una tabla en la base de datos.
- [ ] Definir protocolo de gestión de incidentes de seguridad.  
- [ ] Registrar y reportar incidentes con formato estandarizado.  

### 7. **Gestión de Incidentes**
- [x] Establecer canal de comunicación con Gerencia en caso de incidentes.  
    - Comunicación vía correo electrónico.
- [ ] Documentar cada incidente en formato oficial.  
- [ ] Implementar medidas de contención en menos de 24 horas.  
- [ ] Evaluar impacto y acciones correctivas posteriores.  

### 8. **Normativa y Auditoría**
- [ ] Cumplir con requisitos de ISO 9001:2015.  
- [ ] Realizar auditorías internas periódicas.  
- [ ] Mantener control documental (versiones vigentes y obsoletas).  
- [ ] Asegurar distribución controlada del instructivo.  

### 9. **Indicadores de Gestión**
- [ ] Medir porcentaje de accesos bloqueados correctamente.  
- [ ] Medir éxito de respaldos y restauraciones.  
- [ ] Medir tiempo promedio de contención de incidentes.  
