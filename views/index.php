<?php
    include("header.php");
    include("nav.php");
    use controllers\movieController as MovieController;
    $movies = new MovieController();
    //$movies->update();
    
?>
<main>
<h1 class="indexTitle">Cartelera</h1>
    <h2>Buscar por: </h2>
    <form action="movie/getAll">
        <br>Categoría <input type="text" name='genre'>
        <br>Año <input type="text" name='year'> 
        <button>Buscar</button>
    </form>
    <?php
    $movies->getAll();
    include('moviesList.php');
    ?>
</main>
<?php include("footer.php"); ?>