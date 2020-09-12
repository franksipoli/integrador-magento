<?php

$config['database'] = array(
    'default'       => 'mysql',

    'connections'   => array(
        'mysql'     => array(
            'driver'    => 'mysql',
            'host'      => isset($_SERVER['DB1_HOST']) ? $_SERVER['DB1_HOST'] : 'localhost',
            'database'  => isset($_SERVER['DB1_NAME']) ? $_SERVER['DB1_NAME'] : 'integrador',
            'username'  => isset($_SERVER['DB1_USER']) ? $_SERVER['DB1_USER'] : 'integrador',
            'password'  => isset($_SERVER['DB1_PASS']) ? $_SERVER['DB1_PASS'] : 'uqiFjwM80kxaa5TQ',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ),
    		'sge'     => array(
    				'driver'    => 'sqlsrv',
    				'host'      => '192.168.1.160',
    				'database'  => 'sge',
    				'username'  => 'sge',
    				'password'  => 'senha1',
    				'charset'   => 'utf8',
    				'collation' => 'utf8_unicode_ci',
    				'prefix'    => ''
    		)
	    	/*'sge'     => array(
	    		'driver'    => 'mysql',
	    		'host'      => 'localhost',
	    		'database'  => 'sge',
	    		'username'  => 'sge',
	    		'password'  => 'uqiFjwM80kxaa5TQ',
	    		'charset'   => 'utf8',
	    		'collation' => 'utf8_unicode_ci',
	    		'prefix'    => ''
	    	)*/
    )
);
