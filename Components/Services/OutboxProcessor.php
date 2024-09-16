<?php

namespace Components\Services;

use PDO;

class OutboxProcessor
{
    const ERROR_LIMIT = 5;
    const BATCH_SIZE = 1000;
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function processOutbox(int $batchSize = self::BATCH_SIZE): void
    {
        $sql = "SELECT * FROM outbox WHERE status = 'pending' LIMIT :batchSize";
        $stmt = $this->pdo->prepare($sql);
        try {
            $stmt->bindParam(':batchSize', $batchSize, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Exception $e) {
            error_log("Error fetching messages from outbox: " . $e->getMessage());
            return;
        }

        $messages = $stmt->fetchAll();
        foreach ($messages as $message) {
            $success = $this->sendToMicroservice($message['type'], $message['payload']);

            if ($success) {
                $this->markAsSent($message['id']);
            } else {
                $this->incrementRetries($message['id']);
            }
        }
    }

    private function sendToMicroservice(string $type, string $payload): bool
    {
        // Здесь должен быть код отправки сообщения в микросервис
        // Сэмулируем с помощью таблицы fake_microservice
        $counter = 0;
        while($counter < 5000){
            $counter++;
            $this->pdo
                ->prepare("INSERT INTO fake_microservice (type, payload) VALUES (:type, :payload)")
                ->execute([':type' => $type, ':payload' => $payload]);
        }
        return true; // Предполагаем, что микросервис вернул "success"
    }

    private function markAsSent(int $id): void
    {
        $sql = "UPDATE outbox SET status = 'sent', updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    private function incrementRetries(int $id): void
    {
        $sql = "UPDATE outbox SET retries = retries + 1, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Логируем превышение лимита попыток
        $stmt = $this->pdo->prepare("SELECT retries FROM outbox WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $retries = $stmt->fetch()['retries'];

        if ($retries >= self::ERROR_LIMIT) {
            $sql = "UPDATE outbox SET status = 'failed', updated_at = NOW() WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            error_log("Message $id failed after $retries retries");
        }
    }
}
