<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro 1ra CARRERA ATLÉTICA DEL EDUCADOR FÍSICO</title>
</head>

<body>

    <h1>REGISTRO 1ra CARRERA ATLÉTICA DEL EDUCADOR FÍSICO</h1>

    <p>Formulario de registro de participantes</p>

    <hr>

    <h2>Datos personales</h2>

    <form>

        <div>
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                required
            >
        </div>

        <br>

        <div>
            <label for="apellido_paterno">Apellido paterno</label>
            <input
                type="text"
                id="apellido_paterno"
                name="apellido_paterno"
                required
            >
        </div>

        <br>

        <div>
            <label for="apellido_materno">Apellido materno</label>
            <input
                type="text"
                id="apellido_materno"
                name="apellido_materno"
            >
        </div>

        <br>

        <div>
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input
                type="date"
                id="fecha_nacimiento"
                name="fecha_nacimiento"
                required
            >
        </div>

        <br>

        <div>
            <label for="rama">Rama</label>

            <select id="rama" name="rama" required>
                <option value="">Seleccione una opción</option>
                <option value="femenil">Femenil</option>
                <option value="varonil">Varonil</option>
            </select>
        </div>

        <br>

        <div>
            <label for="distancia">Distancia</label>

            <select id="distancia" name="distancia" required>
                <option value="">Seleccione una opción</option>
                <option value="3K">3 km</option>
                <option value="5K">5 km</option>
                <option value="10K">10 km</option>
            </select>
        </div>  

        <br>

        <div>
            <label for="tipo_corredor">Tipo de participante</label>

            <select id="tipo_corredor" name="tipo_corredor" required>
                <option value="">Seleccione una opción</option>
                <option value="agremiado">Agremiado</option>
                <option value="publico">Público en general</option>
            </select>
        </div>        

        <br>

        <div id="datos_agremiado" style="display: none;">

            <br>

            <div>
                <label for="region_id">Región</label>

                <select id="region_id" name="region_id">
                    <option value="">Seleccione una región</option>
                </select>
            </div>

            <br>

            <div>
                <label for="delegacion_id">Delegación</label>

                <select id="delegacion_id" name="delegacion_id">
                    <option value="">Seleccione una delegación</option>
                </select>
            </div>

        </div>

        <br>



        <button type="submit">
            Continuar
        </button>

    </form>

</body>

<script>
    const tipoCorredor = document.getElementById('tipo_corredor');
    const datosAgremiado = document.getElementById('datos_agremiado');

    tipoCorredor.addEventListener('change', function () {

        if (this.value === 'agremiado') {
            datosAgremiado.style.display = 'block';
        } else {
            datosAgremiado.style.display = 'none';
        }

    });
</script>
</html>