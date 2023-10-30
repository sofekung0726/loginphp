<?php
class Login
{
    private $db;

    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function authenticate($username, $password)
    {
        // Prepare SQL query
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if ($password == $user['password']) {
                // Login successful
                return true;
            }
        }

        // Login failed
        return false;
    }
}
