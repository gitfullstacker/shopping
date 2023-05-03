<? include_once $_SERVER['DOCUMENT_ROOT'] . "/pub/inc/comm.php"; ?>
<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/header.php"; ?>

<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink" />

<!-- Body -->
<div class="main-body">
    <!-- 브랜드검색 -->
    <div class="brand">
        <div class="category-section">
            <div class="item">
                <img class="logo" src="images/new_category.png" alt="category" />
                <p class="title">NEW</p>
            </div>
            <div class="item">
                <img class="logo" src="images/best_category.png" alt="category" />
                <p class="title">BEST</p>
            </div>
            <div class="item">
                <img class="logo" src="images/mockup/category.png" alt="category" />
                <p class="title">CHANEL</p>
            </div>
            <div class="item">
                <img class="logo" src="images/mockup/category.png" alt="category" />
                <p class="title">GUCCI</p>
            </div>
        </div>
        <img class="main-image" src="images/main-image.png" alt="main_image" />
        <div class="product-list">
            <?php
            for ($i = 0; $i < 3; $i++) {
            ?>
                <div class="item">
                    <div class="image">
                        <img src="images/mockup/product1.png" alt="product">
                    </div>
                    <p class="title">가브리엘 스몰 백팩</p>
                    <div class="price-section">
                        <p class="percent">20%</p>
                        <p class="price">일 35,920원</p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- ABLANC RENT -->
    <div class="ablanc-rent">
        <p class="title">ABLANC RENT</p>
        <div class="filter-section">
            <p class="description">이용하고 싶은 날짜를 선택해주세요!</p>
            <button class="select-btn">시작 날짜 선택</button>
            <div class="filter-list">
                <button class="item-btn">브랜드</button>
                <button class="item-btn">사이즈</button>
                <button class="item-btn">스타일</button>
            </div>
        </div>
        <div class="product-section">
            <div class="top-section">
                <div class="discount-view">
                    <div class="switch-box">
                        <div class="button"></div>
                    </div>
                    <p>할인 상품보기</p>
                </div>
                <div class="order-view">
                    <div class="icon">
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.48906 1H6.51694L3.99797 4.15L1.48906 1ZM0.106392 0.805001C1.12202 2.1 2.99742 4.5 2.99742 4.5V7.5C2.99742 7.775 3.22368 8 3.50021 8H4.50579C4.78232 8 5.00857 7.775 5.00857 7.5V4.5C5.00857 4.5 6.87895 2.1 7.89458 0.805001C7.9522 0.731187 7.98783 0.642764 7.99739 0.549803C8.00696 0.456842 7.99009 0.363077 7.94869 0.279186C7.9073 0.195294 7.84305 0.124647 7.76326 0.0752883C7.68347 0.0259299 7.59134 -0.000156018 7.49738 7.02021e-07H0.503594C0.0862804 7.02021e-07 -0.15003 0.475001 0.106392 0.805001Z" fill="#999999" />
                        </svg>
                    </div>
                    <p>인기순</p>
                    <div class="menu hidden">
                        <div class="item">인기순</div>
                        <div class="item">신상품순</div>
                        <div class="item">추천순</div>
                        <div class="item">낮은가격순</div>
                        <div class="item">높은가격순</div>
                    </div>
                </div>
            </div>
            <div class="product-list">
                <?php
                for ($i = 0; $i < 4; $i++) {
                ?>
                    <div class="global-product-item">
                        <div class="image">
                            <img src="images/mockup/product1.png" alt="">
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
            <div class="see-more-section">
                <button class="see-more-btn">
                    <span>더보기</span>
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.14661 1.33063L5.15716 5.21312C5.10967 5.2592 5.05822 5.29176 5.00281 5.31081C4.9474 5.33017 4.88803 5.33984 4.82471 5.33984C4.76138 5.33984 4.70202 5.33017 4.64661 5.31081C4.5912 5.29176 4.53975 5.2592 4.49225 5.21312L0.490934 1.33063C0.380116 1.2231 0.324707 1.08869 0.324707 0.927402C0.324707 0.766111 0.384074 0.627863 0.502807 0.512655C0.621541 0.397448 0.760063 0.339844 0.918374 0.339844C1.07669 0.339844 1.21521 0.397448 1.33394 0.512655L4.82471 3.89975L8.31547 0.512655C8.42629 0.405128 8.56275 0.351365 8.72486 0.351365C8.88729 0.351365 9.02787 0.408968 9.14661 0.524176C9.26534 0.639383 9.32471 0.773791 9.32471 0.927401C9.32471 1.08101 9.26534 1.21542 9.14661 1.33063Z" fill="#333333" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Review -->
    <div class="review">
        <div class="top-section">
            <div class="left-section">
                <p class="title">REVIEW</p>
                <p class="description">실시간 리뷰</p>
            </div>
            <div class="right-section">
                <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.56897 1.12354L14.1346 6.05335L8.56897 10.7839" stroke="black" stroke-width="1.08333" stroke-miterlimit="10" />
                    <path d="M14.1347 6.05322H0.212161" stroke="black" stroke-width="1.08333" stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
        <div class="review-list">
            <?php
            for ($i = 0; $i < 4; $i++) {
            ?>
                <a href="detail/index.php" class="item">
                    <div class="image">
                        <img src="images/mockup/review.png" alt="review">
                        <div class="bottom-section">
                            <p class="brand">CHANEL</p>
                            <p class="title">가브리엘 스몰 백팩</p>
                        </div>
                    </div>
                    <div class="score">★★★★★</div>
                    <div class="content">디자인, 색상 모두 맘에들어요 자주 이용해야겠어요!</div>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<? require_once $_SERVER['DOCUMENT_ROOT'] . "/m/inc/footer.php"; ?>