<?php

namespace Itb;

$_SESSION['staffName'] = array();
$_SESSION['staffPassword'] = array();


class StaffRepository
{
    private $connection;

    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getConnection();

        if(null == $this->connection){
            die('there was an error connection to the database');
        }
    }

    public function dropStaffTable()
    {
        $sql = "DROP TABLE IF EXISTS Staff";
        $this->connection->exec($sql);
    }

    public function createStaffTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS Staff
        (id integer not null primary key auto_increment,
        aName text not null,
        aPassword text not null)";

        $this->connection->exec($sql);
    }

    public function getAllFromStaff()
    {
        $sql = 'SELECT * FROM Staff';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Staff');

        $staff = $stmt->fetchAll();

        return $staff;
    }

    public function deleteAllFromStaff()
    {
        $sql = 'DELETE FROM Staff';
        $numRowsAffected = $this->connection->exec($sql);
        return $numRowsAffected;
    }

    public function insertIntoStaff($aName, $aPassword)
    {
        // Prepare INSERT statement to SQLite3 file db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = 'INSERT INTO Staff (aName, aPassword) VALUES (:aName, :aPassword)';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':aName', $aName);
        $stmt->bindParam(':aPassword', $aPassword);

        // Execute statement
        $noError = $stmt->execute();

        if($noError)
        {
            $_SESSION['staffName'] = $aName;
            $_SESSION['staffPassword'] = $aPassword;

            return $this->connection->lastInsertId();
        }

        else
        {
            return false;
        }
    }

    public function deleteOneFromStaff($id)
    {
        // Prepare SQL
        $sql = 'DELETE FROM Staff WHERE id = :id';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);

        // Execute statement
        $noError = $stmt->execute();

        // does NOT imply any rows were deleted ...
        return $noError;
    }

    public function getOneFromStaff($id)
    {
        $sql = 'SELECT * FROM Staff WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Staff');

        if ($staff = $stmt->fetch())
        {
            return $staff;
        }

        else
        {
            return null;
        }
    }

    public function getNameFromStaff($id)
    {
        $sql = 'SELECT aName FROM Staff WHERE id = :id';

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aName', $aName);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Staff');

        if ($staff = $stmt->fetch()) {
            return $staff;
        } else {
            return null;
        }
    }

    public function updateStaff($id, $aName, $aPassword)
    {
        // Prepare INSERT statement to SQL db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = "UPDATE Staff SET aName = :aName, aPassword = :aPassword WHERE id=:id";

        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aName', $aName);
        $stmt->bindParam(':aPassword', $aPassword);

        $_SESSION['staffName'][] = $aName;
        $_SESSION['staffPassword'][] = $aPassword;


        // Execute statement
        $noError = $stmt->execute();

        // does NOT imply any rows were inserted ...
        return $noError;
    }
}