<script>
$(document).ready(function(){
    $("cinemas").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
</script>

<main class="">

<div style="margin-top:50px" class="container">
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-2"></div>		
		<div class="col-sm-6 bg-light boxStyle">
			<form name="theform" action="" method="POST">
                <?php if(isset($cinema)){?>
                    <input type="hidden" name="id" value="<?=$cinema->getId()?>">
                <?php }?>

                <div class="form-group">
                    <label >Pelicula<span class="asteriskField">*</span></label>
                    <input class="form-control" name="name" type="text" value="<?php if(isset($room)) echo $room->getName()?>" size="20"><br>
                <div class="form-group">
                    <label>Cine<span class="asteriskField">*</span></label>
                    <select name="cinemas" id="cinemas" onchange="getRooms()">
                    <?php foreach($cinemas as $cinema){?>
                    
                    <option value="<?=$cinema->getId()?>"><?=$cinema->getName()?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group" display="none">
                    <label>Sala<span class="asteriskField">*</span></label>
                    <select name="cars" id="cars">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Fecha<span class="asteriskField">*</span></label>
                    <input type="datetime-local" id="time" name="time">
                </div>
                <input type="hidden" name="idCinema" value="<?=$idCinema?>">
                <input type="hidden" name="id" value="<?php if(isset($room)) echo $room->getId()?>">
                <?php if(isset($error)){?>
                    <?=$error?>
                <?php }?>

                <div class="form-group">
                    <div class="row">
                       <input class="btn btn-primary" type="submit"   value="Enviar" style="font-weight: bold">
	
                    </div>
                </div>
             </form>      
		</div>
		<div class="col-sm-1"></div>
		<div class="col-sm-2"></div>
    </div> 
</div> 

</main>
<script>
function getRooms() {

  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      $('#moviesList').html("")

      var myArr = JSON.parse(this.responseText);

      for(var k in myArr) {
        console.log(k, myArr[k]);
        $('#moviesList').append('<a class="movieButton" href="<?=FRONT_ROOT?>movie/details/' + myArr[k]['id_movie'] + '"><img class="img-responsive" style="max-width: 10%" src="' + myArr[k]['img_movie'] + '" alt="' + myArr[k]['title_movie'] + '" ></a>');
      }

      
    }
  }

  var genre = document.getElementById("genres").value;
  var year = document.getElementById("year").value;
  var name = document.getElementById("name").value;
 
  xmlhttp.open("GET","<?= FRONT_ROOT?>room/getAll/",true);
  xmlhttp.send();
}
</script>