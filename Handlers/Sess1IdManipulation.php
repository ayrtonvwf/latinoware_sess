<?php

namespace Handlers;

use SessionHandler;

class V1 extends SessionHandler {
    private const PREFIX = 'my-';

    public function write($id, $data)
    {
        $id = self::PREFIX . $id;

        return parent::write($id, $data);
    }

    public function read($id)
    {
        $id = self::PREFIX . $id;

        return parent::read($id);
    }

    public function destroy($id)
    {
        $id = self::PREFIX . $id;
        
        return parent::destroy($id);
    }
}