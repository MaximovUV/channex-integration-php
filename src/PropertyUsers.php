<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class PropertyUsers extends Channex {
  public function __construct(Init $init) {
      parent::__construct($init);
  }

  public function get(string $id = null) {
        if ($id) {
            return $this->apiConnect->getApiInfo("GET", 'property_users/'.(string)$id);
        } else {
            return $this->apiConnect->getApiInfo("GET", 'property_users/');
        }
        
  }

  public function create(array $data):mixed {
        return $this->apiConnect->getApiInfo("POST", 'property_users', ['invite' => $data]);
  }

  public function update(string $id, mixed $data):mixed {
        return $this->apiConnect->getApiInfo("PUT", 'property_users/'.(string)$id, ['property_user' => $data]);
  }

  public function remove(string $id = null):mixed {
        return $this->apiConnect->getApiInfo("DELETE", 'room_types/'.(string)$id);
  }

}