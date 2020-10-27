<table class="table">
  <thead>
    <tr>
      <th scope="col">Perfil</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Email</th>
      <td><?php 
          if(isset($_SESSION['user'])){
              echo $_SESSION['user']->getEmail();
          }?></td>
    </tr>
    <form action="<?=FRONT_ROOT?>user/profile" method="post">
    <tr>
      <th scope="row">Nombre</th>
      <td><?php
            if($_SESSION['profile']->getFirstName() != null){
              echo $_SESSION['profile']->getFirstName();
            }else{?>
                <input type="text" name="firstName" id="firstName" placeholder="Ingrese su nombre">
                <button type="submit" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar </button>
                <?php
            }?>
        </td>
    </tr>
    <tr>
      <th scope="row">Apellido</th>
      <td><?php
            if($_SESSION['profile']->getLastName() != null){
              echo $_SESSION['profile']->getLastName();
            }else{?>
                <input type="text" name="lastName" id="lastName" placeholder="Ingrese su apellido">
                <button type="submit" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar </button>
                <?php
            }?>
          </td>
    </tr>
    <tr>
      <th scope="row">DNI</th>
      <td><?php
            if($_SESSION['profile']->getDni() != null){
              echo $_SESSION['profile']->getDni();
            }else{?>
                <input type="text" name="dni" id="dni" placeholder="Ingrese su DNI">
                <button type="submit" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar </button>
                <?php
            }?>
        </td>
    </tr>
    </form>
  </tbody>
</table>