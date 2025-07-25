<?php
include("dataBase.php");

if (!isset($_GET['id'])) {
    echo "<p>Product not found.</p>";
    exit;
}

$productId = $_GET['id'];
$action = $_GET['action'];

// Fetch product info
$query = "
    SELECT p.name, p.description
    FROM products p
    WHERE p.id = :id
";
$stmt = $connection->prepare($query);
$stmt->execute([':id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch variants grouped by color
$query = "
    SELECT v.id AS variant_id, v.color, v.size, v.stocks, v.original_price, v.discounted_price, vi.image_url
    FROM product_variants v
    LEFT JOIN variant_images vi ON v.id = vi.variant_id
    WHERE v.product_id = :id
    ORDER BY v.color, v.size
";
$stmt = $connection->prepare($query);
$stmt->execute([':id' => $productId]);

$variants = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $color = $row['color'];
    $variants[$color]['images'][] = $row['image_url'];
    $variants[$color]['prices'][] = [
        'original' => $row['original_price'],
        'discounted' => $row['discounted_price']
    ];
    $variants[$color]['stocks'][] = $row['stocks'];
    $variants[$color]['sizes'][] = $row['size'];
}
$colors = array_keys($variants);
$defaultColor = $colors[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Product - Crabie Admin</title>
    <link href="asset/css/styles.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f7f7f7; }
        .admin-header { 
            background: #111; 
            color: white; 
            padding: 20px; 
            text-align: center; 
        }
        .admin-container { 
            padding: 40px 5%; 
        }
        .product-container {
            display: flex; 
            flex-wrap: wrap; 
            gap: 40px; 
        }
        .carousel-wrapper {
            flex: 1;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #carousel {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 8px;
        }
        .carousel-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: none;
            position: absolute;
            top: 0;
            left: 0;
        }
        .carousel-image.active {
            display: block;
        }
        .details-wrapper { 
            flex: 1; 
            max-width: 500px; 
            background: #fff; 
            padding: 20px; 
            border-radius: 8px; 
        }
        .color-button { 
            display: inline-block; 
            width: 32px; height: 32px; 
            border: 2px solid #ccc; 
            border-radius: 50%; 
            margin-right: 10px; 
            cursor: pointer; 
        }
        .color-button.active { 
            border-color: black; 
        }
        .size-box { 
            display: inline-block; 
            padding: 5px 10px; 
            border: 1px solid #999; 
            margin: 5px; 
            border-radius: 4px; 
        }
        .price-tag { 
            font-size: 20px; 
            margin: 10px 0; 
        }
        .original-price { 
            text-decoration: line-through; 
            color: red; 
            margin-right: 10px; 
        }
    </style>
</head>

<?php

    if($action === 'view'){

?>

        <div class="admin-header">
            <h1>View Product - Crabie Admin</h1>
        </div>

        <div class="admin-container">
            <div class="product-container">

                <!-- LEFT: Image Carousel -->
                <div class="carousel-wrapper">
                    <div id="carousel">
                        <?php foreach ($variants[$defaultColor]['images'] as $index => $img): ?>
                            <img src="<?= $img ?>" class="carousel-image <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" data-color="<?= $defaultColor ?>">
                        <?php endforeach; ?>
                    </div>
                    <div style="margin-top: 10px; text-align: center;">
                        <button id="prevBtn">Prev</button>
                        <button id="nextBtn">Next</button>
                    </div>
                </div>

                <!-- RIGHT: Product Info -->
                <div class="details-wrapper">
                    <h2><?= htmlspecialchars($product['name']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

                    <div class="price-tag">
                        <span class="original-price">₹<?= $variants[$defaultColor]['prices'][0]['original'] ?></span>
                        <strong>₹<?= $variants[$defaultColor]['prices'][0]['discounted'] ?></strong>
                    </div>

                    <p><strong>Stocks:</strong> <?= $variants[$defaultColor]['stocks'][0] ?></p>

                    <p><strong>Colors:</strong></p>
                    <?php foreach ($colors as $color): ?>
                        <div class="color-button" data-color="<?= $color ?>" style="background: <?= $color ?>;"></div>
                    <?php endforeach; ?>

                    <p><strong>Sizes:</strong></p>
                    <?php foreach (array_unique($variants[$defaultColor]['sizes']) as $size): ?>
                        <div class="size-box"><?= $size ?></div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

<?php
    }
    else if($action === 'edit'){
?>
    
        <div class="admin-header">
            <h1>View Product - Crabie Admin</h1>
        </div>

<?php
    }
?>


<script>
    let currentSlide = 0;
    const colorButtons = document.querySelectorAll('.color-button');
    const carousel = document.getElementById('carousel');

    const variantImages = <?= json_encode($variants) ?>;

    colorButtons.forEach(button => {
        button.addEventListener('click', () => {
            const selectedColor = button.dataset.color;

            // Remove active class from all
            document.querySelectorAll('.color-button').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Update images
            carousel.innerHTML = "";
            variantImages[selectedColor].images.forEach((img, index) => {
                const imgElem = document.createElement('img');
                imgElem.src = img;
                imgElem.className = index === 0 ? 'active' : '';
                imgElem.classList.add('carousel-image');
                imgElem.dataset.index = index;
                carousel.appendChild(imgElem);

            });

            // Update prices
            const priceDiv = document.querySelector(".price-tag");
            priceDiv.innerHTML = `
                <span class="original-price">₹${variantImages[selectedColor].prices[0].original}</span>
                <strong>₹${variantImages[selectedColor].prices[0].discounted}</strong>
            `;

            // Update stocks
            document.querySelector("p strong + strong")?.remove();
            const stockElem = document.querySelector("p strong").parentElement;
            stockElem.innerHTML = `<strong>Stocks:</strong> ${variantImages[selectedColor].stocks[0]}`;

            // Update sizes
            const sizes = [...new Set(variantImages[selectedColor].sizes)];
            const sizeWrapper = document.querySelectorAll(".size-box");
            sizeWrapper.forEach(el => el.remove());
            const detailWrapper = document.querySelector(".details-wrapper");
            const sizeParagraph = [...detailWrapper.querySelectorAll("p")].find(p => p.textContent.includes("Sizes"));
            sizes.forEach(size => {
                const sizeBox = document.createElement("div");
                sizeBox.className = "size-box";
                sizeBox.textContent = size;
                sizeParagraph.insertAdjacentElement("afterend", sizeBox);
            });
            reinitializeCarousel();
        });
    });

    // carousellet currentSlide = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-image');
        if (slides.length === 0) return;

        slides.forEach(slide => slide.classList.remove('active'));
        currentSlide = (index + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    document.getElementById('prevBtn').addEventListener('click', () => {
        showSlide(currentSlide - 1);
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        showSlide(currentSlide + 1);
    });

    // Reinitialize on color change
    function reinitializeCarousel() {
        currentSlide = 0;
        showSlide(currentSlide);
    }

</script>

</body>
</html>
