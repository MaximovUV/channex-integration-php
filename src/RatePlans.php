<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class RatePlans extends Channex {
  public function __construct(Init $init) {
      parent::__construct($init);
  }

  public function get(?string $id = null) {
      if (!$id) {
          return $this->apiConnect->getApiInfo("GET", 'rate_plans');
      } else {
          return $this->apiConnect->getApiInfo("GET", 'rate_plans/'.(string)$id);
      }
  }

  public function create(array $data):mixed {
      return $this->apiConnect->getApiInfo("POST", 'rate_plans', ['rate_plan' => $data]);
  }

  public function update(string $id, mixed $data):mixed {
      return $this->apiConnect->getApiInfo("PUT", 'rate_plans/'.(string)$id, ['rate_plan' => $data]);
  }

  public function remove(string $id = null):mixed {
      return $this->apiConnect->getApiInfo("DELETE", 'rate_plans/'.(string)$id);
  }

}