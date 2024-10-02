<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class Booking extends Channex {
  public function __construct(Init $init) {
      parent::__construct($init);
  }

  public function get(?string $id = null) {
      if (!$id) {
          return $this->apiConnect->getApiInfo("GET", 'bookings');
      } else {
          return $this->apiConnect->getApiInfo("GET", 'bookings/'.(string)$id);
      }
  }

  public function create(array $data):mixed {
      return null;
  }

  public function update(string $id, mixed $data):mixed {
      return null;
  }

  public function remove(string $id = null):mixed {
      return null;
  }

}