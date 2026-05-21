<?php

namespace App\Mail\Transport;

use GuzzleHttp\Client;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

class BrevoApiTransport extends AbstractTransport
{
    private Client $client;

    public function __construct(private string $apiKey)
    {
        parent::__construct();

        $this->client = new Client();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $payload = [
            'subject' => $email->getSubject() ?? '',
        ];

        if ($from = $email->getFrom()) {
            $payload['sender'] = $this->formatAddress($from[0]);
        }

        $payload['to'] = $this->formatAddresses($email->getTo());

        if ($cc = $email->getCc()) {
            $payload['cc'] = $this->formatAddresses($cc);
        }

        if ($bcc = $email->getBcc()) {
            $payload['bcc'] = $this->formatAddresses($bcc);
        }

        if ($replyTo = $email->getReplyTo()) {
            $payload['replyTo'] = $this->formatAddress($replyTo[0]);
        }

        if ($html = $email->getHtmlBody()) {
            $payload['htmlContent'] = $html;
        }

        if ($text = $email->getTextBody()) {
            $payload['textContent'] = $text;
        }

        $attachments = [];
        foreach ($email->getAttachments() as $attachment) {
            $headers = $attachment->getPreparedHeaders();
            $filename = $headers->getHeaderParameter('content-disposition', 'filename')
                ?? $headers->getHeaderParameter('content-type', 'name')
                ?? 'attachment';

            $attachments[] = [
                'name' => $filename,
                'content' => base64_encode($attachment->getBody()),
            ];
        }

        if ($attachments) {
            $payload['attachment'] = $attachments;
        }

        $this->client->post('https://api.brevo.com/v3/smtp/email', [
            'headers' => [
                'api-key' => $this->apiKey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
            'json' => $payload,
        ]);
    }

    public function __toString(): string
    {
        return 'brevo+api://api.brevo.com';
    }

    /**
     * @return array<string, string>
     */
    private function formatAddress(Address $address): array
    {
        $formatted = ['email' => $address->getAddress()];

        if ($name = $address->getName()) {
            $formatted['name'] = $name;
        }

        return $formatted;
    }

    /**
     * @param  Address[]  $addresses
     * @return array<int, array<string, string>>
     */
    private function formatAddresses(array $addresses): array
    {
        return array_map(fn (Address $address) => $this->formatAddress($address), $addresses);
    }
}
