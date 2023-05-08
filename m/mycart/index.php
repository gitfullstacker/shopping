<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header_detail.php"; ?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

<div class="body-section">
    <!-- 장바구니가 비였을때 -->
    <div class="empty-content" style="display: none;">
        <img src="images/empty-icon.png" alt="empty">
        <p class="title">장바구니가 비어있어요!</p>
        <button class="shopping-button">
            <span>쇼핑하러 가기</span>
        </button>
    </div>
    <div class="header-section">
        <p class="title">장바구니</p>
        <div class="action-section">
            <button class="delete-btn">
                <span>품절상품 삭제</span>
            </button>
        </div>
    </div>

    <!-- 렌트목록 -->
    <div class="product-list">
        <?php
        for ($i = 0; $i < 2; $i++) {
        ?>
            <div class="item">
                <div class="top-section">
                    <p class="title">CHANEL</p>
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                    </svg>
                </div>
                <div class="product-section">
                    <div class="image">
                        <img src="images/mockup/product.png" alt="product">
                    </div>
                    <div class="content-section">
                        <div class="tag rent">
                            <p class="title">렌트</p>
                        </div>
                        <p class="title">코코핸들 스몰</p>
                        <p class="origin-price">일 38,000원</p>
                        <p class="price"><span class="value rent">30%</span> 일 27,000원</p>
                    </div>
                </div>
                <button class="btn rent-btn">
                    <span>렌트하기</span>
                </button>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- 구분 -->
    <hr class="splitter-bar" />

    <!-- 구독목록 -->
    <div class="product-list">
        <?php
        for ($i = 0; $i < 2; $i++) {
        ?>
            <div class="item">
                <div class="top-section">
                    <p class="title">CHANEL</p>
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.86555 5L0 1.06855L1.13445 0L5 3.93145L8.86555 0L10 1.06855L6.13445 5L10 8.93145L8.86555 10L5 6.06855L1.13445 10L0 8.93145L3.86555 5Z" fill="#6A696C" />
                    </svg>
                </div>
                <div class="product-section">
                    <div class="image">
                        <img src="images/mockup/product.png" alt="product">
                    </div>
                    <div class="content-section">
                        <div class="tag subscription">
                            <p class="title">구독</p>
                        </div>
                        <p class="title">카세트 스몰</p>
                        <p class="description">월정액 구독 전용</p>
                        <p class="price"><span class="value subscription">월</span> 27,000원</p>
                    </div>
                </div>
                <button class="btn subscription-btn">
                    <span>렌트하기</span>
                </button>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- 신규회원 가입혜택 -->
    <img class="welcome-image" src="images/welcome.png" alt="">

    <div class="product-list-section">
        <p class="title">관련 상품</p>
        <div class="product-list">
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