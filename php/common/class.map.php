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

    public function load_projects($filters = array()) {
      $defaults = array(
          'limit' => 250,
          'minLat' => -85,
          'maxLat' => 85,
          'minLng' => -180,
          'maxLng' => 180,
          'cid' => '0'
      );
      $filters = array_merge($defaults, $filters);

      $results = NULL;
      $sql = "SELECT pid, lat, lng, title FROM Projects WHERE lat >= :minLat AND lat <= :maxLat AND lng >= :minLng AND lng <= :maxLng
              LIMIT :limit";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> bindParam(':limit', $filters['limit'], PDO::PARAM_INT);
          $stmt -> bindParam(':minLat', $filters['minLat'], PDO::PARAM_STR);
          $stmt -> bindParam(':maxLat', $filters['maxLat'], PDO::PARAM_STR);
          $stmt -> bindParam(':minLng', $filters['minLng'], PDO::PARAM_STR);
          $stmt -> bindParam(':maxLng', $filters['maxLng'], PDO::PARAM_STR);
          //$stmt -> bindParam(':cid', $filters['cid'], PDO::PARAM_INT);
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
     * Test function to create entry in the database.
     * Must be set: POST, POST[address], POST[title], POST[description]
     * @return bool
     */
    public function add_project() {
        $sql = "INSERT INTO Projects(cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, link, pic, contactName, contactEmail, contactPhone, lat, lng) 
                VALUES (:cid, :title, :status, :startDate, :endDate, :buildingName, :address, :zip, :type, :summary, :link, :pic, :contactName, :contactEmail, :contactPhone, :lat, :lng);
                INSERT INTO History(pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, link, pic, contactName, contactEmail, contactPhone, lat, lng) 
                VALUES ((SELECT MAX(pid) FROM Projects),:cid, :title, :status, :startDate, :endDate, :buildingName, :address, :zip, :type, :summary, :link, :pic, :contactName, :contactEmail, :contactPhone, :lat, :lng)";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":cid",          $_POST['cid'], PDO::PARAM_INT);
            $stmt -> bindParam(":title",        $_POST['title'], PDO::PARAM_STR);
            $stmt -> bindParam(":status",       $_POST['status'], PDO::PARAM_INT);
            $stmt -> bindParam(":startDate",    $_POST['startDate'], PDO::PARAM_STR);
            $stmt -> bindParam(":endDate",      $_POST['endDate'], PDO::PARAM_STR);
            $stmt -> bindParam(":buildingName", $_POST['buildingName'], PDO::PARAM_STR);
            $stmt -> bindParam(":address",      $_POST['address'], PDO::PARAM_STR);
            $stmt -> bindParam(":zip",          $_POST['zip'], PDO::PARAM_INT);
            $stmt -> bindParam(":type",         $_POST['type'], PDO::PARAM_INT);
            $stmt -> bindParam(":summary",      $_POST['summary'], PDO::PARAM_STR);
            $stmt -> bindParam(":link",         $_POST['link'], PDO::PARAM_STR);
            $stmt -> bindParam(":pic",          $_POST['pic'], PDO::PARAM_STR);
            $stmt -> bindParam(":contactName",  $_POST['contactName'], PDO::PARAM_STR);
            $stmt -> bindParam(":contactEmail", $_POST['contactEmail'], PDO::PARAM_STR);
            $stmt -> bindParam(":contactPhone", $_POST['contactPhone'], PDO::PARAM_STR);
            $stmt -> bindParam(":lat",          $_POST['lat'], PDO::PARAM_STR);
            $stmt -> bindParam(":lng",          $_POST['lng'], PDO::PARAM_STR);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
    }

    public function update_project() {
        $sql = "UPDATE Projects SET cid = :cid, title = :title, status = :status, startDate = :startDate, endDate = :endDate, buildingName = :buildingName, address = :address, zip = :zip, type = :type, summary = :summary, 
                                    link = :link, pic = :pic, contactName = :contactName, contactEmail = :contactEmail, contactPhone = :contactPhone, lat = :lat, lng = :lng WHERE pid = :pid LIMIT 1;
                INSERT INTO History(pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, link, pic, contactName, contactEmail, contactPhone, lat, lng) 
                VALUES (:pid, :cid, :title, :status, :startDate, :endDate, :buildingName, :address, :zip, :type, :summary, :link, :pic, :contactName, :contactEmail, :contactPhone, :lat, :lng)";

        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":pid",          $_POST['pid'], PDO::PARAM_INT);
            $stmt -> bindParam(":cid",          $_POST['cid'], PDO::PARAM_INT);
            $stmt -> bindParam(":title",        $_POST['title'], PDO::PARAM_STR);
            $stmt -> bindParam(":status",       $_POST['status'], PDO::PARAM_INT);
            $stmt -> bindParam(":startDate",    $_POST['startDate'], PDO::PARAM_STR);
            $stmt -> bindParam(":endDate",      $_POST['endDate'], PDO::PARAM_STR);
            $stmt -> bindParam(":buildingName", $_POST['buildingName'], PDO::PARAM_STR);
            $stmt -> bindParam(":address",      $_POST['address'], PDO::PARAM_STR);
            $stmt -> bindParam(":zip",          $_POST['zip'], PDO::PARAM_INT);
            $stmt -> bindParam(":type",         $_POST['type'], PDO::PARAM_INT);
            $stmt -> bindParam(":summary",      $_POST['summary'], PDO::PARAM_STR);
            $stmt -> bindParam(":link",         $_POST['link'], PDO::PARAM_STR);
            $stmt -> bindParam(":pic",          $_POST['pic'], PDO::PARAM_STR);
            $stmt -> bindParam(":contactName",  $_POST['contactName'], PDO::PARAM_STR);
            $stmt -> bindParam(":contactEmail", $_POST['contactEmail'], PDO::PARAM_STR);
            $stmt -> bindParam(":contactPhone", $_POST['contactPhone'], PDO::PARAM_STR);
            $stmt -> bindParam(":lat",          $_POST['lat'], PDO::PARAM_STR);
            $stmt -> bindParam(":lng",          $_POST['lng'], PDO::PARAM_STR);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
    }

    public function load_history($filters = array()) {
      $results = NULL;
      $sql = "SELECT hid, time, lat, lng, title FROM History h1 WHERE h1.time =
                (SELECT max(time) FROM History h2 WHERE h2.pid = h1.pid AND h2.time <= :ts) 
              ORDER BY h1.time DESC
              LIMIT :limit ";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> bindParam(':limit', $filters['limit'], PDO::PARAM_INT);
          $stmt -> bindParam(':ts', $filters['timestamp'], PDO::PARAM_STR);
          $stmt -> execute();

          while ($row = $stmt -> fetch()) {
              $results[] = array('hid' => (int) $row[0],
                                 'time' => utf8_encode($row[1]),
                                 'lat' => (float) $row[2],
                                 'lng' => (float) $row[3],
                                 'title' => utf8_encode($row[4])
                                );
          }
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return NULL;
      }

      return $results;
  }

    public function load_history_details($hid) {
        $hid = intval($hid);
        $sql = "SELECT * FROM History WHERE hid=:hid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":hid", $hid, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return NULL;
        }
    }

  public function restore_history($hid) {
      $hid = intval($hid);
      $exists = "SELECT pid FROM Projects WHERE pid = (SELECT pid FROM History WHERE hid=:hid LIMIT 1) LIMIT 1";
      $insert = "INSERT INTO Projects
                 SELECT pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, link, pic, contactName, contactEmail, contactPhone, lat, lng 
                 FROM History WHERE hid=:hid LIMIT 1";
      $update = "UPDATE Projects p, History h
                 SET p.cid = h.cid, p.title = h.title, p.status = h.status, p.startDate = h.startDate, p.endDate = h.endDate, p.buildingName = h.buildingName, p.address = h.address, p.zip = h.zip, p.type = h.type, p.summary = h.summary, p.link = h.link, p.pic = h.pic, p.contactName = h.contactName, p.contactEmail = h.contactEmail, p.contactPhone = h.contactPhone, p.lat = h.lat, p.lng = h.lng
                 WHERE p.pid = h.pid AND h.hid = :hid";
      try {
          $stmt = $this->_db->prepare($exists);
          $stmt -> bindParam(":hid", $hid, PDO::PARAM_INT);
          $stmt -> execute();
          if ($stmt->rowCount() == 0) {
            $stmt = $this->_db->prepare($insert);
            $stmt -> bindParam(":hid", $hid, PDO::PARAM_INT);
            $stmt -> execute();
          } else {
            $stmt = $this->_db->prepare($update);
            $stmt -> bindParam(":hid", $hid, PDO::PARAM_INT);
            $stmt -> execute();
          }
          return TRUE;
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return FALSE;
      }
  }

   public function restore_all_history($timestamp) {
      echo $timestamp;
      $sql = "DELETE FROM Projects;
              INSERT INTO Projects
              SELECT pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, link, pic, contactName, contactEmail, contactPhone, lat, lng 
              FROM History h1 WHERE h1.time =
                (SELECT max(time) FROM History h2 WHERE h2.pid = h1.pid AND h2.time <= :ts)";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> bindParam(":ts", $timestamp, PDO::PARAM_STR);
          $stmt -> execute();
          return TRUE;
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return FALSE;
      }
  }

  public function remove_history($hid) {
      $hid = intval($hid);
      $sql = "DELETE FROM History WHERE hid=:hid LIMIT 1";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> bindParam(":hid", $hid, PDO::PARAM_INT);
          $stmt -> execute();
          return TRUE;
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return FALSE;
      }
  }


  public function load_centers() {
      $sql = "SELECT * FROM Centers";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> execute();
          return $stmt -> fetchAll();
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return NULL;
      }

      return $results;
  }

  public function load_center($cid) {
        $cid = intval($cid);
        $sql = "SELECT * FROM Centers WHERE cid=:cid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":cid", $cid, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return NULL;
        }
    }

  public function add_center() {
    $sql = "INSERT INTO Centers(name, acronym, color) 
            VALUES (:name, :acronym, :color)";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(":name",    $_POST['name'], PDO::PARAM_STR);
        $stmt -> bindParam(":acronym", $_POST['acronym'], PDO::PARAM_STR);
        $stmt -> bindParam(":color",   $_POST['color'], PDO::PARAM_STR);
        $stmt -> execute();
        return TRUE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
}

  public function update_center() {
    $sql = "UPDATE Centers SET
              name = :name,
              acronym = :acronym,
              color = :color
            WHERE cid = :cid LIMIT 1
            ";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(":cid",     $_POST['cid'], PDO::PARAM_INT);
        $stmt -> bindParam(":name",    $_POST['name'], PDO::PARAM_STR);
        $stmt -> bindParam(":acronym", $_POST['acronym'], PDO::PARAM_STR);
        $stmt -> bindParam(":color",   $_POST['color'], PDO::PARAM_STR);
        $stmt -> execute();
        return TRUE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
}

  public function center_referred_to($cid) {
    $cid = intval($cid);
    $sql1 = "SELECT pid FROM Projects WHERE cid=:cid LIMIT 1";
    $sql2 = "SELECT pid FROM History WHERE cid=:cid LIMIT 1";
    try {
        $stmt1 = $this->_db->prepare($sql1);
        $stmt1 -> bindParam(":cid", $cid, PDO::PARAM_INT);
        $stmt1 -> execute();
        $stmt2 = $this->_db->prepare($sql2);
        $stmt2 -> bindParam(":cid", $cid, PDO::PARAM_INT);
        $stmt2 -> execute();
        if ($stmt1->rowCount() > 0 || $stmt2->rowCount() > 0)
          return TRUE;
        else
          return FALSE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
  }

  public function remove_center($cid) {
        $cid = intval($cid);
        $sql = "DELETE FROM Centers WHERE cid=:cid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":cid", $cid, PDO::PARAM_INT);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
    }

  public function load_users() {
      $sql = "SELECT * FROM Users";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> execute();
          return $stmt -> fetchAll();
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return NULL;
      }

      return $results;
  }

  public function load_user($uid) {
        $uid = intval($uid);
        $sql = "SELECT * FROM Users WHERE uid=:uid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":uid", $uid, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return NULL;
        }
    }

  public function add_user() {
    $sql = "INSERT INTO Users(email, cas, admin) 
            VALUES (:email, :cas, :admin)";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(":email", $_POST['email'], PDO::PARAM_STR);
        $stmt -> bindParam(":cas",   $_POST['cas'], PDO::PARAM_BOOL);
        $stmt -> bindParam(":admin", $_POST['admin'], PDO::PARAM_BOOL);
        $stmt -> execute();
        return TRUE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
}

  public function update_user() {
    $sql = "UPDATE Users SET
              cas = :cas,
              admin = :admin
            WHERE uid = :uid LIMIT 1
            ";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(":uid",   $_POST['uid'], PDO::PARAM_INT);
        $stmt -> bindParam(":cas",   $_POST['cas'], PDO::PARAM_BOOL);
        $stmt -> bindParam(":admin", $_POST['admin'], PDO::PARAM_BOOL);
        $stmt -> execute();
        return TRUE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
}

  public function remove_user($uid) {
        $uid = intval($uid);
        $sql = "DELETE FROM Users WHERE uid=:uid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":uid", $uid, PDO::PARAM_INT);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
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

    /**
     * Removes an individual entry from the database. Returns if operation was successful.
     * @param $id int   The ID of the entry you want to remove
     * @return bool     TRUE if successfully removed, FALSE otherwise
     */
    public function remove_project($pid) {
        $pid = intval($pid);
        $sql = "DELETE FROM Projects WHERE pid=:pid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":pid", $pid, PDO::PARAM_INT);
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
    public function load_project_details($pid) {
        $pid = intval($pid);
        $sql = "SELECT * FROM Projects WHERE pid=:pid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":pid", $pid, PDO::PARAM_INT);
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
    /*
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
    */



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


    public function generate_prefetch() {
      $sql = "SELECT title, buildingName, address, zip, contactName FROM Projects";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> execute();

          $file = fopen("search.json", "w");
          fwrite($file, "[");
          while ($row = $stmt->fetch()) {
            foreach ($row as $col) {
              fwrite($file, '"');
              fwrite($file, $col);
              fwrite($file, '",');
            }
          }
          fwrite($file, '""]');
          fclose($file);
      } catch(PDOException $e) {
          echo $e -> getMessage();
      }
    }

}