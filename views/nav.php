<nav class="navBar">
     <div>
          *logo*
          <?php 
          if(isset($_SESSION['user'])){
               echo 'Bienvenido, ' . $_SESSION['user']->getName();
          }
          ?>
     </div>
     <ul class="navList">
     <li class="navItem">
               <a class="navLink" href="home/index">Home</a>
          </li>
          <li class="navItem">
               <a class="navLink" href="user/login">Log in</a>
          </li>
          <li class="navItem">
               <a class="navLink" href="user/signup">Sign up</a>
          </li>
     </ul>
</nav>