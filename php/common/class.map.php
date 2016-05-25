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
  * Add a user to the User table, data comes from POST
  *
  */
  public function insert_user($fname, $lname, $phone, $email, $password) {
    
    $sql = "INSERT INTO Users(email, firstName, lastName, phone, authenticated, password, root) 
            VALUES (:email, :fname, :lname, :phone, '0', :password, '0')";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(":fname", $fname, PDO::PARAM_STR);
        $stmt -> bindParam(":lname", $lname, PDO::PARAM_STR);
        $stmt -> bindParam(":phone", $phone, PDO::PARAM_STR);
        $stmt -> bindParam(":email", $email, PDO::PARAM_STR);
        $stmt -> bindParam(":password", $password, PDO::PARAM_STR);
        $stmt -> execute();
        return TRUE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
  }

/**
  * Return the details of a specific user for login
  *
  */
  public function login_user($email) {
        
        $sql = "SELECT * FROM Users WHERE email=:email LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":email", $email, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return NULL;
        }
  }

    /**
    * Load all projects that meet the filter requirements. 
    *
    */
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
      $sql = "SELECT pid, lat, lng, title FROM Projects WHERE lat >= :minLat AND lat <= :maxLat AND lng >= :minLng AND lng <= :maxLng AND visible = true
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
  * Return a list of all the projects found in the database
  *
  */
  public function load_projects_full() {
      $sql = "SELECT * FROM Projects LEFT JOIN Centers ON Projects.cid=Centers.cid ORDER BY acronym ASC";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> execute();
          return $stmt -> fetchAll();
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return NULL;
      }

      return NULL;
  }

    /**
     * Test function to create entry in the database.
     * Must be set: POST, POST[address], POST[title], POST[description]
     * @return bool
     */
    public function add_project() {
      $sql = "INSERT INTO Projects(cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, results, link, pic, conid, fundedBy, keywords, stemmedSearchText, visible, lat, lng) 
              VALUES (:cid, :title, :status, :startDate, :endDate, :buildingName, :address, :zip, :type, :summary, :results, :link, :pic, :conid, :fundedBy, :keywords, :stemmedSearchText, :visible, :lat, :lng);
              INSERT INTO History(pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, results, link, pic, conid, fundedBy, keywords, stemmedSearchText, visible, lat, lng) 
              VALUES ((SELECT MAX(pid) FROM Projects),:cid, :title, :status, :startDate, :endDate, :buildingName, :address, :zip, :type, :summary, :results, :link, :pic, :conid, :fundedBy, :keywords, :stemmedSearchText, :visible, :lat, :lng)";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> bindParam(":cid",               $_POST['cid'], PDO::PARAM_INT);
          $stmt -> bindParam(":title",             $_POST['title'], PDO::PARAM_STR);
          $stmt -> bindParam(":status",            $_POST['status'], PDO::PARAM_INT);
          $stmt -> bindParam(":startDate",         $_POST['startDate'], PDO::PARAM_STR);
          $stmt -> bindParam(":endDate",           $_POST['endDate'], PDO::PARAM_STR);
          $stmt -> bindParam(":buildingName",      $_POST['buildingName'], PDO::PARAM_STR);
          $stmt -> bindParam(":address",           $_POST['address'], PDO::PARAM_STR);
          $stmt -> bindParam(":zip",               $_POST['zip'], PDO::PARAM_INT);
          $stmt -> bindParam(":type",              $_POST['type'], PDO::PARAM_INT);
          $stmt -> bindParam(":summary",           $_POST['summary'], PDO::PARAM_STR);
          $stmt -> bindParam(":results",           $_POST['results'], PDO::PARAM_STR);
          $stmt -> bindParam(":link",              $_POST['link'], PDO::PARAM_STR);
          $stmt -> bindParam(":pic",              $_POST['pic'], PDO::PARAM_STR);
          $stmt -> bindParam(":conid",             $_POST['conid'], PDO::PARAM_INT);
          $stmt -> bindParam(":fundedBy",          $_POST['fundedBy'], PDO::PARAM_STR);
          $stmt -> bindParam(":keywords",          $_POST['keywords'], PDO::PARAM_STR);
          $stmt -> bindParam(":stemmedSearchText", $_POST['stemmedSearchText'], PDO::PARAM_STR);
          $stmt -> bindParam(":visible",           $_POST['visible'], PDO::PARAM_BOOL);
          $stmt -> bindParam(":lat",               $_POST['lat'], PDO::PARAM_STR);
          $stmt -> bindParam(":lng",               $_POST['lng'], PDO::PARAM_STR);
          $stmt -> execute();
          return TRUE;
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return FALSE;
      }
    }

    /**
    * Update a project in the database and add a new entry to the history, requires all columns of data to be present in POST
    *
    */
    public function update_project() {
        $sql = "UPDATE Projects SET cid = :cid, title = :title, status = :status, startDate = :startDate, endDate = :endDate, buildingName = :buildingName, address = :address, zip = :zip, type = :type, summary = :summary, results = :results,
                                    link = :link, pic = :pic, conid = :conid, fundedBy = :fundedBy, keywords = :keywords, stemmedSearchText = :stemmedSearchText, visible = :visible, lat = :lat, lng = :lng WHERE pid = :pid LIMIT 1;
                INSERT INTO History(pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, results, link, pic, conid, fundedBy, keywords, stemmedSearchText, visible, lat, lng) 
                VALUES (:pid, :cid, :title, :status, :startDate, :endDate, :buildingName, :address, :zip, :type, :summary, :results, :link, :pic, :conid, :fundedBy, :keywords, :stemmedSearchText, :visible, :lat, :lng)";

        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":pid",               $_POST['pid'], PDO::PARAM_INT);
            $stmt -> bindParam(":cid",               $_POST['cid'], PDO::PARAM_INT);
            $stmt -> bindParam(":title",             $_POST['title'], PDO::PARAM_STR);
            $stmt -> bindParam(":status",            $_POST['status'], PDO::PARAM_INT);
            $stmt -> bindParam(":startDate",         $_POST['startDate'], PDO::PARAM_STR);
            $stmt -> bindParam(":endDate",           $_POST['endDate'], PDO::PARAM_STR);
            $stmt -> bindParam(":buildingName",      $_POST['buildingName'], PDO::PARAM_STR);
            $stmt -> bindParam(":address",           $_POST['address'], PDO::PARAM_STR);
            $stmt -> bindParam(":zip",               $_POST['zip'], PDO::PARAM_INT);
            $stmt -> bindParam(":type",              $_POST['type'], PDO::PARAM_INT);
            $stmt -> bindParam(":summary",           $_POST['summary'], PDO::PARAM_STR);
            $stmt -> bindParam(":results",           $_POST['results'], PDO::PARAM_STR);
            $stmt -> bindParam(":link",              $_POST['link'], PDO::PARAM_STR);
            $stmt -> bindParam(":pic",               $_POST['pic'], PDO::PARAM_STR);
            $stmt -> bindParam(":conid",              $_POST['conid'], PDO::PARAM_INT);
            $stmt -> bindParam(":fundedBy",          $_POST['fundedBy'], PDO::PARAM_STR);
            $stmt -> bindParam(":keywords",          $_POST['keywords'], PDO::PARAM_STR);
            $stmt -> bindParam(":stemmedSearchText", $_POST['stemmedSearchText'], PDO::PARAM_STR);
            $stmt -> bindParam(":visible",           $_POST['visible'], PDO::PARAM_BOOL);
            $stmt -> bindParam(":lat",               $_POST['lat'], PDO::PARAM_STR);
            $stmt -> bindParam(":lng",               $_POST['lng'], PDO::PARAM_STR);
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
        $sql = "DELETE FROM Projects WHERE pid=:pid LIMIT 1;";
        $getHid = "SELECT hid FROM History WHERE time = (SELECT max(time) FROM History h2 WHERE h2.pid = :pid) AND pid = :pid LIMIT 1;";
        $updateHistory = "UPDATE History SET deleted = NOW() WHERE hid = :hid;";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":pid", $pid, PDO::PARAM_INT);
            $stmt -> execute();
            $stmt = $this->_db->prepare($getHid);
            $stmt -> bindParam(":pid", $pid, PDO::PARAM_INT);
            $stmt -> execute();
            $hid = $stmt->fetch()['hid'];
            echo $hid;
            $stmt = $this->_db->prepare($updateHistory);
            $stmt -> bindParam(":hid", $hid, PDO::PARAM_INT);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
    }

    public function set_project_visible($pid, $visible) {
        $pid = intval($pid);
        $sql = "UPDATE Projects SET visible = :visible WHERE pid = :pid LIMIT 1;";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":pid", $pid, PDO::PARAM_INT);
            $stmt -> bindParam(":visible", $visible, PDO::PARAM_INT);
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
    * Load the most recent versions of each unique project up to the given timestamp from the History table, only returns a few select columns
    *
    */
    public function load_history($filters = array()) {
      $results = NULL;
      $sql = "SELECT hid, time, lat, lng, title FROM History h1 WHERE h1.time =
                (SELECT max(time) FROM History h2 WHERE h2.pid = h1.pid AND h2.time <= :ts) AND h1.deleted > :ts 
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

      /**
    * Load the most recent versions of each unique project up to the given timestamp from the History table, only returns a few select columns
    *
    */
    public function load_history_full($filters = array()) {
      $sql = "SELECT * FROM (SELECT * FROM History h1 WHERE h1.time =
                (SELECT max(time) FROM History h2 WHERE h2.pid = h1.pid AND h2.time <= :ts) AND h1.deleted > :ts) h
              LEFT JOIN Users ON h.editedBy = Users.uid
              LEFT JOIN Centers ON h.cid = Centers.cid
              ORDER BY acronym ASC LIMIT :limit";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> bindParam(':limit', $filters['limit'], PDO::PARAM_INT);
          $stmt -> bindParam(':ts', $filters['timestamp'], PDO::PARAM_STR);
          $stmt -> execute();

          return $stmt -> fetchAll();
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return NULL;
      }

      return NULL;
  }


  /**
  * Return the all the columns of the history for a given history id (hid)
  *
  */
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

  /**
  * Restore an item from the history to the project table. Check to see if the unique pid of the project already exists in the project table, if so update, if not insert into the table.
  *
  */
  public function restore_history($hid) {
      $hid = intval($hid);
      $exists = "SELECT pid FROM Projects WHERE pid = (SELECT pid FROM History WHERE hid=:hid LIMIT 1) LIMIT 1";
      $insert = "INSERT INTO Projects
                 SELECT pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, results, link, pic, conid, fundedBy, keywords, stemmedSearchText, visible, lat, lng 
                 FROM History WHERE hid=:hid LIMIT 1";
      $update = "UPDATE Projects p, History h
                 SET p.cid = h.cid, p.title = h.title, p.status = h.status, p.startDate = h.startDate, p.endDate = h.endDate, p.buildingName = h.buildingName, p.address = h.address, p.zip = h.zip, p.type = h.type, p.summary = h.summary, p.results = h.results, p.link = h.link, p.pic = h.pic, p.conid = h.conid, p.fundedBy = h.fundedBy, p.keywords = h.keywords, p.stemmedSearchText = h.stemmedSearchText, p.visible = h.visible, p.lat = h.lat, p.lng = h.lng
                 WHERE p.pid = h.pid AND h.hid = :hid";
      $history ="INSERT INTO History (SELECT pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, results, link, pic, conid, fundedBy, keywords, stemmedSearchText, visible, lat, lng FROM History WHERE hid = :hid);";
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
          $stmt = $this->_db->prepare($history);
          $stmt -> bindParam(":hid", $hid, PDO::PARAM_INT);
          $stmt -> execute();
          return TRUE;
      } catch(PDOException $e) {
          echo $e -> getMessage();
          return FALSE;
      }
  }

  /**
  * Restore all items from the history at a given timestamp to the project table. First delete all contents of the project table
  * and then insert all qualifying items from the history table into the project table.
  *
  */
  public function restore_all_history($timestamp) {
      echo $timestamp;
      $sql = "DELETE FROM Projects;
              INSERT INTO Projects
              SELECT pid, cid, title, status, startDate, endDate, buildingName, address, zip, type, summary, results, link, pic, conid, fundedBy, keywords, stemmedSearchText, visible, lat, lng 
              FROM History h1 WHERE h1.time =
                (SELECT max(time) FROM History h2 WHERE h2.pid = h1.pid AND h2.time <= :ts) AND h1.deleted > :ts;
              INSERT INTO History (SELECT * FROM Projects);";
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

  /**
  * Remove an item from the history table by its history id (hid)
  *
  */
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

  /**
  * Return a list of all the centers found in the database
  *
  */
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

  /**
  * Load the details of a specific center by its center id (cid)
  *
  */
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

  /**
  * Add a new center to the Center table
  *
  */
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

  /**
  * Update an existing center in the Center table
  *
  */
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

  /**
  * Checks whether there are any projects that reference a given center id (cid), if true the user won't be able to delete that center
  *
  */
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

  /**
  * Remove a given center from the Center table by its center id (cid)
  *
  */
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

    /**
  * Return a list of all the contacts found in the database
  *
  */
  public function load_contacts() {
      $sql = "SELECT * FROM Contacts";
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

  /**
  * Load the details of a specific contact by his/her contact id (conid)
  *
  */
  public function load_contact($conid) {
        $conid = intval($conid);
        $sql = "SELECT * FROM Contacts WHERE conid=:conid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":conid", $conid, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt -> fetch();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return NULL;
        }
    }

  /**
  * Add a new center to the Contact table
  *
  */
  public function add_contact() {
    $sql = "INSERT INTO Contacts(name, email, phone) 
            VALUES (:name, :email, :phone)";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(":name",    $_POST['name'], PDO::PARAM_STR);
        $stmt -> bindParam(":email", $_POST['email'], PDO::PARAM_STR);
        $stmt -> bindParam(":phone",   $_POST['phone'], PDO::PARAM_STR);
        $stmt -> execute();
        return TRUE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
  }

  /**
  * Update an existing center in the Contact table
  *
  */
  public function update_contact() {
    $sql = "UPDATE Contacts SET
              name = :name,
              email = :email,
              phone = :phone
            WHERE conid = :conid LIMIT 1
            ";
    try {
        $stmt = $this->_db->prepare($sql);
        $stmt -> bindParam(":conid",     $_POST['conid'], PDO::PARAM_INT);
        $stmt -> bindParam(":name",    $_POST['name'], PDO::PARAM_STR);
        $stmt -> bindParam(":email", $_POST['email'], PDO::PARAM_STR);
        $stmt -> bindParam(":phone",   $_POST['phone'], PDO::PARAM_STR);
        $stmt -> execute();
        return TRUE;
    } catch(PDOException $e) {
        echo $e -> getMessage();
        return FALSE;
    }
  }

  /**
  * Checks whether there are any projects that reference a given contact id (conid), if true the user won't be able to delete that center
  *
  */
  public function contact_referred_to($conid) {
    $conid = intval($conid);
    $sql1 = "SELECT pid FROM Projects WHERE conid=:conid LIMIT 1";
    $sql2 = "SELECT pid FROM History WHERE conid=:conid LIMIT 1";
    try {
        $stmt1 = $this->_db->prepare($sql1);
        $stmt1 -> bindParam(":conid", $conid, PDO::PARAM_INT);
        $stmt1 -> execute();
        $stmt2 = $this->_db->prepare($sql2);
        $stmt2 -> bindParam(":conid", $conid, PDO::PARAM_INT);
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

  /**
  * Remove a given center from the Center table by its contact id (conid)
  *
  */
  public function remove_contact($conid) {
        $conid = intval($conid);
        $sql = "DELETE FROM Contacts WHERE conid=:conid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":conid", $conid, PDO::PARAM_INT);
            $stmt -> execute();
            return TRUE;
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
  }


  /**
  * Return the list of users in the User table
  *
  */
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

  /**
  * Return the details of a specific user based on their user id (uid)
  *
  */
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

  /**
  * Add a user to the User table, data comes from POST
  *
  */
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

  /**
  * Update a user's information, user id (uid) comes from POST
  *
  */
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

  /**
  * Remove a user from the User table based on their user id (uid)
  *
  */
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
    * Search the Projects table for any projects whose stemmedSearchText column matches the give search text
    */
    public function search($searchPhrase) {
        $sql = "SELECT title FROM Projects WHERE MATCH (stemmedSearchText) AGAINST (:searchPhrase IN BOOLEAN MODE) AND visible = TRUE LIMIT 10";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":searchPhrase", $searchPhrase, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }

        return NULL;
    }

    /**
    * Compile all searchable fields into a json file which will be sent to end users of the map for search suggestions. This is called any time a project is added, edited, or deleted.
    *
    */
    public function generate_prefetch() {
      $sql = "SELECT title, buildingName, address, zip, name
              FROM (SELECT title, buildingName, address, zip, name, visible FROM Projects LEFT JOIN Contacts ON Projects.conid = Contacts.conid) p 
              WHERE p.visible = TRUE";
      try {
          $stmt = $this->_db->prepare($sql);
          $stmt -> execute();

          $searchText = array();
          while ($row = $stmt->fetch()) {
            foreach ($row as $col) {
              if (strlen($col) > 0 && !in_array($col, $searchText))
                $searchText[] = $col;
            }
          }

          $file = fopen("../../../json/search.json", "w");
          fwrite($file, "[");
          $first = true;
          for($i = 0; $i < count($searchText); $i++) {
            if (!$first)
              fwrite($file, ',');
            else 
              $first = false;

            fwrite($file, '"');
            fwrite($file, $searchText[$i]);
            fwrite($file, '"');
            
          }
          fwrite($file, ']');
          fclose($file);
      } catch(PDOException $e) {
          echo $e -> getMessage();
      }
    }

    /**
     * Removes project picture link from database (sets to empty string)
     *
     * @param int $pid      Project ID
     * @return bool         TRUE on successful execution
     */
    public function delete_picture($pid) {
        $pid = intval($pid);
        $sql = "UPDATE Projects SET Pic='' WHERE pid=:pid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":pid", $pid, PDO::PARAM_INT);
            $stmt -> execute();
            $stmt -> closeCursor();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Saves picture link to database
     *
     * @param int $pid      Project ID
     * @param string $url   The picture URL
     * @return bool         TRUE on successful execution
     */
    public function save_picture($pid, $url) {
        $pid = intval($pid);
        $sql = "UPDATE Projects SET Pic=:url WHERE pid=:pid LIMIT 1";
        try {
            $stmt = $this->_db->prepare($sql);
            $stmt -> bindParam(":url", $url, PDO::PARAM_STR);
            $stmt -> bindParam(":pid", $pid, PDO::PARAM_INT);
            $stmt -> execute();
            $stmt -> closeCursor();
        } catch(PDOException $e) {
            echo $e -> getMessage();
            return FALSE;
        }
        return TRUE;
    }



}