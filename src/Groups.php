<?php
namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class Groups extends Channex {
  public function __construct(Init $init) {
    parent::__construct($init);
  }

  public function get(?string $id = null) {
    if (!$id) {
      return $this->apiConnect->getApiInfo("GET", 'groups');
    } else {
      return $this->apiConnect->getApiInfo("GET", 'groups/'.(string)$id);
    }
  }

  public function create(array $data):mixed {
    return $this->apiConnect->getApiInfo("POST", 'groups', ['group' => $data]);
  }

  public function update(string $id, mixed $data):mixed {
    return $this->apiConnect->getApiInfo("PUT", 'groups/'.(string)$id, ['group' => $data]);
  }

  public function remove(string $id = null):mixed {
    return $this->apiConnect->getApiInfo("DELETE", 'groups/'.(string)$id);
  }

  public function accosiate(string $groupId, string $property_id):mixed {
    return $this->apiConnect->getApiInfo("POST", 'groups/'.(string)$groupId.'/properties/'.(string)$property_id);
  }

}