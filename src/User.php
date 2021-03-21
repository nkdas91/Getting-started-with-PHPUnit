<?php declare(strict_types=1);

class User
{
    protected $db = null;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserData(string $email): array
    {
        $sql = "SELECT id, firstname, lastname, age 
                FROM user 
                WHERE email = '" . $email . "'";
        $result = $this->db->query($sql);

        if (!$result->num_rows) {
            return [];
        }

        return $result->fetch_assoc();
    }

    public function isEligibleToVote(string $email): string
    {
        $user = $this->getUserData($email);

        if (empty($user)) {
            return 'User Not Found';
        }

        return $user['age'] >= 18 ? 'Eligible To Vote' : 'Not Eligible To Vote';
    }
}
