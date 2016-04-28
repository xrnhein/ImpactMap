<?php

require_once "constants.inc.php";

class Map {

    /**
     * The database object
     *
     * @var object
     */
    private $_db;

    /**
     * Checks for a database object and creates one if none is found
     *
     * @param object $db
     * @return void
     */
    public function __construct($db=NULL) {
        if (is_object($db)) {
            $this->_db = $db;
        } else {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $this->_db = new PDO($dsn, DB_USER, DB_PASS);
        }
    }

    /**
     * Test function to create entry in the database.
     * Must be set: POST, POST[address], POST[title], POST[description]
     * @return bool
     */
    public function add_project() {
        $address = trim($_POST['address']);
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $lat = trim($_POST['lat']);
        $lng = trim($_POST['lng']);
        $category = trim($_POST['category']);

        $sql = "INSERT INTO Display(address, description, title, lat, lng, category) VALUES(:add, :desc, :title, :lat, :lng, :category)";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":add", $address, PDO::PARAM_STR);
            $stmt -> bindParam(":desc", $description, PDO::PARAM_STR);
            $stmt -> bindParam(":title", $title, PDO::PARAM_STR);
            $stmt -> bindParam(":lat", $lat, PDO::PARAM_INT);
            $stmt -> bindParam(":lng", $lng, PDO::PARAM_INT);
            $stmt -> bindParam(":category", $category, PDO::PARAM_STR);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
    }

public function load_projects($filters = array()) {
    $defaults = array(
        'limit' => 250,
        'minLat' => -85,
        'maxLat' => 85,
        'minLng' => -180,
        'maxLng' => 180,
        'category' => '%'
    );
    $filters = array_merge($defaults, $filters);

    $results = NULL;
    $sql = "SELECT pid, lat, lng, title FROM Display WHERE lat >= :minLat AND lat <= :maxLat AND lng >= :minLng AND lng <= :maxLng
            AND category LIKE :category
            LIMIT :limit";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(':limit', $filters['limit'], PDO::PARAM_INT);
        $stmt -> bindParam(':minLat', $filters['minLat'], PDO::PARAM_STR);
        $stmt -> bindParam(':maxLat', $filters['maxLat'], PDO::PARAM_STR);
        $stmt -> bindParam(':minLng', $filters['minLng'], PDO::PARAM_STR);
        $stmt -> bindParam(':maxLng', $filters['maxLng'], PDO::PARAM_STR);
        $stmt -> bindParam(':category', $filters['category'], PDO::PARAM_STR);
        $stmt -> execute();

        while ($row = $stmt -> fetch()) {
            $results[] = array('pid' => (int) $row[0],
                               'lat' => (float) $row[1],
                               'lng' => (float) $row[2],
                               'title' => utf8_encode($row[3])
                              );
        }
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return NULL;
    }

    return $results;
}

    /**
     * Returns all entries in the database as a 2D associative array.
     *
     * @param $filters array  A list of filter options:
     *                          limit: max number of entries to fetch, default 100
     *                          minLat: min latitude
     *                          maxLat: max latitude
     *                          minLng: min longitude
     *                          maxLng: max longitude
     *                          category: category
     *
     * @return array          A list of entries with associative index being the column names
     */
    public function load_project_details($pid) {
        $sql = "SELECT * FROM Display WHERE pid = $pid
                LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(':pid', $pid, PDO::PARAM_INT);
            $stmt -> execute();

            $row = $stmt -> fetch();
            return array('pid' => (int) $row[0],
                               'address' => utf8_encode($row[1]),
                               'description' => utf8_encode($row[2]),
                               'pic' => utf8_encode($row[3]),
                               'link' => utf8_encode($row[4]),
                               'lat' => (float) $row[5],
                               'lng' => (float) $row[6],
                               'anim' => utf8_encode($row[7]),
                               'title' => utf8_encode($row[8]),
                               'infoopen' => (int) $row[9],
                               'category' => utf8_encode($row[10]),
                               'approved' => (int) $row[11],
                               'retina' => (int) $row[12]
                                  );
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return NULL;
        }
    }

    /**
     * Removes an individual entry from the database. Returns if operation was successful.
     * @param $id int   The ID of the entry you want to remove
     * @return bool     TRUE if successfully removed, FALSE otherwise
     */
    public function remove($id) {
        $id = intval($id);
        $sql = "DELETE FROM map WHERE id=:id LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
    }

    /**
     * Returns all the information stored on the database from one project in an associative array
     * @param $id int       The ID of the project
     * @return array        The project entry
     */
    public function get_info($id) {
        $id = intval($id);
        $sql = "SELECT * FROM map WHERE id=:id LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return NULL;
        }
    }

    /**
     * Updates a specific project entry in the database.
     * @param int $id           The project ID
     * @param array $values     An array of values to be changed for this entry. The indices are column names.
     * @return bool             TRUE on successful update, FALSE otherwise
     */
    public function update_entry($id, $values = array()) {
        $id = intval($id);
        $defaults = $this -> get_info($id);
        $values = array_merge($values, $defaults);

        $sql = "UPDATE map SET
                  address = :addr,
                  description = :descr,
                  pic = :pic,
                  link = :link,
                  icon = :icon,
                  lat = :lat,
                  lng = :lng,
                  anim = :anim,
                  title = :title,
                  infoopen = :infoopen,
                  category = :cat,
                  approved = :appr,
                  retina = :retina
                WHERE id = :id LIMIT 1
                ";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":addr", $values['address'], PDO::PARAM_STR);
            $stmt -> bindParam(":descr", $values['description'], PDO::PARAM_STR);
            $stmt -> bindParam(":pic", $values['pic'], PDO::PARAM_STR);
            $stmt -> bindParam(":link", $values['link'], PDO::PARAM_STR);
            $stmt -> bindParam(":icon", $values['icon'], PDO::PARAM_STR);
            $stmt -> bindParam(":lat", $values['lat'], PDO::PARAM_STR);
            $stmt -> bindParam(":lng", $values['lng'], PDO::PARAM_STR);
            $stmt -> bindParam(":anim", $values['anim'], PDO::PARAM_STR);
            $stmt -> bindParam(":title", $values['title'], PDO::PARAM_STR);
            $stmt -> bindParam(":infoopen", $values['infoopen'], PDO::PARAM_INT);
            $stmt -> bindParam(":cat", $values['category'], PDO::PARAM_STR);
            $stmt -> bindParam(":appr", $values['approved'], PDO::PARAM_INT);
            $stmt -> bindParam(":retina", $values['retina'], PDO::PARAM_INT);
            $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
    }

    /**
     * Center
     */
    public function search($id) {

    }

    /**
     * Search keyword from title, category, description
     */
    public function search_suggest($keyword) {
        $keyword = preg_replace("/[^A-Za-z0-9]/", " ", $keyword);
        $search_string = '%'.$keyword.'%';

        if (strlen($keyword < 3 || $keyword === ' '))
            return NULL;

        $sql = "SELECT * FROM map WHERE title LIKE :keyword || description LIKE :keyword || category LIKE :keyword";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":keyword", $search_string, PDO::PARAM_STR);
            $stmt -> execute();
            while ($row = $stmt -> fetch())
                $results[] = $row;
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }

        return empty($results) ? NULL : $results;
    }




}