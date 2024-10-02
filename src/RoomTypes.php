<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class RoomTypes extends Channex {
  public function __construct(Init $init) {
      parent::__construct($init);
  }

  public function get(?string $id = null) {
      if (!$id) {
          return $this->apiConnect->getApiInfo("GET", 'room_types');
      } else {
          return $this->apiConnect->getApiInfo("GET", 'room_types/'.(string)$id);
      }
  }

  public function create(array $data):mixed {
      return $this->apiConnect->getApiInfo("POST", 'room_types', ['room_type' => $data]);
  }

  public function update(string $id, mixed $data):mixed {
      return $this->apiConnect->getApiInfo("PUT", 'room_types/'.(string)$id, ['room_type' => $data]);
  }

  public function remove(string $id = null):mixed {
      return $this->apiConnect->getApiInfo("DELETE", 'room_types/'.(string)$id);
  }

}