<?php

require 'autoload.php';

$kernel = new \Framewa\Kernel(\Framewa\Kernel::ENV_DEV);
$kernel->handleRequest();;
