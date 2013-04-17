<?php

return array(
    'translator' => array(
        'translation_file_patterns' => array(
            'googleAnalytics' => array(
                'type'          => 'phpArray',
                'base_dir'      => __DIR__ . '/../languages/googleAnalytics',
                'pattern'       => '%s.php',
                'text_domain'   => 'googleAnalytics',
            ),
        ),
    ),
    'modules' => array(
        'Grid\Core' => array(
            'settings' => array(
                'google' => array(
                    'textDomain'    => 'google',
                    'fieldsets'     => array(
                        'analytics' => 'google-analytics',
                    ),
                ),
                'google-analytics'  => array(
                    'textDomain'    => 'google',
                    'elements'      => array(
                        'id'        => array(
                            'key'   => 'modules.GoogleAnalytics.access.analyticsId',
                            'type'  => 'ini',
                        ),
                    ),
                ),
            ),
            'navigation' => array(
                'settings' => array(
                    'pages' => array(
                        'service'   => array(
                            'label'         => 'admin.navTop.service',
                            'textDomain'    => 'admin',
                            'order'         => 7,
                            'uri'           => '#',
                            'parentOnly'    => true,
                            'pages'         => array(
                                'google'    => array(
                                    'label'         => 'admin.navTop.settings.google',
                                    'textDomain'    => 'admin',
                                    'order'         => 1,
                                    'route'         => 'Grid\Core\Settings\Index',
                                    'resource'      => 'settings.google',
                                    'privilege'     => 'edit',
                                    'params'        => array(
                                        'section'   => 'google',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'Grid\GoogleAnalytics' => array(
            'access' => array(
                'analyticsId' => ''
            )
        )
    ),
    'form' => array(
        'Grid\Core\Settings\Google' => array(
            'type'          => 'Grid\Core\Form\Settings',
            'attributes'    => array(
                'data-js-type' => 'js.form.fieldsetTabs',
            ),
            'fieldsets'     => array(
                'analytics' => array(
                    'spec'  => array(
                        'name'      => 'analytics',
                        'options'   => array(
                            'label'         => 'googleAnalytics.form.settings.legend',
                            'description'   => 'googleAnalytics.form.settings.description',
                        ),
                        'elements'  => array(
                            'id' => array(
                                'spec'  => array(
                                    'type'  => 'Zork\Form\Element\Text',
                                    'name'  => 'id',
                                    'options'   => array(
                                        'label' => 'googleAnalytics.form.settings.id',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'mvc_strategies' => array(
            'Grid\GoogleAnalytics\Mvc\Strategy\GoogleAnalyticsStrategy', // register JSON renderer strategy
        ),
        'template_map'   => array(
            'grid/google-analytics/tracker'  => __DIR__ . '/../view/grid/google-analytics/tracker.js',
        ),
    ),
);