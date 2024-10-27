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
    $this->url = 'https://staging.channex.io/api/v1/';
    if ($this->isStaging) {
      $this->url = 'https://staging.channex.io/api/v1/';
    }
  }

  private function initHeader() {
    $this->headers['user-api-key'] = $this->accessToken;
  }

  public function getApiInfo(string $method, string $urlMethod, ?array $body = null, bool $getAllPage = false) {
    try{
      $client = new Client(
        [
          'headers' => [ 'Content-Type' => 'application/json' ]
        ]
      );
      $request = new Request($method, (string)$this->getCurrentUrl() . $urlMethod, $this->headers, json_encode($body));
      $res = $client->send($request, ['timeout' => self::TIMEOUT]);
      $this->checkErrors($res->getStatusCode());
      $response = json_decode($res->getBody(), true);
      $this->checkResponse($response);
      return $response;
    } catch(Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function getGroupsList():mixed {
    return $this->getApiInfo("GET", 'groups');
  }

  public function createGroup(mixed $group):mixed {
    return $this->getApiInfo("POST", 'groups', ['group' => $group]);
  }

  public function deleteGroup(int $id):mixed {
    return $this->getApiInfo("DELETE", 'groups/'.(string)$id);
  }

  public function getRoomTypesList():mixed {
    return $this->getApiInfo("GET", 'room_types');
  }

  public function getRoomTypesListID(int $id):mixed {
    return $this->getApiInfo("GET", 'room_types/'.(string)$id);
  }

  public function createRoomType(mixed $data):mixed {
    return $this->getApiInfo("POST", 'room_types', ['room_type' => $data]);
  }

  public function updateRoomType(int $id, mixed $data):mixed {
    return $this->getApiInfo("PUT", 'room_types/'.(string)$id, ['room_type' => $data]);
  }

  public function removeRoomType(int $id):mixed {
    return $this->getApiInfo("DELETE", 'room_types/'.(string)$id);
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
