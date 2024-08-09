<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>
<section class="container-m row px-4 py-4">
  {{with category}}
  <form action="index.php?page=Categories_Category&mode={{~mode}}&CategoryID={{CategoryID}}" method="POST" class="col-12 col-m-8 offset-m-2">
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="CategoryID">ID de Categoría</label>
      <input class="col-12 col-m-9" readonly disabled type="text" name="CategoryID" id="CategoryID" placeholder="ID de Categoría" value="{{CategoryID}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="CategoryID" value="{{CategoryID}}" />
      <input type="hidden" name="token" value="{{~category_xss_token}}" />
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="CategoryName">Nombre de Categoría</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="CategoryName" id="CategoryName" placeholder="Nombre de Categoría" value="{{CategoryName}}" />
      {{if CategoryName_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{CategoryName_error}}
      </div>
      {{endif CategoryName_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="Description">Descripción</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="Description" id="Description" placeholder="Descripción" value="{{Description}}" />
      {{if Description_error}}
      <div class="col-12 col-m-9 offset-m-3 error">
        {{Description_error}}
      </div>
      {{endif Description_error}}
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="CreatedDate">Fecha de Creación</label>
      <input class="col-12 col-m-9" {{~readonly}} type="date" name="CreatedDate" id="CreatedDate" placeholder="Fecha de Creación" value="{{CreatedDate}}" />
    </div>
    <div class="row my-2 align-center">
      <label class="col-12 col-m-3" for="IsActive">Estado</label>
      <select name="IsActive" id="IsActive" class="col-12 col-m-9" {{if ~readonly}} readonly disabled {{endif ~readonly}}>
        <option value="1" {{IsActive_active}}>Activo</option>
        <option value="0" {{IsActive_inactive}}>Inactivo</option>
      </select>
    </div>
    {{endwith category}}
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
      window.location.assign("index.php?page=Categories_Categories");
    });
  });
</script>
