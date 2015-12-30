<?php
require "config.php";
require "naverCafeApi.php";
header("Content-Type: text/html; charset=UTF-8");

session_start();

// access_token이 발급된 상태가 아니라면, OAuth 인증 절차 시작
if(!$_SESSION['access_token'] ) {

    try {
        // Request Token 요청
        $request_token_info = $oauth->getRequestToken($request_token_url, $callback_url);

        // 얻어온 Request Token을 이후 Access Token과 교환하기 위해 session에 저장.
        $_SESSION["request_token_secret"] = $request_token_info["oauth_token_secret"];

        // 사용자 인증 URL로 redirect
        header('Location: '.$authorize_url.'&oauth_token='.$request_token_info['oauth_token']);
        exit;
    } catch(OAuthException $E) {
        print_r($E);
        exit;
    }
} else {
// Access_token 이 있다면 API 호출하여 결과 값 반환
    // access_token 을 이용하여 set하여 인증값 생성
    $oauth->setToken($_SESSION['access_token'],$_SESSION['access_token_secret']);

    // cafeAPI 호출을 위한 class 객체 생성
    $cafe_api = new naverCafeApi($oauth, $api_url);

    //타입(mode)에 따라 해당 API 호출
    switch($_GET['mode'])
    {
        //날짜처리
        case "getDate":
            $clubid = $_GET['clubid'];

            $sdate = $_GET['s_date'];
            $edate = $_GET['e_date'];

            $page = $_GET['page'];
            (!$page) ? $page = 1 : $page = $_GET['page'];

            $per_page = $_GET['perpage'];
            (!$per_page) ? $per_page = 500 : $per_page = $_GET['perpage'];

            $result = $cafe_api->getMenuList($getMenuList, $clubid, $page, $per_page);
            break;



        // 카페의 게시판 목록 표시
        case "getMenuList":
            $clubid = $_GET['clubid'];

            $sdate = $_GET['s_date'];
            $edate = $_GET['e_date'];

            $page = $_GET['page'];
            (!$page) ? $page = 1 : $page = $_GET['page'];

            $per_page = $_GET['perpage'];
            (!$per_page) ? $per_page = 500 : $per_page = $_GET['perpage'];

            $result = $cafe_api->getMenuList($getMenuList, $clubid, $page, $per_page);

            break;
        // 카페의 게시물 목록 표시
        case "getArticleList":
            $clubid = $_GET['clubid'];
            $menuid = $_GET['menuid'];
            $menuname = $_GET['menuname'];

            $page = $_GET['page'];
            (!$page) ? $page = 1 : $page = $_GET['page'];

            $per_page = $_GET['perpage'];
            (!$per_page) ? $per_page = 15 : $per_page = $_GET['perpage'];

            $result = $cafe_api->getArticleList($getArticleList, $clubid, $menuid, $page, 50);


            print_r($result);
            break;
        //가입한 카페 목록 표시
        case "getMyCafeList":
        default:
            $page = $_GET['page'];
            (!$page) ? $page = 1 : $page = $_GET['page'];

            $per_page = $_GET['perpage'];
            (!$per_page) ? $per_page = 20 : $per_page = $_GET['perpage'];

            $order = $_GET['order'];
            (!$order) ? $order = "C" : $order = $_GET['order'];

            $result = $cafe_api->getMyCafeList($getMyCafeList, $page, $per_page, $order);
            break;
    }
}
?>
<html>
<head>
</head>
<body>
<?php
switch($_GET['mode'])
{
    case "getDate":
        include "view/cafe_crawling.html";
        break;

    case "getMenuList":
        include "view/getMenuList.html";
        break;
    case "getArticleList":
        include "view/getArticleList.html";
        break;
    case "getMyCafeList":
    default:
        include "view/getMyCafeList.html";
        break;
}
?>
</body>
</html>