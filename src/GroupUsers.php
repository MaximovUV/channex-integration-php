<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class GroupUsers extends Channex {
  public function __construct(Init $init) {
      parent::__construct($init);
  }

  public function get(?string $id = null, ?array $filter = [], ?int $page = 0, ?int $limit = 0) {
        if ($id) {
            return $this->apiConnect->getApiInfo("GET", 'group_users/'.(string)$id);
        } else {
            return $this->apiConnect->getApiInfo("GET", 'group_users/');
        }
  }

  public function create(array $data):mixed {
        return $this->apiConnect->getApiInfo("POST", 'group_users', ['invite' => $data]);
  }

  public function update(string $id, mixed $data):mixed {
        return $this->apiConnect->getApiInfo("PUT", 'group_users/'.(string)$id, ['group_user' => $data]);
  }

  public function remove(string $id = null):mixed {
        return $this->apiConnect->getApiInfo("DELETE", 'group_users/'.(string)$id);
  }

}
