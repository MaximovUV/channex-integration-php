<?php
namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class Properties extends Channex {
  public function __construct(Init $init) {
    parent::__construct($init);
  }

  public function get(?string $id = null) {
    if (!$id) {
      return $this->apiConnect->getApiInfo("GET", 'properties');
    } else {
      return $this->apiConnect->getApiInfo("GET", 'properties/'.(string)$id);
    }
  }

  public function create(array $data):mixed {
    return $this->apiConnect->getApiInfo("POST", 'properties', ['property' => $data]);
  }

  public function update(string $id, mixed $data):mixed {
    return $this->apiConnect->getApiInfo("PUT", 'properties/'.(string)$id, ['property' => $data]);
  }

  public function remove(string $id = null):mixed {
    return [];
  }

}