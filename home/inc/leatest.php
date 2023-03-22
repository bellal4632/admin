<div class="card mb-4">
    <div class="card-header">Leatest Post</div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <?php
            $c = "select * from articles where active='3' ORDER BY created_at desc LIMIT 5;";
            $cr = $conn->query($c);
            while ($row = $cr->fetch_assoc()) {
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-1 me-auto ">
                        <a class="link-dark" style="text-decoration: none; font-size: 15px; text-align: justify; display: flex; align-items: center;" href="details.php?id=<?= $row['id'] ?>">
                            <div class="fw-bold"> <small> <?php echo implode(' ', array_slice(explode(' ', $row['title']), 0, 10)); ?>...Read More </small></div>
                        </a>
                    </div>
                    
                </li>
            <?php } ?>
        </ul>
    </div>
</div>