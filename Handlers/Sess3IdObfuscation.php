<?php

namespace Handlers;

use SessionHandler;

class V3 extends SessionHandler {
    private function hashId($id)
    {
        return hash('sha256', $id);
    }

    public function write($id, $data)
    {
        $hash = $this->hashId($id);

        $content = [
            'data' => $data,
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

        return $content['data'];
    }

    public function destroy($id)
    {
        $hash = $this->hashId($id);
        
        return parent::destroy($hash);
    }
}