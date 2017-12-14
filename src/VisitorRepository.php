<?php

namespace Itb;

$_SESSION['visitorName'] = array();
$_SESSION['visitorPassword'] = array();

class VisitorRepository
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

    public function dropVisitorTable()
    {
        $sql = "DROP TABLE IF EXISTS Visitor";
        $this->connection->exec($sql);
    }

    public function createVisitorTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS Visitor
        (id integer not null primary key auto_increment,
        aName text not null,
        aEmail text,
        aPassword text not null,
        emailNotify text)";

        $this->connection->exec($sql);
    }

    public function getAllFromVisitor()
    {
        $sql = 'SELECT * FROM Visitor';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Visitor');

        $Visitor = $stmt->fetchAll();

        return $Visitor;
    }

    public function deleteAllFromVisitor()
    {
        $sql = 'DELETE FROM Visitor';
        $numRowsAffected = $this->connection->exec($sql);
        return $numRowsAffected;
    }

    public function insertIntoVisitor($aName, $aEmail, $aPassword, $emailNotify)
    {
        // Prepare INSERT statement to SQLite3 file db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = 'INSERT INTO Visitor (aName, aEmail, aPassword, emailNotify) VALUES (:aName, :aEmail, :aPassword, :emailNotify)';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':aName', $aName);
        $stmt->bindParam(':aEmail', $aEmail);
        $stmt->bindParam(':aPassword', $aPassword);
        $stmt->bindParam(':emailNotify', $emailNotify);

        // Execute statement
        $noError = $stmt->execute();

        if($noError)
        {
            $_SESSION['visitorName'][] = $aName;
            $_SESSION['visitorPassword'][] = $aPassword;

            return $this->connection->lastInsertId();
        }

        else
        {
            return false;
        }
    }

    public function deleteOneFromVisitor($id)
    {
        // Prepare SQL
        $sql = 'DELETE FROM Visitor WHERE id = :id';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);

        // Execute statement
        $noError = $stmt->execute();

        // does NOT imply any rows were deleted ...
        return $noError;
    }

    public function getOneFromVisitor($id)
    {
        $sql = 'SELECT * FROM Visitor WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Visitor');

        if ($Visitor = $stmt->fetch())
        {
            return $Visitor;
        }

        else
        {
            return null;
        }
    }

    public function getNameFromVisitor($id)
    {
        $sql = 'SELECT aName FROM Visitor WHERE id = :id';

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aName', $aName);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Visitor');

        if ($Visitor = $stmt->fetch())
        {
            return $Visitor;
        }

        else
        {
            return null;
        }
    }

    public function updateVisitor($id, $aName, $aEmail, $aPassword, $emailNotify)
    {
        // Prepare INSERT statement to SQL db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = "UPDATE Visitor SET aName = :aName, aEmail = :aEmail, aPassword = :aPassword, emailNotify = :emailNotify WHERE id=:id";

        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':aName', $aName);
        $stmt->bindParam(':aEmail', $aEmail);
        $stmt->bindParam(':aPassword', $aPassword);
        $stmt->bindParam(':emailNotify', $emailNotify);

        $_SESSION['visitorName'][] = $aName;
        $_SESSION['visitorPassword'][] = $aPassword;

        // Execute statement
        $noError = $stmt->execute();



        // does NOT imply any rows were inserted ...
        return $noError;
    }
}