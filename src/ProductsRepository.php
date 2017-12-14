<?php
namespace Itb;

class ProductsRepository
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

    public function dropProductsTable()
    {
        $sql = "DROP TABLE IF EXISTS Products";
        $this->connection->exec($sql);
    }

    public function createProductsTable()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS Products
        (id integer not null primary key auto_increment,
        image text,
        description VARCHAR(40),
        price DOUBLE not null)";

        $this->connection->exec($sql);
    }

    public function getAllFromProducts()
    {
        $sql = 'SELECT * FROM Products';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Product');

        $products = $stmt->fetchAll();

        return $products;
    }

    public function deleteAllFromProducts()
    {
        $sql = 'DELETE FROM Products';
        $numRowsAffected = $this->connection->exec($sql);
        return $numRowsAffected;
    }

    public function insertIntoProducts($image, $description, $price)
    {
        // Prepare INSERT statement to SQLite3 file db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = 'INSERT INTO products (image, description, price) VALUES (:image, :description, :price)';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);

        // Execute statement
        $noError = $stmt->execute();

        if($noError)
        {
            return $this->connection->lastInsertId();
        }

        else
        {
            return false;
        }
    }

    public function deleteOneFromProducts($id)
    {
        // Prepare SQL
        $sql = 'DELETE FROM Products WHERE id = :id';
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);

        // Execute statement
        $noError = $stmt->execute();

        // does NOT imply any rows were deleted ...
        return $noError;
    }

    public function getOneFromProducts($id)
    {
        $sql = 'SELECT * FROM Products WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Itb\\Product');

        if ($product = $stmt->fetch())
        {
            return $product;
        }
        else
        {
            return null;
        }
    }

    public function updateProducts($id, $image, $description, $price)
    {
        // Prepare INSERT statement to SQL db
        // no ID since that is AUTO-INCREMENTED by DB
        $sql = "UPDATE Products SET description = :description, price = :price, image = :image WHERE id=:id";

        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);

        // Execute statement
        $noError = $stmt->execute();

        // does NOT imply any rows were inserted ...
        return $noError;
    }
}