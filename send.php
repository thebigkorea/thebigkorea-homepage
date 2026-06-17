<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "<script>alert('잘못된 접근입니다.'); location.href='contact.html';</script>";
    exit;
}

function clean($value) {
    return htmlspecialchars(trim($value ?? ""), ENT_QUOTES, 'UTF-8');
}

$brand         = clean($_POST["brand"] ?? "");
$store         = clean($_POST["store"] ?? "");
$storeAddress  = clean($_POST["storeAddress"] ?? "");
$category      = clean($_POST["category"] ?? "");
$visitType     = clean($_POST["visitType"] ?? "");
$visitDate     = clean($_POST["visitDate"] ?? "");
$visitTime     = clean($_POST["visitTime"] ?? "");
$menu          = clean($_POST["menu"] ?? "");
$extraNote     = clean($_POST["extraNote"] ?? "");
$customerName  = clean($_POST["customerName"] ?? "");
$customerPhone = clean($_POST["customerPhone"] ?? "");
$customerEmail = clean($_POST["customerEmail"] ?? "");
$formSubject   = clean($_POST["subject"] ?? "");
$content       = clean($_POST["content"] ?? "");

if (
    $brand === "" ||
    $store === "" ||
    $category === "" ||
    $customerName === "" ||
    $customerPhone === "" ||
    $customerEmail === "" ||
    $formSubject === "" ||
    $content === ""
) {
    echo "<script>alert('필수 항목을 모두 입력해 주세요.'); history.back();</script>";
    exit;
}

/* 회사에서 받을 이메일 */
$to = "thebig@koreafnb.com";

/* 메일 제목 */
$subject = "[고객의 소리] " . $formSubject;

/* 메일 본문 */
$message  = "고객의 소리 접수 내용\n";
$message .= "====================================\n\n";
$message .= "브랜드: " . $brand . "\n";
$message .= "매장명: " . $store . "\n";
$message .= "매장주소: " . $storeAddress . "\n";
$message .= "문의유형: " . $category . "\n";
$message .= "이용경로: " . $visitType . "\n";
$message .= "방문일: " . $visitDate . "\n";
$message .= "방문시간: " . $visitTime . "\n";
$message .= "주문메뉴: " . $menu . "\n";
$message .= "추가참고사항: " . $extraNote . "\n";
$message .= "성함: " . $customerName . "\n";
$message .= "휴대폰: " . $customerPhone . "\n";
$message .= "이메일: " . $customerEmail . "\n";
$message .= "제목: " . $formSubject . "\n\n";
$message .= "내용:\n" . $content . "\n";

/*
  발신 주소
  같은 회사 메일 하나만 쓰는 상황이면 아래처럼 동일하게 두셔도 됩니다.
*/
$headers  = "From: thebig@koreafnb.com\r\n";
$headers .= "Reply-To: " . $customerEmail . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$result = mail($to, $subject, $message, $headers);

if ($result) {
    echo "<script>alert('고객의 소리가 정상적으로 접수되었습니다.'); location.href='contact.html';</script>";
} else {
    echo "<script>alert('메일 발송에 실패했습니다. 서버의 메일 설정을 확인해 주세요.'); history.back();</script>";
}
?>