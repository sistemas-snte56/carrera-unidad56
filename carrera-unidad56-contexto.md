# Proyecto Carrera Unidad 56 — Contexto y guía de desarrollo

## Objetivo

Sistema web de registro para participantes de una carrera atlética, desarrollado como MVP rápido, práctico y seguro.

## Entorno

- Proyecto: `carrera-unidad56`
- Ruta: `C:\laragon\www\carrera-unidad56`
- URL pública: `http://carrera-unidad56.test/`
- Panel administrativo: `http://carrera-unidad56.test/admin`
- Laravel: 13.10.1
- PHP: 8.3.13
- Composer: 2.10.0
- Laragon / Windows
- MySQL/MariaDB
- Base de datos: `carrera_unidad56`
- Filament: 5
- Livewire instalado como dependencia

## Forma de trabajo

Trabajar paso a paso, una acción a la vez.

- No avanzar varias etapas simultáneamente.
- No improvisar ni asumir estructuras no comprobadas.
- Probar cada cambio antes de continuar.
- Si falta información importante, preguntar.
- Evitar archivos enormes o cambios innecesarios.
- Priorizar un MVP funcional.

## Acceso

### Público

El registro estará en `/`.

Los participantes NO tendrán cuenta ni inicio de sesión.

### Administrativo

Filament estará en `/admin`.

Se utilizará para gestionar participantes y posteriormente validar registros, documentos, acuses y estadísticas.

## Carrera

Distancias:

- 3 km
- 5 km
- 10 km

Ramas:

- Femenil
- Varonil

No existen categorías por edad.

La edad se calculará a partir de la fecha de nacimiento cuando sea necesaria.

## Tipo de participante

Opciones:

- Agremiado
- Público en general

### Agremiado

Debe seleccionar:

1. Región
2. Delegación

La Delegación se filtra según la Región seleccionada.

En la tabla `participantes` solamente se guarda `delegacion_id`.

La Región se obtiene mediante:

`Participante -> Delegación -> Región`

No se almacena `region_id` en `participantes`.

### Público en general

No selecciona Región ni Delegación.

`delegacion_id` queda `NULL`.

## Campos de participantes

Tabla: `participantes`

- `id`
- `folio`
- `acuse_token`
- `numero_corredor`
- `nombre`
- `apellido_paterno`
- `apellido_materno`
- `fecha_nacimiento`
- `rama`
- `distancia`
- `tipo_corredor`
- `delegacion_id`
- `correo`
- `telefono`
- `ine_path`
- `voucher_path`
- `estatus`
- `created_at`
- `updated_at`

## Datos personales

El participante captura:

- Nombre
- Apellido paterno
- Apellido materno (opcional)
- Fecha de nacimiento
- Rama
- Distancia

No se guarda la edad directamente.

## Contacto

- Correo electrónico
- Teléfono celular

Reglas previstas:

### Correo

- Obligatorio
- Validar formato
- Guardar en minúsculas
- Se utilizará para enviar el acuse

### Teléfono

- Obligatorio
- 10 dígitos
- Solo números

## Documentos

El participante debe subir:

1. INE o credencial de elector
2. Comprobante de pago

Restricciones:

- JPG/JPEG
- PNG
- PDF
- Máximo 5 MB por archivo

Los documentos deben permanecer en almacenamiento privado, no en `public/`.

Rutas actuales:

- `participantes/ine`
- `participantes/vouchers`

## Pago

No se integrará una pasarela de pago.

El participante únicamente proporciona el comprobante de pago.

No se pedirán manualmente:

- monto
- referencia bancaria
- fecha de pago

El administrador verificará el comprobante.

## Folio

Formato definitivo:

`CAR-2026-XXXXXX`

Ejemplo:

`CAR-2026-A7K3P9`

Características:

- Único
- Aleatorio
- No revela el consecutivo de registros
- Visible para el participante
- Se utilizará en correo y acuse

Actualmente se genera automáticamente en el modelo.

## Número de corredor

Será un consecutivo global.

Ejemplos:

- Registro 1 → `1`
- Registro 2 → `2`
- Registro 3 → `3`

La base de datos guarda el entero.

La presentación con ceros a la izquierda se resolverá posteriormente.

Ejemplos futuros:

- `1` → `00001`
- `15` → `00015`
- `125` → `00125`
- `6500` → `06500`

No se deben almacenar los ceros en la base de datos.

El número es global y no depende de:

- distancia
- rama
- región
- tipo de participante

No se debe reutilizar un número de corredor eliminado.

## Acuse token

Cada participante tiene un `acuse_token` único.

Se genera automáticamente como UUID.

Ejemplo:

`bdca6fa0-fedc-4062-89ab-4f85e57edb85`

Servirá posteriormente para un acceso seguro al acuse/PDF.

No se captura manualmente.

## Estatus

El registro inicia con:

`pendiente`

Posteriormente se implementará el flujo administrativo de validación.

## Modelo Participante

El modelo genera automáticamente al crear:

- `acuse_token`
- `folio`
- `numero_corredor`

Esto ya fue probado desde Filament.

## Normalización UTF-8 pendiente

Se decidió implementar posteriormente en el modelo `Participante` una función compatible con UTF-8 para guardar nombres y apellidos en mayúsculas sin perder acentos ni Ñ.

Ejemplos:

