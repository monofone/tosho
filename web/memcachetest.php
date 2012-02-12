<?php

$m = new Memcache();
$m->connect('localhost');
$m->set('foobar','irgendeinvalue');
echo $m->get('5v1a8tnp3aop93q8ci5s05k1e7');
echo uniqid(true);