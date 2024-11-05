<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class Booking extends Channex {
  public function __construct(Init $init) {
      parent::__construct($init);
  }

  public function get(?string $id = null, ?array $filter = [], ?int $page = 0, ?int $limit = 0) {
    if (!$id) {
        return $this->apiConnect->getApiInfo("GET", 'booking_revisions/feed', null, $filter, $page, $limit);
    } else {
        return $this->apiConnect->getApiInfo("GET", 'booking_revisions/'.(string)$id, null, $filter, $page, $limit);
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

  public function ack(string $id = null):mixed {
    return  $this->apiConnect->getApiInfo("POST", 'booking_revisions/'.(string)$id.'/ack');
  }

}