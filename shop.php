<?php
    include("header.php");
    
    // $query = "
    //     SELECT * FROM products
    //     ORDER BY id DESC
    // ";
    // $statement = $connection->prepare($query);
    // $statement->execute();

?>

    <!-- Banner -->
    <section class="shop-banner">
        <img src="./images/shop-banner.png" alt="Shop Banner"  class="banner-img">
    </section>

    <!-- Main Shop Section -->
    <section class="shop">
        <div class="shop-sidebar">
            <h4>Browse by</h4>
            <ul>
                <li class="active">All products</li>
                <li>Mens</li>
                <li>Womens</li>
            </ul>
        </div>

        <div class="shop-content">
            <div class="shop-header">
                <h2>All products</h2>
                <div class="sort-dropdown">
                <label for="sort">Sort by:</label>
                <select id="sort">
                    <option value="default">Default</option>
                    <option value="low">Price: Low to High</option>
                    <option value="high">Price: High to Low</option>
                </select>
                </div>
            </div>

            <div class="product-grid">
                <!-- Product Card -->
                <div class="product-card">
                    <span class="badge black">Best Seller</span>
                    <img src="./images/jacket1.png" alt="Light Blue Jacket" />
                    <h4>Light Blue Hooded Winter Jacket</h4>
                    <p>₹1299.00</p>
                    <button class="add-btn">Add to bag</button>
                </div>
                <div class="product-card">
                    <span class="badge black">Best Seller</span>
                    <img src="./images/jacket1.png" alt="Light Blue Jacket" />
                    <h4>Light Blue Hooded Winter Jacket</h4>
                    <p>₹1299.00</p>
                    <button class="add-btn">Add to bag</button>
                </div>
                <div class="product-card">
                    <span class="badge black">Best Seller</span>
                    <img src="./images/jacket1.png" alt="Light Blue Jacket" />
                    <h4>Light Blue Hooded Winter Jacket</h4>
                    <p>₹1299.00</p>
                    <button class="add-btn">Add to bag</button>
                </div>
                <div class="product-card">
                    <span class="badge black">Best Seller</span>
                    <img src="./images/jacket1.png" alt="Light Blue Jacket" />
                    <h4>Light Blue Hooded Winter Jacket</h4>
                    <p>₹1299.00</p>
                    <button class="add-btn">Add to bag</button>
                </div>
                <div class="product-card">
                    <span class="badge black">Best Seller</span>
                    <img src="./images/jacket1.png" alt="Light Blue Jacket" />
                    <h4>Light Blue Hooded Winter Jacket</h4>
                    <p>₹1299.00</p>
                    <button class="add-btn">Add to bag</button>
                </div>
                <div class="product-card">
                    <span class="badge black">Best Seller</span>
                    <img src="./images/jacket1.png" alt="Light Blue Jacket" />
                    <h4>Light Blue Hooded Winter Jacket</h4>
                    <p>₹1299.00</p>
                    <button class="add-btn">Add to bag</button>
                </div>

                <!-- Repeat more product-card divs -->
            </div>
        </div>
    </section>

    <!-- Subscribe -->
    <section class="subscribe">
        <h3>STAY UPDATED</h3>
        <p>Be the first to know about new arrivals, exclusive offers, and style tips.</p>
        <div class="subscribe-form">
            <input type="email" placeholder="Enter your email" />
            <button>Subscribe</button>
        </div>
    </section>

    <?php
        include("footer.php")
    ?>

    <script>
        // JavaScript to highlight active link
        const links = document.querySelectorAll('.nav-link');
        const currentPage = location.pathname.split('/').pop();

        links.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>