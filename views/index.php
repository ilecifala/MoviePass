<?php
    include("header.php");
    use api\MovieDbInterface as api;
    $api = new api();
?>
<main>
    <div>
        <span class="indexTitle">Cartelera</span><br>
        <?php
            $movies = $api->getMovies(1);
            foreach($movies as $movie){
                ?> <img src="<?= $movie->getImg(); ?>" alt="<?= $movie->getTitle();?>" width="150px">
            <?php } ?>
    </div>
</main>
<?php include("footer.php"); ?>