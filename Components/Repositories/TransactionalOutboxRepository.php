<?php

namespace Components\Repositories;

use PDO;

class TransactionalOutboxRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addToOutbox(string $type, array $payload): bool
    {
        $sql = "INSERT INTO outbox (type, payload, status, retries) VALUES (:type, :payload, 'pending', 0)";
        $stmt = $this->pdo->prepare($sql);
        $payloadJson = json_encode($payload);
        return $stmt->execute([
            ':type' => $type,
            ':payload' => $payloadJson
        ]);
    }

}