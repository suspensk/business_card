<?php
/**
 * Created by PhpStorm.
 * User: Sofia
 * Date: 9/6/2016
 * Time: 9:10 AM
 */
return array(
    'relationships' => array(
        array(
            'type'  => 'oneToMany',
            'owner' => 'project',
            'items' => 'task',

            // При удалении проектов
            // сразу удалять их задания
         /*   'itemsOptions' => array(
                'onOwnerDelete' => 'delete'
            )*/
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'fairy',
            'items' => 'flower'
        ),
        /**/
        array(
            'type'  => 'oneToMany',
            'owner' => 'country',
            'items' => 'campaign',
            'itemsOptions' => array(
                'ownerKey' => 'country',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'city',
            'items' => 'campaign',
            'itemsOptions' => array(
                'ownerKey' => 'city',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'country',
            'items' => 'city',
            'itemsOptions' => array(
                'ownerKey' => 'country',
                'onOwnerDelete' => 'delete'
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'medium',
            'items' => 'campaign',
            'itemsOptions' => array(
                'ownerKey' => 'medium',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'publisher',
            'items' => 'campaign',
            'itemsOptions' => array(
                'ownerKey' => 'publisher',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'compensation',
            'items' => 'campaign',
            'itemsOptions' => array(
                'ownerKey' => 'compensation',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'payment_term',
            'items' => 'campaign',
            'itemsOptions' => array(
                'ownerKey' => 'payment_term',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'rep',
            'items' => 'campaign',
            'itemsOptions' => array(
                'ownerKey' => 'rep',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'page',
            'items' => 'campaign',
            'ownerOptions' => array(
                'itemsProperty' => 'campaign_default'
            ),
            'itemsOptions' => array(
                'ownerKey' => 'default_page',
                'ownerProperty' => 'default_page',
            //    'onOwnerDelete' => 'delete'
            )
        ),
        array(
            // mandatory options
            'type'  => 'manyToMany',
            'left'  => 'campaign',
            'right' => 'page',

            'pivot' => 'campaign_page',
            'pivotOptions' => array(
                'connection' => 'default',
                'leftKey'  => 'campaign',
                'rightKey' => 'page',
            )
        ),
        array(
            // mandatory options
            'type'  => 'manyToMany',
            'left'  => 'ad',
            'right' => 'tag',

            'pivot' => 'ad_tag',
            'pivotOptions' => array(
                'connection' => 'default',
                'leftKey'  => 'ad',
                'rightKey' => 'tag',
            )
        ),
        array(
            // mandatory options
            'type'  => 'manyToMany',
            'left'  => 'ad',
            'right' => 'country',

            'pivot' => 'ad_country',
            'pivotOptions' => array(
                'connection' => 'default',
                'leftKey'  => 'ad',
                'rightKey' => 'country',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'ad_type',
            'items' => 'ad',
            'itemsOptions' => array(
                'ownerKey' => 'ad_type',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'file_type',
            'items' => 'ad',
            'itemsOptions' => array(
                'ownerKey' => 'file_type',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'ad_size',
            'items' => 'ad',
            'itemsOptions' => array(
                'ownerKey' => 'ad_size',
            )
        ),
        array(
            'type'  => 'oneToMany',
            'owner' => 'language',
            'items' => 'ad',
            'itemsOptions' => array(
                'ownerKey' => 'language',
            )
        )

    )
);