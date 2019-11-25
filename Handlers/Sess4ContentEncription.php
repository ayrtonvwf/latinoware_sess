<?php

namespace Handlers;

use SessionHandler;

class V4 extends SessionHandler {
    private function hashId($id)
    {
        return hash('sha256', $id);
    }

    private function generateKey($id)
    {
        $binaryKey = sodium_crypto_generichash($id);
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

        return parent::write($hash, $content);
    }

    public function read($id)
    {
        $hash = $this->hashId($id);

        $content = parent::read($hash);
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
        
        return parent::destroy($hash);
    }
}