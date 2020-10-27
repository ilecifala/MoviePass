
<main>
    <h1 class="indexTitle">Cartelera</h1>
    <h2>Ver Por: </h2>
    <form method="GET" >
        <label for="genres">Genero:</label>
        <select name="genre" id="genres" onchange="showResult()">
            <option value="all">Todos</option>
            <?php foreach($genres as $genre){?>
            <option value="<?=$genre->getId();?>" <?php if($genre->getId() == $genreRequired) echo "selected=\"selected\""?>><?=$genre->getName();?></option> 
        <?php } ?>
        </select>
    </form>

    <input type="date" id="time" name="time">

    <div class="moviesList" id="moviesList">
        <?php foreach($movies as $movie){?> 
        <a class="movieButton" href="<?=FRONT_ROOT?>movie/details/<?= $movie->getId()?>"><img class="img-responsive" style="max-width: 10%" src="<?= $movie->getImg(); ?>" alt="<?= $movie->getTitle();?>" ></a>
        
        <?php } ?>
    </div>
    <br>
    <nav>
      <ul class="pagination justify-content-center">
        <?php if($offset != 0){?>
        <li class="page-item">
          <a class="page-link" href="<?= FRONT_ROOT . "movie/displayBillboard/" . $genreRequired. "/" . $yearRequired . "/" . ($page-1)?>" >Previous</a>
        </li>
        <?php } ?>
        <?php //this could probably be optimized 
        for($i=$page-3; $i < $page;$i++){
          if($i > 0 ){?>
          <li class="page-item">
            <a class="page-link" href="<?= FRONT_ROOT . "movie/displayBillboard/" . $genreRequired. "/" . $yearRequired . "/" . $i?>"><?=$i?></a>
          </li>
        <?php } }?>

          <li class="page-item active">
            <a class="page-link" href=""><?=$page?></a>
          </li>

          <?php for($i=$page+1; $i < $page+3;$i++){
          if($i <= $totalPages ){?>
          <li class="page-item">
            <a class="page-link" href="<?= FRONT_ROOT . "movie/displayBillboard/" . $genreRequired. "/" . $yearRequired . "/" . $i?>"><?=$i?></a>
          </li>
        <?php } }?>


        <?php if($page < $totalPages){?>
        <li class="page-item">
          <a class="page-link" href="<?= FRONT_ROOT . "movie/displayBillboard/" . $genreRequired. "/" . $yearRequired . "/" . ($page+1)?>">Next</a>
        </li>
        <?php }?>
    </ul>
    </nav>
</main>
<script>
function showResult() {

  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      //Clear all movies
      $('#moviesList').html("")

      var movies = JSON.parse(this.responseText);

      for(var index in movies) {
        console.log(index, movies[index]);
        $('#moviesList').append('<a class="movieButton" href="<?=FRONT_ROOT?>movie/details/' + movies[index]['id_movie'] + '"><img class="img-responsive" style="max-width: 10%" src="' + movies[index]['img_movie'] + '" alt="' + movies[index]['title_movie'] + '" ></a>');
      }

      
    }
  }

  var genre = document.getElementById("genres").value;
  var year = document.getElementById("year").value;
  var name = document.getElementById("name").value;
 
  xmlhttp.open("GET","<?= FRONT_ROOT?>movie/getMovies/" + genre + "/" + year + "/" + name,true);
  xmlhttp.send();
}
</script>