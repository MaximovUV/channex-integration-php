<?php
namespace ChannexIntegration;

use ChannexIntegration\Init;

abstract class Channex {

  public ?Init $apiConnect;

  public function __construct(Init $init) {
    $this->apiConnect = $init;
  }
  abstract public function get(?string $id = null, ?array $filter = [], ?int $page = 0, ?int $limit = 0);
  abstract public function create(array $data);
  abstract public function update(string $id, array $data);
  abstract public function remove(string $id = null);
}