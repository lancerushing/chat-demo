<?php

function setUpRedis() {
	$pidfile = tempnam(sys_get_temp_dir(), "redis_pid_");
	exec(sprintf("%s > %s 2>&1 & echo $! >> %s", "redis-server --port 7777 ", "/dev/null", $pidfile));
}

setUpRedis();
