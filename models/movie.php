<?php
namespace models;

class Movie{

    private $id;
	private $title;
	private $overview;
    private $img;
    private $originalLanguage;
    private $genresId;
    private $releaseDate;

    public function __construct($id, $title, $overview, $img, $originalLanguage, $genresId, $releaseDate){
        $this->id = $id;
		$this->title = $title;
		$this->overview = $overview;
        $this->img = $img;
        $this->originalLanguage = $originalLanguage;
        $this->genresId = $genresId;
        $this->releaseDate = $releaseDate;
    }

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getOverview(){
		return $this->overview;
	}

	public function setOverview($overview){
		$this->overview = $overview;
	}


	public function getImg(){
		return $this->img;
	}

	public function setImg($img){
		$this->img = $img;
	}

	public function getOriginalLanguage(){
		return $this->originalLanguage;
	}

	public function setOriginalLanguage($originalLanguage){
		$this->originalLanguage = $originalLanguage;
	}

	public function getGenresId(){
		return $this->genresId;
	}

	public function setGenresId($genresId){
		$this->genresId = $genresId;
	}

	public function getReleaseDate(){
		return $this->releaseDate;
	}

	public function setReleaseDate($releaseDate){
		$this->releaseDate = $releaseDate;
	}

}