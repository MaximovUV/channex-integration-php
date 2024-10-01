<?php
class Init {
  private string $accessToken;
  private bool $isStaging;
  private string $url;
  private array $headers;
  public function __construct(string $accessToken, bool $isStaging = false)  {
    if (!$accessToken) {
      throw new Error('Access token not set');
    }
    $this->accessToken = $accessToken;
    $this->isStaging = $isStaging;
    $this->initUrl();
    $this->initHeader();
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

  private function getApiInfo(string $method, string $urlMethod, array $body = [], bool $getAllPage = false) {
    try{
      $client = new GuzzleHttp\Client();
      $res = $client->request($method, (string)$this->url . '/' . $urlMethod, ['headers' => $this->headers, 'body' => $body]);
      $this->checkErrors($res->getStatusCode());
      $response = json_decode($res->getBody());
      $this->checkResponse($response);
      return $response;
    } catch(Throwable $e) {
      throw new Error($e->getMessage());
    }
  }

  public function getPropertiesList():mixed {
    return $this->getApiInfo("GET", 'properties');
  }

  public function getPropertyById(string $id):mixed {
    return $this->getApiInfo("GET", 'properties.'.(string)$id);
  }

  public function createProperty(mixed $data):mixed {
    return $this->getApiInfo("POST", 'properties', ['property' => $data]);
  }

  public function updateProperty(mixed $data):mixed {
    return $this->getApiInfo("PUT", 'properties', ['property' => $data]);
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
      throw new Error($data->errors->title);
    }
  }

  private function checkErrors(int $status) {
    switch($status) {
      case 200:
        break;
      case 400:
        throw new Error('The request was unacceptable, often due to missing a required parameter.');
      case 401:
        throw new Error('No valid Bearer token provided.');
      case 403:
        throw new Error('Access forbidden.');
      case 404:
        throw new Error('The requested resource doesn`t exist.');
      case 422:
        throw new Error('Validation Error.');
      default:
        throw new Error('Unknown code response');
    }
  }
}
