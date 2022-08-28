<?php

declare(strict_types=1);

namespace Atakde\AkismetPhp;

use Atakde\AkismetPhp\Exception\InvalidResponseException;

/**
 * AkismetPhp
 * @author Atakan Demircioğlu
 * @version 1.0
 * @package AkismetPhp
 */

class AkismetPhp
{
    private ?string $userIp = null;
    private ?string $userAgent = null;
    private ?string $referrer = null;
    private ?string $permalink = null;
    private ?string $commentType = null;
    private ?string $commentAuthor = null;
    private ?string $commentAuthorEmail = null;
    private ?string $commentAuthorUrl = null;
    private ?string $commentContent = null;
    private ?string $blogUrl = null;
    private ?string $akismetKey = null;
    private string $akismetVersion = '1.1';
    private string $checkType = 'comment-check';

    public function setUserIp(string $userIp): self
    {
        $this->userIp = $userIp;
        return $this;
    }

    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    public function setReferrer(string $referrer): self
    {
        $this->referrer = $referrer;
        return $this;
    }

    public function setPermalink(string $permalink): self
    {
        $this->permalink = $permalink;
        return $this;
    }

    public function setCommentType(string $commentType): self
    {
        $this->commentType = $commentType;
        return $this;
    }

    public function setCommentAuthor(string $commentAuthor): self
    {
        $this->commentAuthor = $commentAuthor;
        return $this;
    }

    public function setCommentAuthorEmail(string $commentAuthorEmail): self
    {
        $this->commentAuthorEmail = $commentAuthorEmail;
        return $this;
    }

    public function setCommentAuthorUrl(string $commentAuthorUrl): self
    {
        $this->commentAuthorUrl = $commentAuthorUrl;
        return $this;
    }

    public function setCommentContent(string $commentContent): self
    {
        $this->commentContent = $commentContent;
        return $this;
    }

    public function setBlogUrl(string $blogUrl): self
    {
        $this->blogUrl = $blogUrl;
        return $this;
    }

    public function setAkismetKey(string $akismetKey): self
    {
        $this->akismetKey = $akismetKey;
        return $this;
    }

    public function createAkismetEndpoint(): string
    {
        return 'https://' . $this->akismetKey . '.rest.akismet.com/' . $this->akismetVersion . '/' . $this->checkType;
    }

    public function checkSpam(): bool
    {
        $params = [
            'user_ip' => $this->userIp,
            'user_agent' => $this->userAgent,
            'referrer' => $this->referrer,
            'permalink' => $this->permalink,
            'comment_type' => $this->commentType,
            'comment_author' => $this->commentAuthor,
            'comment_author_email' => $this->commentAuthorEmail,
            'comment_author_url' => $this->commentAuthorUrl,
            'comment_content' => $this->commentContent,
            'blog' => $this->blogUrl,
        ];

        // remove null values
        $params = array_filter($params, function ($value) {
            return $value !== null;
        });

        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->createAkismetEndpoint());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);

            if ($info['http_code'] === 200) {
                if ($response === 'true' || $response === 'false') {
                    return $response === 'true';
                } else {
                    throw new InvalidResponseException('Error: ' . $response);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

        return false;
    }
}
