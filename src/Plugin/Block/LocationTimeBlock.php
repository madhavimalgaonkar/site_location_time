<?php

namespace Drupal\site_location_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\site_location_time\Service\SiteTime;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a 'LocationTimeBlock' block.
 *
 * @Block(
 *  id = "locationtimeBlock",
 *  admin_label = @Translation("Site Location and Time block"),
 * )
 */
class LocationTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {
    /**
     * @var \Drupal\Core\Config\Config
     */
    protected $config;

    /**
     * @var SiteTime $time
     */
    protected $time;

    /**
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     * The config factory so we can get the site settings.
     * @param Drupal\site_location_time\Service\Time $time
     * The service so that we can get time based on timezone set in settings.
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, SiteTime $time) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->config = $config_factory->get('site_location_time.settings');
        $this->time = $time;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     * 
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
            return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('config.factory'),
            $container->get('site_location_time.sitetime')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $location = $this->config->get('city') . ', ' . $this->config->get('country');
        $formatteddate = $this->time->getTime($this->config->get('timezone'));
        return [
            '#theme' => 'site_location_time',
            '#title' => $this->t('Site Location and Time'),
            '#body' => $location,
            '#description' => $formatteddate,
            '#attributes' => [
                'class' => [
                    'site-location-time--block',
                ],
            ],
        ];
    }   
}