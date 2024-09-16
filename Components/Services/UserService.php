<?php

namespace Components\Services;

use Components\Repositories\TransactionalOutboxRepository;
use PDO;

class UserService
{
    private PDO $pdo;
    private TransactionalOutboxRepository $outbox;

    public function __construct(PDO $pdo, TransactionalOutboxRepository $outbox)
    {
        $this->pdo = $pdo;
        $this->outbox = $outbox;
    }

    public function notifyAllUsersByNumber(string $type, array $payload): void
    {
        $users = $this->getUsersGenerator();
        if($users->current() === false) {
            throw new \Exception('No users found', 404);
        }
        try {
            $this->pdo->beginTransaction();
            foreach ($users as $user) {
                $this->outbox->addToOutbox($type, [
                    'number' => $user['number'],
                    'subject' => $payload['subject'],
                    'message' => $payload['message']
                ]);
            }
            $this->pdo->commit();

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw new \Exception('Failed to notify users', 500);
        }
    }

    public function getUsersGenerator(): \Generator
    {
        $stmt = $this->pdo->query('SELECT number, name FROM users');
        while ($row = $stmt->fetch()) {
            yield $row;
        }
    }
}
