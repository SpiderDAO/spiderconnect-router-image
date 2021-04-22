<?php

class cli
{
    public function execute($command)
    {
        return shell_exec($command);
    }
}
