<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Reporte información granjas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f0f8ff;
    }
    .container {
      width: 90%;
      max-width: 400px;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .container h1 {
      color: #0073e6;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      font-weight: bold;
      color: #333;
      margin-bottom: 5px;
    }
    select, textarea, input {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    button {
      background-color: #0073e6;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      background-color: #005bb5;
    }
    textarea {
      resize: vertical;
      min-height: 60px;
    }
    input {
      resize: vertical;
      min-height: 20px;
    }
    .logo {
      position: absolute;
      top: 20px;
      left: 20px;
      width: 50px;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="container">
    <h1>Reporte sanidad Granjas</h1>
    <form method="POST" action="descarga.php">
      <div class="form-group">
        <label for="origen">Tipo Reporte</label>
        <select id="origen" name="origen">
          <option value="medicacion">Medicaciones en Cerdos</option>
          <option value="insectos">Control de insectos</option>
          <option value="roedores">Control de roedores</option>
          <option value="aves">Necropsia aves</option>
          <option value="cerdos">Necropsia Cerdos</option>
        </select>
      </div>

      <!-- Rango de Fechas -->
      <div class="form-group">
        <label for="fechaInicio">Fecha Inicio</label>
        <input type="date" id="fechaInicio" name="fechaInicio" required>
      </div>
      <div class="form-group">
        <label for="fechaFin">Fecha Fin</label>
        <input type="date" id="fechaFin" name="fechaFin" required>
      </div>

      <button type="submit">Descargar</button>
    </form>
  </div>
  <div id="datos"></div>
</body>
<script>
  // Si necesitas procesar el rango de fechas por JavaScript, aquí puedes validarlo
</script>
</html>
