<?php
?>
<main>
    <h1 class="indexTitle">Cartelera</h1>
    <h2>Ver Por: </h2>
    <form method="GET" >
        <label for="genres">Genero:</label>
        <select name="genre" id="genres" onchange="this.form.submit()">
            <option value="all">Todos</option>
            <?php foreach($genres as $genre){?>
            <option value="<?=$genre->getId();?>" <?php if($genre->getId() == $genreRequired) echo "selected=\"selected\""?>><?=$genre->getName();?></option> 
        <?php } ?>
        </select>

        <label for="year">Año:</label>
        <select name="year" id="year" onchange="this.form.submit()">
            <option value="all">Todos</option>
            <?php for($i = 2020; $i > 2015 ; $i--){?>
            
            <option value="<?=$i?>"<?php if($i == $yearRequired) echo " selected=\"selected\""?>><?=$i?></option> 
        <?php } ?>
        </select>
    </form>
    <!--
    <form action="order/byDate">
        <input type="submit" value="Fecha">
        <input type="submit" value="Categoria"> 
    </form>
    -->
    <div class="moviesList">
        <?php foreach($movies as $movie){?> 
        <a class="movieButton" href="<?=FRONT_ROOT?>movie/details/<?= $movie->getId()?>"><img class="img-responsive" style="max-width: 10%" src="<?= $movie->getImg(); ?>" alt="<?= $movie->getTitle();?>" ></a>
        
        <?php } ?>
    </div>
    <nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>
</main>
