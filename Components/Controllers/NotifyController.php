<?php

namespace Components\Controllers;

use Components\Contracts\ControllerInterface;
use Components\Contracts\PageInterface;
use Components\Contracts\RenderInterface;
use Components\DB;
use Components\Pages\Notify;
use Components\Repositories\TransactionalOutboxRepository;
use Components\Services\OutboxProcessor;
use Components\Services\UserService;
use Components\Utils\RenderHTML;

final class NotifyController implements ControllerInterface
{
    private RenderInterface $renderer;
    private PageInterface $page;
    private OutboxProcessor $manualProcessing;
    private \PDO $db;

    public function __construct()
    {
        $this->db = DB::getInstance()->getConnection();
        $this->page = new Notify();
        $this->renderer = new RenderHTML();
        $this->transactionalRepository= new TransactionalOutboxRepository($this->db);
        $this->notyficationService = new UserService($this->db, $this->transactionalRepository);
        $this->manualProcessing = new OutboxProcessor($this->db);
    }

    public function index(): void
    {
        $this->renderer->render($this->page->getHtml());
    }

    public function notify(): void
    {
        $type = 'sms';
        $payload = $this->getNotifyMessageData();
        $this->notyficationService->notifyAllUsersByNumber($type, $payload);
        $this->manualProcessing->processOutbox();
    }

    function validateInput(array &$postData): void
    {
        foreach ($postData as $key => $value) {
            $postData[$key] = htmlspecialchars($value);
        }
    }

    private function getNotifyMessageData()
    {
        $postData = $_POST;
        if ($postData['subject'] === '' || $postData['message'] === '') {
            throw new \Exception('No data found in POST request', 400);
        }

        $this->validateInput($postData);

        return $postData;
    }

}