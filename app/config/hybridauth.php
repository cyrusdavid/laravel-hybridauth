<?php

return array(
    'base_url'  => URL::route('hybridauth', array('process' => true)),
    'providers' => array(
        'Facebook' => array(
            'enabled' => true,
            'keys'    => array(
                'id'     => '',
                'secret' => ''
            ),
            'scope' => ['publish_actions', 'email', 'user_location']
        )
    )
);
