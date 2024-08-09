<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>
<section class="container-m row px-4 py-4">
  {{with viaje}}
  <form action="index.php?page=Viajes_Viaje&mode={{~mode}}&id_viaje={{id_viaje}}" method="POST" class="col-12 col-m-8 offset-m-2">
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="id_viaje">ID Viaje</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="id_viaje" id="id_viaje" placeholder="ID Viaje" value="{{id_viaje}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="id_viaje" value="{{id_viaje}}" />
      <input type="hidden" name="viaje_xss_token" value="{{~viaje_xss_token}}" />
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="destino">Destino</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="destino" id="destino" placeholder="Destino" value="{{destino}}" />
      {{if destino_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{destino_error}}
      </div>
      {{endif destino_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="medio_transporte">Medio de Transporte</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="medio_transporte" id="medio_transporte" placeholder="Medio de Transporte" value="{{medio_transporte}}" />
      {{if medio_transporte_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{medio_transporte_error}}
      </div>
      {{endif medio_transporte_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="duracion_dias">Duración en Días</label>
      <input class="col-12 col-m-9" {{~readonly}} type="number" name="duracion_dias" id="duracion_dias" placeholder="Duración en Días" value="{{duracion_dias}}" />
      {{if duracion_dias_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{duracion_dias_error}}
      </div>
      {{endif duracion_dias_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="costo_total">Costo Total</label>
      <input class="col-12 col-m-9" {{~readonly}} type="number" step="0.01" name="costo_total" id="costo_total" placeholder="Costo Total" value="{{costo_total}}" />
      {{if costo_total_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{costo_total_error}}
      </div>
      {{endif costo_total_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="fecha_inicio">Fecha de Inicio</label>
      <input class="col-12 col-m-9" {{~readonly}} type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha de Inicio" value="{{fecha_inicio}}" />
      {{if fecha_inicio_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{fecha_inicio_error}}
      </div>
      {{endif fecha_inicio_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="status">Estado</label>
      <select name="status" id="status" class="col-12 col-m-9" {{if ~readonly}} readonly disabled {{endif ~readonly}}>
        <option value="ACT" {{status_ACT}}>Activo</option>
        <option value="INA" {{status_INA}}>Inactivo</option>
      </select>
      {{if status_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{status_error}}
      </div>
      {{endif status_error}}
    </div>
    {{endwith viaje}}
    <div class="row my-4 align-center flex-end">
      {{if showCommitBtn}}
      <button class="primary col-12 col-m-2" type="submit" name="btnConfirmar">Confirmar</button>
      &nbsp;
      {{endif showCommitBtn}}
      <button class="col-12 col-m-2" type="button" id="btnCancelar">
        {{if showCommitBtn}}
        Cancelar
        {{endif showCommitBtn}}
        {{ifnot showCommitBtn}}
        Regresar
        {{endifnot showCommitBtn}}
      </button>
    </div>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const btnCancelar = document.getElementById("btnCancelar");
    btnCancelar.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=Viajes_Viajes");
    });
  });
</script>