- `José` → `JOSÉ`
- `Muñoz` → `MUÑOZ`
- `Gutiérrez` → `GUTIÉRREZ`

Campos previstos:

- `nombre`
- `apellido_paterno`
- `apellido_materno`

Correo:

- minúsculas

No alterar innecesariamente los valores internos controlados como:

- `femenil`
- `varonil`
- `3K`
- `5K`
- `10K`
- `agremiado`
- `publico`

## Relaciones

### Region

`Region hasMany Delegacion`

### Delegacion

`Delegacion belongsTo Region`

`Delegacion hasMany Participante`

### Participante

`Participante belongsTo Delegacion`

Cadena:

`Participante -> Delegación -> Región`

## Tablas

### regiones

- `id`
- `nombre`
- timestamps

### delegaciones

- `id`
- `region_id`
- `delegacion`
- `sede`
- timestamps

### participantes

Estructura descrita anteriormente.

## Catálogos

Las regiones y delegaciones ya fueron cargadas mediante seeders:

- `RegionSeeder`
- `DelegacionSeeder`

Las relaciones fueron probadas correctamente.

## Filament

Resource:

`ParticipanteResource`

Ubicación:

`app/Filament/Resources/Participantes/ParticipanteResource.php`

Existe:

- listado
- creación
- edición
- vista
- formulario
- tabla
- infolist

## Pruebas realizadas

Se crearon dos participantes de prueba desde Filament.

Primera prueba:

- Folio: `CAR-2026-IEWLLN`
- Número: `1`
- Estatus: `pendiente`

Segunda prueba:

- Folio: `CAR-2026-XSSAE4`
- Número: `2`
- UUID de acuse generado
- Estatus: `pendiente`

También se comprobó que los archivos de INE y comprobante se almacenan correctamente.

Por lo tanto está confirmado:

`Filament -> Laravel -> MySQL`

funciona correctamente para el registro.

## Acuse y correo

La convocatoria indica que el acuse y el correo deben incluir como mínimo:

- Nombre
- Edad
- Distancia
- Tipo de participante: Agremiado / Público en general

Además se podrán incluir:

- Folio
- Número de corredor
- Rama
- Región/Delegación cuando corresponda

La edad se calcula desde `fecha_nacimiento`.

## Orden de desarrollo

1. Formulario público
2. Guardado correcto
3. Validaciones
4. Región -> Delegación dependiente
5. Archivos privados
6. Confirmación de registro
7. Normalización de datos
8. Acuse PDF
9. Correo
10. Administración avanzada

No implementar todavía funcionalidades avanzadas antes de que el formulario público básico funcione.

## Siguiente etapa

Construir el formulario público en `/`.

Debe contener:

### Bloque 1 — Datos personales

- Nombre
- Apellido paterno
- Apellido materno
- Fecha de nacimiento
- Rama
- Distancia

### Bloque 2 — Tipo de participante

- Agremiado
- Público en general

Si es Agremiado:

- Región
- Delegación filtrada por Región

Si es Público:

- No mostrar Región/Delegación

### Bloque 3 — Contacto

- Correo
- Teléfono

### Bloque 4 — Documentos

- INE/credencial
- Comprobante de pago

Al enviar:

- generar folio
- generar número
- generar `acuse_token`
- guardar participante
- estatus `pendiente`

## Prompt maestro para continuar

Estoy desarrollando un sistema Laravel 13 + Filament 5 para registrar participantes de una carrera atlética.

El proyecto se llama `carrera-unidad56` y está en Laragon para Windows.

Ya existe una base de datos MySQL llamada `carrera_unidad56`.

El registro público estará en `/` y el panel administrativo en `/admin`.

Los participantes NO tendrán cuenta.

El formulario debe registrar:

- nombre
- apellido paterno
- apellido materno opcional
- fecha de nacimiento
- rama: femenil/varonil
- distancia: 3K/5K/10K
- tipo: agremiado/público en general
- correo
- teléfono
- INE/credencial
- comprobante de pago

Si es agremiado debe seleccionar Región y después Delegación. La Delegación debe filtrarse según la Región seleccionada. En `participantes` solamente se almacena `delegacion_id`; la Región se obtiene mediante la relación Delegación -> Región.

Si es público en general, no se muestran ni requieren Región y Delegación.

El participante recibe automáticamente:

- folio con formato `CAR-2026-XXXXXX`
- número de corredor consecutivo global
- `acuse_token` UUID único
- estatus inicial `pendiente`

La base de datos guarda el número como entero (`1`, `2`, `3`...). Los ceros a la izquierda (`00001`) se resolverán posteriormente solamente en la presentación.

Los documentos deben ser privados, aceptar JPG/JPEG, PNG o PDF y pesar máximo 5 MB cada uno.

Ya se comprobó desde Filament que el registro se guarda correctamente y que folio, número, UUID, datos y archivos funcionan.

También quiero implementar posteriormente normalización UTF-8 en el modelo `Participante` para guardar nombres y apellidos en mayúsculas sin perder acentos ni Ñ.

Trabaja conmigo paso a paso. No hagas varias modificaciones a la vez. Antes de avanzar a una etapa nueva, confirma el resultado de la etapa anterior. No improvises ni supongas estructuras que no hayamos comprobado.

El siguiente objetivo es construir el formulario público de registro en `/`.
