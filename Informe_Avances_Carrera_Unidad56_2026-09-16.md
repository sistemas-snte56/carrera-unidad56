# Sistema de Registro – 1ra Carrera Atlética del Educador Físico

## Informe de avances
**Fecha de corte:** 16 de septiembre de 2026  
**Proyecto:** Carrera Unidad 56  
**Institución:** SNTE Sección 56 – Veracruz

---

## 1. Objetivo del sistema

Se desarrolló un sistema web para administrar el registro de participantes de la **1ra Carrera Atlética del Educador Físico**, con el propósito de centralizar y facilitar:

- Registro público de participantes.
- Captura de información personal y deportiva.
- Identificación de participantes agremiados y público en general.
- Selección de región y delegación para participantes agremiados.
- Recepción digital de documentación.
- Generación automática de folio.
- Asignación de número de corredor.
- Confirmación automática por correo electrónico.
- Generación de acuse de registro en PDF.
- Código QR para consulta del registro.
- Consulta pública del estatus del registro.
- Administración de participantes mediante un panel interno.

---

## 2. Características generales

### Modalidades de participación

El sistema contempla:

- **Agremiado**
- **Público en general**

Para los participantes agremiados se solicita:

**Región → Delegación**

El sistema conserva la relación con la delegación y obtiene la región mediante dicha relación.

### Distancias

- 3K
- 5K
- 10K

### Rama

- Femenil
- Varonil

No se manejan categorías por edad. La edad se calcula automáticamente a partir de la fecha de nacimiento.

---

## 3. Flujo general de registro

El proceso actualmente funciona de la siguiente manera:

```text
Participante
     │
     ▼
Formulario público
     │
     ├── Datos personales
     ├── Fecha de nacimiento
     ├── Rama
     ├── Distancia
     ├── Tipo de corredor
     │
     ├── Si es agremiado
     │      └── Región → Delegación
     │
     ├── Correo electrónico
     ├── Teléfono
     ├── INE / credencial
     └── Comprobante de pago
     │
     ▼
Validación de información
     │
     ▼
Registro en base de datos
     │
     ├── Folio automático
     ├── Número de corredor
     ├── Token único
     └── Estatus: Pendiente
     │
     ▼
Correo de confirmación
     │
     ▼
Acuse PDF + Código QR
     │
     ▼
Consulta pública del registro
```

---

## 4. Folio y número de corredor

Al concluir un registro, el sistema genera automáticamente:

### Folio

Formato:

```text
CAR-2026-XXXXXX
```

Ejemplo:

```text
CAR-2026-IEWLLN
```

El folio es único para cada participante.

### Número de corredor

El número es global y consecutivo.

La presentación al participante utiliza cinco dígitos:

```text
00001
00002
00003
...
```

El número no depende de la distancia, rama, región o tipo de participante.

---

## 5. Acuse de registro

Una vez registrado el participante, el sistema genera un **acuse en formato PDF**.

El documento contiene información relevante del registro, incluyendo:

- Nombre del participante.
- Edad.
- Rama.
- Distancia.
- Tipo de corredor.
- Número de corredor.
- Folio.
- Fecha de registro.
- Estatus actual.
- Código QR.

El código QR dirige a la consulta pública del registro.

---

## 6. Consulta pública

Cada participante cuenta con un identificador único para consultar su registro.

La consulta permite visualizar información como:

- Folio.
- Nombre.
- Edad.
- Rama.
- Distancia.
- Tipo de corredor.
- Región y delegación, cuando corresponde.
- Número de corredor.
- Fecha de registro.
- Estatus actual.

La consulta no requiere que el participante tenga una cuenta o contraseña.

---

## 7. Código QR

El QR incluido en el acuse permite consultar directamente el registro.

La dirección asociada al QR utiliza un **token único**, en lugar de exponer directamente el identificador interno de la base de datos.

Esto permite separar el identificador público de los identificadores internos utilizados por el sistema.

---

## 8. Documentación digital

El sistema permite cargar:

- INE o credencial de elector.
- Comprobante de pago.

Formatos permitidos:

- JPG
- JPEG
- PNG
- PDF

Tamaño máximo:

**5 MB por archivo.**

Los archivos se almacenan de manera privada y no se encuentran publicados directamente en una carpeta pública del sitio.

---

## 9. Protección de documentos

Se realizó una revisión específica del acceso a la documentación de los participantes.

Actualmente:

- El acceso a documentos requiere autenticación en el panel administrativo.
- Los enlaces de documentos utilizan URLs firmadas.
- Las firmas tienen una vigencia de 10 minutos.
- Si se modifica manualmente el identificador del participante en la URL, la firma deja de ser válida.
- En esa situación el sistema responde con:

```text
403 – Invalid signature
```

Esto evita que una URL válida de un documento pueda modificarse simplemente cambiando el identificador para intentar consultar otro documento.

La protección fue probada tanto para:

- INE / credencial.
- Comprobante de pago.

---

## 10. Correo electrónico automático

Al finalizar un registro, el sistema envía automáticamente un correo de confirmación.

El correo incluye:

- Confirmación del registro.
- Folio.
- Número de corredor.
- Rama.
- Distancia.
- Enlace para descargar el acuse.
- Enlace para consultar el registro.

La comunicación por correo electrónico fue probada exitosamente en el ambiente de producción.

