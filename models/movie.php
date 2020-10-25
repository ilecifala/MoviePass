<?php
namespace models;

class Movie implements \JsonSerializable{

    private $id;
	private $title;
	private $overview;
    private $img;
    private $language;
    private $genres;
	private $releaseDate;
	private $duration;

    public function __construct($id = -1, $title = '', $overview = '', $img = '', $language = '', $genres = array(), $releaseDate = '', $duration = ''){
		$this->id = $id;
		$this->title = $title;
		$this->overview = $overview;
        $this->img = $img;
        $this->language = $language;
        $this->genres = $genres;
		$this->releaseDate = $releaseDate;
		$this->duration = $duration;
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

	public function getLanguage(){
		return $this->language;
	}

	public function setLanguage($language){
		$this->language = $language;
	}

	public function getGenres(){
		return $this->genres;
	}

	public function setGenres($genres){
		$this->genres = $genres;
	}

	public function getReleaseDate(){
		return $this->releaseDate;
	}

	public function setReleaseDate($releaseDate){
		$this->releaseDate = $releaseDate;
	}

	public function getDuration(){
		return $this->duration;
	}

	public function setDuration($duration){
		$this->duration = $duration;
	}

    public function jsonSerialize(){
        return get_object_vars($this);
    }

}