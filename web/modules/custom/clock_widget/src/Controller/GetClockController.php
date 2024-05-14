<?php

namespace Drupal\clock_widget\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\clock_widget\ClockClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Controller for retrieving current time.
 */
class GetClockController extends ControllerBase {

  /**
   * Guzzle HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Logger channel.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Caching service.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected $cache;

  /**
   * Construct a Clock API client.
   *
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   Guzzle HTTP client.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   Logger factory service.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cacheBackend
   *   Caching service.
   */
  public function __construct(ClientInterface $httpClient, LoggerChannelFactoryInterface $logger_factory, CacheBackendInterface $cacheBackend) {
    $this->httpClient = $httpClient;
    $this->logger = $logger_factory->get('clock_widget');
    $this->cache = $cacheBackend;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client'),
      $container->get('logger.factory'),
      $container->get('cache.default')
    );
  }

  /**
   * Controller callback for retrieving current time.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param string $cont
   *   The country code.
   * @param string $city
   *   The city name.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response.
   */
  public function getTime(Request $request, string $cont, string $city) {
    $timezone = $cont . "/" . $city;
    $url = 'https://timeapi.io/api/Time/current/zone?timeZone=' . $timezone;
    // Create a unique cache ID using the TIMEZONE.
    $cache_id = 'clock_widget:clock:' . $url;

    // Look for an existing cache record.
    $data = $this->cache->get($cache_id);

    // If we find one, we can use the cached data, unless specifically asked not
    // to.
    if ($data) {
      $time = $data->data;
      // $this->cache->delete($cache_id);
      $this->logger->warning('returned from cached');
    }
    // If not, we need to request fresh data from the API.
    else {
      try {
        $response = $this->httpClient->get($url);
        $json = json_decode($response->getBody()->getContents());
        $this->logger->warning('returned from api');
      }
      catch (GuzzleException $e) {
        $this->logger->warning($e->getMessage());
        return new JsonResponse(['error' => 'Unable to fetch time data.'], 500);
      }

      $time = $json->time;
      // Store the calculated data in the cache for next time, or until it's
      // more than 1 hour old.
      $this->cache->set($cache_id, $time, strtotime('+1 minute'));
    }

    // Check if time is fetched successfully.
    if ($time !== null) {
      return new JsonResponse(['time' => $time]);
    }

    // Return an error response if time data is not available.
    return new JsonResponse(['error' => 'Unable to fetch time data.'], 500);
  }

}
