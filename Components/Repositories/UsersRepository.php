<?php

namespace Components\Repositories;

final class UsersRepository
{
    public function __construct($dbConnection)
    {
        $this->pdo = $dbConnection;
    }

    public function saveBatch($data): void
    {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO users (number, name) VALUES (:number, :name)");
            foreach ($data as $user) {
                $stmt->execute([':number' => $user[0], ':name' => $user[1]]);
            }
            $this->pdo->commit();
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            echo $e->getMessage();
            throw new \Exception('Error saving users in database');
        }
    }
}