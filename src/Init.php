<?php
namespace ChannexIntegration;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

final class Init {
  private string $accessToken;
  private bool $isStaging;
  private string $url;
  private array $headers;

  const TIMEOUT = 5;
  public function __construct(string $accessToken, bool $isStaging = false)  {
    if (!$accessToken) {
      throw new Exception('Access token not set');
    }
    $this->accessToken = $accessToken;
    $this->isStaging = $isStaging;
    $this->initUrl();
    $this->initHeader();
  }

  public function getCurrentUrl() {
    return $this->url;
  }

  private function initUrl() {
    $this->url = 'https://app.channex.io/';
    if ($this->isStaging) {
      $this->url = 'https://staging.channex.io/';
    }
  }

  private function initHeader() {
    $this->headers['user-api-key'] = $this->accessToken;
  }

  public function getApiInfo(string $method, string $urlMethod, ?array $body = null, ?array $filter = [], ?int $page = 0, ?int $limit = 0)  {
    try{
      $client = new Client(
        [
          'headers' => [ 'Content-Type' => 'application/json' ]
        ]
      );

      $pageStr = $this->addGetMethod($filter, $page, $limit);

      $request = new Request($method, (string)$this->getCurrentUrl() .'api/v1/'. $urlMethod. $pageStr, $this->headers, json_encode($body));
      $res = $client->send($request, ['timeout' => self::TIMEOUT]);
      $this->checkErrors($res->getStatusCode());
      $response = json_decode($res->getBody(), true);
      $this->checkResponse($response);
      return $response;
    } catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function addGetMethod(array $filter=[], int $page = 0, int $limit = 0) {
    $pageStr = '';
    if ($page) {
      $pageStr = '?pagination[page]='.(string) $page;
    }
    if ($limit) {
        if ($pageStr) {
          $pageStr .= '&pagination[limit]='.(string) $limit;
        } else {
          $pageStr = '?pagination[limit]='.(string) $limit;
        }
    }
    if ($filter) {
      foreach($filter as $name => $value) {
        if ($pageStr) {
          $pageStr .= '&filter['.(string)$name.']='.(string) $value;
        } else {
          $pageStr = '?filter['.(string)$name.']='.(string) $value;
        }
      }
    }
    return $pageStr;
  }

  private function checkResponse(mixed $data) {
    if (isset($data->errors) && isset($data->errors->title)) {
      throw new Exception($data->errors->title);
    }
  }

  private function checkErrors(int $status) {
    switch($status) {
      case 200:
        break;
      case 201:
        break;
      case 400:
        throw new Exception('The request was unacceptable, often due to missing a required parameter.');
      case 401:
        throw new Exception('No valid Bearer token provided.');
      case 403:
        throw new Exception('Access forbidden.');
      case 404:
        throw new Exception('The requested resource doesn`t exist.');
      case 422:
        throw new Exception('Validation Error.');
      default:
        throw new Exception('Unknown code response');
    }
  }
}
