<?php
session_start();
if (isset($_POST['product_image'])) {
    $productImage = $_POST['product_image'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <link rel="icon" href="images/favicon.png" type="image/gif" />

    <title>GlamGirl | Virtual Fitting Room</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <!-- font awesome style -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />

    <style>
        .fit-preview {
            position: relative;
            margin: 20px auto;
            width: 400px;
            height: 400px;
            text-align: center;
        }

        #uploadedImage {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .virtual-fit-overlay {
            position: absolute;
            top: 10;
            left: 0;
            z-index: 2;
            cursor: grab;
            width: 100px; 
        }

        .action-buttons {
            margin: 20px 0;
            text-align: center;
        }

        .action-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #ed247c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-buttons button:hover {
            background-color: #d41b68;
        }
    </style>
</head>

<body>

<?php include 'navbar.php'; ?>

    <div class="background-image"></div>
    <h1 class="text-light text-center">Virtual Fitting Room</h1>

    <section>
        <div class="container">
            <!-- Upload Image Section -->
            <div class="text-center">
                <h2>Upload Your Image</h2>
                <input type="file" accept="image/*" id="userImage" onchange="uploadImage()" />
            </div>

            <!-- Selected Accessory Section -->
            <div class="text-center">
                <h2>Selected Accessory</h2>
                <img src="<?php echo $productImage; ?>" alt="Accessory" id="accessoryImage" style="width: 100px;">
            </div>

            <!-- Fitting Preview Section -->
            <div class="fit-preview">
                <h2>Fitting Preview</h2>
                <div id="uploadedImageContainer">
                    <img id="uploadedImage" src="" alt="Uploaded Image">
                    <img id="virtualAccessory" src="<?php echo $productImage; ?>" alt="Accessory" class="virtual-fit-overlay">
                </div>
            </div>

            <div class="action-buttons">
                <button onclick="increaseSize()">Increase Size</button>
                <button onclick="decreaseSize()">Decrease Size</button>
            </div>
        </div>
    </section>


    <?php include 'footer.php'; ?>

    <script>
    let isDragging = false;
    const uploadedImage = document.getElementById("uploadedImage");
    const virtualAccessory = document.getElementById("virtualAccessory");
    let currentWidth = 100;

    // Upload and display the user's image
    function uploadImage() {
        const file = document.getElementById("userImage").files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                uploadedImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    virtualAccessory.addEventListener("mousedown", (event) => {
        event.preventDefault();
        isDragging = true;

        const startX = event.clientX;
        const startY = event.clientY;

        const accessoryRect = virtualAccessory.getBoundingClientRect();
        const accessoryLeft = accessoryRect.left;
        const accessoryTop = accessoryRect.top;

        const offsetX = startX - accessoryLeft;
        const offsetY = startY - accessoryTop;

        function moveAccessory(event) {
            if (isDragging) {
                const newLeft = event.clientX - offsetX;
                const newTop = event.clientY - offsetY;

                virtualAccessory.style.left = `${newLeft}px`;
                virtualAccessory.style.top = `${newTop}px`;
            }
        }

        function stopMoving() {
            isDragging = false;
            document.removeEventListener("mousemove", moveAccessory);
            document.removeEventListener("mouseup", stopMoving);
        }

        document.addEventListener("mousemove", moveAccessory);
        document.addEventListener("mouseup", stopMoving);
    });

    function increaseSize() {
        currentWidth += 5;
        virtualAccessory.style.width = `${currentWidth}px`;
    }

    function decreaseSize() {
        currentWidth -= 5;
        if (currentWidth < 10) currentWidth = 10;
        virtualAccessory.style.width = `${currentWidth}px`;
    }
</script>
</body>

</html>