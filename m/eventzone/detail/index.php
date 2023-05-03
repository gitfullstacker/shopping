<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php"; ?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

<!-- Header -->
<div class="header">
    <a href="javascript:history.back()" class="return-btn">
        <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.41475 14.2576L0.202765 7.81002C0.129032 7.73327 0.0769276 7.65012 0.0464514 7.56057C0.0154837 7.47102 0 7.37507 0 7.27273C0 7.17038 0.0154837 7.07444 0.0464514 6.98489C0.0769276 6.89534 0.129032 6.81218 0.202765 6.73543L6.41475 0.268649C6.58679 0.0895498 6.80184 0 7.05991 0C7.31797 0 7.53917 0.0959463 7.7235 0.287839C7.90783 0.479731 8 0.703606 8 0.959463C8 1.21532 7.90783 1.43919 7.7235 1.63109L2.30415 7.27273L7.7235 12.9144C7.89555 13.0935 7.98157 13.314 7.98157 13.576C7.98157 13.8385 7.8894 14.0657 7.70507 14.2576C7.52074 14.4495 7.30568 14.5455 7.05991 14.5455C6.81413 14.5455 6.59908 14.4495 6.41475 14.2576Z" fill="#333333" />
        </svg>
    </a>
    <p class="title">NEWS LETTER</p>
</div>

<div class="body">
    <div class="header-section">
        <p class="title">2023 TREND CURATION</p>
        <p class="description">2023 패션 트렌드 미리보기</p>
    </div>

    <!-- 알람 -->
    <div class="content">
        <img src="../images/mockup/event2.png" alt="event">
        <div class="notification-section">
            <div class="header-section">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 0.000128502C9.48913 0.000128502 11.3967 0.790269 12.8033 2.19678C14.2099 3.6033 15 5.51105 15 7.50006C15 9.48908 14.2099 11.3968 12.8033 12.8033C11.3968 14.2099 9.48903 15 7.5 15C5.51097 15 3.60327 14.2099 2.19668 12.8033C0.790148 11.3968 2.52514e-07 9.48908 2.52514e-07 7.50006C0.00213476 5.5116 0.79304 3.60529 2.19905 2.19903C3.60519 0.793033 5.51142 0.00212144 7.50013 0L7.5 0.000128502ZM7.5 12.0001C7.69889 12.0001 7.88974 11.9211 8.03037 11.7804C8.17099 11.6397 8.24997 11.449 8.24997 11.2501C8.24997 11.0511 8.17099 10.8604 8.03037 10.7198C7.88974 10.5791 7.6989 10.5 7.5 10.5C7.3011 10.5 7.11026 10.5791 6.96964 10.7198C6.82901 10.8604 6.75003 11.0511 6.75003 11.2501C6.75003 11.449 6.82901 11.6397 6.96964 11.7804C7.11026 11.9211 7.3011 12.0001 7.5 12.0001ZM6.75003 9.00012C6.75003 9.26806 6.89292 9.51566 7.12495 9.64963C7.35699 9.7836 7.64301 9.7836 7.87505 9.64963C8.10709 9.51566 8.24997 9.26806 8.24997 9.00012V3.74987C8.24997 3.48193 8.10708 3.23433 7.87505 3.10036C7.64302 2.96638 7.357 2.96638 7.12495 3.10036C6.89291 3.23433 6.75003 3.48193 6.75003 3.74987V9.00012Z" fill="#333333" />
                </svg>
                <p class="title">꼭 확인해주세요</p>
            </div>
            <div class="notification-list">
                <?php
                for ($i = 0; $i < 5; $i++) {
                ?>
                    <p class="item">­­・본 이벤트는 2023.01부터 2023.02까지 진행됩니다.</p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- 관련 상품 -->
    <div class="relation-section">
        <p class="title">관련 상품</p>
        <div class="relation-product-list">
            <?php
            for ($i = 0; $i < 4; $i++) {
            ?>
                <div class="global-product-item">
                    <div class="image">
                        <img src="../images/mockup/product1.png" alt="">
                        <div class="tag discount">
                            <p class="value">20%</p>
                        </div>
                    </div>
                    <p class="brand">CHANEL</p>
                    <p class="title">가브리엘 스몰 백팩</p>
                    <div class="price-section">
                        <p class="current-price">일 35,920원</p>
                        <p class="origin-price">35,920원</p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>