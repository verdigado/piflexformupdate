<?php

$EM_CONF[$_EXTKEY] = [
    'title'            => 'pi_flexform Update',
    'description'      => 'Updates data in pi_flexform',
    'category'         => 'misc',
    'author'           => 'Dirk Wildt (verdigado eG)',
    'author_email'     => 'support@verdigado.com',
    'state'            => 'alpha',
    'clearCacheOnLoad' => 0,
    'version'          => '0.0.3',
    'constraints'      => [
        'depends'   => [
            'typo3' => '10.4.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
];
