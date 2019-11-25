<?php

namespace Handlers;

use SessionHandler;

class V2 extends SessionHandler {
    private const PREFIX = 'my-';

    public function write($id, $data)
    {
        $id = self::PREFIX . $id;

        $content = [
            'data' => $data,
            'time' => time()
        ];
        $content = json_encode($content, JSON_PRETTY_PRINT);

        return parent::write($id, $content);
    }

    public function read($id)
    {
        $id = self::PREFIX . $id;

        $content = parent::read($id);
        $content = json_decode($content, true);

        if (empty($content['data'])) {
            return '';
        }

        return $content['data'];
    }

    public function destroy($id)
    {
        $id = self::PREFIX . $id;
        
        return parent::destroy($id);
    }
}