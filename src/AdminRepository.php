<?php

namespace Itb;

$_SESSION['adminName'] = array();
$_SESSION['adminPassword'] = array();


class AdminRepository
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

    public function dropAdminTable()
    {
        $sql = "DROP TABLE IF EXISTS Admin";
        $this->connection->exec($sql);
    }

    public function createAdminTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS Admin
        (id integer not null primary key auto_increment,
        aName text not null,
        aPassword text not null)";

        $this->connection->exec($sql);
    }

    public function getAllFromAdmin()
    {
        $sql = 'SELECT * FROM Admin';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Admin');

        $staff = $stmt->fetchAll();

        return $staff;
    }

    public function deleteAllFromAdmin()
    {
        $sql = 'DELETE FROM Admin';
        $numRowsAffected = $this->connection->exec($sql);
        return $numRowsAffected;
    }

    public function insertIntoAdmin($aName, $aPassword)
    {
        // Prepare INSERT statement to SQLite3 file db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = 'INSERT INTO Admin (aName, aPassword) VALUES (:aName, :aPassword)';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':aName', $aName);
        $stmt->bindParam(':aPassword', $aPassword);

        // Execute statement
        $noError = $stmt->execute();

        if($noError)
        {
            $_SESSION['adminName'][] = $aName;
            $_SESSION['adminPassword'][] = $aPassword;

            return $this->connection->lastInsertId();
        }
        else
        {
            return false;
        }
    }

    public function deleteFromAdmin($id)
    {
        // Prepare SQL
        $sql = 'DELETE FROM Admin WHERE id = :id';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);

        // Execute statement
        $noError = $stmt->execute();

        // does NOT imply any rows were deleted ...
        return $noError;
    }

    public function getOneFromAdmin($id)
    {
        $sql = 'SELECT * FROM Admin WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Admin');

        if ($Admin = $stmt->fetch())
        {
            return $Admin;
        }

        else
        {
            return null;
        }
    }

    public function getNameFromAdmin($id)
    {
        $sql = 'SELECT aName FROM Admin WHERE id = :id';

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aName', $aName);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Admin');

        if ($staff = $stmt->fetch())
        {
            return $staff;
        }

        else
        {
            return null;
        }
    }

    public function getPasswordFromAdmin($id)
    {
        $sql = 'SELECT aPassword FROM Admin WHERE id = :id';

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aPassword', $aPassword);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Admin');

        if ($staff = $stmt->fetch())
        {
            return $staff;
        }

        else
        {
            return null;
        }
    }

    public function updateAdmin($id, $aName, $aPassword)
    {
        // Prepare INSERT statement to SQL db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = "UPDATE Admin SET aName = :aName, aPassword = :aPassword WHERE id=:id";

        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aName', $aName);
        $stmt->bindParam(':aPassword', $aPassword);

        $_SESSION['adminName'][] = $aName;
        $_SESSION['adminPassword'][] = $aPassword;

        // Execute statement
        $noError = $stmt->execute();

        // does NOT imply any rows were inserted ...
        return $noError;
    }
}