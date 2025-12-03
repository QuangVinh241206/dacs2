(function () {
    // Dữ liệu variants từ backend
    var variants = window.productVariants || [];

    var discount = window.productDiscount || 0;

    var priceEl = document.getElementById("price-display");
    var origEl = document.getElementById("original-price");
    var addBtn = document.getElementById("addToCart");
    var colorContainer = document.getElementById("color-buttons-container");
    var sizeButtons = document.querySelectorAll(".size-button");

    var selectedSize = null;
    var selectedColor = null;

    function formatVnd(n) {
        return new Intl.NumberFormat("vi-VN").format(Math.round(n)) + "₫";
    } // 1. Tìm biến thể khớp với SIZE và COLOR (An toàn với null/rỗng)

    function findVariant(size, color) {
        if (!variants) return null;
        var targetSize = size === null ? "" : String(size);
        var targetColor = color === null ? "" : String(color);
        for (var i = 0; i < variants.length; i++) {
            var vSize =
                variants[i].size === null ? "" : String(variants[i].size);
            var vColor =
                variants[i].color === null ? "" : String(variants[i].color);

            if (vSize === targetSize && vColor === targetColor) {
                return variants[i];
            }
        }
        return null;
    } // 2. Cập nhật Giá và Variant ID

    function updatePriceAndVariant(v) {
        if (!v || (v.stock && v.stock <= 0)) {
            priceEl.textContent = "Hết hàng";
            origEl.textContent = "";
            origEl.classList.add("hidden");
            addBtn.setAttribute("data-variant-id", "");
            addBtn.disabled = true;
            addBtn.innerHTML =
                '<i class="ri-shopping-cart-2-line mr-2"></i> Hết hàng';
            return;
        }

        var price = v.price;
        if (discount && discount > 0) {
            var discounted = Math.round(price * (1 - discount / 100));
            priceEl.textContent = formatVnd(discounted);
            origEl.textContent = formatVnd(price);
            origEl.classList.remove("hidden");
        } else {
            priceEl.textContent = formatVnd(price);
            origEl.textContent = "";
            origEl.classList.add("hidden");
        }

        if (addBtn) addBtn.setAttribute("data-variant-id", v.id);
        addBtn.disabled = false;
        addBtn.innerHTML =
            '<i class="ri-shopping-cart-2-line mr-2"></i> Thêm vào giỏ hàng';
    } // 3. Xử lý khi chọn Kích thước

    function handleSizeSelect(sizeButton) {
        // Cập nhật trạng thái nút Kích thước
        sizeButtons.forEach(function (b) {
            b.classList.remove("bg-primary", "text-white");
            b.classList.add("bg-white", "text-gray-700");
        });
        sizeButton.classList.remove("bg-white", "text-gray-700");
        sizeButton.classList.add("bg-primary", "text-white");

        selectedSize = sizeButton.getAttribute("data-size");
        selectedColor = null; // Reset Màu khi Kích thước thay đổi
        renderColorButtons(selectedSize);
    } // 4. Hiển thị các nút Màu sắc có sẵn cho Kích thước đã chọn (DÙNG TEXT BUTTON)

    function renderColorButtons(size) {
        colorContainer.innerHTML = ""; // Xóa các nút cũ

        var compareSize = size === null ? "" : String(size);
        var availableColors = [];

        variants.forEach(function (v) {
            var vSize = v.size === null ? "" : String(v.size);
            if (
                vSize === compareSize &&
                v.color &&
                availableColors.indexOf(v.color) === -1
            ) {
                availableColors.push(v.color);
            }
        });

        if (availableColors.length === 0) {
            colorContainer.innerHTML =
                '<span class="text-gray-600">Không có tùy chọn màu sắc.</span>'; // Cập nhật giá dựa trên Size và Color rỗng
            var v = findVariant(size, null);
            updatePriceAndVariant(v);
            return;
        } // Tạo nút màu dưới dạng text button

        availableColors.forEach(function (color) {
            var btn = document.createElement("button");
            btn.setAttribute("type", "button");
            btn.setAttribute("data-color", color);
            btn.title = color; // Sử dụng class của nút kích thước

            btn.className =
                "color-button px-4 py-2 rounded border border-gray-300 text-gray-700 font-medium bg-white hover:bg-primary hover:text-white transition";
            btn.textContent = color; // Chèn tên màu vào // Xử lý khi chọn Màu sắc

            btn.addEventListener("click", function () {
                // Bỏ chọn tất cả nút màu khác
                document
                    .querySelectorAll(".color-button")
                    .forEach(function (c) {
                        c.classList.remove("bg-primary", "text-white");
                        c.classList.add("bg-white", "text-gray-700");
                    }); // Chọn nút hiện tại
                btn.classList.remove("bg-white", "text-gray-700");
                btn.classList.add("bg-primary", "text-white");

                selectedColor = btn.getAttribute("data-color"); // Tìm và cập nhật biến thể cuối cùng

                var finalVariant = findVariant(selectedSize, selectedColor);
                updatePriceAndVariant(finalVariant);
            });
            colorContainer.appendChild(btn);
        }); // Tự động chọn màu đầu tiên và cập nhật giá

        var firstColorButton = document.querySelector(".color-button");
        if (firstColorButton) {
            firstColorButton.click(); // Giả lập click để chọn và cập nhật giá/id
        }
    } // 5. Khởi tạo Kích thước và Màu sắc

    if (sizeButtons.length) {
        sizeButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                handleSizeSelect(this);
            });
        }); // Tự động chọn Kích thước đầu tiên khi tải trang

        sizeButtons[0].click();
    } else if (variants.length) {
        // Nếu không có nút kích thước, chỉ hiển thị màu sắc nếu có
        selectedSize = null;
        renderColorButtons(selectedSize);
    } // ... Các logic khác (Thumbnail, Tabs) giữ nguyên ...

    var thumbnails = document.querySelectorAll(".thumbnail");
    var mainImage = document.getElementById("main-image");
    if (thumbnails && thumbnails.length) {
        thumbnails.forEach(function (t) {
            t.addEventListener("click", function () {
                var src = t.getAttribute("data-src") || t.getAttribute("src");
                if (src && mainImage) mainImage.setAttribute("src", src);
                thumbnails.forEach(function (x) {
                    x.classList.remove("border-primary");
                    x.classList.add("border-transparent");
                });
                t.classList.remove("border-transparent");
                t.classList.add("border-primary");
            });
        });
    }

    var tabButtons = document.querySelectorAll(".tab-button");
    var tabContents = document.querySelectorAll(".tab-content");
    if (tabButtons.length) {
        tabButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                var target = btn.getAttribute("data-tab");

                tabButtons.forEach(function (b) {
                    b.classList.remove("active", "border-primary");
                    b.classList.add("text-gray-500", "border-transparent");
                    b.setAttribute("aria-selected", "false");
                });
                btn.classList.add("active", "border-primary");
                btn.classList.remove("text-gray-500", "border-transparent");
                btn.setAttribute("aria-selected", "true");

                tabContents.forEach(function (c) {
                    c.classList.add("hidden");
                    c.setAttribute("aria-hidden", "true");
                });
                var targetEl = document.getElementById(target);
                if (targetEl) {
                    targetEl.classList.remove("hidden");
                    targetEl.setAttribute("aria-hidden", "false");
                }
            });
        }); // Hiển thị tab mặc định
        var activeBtn =
            document.querySelector(".tab-button.active") || tabButtons[0];
        if (activeBtn) {
            var initial = activeBtn.getAttribute("data-tab");
            tabContents.forEach(function (c) {
                c.classList.add("hidden");
                c.setAttribute("aria-hidden", "true");
            });
            var el = document.getElementById(initial);
            if (el) {
                el.classList.remove("hidden");
                el.setAttribute("aria-hidden", "false");
            }
            tabButtons.forEach(function (b) {
                b.classList.remove("active", "border-primary");
                b.classList.add("text-gray-500", "border-transparent");
                b.setAttribute("aria-selected", "false");
            });
            activeBtn.classList.add("active", "border-primary");
            activeBtn.classList.remove("text-gray-500", "border-transparent");
            activeBtn.setAttribute("aria-selected", "true");
        }
    }
    // Rating stars: handle click to set hidden input
    (function () {
        var ratingStars = document.querySelectorAll(".rating-star");
        var ratingInput = document.getElementById("rating-input");
        if (!ratingStars || ratingStars.length === 0 || !ratingInput) {
            // no rating UI on this page
        } else {
            function setRating(val) {
                ratingInput.value = val;
                ratingStars.forEach(function (s, idx) {
                    if (idx < val) {
                        s.classList.remove("ri-star-line");
                        s.classList.add("ri-star-fill", "text-yellow-400");
                    } else {
                        s.classList.remove("ri-star-fill", "text-yellow-400");
                        s.classList.add("ri-star-line");
                    }
                });
            }
            ratingStars.forEach(function (btn) {
                btn.addEventListener("click", function () {
                    var v = parseInt(this.getAttribute("data-value")) || 0;
                    setRating(v);
                });
            });
            // default
            setRating(parseInt(ratingInput.value) || 5);
        }
    })();
    // Review form submit via AJAX
    (function () {
        var reviewForm = document.getElementById("review-form");
        if (!reviewForm) return;

        reviewForm.addEventListener("submit", function (e) {
            e.preventDefault();
            var csrf =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || "";
            var formData = new FormData(reviewForm);
            var action = reviewForm.getAttribute("action");

            fetch(action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    Accept: "application/json",
                },
                body: formData,
            })
                .then(function (res) {
                    if (res.status === 401) {
                        // redirect to login
                        var loginUrl =
                            document
                                .getElementById("favorite-button")
                                ?.getAttribute("data-login-url") ||
                            "/auth/login";
                        window.location.href = loginUrl;
                        return;
                    }
                    return res.json();
                })
                .then(function (data) {
                    if (!data) return;
                    if (data.html) {
                        var list = document.getElementById("reviews-list");
                        if (list) list.innerHTML = data.html;
                    }
                    // update average stars
                    if (typeof data.avg !== "undefined") {
                        var avg = parseFloat(data.avg) || 0;
                        var rounded = Math.round(avg * 2) / 2;
                        var full = Math.floor(rounded);
                        var half = rounded - full === 0.5 ? 1 : 0;
                        var empty = 5 - full - half;
                        var starsHtml = "";
                        for (var i = 0; i < full; i++)
                            starsHtml += '<i class="ri-star-fill"></i>';
                        if (half)
                            starsHtml += '<i class="ri-star-half-fill"></i>';
                        for (var i = 0; i < empty; i++)
                            starsHtml += '<i class="ri-star-line"></i>';
                        var avgEl = document.getElementById("average-stars");
                        if (avgEl) avgEl.innerHTML = starsHtml;
                    }
                    if (typeof data.count !== "undefined") {
                        var countEl = document.getElementById("review-count");
                        if (countEl)
                            countEl.textContent =
                                "(" + data.count + " đánh giá)";
                    }
                    // clear form comment and reset rating
                    var ta = reviewForm.querySelector(
                        'textarea[name="comment"]'
                    );
                    if (ta) ta.value = "";
                    var ratingInput = document.getElementById("rating-input");
                    if (ratingInput) ratingInput.value = 5;
                    // reset star UI
                    document
                        .querySelectorAll(".rating-star")
                        .forEach(function (s) {
                            s.classList.remove(
                                "ri-star-fill",
                                "text-yellow-400"
                            );
                            s.classList.add("ri-star-line");
                        });
                    document
                        .querySelectorAll(".rating-star")[4]
                        ?.classList.remove("ri-star-line");
                    document
                        .querySelectorAll(".rating-star")[4]
                        ?.classList.add("ri-star-fill", "text-yellow-400");
                })
                .catch(function (err) {
                    console.error("Submit review error", err);
                });
        });
    })();
    // Số lượng
    const increaseBtn = document.getElementById("increase-quantity");
    const decreaseBtn = document.getElementById("decrease-quantity");
    const quantityInput = document.getElementById("quantity-input");
    let timer; // dùng để chạy liên tục
    quantityInput.addEventListener("input", function () {
        let val = parseInt(quantityInput.value);
        let variantID = parseInt(addBtn.getAttribute("data-variant-id"));
        let stock = variants.find((v) => v.id == variantID)?.stock || 0;
        if (isNaN(val) || val < 1) {
            quantityInput.value = 1;
        }
        if (val > stock) {
            quantityInput.value = stock;
        }
    });
    // Hàm tăng
    function increase() {
        let variantID = parseInt(addBtn.getAttribute("data-variant-id"));
        let stock = variants.find((v) => v.id == variantID)?.stock || 0;
        if (stock >= parseInt(quantityInput.value) + 1) {
            let current = parseInt(quantityInput.value) || 1;
            quantityInput.value = current + 1;
        }
        else {
            toastr.error('Chỉ còn ' + stock + ' sản phẩm trong kho.');
        }
    }

    // Hàm giảm
    function decrease() {
        let current = parseInt(quantityInput.value) || 1;
        if (current > 1) {
            quantityInput.value = current - 1;
        }
    }

    // Bắt đầu giữ chuột để chạy liên tục
    function startHold(action) {
        action(); // thực hiện 1 lần khi nhấn
        timer = setTimeout(function run() {
            action();
            timer = setTimeout(run, 80); // tốc độ nhanh hơn
        }, 400); // delay khi bắt đầu giữ
    }

    // Dừng lại khi nhả chuột hoặc rời nút
    function stopHold() {
        clearInterval(timer);
    }
    increaseBtn.addEventListener("mousedown", () => startHold(increase));
    increaseBtn.addEventListener("mouseup", stopHold);
    increaseBtn.addEventListener("mouseleave", stopHold);
    decreaseBtn.addEventListener("mousedown", () => startHold(decrease));
    decreaseBtn.addEventListener("mouseup", stopHold);
    decreaseBtn.addEventListener("mouseleave", stopHold);

    // Favorite (Like) button AJAX handler
    (function () {
        var favBtn = document.getElementById("favorite-button");
        if (!favBtn) return;

        favBtn.addEventListener("click", function (e) {
            e.preventDefault();
            var pid = favBtn.getAttribute("data-product-id");
            if (!pid) return;

            var csrf =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || "";

            // Disable while processing
            favBtn.disabled = true;

            var favUrl =
                favBtn.getAttribute("data-fav-url") || "/user/favorites/toggle";
            var loginUrl =
                favBtn.getAttribute("data-login-url") || "/auth/login";
            fetch(favUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                    Accept: "application/json",
                },
                body: JSON.stringify({ product_id: pid }),
            })
                .then(function (res) {
                    if (res.status === 401) {
                        // Not authenticated - redirect to configured login route
                        window.location.href = loginUrl;
                        return;
                    }
                    return res.json().catch(function () {
                        return {};
                    });
                })
                .then(function (data) {
                    // expected { status: 'added'|'removed', count: n }
                    if (!data) return;
                    var icon = favBtn.querySelector("i");
                    if (icon) {
                        if (data.status === "added") {
                            icon.classList.remove("ri-heart-line");
                            icon.classList.add("ri-heart-fill", "text-red-500");
                        } else if (data.status === "removed") {
                            icon.classList.remove(
                                "ri-heart-fill",
                                "text-red-500"
                            );
                            icon.classList.add("ri-heart-line");
                        }
                    }
                })
                .catch(function (err) {
                    console.error("Favorite toggle error", err);
                })
                .finally(function () {
                    favBtn.disabled = false;
                });
        });
    })();
})();
