<?php

namespace Handlers;

use SessionHandler;
use SessionHandlerInterface;

class Sess6AppKey implements SessionHandlerInterface {
    /**
     * @var SessionHandlerInterface
     */
    private $sessionHandler;

    /**
     * @var string
     */
    private $appKey;

    public function __construct($appKey, $sessionHandler = null)
    {
        if (!$sessionHandler) {
            $sessionHandler = new SessionHandler();
        }

        $this->appKey = sodium_bin2hex($appKey);
        $this->sessionHandler = $sessionHandler;
    }

    private function hashId($id)
    {
        return hash('sha256', $id . $this->appKey);
    }

    private function generateKey($id)
    {
        $binaryKey = sodium_crypto_generichash($id . $this->appKey);
        $hexaKey = sodium_bin2hex($binaryKey);
        return substr($hexaKey, 0, SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
    }

    public function write($id, $data)
    {
        $hash = $this->hashId($id);

        $key = $this->generateKey($id);
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $data = sodium_crypto_secretbox($data, $nonce, $key);

        $content = [
            'data' => sodium_bin2hex($data),
            'nonce' => sodium_bin2hex($nonce),
            'time' => time()
        ];
        $content = json_encode($content, JSON_PRETTY_PRINT);

        return $this->sessionHandler->write($hash, $content);
    }

    public function read($id)
    {
        $hash = $this->hashId($id);

        $content = $this->sessionHandler->read($hash);
        $content = json_decode($content, true);

        if (empty($content['data'])) {
            return '';
        }

        $key = $this->generateKey($id);
        $nonce = sodium_hex2bin($content['nonce']);
        $data = sodium_hex2bin($content['data']);
        return sodium_crypto_secretbox_open($data, $nonce, $key);
    }

    public function destroy($id)
    {
        $hash = $this->hashId($id);
        
        return $this->sessionHandler->destroy($hash);
    }

    public function open($savePath, $id)
    {
        $hash = $this->hashId($id);

        return $this->sessionHandler->open($savePath, $id);
    }

    public function close()
    {
        return $this->sessionHandler->close();
    }

    public function gc($maxLifetime)
    {
        return $this->sessionHandler->gc($maxLifetime);
    }
}