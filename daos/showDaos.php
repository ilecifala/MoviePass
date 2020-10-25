<?php
namespace daos;
use daos\baseDaos as BaseDaos;
use models\show as Show;
use models\movie as Movie;
use models\room as Room;

class ShowDaos extends BaseDaos{

    const TABLE_NAME = "shows";

    public function __construct(){
        parent::__construct(self::TABLE_NAME, 'Show');        
    }

    public function getAll(){
        //var_dump(parent::_getAll());

        $query = "SELECT s.id_show, s.datetime_show, m.*, r.* FROM shows s
        INNER JOIN movies m ON s.idMovie_show = m.id_movie
        INNER JOIN rooms r ON s.idRoom_show = r.id_room";

        $connection = Connection::getInstance();
        $resultSet = $connection->executeWithAssoc($query);

        $result = array();

        foreach ($resultSet as $show){
            $result[] = new show(
                                new Movie(
                                    $show['id_movie'],
                                    $show['title_movie'], 
                                    $show['overview_movie'], 
                                    $show['img_movie'], 
                                    $show['language_movie'],
                                    unserialize($show['genreIds_movie']),
                                    $show['releaseDate_movie'],
                                    $show['duration_movie']),
                                new Room(
                                    $show['id_room'],
                                    $show['price_room'],
                                    $show['capacity_room'],
                                    $show['idCinema_room']
                                ),
                                $show['datetime_show']
                                );
        }
        echo "<pre>";
        var_dump($resultSet);
        echo "</pre>";
        
    }

    public function exists($id){
        return parent::_exists($id);
    }

    public function getById($id){
        return parent::_getByProperty($id, 'id');
    }

    public function add($show){
        return parent::_add($show);
    }

    public function remove($id){
        return parent::_remove($id, 'id');
    }

    public function modify($show){
        return parent::_modify($show, $show->getId(), "id");
    }
}
?>