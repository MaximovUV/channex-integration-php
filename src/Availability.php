<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class Availability extends Channex {
  public function __construct(Init $init) {
      parent::__construct($init);
  }

  public function get(?string $id = null, ?array $filter = [], ?int $page = 0, ?int $limit = 0) {
      return;
  }

  public function create(array $data):mixed {
      return $this->apiConnect->getApiInfo("POST", 'availability', ['values' => $data]);
  }

  public function update(string $id, mixed $data):void {
      return;
  }

  public function remove(string $id = null):void {
      return;
  }

}
