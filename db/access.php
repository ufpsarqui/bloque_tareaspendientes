<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'block/bloque_tareaspendientes:myaddinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        ),
    ),
);
