<?php

return array(
    'type'      => 'group',
    'resolvers' => array(
        /*'view' => array(
            'type'     => 'pattern',

            //Поскольку параметр id обязателен
            //то скобок не ставим
            'path'     => 'quickstart/view/<id>',
            'defaults' => array(
                'processor' => 'quickstart',
                'action'    => 'view'
            )
        ),*/
       /* 'view' => array(
            //Создаем префикс
            'type'      => 'prefix',
            'path'   => 'view/<id>/',
            'resolver' => array(
                'type'      => 'group',
                'resolvers' => array(
                    //направит /user/5/friends to Friends::userFriends()
                    'quickstart' => array(
                        'path'  => 'quickstart',
                        'defaults' => array(
                            'processor' => 'quickstart',
                            'action'    => 'view'
                        )
                    ),
                    //направит /user/5/profile to Profile::userProfile()
                    'profile' => array(
                        'path'  => 'profile',
                        'defaults' => array(
                            'processor' => 'profile',
                            'action'    => 'userProfile'
                        )
                    )
                )
            )
        ),*/
        'campaigns' => array(
            'type'     => 'pattern',

            //Since the id parameter is mandatory
            //we don't wrap it in brackets
            'path'     => 'campaigns/view/<id>',
            'defaults' => array(
                'processor' => 'campaigns',
                'action'    => 'view'
            )
        ),
        // a prefixed group for /admin/ routes
        'admin' => array(
            'type' => 'prefix',
            'path' => 'admin',
            'defaults' => array(
                'processor' => 'admin',
            ),
            'resolver' => array(
                'type' => 'group',
                'resolvers' => array(

                    'action' => array(
                        'type'     => 'pattern',
                        'path'     => '/<adminProcessor>/<action>'
                    ),

                    'processor' => array(
                        'type'     => 'pattern',
                        'path'     => '(/<adminProcessor>)',
                        'defaults' => array(
                            'adminProcessor' => 'dashboard',
                            'action'    => 'default'
                        )
                    ),
                )
            )
        ),

        'action' => array(
            'type'     => 'pattern',
            'path'     => '<processor>/<action>'
        ),

        'processor' => array(
            'type'     => 'pattern',
            'path'     => '(<processor>)',
            'defaults' => array(
                'processor' => 'dashboard',
                'action'    => 'default'
            )
        ),
        
    )
);
