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
    <tr>
      <th scope="row">Nombre</th>
      <td><?php
            if(isset($_SESSION['profile'])){
              echo $_SESSION['profile']->getFirstName();
            }else{?>
                <form action="<?=FRONT_ROOT?>user/profile" method="post">
                <input type="text" name="firstName" id="firstName" placeholder="Ingrese su nombre">
                <button type="submit" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar </button>
                </form><?php
            }?>
        </td>
    </tr>
    <tr>
      <th scope="row">Apellido</th>
      <td><?php
            if(isset($_SESSION['profile'])){
              echo $_SESSION['profile']->getLastName();
            }else{?>
                <form action="<?=FRONT_ROOT?>user/profile" method="post">
                <input type="text" name="lastName" id="lastName" placeholder="Ingrese su apellido">
                <button type="submit" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar </button>
                </form><?php
            }?></td>
    </tr>
  </tbody>
</table>