**Observación:** durante las pruebas, uno de los mensajes de prueba llegó a la carpeta de correo no deseado (Spam). La entrega del correo funcionó, pero la configuración de entregabilidad puede revisarse posteriormente.

---

## 11. Panel administrativo

El sistema cuenta con un panel administrativo protegido mediante acceso de usuario.

Desde el panel se pueden administrar los participantes registrados y consultar su información.

Entre los datos disponibles se encuentran:

- Folio.
- Número de corredor.
- Datos personales.
- Fecha de nacimiento.
- Rama.
- Distancia.
- Tipo de corredor.
- Región / Delegación mediante la relación correspondiente.
- Correo.
- Teléfono.
- Documentación.
- Estatus.

Los documentos pueden abrirse desde el panel mediante enlaces protegidos.

---

## 12. Estatus del registro

Actualmente se contemplan los siguientes estados:

| Estatus | Descripción |
|---|---|
| Pendiente | Registro recibido y pendiente de validación |
| Validado | Registro validado administrativamente |
| Rechazado | Registro que no cumple con los criterios establecidos |

El estatus actual se refleja tanto en la consulta pública como en el acuse generado.

Esto permite que el participante consulte posteriormente el estado actualizado de su registro.

---

## 13. Tecnologías utilizadas

El sistema fue desarrollado utilizando:

- **Laravel 13**
- **PHP 8.3**
- **Filament**
- **Livewire**
- **MySQL**
- **Gmail SMTP**
- **DomPDF** para generación de documentos PDF
- **Simple Software QR Code** para generación de códigos QR
- **Git / GitHub** para control de versiones

La aplicación funciona en:

- Ambiente local de desarrollo.
- Ambiente de producción.

---

## 14. Ambiente de producción

El sistema se encuentra actualmente desplegado en:

**https://carrera.snte56.org.mx/**

El panel administrativo se encuentra disponible mediante la ruta administrativa correspondiente.

La aplicación ya fue probada directamente en producción.

---

## 15. Pruebas realizadas hasta el 16 de septiembre de 2026

Se han realizado pruebas funcionales de los principales componentes:

### Registro

- [x] Formulario público funcionando.
- [x] Registro de participantes.
- [x] Selección de distancia.
- [x] Selección de rama.
- [x] Selección de tipo de corredor.
- [x] Región y delegación para agremiados.
- [x] Carga de documentación.
- [x] Validación de archivos.

### Identificación

- [x] Generación automática de folio.
- [x] Generación de número de corredor.
- [x] Token único para consulta.

### Comunicación

- [x] Envío automático de correo.
- [x] Enlace al acuse.
- [x] Enlace de consulta.

### Documentos

- [x] Generación del acuse PDF.
- [x] Código QR.
- [x] Consulta mediante QR.
- [x] Acceso administrativo a INE.
- [x] Acceso administrativo a comprobante.
- [x] Protección mediante URL firmada.

### Consulta

- [x] Consulta pública.
- [x] Visualización del estatus.
- [x] Visualización del número de corredor.
- [x] Visualización de datos del participante.

### Producción

- [x] Aplicación desplegada.
- [x] Base de datos operativa.
- [x] Registro real realizado desde dispositivo móvil.
- [x] Correo real recibido.
- [x] Acuse generado correctamente.
- [x] QR probado.
- [x] Consulta pública probada.
- [x] Protección de documentos probada en producción.

---

## 16. Estado actual del proyecto

### Estado: OPERATIVO Y EN PRUEBAS FINALES

El sistema ya cuenta con el flujo principal completo:

```text
Registro
   ↓
Validación
   ↓
Folio + número de corredor
   ↓
Correo de confirmación
   ↓
Acuse PDF
   ↓
Código QR
   ↓
Consulta pública
   ↓
Administración
```

La aplicación se encuentra funcionando en producción y las principales funciones han sido verificadas mediante pruebas reales.

---

## 17. Control de versiones

El proyecto cuenta con control de versiones mediante Git.

La última modificación relacionada con seguridad fue registrada mediante el commit:

```text
bb90277
Protege acceso a documentos de participantes
```

Este cambio corresponde a la protección del acceso administrativo a los documentos de los participantes mediante autenticación y URLs firmadas.

---

## 18. Próximos pasos

Una vez concluida la etapa actual de pruebas, quedan como actividades de cierre:

1. Revisión final de configuración de producción.
2. Desactivar el modo de depuración (`APP_DEBUG=false`).
3. Establecer el ambiente como producción (`APP_ENV=production`).
4. Revisión final de entregabilidad del correo electrónico.
5. Pruebas finales de carga y operación.
6. Validación administrativa del proceso de registro.
7. Preparación para operación formal.

---

## 19. Conclusión

Al **16 de septiembre de 2026**, el sistema de registro de la **1ra Carrera Atlética del Educador Físico** cuenta con un flujo funcional completo y se encuentra operando en producción.

La plataforma permite realizar el registro desde un dispositivo con acceso a Internet, generar automáticamente la identificación del participante, enviar la confirmación por correo, emitir un acuse digital con código QR y consultar posteriormente el estado del registro.

Adicionalmente, se implementaron mecanismos de protección para la documentación digital proporcionada por los participantes, incluyendo autenticación administrativa, almacenamiento privado y URLs firmadas con vigencia limitada.

El proyecto se encuentra en una etapa de **pruebas finales y preparación para operación formal**.
