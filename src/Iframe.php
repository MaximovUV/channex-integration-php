<?php

namespace ChannexIntegration;
use ChannexIntegration\Channex;
use ChannexIntegration\Init;
final class Iframe extends Channex {
    private $url;
    public function __construct(Init $init) {
        $this->url = $init->getCurrentUrl();
        parent::__construct($init);
    }

  public function get(?string $id = null, ?array $filter = [], ?int $page = 0, ?int $limit = 0) {
    return;
  }

  public function getIframe($data, $code) {
    $tokenData = null;
    $iframeCode = '';
    $tokenData = $this->getOneTimeAccessToken($data);
    if ($tokenData && isset($tokenData['data']['token'])) {
        $token = $tokenData['data']['token'];
        $iframeCode = $this->url.'auth/exchange?oauth_session_key='.$token.'&app_mode=headless&redirect_to=/channels&property_id='.$data['property_id'].'&channels='.$code;
    }
    return $iframeCode;
  }

  private function getOneTimeAccessToken($data) {
    return $this->apiConnect->getApiInfo("POST", 'auth/one_time_token', ['one_time_token' => $data]);
  }


  public function create(array $data):void {
      return;
  }

  public function update(string $id, mixed $data):void {
      return;
  }

  public function remove(string $id = null):void {
      return;
  }

}
