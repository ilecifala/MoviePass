<?php
    include("header.php");
    use api\MovieDbInterface as api;
    $api = new api();
?>
<main>
    <h1 class="indexTitle">Cartelera</h1>
    <h2>Ordenar Por: </h2>
    <form action="order/byDate">
        <input type="submit" value="Fecha">
        <input type="submit" value="Categoria"> 
    </form>
    <div class="moviesList">
        <form action="selection/selectMovie" method="POST">
        <?php
            $movies = $api->getMovies(1);
            foreach($movies as $movie){
                ?> <a class="movieButton" href="movie/getMovie/<?= $movie->getId()?>"><img src="<?= $movie->getImg(); ?>" alt="<?= $movie->getTitle();?>"  width="200px"></a>
            <?php } ?>
        </form>
    </div>
</main>
<?php include("footer.php"); ?>