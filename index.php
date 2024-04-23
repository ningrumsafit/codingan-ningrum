<!DOCTYPE html>
<html lang="en">
<body id="page-top" style="background-color: pink;">



<head>
    <?php include "link.php"; ?>
</head>



    <div id="wrapper">

        <?php include "sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include "topbar.php"; ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-white-800">Gallery ku</h1>
                    </div>

                    <div class="row">
                        <?php
                        $stmt = $conn->prepare("SELECT f.*, u.Username FROM foto f JOIN user u ON f.UserID = u.UserID");
                        $stmt->execute();
                        $fotos = $stmt->get_result();
                        ?>
                        <?php foreach ($fotos as $data) : ?>
                            <div class="col-lg-5 col-md-5 mb-5">
                                <div class="card shadow mb-4">
                                    <img class="card-img-top" src="<?= htmlspecialchars($data['LokasiFile']); ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($data['JudulFoto']); ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($data['DeskripsiFoto']); ?></p>
                                        <p class="card-text"><small class="text-muted">Diunggah oleh <?= htmlspecialchars($data['Username']); ?> on <?= htmlspecialchars($data['TanggalUnggah']); ?></small></p>

                                        <?php
                                        $likeStmt = $conn->prepare("SELECT COUNT(*) AS likes FROM likefoto WHERE FotoID = ?");
                                        $likeStmt->bind_param("i", $data['FotoID']);
                                        $likeStmt->execute();
                                        $likeResult = $likeStmt->get_result()->fetch_assoc();
                                        ?>
                                        <button class="btn btn-dark like-btn" data-fotoid="<?= $data['FotoID']; ?>"><i class="fas fa-heart"></i></button>
                                        <br>
                                        <hr>
                                        <span id="like-count-<?= $data['FotoID']; ?>"><?= $likeResult['likes']; ?> Suka</span>

                                        <h6 class="mt-3">Komentar:</h6>
                                        <?php
                                        $komStmt = $conn->prepare("SELECT k.IsiKomentar, u.Username FROM komentarfoto k JOIN user u ON k.UserID = u.UserID WHERE k.FotoID = ?");
                                        $komStmt->bind_param("i", $data['FotoID']);
                                        $komStmt->execute();
                                        $komentar = $komStmt->get_result();
                                        ?>
                                        <ul class="list-unstyled">
                                            <?php foreach ($komentar as $kom) : ?>
                                                <li><strong><?= htmlspecialchars($kom['Username']); ?>:</strong> <?= htmlspecialchars($kom['IsiKomentar']); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <form action="post_comment.php" method="POST">
                                            <div class="form-group">
                                                <textarea name="komentar" class="form-control" placeholder="Tambahkan Komentar..."></textarea>
                                                <input type="hidden" name="fotoID" value="<?= $data['FotoID']; ?>">
                                            </div>
                                            <button type="submit" class="btn btn-dark">Kirim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>




            </div>

            <?php include "footer.php"; ?>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include "plugin.php"; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const fotoID = this.getAttribute('data-fotoid');
                    fetch('like_photo.php', {
                            method: 'POST',
                            body: JSON.stringify({
                                fotoID
                            }),
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const likeCount = document.getElementById(`like-count-${fotoID}`);
                                likeCount.textContent = `${data.likes} Likes`;
                            } else {
                                alert('Anda sudah menyukai foto ini!');
                            }
                        });
                });
            });
        });
    </script>
</body>

</html>