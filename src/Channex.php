<?php
namespace ChannexIntegration;

use ChannexIntegration\Init;

abstract class Channex {

  public ?Init $apiConnect;

  public function __construct(Init $init) {
    $this->apiConnect = $init;
  }
  abstract public function get(?string $id = null);
  abstract public function create(array $data);
  abstract public function update(string $id, array $data);
  abstract public function remove(string $id = null);
}