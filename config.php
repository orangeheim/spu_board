<?php
// Request Token 요청 주소
$request_token_url = 'https://nid.naver.com/naver.oauth?mode=req_req_token';  // 신버전

// 사용자 인증 URL
$authorize_url = 'https://nid.naver.com/naver.oauth?mode=auth_req_token'; //신버전

// Access Token URL
$access_token_url = 'https://nid.naver.com/naver.oauth?mode=req_acc_token'; //신버전

// Consumer 정보 (Consumer를 등록하면 얻어올 수 있음.)
$consumer_key = "wPBepAz55Qkf9PaMC5sp";
$consumer_secret = "LjNnOJbqpj";
$callback_url = "http://192.168.0.249/callback.php";

// API prefix (보호된 자원이 있는 URL의 prefix)
$api_url = 'http://openapi.naver.com';
$getMyCafeList = "/cafe/getMyCafeList.xml";
$getArticleList = "/cafe/getArticleList.xml";
$getMenuList = "/cafe/getMenuList.xml";

// Service Provider와 통신할 인터페이스를 갖고 있는 객체 생성.
$oauth = new OAuth($consumer_key, $consumer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
?>